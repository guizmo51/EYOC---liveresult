<?php

//On inclus les horaires de depart

//$_GET['file']=$argv[1].".csv";



$categories=Array('HE');

//En 1er order et en 2nd le numero
$radioControls=Array('HE'=>
					Array('HE'=>
							Array('1'=>Array('39','46'), 
									'8'=>Array('44','50'), 
								  '999'=>Array('999', '54')
								  )
						
						)
					);


//46 50 54
//En 1er order et en 2nd le numero

// $splittimes=Array();
// foreach($radioControls as $tab){
// $splittimes[]=$tab[0];
// }
Class Runner{

var $id;
var $name;
var $cate;
var $club;
var $startTime;
var $raceTime;
var $classification;
function __construct($tab){
	
		foreach($tab as $elem){
		$this->{$elem[0]}='';
		
		}
	}

function Runner() {
$this->splitTimes=Array();
}


}


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
//echo "Temps : ".$string." - count = ".count($temps)."|";
if(count($temps)<3){
$heures=0;
$minutes=$temps[0];
$secondes=$temps[1];
}else{
$heures=$temps[0];
$minutes=$temps[1];
$secondes=$temps[2];
}
$secondes+=($minutes*60)+($heures*3600);

return $secondes*1000;

}

$file=$_GET['file'];
$parser=explode('.',$file);
$cate=$parser[0];
$fileAsArray = Array();
$response=new Response();
if (($handle = fopen($cate.".csv", "r")) !== FALSE) {
while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
$fileAsArray[] = $data;
var_dump($data);
}
fclose($handle);
}
$raceTimes=Array();

$coureur=Array();
$cpt=0;

foreach($radioControls[$cate][$cate]  as $tab){

$bestSplitTime[$tab[0]]="9999999999999";

}



$bestRaceTime="";


unset($fileAsArray[0]);
var_dump($fileAsArray);
foreach($fileAsArray as $ligne){
	
	$runner=new Runner($radioControls[$cate][$cate]);
	
	unset($coureur);
	$runner->id=$ligne[0];
	$runner->name=$ligne[0]." ".utf8_encode(strtoupper($ligne[3])." ".ucfirst($ligne[4]));
	$runner->cate=$ligne[18];
	$class=$ligne[18];
	
	$runner->club=$ligne[15]; //ou $ligne[15]
	//On rajoute des postes 9 12 14 17
	
	
	foreach($radioControls[$cate][$cate] as $tab){
	echo "tot";
	var_dump($tab);
	$coureur[$cpt][$tab[0]]=@convert_date($ligne[$tab[1]]);
	$runner->{$tab[0]}=@convert_date($ligne[$tab[1]]);
	//$runner->splitTimes[$tab[0]]=@convert_date($tab[1]);
	}

	
	
	$runner->splitTimes=$coureur[$cpt];
	foreach($radioControls[$cate][$cate] as $tab){
		
		
		if(($coureur[$cpt][$tab[0]]<$bestSplitTime[$tab[0]]) &&($coureur[$cpt][$tab[0]]!=0)){
		$bestSplitTime[$tab[0]]=(String)$coureur[$cpt][$tab[0]];
		
		}
		
	
	}
	if(isset($ligne[8]) && ($ligne[8]!=0)){
	//$coureur[$cpt]['startTime']=convert_date($ligne[8]);
	$runner->startTime=convert_date($ligne[9]);
	}else{
	//$coureur[$cpt]['startTime']="10:00:00";
	$runner->startTime=convert_date("10:00:00");
	}
	
	//On a le tps en heure minute seconde il le faut en millisecondes
	if(isset($ligne[11]) && ($ligne[11]!=0)){
	$runner->raceTime=@convert_date($ligne[11]);
	
	}else{
	
	$runner->raceTime="";
	}
	$raceTimes[]=$runner->raceTime;

	$runner->classification=$ligne[12];
	$data['id']=$runner->id;
	$data['cell']=$runner;
	
	
	//$response->rows[$cpt]['cell']= (object)$data_cell;
	
	$response->rows[$cpt]=(object)$data;
	//$response->rows[$cpt]['cell']=$runner;
	$cpt++;

}
sort($raceTimes,SORT_NUMERIC);
$best[$class]=$raceTimes[0];

$bestST[$class]=$bestSplitTime;
$response->records="2";
$response->total=1;
$response->page=0;
$response->updatetime=date("H:i:s");
$response->bestRaceTime=(object)$best;
$response->bestSplitTime=(object)$bestST;


$handle=fopen($cate.".json", "w");
fwrite($handle,json_encode($response));

echo json_encode($response);
fclose($handle);
?>