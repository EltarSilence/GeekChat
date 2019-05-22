$(document).ready(function(){
  $('#editProfile').on('click', function(){
    $.ajax({
      method : "POST",
      url : "myProfile",
      data : {},
      success : function(data){
        $('#profile').html(data);
        $('#profile').slideDown();
        $('#backbutton').on('click', function(){
          $('#profile').slideUp();
          setTimeout(function(){
            $('#profile').html("");
          }, 800);

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
