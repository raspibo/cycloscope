#!/bin/bash
#crea una cartella per appoggiare le immagini
mkdir /home/cycloscope/photo_lab/thumb/
#per ogni file trovato in /home/cycloscope/photo_lab/ esegue la creazione di un'immagine ridimensionata al 10% dell'originale
for nome_file in /home/cycloscope/photo_lab/GOPR*.JPG
do 
 if [ ! -f /home/cycloscope/photo_lab/thumb/`basename $nome_file` ]
 then
  convert $nome_file -resize 10% /home/cycloscope/photo_lab/thumb/`basename $nome_file`
 fi
done

