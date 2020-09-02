<?php
	/**
	 * Reference : [PHP] 원격 URL의 파일을 로컬로 가져오기 (http://unikys.tistory.com/345)
	 */
	 
	$keyword = $_POST['keyword'];
	$extension = $_POST['extension'];
	$imgUrl = $_POST['imgUrl'];
	$srcUrl = $_POST['srcUrl'];
	$LOCAL_PATH = "../images/";
	$INI_PATH_NAME = $LOCAL_PATH."keyword-sources.ini";
	$INI_ASSIGNMENT = " = \"";
	$INI_NEW_LINE = "\"\n";	
	
	if($keyword != "") {
		// download img file
		print_r($imgUrl."\n");
		print_r($LOCAL_PATH.$keyword.$extension."\n");
		copy($imgUrl, $LOCAL_PATH.$keyword.$extension);	
		// The below is write source url in ini file/*
		$oldINIString = parse_ini_file($INI_PATH_NAME);
		if( array_key_exists($keyword, $oldINIString) ) {
			$oldINIString[$keyword] = $srcUrl;
			$fp = fopen($INI_PATH_NAME, "w+");
			$INIString = "";
			foreach($oldINIString as $key => $value)
				$INIString .= $key.$INI_ASSIGNMENT.$value.$INI_NEW_LINE;
			fwrite($fp, $INIString);
			fclose($fp);
		} else {
			$oldString = file_get_contents($INI_PATH_NAME);
			$fp = fopen($INI_PATH_NAME, "w+");
			$INIString = $keyword.$INI_ASSIGNMENT.$srcUrl.$INI_NEW_LINE;
			fwrite($fp, $INIString.$oldString);
			fclose($fp);
		}
	}

	// request 결과 확인용. 확인필요시 주석해제
	//print_r($keyword."\n".$imgUrl."\n".$srcUrl);
?>