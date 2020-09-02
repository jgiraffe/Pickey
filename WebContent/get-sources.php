<?php
	class GetSources {
		public function Get() {
			$location = "keyword-image/images/";
			$fileName = "keyword-sources.ini";
			$path = $location.$fileName;
			
			return parse_ini_file($path);
			
			/*
			$parsedINI = parse_ini_file($path);
			
			$keywords = array_keys($parsedINI);
			$sources = array_values($parsedINI);
			
			$data = array();
			$data['key'] = $keywords;
			$data['src'] = $sources;
			
			return $data;*/
		}
	}
?>