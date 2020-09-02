<?php
	class TrendRestApi
	{
		protected $LOCAL_PATH = "trend-naver/";
		
		protected $url;
		protected $clientId;
		protected $clientSecret;

		function __construct($url, $clientId, $clientSecret)
		{
			$this->url = $url;
			$this->clientId = $clientId;
			$this->clientSecret = $clientSecret;
		}
		
		protected function getHeader($method)
		{
			$header = array(
				"Content-Type: application/json",
				"X-Naver-Client-Id: ".$this->clientId,
				"X-Naver-Client-Secret: ".$this->clientSecret
			);
			return $header;
		}
		
		public function Get($query = array())
		{
			$ch = curl_init();
			if (!$ch) {
				die ("Couldn't initialize a cURL handle");
			}
				
			curl_setopt($ch, CURLOPT_URL, $this->url);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $this->getHeader('GET'));
			// SSL 이슈가 있을 경우, 아래 코드 주석 해제
			// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
			$response = curl_exec ($ch);
			$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			//echo "status_code:".$status_code." ";
			curl_close ($ch);
			
			if($status_code != 200) {
				echo "Error : ".$response;
				die ("have been occurred!");
			}
			return $response;
		}
		
		public function WriteFile($response = array(), $resultDir, $number)
		{
			$fp = fopen($this->LOCAL_PATH.$resultDir."result".$number.".json", "w+");
			fwrite($fp, $response);
			// 한글깨짐 문제 발생시 아래 주석 해제
			//fwrite($fp, json_encode($response, JSON_UNESCAPED_UNICODE));
			fclose($fp);
		}
	}
?>