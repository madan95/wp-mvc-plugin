<?php

class ModelMapper{

//maps single model
  public function singleModelMapper($model_name, $model_data){
    $model = ModelFactory::getModel($model_name);
    $model->setProperties($model_data);
    return $model;
  }

//maps array of model
  public function arrayModelMapper($model_name, $array_model_data){
    $array_of_model_obj = array();
    if(!empty($array_model_data)){
      foreach($array_model_data as $key => $value){
        $temp_model = ModelFactory::getModel($model_name);
        $temp_model->setProperties($value);
        array_push($array_of_model_obj, $temp_model);
      }
    }
    return $array_of_model_obj;
  }


}
