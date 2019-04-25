<?php
/**
 * Created by PhpStorm.
 * User: madan
 * Date: 12/12/2017
 * Time: 17:45
 */

class Client extends Person{

    private $customerId ;

    function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function getCustomerId()
    {
        return $this->customerId;
    }

    /**
     * @param mixed $customerId
     */
    public function setCustomerId($customerId)
    {
        $this->customerId = $customerId;
    }



}