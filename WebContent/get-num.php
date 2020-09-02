<?php
	require_once "keyword_generator-naver.php";

	$api = new KeywordGeneratorNaver();
	$api->Get();
	$cnt = $api->GetCountArray();

	echo $cnt[$_POST['key']];
?>
