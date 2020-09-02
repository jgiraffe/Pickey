<?php
	/**
	 * 절대치 산출 기준 키워드를 입력하세요. 
	 * 기준 키워드는 검색광고에서 검색 시 연관 키워드가 없을 수록 좋습니다.
	 * 계산의 정확성을 위해 검색횟수가 5000이상 나오는 키워드를 사용해주세요.
	 * 기준 키워드가 바뀌면 preprocessor-naver.php 파일도 수정해주셔야 합니다.
	 */
	$KEYWORD = "NOTEPAD++";
	$TREND_PATH = "./trend-naver/";
	$TREND_KEYWORD_DIR = $TREND_PATH."keyword/"; //읽을 디렉토리의 위치 
	$TREND_RESULT_DIR = $TREND_PATH."result/"; //읽을 디렉토리의 위치 
	$RESULT_DIR = "processed_result/"; //결과물 디렉토리의 위치 
	$EXTENSION = "json"; //읽을 확장자명
	
	$keywordAbsolute = -1;
	$timeStamp = strtotime("+8 hour");
	$resultList = array();
	$cntList = 0;

	if(!$dh = @opendir($TREND_RESULT_DIR)){
			echo "Can't open the directory \n";
			exit(1);
	}

	while(($file = readdir($dh)) != false){
			if($file == "." || $file == "..")continue;
			$filePath = $TREND_RESULT_DIR.$file;
			// 파일일 경우 (디렉토리는 제외)
			if(is_file($filePath)){
					// 확장자 비교 
					if(stristr($filePath, $EXTENSION)){
						$resultList[$cntList] = $filePath;
						$cntList++;
					}
			}
	}
	closedir($dh);
		
	// 기준 키워드의 검색회수 절대치를 알아내는 루틴
	$jsonAbsolute  = file_get_contents("searchad-naver/result.json", "r+");
	$jsonAbsoluteDecoded = json_decode($jsonAbsolute);
	foreach ($jsonAbsoluteDecoded -> keywordList as $parentKey => $parentKeyValue) {
		foreach($parentKeyValue as $key => $key_value) {
			if($key_value === $KEYWORD) {
				$keywordAbsolute = ($parentKeyValue -> monthlyPcQcCnt)+
									($parentKeyValue -> monthlyMobileQcCnt);
			}
		}
	}
	
	// 키워들의 검색회수 상대치를 알아내는 루틴
	$resultString = array();
	$resultCount = array();
	$cnt = 0;
	
	foreach($resultList as $file_key => $resultFile) {
		$jsonRelative = json_decode(file_get_contents($resultFile, "r+"));
		foreach($jsonRelative->results as $key => $parsed) {
			if(count($parsed->data) == 1){
				$resultString[$cnt] = $parsed->title;
				$resultCount[$cnt] = $parsed->data[0]->ratio;
				$cnt++;
			}
		}
	}
	
	$resultKeyword = array();
	$resultKeyword[0] = $KEYWORD;
	$resultAbsolute = array();
	$resultAbsolute[0] = $keywordAbsolute;
	
	$keywordRelative = -1;
	$cnt = 1;
	
	foreach($resultString as $key => $title) {
		if($title === $KEYWORD) {
			$keywordRelative = $keywordAbsolute / $resultCount[$key];
		}
		else {
			$resultKeyword[$cnt] = $title;
			$resultAbsolute[$cnt] = (int)($resultCount[$key] * $keywordRelative);
			$cnt++;
		}
	}
	
	$outString = "";
	
	foreach($resultKeyword as $key => $title) {
		$outString = $outString.$title." = ".$resultAbsolute[$key]."\r\n";
	}
	$fp = fopen($RESULT_DIR."result".date("Ym", $timeStamp).".ini", "w+");
			//fwrite($fp, json_encode($response);
			// 한글깨짐 문제 발생시 아래 주석 해제
			fwrite($fp, $outString);
			fclose($fp);
?>