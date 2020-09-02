<?php
$keyword = "테스트";
	$srcUrl = "http://test.com/";
	$LOCAL_PATH = "../images/";
	$INI_PATH_NAME = $LOCAL_PATH."keyword-sources.ini";
	$INI_ASSIGNMENT = " = \"";
	$INI_NEW_LINE = "\"\n";	
	$oldString = file_get_contents($INI_PATH_NAME);
$fp = fopen($INI_PATH_NAME, "w+");
			$INIString = $keyword.$INI_ASSIGNMENT.$srcUrl.$INI_NEW_LINE;
			fwrite($fp, $INIString.$oldString);
			fclose($fp);
?>