<?php
class Task extends Base{

  private $product ;
  private $location;
  private $staffs = array();

  public function setProduct($product){
    $this->product = $product;
  }

  public function setLocation($location){
    $this->location = $location;
  }

  public function setStaffs($staffs){
    $this->staffs = $staffs;
  }

  public function getProduct(){
    return $this->product;
  }

  public function getLocation(){
    return $this->location;
  }

  public function getStaffs(){
    return $this->staffs;
  }

  public function findTotalTime(){
    $date_start = DateTime::createFromFormat('Y-m-j', $this->getValue('date_start'));
    $date_finish = DateTime::createFromFormat('Y-m-j', $this->getValue('date_finish'));
    $interval = $date_start->diff($date_finish);
    return $interval->format('%R%a days');
  }

  public function getTotalCost(){
    $entity_manager = EntityManagerFactory::createEM();
    $product = $entity_manager->find('product', $this->getValue('product_id'));
    $total_cost = $this->getValue('product_quantity') * $product->getValue('product_cost');
    return $total_cost;
  }

  public function findTotalCost(){
    $product = $this->getProduct();
    $product_quantity = $this->getValue('product_quantity');
    $total_cost = $product_quantity * $product->getValue('product_cost');
    return $total_cost;
  }

  public function getProductOld(){
    $product_dao = DAOFactory::createDAO('product');
    $product = $product_dao->get($this->getValue('product_id'));
    return $product;
  }

  public function getLocationOld(){
    $location_dao = DAOFactory::createDAO('location');
    $location  = $location_dao->get($this->getValue('location_id'));
    return $location;
  }

  public function getStaffsOld(){
    $taskstaff_dao = DAOFactory::createDAO('taskstaff');
    $taskstaffs = $taskstaff_dao->getMatch($this->getValue('task_id'), 'task_id');

  }


} ?>
