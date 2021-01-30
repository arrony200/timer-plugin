(function ($) {
  "use strict";

 


var gHours = 0;
var gMinutes = 0;
var gSeconds = 0;

var remainingTime;

var countdownHandle;

var audio = new Audio(plugindir_object.audio_url+'/beep.mp3');






onPomodoroTimer();



function onPomodoroTimer(){

  stopTimer();
  if (typeof time_object  !== "undefined"){
    gMinutes = time_object.pomodoro_minutes;
    gSeconds = time_object.pomodoro_seconds;
  }


  resetTimer();

  $('#shortButton').removeClass('btn-success');
  $('#longButton').removeClass('btn-success');
  $('#pomodoroButton').addClass('btn-success');
  $('.pomodoro_timer').removeClass('longbreak');
  $('.pomodoro_timer').removeClass('shortbreak');


}


$('#pomodoroButton').on('click', function() {
  onPomodoroTimer();
});


  
function onShortTimer(){
  stopTimer();
  if (typeof time_object  !== "undefined"){
  gMinutes = time_object.short_break_minutes;
  gSeconds = time_object.short_break_seconds;
  }
  resetTimer();

    $('#pomodoroButton').removeClass('btn-success');
    $('#longButton').removeClass('btn-success');
    $('#shortButton').addClass('btn-success');
    $('.pomodoro_timer').addClass('shortbreak');
    $('.pomodoro_timer').removeClass('longbreak');
}

$('#shortButton').on('click', function() {
  onShortTimer();
});
 

function onLongTimer(){
    stopTimer();
    if (typeof time_object  !== "undefined"){
    gMinutes = time_object.long_break_minutes;
    gSeconds = time_object.long_break_seconds;
    }
    resetTimer();

    $('#pomodoroButton').removeClass('btn-success');
    $('#shortButton').removeClass('btn-success');
    $('#longButton').addClass('btn-success');
    $('.pomodoro_timer').removeClass('shortbreak');
    $('.pomodoro_timer').addClass('longbreak');
}
$('#longButton').on('click', function() {
  onLongTimer();
});

function onStartTimer(){
    stopTimer();
    startTimer();
};

$('#startButton').on('click', function() {
  onStartTimer();
});

$('#startButton').on('click', function() {
  $('#startButton').hide();
  $('#stopButton').show();
});

$('#stopButton').on('click', function() {
  $('#stopButton').hide();
  $('#startButton').show();
});



function onStopTimer(){
  stopTimer();
};
$('#stopButton').on('click', function() {
  onStopTimer();
});



function onResetTimer(){
  stopTimer();
  resetTimer();
}
$('#restartButton').on('click', function() {
  onResetTimer();
});


function startAlarm(){
  if(remainingTime<1000)
  {
    audio.play();
  }
}

function startTimer() {
  countdownHandle=setInterval(function() {
    decrementTimer();
  },1000);
}

function stopTimer() {
  clearInterval(countdownHandle);
  startAlarm();

}

function resetTimer(){

 remainingTime = (gHours*60*60*1000)+
  (gMinutes*60*1000)+
  (gSeconds*1000);
  renderTimer();
}

function renderTimer(){


  var deltaTime=remainingTime;

  var minutesValue=Math.floor(deltaTime/(1000*60));
  deltaTime=deltaTime%(1000*60);

  var secondsValue=Math.floor(deltaTime/(1000));

  animateTime( minutesValue, secondsValue);
};


function animateTime( remainingMinutes, remainingSeconds) {

  // position

  $('#minutesValue').css('top', '0em');
  $('#secondsValue').css('top', '0em');

 $('#minutesNext').css('top', '0em');
  $('#secondsNext').css('top', '0em');


  var oldMinutesString = $('#minutesNext').text();
  var oldSecondsString = $('#secondsNext').text();


  var minutesString = formatTime(remainingMinutes);
  var secondsString = formatTime(remainingSeconds);

 
  $('#minutesValue').text(oldMinutesString);
  $('#secondsValue').text(oldSecondsString);


  $('#minutesNext').text(minutesString);
  $('#secondsNext').text(secondsString);


  if(oldMinutesString !== minutesString) {
    $('#minutesValue').animate({top: '-=1em'});
    $('#minutesNext').animate({top: '-=1em'});
  }

  if(oldSecondsString !== secondsString) {
   // $('#secondsValue').animate({top: '-=1em'});
  // $('#secondsNext').animate({top: '-=1em'});
  }
}


function formatTime(intergerValue){

  return intergerValue > 9 ? intergerValue.toString():'0'+intergerValue.toString();

}

function decrementTimer(){

  remainingTime-=(1*1000);

  if(remainingTime<1000){
    onStopTimer();
  }

  renderTimer();
}


})(jQuery); 