$(document).ready(function() {
	$("#status").show();
	$("#onewaytrip").hide();
	$("#twowaytrip").hide();
//	$("#finddeals").hide();


	$("#but1").click(function(){
		$("#status").show();
		$("#onewaytrip").hide();
		$("#twowaytrip").hide();
//		$("#finddeals").hide();
	});
	$("#but2").click(function(){
		$("#status").hide();
		$("#onewaytrip").show();
		$("#twowaytrip").hide();
//		$("#finddeals").hide();
	});
	$("#but3").click(function(){
		$("#status").hide();
		$("#onewaytrip").hide();
		$("#twowaytrip").show();
//		$("#finddeals").hide();
	});
//	$("#but4").click(function(){
//		$("#status").hide();
//		$("#onewaytrip").hide();
//		$("#twowaytrip").hide();
//		$("#finddeals").show();
//	});
});
