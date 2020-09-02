<!DOCTYPE html>
<html lang="ko">
	<head>
		<meta charset="utf-8">
		<style>
			.wrapper {
				position: relative;
				display: inline-block;
				width: 500px;
				height: 500px;
				background-color: black;
				background-position: center;
				background-size: contain;
				background-repeat: no-repeat;
			}
			.text {
				position: absolute;
				text-align: center;
				left: 50%;
				top: 50%;
				transform:translate(-50%,-50%);
				color: white;
				background-color: black;
			}
			.source {
				position: absolute;
				right: 10px;
				bottom: 10px;
				text-align: center;
				font-size: 5px;
				color: gray;
			}
		</style>
		<script type="text/javascript" src="./jquery-3.3.1.js"></script>
	</head>
	<body>
		<div id="key1", class="wrapper">
			<div class="text">
			<?php 
				require_once "keyword_generator-naver.php";
				require_once "get-sources.php";
				
				$keywordGenerator = new KeywordGeneratorNaver();
				$keywordGenerator->Get();
				$key = $keywordGenerator->GetKeyword();
				$count = $keywordGenerator->GetSearchCount($key);
				
				// 따로 키워드를 표시하여 사용 시 아래를 주석처리
				print($key."<br>");
				print($count."<br>");
				
				$srcApi = new GetSources();
				$sources = json_encode($srcApi->Get(), JSON_UNESCAPED_UNICODE);	// 한글깨짐 현상 방지
			?>
			<script type="text/javascript">
				var LOCATION = "keyword-image/images/";
				var key = "<?=$key;?>";
				var EXTENSION = ".jpg";
				var path = LOCATION + key + EXTENSION;
				var src = "url(\"" + path + "\")";
				$("#key1").css('background-image', src);
				var imgSrc = <?=$sources;?>;
				//$("#src1").attr("href", imgSrc[key]);	// 사용 불가능한 방법
				function src1() {
					window.open(imgSrc[key]);	// 윈도우에 해당 링크로 새 창 적재
				}
			</script>
			</div>
			<a href="#", id="src1", class="source", onclick="src1()", target="_blank">
				이미지 출처
			</div>
		</div>
	</body>
</html>