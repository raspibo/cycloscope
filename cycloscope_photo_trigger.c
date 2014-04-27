/*
   GoPro sampling street code 
   Based on a description of: http://benlo.com/msp430/GoProController.html
   Reimplemented with Atmega328P 
   This code shoot a photo every SAMPLE_DIST meters
   The mcu go in sleep mode to reduce power consumption and wake up every .25 seconds with watchdog

   Compile and upload with: 
   rm *.hex *.elf ; make &&  avrdude -p m328p -c usbasp -U flash:w:cycloscope_photo_trigger.hex 
 */

#include <avr/io.h>
#include <util/delay.h>
#include <avr/interrupt.h>
#include "pinDefines.h"
#include <avr/sleep.h>
#include <avr/power.h>
#include <avr/wdt.h>

#define WHEEL_CIRC       67  //  Circonferenza della ruota in cm
#define SAMPLE_DIST      500 //  Distanza in metri tra due foto
#define SAMPLE_COUNT     237 //  Calcolato come SAMPLE_DIST/WHEEL_CIRC

#define GOPRO_WAKE_START 0    //   waiting for next cycle
#define GOPRO_WAKE_STOP  1    //   button down to start
#define GOPRO_SHUT_START 16   //   waiting for camera to take pic
#define GOPRO_SHUT_END   28   //   button down to stop

volatile int giri=0;
volatile uint8_t tot_overflow;

volatile int f_wdt=1;

volatile int time=0;
volatile int scatto_attivo=0;
//volatile int last_time=0;
volatile int x=0;

void initInterrupt0(void) {                    //Imposta i registri per abilitare Interrupt sul pin INT0
 EIMSK |= (1 << INT0);                         /* enable INT0 */
 EICRA |= (1 << ISC00);                        /* trigger when button changes */
 sei();                                        /* set (global) interrupt enable bit */
}

ISR(INT0_vect) {                                //Imposta la routine da eseguire quando si riceve una variazione solo pin INT0
  if (bit_is_set(BUTTON_PIN, BUTTON)) {
   PORTC |= (1 << 3);                            //Accensione del led verde port c pin 3 quando si verifica l'interrupt ed il pin è alto
   giri=giri+1;                                  //incrementa il contatore di giri della ruota
  } else {
   PORTC &= ~(1 << 3);                           //Spegne il  led verde port c pin 3 quando si verifica l'interrupt ed il pin è basso
  }
}

ISR(WDT_vect)
{
 sleep_disable();                              //Disable Sleep on Wakeup
 time++;                                       //Incrementa il contatore di tempo dopo il risveglio del watchdog
}

void enterSleep(void)
{
 set_sleep_mode(SLEEP_MODE_PWR_DOWN);   /* EDIT: could also use SLEEP_MODE_PWR_DOWN for lowest power consumption. */
 sleep_enable();
 sleep_mode();                          /* Now enter sleep mode. */
 /* The program will continue from here after the WDT timeout*/
 sleep_disable();                       /* First thing to do is disable sleep. */
 /* Re-enable the peripherals. */
 power_all_enable();
}


int main(void) {
 DDRB = 0x01;                                 /*setta come uscita solo il pin b0 a cui è collegato il led e ed il pin 12 di go pro*/
 LED_DDR = 0x01;                              /*setta alto il pin 12, collegato a led e vcc */
 DDRC = 0x08;                                 /*portc pin 3 out pin debug, collegato a led (varde) e poi a vcc*/
 PORTC &= ~(1 << 3);                          /*setta alto pin 3 port c, led spento*/
 DDRC = 0x08;                                 /*portc out pin debug*/
 //  LED_PORT ^= (1 << LED0); //toggle
 BUTTON_PORT |= (1 << BUTTON);                /*pullup sul pin INT0, collegato a sensore magnetico*/
 initInterrupt0();                            /*inizializza le variabili per abilitare interrutp su pin sensore magnetico*/
 MCUSR &= ~(1<<WDRF);                         /*Clear the reset flag. */
 WDTCSR |= (1<<WDCE) | (1<<WDE);              /*In order to change WDE or the prescaler, we need to set WDCE (This will allow updates for 4 clock cycles). */
 //WDTCSR = 1<<WDP0 | 1<<WDP3; /* 8.0 seconds */  /* set new watchdog timeout prescaler value */
 WDTCSR = 1<<WDP2;                            /*WDT interrupt every 250 milliseconds */
 WDTCSR |= _BV(WDIE);                         /*Enable the WD interrupt (note no reset). */

 LED_PORT |= (1 << LED0);                     //Spegne il led giallo nel caso fosse rimasto acceso

// giri=SAMPLE_COUNT - 10;                                      //Azzera il contatore di giri 
 giri=0;                                      //Azzera il contatore di giri 

 for (x=0;x<=3;x++) {
  PORTC &= ~(1 << 3);                           //Spegne il  led verde port c pin 3 quando si verifica l'interrupt ed il pin è basso
  _delay_ms(500);
  PORTC |= (1 << 3);
  _delay_ms(500);
 }
 while (1) {

  if (giri>=SAMPLE_COUNT && scatto_attivo==0) {                      //Raggiunta la quantità di giri per lo scatto. Impostare a 238 per i test su strada//
   LED_PORT &= ~(1 << LED0);                      //Accensione della telecamera e del led giallo (B0) il pin va a massa
   time=GOPRO_WAKE_START;                        //Azzera il conteggio di interrupt di watchdog per il calcolo del tempo
   wdt_reset();                                  //Azzera il watchdog per un calcolo preciso del tempo
   scatto_attivo=1;				//parte la sequenza di scatto
  giri=0;                                      //Azzera il contatore di giri
  }






 if (time==GOPRO_WAKE_STOP && scatto_attivo==1) {  //Se GOPRO_WAKE_STOP(=1) sono passati 250 msecondi la gopro è accesa
  LED_PORT |= (1 << LED0);                     //Spengo il led a vcc il pin B0 (spegne il led giallo), la go pro è accesa
 }
 if (time==GOPRO_SHUT_START && scatto_attivo==1) {//GOPRO_SHUT_START(32) raggiunti 32 conteggi di watchdog la foto è scattata
  LED_PORT &= ~(1 << LED0);                    //Spengo la go pro portando a massa il pin B0(il led giallo si accende)
 }

 if (time>=GOPRO_SHUT_END && scatto_attivo==1) {  //dopo 3 secondi finisce la sequenza di shutdown della go pro
  LED_PORT |= (1 << LED0);                     //Spengo il led a vcc il pin B0 (spegne il led giallo), la go pro è spenta
  time=GOPRO_WAKE_START;                       //Azzera il conteggio di interrupt di watchdog per il calcolo del tempo
  scatto_attivo=0;
 }
 sleep_enable();                               // Enable Sleep Mode

  enterSleep();
 }
 return (0);                                  /* This line is never reached */
}
