$(document).ready(function(){
  $('#editProfile').on('click', function(){
    $.ajax({
      url : "my_profile",
      method : "POST",
      data : {},
      success : function(data){
        $('#profile').html(data);
      },
      error : function(er){
        console.log(er);
      }
    });
  });

  $('#show').on('click', function(){
    $('#users').remove();
  });
});
