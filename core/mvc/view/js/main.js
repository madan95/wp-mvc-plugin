function init(){
  //var ajax_action_btns = document.querySelectorAll(".ajax_action");
  //var i;
  //for(i=0; i<ajax_action_btns.length; i++){
   //   new Action(ajax_action_btns[i]).init();
  //}

    //listen to click on ajax_action class
    $(".ajax_action").ajax_action();
}

document.addEventListener('DOMContentLoaded', function(){ init(); });
