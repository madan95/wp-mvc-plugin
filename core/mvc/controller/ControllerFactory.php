<?php

class ControllerFactory {
  public static function createController($controller_name){
    $controllerClass = $controller_name.'Controller';
    $serviceClass = $controller_name.'Service';
    $daoClass = $controller_name.'DAO';

    $isController = Helper::checkIfFileExists(BASEPATH.'/Implement/mvc/controller/'. $controller_name . 'Controller.php');
    $isService = Helper::checkIfFileExists(BASEPATH.'/Implement/mvc/service/'. $controller_name . 'Service.php');
    $isDao = Helper::checkIfFileExists(BASEPATH.'/Implement/mvc/dao/'. $controller_name . 'DAO.php');

    if($isController){
      $controller = new $controllerClass();
        if($isService){
            $service = new $serviceClass();
              if($isDao){
                    $dao = new $daoClass();
                    $service->setDAO($dao);
                    $controller->setService($service);
              }else{
                $controller->setService($service);
              }
        }
      return $controller;
    }
  }

}
