#!/bin/bash
if [ $#  -eq 1 ] 
then
folder=$1
offset=$2
rm -f /home/dancast78/photo_lab/*
cp -v /var/www/cycloscope/photo/GoPro/$folder/* /home/dancast78/photo_lab/
echo "Changing images description exif....please wait"
#exiftool  -ImageDescription="Cycloscope project - http://itcycloscope.weebly.com/" /home/dancast78/photo_lab/GOPR*.JPG
for nome_file in /home/dancast78/photo_lab/GOPR*.JPG
do
# Per evitare di mettere due volte il watermark controllo il campo description, se non è compilato significa che la foto non è ancora stata marcata
exiftool  -ImageDescription="Cycloscope project - http://itcycloscope.weebly.com/"  -if '$ImageDescription ne "Cycloscope project - http://itcycloscope.weebly.com/"' $nome_file && convert -filter Lanczos $nome_file -set option:filter:filter Lanczos -set option:filter:blur 0.8 /home/dancast78/images/watermark.png -gravity SouthEast -composite $nome_file 
done 

echo "Images description exif....ended"
#exiftool -v2 -geosync=+168518354 -geotag /var/www/cycloscope/photo/GoPro/2014-05-05_bologna_portomaggiore/MAG-05-14\ 221545.gpx /var/www/cycloscope/photo/GoPro/2014-05-05_bologna_portomaggiore/*896.JPG
echo "Geotagging photos"
#exiftool -v2 -geosync=+168496754 -geotag /home/dancast78/photo_lab/*.gpx /home/dancast78/photo_lab/GOPR.JPG
exiftool -v2 -geosync=-21600 -geotag /home/dancast78/photo_lab/*.gpx /home/dancast78/photo_lab/GOPR*.JPG 

for nome_file in /home/dancast78/photo_lab/GOPR*.JPG
do 
 if [ ! -f /var/www/cycloscope/geotagged/thumb/`basename $nome_file` ]
 then
  convert $nome_file -resize 10% /var/www/cycloscope/geotagged/thumb/`basename $nome_file`
 fi
done
cp /home/dancast78/photo_lab/GOPR*.JPG /var/www/cycloscope/geotagged/
cd /var/www/cycloscope
php5 /var/www/cycloscope/markers2csv.php 
else 
echo "Lanciami: $0 <cartella>"
ls -i /var/www/cycloscope/photo/GoPro/
fi
