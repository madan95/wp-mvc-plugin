<?php
class Booking2Controller extends GenericController{

  public function register($request){
    return require (BASEPATH . '/Implement/mvc/view/models/booking/new.php');
  }




}
