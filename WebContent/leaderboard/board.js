/*
var currentPage = 1;
loadCurrentPage();

$("#next, #prev").click(function(){
	currentPage =
		($(this).attr('id')=='next') ? currentPage + 1 : currentPage - 1;
		
	if(currentPage==0)
		currentPage=1;
	else if (currentPage==101)
		currentPage=100;
	else
		loadCurrentPage();
});

function loadCurrentPage(){
	$('input').attr('disabled','disabled');
	
	$('#displayResults').html('<img src
}
	*/
function yoso(x) {
	return document.querySelector(x);
}
function normalBoard() {
	yoso("#timeAttack").style.display = "none";
	yoso("#normal").style.display = "block";
	yoso("#normalButton").style.display = "block";
	yoso("#timeAttackButton").style.display = "block";
}
function timeBoard() {
	yoso("#timeAttack").style.display = "block";
	yoso("#normal").style.display = "none";
	yoso("#normalButton").style.display = "block";
	yoso("#timeAttackButton").style.display = "block";
}
/*
function goBack() {
    window.history.back();
}
*/
function openPage(url) {
    newPage=window.open(url, "_self");
}