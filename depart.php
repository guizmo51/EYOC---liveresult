<?php 
if (($handle = fopen("departs.csv", "r")) !== FALSE) {
while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
$fileAsArray[] = $data;
}
fclose($handle);
}


unset($fileAsArray[0]);
$tampon='<?php 
';
foreach($fileAsArray as $ligne){
	
	$tampon.='$starttime['.$ligne[0].']="'.$ligne[10].'";
	';
	
	
	
	
	
	}
$tampon.=" ?>";


$hdle=fopen("starttime.php" , "w+");
fwrite($hdle, $tampon);
fclose($hdle);
 
?>