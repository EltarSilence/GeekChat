$(document).ready(function(){
  ajax_getOnlineUser();
  ajax_updateOnlineStatus();
  var onlineInterval = setInterval(ajax_updateOnlineStatus, 5000);
  setTimeout(function(){
    var userInterval = setInterval(ajax_getOnlineUser, 5000);
  }, 2000);

});
function ajax_getOnlineUser(){
  $.ajax({
    method : "POST",
    url : "getOnlineUser",
    data : {},
    success : function(data){
      $('#users').html(data);
      addAjax();
      $("div[id^=tooltip]").remove();
      $(function(){
        $('[data-toggle="tooltip"]').tooltip()
      });
    }
  });
}
function ajax_updateOnlineStatus(){
  $.ajax({
    method : "POST",
    url : "updateOnlineStatus",
    data : {},
    success : function(data){
    },
    error: function(er){
    }
  });
}
function addAjax(){
  $('#users a').on('click', function(){
    debugger;
    $.ajax({
      url : "show_profile",
      method : "POST",
      data : {
        "id" : $(this).attr("data-id")
      },
      success : function(data){
        debugger;
        $('#profile').html(data);
        $('#profile').slideDown();
        $('#backbutton').on('click', function(){
          $('#profile').slideUp();
          setTimeout(function(){
            $('#profile').html("");
          }, 800);

        });
      },
      error : function(er){
        console.log(er);
      }
    });
  });
}
