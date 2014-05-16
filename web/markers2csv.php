<?

function getDirectoryTree( $outerDir , $x){
    $dirs = array_diff( scandir( $outerDir ), Array( ".", ".." ) );
    $dir_array = Array();
    foreach( $dirs as $d ){
//        if( is_dir($outerDir."/".$d)  ){
//            $dir_array[ $d ] = getDirectoryTree( $outerDir."/".$d , $x);
//        }else{
         if (($x)?ereg($x.'$',$d):1)
            $dir_array[ $d ] = $d;
//            }
    }
    return $dir_array;
} 

?>



<?
date_default_timezone_set('UTC');
$fp = fopen('/var/www/cycloscope/markers.csv', 'w');
fwrite($fp,"photo,title,city,state,country,latitude,longitude\n");
$files=getDirectoryTree('geotagged','0.JPG'); 
foreach ($files as  $x) {
 $photo=sprintf ("geotagged/%s",$x);
 $exif = exif_read_data($photo, 0, true);
//print_r($exif);
 $Latitude =$exif['GPS']['GPSLatitude'];
 $Longitude=$exif['GPS']['GPSLongitude'];
 $data=$exif['EXIF']['DateTimeOriginal'];
 $data_sync=date("Y:m:d H:i:s",$exif['FILE']['FileDateTime']);
 $lat_degrees = explode("/",$Latitude[0]); 
 $lat_minutes = explode("/",$Latitude[1]);
 $lat_seconds = explode("/",$Latitude[2]);
 $lat_coord = round(($lat_degrees[0]) + (($lat_minutes[0] * 60)+($lat_seconds[0]/$lat_seconds[1]))/3600,4);

 $lon_degrees = explode("/",$Longitude[0]); 
 $lon_minutes = explode("/",$Longitude[1]);
 $lon_seconds = explode("/",$Longitude[2]);
 $lon_coord = round(($lon_degrees[0]) + (($lon_minutes[0] * 60)+($lon_seconds[0]/$lon_seconds[1]))/3600,4);
if ($lon_coord!=0) {
 fwrite($fp, $photo . ",2,<a href=$photo target=_blank><img src =geotagged/thumb/" . basename($photo) ." width=200></a><br>" . $lat_coord . "-" . $lon_coord . ",Cycloscope Project,5," . $lat_coord . "," . $lon_coord . "\n");
 echo "$photo\n";
}
}
fclose($fp);
?>

