var content = null;
$(document).ready(function(){
  $("#coll").click(function(){
    if ($('#row2').is(":visible")){
      $(this).find('i').removeClass('fa-chevron-up');
      $(this).find('i').addClass('fa-chevron-down');
      $("#row2").slideUp(400);
      if ($('#row3').is(":visible")){
        $("#row3").slideUp(400);
      }
    }else{
      $(this).find('i').removeClass('fa-chevron-down');
      $(this).find('i').addClass('fa-chevron-up');
      $("#row2").slideDown(400);
    }
  });

  $("#coll2").click(function(){
    if ($('#row3').is(":visible")){
      $("#row3").slideUp(400);
    }else{
      $("#row3").slideDown(400);
    }
  });

  $("#addLink").click(function(){
    if ($('#row4').is(":visible")){
      $("#row4").slideUp(400);
    }else{
      $("#row4").slideDown(400);
    }
  });
  $('#link').on('change', function(){
    setContent('link');
  });



});

function setContent(type){
  content = type;

  


}
