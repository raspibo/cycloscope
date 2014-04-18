rm *.hex *.elf 
avr-gcc -mmcu=atmega328 -DF_CPU=1000000UL -DBAUD=9600 -Os -I. -funsigned-char -funsigned-bitfields -fpack-struct -fshort-enums  -Wall -Wstrict-prototypes -g -ggdb -ffunction-sections -fdata-sections -Wl,--gc-sections -Wl,--relax -std=gnu99 cycloscope_photo_trigger.c     --output cycloscope_photo_trigger.elf && avr-objcopy -R .eeprom -O ihex cycloscope_photo_trigger.elf cycloscope_photo_trigger.hex &&  avrdude -p m328p -c usbasp -U flash:w:cycloscope_photo_trigger.hex