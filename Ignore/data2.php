<?php
/**
 * Created by PhpStorm.
 * User: madan
 * Date: 03/01/2018
 * Time: 11:37
 */

/* initially creates the database for use*/


function my_plugin_create_db(){
  $tables = [];
  include BASEPATH . '/core/model/variables.php';
  array_push($tables,  $db_product, $db_location, $db_customer, $db_client, $db_staff, $db_group, $db_groupstaff, $db_booking, $db_task);
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    foreach($tables as $tableArray){
          $table = "";
          $fields = [];
          $extras = [];
    foreach($tableArray as $item ){
        foreach ($item as $key => $value){
            if($key == "table_name"){
                $table = $value;
            }
            if($key == "field"){
                $fields[$value[0]] = $value[1]." ".$value[2];
            }
            if($key == "extra"){
              $extras[] = $value[0];
            }
        }
    }
        $sql = create_table($fields, $extras, $table, $charset_collate);
        require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
  }
}

function create_table(array $fields, $extras,  $tableName, $charset_collate){
    $condition = create_sql_condition($fields);
    $extras_condition = create_sql_extra_condition($extras);
    if($extras_condition){
    $sql = "CREATE TABLE " . $tableName . " ( " . $condition . " , ". $extras_condition . " ) " . $charset_collate . " ; ";
  }else{
    $sql = "CREATE TABLE " . $tableName . " ( " . $condition . " ) " . $charset_collate . " ; ";
  }
    return $sql;
}

function create_sql_extra_condition(array $pair){
    $condition = array();
    $glue = ' , ';
    foreach ($pair as $key => $value){
        $condition[] = "{$value}";
    }
    $condition = join($glue, $condition);
    return $condition;
}

function create_sql_condition(array $pair){
    $condition = array();
    $glue = ' , ';
    foreach ($pair as $key => $value) {
        $condition[] = "{$key} {$value}";
    }
    $condition = join($glue, $condition);
    return $condition;
}
