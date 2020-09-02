<?php
	ini_set("default_socket_timeout", 30);
	require_once 'restapi.php';

	$HINT_KEYWORD = "NOTEPAD++";
	$config = parse_ini_file("config.ini");
	$api = new SearchAdRestApi($config['BASE_URL'], $config['API_KEY'], $config['SECRET_KEY'], $config['CUSTOMER_ID']);
	//$body  = file_get_contents("keyword.json", "r+");
	$dateData = strtotime("-1 month", mktime(0,0,0, date("m"), 1, date("Y"))); //한달전
	$prevMonth = date("m", $dateData);
	$prevMonth %= 13;		// mk 0x to xx. (ex. 07->7, 11->11)
	//$body = "{\"hintKeywords\": \"".$HINT_KEYWORD."\",\"month\": ".$prevMonth.",\"showDetail\": 0}";
	$body = "{\"hintKeywords\": \"".$HINT_KEYWORD."\",\"month\": "."3".",\"showDetail\": 0}";
	$api->WRITE_FILE($api->GET("/keywordstool", $body));
?>