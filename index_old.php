<?php





Class Response{

var $page;
var $total;
var $records;
var $updatetime;
function Response() {
$this->rows=Array();
}


}
////

function convert_date($string){

$temps=explode(":", $string);
$heures=$temps[0];
$minutes=$temps[1];
$secondes=$temps[2];

$secondes+=($minutes*60)+($heures*60);

return $secondes*1000;

}
$lignes[5]="00:02:00";
$lignes[6]="00:03:00";
$lignes[7]="00:04:00";
$lignes[8]="00:05:00";
$radioControls=Array('9'=>'5', '12'=>'6', '14'=>'7', '17'=>'8');

$fileAsArray = Array();
$response=new Response();
if (($handle = fopen("HEA.csv", "r")) !== FALSE) {
while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
$fileAsArray[] = $data;
}
fclose($handle);
}
$raceTimes=Array();

$coureur=Array();
$cpt=0;
$bestSplitTime[9]="9999999999999";
$bestSplitTime[12]="9999999999999";
$bestSplitTime[14]="9999999999999";
$bestSplitTime[17]="9999999999999";
$bestRaceTime="";
foreach($fileAsArray as $ligne){
	
	if($cpt!=0){
	unset($coureur);
	$coureur[$cpt]['id']=$ligne[0];
	$coureur[$cpt]['name']=utf8_encode(strtoupper($ligne[3])." ".ucfirst($ligne[4]));
	$coureur[$cpt]['class']=$ligne[18];
	$class=$ligne[18];
	
	$coureur['club']=$ligne[14]; //ou $ligne[15]
	//On rajoute des postes 9 12 14 17
	
	
	
	
	$coureur[$cpt]['9']=convert_date('00:02:00');
	$coureur[$cpt]['12']=convert_date('00:03:00');
	$coureur[$cpt]['14']=convert_date('00:04:00');
	$coureur[$cpt]['17']=convert_date('00:05:00');
	
	
	foreach($radioControls as $radio_num=>$toto){
		
		if($coureur[$cpt][$radio_num]<$bestSplitTime[$radio_num]){
		$bestSplitTime[$radio_num]=(String)$coureur[$cpt][$radio_num];
		
		}
		
	
	}
	if(isset($ligne[8]) && ($ligne[8]!=0)){
	$coureur[$cpt]['startTime']=convert_date($ligne[8]);
	
	}else{
	$coureur[$cpt]['startTime']="10:00:00";
	}
	
	//On a le tps en heure minute seconde il le faut en millisecondes
	if(isset($ligne[11]) && ($ligne[11]!=0)){
	$coureur[$cpt]['raceTime']=convert_date($ligne[11]);
	
	}else{
	
	$coureur[$cpt]['raceTime']="";
	}
	$raceTimes[]=$coureur[$cpt]['raceTime'];

	$coureur[$cpt]['classification']=$ligne[12];
	$data[$cpt]['id']=$coureur['id'];
	$data[$cpt]['cell']=(object)$coureur;
	
	
	//$response->rows[$cpt]['cell']= (object)$data_cell;
	}
	$response->rows= (object)$data;
	$cpt++;

}
sort($raceTimes,SORT_NUMERIC);
$best[$class]=$raceTimes[0];

$bestST[$class]=$bestSplitTime;
$response->records="2";
$response->total=1;
$response->page=0;
$response->updatetime="13:10:59";
$response->bestRaceTime=(object)$best;
$response->bestSplitTime=(object)$bestST;

var_dump($response);
$handle=fopen("data.json", "w");
fwrite($handle,json_encode($response));
fclose($handle);
?>