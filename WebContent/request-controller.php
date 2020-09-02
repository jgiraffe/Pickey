<?php
	class RequestController
	{
		private $RESULT_DIR = "processed_result/"; //결과물 디렉토리의 위치
		private $FLAG_FILE_NAME = "aleady-requsted";
		
		public function IsAleadyRequested()
		{
			$flag = false;
			if(!$dh = @opendir($this->RESULT_DIR)){
					echo "Can't open the directory \n";
					exit(1);
			}

			while(($file = readdir($dh)) != false)
				if($file == $this->FLAG_FILE_NAME) $flag = true;
			
			closedir($dh);
			
			return $flag;
		}
		
		public function SetFlag($flag)
		{
			if($flag) $this->SetFlagTrue();
			else $this->SetFlagFalse();
		}
		
		private function SetFlagTrue()
		{
			if(!$this->IsAleadyRequested()) {
				$fp = fopen($this->RESULT_DIR.$this->FLAG_FILE_NAME, "w+");
				fwrite($fp, "");
				fclose($fp);
			}
		}
		
		private function SetFlagFalse()
		{
			if($this->IsAleadyRequested()) {
				if(!unlink($this->RESULT_DIR.$this->FLAG_FILE_NAME)){
					echo "Can't set the flag to false \n";
					exit(1);
				}
			}
		}
	}
?>