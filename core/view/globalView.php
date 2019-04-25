<?php

//bootstrap container
  function createContainer($position){
    if($position == "open"){
      return '<div class="container">';
    }else if($position == 'close'){
      return '</div>';
  }



  }
