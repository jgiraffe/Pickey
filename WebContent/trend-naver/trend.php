<?php
	ini_set("default_socket_timeout", 30);
	require_once 'restapi.php';
	
	class Trend
	{
		protected $BASE_DIR = "./trend-naver/"; // 이 스크립트의 위치
		protected $KEYWORD_DIR = "./trend-naver/keyword/"; //읽을 디렉토리의 위치 
		protected $RESULT_DIR = "result/"; //결과물 디렉토리의 위치 
		protected $EXTENSION = "json"; //읽을 확장자명
		
		protected function GetKeywordList()
		{
			$keywordList = array();
			$cntList = 0;

			if(!$dh = @opendir($this->KEYWORD_DIR)){
					echo "Can't open the directory \n";
					exit(1);
			}

			while(($file = readdir($dh)) != false){
					if($file == "." || $file == "..")continue;
					$filePath = $this->KEYWORD_DIR.$file;
					// 파일일 경우 (디렉토리는 제외)
					if(is_file($filePath)){
							// 확장자 비교 
							if(stristr($filePath, $this->EXTENSION)){
								$keywordList[$cntList] = $filePath;
								$cntList++;
							}
					}
			}
			closedir($dh);
			return $keywordList;
		}
		
		protected function GetResultList()
		{
			$resultList = array();
			$cntList = 0;

			if(!$dh = @opendir($this->BASE_DIR.$this->RESULT_DIR)){
					echo "Can't open the directory \n";
					exit(1);
			}

			while(($file = readdir($dh)) != false){
					if($file == "." || $file == "..")continue;
					$filePath = $this->BASE_DIR.$this->RESULT_DIR.$file;
					// 파일일 경우 (디렉토리는 제외)
					if(is_file($filePath)){
							// 확장자 비교 
							if(stristr($filePath, $this->EXTENSION)){
								$resultList[$cntList] = $filePath;
								$cntList++;
							}
					}
			}
			closedir($dh);
			return $resultList;
		}
		
		public function RemoveOldList()
		{
			$keywordList = $this->GetKeywordList();
			foreach($keywordList as $key => $fileName) {
				$isRemoved = unlink($fileName);
				if($isRemoved != 1) return false;
			}
			$resultList = $this->GetResultList();
			foreach($resultList as $key => $fileName) {
				$isRemoved = unlink($fileName);
				if($isRemoved != 1) return false;
			}
			return true;
		}
		
		protected function GetINIFile() 
		{
			$config = parse_ini_file("config.ini");
			return new TrendRestApi($config['BASE_URL'], $config['CLIENT_ID'], $config['CLIENT_SECRET']);
		}
		
		public function QueryTrend()
		{
			$keywordList = $this->GetKeywordList();
			$api = $this->GetINIFile();
					
			foreach($keywordList as $key => $fileName) {
				$body  = file_get_contents($fileName, "r+");
				$api->WriteFile($api->Get($body), $this->RESULT_DIR, $key);
			}
		}
		
	}
?>