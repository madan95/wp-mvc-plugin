<?php

class Location extends Base{
  protected $location_id;
  protected $location_name;
  protected $location_address;

  public function __construct(){

  }

  public function getFullAddress(){
   $address_array = array();
   $address_array[] =  $this->getValue('street_address');
   $address_array[] = $this->getValue('city');
   $address_array[] =  $this->getValue('zip');
   $address_array[] = $this->getValue('country');
   foreach($address_array as $key => $value){
     if(empty($value)){
       unset($address_array[$key]);
     }
   }
   if(empty($address_array)){
     return '';
   }else{
     return implode(", ", $address_array);
   }
   }

  public function getLocationId(){
    return $this->location_id;
  }
  public function getLocationName(){
    return $this->location_name;
  }
  public function getLocationAddress(){
    return $this->location_address;
  }

  public function setLocationId($location_id){
    $this->location_id = $location_id;
  }
  public function setLocationName($location_name){
    $this->location_name = $location_name;
  }
  public function setLocationAddress($location_address){
    $this->location_address = $location_address;
  }

  public function setAll($location_id, $location_name, $location_address){
    $this->setLocationId($location_id);
    $this->setLocationName($location_name);
    $this->setLocationAddress($location_address);
  }



}
?>
