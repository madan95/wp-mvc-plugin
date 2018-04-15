<?php
class DAOHelper{

//helps find pk of table for DAO
  public static function setPrimaryKey($db_prefix){
    require TABLE_VARIABLES;
    return ${"db_$db_prefix"}['primary_key']['field_name'];
  }

//sets key/value column field in DAO of table
  public static function setColumnsWithValue($db_prefix){
    $columns_with_value = array();
    require TABLE_VARIABLES;
    foreach((array)${"db_$db_prefix"}['fields'] as $field){
      $columns_with_value[$field['field_name']] = '';
    }
    return $columns_with_value;
  }

//return pk from model obj or array
  public static function getPrimaryKeyFromModel($model){
    if(is_object($model)){
      return $model->getValue($model->getPrimaryKey());
    }else{
      return $model['id'];
    }
  }

}
