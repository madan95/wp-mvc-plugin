<?php
class ModelHelper{

  public static function setPrimaryKey($db_prefix){
    require TABLE_VARIABLES;
    return ${"db_$db_prefix"}['primary_key']['field_name'];
  }

  public static function setColumnsWithValue($db_prefix){
    $columns_with_value = array();
    require TABLE_VARIABLES;
    foreach((array)${"db_$db_prefix"}['fields'] as $field){
      $columns_with_value[$field['field_name']] = null;
    }
    return $columns_with_value;
  }

}
