$(document).ready(function(){
  $('#editProfile').on('click', function(){
    $.ajax({
      method : "POST",
      url : "my_profile",
      data : {},
      success : function(data){
        $('#profile').html(data);
        $('button').on('click', function(){
          $('#profile').html("");
        });
        addSaveAjax();
      },
      error : function(er){
        console.log(er);
      }
    });
  });
  function addSaveAjax(){


  }
});
