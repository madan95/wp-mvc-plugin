<?php

class Testtask{

  private $task_id;
  private $date_start;
  private $date_finish;
  private $description;
  private $product_id;
  private $product_quantity;
  private $location_id;
  private $booking_id;
  private $status;

  public function __construct($task_id, $date_start, $date_finish, $description, $product_id, $product_quantity, $location_id, $booking_id, $status){
    $this->task_id = $task_id;
    $this->date_start = $date_start;
    $this->date_finish = $date_finish;
    $this->description = $description;
    $this->product_id = $product_id;
    $this->product_quantity = $product_quantity;
    $this->location_id = $location_id;
    $this->booking_id = $booking_id;
    $this->status = $status;
  }

  public static function fromState(array $state){
    return new self(
      $state['task_id'],
      $state['date_start'],
      $state['date_finish'],
      $state['description'],
      $state['product_id'],
      $state['product_quantity'],
      $state['location_id'],
      $state['booking_id'],
      $state['status']
    );
  }




}
