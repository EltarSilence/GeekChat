$(document).ready(function() {
  $("#row2").toggle();
	$("#row3").toggle();

  $("#coll").click(function(){
  	$("#row2").toggle();
    if ($('#row3').is(":visible")){
      $('#row3').toggle();
      $('#row2').find('i').toggleClass('fa-chevron-down fa-chevron-up');
    }
    $(this).find('i').toggleClass('fa-chevron-down fa-chevron-up');
  });

  $("#coll2").click(function(){
  	$("#row3").toggle();
    $(this).find('i').toggleClass('fa-chevron-down fa-chevron-up');
  });

});
