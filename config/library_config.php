<?php
//function untuk menentukan url root dari website
function base_url($string = ""){
	if($string == ""){
		$url = $_SERVER['SERVER_NAME'] == 'localhost' ? 'http://localhost/spk-wp/' : 'http://'.$_SERVER['SERVER_NAME']."/spk-wp/";	
	} else {
		$url = $_SERVER['SERVER_NAME'] == 'localhost' ? 'http://localhost/spk-wp/'.$string : 'http://'.$_SERVER['SERVER_NAME']."/spk-wp/".$string;
	}
	
	return $url;
}

//fungsi untuk berpindah halaman
function redirect($uri, $http_response_code = 302){
	header("Location: ".$uri, TRUE, $http_response_code);
	exit;
}

//Store Weight Criteria
$_SESSION['weight_criteria'] = array(
	"C1" => 5,
	"C2" => 4,
	"C3" => 4,
	"C4" => 3,
	"C5" => 5,
);

//Weight Rules
$_SESSION['weight_rule'] = array(
	0 => 1,
	1 => 1,
	2 => 1,
	3 => -1,
	4 => 1,
	5 => 1
);

//Ranking Setiap Kriteria
$_SESSION['rc'] = array(
		"Proposal" => array(
		"5"				=> 1,
		"3"				=> 2
		
	),
	
		"TingkatKemajuan" 		=> array(
		"5"					=> 1
		
	)
);
?>