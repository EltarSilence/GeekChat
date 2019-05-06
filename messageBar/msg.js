$( document ).ready(function() {
    $("#row2").toggle();
	$("#row3").toggle();
});

$("#coll").on("click", function(){
	$("#row2").toggle();
});

$("#coll2").on("click", function(){
	$("#row3").toggle();
})

