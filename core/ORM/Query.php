<?php
// HELPS Build Query for wpdb operation
class Query{


//Create join Left Query
 function joinLeft($table1, $table2, $column_to_search, $select=null){
    $select = isset($select) ? $select : $table1.'.*';
    $sql = "SELECT $select FROM $table1 INNER JOIN $table2 ON $table1.$column_to_search = $table2.$column_to_search ";
    return $sql;
  }

  //find()
  function singleSelectQuery($table_name, $primary_key){
    $sql = "SELECT * FROM `$table_name` WHERE `$primary_key` = '%s'";
    return $sql;
  }

//findAll()
  function selectAllQuery($table_name){
    $sql = "SELECT * FROM `$table_name`";
    return $sql;
  }

  function querySelectWhere($table_name, $column){
    return "SELECT * FROM `$table_name` WHERE `$column` = %d";
  }

  function whereQueryGenerator($key_word, $columns_with_value){
    global $wpdb;
    $sql = '';
    if(!empty($key_word)){
      $like_statements = array();
      foreach($columns_with_value as $name => $type){
        $like_statements[] = $wpdb->prepare(" `$name` LIKE %s ", '%'.$key_word.'%');
      }
      $sql = ' WHERE ' . implode(' OR ', $like_statements);
    }
    return $sql;
  }

  function createCountQuery($table_name, $whereQuery){
    $sql = "SELECT COUNT(*) FROM `$table_name` " . $whereQuery;
    return $sql;
  }

  function orderQueryGenerator($order_by, $order){
    $sql = '';
    if($order_by != ''){
      $order = esc_sql($order);
      $order_by = esc_sql($order_by);
      $sql = " ORDER BY `$order_by` $order ";
    }
    return $sql;
  }

  function selectWithWhereQueryGenerator($table_name, $where_qry){
    return " SELECT * FROM `$table_name` " . $where_qry;
  }

  function selectWithLimitQueryGenerator($table_name, $where_qry, $begin_row, $end_row){
    return "SELECT * FROM `$table_name` $where_qry LIMIT $begin_row, $end_row";
  }


}

 ?>
