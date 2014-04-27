/* 
Questo codice pre arduino serve per controllare se effettivamente il codice cycloscope_photo_trigger.c funziona
si collega il pin INT0 al sensore di hall sulla ruota e si controlla che dopo 238 giri inizi la sequenza di scatto
*/

int inPin = 7;

volatile int state = LOW;
volatile int contatore=0;
volatile int contatore_old=0;

void setup()
{
  Serial.begin(115200);
  pinMode(inPin, INPUT);
  attachInterrupt(0, blink, FALLING);
}

void loop()
{
if (contatore!=contatore_old) {
Serial.print (contatore);
Serial.print (" ");
Serial.println (digitalRead(inPin));
contatore_old=contatore;
}
}

void blink()
{
  contatore++;
  if (contatore==238) {
  contatore=0;
  };
}
