<?php
	function parseConfig() {
		//$config = parse_ini_file("config-local.ini");
		$config = parse_ini_file(".config.ini");
		return $config;
	}
?>