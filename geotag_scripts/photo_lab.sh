#!/bin/bash

#Questo script si occupa di diverse operazioni sulle foto cel progetto cycloscope

if [ $#  -eq 1 ] # E obbligatorio il parametro data nel formato AAAAMMGG
then
data=$1
offset=$2
#Pulizia iniziale cartella di appoggio
rm -f /home/cycloscope/photo_lab/* 
#Elaborazione del file gpx nella cartella /var/www/html/cycloscope/photo/GoPro/$data*/ e filtraggio della sola data passata come parametro allo script
#usato perchè le tracce possono essere memorizzate anche su più giorni e quindi trovarsi nella cartella realitiva ad un altro giorno
gpsbabel -t -i gpx -f /var/www/html/cycloscope/photo/GoPro/$data*/*.gpx -x track,start=`echo $data|sed -e s/-//g`00,stop=`echo $data|sed -e s/-//g`23 -o gpx -F /var/www/html/cycloscope/gpx/`echo $data|sed -e s/-//g`.gpx 
#Copia dei file JPG dalle cartelle di upload all'area di elaborazione
cp -v /var/www/html/cycloscope/photo/GoPro/$data*/*.JPG /home/cycloscope/photo_lab/

#echo "Changing images description exif....please wait"
#for nome_file in /home/cycloscope/photo_lab/GOPR*.JPG
#do
#Di seguito il cambio del campo exif description nei metadata dell'immagine
# Per evitare di mettere due volte il watermark controllo il campo description, se non Ã¨ compilato significa che la foto non Ã¨ ancora stata marcata
#Viene inserito anche il watermark  nelle foto caricando il file /home/cycloscope/photo_script/images/watermark.png
# exiftool  -ImageDescription="Cycloscope project - http://itcycloscope.weebly.com/"  -if '$ImageDescription ne "Cycloscope project - http://itcycloscope.weebly.com/"' $nome_file && convert -filter Lanczos $nome_file -set option:filter:filter Lanczos -set option:filter:blur 0.8 /home/cycloscope/photo_script/images/watermark.png -gravity SouthEast -composite $nome_file
#date> /dev/null
#done
#echo "Images description exif....ended"

#exiftool -v2 -geosync=+168518354 -geotag /var/www/cycloscope/photo/GoPro/2014-05-05_bologna_portomaggiore/MAG-05-14\ 221545.gpx /var/www/cycloscope/photo/GoPro/2014-05-05_bologna_portomaggiore/*896.JPG
echo "Geotagging photos"
#exiftool -v2 -geosync=+168496754 -geotag /home/cycloscope/photo_lab/*.gpx /home/cycloscope/photo_lab/GOPR.JPG
#exiftool -v2 -geosync=-21600 -geotag /home/cycloscope/photo_lab/*.gpx /home/cycloscope/photo_lab/GOPR*.JPG
#exiftool -v2 -geosync=-25200 -geotag /var/www/html/cycloscope/gpx/`echo "$data"|sed -e s/-//g`.gpx /home/cycloscope/photo_lab/GOPR*.JPG
#exiftool -v2 -geosync=-18000 -geotag /var/www/html/cycloscope/gpx/`echo "$data"|sed -e s/-//g`.gpx /home/cycloscope/photo_lab/GOPR*.JPG
#exiftool -v2 -geosync=-14854 -geotag /var/www/html/cycloscope/gpx/`echo "$data"|sed -e s/-//g`.gpx /home/cycloscope/photo_lab/GOPR*.JPG
case "$data" in
	2014-08-21)
		exiftool -v2 -geosync="-63191547" -geotag /var/www/html/cycloscope/gpx/20140821.gpx /home/cycloscope/photo_lab/GOPR*.JPG
	;;
	2014-08-22)
		exiftool -v2 -geosync="-63191547" -geotag /var/www/html/cycloscope/gpx/20140822.gpx /home/cycloscope/photo_lab/GOPR*.JPG
	;;
	2014-08-23)
		exiftool -v2 -geosync="-63180600" -geotag /var/www/html/cycloscope/gpx/20140823.gpx /home/cycloscope/photo_lab/GOPR*.JPG
	;;
	2014-08-24)
		exiftool -v2 -geosync="-63180600" -geotag /var/www/html/cycloscope/gpx/20140824.gpx /home/cycloscope/photo_lab/GOPR*.JPG
	;;
	2014-08-26)
		exiftool -v2 -geosync="-63170600" -geotag /var/www/html/cycloscope/gpx/20140826.gpx /home/cycloscope/photo_lab/GOPR*.JPG
	;;
	*)
		exiftool -v2 -geosync="-04:00:00" -geotag /var/www/html/cycloscope/gpx/`echo "$data"|sed -e s/-//g`.gpx /home/cycloscope/photo_lab/GOPR*.JPG
esac
#exiftool -v2 -geosync="-03:30:00" -geotag /var/www/html/cycloscope/gpx/`echo "$data"|sed -e s/-//g`.gpx /home/cycloscope/photo_lab/GOPR*.JPG
#exiftool -v2 -geotag /var/www/html/cycloscope/gpx/`echo "$data"|sed -e s/-//g`.gpx /home/cycloscope/photo_lab/GOPR*.JPG
echo "Dopo aver analizzato se il geotagging è andato bene premi invio per continuare o CTRL+C per uscire"
read attendi
for nome_file in /home/cycloscope/photo_lab/GOPR*.JPG
do
 if [ ! -f /var/www/cycloscope/geotagged/`echo "$data"|sed -e s/-//g`/thumb/`basename $nome_file` ]
 then
coord_string=`exiftool -gpsposition -n $nome_file | awk '{print $4" "$5}'`
#Install  json with sudo npm install -g json
# rev_geo=`curl -s "http://nominatim.openstreetmap.org/reverse?%20$coord_string&format=json&addressdetails=1&email=castellariatalice.it&accept-language=en-gb"| json address|json -a -d ", " suburb city town village county country country_code | sed -e "s/, , , /, /g"| sed -e "s/, , /, /g"| sed -e "s/^, //g"`
### set -x
### rev_geo=`curl -s "http://nominatim.openstreetmap.org/reverse?$coord_string&format=xml&addressdetails=1&email=castellariatalice.it&accept-language=en-gb"| grep  -Po "(?<=>)(.*)(?=</result>)"|awk -F"," '{print $4","$5","$7}'| sed -e 's/[,$]//g' `
### echo "$rev_geo"
### set +x	
### exiftool  -ImageDescription="Cycloscope project - http://itcycloscope.weebly.com/ - $rev_geo" $nome_file
set -x 
if [ ${#coord_string} -gt 1 ]
then
echo "Reverse Geotagging photo"
rev_geo=`/home/cycloscope/photo_script/rev_geocoding.py $coord_string`
 if [ ${#rev_geo} -gt 1 ]
 then
  exiftool  -ImageDescription="Cycloscope project - http://itcycloscope.weebly.com/ - $rev_geo" $nome_file
  last_good_rev_geo=$rev_geo
 else 
  if [ ${#last_good_rev_geo} -gt 1 ] 
  then
   exiftool  -ImageDescription="Cycloscope project - http://itcycloscope.weebly.com/ - $rev_geo" $nome_file
  else
   exiftool  -ImageDescription="Cycloscope project - http://itcycloscope.weebly.com/" $nome_file
  fi
 fi
fi
set +x
 echo "Creating thumb"
  mkdir -p /var/www/html/cycloscope/geotagged/`echo $data|sed -e s/-//g`/thumb

  mkdir -p /var/www/html/cycloscope/geotagged/`echo $data|sed -e s/-//g`/large
  convert $nome_file -resize 10% /var/www/html/cycloscope/geotagged/`echo $data|sed -e s/-//g`/thumb/`basename $nome_file`
  convert $nome_file -resize 40% /var/www/html/cycloscope/geotagged/`echo $data|sed -e s/-//g`/large/`basename $nome_file`
 fi
done
convert /var/www/html/cycloscope/geotagged/`echo $data|sed -e s/-//g`/thumb/GOPR*0.JPG +append /var/www/html/cycloscope/geotagged/`echo $data|sed -e s/-//g`/filmstrip.jpg
cp /home/cycloscope/photo_lab/GOPR*.JPG /var/www/html/cycloscope/geotagged/`echo $data|sed -e s/-//g`/
if [ ! -f /var/www/html/cycloscope/geotagged/`echo $data|sed -e s/-//g`/it.txt ] 
then 
 echo -e "Diario del $data \n In arrivo!"> /var/www/html/cycloscope/geotagged/`echo $data|sed -e s/-//g`/it.txt
fi
cd /var/www/html/cycloscope
#php5 /var/www/html/cycloscope/markers2csv.php
#grep bound gpx/*|awk -F"\"" '{print "{ geometry: { type: \"Point\", coordinates: ["($4+$8)/2","($2+$6)/2"] },  properties: { id: \""substr($1,5,8)"\", zoom: 10 }, type: 'Feature' },"}' | sed s/Feature/\'Feature\'/g
exiftool -n -filename -gpslatitude -gpslongitude -csv -T /var/www/html/cycloscope/geotagged/*/*.JPG > /var/www/html/cyclodev/geotagged_photo_db.csv
echo "Now check http://lela.ismito.it/cyclodev/?data_dbg=`echo $data|sed -e s/-//g`"
else
echo "Lanciami: $0 <AAAA-MM-GG>"
ls -i /var/www/html/cycloscope/photo/GoPro/
fi
chown -R cycloscope:cycloscope /var/www/html/cycloscope/geotagged/
chmod -R 755 /var/www/html/cycloscope/geotagged/
