$(document).ready(function(){
  ajax_getOnlineUser();
  var userInterval = setInterval(ajax_getOnlineUser, 10000);
});
function ajax_getOnlineUser(){
  $.ajax({
    method : "POST",
    url : "getOnlineUser",
    data : {},
    success : function(data){
      $('#users').html(data);
      $("div[id^=tooltip]").remove();
      $(function(){
        $('[data-toggle="tooltip"]').tooltip()
      });
    }
  });
}
