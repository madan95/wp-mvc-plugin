<?php
class GenericDAO{

  protected $db;
  protected $persistentClass = '';
  protected $db_table_name = '';
  protected $table_name = '';
  protected $primary_key = '';
  protected $columns_with_value = '';

  public function __construct($model_class = null){
    global $wpdb;
    $this->db = $wpdb;
    $this->persistentClass = $model_class;
    $this->table_name = $model_class;
    $this->db_table_name = TABLE_PREFIX.$model_class;
    $this->primary_key = DAOHelper::setPrimaryKey($this->persistentClass);
    $this->columns_with_value = DAOHelper::setColumnsWithValue($this->persistentClass);
  }

//find one by [pk_id]
  public function find($id){
    try{
      $column_data_array = $this->db->get_row($this->db->prepare(Query::singleSelectQuery($this->db_table_name, $this->primary_key), $id), 'ARRAY_A');
      return ModelMapper::singleModelMapper($this->persistentClass, $column_data_array);
    }catch(Exception $e){
      echo 'Fail Find , Rolling Back';
    }
  }

//find all from table
  public function findAll(){
    try{
      $array_of_model = $this->db->get_results(Query::selectAllQuery($this->db_table_name), "ARRAY_A");
      return ModelMapper::arrayModelMapper($this->persistentClass, $array_of_model);
    }catch(Exception $e){
      echo 'Fialed FindAll, Rolling Back';
    }
  }

//save the model to database
  public function persist($model){
    $insert_values = array();
    foreach($model->getColumnsWithValue() as $name => $value){
      $insert_values[$name] = stripslashes_deep($value);
    }
    try{
      $this->db->insert($this->db_table_name, $insert_values);
      return $this->db->insert_id;
    }catch(Exception $e){
      echo 'Failed Persist ';
    }
  }

//update the model in database
  public function update($model){
    try{
      if(is_object($model)){
        return $this->db->update($this->db_table_name, $model->getColumnsWithValue(), array($this->primary_key => $model->getValue($this->primary_key)));
      }else{
        return $this->db->update($this->db_table_name, array($model['column'] => $model['value']), array($this->primary_key => $model['id']));
      }
    }catch(Exception $e){
      echo 'Failed to Update Rolling BACK';
    }
  }

//delete the model in the database
  public function delete($model){
    try{
      $pk_id = DAOHelper::getPrimaryKeyFromModel($model);
      $this->db->delete($this->db_table_name, array($this->primary_key => $pk_id));
    }catch(Exception $e){
      echo 'Failed to Delete';
    }
  }



  public function getMatch($column, $key_word){
    $sql = $this->db->prepare(
      Query::querySelectWhere($this->db_table_name, $column),
       $key_word
     );
    $array_of_model = $this->db->get_results($sql, 'ARRAY_A');
    return ModelMapper::arrayModelMapper($this->persistentClass, $array_of_model);
  }



  public function getMatchOld($column, $key_word){
    $array_of_model = array();
    try{
      $sql  = "SELECT * FROM `$this->db_table_name` WHERE `$column` = %d";
      $qry = $this->db->prepare($sql, $key_word);
      $array_of_model = $this->db->get_results($qry, "ARRAY_A");
      //$array_of_model = $this->db->get_results("SELECT * FROM `$this->db_table_name` WHERE `$column` = `$key_word`", "ARRAY_A");
    }catch(Exception $e){
      echo 'Failed getMatch Query to Database';
    }
    $array_of_model_obj = array();
    foreach($array_of_model as $key => $value){
      $temp_model = ModelFactory::getModel($this->persistentClass);
      $temp_model->setProperties($value);
      array_push($array_of_model_obj, $temp_model);
    }

    return $array_of_model_obj;
  }


  public function getMatchValue($column, $key_word, $column_to_return){
    $array_of_model = array();
    try{
      $sql  = "SELECT `$column_to_return` FROM `$this->db_table_name` WHERE `$column` = %d";
      $qry = $this->db->prepare($sql, $key_word);
      $result =  $this->db->get_results($qry, 'ARRAY_N');
      return $result;
    }catch(Exception $e){
      echo 'Failed getMatch Query to Database';
    }
  }

  public function getAnyMatch($key_word){
    $where_qry = $this->where_query_generator($key_word);
    try{
      $array_of_model = $this->db->get_results("SELECT * FROM `$this->db_table_name` ".$where_qry, "ARRAY_A");
    }catch(Exception $e){
      echo 'Fialed to Get ANy Match, Rolling Back';
    }

    $array_of_model_obj = array();
    foreach($array_of_model as $key => $value){
      $temp_model = ModelFactory::getModel($this->persistentClass);
      $temp_model->setProperties($value);
      array_push($array_of_model_obj, $temp_model);
    }

    return $array_of_model_obj;
  }

  public function test(){
      $sql = 'SELECT * FROM `pca_dummy_task` INNER JOIN `pca_dummy_booking` ON  `pca_dummy_task`.`booking_id` = `pca_dummy_booking`.`booking_id` INNER JOIN `pca_dummy_customer` ON `pca_dummy_booking`.`customer_id` = `pca_dummy_customer`.`customer_id`';
        $array_of_model = $this->db->get_results($sql, 'ARRAY_A');
        foreach($array_of_model as $key => $value){
        $booking = ModelFactory::getModel('booking');
        $booking->setProperties($value);
      }
  }


  public function getBootGridData($request){
    $request['columns_with_value'] = $this->columns_with_value;
    $request['db_table_name'] = $this->db_table_name;
    $boot_grid_dao = DAOFactory::getBootgridDAO($request);
    $total =  $boot_grid_dao->get_count_total();
    $array_of_model = $boot_grid_dao->getGridDataSingleTable();

    $array_of_model_obj = ModelMapper::arrayModelMapper($this->persistentClass, $array_of_model);
    return array(
      'array_of_model_obj' => $array_of_model_obj,
      'total' => $total
    );
  }



  public function findGridSearch($request){
    $order_by = '';
    $order = '';
    $key_word = '';
    $default_rowCount = 10;
    $default_page = 1;

    if(isset($request['sort'])){
      foreach($request['sort'] as $name => $value){
        $order_by = $name;
        $order = $value;
      }
    }else{
      $order_by = $request['primary_key'];
      $order = $request['default_sort']; // ???
    }

    if(!empty($request['searchPhrase'])){
      $key_word = $request['searchPhrase'];
    }

    // number of row perpage and number of row to retrive strating from beging row
    $end_row = isset($request['rowCount']) ? $request['rowCount'] : $default_rowCount;

    $page = isset($request['current']) ? $request['current'] : $default_page; //current front end page

    $begin_row = ($page * $end_row)-$end_row; //row to start gettig data from

    $total;
    $data;
    if($request['parent_table_name']!=null){
     $total = $this->get_count_total($key_word, $request['parent_table_name'], $request['parent_id'] );
      $data = $this->select_condition_with_parent($key_word, $order_by, $order, $begin_row, $end_row, $request['parent_table_name'], $request['parent_id']);
    }else{
      $total = $this->get_count_total($key_word);
      $data = $this->select_condition($key_word, $order_by, $order, $begin_row, $end_row);
    }
    $data_array = array();
  /*  console($data);
    foreach($data as $key => $staff){
        $row_array = array();

        $row_array['staff_id'] = $staff->getValue('staff_id');
        $row_array['first_name'] = $staff->getValue('first_name');
        $row_array['last_name'] = $staff->getValue('last_name');
        $row_array['mobile_number'] = $staff->getValue('mobile_number');
        $row_array['phone_number'] = $staff->getValue('phone_number');

        array_push($data_array, $row_array);

    }
    $json_data = array(
      'current' => intval($request['current']),
      'rowCount' => $end_row,
      'total' => $total,
      'rows' => $data
    );
*/
    try{
      $array_of_model = $data;
    }catch(Exception $e){
      echo 'Fialed FindAll, Rolling Back';
    }

    $array_of_model_obj = array();
    foreach($array_of_model as $key => $value){
      $temp_model = ModelFactory::getModel($this->persistentClass);
      $temp_model->setProperties($value);
      array_push($array_of_model_obj, $temp_model);
    }

    return array('array_of_model_obj' => $array_of_model_obj, 'total' => $total);

  //  return $json_data;
  }


  public function get_count_total($key_word, $parent_table_name =null, $parent_table_id=null){
  $where_qry = $this->where_query_generator($key_word);
  $sql;
if($parent_table_name != null){
  $parent_table_primary_key = $parent_table_name.'_id';
  $parent_child_table_name = TABLE_PREFIX.$parent_table_name.$this->table_name;
  $sql_parent = " WHERE $this->primary_key IN ( SELECT `$this->primary_key` FROM `$parent_child_table_name` WHERE `$parent_table_primary_key` = $parent_table_id ) ";
  $sql = "SELECT COUNT(*) FROM `$this->db_table_name` $sql_parent ".$where_qry;
}else{
  $sql = "SELECT COUNT(*) FROM `$this->db_table_name` ".$where_qry;
}
  return $this->db->get_var($sql);
}

public function select_condition($key_word, $order_by, $order, $begin_row, $end_row){
    $where_qry = $this->where_query_generator($key_word);
    $order_qry = $this->order_query_generator($order_by, $order);
    if($end_row < 0){
      $sql = "SELECT * FROM `$this->db_table_name` $where_qry $order_qry";
    }else{

      $sql = "SELECT * FROM `$this->db_table_name` $where_qry $order_qry LIMIT  $begin_row, $end_row";
    }
    return $this->db->get_results($sql, 'ARRAY_A');
}
public function select_condition_with_parent($key_word, $order_by, $order, $begin_row, $end_row, $parent_table_name, $parent_table_id){
  $parent_table_name = $parent_table_name; // Parent Table Name [TASK]is-
  $parent_table_id = $parent_table_id; //PARENT TABLE ID [1234]
  $parent_table_primary_key = $parent_table_name.'_id'; //Parent Table PK Name [TASK_ID]

  $parent_child_table = $parent_table_name.$this->table_name; //Parent Chidl Table NAME [TASKSTAFF] ??? HOW TO DECIDE WHICH TABLE NAME GO FIRST OR LAST??
  $parent_child_table_name = TABLE_PREFIX.$parent_child_table; //PC (MIDDLE-MAN) Table Name Database [PREFIX_TASKSTAFF]
  $parent_db_table_name = TABLE_PREFIX.$parent_table_name; //Parent Table Name Database [PREFIX_TASK]

  $where_qry = $this->where_query_generator_parent($key_word);
  $order_qry = $this->order_query_generator($order_by, $order);

//  $sql_parent = "SELECT $this->primary_key FROM $this->db_table_name WHERE $this->primary_key IN ( SELECT `$this->primary_key` FROM `$parent_child_table_name` WHERE `$parent_table_primary_key` = $parent_table_id ) ";
  //$sql_parent = "SELECT * FROM $this->db_table_name INNER JOIN ( $parent_child_table_name on $parent_child_table_name.$this->primary_key=$this->db_table_name.$this->primary_key WHERE $parent_child_table_name.$parent_table_primary_key = $parent_table_id ) ";

//$sql;
//  if($end_row < 0){
//    $sql = "$sql_parent $where_qry $order_qry";
//  }else{
    //$sql = "SELECT * FROM $this->db_table_name IN ( $sql_parent ) $where_qry $order_qry LIMIT  $begin_row, $end_row";
//    $sql = "SELECT * FROM $this->db_table_name WHERE $this->primary_key IN ( $sql_parent ) OR $where_qry  ";

//  }
//  $sql = "SELECT * FROM $this->db_table_name WHERE $TSELECT * FROM $this->db_table_name WHERE $this->primary_key IN ( $sql_parent ) OR $where_qry  ";

//  $sql = "SELECT * FROM $this->db_table_name INNER JOIN $parent_child_table_name ON $this->db_table_name.$this->primary_key = $parent_child_table_name.$this->primary_key WHERE $parent_child_table_name.$this->primary_key = $parent_table_id";

//  $sql = "SELECT s.* FROM `$this->db_table_name` s INNER JOIN `$parent_child_table_name` ts ON ts.$this->primary_key = ts.$this->primary_key WHERE ts.$parent_table_primary_key = $parent_table_id";

//  $sql  = "SELECT s.$this->primary_key FROM $parent_child_table_name ts RIGHT JOIN $this->db_table_name s ON ts.$parent_table_primary_key = $parent_table_id";

  //$sql = "SELECT $this->db_table_name.* FROM $parent_child_table_name $parent_child_table INNER JOIN $this->db_table_name $this->db_table_name ON $parent_child_table.$this->primary_key = $this->db_table_name.$this->primary_key INNER JOIN $parent_db_table_name $parent_table_name ON  $parent_child_table.$parent_table_primary_key = $parent_table_name.$parent_table_primary_key WHERE $parent_table_name.$parent_table_primary_key = $parent_table_id ";
//  $sql = "SELECT $this->db_table_name.* SELECT $this->db_table_name.$this->primary_key FROM $parent_child_table_name $parent_child_table INNER JOIN $this->db_table_name $this->db_table_name ON $parent_child_table.$this->primary_key = $this->db_table_name.$this->primary_key INNER JOIN $parent_db_table_name $parent_table_name ON  $parent_child_table.$parent_table_primary_key = $parent_table_name.$parent_table_primary_key WHERE $parent_table_name.$parent_table_primary_key = $parent_table_id ";

  $sql = "SELECT * FROM $this->db_table_name WHERE EXISTS ( SELECT * FROM $parent_child_table_name WHERE $this->primary_key = $this->db_table_name.$this->primary_key AND $parent_table_primary_key = $parent_table_id ) $where_qry $order_qry LIMIT  $begin_row, $end_row";

  return $this->db->get_results($sql, 'ARRAY_A');

}

public function where_query_generator($key_word){
    $qry = "";
    if($key_word != ""){
        $like_statements = array();
        foreach ($this->columns_with_value as $name => $type){
            $like_statements[] = $this->db->prepare(" `$name` LIKE %s ", '%'.$key_word.'%');
        }
        $qry = " WHERE " .implode(" OR ",$like_statements);
    }
    return $qry;
}

public function where_query_generator_parent($key_word){
    $qry = "";
    if($key_word != ""){
        $like_statements = array();
        foreach ($this->columns_with_value as $name => $type){
            $like_statements[] = $this->db->prepare(" $this->db_table_name.$name LIKE %s ", '%'.$key_word.'%');
        }
        $qry = " HAVING " .implode(" OR ",$like_statements);
    }
    return $qry;
}

public function order_query_generator($order_by, $order){
    $qry ="";
    if($order_by != ""){
        $order = esc_sql($order);
        $order_by = esc_sql($order_by);
        $qry = " ORDER BY `$order_by` $order";
    }
    return $qry;
}

public function getRelatedModel($table_to_search){
  $column_to_search = $this->primary_key;
  $table1 = $this->db_table_name;
  $table2 = Helper::convertToTableName($table_to_search);
  $array_of_model = array();

  try{
    $sql = Query::joinLeft($table1, $table2, $column_to_search);
    $array_of_model = $this->db->get_results($sql, 'ARRAY_A');
  }catch(Exception $e){
    echo 'Failed LEft JOIng';
  }

  $array_of_model_obj = array();
  foreach($array_of_model as $key => $value){
    $temp_model = ModelFactory::getModel($this->persistentClass);
    $temp_model->setProperties($value);
    array_push($array_of_model_obj, $temp_model);
  }
  return $array_of_model_obj;
}

  public function transaction(){
    //beging transcation
    try{
      //insert/update query
      //commit
    }catch(Exception $e){
      //rollback
    }
  }

}
 ?>
