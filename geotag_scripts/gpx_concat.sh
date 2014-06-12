#!/bin/bash
#find /var/www/cycloscope/photo/GoPro/ -name "*.gpx" -print0 | while read -d $'\0' track
rm /home/dancast78/gpx_lab/*.gpx
find /var/www/cycloscope/photo/GoPro/ -type f -name '*.gpx' -exec cp {} /home/dancast78/gpx_lab/ \;
/usr/bin/rename s/\ //g /home/dancast78/gpx_lab/*.gpx
for track in /home/dancast78/gpx_lab/*.gpx
do
track_list="$track_list -f $track "
done
echo $track_list
/usr/bin/gpsbabel -i gpx $track_list -x simplify,count=200 -o gpx -F /var/www/cycloscope/cycloscope.gpx
