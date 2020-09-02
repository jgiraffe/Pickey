<?php
	require_once "keyword_generator-naver.php";
	require_once "get-sources.php";

	$api = new KeywordGeneratorNaver();
	$api->Get();
	$kwrd = $api->GetKeywordArray();
	$len = count($kwrd);

	$srcApi = new GetSources();
	$sources = $srcApi->Get();

	for($i = 0; $i < $len; $i++){
		if ($kwrd[$i] == '퐁') {
			$temp = $kwrd[$i];
			$kwrd[$i] = $kwrd[0];
			$kwrd[0] = $temp;
		}
	}

	$data = array();
	$data['key'] = $kwrd;
	$data['src'] = $sources;
	echo json_encode($data, JSON_UNESCAPED_UNICODE);
?>
