<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>temp</title>
	<script src="./jquery-3.3.1.js"></script>
	<script src="./get-google-image.js"></script>
</head>

<body onload="dynamicImgGetter('네이버')">
	<script type="text/javascript">
	// 구글 Custom Search api
	function dynamicImgGetter(keyword) {
		var httpRequest;
		var EXTENSION = "jpg";	// only .jpg extension 
		var dataObj = { extension : EXTENSION };
		$.ajax({
			url : 'get-url.php',
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
		/*
		document.write("<img src=\"" + getImgUrl(httpResponse)+ "\"\>");
		document.write(getSrcUrl(httpResponse)+ '<Br><Br><Br>');
		*/
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
			url : 'dowload-url.php',
			async : false,
			type : 'POST',
			data : dataObj,
			dataType : 'text'
			// request 결과 확인용. 확인필요시 주석해제
			/*
			,success : function(data) {
				console.log(data);
			}*/
		});
	}
	</script>
</body>
</html>
