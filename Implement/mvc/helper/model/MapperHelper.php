<?php
class MapperHelper{

  public function __construct(){

  }

//Maps a request with table_name and properties to appropriate MODEL/OBJECT
  public function mapRequestToObject($table_name, $properties=null){
    $model = ModelFactory::createModel($table_name);
    $model->setProperties($properties);
    return $model;
  }

}
