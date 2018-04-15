<?php

abstract class BaseModel  {

  protected $table_name = '';
  protected $columns = '';
  protected $primary_key = '';
  protected $db;

  protected $columns_with_value = '';

  public function __construct(){

  }

//Initialise The Model
  public function init($table_name){
    $table_name = TABLE_PREFIX.$table_name;
    global $wpdb;
    $this->db = $wpdb;

    $this->table_name = $table_name;
    $this->setColumns();
    $this->setPrimaryKey();
  }

  public function getTableName(){
    return $this->table_name;
  }

  public function setTableName($table_name){
    $this->table_name = TABLE_PREFIX.$table_name;
  }

  public function getPrimaryKey(){
    return $this->primary_key;
  }

  public function getColumns(){
    return $this->columns_with_value;
  }

  public function getValue($name){
    return $this->columns_with_value[$name];
  }

  public function setValue($name, $value){
    $this->columns_with_value[$name] = $value;
  }

  public function getColumnsWithValue(){
    return $this->columns_with_value;
  }



//Fill the columns in Model Class using latest database
  public function setColumns(){
    $this->db->get_row("SELECT * FROM `$this->table_name`");
    $this->columns = array();
    foreach($this->db->get_col_info('name') as $i => $name){
      $this->columns[$name] = $this->db->col_info[$i]->type;
      $this->columns_with_value[$name] = '';
    }
  }

  public function setColumnsFromArray(){
    $db_prefix = str_replace(TABLE_PREFIX, '', $this->table_name);
    require TABLE_VARIABLES;
    foreach(${"db_$db_prefix"}['fields'] as $field){
      $this->columns[$field['field_name']] = $field['field_type'];
    }
  }

//Set PrimaryKeyName using Database
  public function setPrimaryKey(){
    $row = $this->db->get_row("SHOW FIELDS FROM `$this->table_name` WHERE `Key` = 'PRI'");
    $this->primary_key = $row->Field;
    }

//Add/Insert Model to Database
  public function add($values){
    $insert_values = array();
    //set value in columns and stripslashes
    foreach($this->columns as $name => $type){
      $insert_values[$name] = stripslashes_deep($values[$name]);
    }
    if($this->db->insert($this->table_name, $insert_values)){
      console('Sucessfully Inserted Model to Database and New Id : '. $this->db->insert_id);
    }else{
      console('Inserting Model to Database Failed');
    }

  }

//saves the current model
  public function save(){
    $insert_values = array();
    //set value in columns and stripslashes
    foreach($this->columns_with_value as $name => $value){
      $insert_values[$name] = stripslashes_deep($value);
    }
    if($this->db->insert($this->table_name, $insert_values)){
      console('Sucessfully Inserted Model to Database and New Id : '. $this->db->insert_id);
      $this->columns_with_value[$this->primary_key] = $this->db->insert_id;
    }else{
      console('Inserting Model to Database Failed');
    }
  }

//Update New Values of Model To Database
  public function update($new_values){
    $update_values = array();
    //Set new Value to Model
    foreach($this->columns as $name => $type){
      $update_values[$name] = stripslashes_deep($new_values[$name]);
    }

    if($this->db->update($this->table_name, $update_values, array(
      $this->primary_key => $new_values[$this->primary_key]
    ))){
      console('New Value Sucessfully Updated in database');
    }else{
      console('Failed Updating New Value for this Model to Database');
    }
  }

//Get Row By Its Primary Key
  public function find($id){
    $sql = $this->db->prepare("SELECT * FROM `$this->table_name` WHERE `$this->primary_key` = '%s'", $id);
    $this->setProperties(Helper::stdObjToArray($this->db->get_row($sql)));
  }

//Remove/Delete Model From Database
  public function remove($id){
    $sql = $this->db->prepare("DELETE FROM '$this->table_name' WHERE '$this->primary_key' = '%s'", $id);
    if($this->db->query($sql)){
      console('Sucessfully Removed Model');
    }else{
      console('Failed Removing this Model');
    }
  }

//List everything from this Table
  public function list_all(){
    return $this->db->get_results("SELECT * FROM `$this->table_name`");
  }

//Use array of key value to populate model properties (need protected properties)
  public function setProperties($array_properties){
    foreach($this->columns_with_value as $name => $value){
      $this->columns_with_value[$name] = $array_properties[$name];
    }
  }

//use the $key_word and $column to find extact match row from the current table
  public function getMatch($key_word, $column){
  $sql = "SELECT * FROM `$this->table_name` WHERE `$column` = %d";
  $qry = $this->db->prepare($sql, $key_word);
  $array_std_obj_list =  $this->db->get_results($qry);
  $list_of_task_obj = array();
  foreach($array_std_obj_list as $key => $value){
    $list_of_task_obj[] = MapperHelper::mapRequestToObject(Helper::removeTablePrefix($this->table_name), Helper::stdObjToArray($value));
  }
  return $list_of_task_obj;
  }

//creates  query which selects rows that is simillar to $key_word
  public function select($key_word, $order_by, $order, $begin_row, $end_row) {
		$where_qry = $this->generate_where_query($key_word);
		$order_qry = $this->generate_order_query($order_by, $order);
		$sql = "SELECT * FROM `$this->table_name` $where_qry $order_qry LIMIT $begin_row, $end_row";
		return $this->db->get_results($sql);
	}

  //used by select method to generate where query using the $key_word
  private function generate_where_query($key_word) {
$qry = "";
if ($key_word != "") {
 $like_statements = array();
 foreach ($this->columns as $name => $type) {
   $like_statements[] = $this->db->prepare(" `$name` LIKE '%%%s%%'", $key_word);
 }
 $qry = " WHERE " . implode(" OR ", $like_statements);
}
return $qry;
}

//used by select method to generate order by query
private function generate_order_query($order_by, $order) {
 $qry = "";
if ($order_by != "") {
 $order = esc_sql($order);
 $order_by = esc_sql($order_by);
 $qry = " ORDER BY `$order_by` $order";
}
return $qry;
}




}
