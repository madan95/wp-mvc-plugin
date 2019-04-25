<?php
class Location{
    private $locationId;
    private $locationName;
    private $locationAddress;

    private static $dbLocation = array(
        locationId => 'INT NOT NULL AUTO_INCREMENT PRIMARY KEY',
        locationName => 'VARCHAR(200)',
        locationAdress => 'VARCHAR(200)',
        locationVariable => 'VARCHAR(200)',
        locationV => 'VARCHAR(200)'
    );


    public function __construct(){
  
    }

    function getLocationId() {
        return $this->locationId;
    }

    function getLocationName() {
        return $this->locationName;
    }

    function getLocationAddress() {
        return $this->locationAddress;
    }

    function setLocationId($locationId) {
        $this->locationId = $locationId;
    }

    function setLocationName($locationName) {
        $this->locationName = $locationName;
    }

    function setLocationAddress($locationAddress) {
        $this->locationAddress = $locationAddress;
    }



    /**
     * @return array
     */
    public static function getColumn()
    {
        return self::$dbLocation;
    }





}
