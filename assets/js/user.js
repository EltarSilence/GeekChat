$(document).ready(function(){
  $(function(){
    $('[data-toggle="tooltip"]').tooltip()
  });

  var userInterval = setInterval(function(){
    $.ajax({
      method : "POST",
      url : "getOnlineUser",
      data : {},
      success : function(data){
        $('#users').html(data);
      }
    });
  }, 10000);

});
