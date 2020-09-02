function share_is_mobile(){
	var mobile = new Array('iPhone', 'iPad', 'iPod', 'BlackBerry', 'Android', 'Windows CE', 'LG', 'MOT', 'SAMSUNG', 'SonyEricsson', 'Opera Mini', 'IEMobile');
	for(var word in mobile){
		if(navigator.userAgent.match(mobile[word]) != null) return true;
	}
	return false;
}
function share_naver(url, text){
	var w = 720;
	var h = 720;
	var popup = window.open("http://share.naver.com/web/shareView.nhn?url="+encodeURIComponent(url)+"&title="+encodeURIComponent(text), 'share', 'width='+w+',height='+h+',left='+(screen.availWidth-w)*0.5+',top='+(screen.availHeight-h)*0.5);
	return false;
}
function share_facebook(url){
	var w = 720;
	var h = 350;
	jQuery.post('https://graph.facebook.com', {id:encodeURI(url),scrape:true});
	window.open('https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent(url), 'share', 'width='+w+',height='+h+',left='+(screen.availWidth-w)*0.5+',top='+(screen.availHeight-h)*0.5);
	return false;
}
function share_twitter(url, text){
	var w = 720;
	var h = 350;
	window.open('https://twitter.com/intent/tweet?text='+encodeURIComponent(text)+'&url='+encodeURIComponent(url), 'share', 'width='+w+',height='+h+',left='+(screen.availWidth-w)*0.5+',top='+(screen.availHeight-h)*0.5);
	return false;
}
function share_band(url, text){
	var w = 410;
	var h = 540;
	window.open('http://www.band.us/plugin/share?body='+encodeURIComponent(text)+encodeURIComponent("\n")+encodeURIComponent(url)+'&route='+encodeURIComponent(url), 'share', 'width='+w+',height='+h+',left='+(screen.availWidth-w)*0.5+',top='+(screen.availHeight-h)*0.5);
	return false;
}
function share_kakaostory(url, text){
	Kakao.Story.share({
		url: encodeURI(url),
		text: text
	});
	return false;
}
function share_kakaotalk(url, text){
	var share_img_src = jQuery('meta[property="og:image"]').last().attr('content');
	//var share_description = jQuery('meta[property="og:description"]').last().attr('content');
	try{ Kakao.init('fed69c26951d3ac1af440a77cf949f76'); } catch(e) {}
	if(share_img_src){
		Kakao.Link.sendDefault({
			objectType: 'feed',
			content: {
				title: text,
				//description: share_description,
				imageUrl: share_img_src,
				link: {
					mobileWebUrl: url,
					webUrl: url
				}
			}
		});
	}
	else{
		alert('소셜 공유 버튼 설정에서 공유하기 기본 이미지를 선택해주세요.');
	}
	return false;
}
function share_google(url){
	var w = 600;
	var h = 600;
	window.open('https://plus.google.com/share?url='+encodeURIComponent(url), 'share', 'width='+w+',height='+h+',left='+(screen.availWidth-w)*0.5+',top='+(screen.availHeight-h)*0.5);
	return false;
}
function share_line(url, text){
	if(share_is_mobile()){
		var w = 410;
		var h = 540;
		window.open('http://line.me/R/msg/text/?'+encodeURIComponent(text)+encodeURIComponent("\n")+encodeURIComponent(url), 'share', 'width='+w+',height='+h+',left='+(screen.availWidth-w)*0.5+',top='+(screen.availHeight-h)*0.5);
	}
	else{
		alert('라인이 설치된 모바일에서만 가능합니다.');
	}
	return false;
}
function share(sns, url, title, name, score, gameMode, percentileRank){
	var NORMAL = 0;
	var TIME_ATTACK = 1;
	var mode = "";
	if(gameMode == TIME_ATTACK) mode = "타임 어택 ";
	else if(gameMode == NORMAL) mode = "일반 게임 ";
	title += "\n" + name + "님이 " + mode + "모드에서 " + score + "점을 획득하셨습니다! (상위 " + percentileRank + "%)";
	//console.log(title);
	switch(sns){
		case 'naver': share_naver(url, title); break;
		case 'facebook': share_facebook(url); break;
		case 'twitter': share_twitter(url, title); break;
		case 'band': share_band(url, title); break;
		case 'kakaostory': share_kakaostory(url, title); break;
		case 'kakaotalk': share_kakaotalk(url, title); break;
		case 'google': share_google(url); break;
		case 'line': share_line(url, title); break;
	}
	return false;
}