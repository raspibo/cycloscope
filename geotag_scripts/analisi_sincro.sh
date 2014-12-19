#!/bin/bash
data_long=$1
data_short=`echo $data_long | sed -e "s/-//g"`
exiftool -v2 -geotag /var/www/html/cyclodev/gpx/${data_short}.gpx /home/cycloscope/photo_script/images/watermark.png | grep GPS
exiftool -CreateDate /var/www/html/cycloscope/photo/GoPro/${data_long}*/*.JPG| head -3
exiftool -CreateDate /var/www/html/cycloscope/photo/GoPro/${data_long}*/*.JPG| tail -2

