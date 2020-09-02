<?php
	// 모든 세션 변수 초기화 및 해제
	session_start();
	$_SESSION = array();
	
	include_once 'decrypt.php';
	
	$_SESSION['score'] = 0;
	//print_r($_SESSION['score'].", ".$score);
?>