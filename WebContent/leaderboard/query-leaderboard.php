<?php
	include '../query/load-config.php';
	$config = parseConfig();
	$HOST_NAME = $config['HOST_NAME'];
	$USER_NAME = $config['USER_NAME'];
	$PASSWORD = $config['PASSWORD'];
	$SCHEME_NAME = $config['SCHEME_NAME'];

	$result = "";

	$conn = mysqli_connect($HOST_NAME, $USER_NAME, $PASSWORD, $SCHEME_NAME);//db연결
	
	$conn->query("set session character_set_connection=utf8;");
	$conn->query("set session character_set_results=utf8;");
	$conn->query("set session character_set_client=utf8;");
	
	$data = array();
	$tableName = $_POST['table'];
	$tableName = strip_tags($tableName);
	$sql = "SELECT * FROM pickey_".$tableName." ORDER BY score DESC";
	if($queryResult = $conn->query($sql)) {
		while($row = $queryResult -> fetch_array(MYSQLI_ASSOC)){//전체를 data배열에 삽입.
			array_push($data, $row);
			/******
			 ******  서버 부하 방지를 위한
			 ******  리더보드 조회 제한
			 ******/
			if(sizeof($data) >= 1000) break;
			/******/
		}
		$queryResult->close();
	}
	$data = array_reverse($data);
	
	
	$i = 0;
	$len_array=count($data);
	
	while($i < $len_array) {	//10등까지 출력
		try {
			$value = array_pop($data);
			if($value == null) throw new Exception("Offset overflow Exception");
				echo "<tr>";
				echo "<td class='rankRow' style='text-align: center'>".strval($i+1)."등"."</td>";
				echo "<td class='nicknameRow' style='text-align: left'>".strval($value['nickname'])."</td>";      
				echo "<td class='scoreRow' style='text-align: center'>".strval($value['score'])."</td>";
				echo "</tr>";
		} catch(Exception $e) {
			$result .= "없음, ";	//strval: string캐스트
			$result .= "0\n";
		} finally { $i++; }
	}
	$conn->close();
	
	print_r($result);
?>