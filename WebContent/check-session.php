<?php
	session_start();
	include_once 'query-rank.php';
	include_once 'decrypt.php';
	
	$msg = $_POST;
	
	if( is_numeric($msg['score']) ) {
		print_r("잘못된 접근입니다");
	}
	else {
		$privateKey = openssl_get_privatekey( file_get_contents( "ssl/keys/private.key" ) ) ;
		$encryptedScore = base64_decode(explode( ":::", $msg['score'] )[0]);
		$decryptedScore = decrypt($encryptedScore, $privateKey);
		$score = $decryptedScore;
		$score = strip_tags($score);
		
		//print_r($_SESSION['score'].", ".$score);
		
		if($_SESSION['score'] == $score && $score < 771) 
			print_r(queryRank($msg));
		else print_r("잘못된 접근입니다");
	}
?>