var gameType = 0; 		// 0:일반, 1:타임어택
var NORMAL = 0;
var TIME_ATTACK = 1;
var score = 0;			// 점수
var n = 1; 				// 키워드 배열 인덱스
var pickeyCount = 6; 			// 카운트다운 시간
var isItPressed = 0; 	// 현재 버튼이 눌린 상태인지 검사
var setCountdown; 		// 카운트다운 함수를 저장
var kwrdcount = 0; 		// 키워드 검색량 카운트
var setCountup; 		// 카운트업 함수를 저장
var keyArr; 			// 키워드 배열
var keyCnt1; 			// 키워드1 검색량
var keyCnt2; 			// 키워드2 검색량
var srcArr; 			// 출처 주소 배열
var len; 				// 키워드 배열의 최대 길이를 저장
var src; 				// 출처 주소 저장
var globalResultType; 	// 1 : 정답,  2 : 무효(오차범위 10% 내외), 그 외 : 오답
var isPC;
var isAleadyRanked = false;
var pongMode = false;

var previousName;	// for query in index.php at function requestQueryRank(isOnlyRank)
var percentileRank = -1;

function yoso(x) {
	return document.querySelector(x);
}

function startTimeAttack() {
	gameType = TIME_ATTACK;
	setCountdown = setInterval(countdown, 1000);
	startGame();
}

function startGame() {
	resetSession();

	yoso("#menu").style.display = "none";
	yoso("#ads").style.display = "none";
	yoso(".footer").style.display = "none";
	yoso("#gameOver").style.display = "none";
	//yoso("#queryInsertUpdate").style.display = "none";
	yoso("#game").style.display = "block";
	changeKeywordArr();

	// 퐁 모드
	if (gameType == NORMAL && pongMode == true && isPC == true) {
		n = 0;
		yoso("#src1").style.display = "none";
		yoso("#pongSrc").style.display = "block";
	}

	yoso("#higherButton").style.display = "block";
	yoso("#higherButton").style.display = "block";
	yoso("#num2").style.display = "none";
	yoso("#game #score span").innerHTML = score;

	setImgBackground("#image1");
	keyCnt1 = getKeywordCount();
	yoso("#game #k1").innerHTML = keyArr[n];
	yoso("#game #num1").innerHTML = numberWithCommas(keyCnt1);

	n++;
	setImgBackground("#image2");
	yoso("#game #k2").innerHTML = keyArr[n];
}

function countdown() {
	pickeyCount--;
	yoso("#ftext").innerHTML = pickeyCount;
	if (pickeyCount <= 0) {
		keyCnt2 = getKeywordCount();
		result(3);
	}
}

function countup() {
	if (Number(keyCnt2) <= 199) kwrdcount++;
	else kwrdcount = parseInt(kwrdcount + Number(keyCnt2) * 0.005);
	yoso("#num2").innerHTML = numberWithCommas(kwrdcount);

	if (kwrdcount >= keyCnt2){
		clearInterval(setCountup);
		yoso("#ftext").innerHTML = "VS";
		yoso("#num2").innerHTML = numberWithCommas(keyCnt2);
		kwrdcount = 0;
		yoso("#thecircle").style.transform = "rotateY(180deg)";

		if (globalResultType == 1) {
			a234fgr54r5h6r5ju();
			yoso("#back").style.background = "green";
			yoso("#btext").innerHTML = "정답!";
			setTimeout(setNextLevel, 2000);
		}

		else if (globalResultType == 2) {
			yoso("#back").style.background = "gray";
			yoso("#btext").innerHTML = "무효!";
			setTimeout(setNextLevel, 2000);
		}

		else {
			yoso("#back").style.background = "#FF3636";
			if (gameType == TIME_ATTACK) yoso("#btext").innerHTML = "실패!";
			else yoso("#btext").innerHTML = "오답!";
			setTimeout(gameOver, 2000);
		}
	}
}

function isHigher() {
	keyCnt2 = getKeywordCount();
	if (isItPressed == 1) return;
	else if(Number(keyCnt1) <= Number(keyCnt2)) result(1);
	else if(Number(keyCnt1) <= Number(keyCnt2) * 0.9 ||
	        Number(keyCnt1) <= Number(keyCnt2 * 1.1)) result(2);
	else result(3);
}

function isLower() {
	keyCnt2 = getKeywordCount();
	if (isItPressed == 1) return;
	else if(Number(keyCnt1) >= Number(keyCnt2)) result(1);
	else if(Number(keyCnt1) >= Number(keyCnt2) * 0.9 ||
          Number(keyCnt1) >= Number(keyCnt2) * 1.1) result(2);
	else result(3);
}

function result(resultType) {
	// rslt // 1 : 정답,  2 : 무효(오차범위 10% 내외), 그 외 : 오답
	isItPressed = 1;
	globalResultType = resultType;
	if (gameType == TIME_ATTACK) clearInterval(setCountdown);
	// yoso("#num2").innerHTML = cntArr[n];
	yoso("#higherButton").style.display = "none";
	yoso("#lowerButton").style.display = "none";
	yoso("#num2").style.display = "block";
	setCountup = setInterval(countup, 0.1);
}

function setNextLevel() {
	isItPressed = 0;
	if(gameType == TIME_ATTACK) {
		pickeyCount = 6;
		setCountdown = setInterval(countdown, 1000);
	}
	if(pongMode == true) {
		pongMode = false;
		yoso("#src1").style.display = "block";
		yoso("#pongSrc").style.display = "none";
	}
	yoso("#higherButton").style.display = "block";
	yoso("#lowerButton").style.display = "block";
	yoso("#num2").style.display = "none";

	setImgBackground("#image1");
	keyCnt1 = keyCnt2;
	yoso("#game #k1").innerHTML = keyArr[n];
	yoso("#game #num1").innerHTML = numberWithCommas(keyCnt1);
	n++;
	if(n == len + 1) {
		alert("준비된 키워드가 고갈되었습니다!");
		gameOver();
	}
	setImgBackground("#image2");
	yoso("#game #k2").innerHTML = keyArr[n];
	yoso("#thecircle").style.transform = "rotateY(0deg)";
}

function setImg(ext) {
	var loc = "keyword-image/images/";
	var path = loc + keyArr[n] + ext;
	src = "url(\"" + path + "\")";
	return path;
}

function setImgBackground(where) {
	try {
		var backgroundImg = setImg(".jpg");
		if(!isImageExists(backgroundImg)) throw e;
	} catch(e) {
		try {
			backgroundImg = setImg(".JPG");
			if(!isImageExists(backgroundImg)) throw ee;
		} catch(ee) {
			console.log("ImageNotFoundException : ");
			console.log("Try to automatically download the "
						+ keyArr[n] + " image on the server...");
			dynamicImgGetter(keyArr[n]);	// is in the index.php
		}
	} finally {
		$(where).css('background-image', src);
	}
}

function isImageExists(image_url){
    var http = new XMLHttpRequest();
	try {
		http.open('HEAD', image_url, false);
		http.send();
	} catch(e) {
	} finally { return http.status != 404; }
}

function gameOver() {
	yoso("#higherButton").style.display = "block";
	yoso("#lowerButton").style.display = "block";
	yoso("#num2").style.display = "none";
	yoso("#menu").style.display = "none";
	yoso("#ads").style.display = "block";
	yoso("#game").style.display = "none";
	yoso("#gameOver").style.display = "block";
	yoso("#gameOver #lastScore").innerHTML = score;

	// 게임 상태 초기화 작업
	yoso("#ftext").innerHTML = "VS";
	yoso("#thecircle").style.transform = "rotateY(0deg)";
	isItPressed = 0;
	pickeyCount = 6;
	kwrdcount = 0;
	n = 1;

	//if(isInTopTen(score)) { yoso("#queryInsertUpdate").style.display = "block"; }
	percentileRank = requestQueryRank(false);
	if (percentileRank >= 0.0 && percentileRank <= 10.0) {
		yoso("#gameOverTable").style.backgroundImage = "url(res/goood.gif)";
		yoso("#message").innerHTML = "훌륭합니다!";
	}
	else if (percentileRank >= 10.0 && percentileRank <= 30.0) {
		yoso("#gameOverTable").style.backgroundImage = "url(res/happy.gif)";
		yoso("#message").innerHTML = "대단하네요!";
	}
	else if (percentileRank >= 30.0 && percentileRank <= 70.0) {
		yoso("#gameOverTable").style.backgroundImage = "url(res/soso.gif)";
		yoso("#message").innerHTML = "그럭저럭...";
	}
	else if (percentileRank >= 70.0 && percentileRank <= 90.0) {
		yoso("#gameOverTable").style.backgroundImage = "url(res/sad.gif)";
		yoso("#message").innerHTML = "좀 더 노력하세요...";
	}
	else {
		yoso("#gameOverTable").style.backgroundImage = "url(res/kidpepe.gif)";
		yoso("#message").innerHTML = "ㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋ";
	}
}

function backToMenu() {
	yoso("#game").style.display = "none";
	yoso("#gameOver").style.display = "none";
	//yoso("#queryInsertUpdate").style.display = "none";
	yoso("#menu").style.display = "block";
	yoso("#ads").style.display = "block";
	yoso(".footer").style.display = "block";

	score = 0;
	percentileRank = -1;
	gameType = NORMAL;
	isAleadyRanked = false;
}

function src1() { window.open(srcArr[keyArr[n-1]]); }
function src2() { window.open(srcArr[keyArr[n]]); }

 function numberWithCommas(x) {
    x = x.toString();
    var pattern = /(-?\d+)(\d{3})/;
    while (pattern.test(x))
        x = x.replace(pattern, "$1,$2");
    return x;
}

function checkDevice() {
	var filter = "win16|win32|win64|mac|macintel";
	var agent = navigator.userAgent.toLowerCase();

	if (navigator.platform) {
		if (filter.indexOf(navigator.platform.toLowerCase()) >= 0) {
			// pc 접속시 버튼에 애니메이션 추가
			isPC = true;
			yoso("#normal").setAttribute("class", "pcbttn");
			yoso("#time").setAttribute("class", "pcbttn");
			yoso("#higherButton").setAttribute("class", "pcbttn");
			yoso("#lowerButton").setAttribute("class", "pcbttn");
			yoso("#menuButton").setAttribute("class", "pcbttn");
			yoso("#confirm").setAttribute("class", "pcbttn");
			yoso("#leaderboard").setAttribute("class", "pcbttn");


			if (filter.indexOf(navigator.platform.toLowerCase()) < 18 &&
			    agent.indexOf("chrome") == -1  &&
					agent.indexOf("safari") != -1 ) {
				// 윈도우용 Safari로 사이트 접근 시 게임 비활성화
				disableTheGame();
			}

			if ((navigator.appName == 'Netscape' && navigator.userAgent.search('Trident') != -1) ||
			     (agent.indexOf("msie") != -1)) {
				// IE로 사이트 접근 시 게임 비활성화
				disableTheGame();
			}
		}
	}
}

function disableTheGame() {
	yoso("#normal").style.display = "none";
	yoso("#time").style.display = "none";
	yoso("#explanation").innerHTML = "죄송합니다!<br>PICKEY는 해당 브라우저를 지원하지 않습니다.";
}

function openPage(url) {
    newPage=window.open(url, "_self");
}

function changeKeywordArr(){
		$.ajax({
			url : 'get-key.php',
			async : false, // AJAX data -> global
			type : 'get',
			dataType : 'json',
			success : function(data) {
				keyArr = data.key;
				cntArr = data.cnt;
				srcArr = data.src;
				len = keyArr.length;
			}
		});
		$.ajax({
			url : 'async-query-trend.php',
			async : true, // AJAX data -> global
		});
	}

	/**
	 * Response Data의 패킷이 노출되어 개발자도구 등을 참고하여 게임성을 해칠 수 있는 문제를 해소
	 */
	function getKeywordCount(){
		var tmpData;
		$.ajax({
			url : 'get-num.php',
			async : false, // AJAX data -> global
			type : 'post',
			data: { key: keyArr[n] },
			dataType : 'text',
			success : function(data) {
				tmpData = data;
			}
		});
		return tmpData;
	}

	// 구글 Custom Search api
	function dynamicImgGetter(keyword) {
		var httpRequest;
		var EXTENSION = "jpg";	// only .jpg extension
		var dataObj = { extension : EXTENSION };
		$.ajax({
			url : 'keyword-image/request-method/get-url.php',
			async : false,
			type : 'POST',
			data : dataObj,
			dataType : 'text',
			success : function(data) {
				httpRequest = data;
			}
		});
		httpRequest += keyword;	// set a keyword

		var httpResponse = httpGet(httpRequest);
		downloadImg(keyword, "."+EXTENSION,
		getImgUrl(httpResponse), getSrcUrl(httpResponse));
	}

	/**
	 * 서버 디렉토리에 이미지 다운로드 요청
	 * example : downloadImg(keyword, "." + EXTENSION,
	 *				getImgUrl(httpResponse), getSrcUrl(httpResponse));
	 */
	function downloadImg(pKeyword, pExtension, pImgUrl, pSrcUrl){
		var dataObj = {
			keyword : pKeyword,
			extension : pExtension,
			imgUrl : pImgUrl,
			srcUrl : pSrcUrl
		};
		$.ajax({
			url : 'keyword-image/request-method/dowload-url.php',
			async : false,
			type : 'POST',
			data : dataObj,
			dataType : 'text'
			// request 결과 확인용. 확인필요시 주석해제

			,success : function(data) {
				//console.log(data);
			}
		});
	}

	/**
	 * game over 후 랭킹등록을 하는 쿼리 함수
	 */
	function requestQueryRank() {
		if(!isNonTag('#nickname')) return false;
		var DEFAULT_NAME = "NO_NAME";
		var nickname;
		nickname = $("#nickname").val();
		if(nickname == '') nickname = DEFAULT_NAME;

		var queryType;
		if(gameType == TIME_ATTACK){ queryType = 'time'; }
		else{ queryType = 'normal'; }

		var encryptedScore = encrypt(score);

		if(!isAleadyRanked) {
			previousName = DEFAULT_NAME;
		}

		nickname = filter(filteringXSS(nickname), "바른 닉네임");
		var dataObj = {
			queryType: encrypt(queryType),
			isAleadyRanked: encrypt(isAleadyRanked),
			score: encryptedScore,
			nickname: encrypt(nickname),
			previousName: encrypt(previousName)
		};

		var requestData;
		$.ajax({
			url: 'check-session.php',
			async : false,
			type: 'POST',
			data: dataObj,
			dataType : 'text',
			cache: false,
			success: function(data){
				//console.log(data);
				//console.log(parseInt(data));
				isAleadyRanked = true;
				previousName = nickname;
				requestData = parseFloat(data);

				if(data == "잘못된 접근입니다") alert(data);
				//else alert("NO_NAME 등록");
				//window.location.href = "query-normal-rank.php";
				//$('#rank').html(data);//버튼으로 넘어가게 하려했으나 실패
			}
		});

		yoso("#gameOver #userNickname").innerHTML = previousName;
		yoso("#gameOver #percentileRank").innerHTML = requestData;
		if(previousName.toLowerCase() == "pong" || previousName == "퐁") pongMode = true;
		return requestData;
	}


// 패킷 스니핑 및 통신단계에서의 변조 방지
function encrypt(plainText) {
	plainText = String(plainText);
	var publicKey = "-----BEGIN PUBLIC KEY-----MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAuIM/3DDO1O4VZ8Yk0MyMyhQuk2juL4LvxkMqDWb+NLs0La31qwsHMs9IlLlQVG1nGI8XECaAo9Q3hd2i0ExTZGlAhAaRVjbMCWvq7Fe2ONgYrQIjQqVypxAgYnb4Y8AyZMmFJWeSz0FUdb+rtrow9dF8p+PwaxFDH5GLSTfDYUneeh1uw6tOH01VAAS25Jlv/wbo8VxuFWOcxOFtcuBvwynve7LJMzpgQ9nW6GB9f7sxISrI0KNGFXt/mPfsshB6iAoiUQfV+MMBJtcVb16uGHaM8E2QnjqLGXtjQDuHM0MFdogSo3iL3cR/MX1CWqQo6cy8gmrqAimcscZQjb8XTQIDAQAB-----END PUBLIC KEY-----";
	var crypt = new JSEncrypt();
	// 키 설정
	crypt.setPrivateKey(publicKey);
	// 암호화
	var encryptedText = crypt.encrypt(plainText);
	return encryptedText;
}

/**
 *	클라리언트 단에서 일어나는 패킷변조 방지 함수
 */
// 게임 시작 시 마다 세션에 저장된 점수정보 초기화
function resetSession() {
		$.ajax({
			url: 'init-session.php',
			async : false,
			type: 'POST',
			cache: false
		});
}

// 패킷 변조 방지를 위한 단계적 호출
function a234fgr54r5h6r5ju() {
	yoso("#game #score span").innerHTML = ++score;
	e65j7thtyujty = encrypt(score);
	dskfldcvio439 = encrypt(n);

		// 클라리언트 단에서 일어나는 패킷변조 방지용 세션정보 저장
		$.ajax({
			url: 'edit_session-score.php',
			async : false,
			data: {
				score: e65j7thtyujty,
				dskfldcvio439 : dskfldcvio439
				},
			dataType : 'text',
			type: 'POST',
			cache: false,
			success: function(data) {
				if(data == "잘못된 접근입니다") alert(data);
			}
		});
}
