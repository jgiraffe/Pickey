<?php
	function queryRank($msg) {
		include_once 'decrypt.php';
		$privateKey = openssl_get_privatekey( file_get_contents( "ssl/keys/private.key" ) ) ;
		$decrypted = array();
		foreach($msg as $key => $value) {
			$encryptedKey = base64_decode(explode( ":::", $value )[0]);
			$decrypted[$key] = decrypt($encryptedKey, $privateKey);
		}

		$queryType = $decrypted['queryType'];
		$queryType = strip_tags($queryType);
		$isAleadyRanked = null;
		$score = $_SESSION['score'];
		$nickname = $decrypted['nickname'];
		$nickname = strip_tags($nickname);
		$nickname = htmlspecialchars($nickname);
		$previousName = null;

		$DEFAULT_NAME = "NO_NAME";
		
		include 'query/load-config.php';
		$config = parseConfig();
		$HOST_NAME = $config['HOST_NAME'];
		$USER_NAME = $config['USER_NAME'];
		$PASSWORD = $config['PASSWORD'];
		$SCHEME_NAME = $config['SCHEME_NAME'];

		$conn = mysqli_connect($HOST_NAME, $USER_NAME, $PASSWORD, $SCHEME_NAME);//db연결

		$conn->query("set session character_set_connection=utf8;");
		$conn->query("set session character_set_results=utf8;");
		$conn->query("set session character_set_client=utf8;");
		
		$isAleadyRanked = $decrypted['isAleadyRanked'];
		$isAleadyRanked = strip_tags($isAleadyRanked);
		if($isAleadyRanked=="true") $isAleadyRanked = true; 
		else $isAleadyRanked = false;
		$previousName = $decrypted['previousName'];
		$previousName = strip_tags($previousName);
		// TODO if isAleadyRanked then Update. (do not insert.)
		$stmt = null;
		if($isAleadyRanked) {
			$num = -1;
			$sql = "select max(num) as num from pickey_".$queryType." where nickname=\"".$previousName."\" and score=".$score;
			foreach($conn->query($sql) as $row){ $num = $row['num']; }
			$stmt = $conn -> prepare("UPDATE pickey_".$queryType." SET nickname = ? WHERE num = ?");
			$stmt->bind_param("si", $nickname, $num);//si s:string, i:inteager
		} else {
			$stmt = $conn -> prepare("INSERT INTO pickey_".$queryType."(nickname,score) VALUES (?,?)");
			$stmt->bind_param("si", $nickname, $score);//si s:string, i:inteager
		}
		$stmt->execute();//pickey_".$queryType."에 닉네임 점수 레코드 삽입
		$stmt->close();
		
		$result = -1;
		$sql = "SELECT \n"
		. "    combined.nickname,\n"
		. "    combined.score,\n"
		. "    ROUND(((@rank - rank) / @rank) * 100, 2) AS percentile_rank\n"
		. "FROM\n"
		. "    (SELECT \n"
		. "        *,\n"
		. "            @prev:=@curr,\n"
		. "            @curr:=score_table.score,\n"
		. "            @rank:=IF(@prev = @curr, @rank, @rank + 1) AS rank\n"
		. "    FROM\n"
		. "        (SELECT \n"
		. "        nickname, score\n"
		. "    FROM\n"
		. "        ".$SCHEME_NAME.".pickey_".$queryType.") AS score_table, (SELECT @curr:=NULL, @prev:=NULL, @rank:=0) AS rank\n"
		. "    ORDER BY score ASC) AS combined\n"
		. "WHERE\n"
		. "    nickname = '".$nickname."' AND score = ".$score;
		foreach($conn->query($sql) as $row){ $result = $row['percentile_rank']; }
		
		$conn->close();
		
		return $result;
	}
?>