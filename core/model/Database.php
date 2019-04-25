<?php
/**
 * Created by PhpStorm.
 * User: madan
 * Date: 03/01/2018
 * Time: 11:37
 */

/* initially creates the database for use*/

class Database{

    public function __construct()
    {
    }

    //Create Table in Database  initial
    function createDatabase(){
        $tables = array();
        require TABLE_VARIABLES;
        foreach ($db_tables as $table_name){
            array_push($tables, ${"db_$table_name"});
        }
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
        foreach($tables as $item){
            $table = "";
            $fields = [];
            $extras = [];
            $table = $item['table_name'];
            foreach ($item['fields'] as $field){
                $fields[$field[0]] = $field[1]." ".$field[2];
            }
            if($item['extra']){
                foreach ($item['extra'] as $extra){
                    $extras[] = $extra[0];
                }
            }
            $sql = $this->create_table($fields, $extras, $table, $charset_collate);
            require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
            dbDelta( $sql );
        }
    }

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
