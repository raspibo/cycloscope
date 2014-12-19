#!/bin/bash
#find /var/www/cycloscope/photo/GoPro/ -name "*.gpx" -print0 | while read -d $'\0' track
#rm /home/dancast78/gpx_lab/*.gpx
data=$1 #AAAAMMGG
find /var/www/html/cycloscope/photo/GoPro/Archive -type f -name '*.gpx' -exec cp {} /var/www/html/cycloscope/photo/GoPro/Archive/ \;
/usr/bin/rename s/\ //g /var/www/html/cycloscope/photo/GoPro/Archive/*.gpx
for track in /var/www/html/cycloscope/photo/GoPro/Archive/*.gpx
do
track_list="$track_list -f $track "
done
echo $track_list
/usr/bin/gpsbabel -i gpx $track_list -x simplify,count=200 -o gpx -F /var/www/html/cycloscope/photo/GoPro/Archive/traccia_tot.gpx
#data="20140804"
gpsbabel -t -i gpx -f  /var/www/html/cycloscope/photo/GoPro/Archive/traccia_tot.gpx  -x track,start=${data}00,stop=${data}23 -o gpx -F /var/www/html/cycloscope/gpx/${data}.gpx 
