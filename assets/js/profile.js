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
	var formdata= new FormData();
	formdata.append("immage", document.getElementById("inputimg").files[0]);
	formdata.append("bio", document.getElementById("bio").innerHTML);
	var req=new XMLHttpRequest();
	req.open("POST","modifyprofile");
	req.send(formdata);
  }
});

function modimg(){
	document.getElementById("inputimg").click();
}