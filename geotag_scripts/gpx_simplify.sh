cd /var/www/html/cycloscope/gpx_work/
for track in *.gpx
do

#/usr/bin/gpsbabel -i gpx -f /var/www/html/cycloscope/gpx_work/$track -x simplify,crosstrack,error=0.1k -o gpx -F /var/www/html/cycloscope/gpx/${track}
/usr/bin/gpsbabel -i gpx -f /var/www/html/cycloscope/gpx_work/$track   -x transform,rte=trk -x nuketypes,waypoints,tracks -x simplify,count=50 -o gpx -F /var/www/html/cycloscope/gpx/${track}

done
