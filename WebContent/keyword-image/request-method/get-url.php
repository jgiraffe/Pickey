<?php
/**
 * Parameter Reference : https://developers.google.com/custom-search/v1/using_rest
 */
	$config = parse_ini_file("config.ini");
	echo "https://www.googleapis.com/customsearch/v1?key=".$config['API_KEY']. 	// key
									"&num=1".									// one result requested
									"&searchType=image".						// image search
									"&fileType=".$_POST['extension'].			// requested extension 
									"&fields=items(link,image(contextLink))".	// needed information
									"&prettyPrint=false".						// response code style
									//"&rights=cc_publicdomain".				// public domain license (The result may be inadequate or inadequate)
									"&cx=".$config['GOOGLE_ENGINE_ID'].			// google Enginge
									"&q=";										// keyword. it will be defined in JS
								
/**
 * There is the Responce example below. (request keyword : 네이버)
 * See more : https://developers.google.com/custom-search/v1/performance#partial
 */
/*
{
	"kind":"customsearch#search",
	"url":{
		"type":"application/json",
		"template":"https://www.googleapis.com/customsearch/v1?
			q={searchTerms}&num={count?}&start={startIndex?}&lr={language?}
			&safe={safe?}&cx={cx?}&sort={sort?}&filter={filter?}&gl={gl?}
			&cr={cr?}&googlehost={googleHost?}&c2coff={disableCnTwTranslation?}
			&hq={hq?}&hl={hl?}&siteSearch={siteSearch?}&siteSearchFilter={siteSearchFilter?}
			&exactTerms={exactTerms?}&excludeTerms={excludeTerms?}&linkSite={linkSite?}
			&orTerms={orTerms?}&relatedSite={relatedSite?}&dateRestrict={dateRestrict?}
			&lowRange={lowRange?}&highRange={highRange?}&searchType={searchType}
			&fileType={fileType?}&rights={rights?}&imgSize={imgSize?}&imgType={imgType?}
			&imgColorType={imgColorType?}&imgDominantColor={imgDominantColor?}&alt=json"
		},
	"queries":{
		"request":[{
			"title":"Google Custom Search - 네이버",
			"totalResults":"3580",
			"searchTerms":"네이버","count":1,
			"startIndex":1,
			"inputEncoding":"utf8",
			"outputEncoding":"utf8",
			"safe":"off",
			"cx":"009780036754659956620:hwqakvwabqi",
			"rights":"cc_publicdomain",
			"searchType":"image"
		}],
		"nextPage":[{
			"title":"Google Custom Search - 네이버",
			"totalResults":"3580",
			"searchTerms":"네이버","count":1,
			"startIndex":2,
			"inputEncoding":"utf8",
			"outputEncoding":"utf8",
			"safe":"off",
			"cx":"009780036754659956620:hwqakvwabqi",
			"rights":"cc_publicdomain",
			"searchType":"image"
		}]
	},
	"context":{ "title":"Google" },
	"searchInformation":{
		"searchTime":0.616832,
		"formattedSearchTime":"0.62",
		"totalResults":"3580",
		"formattedTotalResults":"3,580"
	},
	"items":[{
		"kind":"customsearch#result",
		"title":"파일:Naver Logotype.svg - 위키백과, 우리 모두의 백과사전",
		"htmlTitle":"파일:\u003cb\u003eNaver\u003c/b\u003e Logotype.svg - 위키백과, 우리 모두의 백과사전",
		"link":"https://upload.wikimedia.org/wikipedia/commons/thumb/2/23/Naver_Logotype.svg/1280px-Naver_Logotype.svg.png",
		"displayLink":"ko.wikipedia.org",
		"snippet":"파일:Naver Logotype.svg - 위키백과, 우리 모두의 백과사전",
		"htmlSnippet":"파일:\u003cb\u003eNaver\u003c/b\u003e Logotype.svg - 위키백과, 우리 모두의 백과사전",
		"mime":"image/png",
		"image":{
			"contextLink":"https://ko.wikipedia.org/wiki/%ED%8C%8C%EC%9D%BC:Naver_Logotype.svg",
			"height":231,
			"width":1280,
			"byteSize":20874,
			"thumbnailLink":"https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR0XHso12Kos6ZV29hGQJXSJrACqw3TCjO6Nl7ny5J17xgYBRaUHWapY8Q",
			"thumbnailHeight":27,
			"thumbnailWidth":150
		}
	}]
}
*/
?>







