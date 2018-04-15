<?php
require_once (BASEPATH . '/core/mvc/model/BaseModel.php');

class ModelFactory{


    public static function getModel($table_name){
      $model = ucwords($table_name);
      if(file_exists(BASEPATH.'/Implement/mvc/model/' . $model . '.php')){
        include_once  (BASEPATH.'/Implement/mvc/model/' . $model . '.php');
      }
      if(class_exists($model)){
        $model = new $model();
        $model->init($table_name);
        return $model;
      }else{
        throw new Exception('Invalid Model Type Given');
      }
    }

//creates model using the table_name parameter and also initiailses it with it's attributes
  public static function createModel($table_name){
    $model = ucwords($table_name);
    if(file_exists(BASEPATH.'/Implement/mvc/model/' . $model . '.php')){
      include_once  (BASEPATH.'/Implement/mvc/model/' . $model . '.php');
    }
    if(class_exists($model)){
      $model = new $model();
      $model->init($table_name);
      return $model;
    }else{
      throw new Exception('Invalid Model Type Given');
    }
  }




  //creates model using the table_name parameter and also initiailses it with it's attributes
    public static function justCeateModel($table_name){
      $model = ucwords($table_name);
      if(file_exists(BASEPATH.'/Implement/mvc/model/' . $model . '.php')){
        include_once  (BASEPATH.'/Implement/mvc/model/' . $model . '.php');
      }
      if(class_exists($model)){
        $model = new $model();
        $model->setTableName = $table_name;

        return $model;
      }else{
        throw new Exception('Invalid Model Type Given');
      }
    }


//Creates Generic Model which can be used for any model by manually setting tableName on run time
  public static function createGenericModel(){
    $model = ucwords('genericmodel');
    if(file_exists(BASEPATH.'/Implement/mvc/model/' . $model . '.php')){
      include_once  (BASEPATH.'/Implement/mvc/model/' . $model . '.php');
    }
    if(class_exists($model)){
      $model = new $model();
      return $model;
    }
  }


  /*
    public static function mapArrayToModel($array_data,  $model){
      foreach($array_data as $key => $value){
        $model->setAllValue = $value;
      }
      return $model;
    }

    public static function build($table_name)
    {
      $model = ucwords($table_name);
      if(class_exists($model)){
        $model = new $model();
        $model->init($table_name);
        return $model();
      }else{
        throw new Exception('Invalid Model Type Given');
      }
    }
  */




}
