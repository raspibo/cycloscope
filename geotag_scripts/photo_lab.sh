#!/bin/bash
if [ $#  -eq 1 ]
then
data=$1
offset=$2
rm -f /home/cycloscope/photo_lab/*
cp -v /var/www/html/cycloscope/photo/GoPro/$data*/*.JPG /home/cycloscope/photo_lab/
echo "Changing images description exif....please wait"
#exiftool  -ImageDescription="Cycloscope project - http://itcycloscope.weebly.com/" /home/cycloscope/photo_lab/GOPR*.JPG
for nome_file in /home/cycloscope/photo_lab/GOPR*.JPG
do
# Per evitare di mettere due volte il watermark controllo il campo description, se non Ã¨ compilato significa che la foto non Ã¨ ancora stata marcata
 exiftool  -ImageDescription="Cycloscope project - http://itcycloscope.weebly.com/"  -if '$ImageDescription ne "Cycloscope project - http://itcycloscope.weebly.com/"' $nome_file && convert -filter Lanczos $nome_file -set option:filter:filter Lanczos -set option:filter:blur 0.8 /home/cycloscope/photo_script/images/watermark.png -gravity SouthEast -composite $nome_file
done
echo "Images description exif....ended"
#exiftool -v2 -geosync=+168518354 -geotag /var/www/cycloscope/photo/GoPro/2014-05-05_bologna_portomaggiore/MAG-05-14\ 221545.gpx /var/www/cycloscope/photo/GoPro/2014-05-05_bologna_portomaggiore/*896.JPG
echo "Geotagging photos"
#exiftool -v2 -geosync=+168496754 -geotag /home/cycloscope/photo_lab/*.gpx /home/cycloscope/photo_lab/GOPR.JPG
#exiftool -v2 -geosync=-21600 -geotag /home/cycloscope/photo_lab/*.gpx /home/cycloscope/photo_lab/GOPR*.JPG
#exiftool -v2 -geosync=-25200 -geotag /var/www/html/cycloscope/gpx/`echo "$data"|sed -e s/-//g`.gpx /home/cycloscope/photo_lab/GOPR*.JPG
exiftool -v2 -geosync=-18000 -geotag /var/www/html/cycloscope/gpx/`echo "$data"|sed -e s/-//g`.gpx /home/cycloscope/photo_lab/GOPR*.JPG

for nome_file in /home/cycloscope/photo_lab/GOPR*.JPG
do
 if [ ! -f /var/www/cycloscope/geotagged/`echo "$data"|sed -e s/-//g`/thumb/`basename $nome_file` ]
 then
 echo "Reverse Geotagging photo"
 coord_string=`exiftool -gpsposition -n $nome_file | awk '{print "lat="$4"&lon="$5}'`
#Install  json with sudo npm install -g json
# rev_geo=`curl -s "http://nominatim.openstreetmap.org/reverse?%20$coord_string&format=json&addressdetails=1&email=castellariatalice.it&accept-language=en-gb"| json address|json -a -d ", " suburb city town village county country country_code | sed -e "s/, , , /, /g"| sed -e "s/, , /, /g"| sed -e "s/^, //g"`
 rev_geo=`curl -s "http://nominatim.openstreetmap.org/reverse?$coord_string&format=xml&addressdetails=1&email=castellariatalice.it&accept-language=en-gb"| grep  -Po "(?<=>)(.*)(?=</result>)"|awk -F"," '{print $4","$5","$7}'| sed -e 's/[,$]//g' `
 echo "$rev_geo"
 exiftool  -ImageDescription="Cycloscope project - http://itcycloscope.weebly.com/ - $rev_geo" $nome_file
 echo "Creating thumb"
  mkdir -p /var/www/html/cycloscope/geotagged/`echo $data|sed -e s/-//g`/thumb
  mkdir -p /var/www/html/cycloscope/geotagged/`echo $data|sed -e s/-//g`/large
  convert $nome_file -resize 10% /var/www/html/cycloscope/geotagged/`echo $data|sed -e s/-//g`/thumb/`basename $nome_file`
  convert $nome_file -resize 40% /var/www/html/cycloscope/geotagged/`echo $data|sed -e s/-//g`/large/`basename $nome_file`
 fi
done
convert /home/cycloscope/photo_lab/thumb/GOPR*0.JPG +append /home/cycloscope/photo_lab/filmstrip.jpg
cp /home/cycloscope/photo_lab/GOPR*.JPG /var/www/html/cycloscope/geotagged/`echo $data|sed -e s/-//g`/
cp /home/cycloscope/photo_lab/filmstrip.jpg /var/www/html/cycloscope/geotagged/`echo $data|sed -e s/-//g`/
if [ ! -f /var/www/html/cycloscope/geotagged/`echo $data|sed -e s/-//g`/it.txt ] 
then 
 echo -e "Diario del $data \n In arrivo!"> /var/www/html/cycloscope/geotagged/`echo $data|sed -e s/-//g`/it.txt
fi
cd /var/www/html/cycloscope
php5 /var/www/html/cycloscope/markers2csv.php
else
echo "Lanciami: $0 <AAAA-MM-GG>"
ls -i /var/www/html/cycloscope/photo/GoPro/
fi
