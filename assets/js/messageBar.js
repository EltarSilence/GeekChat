var content = null;
$(document).ready(function(){
  $("#coll").click(function(){
    if ($('#row2').is(":visible")){
      $(this).find('i').removeClass('fa-chevron-up');
      $(this).find('i').addClass('fa-chevron-down');
      $("#row2").slideUp(400);
      if ($('#rowEmoji').is(":visible")){
        $("#rowEmoji").slideUp(400);
      }
    }else{
      $(this).find('i').removeClass('fa-chevron-down');
      $(this).find('i').addClass('fa-chevron-up');
      $("#row2").slideDown(400);
    }
  });

  $("#addEmoji").click(function(){
    $("#rowLink").slideUp(400);
    if ($('#rowEmoji').is(":visible")){
      $("#rowEmoji").slideUp(400);
    }else{
      $("#rowEmoji").slideDown(400);
    }
  });

  $("#addImage").click(function(){
    $("#rowLink").slideUp(400);
    $("#rowEmoji").slideUp(400);
    $('#image').click();
  });
  $('#image').on('change', function(e){
    var f = new FormData();
    f.append('data[]', $(this)[0]['files'][0]);
    content = type;
  });

  $("#addLink").click(function(){
    $("#rowEmoji").slideUp(400);
    if ($('#rowLink').is(":visible")){
      $("#rowLink").slideUp(400);
    }else{
      $("#rowLink").slideDown(400);
    }
  });
  $('#link').on('keydown keyup', function(){
    if($('#link').val() != ""){
      var f = new FormData();
      f.append('data', $('#link').val());
      setContent('link', f);
    }
  });



  $('#sendMessage').on('click', function(){
    var f = new FormData();
    f.append('text', $('#textMessage').html());
    f.append('type', content);
    switch (content){
      case 'image':
        f.append('data[]', $(this)[0]['files'][0]);
        break;
      case 'link':
        f.append('data', $('#link').val());
        break;

    }
    $.ajax({
      url : "sendMessage",
      method : "POST",
      data : f,
      processData: false,
      contentType: false,
      beforeSend: function(){
        $('#textMessage').html("");
      },
      success : function(data){
      },
      error : function(er){
        debugger;
      }
    });





  });

});

function removeContent(){
  content = null;
  $('#rowAllegati').html("");
  $("#rowAllegati").slideUp(400);
}

function setContent(type, data){
  content = type;
}
