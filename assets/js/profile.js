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
        $('#safe').on('click',function(){
          var formdata = new FormData();
          formdata.append("image", document.getElementById("inputimg").files[0]);
          formdata.append("bio", $('#bio').val());
          $.ajax({
            method : "POST",
            url : "modifyProfile",
            processData : false,
            contentType: false,
            data : formdata,
            success : function(){
              $('#profile').slideUp();
              setTimeout(function(){
                $('#profile').html("");
              }, 800);
            },
            error : function(er){
              console.log(er);
            }
          });
        });
      },
      error : function(er){
        console.log(er);
      }
    });
  });

});
function modimg(){
	document.getElementById("inputimg").click();
}
