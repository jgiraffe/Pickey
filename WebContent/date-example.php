<?php
	// reference : php 지난달 구하기(http://skymin2.tistory.com/35)
	$prev_month = strtotime("-1 month", mktime(0,0,0, date("m"), 1, date("Y"))); //한달전
	echo date("Y-m-01", $prev_month ); //지난달 1일
	echo date("Y-m-t", $prev_month ); //지난달 말일
	
	echo "<br>";
	$dateData = strtotime("0 month", mktime(0,0,0, date("m"), 1, date("Y"))); //한달전
	$prevMonth = date("m", $dateData);
	$prevMonth %= 13;
	echo $prevMonth; //
?>