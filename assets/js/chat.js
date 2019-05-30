$(document).ready(function(){
  var int = setInterval(function(){
    $.ajax({
      url : "getMessage",
      method : "POST",
      data : {
        id : $('#chat > div:first-child > div:last-child').attr('data-id') || 0
      },
      success: function(data){
        $.each(data, function(key, value){
          if($('#chat > *[data-id = '+key+']').length == 0){
            $('#chat > div:first-child').append(value);
          }
        });
      },
      error: function(er){
        console.log(er);
      }
    });
  }, 5000);
});
