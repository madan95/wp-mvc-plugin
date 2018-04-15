<?php

class Customer  extends Base{
  private $customer_id;
  private $customer_name;
  private $location_id;
  private $full_address;

  public function __construct(){

  }

  public function getFullAddress(){
    $entity_manager = EntityManagerFactory::createEM();
    $location = $entity_manager->find('location', $this->getValue('location_id'));
    return $location->getFullAddress();
  }

  public function getCustomerId(){
    return $this->customer_id;
  }
  public function getCustomerName(){
    return $this->customer_name;
  }
  public function getLocationId(){
    return $this->location_id;
  }

  public function setCustomerId($customer_id){
    $this->customer_id = $customer_id;
  }
  public function setCustomerName($customer_name){
    $this->customer_name = $customer_name;
  }
  public function setLocationId($location_id){
    $this->location_id = $location_id;
  }

  public function setAll($customer_id, $customer_name, $location_id){
    $this->setCustomerId($customer_id);
    $this->setCustomerName($customer_name);
    $this->setLocationId($location_id);
  }


}
?>
