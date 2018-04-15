<?php

class Base  {

  protected $table_name = '';
  protected $columns = '';
  protected $primary_key = '';
  protected $columns_with_value = array();

  public function __construct(){

  }

// set tablename, primarykey name, name of all columns
  public function init($table_name){
    $this->setTableName($table_name);
    $this->primary_key = ModelHelper::setPrimaryKey($this->table_name);
    $this->columns_with_value = ModelHelper::setColumnsWithValue($this->table_name);
  }

//set columns value of table-row
  public function setValue($name, $value){
    $this->columns_with_value[$name] = $value;
  }

//get column value of table-row
  public function getValue($name){
      return $this->columns_with_value[$name];
  }

  //check if this table has column
  public function hasColumn($name){
    return array_key_exists($name, $this->columns_with_value);
  }

//get priamry key
  public function getPrimaryKey(){
    return $this->primary_key;
  }

//get table name
  public function getTableName($db = NULL){
    if($db){
      return TABLE_PREFIX.$this->table_name;
    }else{
    return $this->table_name;
  }
  }

//set table name
  public function setTableName($table_name){
    $this->table_name = $table_name;
  }

//returs columns with value
  public function getColumnsWithValue(){
    return $this->columns_with_value;
  }

//set the properties of columsn
  public function setProperties($array_properties){
    foreach($this->columns_with_value as $name => $value){
      $this->columns_with_value[$name] = $array_properties[$name];
    }
  }


}
