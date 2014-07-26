<html>
<meta charset="utf-8">

<body style="background: none repeat scroll 0 0 #FFD018; text-align:center;">
<form name=uno action=blog_save.php method=post>
<?php
$lang='it';
$file = 'geotagged/' . $_REQUEST["data"] . '/' . $lang . '.txt';
// Open the file to get existing content
$current = file_get_contents($file);
echo "<textarea  name=testo cols=80 rows=30 style='font-family: \'Trebuchet MS\' !important;'>";
echo $current;
echo "</textarea>";
file_put_contents($file, $current);
?>
<br>
<input type=hidden name=data value="<?=$_REQUEST["data"]?>">
<input type=submit value=salva>
</form>
</body>
</html>
