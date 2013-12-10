<?php

//On inclus les horaires de depart

$_GET['file']="H18-1.csv";

$categories=Array('H18');

//En 1er order et en 2nd le numero
$radioControls=Array('H18'=>
					Array('H18-1'=>
							Array('8'=>Array('39','25'), 
									'9'=>Array('44','29'), 
									'10'=>Array('77','33'), 
								  '999'=>Array('999', '37')
								  ),
						  'H18-2'=>
							Array('8'=>Array('39','25'), 
									'9'=>Array('44','29'), 
									'10'=>Array('77','33'), 
								  '999'=>Array('999', '37')
								  )
						)
					);

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
echo "Temps : ".$string." - count = ".count($temps)."|";
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

/*foreach($categories as $categ){
foreach($radioControls[$categ] as $cate=>$file){*/
$file=$_GET['file'];
$parser=explode('.',$file);
$cate=$parser[0];
$parse_cate=explode('-',$cate);

$fileAsArray = Array();
$response=new Response();
if (($handle = fopen($cate.".csv", "r")) !== FALSE) {
while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
$fileAsArray[] = $data;
}
fclose($handle);
}
$raceTimes=Array();

$coureur=Array();
$cpt=0;

foreach($radioControls[$parse_cate[0]][$cate] as $ctrl){
	
	$bestSplitTime[$ctrl[0]]="999999999999999";
}
var_dump($bestSplitTime);
$bestRaceTime="";


unset($fileAsArray[0]);

foreach($fileAsArray as $ligne){
	
	$runner=new Runner($radioControls[$parse_cate[0]][$cate]);
	
	unset($coureur);
	$runner->id=$ligne[0];
	$runner->name=utf8_encode(strtoupper($ligne[3])." ".ucfirst($ligne[4]));
	$runner->cate=$ligne[10];
	$class=$ligne[10];
	
	
	$runner->club="FRA";
	//On rajoute des postes 9 12 14 17
	
	
	foreach($radioControls[$parse_cate[0]][$cate] as $ctrl){
	
	$coureur[$cpt][$ctrl[0]]=@convert_date($ligne[$ctrl[1]]);
	$runner->{$ctrl[0]}=@convert_date($ligne[$ctrl[1]]);
	}
	
	
	
	
	
	
	
	$runner->splitTimes=$coureur[$cpt];
	foreach($radioControls[$parse_cate[0]][$cate] as $ctrl){
		
		if(($coureur[$cpt][$ctrl[0]]<$bestSplitTime[$ctrl[0]]) &&($coureur[$cpt][$ctrl[0]]!=0)){
		$bestSplitTime[$ctrl[0]]=(String)$coureur[$cpt][$ctrl[0]];
		
		}
		
	
	}
	if(isset($ligne[8]) && ($ligne[8]!=0)){
	
	$runner->startTime=convert_date($ligne[9]);
	}else{
	
	$runner->startTime=convert_date("10:00:00");
	}
	
	//On a le tps en heure minute seconde il le faut en millisecondes
	if(isset($ligne[19]) && ($ligne[19]!=0)){
	$runner->raceTime=@convert_date($ligne[19]);
	
	}else{
	
	$runner->raceTime="";
	}
	$raceTimes[]=$runner->raceTime;

	$runner->classification=$ligne[20];
	$data['id']=$runner->id;
	$data['cell']=$runner;
	
	
	
	
	$response->rows[$cpt]=(object)$data;
	
	$cpt++;

}
sort($raceTimes,SORT_NUMERIC);
$best[$class]=$raceTimes[0];
var_dump($runner);
$bestST[$class]=$bestSplitTime;
$response->records="2";
$response->total=1;
$response->page=0;
$response->updatetime=date("H:i:s");
$response->bestRaceTime=(object)$best;
$response->bestSplitTime=(object)$bestST;


$handle=fopen($cate.".json", "w");
fwrite($handle,json_encode($response));
fclose($handle);


?>