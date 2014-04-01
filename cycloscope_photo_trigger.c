// ------- Preamble -------- //
#include <avr/io.h>
#include <util/delay.h>
#include <avr/interrupt.h>
#include "pinDefines.h"
#include <avr/sleep.h>

// ------- Global Variables ---------- //
volatile int x=0;
volatile uint8_t tot_overflow;

ISR(INT0_vect) {                                //Imposta la routine da eseguire quando si riceve una variazione solo pin INT0
 if (bit_is_set(BUTTON_PIN, BUTTON)) {
  LED_PORT |= (1 << LED1);
  x=x+1;
 } else {
  LED_PORT &= ~(1 << LED1);
 }
}

ISR(TIMER1_OVF_vect) {                         //Imposta il timer su overflow di TIMER1
    tot_overflow++;
    if (tot_overflow >= 10 && x>=10) {
      LED_PORT ^= (1 << 0);
      tot_overflow = 0;   
      x=0;
    }
}

void initInterrupt0(void) {                    //Imposta i registri per abilitare Interrupt sul pin INT0
 EIMSK |= (1 << INT0);
 EICRA |= (1 << ISC00);
 sei();
}

void timer1_init(void) {                       //Imposta i registri per abilitare Interrupt su Timer1
    TCCR1B |= (1 << CS11);
    TCNT1 = 0;
    TIMSK1 |=  (1<<TOIE1);
    sei();
    tot_overflow = 0;
}

int main(void) {
  LED_DDR = 0xff;                                   /* all LEDs active */
  BUTTON_PORT |= (1 << BUTTON);                              /* pullup */
  timer1_init();
  initInterrupt0();
  set_sleep_mode (SLEEP_MODE_PWR_DOWN);             /* Queste 3 istruzioni abilitano il modo in basso consumo della CPU */ 
  sleep_enable();
  sleep_cpu ();  
  while (1) {
  _delay_ms(100);
   if (x>=10) {
    LED_PORT |= (1 << LED0);
   }
  }                                                  
  return (0);                            /* This line is never reached */
}
