<?php
class Booking extends Model {

  private $jobID;
  private $customer;
  private $task = array();
  private $startDate;
  private $dueDate;

  private static $dbBooking2 = array(
                                  array( 'table_name' => 'booking'    ),
                                 array( 'field' => ' booking_id ', 'type' => ' int(20) ', 'more_info' => ' NOT NULL AUTO_INCREMENT '),
                                 array( 'field' => ' booking_task_id ', 'type' => ' int(20) '),
                                 array( 'field' => ' booking_start_date ', 'type' => ' DATE '),
                                 array( 'field' => ' booking_due_date ', 'type' => ' DATE '),
                                 array( 'extra' => ' FOREIGN KEY (booking_task_id) REFERENCES pca_task(task_id) '),
                                array('extra' => ' PRIMARY KEY (booking_id) ')
  );


  public function __construct(){
  }

    public static function getColumn()
    {
        return self::$dbBooking;
    }


    function getStartDate() {
      return $this->startDate;
  }

  function getDueDate() {
      return $this->dueDate;
  }

  function getTask() {
      return $this->task;
  }

  function setStartDate($startDate) {
      $this->startDate = $startDate;
  }

  function setDueDate($dueDate) {
      $this->dueDate = $dueDate;
  }

  function setTask($task) {
      $this->task = $task;
  }

  function getCustomer() {
      return $this->customer;
  }

  function setCustomer($customer) {
      $this->customer = $customer;
  }

  function getJobID() {
      return $this->jobID;
  }

  function setJobID($jobID) {
      $this->jobID = $jobID;
  }


}
