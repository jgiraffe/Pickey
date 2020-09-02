<?php
	session_start();
	include_once 'query-rank.php';
	include_once 'decrypt.php';
	
	$msg = $_POST;
	
	if( is_numeric($msg['score']) or is_numeric($msg['dskfldcvio439']) ) {
		print_r("잘못된 접근입니다");
	}
	else {
		$privateKey = openssl_get_privatekey( file_get_contents( "ssl/keys/private.key" ) ) ;
		$encryptedScore = base64_decode(explode( ":::", $msg['score'] )[0]);
		$decryptedScore = decrypt($encryptedScore, $privateKey);
		$score = $decryptedScore;
		$score = strip_tags($score);
		
		$dskfldcvio439 = base64_decode(explode( ":::", $msg['dskfldcvio439'] )[0]);
		$decryptedLevel = decrypt($dskfldcvio439, $privateKey);
		$level = $decryptedLevel;
		$level = strip_tags($level);
		
		if($score - $level > 4)
			print_r("잘못된 접근입니다");
		else {
			if($score == $_SESSION['score']+1)
				$_SESSION['score']++;
		}
	}
?>