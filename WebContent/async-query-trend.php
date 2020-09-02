<?php
	require_once "keyword_generator-naver.php";
	require_once 'request-controller.php';
	
	$api = new KeywordGeneratorNaver();
	$requestControoler = new RequestController();
  
	// TODO Async processing
	//include 'async-example.php';
	if(!$requestControoler->IsAleadyRequested()) {
		$requestControoler->SetFlag(true);
		$api->QueryTrend();
		$requestControoler->SetFlag(false);
	}
?>
