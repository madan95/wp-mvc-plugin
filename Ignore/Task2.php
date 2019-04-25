<?php
class Task2{
  private $taskId;
  private $dateStart;
  private $dateFinish;
  private $description;
  private $staff = array();
  private $product;
  private $location;

  
      private static $dbTask = array(
        taskId => 'INT(6) NOT NULL AUTO_INCREMENT PRIMARY KEY',
        discription => 'VARCHAR(200)' ,
		locationIdFk => 'INT , FOREIGN KEY (locationIdFk) REFERENCES pca_location(locationId)'
   );

  public function __construct(){

  }
  function getDateStart() {
      return $this->dateStart;
  }

  function getDateFinish() {
      return $this->dateFinish;
  }

  function getDescription() {
      return $this->description;
  }

  function setDateStart($dateStart) {
      $this->dateStart = $dateStart;
  }

  function setDateFinish($dateFinish) {
      $this->dateFinish = $dateFinish;
  }

  function setDescription($description) {
      $this->description = $description;
  }

  function getProduct() {
      return $this->product;
  }

  function setProduct($product) {
      $this->product = $product;
  }
  
  function getLocation() {
      return $this->location;
  }

  function setLocation($location) {
      $this->location = $location;
  }

  function getTaskId() {
      return $this->taskId;
  }

  function setTaskId($taskId) {
      $this->taskId = $taskId;
  }

    /**
     * @return array
     */
    public function getStaff()
    {
        return $this->staff;
    }

    /**
     * @param array $staff
     */
    public function setStaff($staff)
    {
        $this->staff = $staff;
    }


    /**
     * @return array
     */
    public static function getColumn()
    {
        return self::$dbTask;
    }


}
