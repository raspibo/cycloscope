// ------- Preamble -------- //
#include <avr/io.h>
#include <util/delay.h>
#include <avr/interrupt.h>
#include "pinDefines.h"
#include <avr/sleep.h>

// ------- Global Variables ---------- //
volatile int x=0;
volatile uint8_t tot_overflow;

void initInterrupt0(void) {                    //Imposta i registri per abilitare Interrupt sul pin INT0
 EIMSK |= (1 << INT0);
 EICRA |= (1 << ISC00);
 sei();
}

ISR(INT0_vect) {                                //Imposta la routine da eseguire quando si riceve una variazione solo pin INT0
 if (bit_is_set(BUTTON_PIN, BUTTON)) {
  LED_PORT |= (1 << LED1);
  x=x+1;
 } else {
  LED_PORT &= ~(1 << LED1);
 }
 if (x>=10) {                                  //Impostare a 238 per i test su strada//
  LED_PORT |= (1 << LED0);
  _delay_ms(100);
  LED_PORT &= ~(1 << LED0);
  x=0;
 }
}

int main(void) {
  LED_DDR = 0xff;                              /* all LEDs active */
  BUTTON_PORT |= (1 << BUTTON);                /* pullup */
  initInterrupt0();
  set_sleep_mode (SLEEP_MODE_PWR_DOWN);        /* Queste 3 istruzioni abilitano il modo in basso consumo della CPU */ 
  sleep_enable();
  while (1) {
  sleep_cpu ();  
  }                                                  
  return (0);                                  /* This line is never reached */
}
