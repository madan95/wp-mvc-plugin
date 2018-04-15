<?php

class ServiceFactory {

  //Service class using service name, atomatically addes dao if it exist 
  public static function createService($service_name){
    $serviceClass = $service_name.'Service';
    $daoClass = $service_name.'DAO';

    $isService = Helper::checkIfFileExists(BASEPATH.'/Implement/mvc/service/'. $service_name . 'Service.php');
    $isDao = Helper::checkIfFileExists(BASEPATH.'/Implement/mvc/dao/'. $service_name . 'DAO.php');

        if($isService){
            $service = new $serviceClass();
              if($isDao){
                    $dao = new $daoClass();
                    $service->setDAO($dao);
              }
            return $service;
        }
  }

}
