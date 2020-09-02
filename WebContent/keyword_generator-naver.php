<?php
	class KeywordGeneratorNaver
	{
		public $RESULT_PATH = "processed_result/";
		private $keyword = array();
		private $keywordCount = "";
		
		protected function IsNewMonth()
		{
			$resultList = array();
			
			if(!$dh = @opendir($this->RESULT_PATH)){
					echo "Can't open the directory \n";
					exit(1);
			}
			
			$cnt = 0;

			while(($file = readdir($dh)) != false){
					if($file == "." || $file == "..")continue;
					$resultList[$cnt] = $file;
					$cnt++;
			}
			closedir($dh);
			
			$flag = false;
			
			$timeStamp = strtotime("+8 hour");	//	seoul, korean
			$currentFileName = "result".date("Ym", $timeStamp).".ini";
					
			foreach($resultList as $key => $fileName) {
				if($fileName === $currentFileName) {
					$flag = true;
					break;
				}
			}
			return !$flag;
		}
		
		public function Get()
		{			
			// TODO find n, n-1, n-2, ... to no files remain
			// Value assignment
			$iniList = $this->GetINIList();
		
			while($this->keywordCount == "") {
				$currentFileName = array_pop($iniList);
				if($currentFileName == null) {
					echo "No more ini files \n";
					exit(1);
				}
				$this->keywordCount = parse_ini_file($this->RESULT_PATH.$currentFileName);
			}
						
			$this->keyword = array_keys($this->keywordCount);
			
			shuffle($this->keyword);
		}
		
		private function GetINIList() {
			$RESULT_DIR = "./processed_result/"; //읽을 디렉토리의 위치 
			$EXTENSION = "ini"; //읽을 확장자명
			$iniList = array();

			if(!$dh = @opendir($RESULT_DIR)){
				echo "Can't open the directory \n";
				exit(1);
			}

			while(($file = readdir($dh)) != false){
				if($file == "." || $file == "..")continue;
				$filePath = $RESULT_DIR.$file;
				// 파일일 경우 (디렉토리는 제외)
				if(is_file($filePath)){
						// 확장자 비교 
						if(stristr($filePath, $EXTENSION))
							array_push($iniList, $file);
				}
			}
			closedir($dh);
		        sort($iniList);
			return $iniList;
		}
		
		public function QueryTrend() {
			if($this->IsNewMonth()) {
				require_once "trend-naver/trend.php";
				$trend = new Trend();
				if($trend->RemoveOldList() == true) {
					include "data_processor/preprocessor-naver.php";
					$trend->QueryTrend();
					include "searchad-naver/searchad.php";
					include "data_processor/postprocessor-naver.php";
				}
				else {
					// TODO Control Exception
				}
			}
		}
		
		/**
		 * @return a keyword
		 */
		
		public function GetKeyword()
		{
			if(sizeof($this->keyword) > 0) {
				return array_pop($this->keyword);
			} else return "THERE_ARE_NO_KEYWORDS";
		}
		
		/**
		 * @param keyword which you want know
		 * @return a keyword
		 */
		public function GetSearchCount($keywordString)
		{
			if(array_key_exists($keywordString, $this->keywordCount)) {
				return $this->keywordCount[$keywordString];
			} else return -1;
		}
		
		/**
		 * If you called this function, you should not call GetKeyword()
		 * If you are'nt, this may return reduced keywordArray[]
		 * @return the keywordArray[]
		 */
		public function GetKeywordArray()
		{
			return ($this->keyword);
		}
		
		/**
		 * @return the countArray[]
		 */
		public function GetCountArray()
		{
			return ($this->keywordCount);
		}
		
		
		/**
		 *	If you called this function, you should not call GetKeyword()
		 *	If you are'nt, this may return reduced KeywordPair[]
		 *	@return the keywordPair(key:value)[0:keyword, 1:count]
		 */
		public function GetKeywordPair()
		{
			$orderdPair = array();
			$orderdPair[0] = $this->GetKeyword();
			$orderdPair[1] = $this->GetSearchCount($orderdPair[0]);
			return $orderdPair;
		}
	}
?>
