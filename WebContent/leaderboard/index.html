<!DOCTYPE html>
<html>
<head>
	<!-- 사이트 메타 정보 시작 -->
	<meta charset="utf-8" />
	<title>픽키 랭킹</title>
	<link rel="shortcut icon" type="image/x-icon" href="../res/favicon.ico">
	<link rel="icon" type="image/x-icon" href="../res/favicon.ico">
	<link rel="manifest" href="../manifest.json">
	<link rel="canonical" href="https://pickey.tk/">
	<!-- 네이버 웹마스터 등록 -->
	<meta name="naver-site-verification" content="d62931d17669dd48824b2c905e2a0a322a504e87"/>
	<!-- 구글 웹마스터 등록 -->
	<meta name="google-site-verification" content="d-3JIFYPVex8kA8uM0ISDTJcyV3z3-Fo7ix77mbiU08"/>
	<meta name="nosnippet">
	<meta name="description" content="네이버 기반의 한국형 검색어 비교 게임!">
	<meta name="Keywords" content="네이버 기반의 한국형 검색어 비교 게임!">
	<meta property="og:type" content="website">
	<meta property="og:title" content="픽키">
	<meta property="og:description" content="네이버 기반의 한국형 검색어 비교 게임!">
	<meta property="og:image" content="https://pickey.tk/res/logo.png">
	<meta property="og:url" content="https://pickey.tk/">
	<meta name="viewport" content="width=device-width, height=device-height,
		initial-scale=1.0, maximum-scale=1.0, minimum-scale:1.0, user-scalable=no, shrink-to-fit=no">
	<!-- 사이트 메타 정보 끝 -->

	<!-- Global site tag (gtag.js) - Google Analytics 시작 -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=G-X3W9B0VVW2"></script>
	<script>
	window.dataLayer = window.dataLayer || [];
	function gtag(){dataLayer.push(arguments);}
	gtag('js', new Date());

	gtag('config', 'G-X3W9B0VVW2');
	</script>
	<!-- Global site tag (gtag.js) - Google Analytics 끝 -->

	gtag('config', 'G-X3W9B0VVW2');
	</script>

	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans">
	<script src="board.js"></script>
	<script src="../jquery-3.3.1.js"></script>
	<link rel="stylesheet" type="text/css" href="../layout/board.css">
</head>

<body onload="setWindow(); setBoard('normal');"><!--onload="setBoard('normal')"-->
	<script>
		/**
		 * game over 후 랭킹등록을 하는 쿼리 함수
		 * isOnlyRank에 false를 주면 데이터 변경 없이 평균과 top10 조회만 한다.
		 */
		function setBoard(queryType) {
			var dataObj = { table: queryType };
			
			var requestData;
			$.ajax({
				url: 'query-leaderboard.php',
				async : false,
				type: 'POST',
				data: dataObj,
				dataType : 'text',
				cache: false,
				success: function(data){
					requestData = data;
					//if(hasNickname) alert("랭킹이 등록되었습니다!");
					//else alert("NO_NAME 등록");
					//window.location.href = "query-normal-rank.php";
					//$('#rank').html(data);//버튼으로 넘어가게 하려했으나 실패
				}
			});
			document.querySelector("#boardScript").innerHTML = requestData;
			if(queryType == 'time')
				$(function() {
					$("#time").css("background-color","white");
					$("#time").css("color","black");
					$("#normal").css("background-color","transparent");
					$("#normal").css("color","white");
				});
			else if(queryType == 'normal')
				$(function() {
					$("#time").css("background-color","transparent");
					$("#time").css("color","white");
					$("#normal").css("background-color","white");
					$("#normal").css("color","black");
				});
			else
				$(function() {
					$("#time").css("background-color","transparent");
					$("#time").css("color","white");
					$("#normal").css("background-color","white");
					$("#normal").css("color","black");
				});
			//$("#boardScript, .board tr").css("background", "transparent");
			boardWidth(queryType);
		}
	</script>
	<script>
		$(window).resize(setWindow);	// 창 크기 변화 감지 이벤트 등록
		function setWindow() {
			var windowWidth = window.innerWidth;
			var windowHeight = window.innerHeight;
			var marginTop;
			if(windowWidth > 808) marginTop = 170;
			else if(windowWidth > 440) marginTop = 180;
			else if(windowWidth > 330) marginTop = 120;
			else marginTop = 120;
			$("#leaderBoard").css("height", windowHeight-marginTop);
		}
		function boardWidth(queryType) {
			//console.log($("tr").css("border-style"));
			//console.log($("td").css("border-style"));
			$("#leaderBoard tr:even").css("background-color", "rgba(100, 100, 100, 0.2)");
			if(queryType == 'time') {
				$(".rankRow").width('3820px');
				$(".nicknameRow").width('11950px');
				$(".scoreRow").width('1830px');
			} else  {
				$(".rankRow").width('3700px');
				$(".nicknameRow").width('11950px');
				$(".scoreRow").width('1500px');
			}
		}
	</script>
	<div id="wrapper">
		<div id="filter">
			<div id="uiSet">
				<p id="logo"> <a href="../">
						<img src="../res/logo.png" alt="Pickey"/></a>
				</p>
				<p id="title"> <a href="./">
						<img src="../res/Leaderboard.png" alt="Pickey"/></a>
				</p>
				<div id="buttonWrapper">
					<button id="normal" class="selectionButton" onclick="setBoard('normal')">일반 게임</button>
					<button id="time" class="selectionButton" onclick="setBoard('time')">타임 어택</time>
				</div>
			</div>
			<div id="leaderBoard">
				<table>
					<tr id="boardHeader">
						<th id="rankHeader">Rank</th>
						<th id="nicknameHeader">Nickname</th>      
						<th id="scoreHeader">Score</th>
					</tr>
				</table>
				<div id="boardLayout">
					<table id="boardScript" class="board"></table>
				</div>
			</div>
		</div>
	</div>

</body>
<html>