<?php
	require_once "keyword_generator-naver.php";
	
	$api = new KeywordGeneratorNaver();
	$api->Get();
	
	// How to get keywords, searchCounts separately
	print_r(nl2br("Get keywords, searchCounts separately\n"));
	print_r(nl2br("Result : \n"));
	$stringContainer = "";
	$countContainer = -1;
	while($stringContainer !== "THERE_ARE_NO_KEYWORDS") {
		$stringContainer = $api->GetKeyword();
		$countContainer = $api->GetSearchCount($stringContainer);
		
		if($countContainer == -1) {
			break;
		} else {
			print_r($stringContainer);
			print_r(" = ");
			print_r($countContainer);
			print_r(nl2br("\n"));
		}
	}
	
	print_r(("--------------------------------------------------------------------------------"));
	print_r(nl2br("\n\n\n\n\n"));
	print_r(("--------------------------------------------------------------------------------"));
	print_r(nl2br("\n"));
	$api->Get();
	
	// How to get the keywordArray[] and searchCountArray[] separately
	print_r(nl2br("Get the keywordArray[] and searchCountArray[] separately\n"));
	print_r(nl2br("Result : \n"));
	print_r($api->GetKeywordArray());
	print_r($api->GetCountArray());
	
	
	print_r(("--------------------------------------------------------------------------------"));
	print_r(nl2br("\n\n\n\n\n"));
	print_r(("--------------------------------------------------------------------------------"));
	print_r(nl2br("\n"));
	$api->Get();
	
	//How to get an orderedPair[] of keywords and searcheCounts
	print_r(nl2br("Get an orderedPair[] of keywords and searcheCounts\n"));
	print_r(nl2br("Result : \n"));
	$pairContainer = array();
	while(true) {
		$pairContainer = $api->GetKeywordPair();
		if($pairContainer[0] === "THERE_ARE_NO_KEYWORDS")
			break;
		
		if($pairContainer[1] == -1) {
			break;
		} else {
			print_r($pairContainer);
			print_r(nl2br("\n"));
		}
	}
?>