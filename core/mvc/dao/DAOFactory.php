<?php

class DAOFactory {

  private static $_instance;

  public function __construct(){
  }

//Set Single Factory Instance
  public static function setFactory($f){
    self::$_instance = $f;
  }

//Get Single DAOFactory
  public static function getFactory(){
    if(!self::$_instance){
      self::$_instance = new self;
    }
    return self::$_instance;
  }

//include and create dao class of the table
  public static function createDAO($dao_name){
    $daoClass = $dao_name.'DAO';
    if(Helper::checkIfFileExists(BASEPATH.'/Implement/mvc/dao/'. Helper::convertToPascalCase($dao_name) . 'DAO.php')){
      return new $daoClass($dao_name);
    }else{
      console('This DAO doesn\'t exisit : '. Helper::convertToPascalCase($dao_name));
    }
  }

  public static function getBootgridDAO($request){
    return new BootGridDAO($request);
  }

}
