/**
 * @Author: 띠리
 * @Modify: NeoMind
 * Reference: http://wwwi.tistory.com/240
 */
function xmlToNodeArray(xmlPathName, tagName) {
	var xmlDoc=null;
	var request;	//Ajax 요청 객체 생성
	// Reference : http://blog.naver.com/PostView.nhn?blogId=jinhyuk2174&logNo=70187555785&parentCategoryNo=110&categoryNo=&viewDate=&isShowPopularPosts=true&from=search
	if(window.XMLHttpRequest){	//IE 8.0 이하 브라우저가 아닌 브라우저에서의 생성
		request = new XMLHttpRequest();
	} else{ //IE 8.0 하위 버전의 브라우저에서의 생성
		request = new ActiveXObject("Microsoft.XMLHTTP");
	}

   request.open("GET", xmlPathName, false);	//요청 메시지 생성
   request.send('', false);	//요청
   
	var datas = request.responseXML.getElementsByTagName(tagName);
	if(datas != null) {
		var output = new Array(); 
		for( var i = 0; i<datas.length ; i++)
			output[i] = datas[i];
		return output;
	}
	return false;
}

/**
 * @Author: 
 * @Modify: NeoMind
 * Reference: http://superkts.pe.kr/helper/view.php?seq=4&PHPSESSID=b9044efb86f9d92cd82df88bf5666b1c
 */
function filter(originText, filterd) {
	var filterWordList = xmlToNodeArray("filter_word_list.xml", "word");
	if(filterWordList != false && filterWordList != null) {
		var tmp;
		var engKor = onlyEngKor(originText);
		for(i=0 ; i<filterWordList.length ; i++){
			tmp = originText.toLowerCase().indexOf(
				filterWordList[i].childNodes[0].nodeValue);
			if(tmp >= 0){ return filterd; }
			tmp = engKor.toLowerCase().indexOf(
				filterWordList[i].childNodes[0].nodeValue);
			if(tmp >= 0){ return filterd; }
		}
	}
	return originText;
}

function onlyEngKor(originText) {
	return originText.replace(/[^(가-힣ㄱ-ㅎㅏ-ㅣa-zA-Z)]/gi, "");
}