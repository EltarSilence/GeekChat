$(document).ready(function(){
  $.ajax({
    url : "getMessage",
    method : "POST",
    data : {
      id : "1"
    },
    success: function(data){
      $('#chat > div:first-child').append(data);
    },
    error: function(er){
      console.log(er);
    }
  });
});
