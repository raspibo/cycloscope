/*
GoPro sampling street code 
Based on a description of: http://benlo.com/msp430/GoProController.html
Reimplemented with Atmega328P 
This code shoot a photo every SAMPLE_DIST meters
The mcu go in sleep mode to reduce power consumption and wake up every .25 seconds with watchdog

Compile and upload with: 
rm *.hex *.elf ; avr-gcc -mmcu=atmega328 -DF_CPU=1000000UL -DBAUD=9600 -Os -I. -funsigned-char -funsigned-bitfields -fpack-struct -fshort-enums  -Wall -Wstrict-prototypes -g -ggdb -ffunction-sections -fdata-sections -Wl,--gc-sections -Wl,--relax -std=gnu99 cycloscope_photo_trigger.c     --output cycloscope_photo_trigger.elf && avr-objcopy -R .eeprom -O ihex cycloscope_photo_trigger.elf cycloscope_photo_trigger.hex &&  avrdude -p m328p -c usbasp -U flash:w:cycloscope_photo_trigger.hex 
rm *.hex *.elf ; make &&  avrdude -p m328p -c usbasp -U flash:w:cycloscope_photo_trigger.hex 
*/

#include <avr/io.h>
#include <util/delay.h>
#include <avr/interrupt.h>
#include <avr/sleep.h>
#include <avr/power.h>
#include <avr/wdt.h>

#define WHEEL_CIRC       67  //  Circonferenza della ruota in cm
#define SAMPLE_DIST      500 //  Distanza in metri tra due foto
#define SAMPLE_COUNT     238 //  Calcolato come SAMPLE_DIST/WHEEL_CIRC

#define GOPRO_WAKE_START 0    //   waiting for next cycle
#define GOPRO_WAKE_STOP  1    //   button down to start
#define GOPRO_SHUT_START 32   //   waiting for camera to take pic
#define GOPRO_SHUT_END   56   //   button down to stop

volatile int x=0;
volatile uint8_t tot_overflow;

volatile int f_wdt=1;

static int time;

void initInterrupt0(void) {                    //Imposta i registri per abilitare Interrupt sul pin INT0
 EIMSK |= (1 << INT0);
 EICRA |= (1 << ISC00);
 sei();
}

ISR(INT0_vect) {                                //Imposta la routine da eseguire quando si riceve una variazione solo pin INT0
 if (bit_is_set(PIND, PD2)) {
  //PORTB |= (1 << LED1);
  PORTC |= (1 << 3);
  x=x+1;
 } else {
//  PORTB &= ~(1 << LED1);
  PORTC &= ~(1 << 3);
 }
 if (x>=SAMPLE_COUNT) {                                  //Impostare a 238 per i test su strada//
 PORTB &= ~(1 << PB0);
  time=GOPRO_WAKE_START;
  wdt_reset();
 }
}

ISR(WDT_vect)
{
  sleep_disable();          // Disable Sleep on Wakeup
  time++;
 if (time==GOPRO_WAKE_STOP && x>=SAMPLE_COUNT) {
   PORTB |= (1 << PB0); 
  }
  if (time==GOPRO_SHUT_START && x>=SAMPLE_COUNT) {
   PORTB &= ~(1 << PB0);
  }
  if (time>=GOPRO_SHUT_END && x>=SAMPLE_COUNT) {
   PORTB |= (1 << PB0);
   time=GOPRO_WAKE_START;
   x=0;
  }
  sleep_enable();           // Enable Sleep Mode
}

void enterSleep(void)
{
 set_sleep_mode(SLEEP_MODE_PWR_DOWN);   /* EDIT: could also use SLEEP_MODE_PWR_DOWN for lowest power consumption. */
 sleep_enable();
 sleep_mode();                          /* Now enter sleep mode. */
 /* The program will continue from here after the WDT timeout*/
 sleep_disable(); /* First thing to do is disable sleep. */
 /* Re-enable the peripherals. */
 power_all_enable();
}


int main(void) {
 DDRB = 0x01;                                 /*portb out led pin 12 go pro*/
 DDRB = 0x01;                              /*pin 12 high */
 DDRC = 0x08;                                 /*portc out pin debug*/
 PORTC &= ~(1 << 3);
 DDRC = 0x08;                                 /*portc out pin debug*/
 //  PORTB ^= (1 << PB0); //toggle
 PORTD |= (1 << PD2);                /* pullup */
 initInterrupt0();
 /* Clear the reset flag. */
 MCUSR &= ~(1<<WDRF);
 /* In order to change WDE or the prescaler, we need to set WDCE (This will allow updates for 4 clock cycles). */
 WDTCSR |= (1<<WDCE) | (1<<WDE);
 //WDTCSR = 1<<WDP0 | 1<<WDP3; /* 8.0 seconds */  /* set new watchdog timeout prescaler value */
 WDTCSR = 1<<WDP2; /* 250 milliseconds */
 WDTCSR |= _BV(WDIE);  /* Enable the WD interrupt (note no reset). */

 PORTB |= (1 << PB0); //Spegne il led

 while (1) {
   enterSleep();
 }
 return (0);                                  /* This line is never reached */
}
