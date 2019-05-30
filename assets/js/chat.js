$(document).ready(function(){
  var int = setIntervall(function(){
    $.ajax({
      url : "getMessage",
      method : "POST",
      data : {
        id : $('#chat > div:first-child > div:last-child').attr('data-id')
      },
      success: function(data){
        $('#chat > div:first-child').append(data);
      },
      error: function(er){
        console.log(er);
      }
    });
  }, 1500);
});
