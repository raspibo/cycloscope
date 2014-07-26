<html>
<body style="background: none repeat scroll 0 0 #FFD018; text-align:center;">
<div style="width: 500px;padding: 10px;border: 5px solid gray;margin: auto; ">
<?php
$pattern='/^2014[0-9][0-9][0-9][0-9]/';
$lang="it";
if (preg_match($pattern, $_REQUEST["data"])) {
 $myFile = "geotagged/" . $_REQUEST["data"] . "/" . $lang . ".txt" ;
echo "$myFile<br>";
 $fh = fopen($myFile, 'w') or die("can't open file");
 fwrite($fh, $_REQUEST["testo"]);
 fclose($fh);
 $file = 'geotagged/' . $_REQUEST["data"] . '/' . $lang . '.txt';
 // Open the file to get existing content
 $current = file_get_contents($file);
 echo $current;
}
?>
</div>
</body>
</html>
