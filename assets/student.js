import './bootstrap.js';
import './styles/student.css';
import './images';
$(document).ready(function(){
  var time = $(".timer").text();
  $(".timer").text(time+":00"+":00 time left");
  var seconds = 0;
  var minutes = 0;
  var hours = parseInt(time);
  console.log("hello");
  var timer = setInterval(() => {
    if(hours == 0 && minutes == 0 && seconds == 0){
      clearInterval(timer);
      // console.log("end");
      $(".exam-form").trigger("submit");
    }
    if(seconds<=0 && hours!=0){
      minutes--;
      seconds = 59;
    }
    if(minutes<=0 && hours!=0){
      hours=0;
      minutes = 0;
      seconds = 10;
    }

    $(".timer").text(hours+":"+minutes+":"+seconds+" time left");
    seconds--;
  },1000)
});