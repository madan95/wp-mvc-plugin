<?php

class Client extends Base{
  public function __construct(){

  }

  public function getFullName(){
    return $this->getValue('first_name').' '.$this->getValue('last_name');
  }

  public function getContactNumbers(){
  $number = '';
  if($this->getValue('mobile_number')){
    $number .= '( '.$this->getValue('mobile_number').' )';
  }
  if($this->getValue('phone_number')){
    $number .= '( '.$this->getValue('phone_number').' )';
  }
  return $number;
}
}
