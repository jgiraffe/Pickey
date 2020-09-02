	var ACC = 0.05;
	var SPEED = 3;
	var speed = SPEED;
	var tspeed = speed;
	var lspeed = speed;
	var angle;
	var pTop = window.innerHeight / 2;
	var pLeft = window.innerWidth / 2;
	var startThePong;
	var isStart = false;
	var posi = 1;
	var stickPosi;
	var stickPosi2;
	var pScore = 0;


	function readyThePong() {
		pongMode = false;
		yoso("#src1").style.display = "block";
		yoso("#pongSrc").style.display = "none";
		yoso("#exitPong").style.display = "block";
		yoso("#lowerButton").setAttribute("id", "pongStick1");
		yoso("#higherButton").setAttribute("id", "pongStick2");
		yoso("#pongScore").style.display = "block";
		yoso("#pongBall").style.display = "block";
		yoso("#thecircle").style.display = "none";
		yoso("#pongStick1").innerHTML = "퐁";
		yoso("#pongStick2").innerHTML = "퐁";
		startThePong = setInterval(moveBall, 0.1);
		isStart = true;
		yoso("#game").addEventListener("mousemove", moveTheStick);
	}

	function moveTheStick(){
		if (isStart == true) {
			stickPosi = window.event.clientY;
			stickPosi2 = window.innerHeight - window.event.clientY;

			if (stickPosi < 140) { // 80
				stickPosi = 140; // 80
				stickPosi2 = window.innerHeight - 140; // 115
			}

			if (stickPosi > window.innerHeight - 140) { // 115
				stickPosi = window.innerHeight - 140; // 115
				stickPosi2 = 140; // 80
			}
			document.getElementById("pongStick1").style.top = (stickPosi - 75)+"px";
			document.getElementById("pongStick2").style.top = (stickPosi2 - 75)+"px";
		}
		else { }
	}

	function moveBall() {
		// 공 위치 설정
		document.getElementById("pongBall").style.top = pTop+"px";
		document.getElementById("pongBall").style.left = pLeft+"px";
		angle = parseInt(Math.random()*15)+45;
		// posi 1 ++ 오아 2 -+ 오위 3 +- 왼아 4 -- 왼위
		if(pTop >= window.innerHeight - 74 && posi == 1) {
			posi = 2;
			tspeed = -speed * Math.cos(angle * Math.PI / 180).toFixed(2);
			lspeed = speed * Math.sin(angle * Math.PI / 180).toFixed(2);
		}
		//스틱 투 튕
		if(pLeft >= window.innerWidth - 120 && pTop >= stickPosi2 - 95 && pTop <= stickPosi2 + 115 && posi == 1){
			setNextPongStatus();
			posi = 3;
			pLeft = window.innerWidth - 120;
			tspeed = speed * Math.cos(angle * Math.PI / 180).toFixed(2);
			lspeed = -speed * Math.sin(angle * Math.PI / 180).toFixed(2);
		}
		//스틱 투 튕
		if(pLeft >= window.innerWidth - 120 && pTop >= stickPosi2 - 95 && pTop <= stickPosi2 + 115 && posi == 2){
			setNextPongStatus();
			posi = 4;
			pLeft = window.innerWidth - 120;
			tspeed = -speed * Math.cos(angle * Math.PI / 180).toFixed(2);
			lspeed = -speed * Math.sin(angle * Math.PI / 180).toFixed(2);
		}
		if(pTop <= 40 && posi == 2){
			posi = 1;
			tspeed = speed * Math.cos(angle * Math.PI / 180).toFixed(2);
			lspeed = speed * Math.sin(angle * Math.PI / 180).toFixed(2);
		}
		if(pTop >= window.innerHeight - 74 && posi == 3){
			posi = 4;
			tspeed = -speed * Math.cos(angle * Math.PI / 180).toFixed(2);
			lspeed = -speed * Math.sin(angle * Math.PI / 180).toFixed(2);
			}
		//스틱원 튕
		if(pLeft <= 120 && pTop >= stickPosi-115 && pTop <= stickPosi + 115 && posi == 3){
			setNextPongStatus();
			posi = 1;
			pLeft = 120;
			tspeed = speed * Math.cos(angle * Math.PI / 180).toFixed(2);
			lspeed = speed * Math.sin(angle * Math.PI / 180).toFixed(2);
		}
		//스틱원 튕
		if(pLeft <= 120 && pTop >= stickPosi-115 && pTop <= stickPosi + 115 && posi == 4){
			setNextPongStatus();
			posi = 2;
			pLeft = 120;
			tspeed = -speed * Math.cos(angle * Math.PI / 180).toFixed(2);
			lspeed = +speed * Math.sin(angle * Math.PI / 180).toFixed(2);
		}
		if(pTop <= 40 && posi == 4){
			posi = 3;
			tspeed = speed * Math.cos(angle * Math.PI / 180).toFixed(2);
			lspeed = -speed * Math.sin(angle * Math.PI / 180).toFixed(2);
		}
		//die
		if (pLeft < 75 || pLeft > window.innerWidth - 50){
			speed = SPEED;
			pScore = 0;
			yoso("#pongScore").innerHTML = pScore;
		 	pTop = window.innerHeight / 2;
			pLeft = window.innerWidth / 2;
			randomRestart(parseInt(Math.random()*4)+1);
		}
			pTop += tspeed;
			pLeft += lspeed;
	}

	function randomRestart(r) {
		if (r == 1) {
			posi = 1;
			tspeed = speed;
			lspeed = speed;
		}
		else if (r == 2) {
			posi = 2;
			tspeed = -speed;
			lspeed = speed;
		}
		else if (r == 3) {
			posi = 3;
			tspeed = speed;
			lspeed = -speed;
		}
		else {
			posi = 4;
			tspeed = -speed;
			lspeed = -speed;
		}
	}

	function setNextPongStatus() {
		yoso("#pongScore").innerHTML = ++pScore;
		if(pScore > 0 && pScore % 100 == 0 && score < 2)
			a234fgr54r5h6r5ju();
		speed += ACC;
	}

	function exitThePong() {
		speed = SPEED;
		pScore = 0;
		yoso("#pongScore").innerHTML = pScore;
		pTop = window.innerHeight / 2;
		pLeft = window.innerWidth / 2;
		randomRestart(parseInt(Math.random()*4)+1);
		clearInterval(startThePong);
		isStart = false;
		yoso("#pongStick1").innerHTML = "PICK!";
		yoso("#pongStick2").innerHTML = "PICK!";
		yoso("#pongStick1").setAttribute("id", "lowerButton");
		yoso("#pongStick2").setAttribute("id", "higherButton");
		yoso("#pongScore").style.display = "none";
		yoso("#pongBall").style.display = "none";
		yoso("#thecircle").style.display = "block";
		yoso("#exitPong").style.display = "none";
	}
