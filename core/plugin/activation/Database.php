<?php
/**
 * Created by PhpStorm.
 * User: madan
 * Date: 03/01/2018
 * Time: 11:37
 */

/* initially creates the database for use*/

class Database{

    private $db;

    public function __construct()
    {
      global $wpdb;
      $this->db = $wpdb;
    }

    public function createDatabase(){
      $tables = array();
      require TABLE_VARIABLES;
      foreach($db_tables as $table_name){
        array_push($tables, ${"db_$table_name"});
      }
      $charset_collate = $this->db->get_charset_collate();
      foreach($tables as $table){
        $table_name = '';
        $fields = [];
        $extras = [];

        $table_name = $table['table_name'];
        foreach($table['fields'] as $field){
          $fields[$field['field_name']] = $field['field_type'].' '.$field['field_feature'];
        }

        $sql = $this->create_table($fields, $table['extra'], $table_name, $charset_collate);

        require_once( ABSPATH. '/wp-admin/includes/upgrade.php');
        dbDelta($sql);
      }

    }

    //Create Table in Database  initial

    function create_table(array $fields, $extras,  $tableName, $charset_collate){
        $condition = $this->create_sql_condition($fields);
        $extras_condition = $this->create_sql_extra_condition($extras);
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

}
