// sourced by https://stackoverflow.com/questions/247483/http-get-request-in-javascript

function httpGet(theUrl)
{
    var xmlHttp = new XMLHttpRequest();
    xmlHttp.open( "GET", theUrl, false ); // false for synchronous request
    xmlHttp.send( null );
    return xmlHttp.responseText;
}

function httpGetAsync(theUrl, callback)
{
    var xmlHttp = new XMLHttpRequest();
    xmlHttp.onreadystatechange = function() { 
        if (xmlHttp.readyState == 4 && xmlHttp.status == 200)
            callback(xmlHttp.responseText);
    }
    xmlHttp.open("GET", theUrl, true); // true for asynchronous 
    xmlHttp.send(null);
}

// 이미지 주소
function getImgUrl(jsonResponse)
{
	var imgUrl;
	try {
		imgUrl = JSON.parse(jsonResponse).items[0].link;
	} catch(e) {
		imgUrl = JSON.parse(jsonResponse).items.link;
	} finally {
		return imgUrl;
	}
}

// 이미지의 출처
function getSrcUrl(jsonResponse)
{
	var srcUrl;
	try {
		srcUrl = JSON.parse(jsonResponse).items[0].image.contextLink;
	} catch(e) {
		srcUrl = JSON.parse(jsonResponse).items.image.contextLink;
	} finally {
		return srcUrl;
	}
}