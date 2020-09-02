<?php
	$queryType = $_POST['queryType'];
	$queryType = strip_tags($queryType);
	
	include 'query/load-config.php';
	$config = parseConfig();
	$HOST_NAME = $config['HOST_NAME'];
	$USER_NAME = $config['USER_NAME'];
	$PASSWORD = $config['PASSWORD'];
	$SCHEME_NAME = $config['SCHEME_NAME'];
	
	$result = 0;

	$conn = mysqli_connect($HOST_NAME, $USER_NAME, $PASSWORD, $SCHEME_NAME);//db연결
	
	$conn->query("set session character_set_connection=utf8;");
	$conn->query("set session character_set_results=utf8;");
	$conn->query("set session character_set_client=utf8;");
	
	foreach($conn->query("SELECT AVG(score) FROM pickey_".$queryType) as $row){	//평균
		$chan = sprintf('%0.2f',$row['AVG(score)']);
		$result .= "평균: ".$chan."\n";
	}
	
	$data = array();
	$i = 1;
	$sql = "SELECT * FROM pickey_".$queryType." ORDER BY score DESC";
	if($queryResult = $conn->query($sql)) {
		while(($row = $queryResult -> fetch_array(MYSQLI_ASSOC)) && ($i <= 10)){//10등까지 data배열에 삽입.
			array_push($data, $row);
			$i++;
		}
		$queryResult->close();
	}

	try {
		$result = array_pop($data)['score'];
	} catch(Exception $e) {
		$result = 0;
	}
	
	$conn->close();
	
	print_r($result);
?>