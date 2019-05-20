var gumStream; //stream from getUserMedia()
var rec; //Recorder.js object
var input; //MediaStreamAudioSourceNode we'll be recording
var AudioContext;
var audioContext;
var timer;
window.onload = function(){
  var AudioContext = window.AudioContext || window.webkitAudioContext;
}
$(document).ready(function(){
  var status = 0;
  /*
    0 =>  Stopped
    1 =>  Recoding
  */

  $('#recordAudio').on('click', function(){
    audioContext = new AudioContext; //new audio context to help us record
    if(status == 0){
      $('#recordAudio i').removeClass('fas fa-microphone-alt');
      $('#recordAudio i').addClass('far fa-stop-circle');
      $('#timer').slideDown();
      status = 1;
      startRecording();
    }else{
      $('#recordAudio i').removeClass('far fa-stop-circle');
      $('#recordAudio i').addClass('fas fa-microphone-alt');
      $('#timer').slideUp();
      stopRecording();
      status = 0;
    }
  });

  function startRecording(){
    var constraints = {
      audio: true,
      video: false
    };
    navigator.mediaDevices.getUserMedia(constraints).then(function(stream){
        gumStream = stream;
        input = audioContext.createMediaStreamSource(stream);
        rec = new Recorder(input, {numChannels : 1});
        rec.record();
        var intervalTime = 1;
        $('#timer').html(convertIntToTime(intervalTime));
        timer = setInterval(function(){
          $('#timer').html(convertIntToTime(intervalTime));
          intervalTime++;
        }, 1000);
    }).catch(function(err) {
      console.log(err);
    });
  }

  function convertIntToTime(n){
    var m = parseInt(n/60).length == 2 ? parseInt(n/60) : "0"+parseInt(n/60);
    var s = ((n%60).length == 2 ? n%60 : "0" + n%60);
    return m + ":" + s;
  }

  function stopRecording(){
    rec.stop();
    clearInterval(timer);
    gumStream.getAudioTracks()[0].stop();
    rec.exportWAV(createDownloadLink);
  }

  function createDownloadLink(blob) {
    URL = window.URL || window.webkitURL;
    var url = URL.createObjectURL(blob);
    var au = document.createElement('audio');

    $('#rowAllegati').html(au);

    var li = document.createElement('li');
    var link = document.createElement('a');

    //add controls to the <audio> element
    au.controls = true;
    au.src = url;

    //link the a element to the blob
    link.href = url;
    link.download = new Date().toISOString() + '.wav';

    console.log(blob);

    //link.click();
/*
    var filename = new Date().toISOString();

    //upload link
    var upload = document.createElement('a');
    upload.href="#";
    upload.innerHTML = "Upload";
    upload.addEventListener("click", function(event){
      var xhr=new XMLHttpRequest();
      xhr.onload=function(e) {
          if(this.readyState === 4) {
              console.log("Server returned: ",e.target.responseText);
          }
      };
      var fd=new FormData();
      fd.append("audio_data", blob, "filename");
      xhr.open("POST","upload.php",true);
      xhr.send(fd);
    });
*/
  }
});
