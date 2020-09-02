<?php
	require_once 'trend-naver/trend.php';
	/**
	 * 절대치 산출 기준 키워드를 입력하세요. 
	 * 기준 키워드는 검색광고에서 검색 시 연관 키워드가 없을 수록 좋습니다.
	 * 계산의 정확성을 위해 검색횟수가 5000이상 나오는 키워드를 사용해주세요.
	 * 기준 키워드가 바뀌면 preprocessor-naver.php 파일도 수정해주셔야 합니다.
	 */
	
	// reference : php 지난달 구하기(http://skymin2.tistory.com/35)
	$prevMonth = strtotime("-1 month", mktime(0,0,0, date("m"), 1, date("Y"))); //한달전
	$prevStartDate = date("Y-m-01", $prevMonth ); //지난달 1일
	$prevEndDate = date("Y-m-t", $prevMonth ); //지난달 말일
	
	$KEYWORD = "NOTEPAD++";
	$LOCAL_PATH = "trend-naver/keyword/";
	// H = HEAD, U = UNIT, B = BODY, T = TAIL
	$JSON_H = "{\"startDate\":\"".$prevStartDate."\",\"endDate\":\"".$prevEndDate."\",\"timeUnit\":\"month\",\"keywordGroups\": [{\"groupName\": \"";
	$JSON_UH = "\"]},{\"groupName\":\"";
	$JSON_UB = "\",\"keywords\":[\"";
	$JSON_T = "\"]}]}";
	
	$keywordList = file("trend-naver/keyword_list.txt", 0); // file to array
	$jsonList = array();

	foreach($keywordList as $key => $value) {
		if($key % 4 == 0){
			$jsonList[$key/4] = $JSON_H.$KEYWORD.$JSON_UB.$KEYWORD;
		} 
		$jsonList[$key/4] = $jsonList[$key/4].$JSON_UH.trim($keywordList[$key]).$JSON_UB.trim($keywordList[$key]);
		if(($key % 4 == 3) || ($key == count($keywordList)-1)){
			$jsonList[$key/4] = $jsonList[$key/4].$JSON_T;
			
			$fp = fopen($LOCAL_PATH."keyword".(int)($key/4).".json", "w+");
			//fwrite($fp, json_encode($response);
			// 한글깨짐 문제 발생시 아래 주석 해제
			fwrite($fp, $jsonList[$key/4]);
			fclose($fp);
		}
	}
?>