<?php
/**
 * Created by PhpStorm.
 * User: madan
 * Date: 03/01/2018
 * Time: 10:12
 */

class database
{
    function __construct()
    {
        register_activation_hook( __FILE__, 'my_plugin_create_db' );
    }

    private static $dbBooking = array(
        array( 'table_name' => 'booking2'    ),
        array( 'field' => array( ' booking_id ',  ' int(20) ', ' NOT NULL AUTO_INCREMENT ')),
        array( 'field' => array(' booking_task_id ', ' int(20) ')),
        array( 'field' => array(' booking_start_date ', ' DATE ')),
        array( 'field' => array(' booking_due_date ', ' DATE ')),
        array( 'extra' => array(' FOREIGN KEY (booking_task_id) REFERENCES pca_task(task_id) ')),
        array('extra' => array(' PRIMARY KEY (booking_id) '))
    );

    public function createDatabase(){
        register_activation_hook( __FILE__, 'my_plugin_create_db' );
    }

    public function my_plugin_create_db(){
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();

        $table = "";
        $fields = [];
        $extras = [];
        foreach(database::$dbBooking as $item ){
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
        $table_name = $wpdb->prefix . $table;
        $sql = $this->create_table($fields, $extras, $table_name, $charset_collate);

        echo 'RUN RUN';
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
    }

    function create_table(array $fields, $extras,  $tableName, $charset_collate){
        $condition = $this->create_sql_condition($fields);
        $extras_condition = $this->create_sql_extra_condition($extras);
        $sql = "CREATE TABLE " . $tableName . " ( " . $condition . " , ". $extras_condition . " ) " . $charset_collate . " ; ";
        return $sql;
    }

    public function create_sql_extra_condition(array $pair){
        $condition = array();
        $glue = ' , ';
        foreach ($pair as $key => $value){
            $condition[] = "{$value}";
        }
        $condition = join($glue, $condition);
        return $condition;
    }

    public function create_sql_condition(array $pair){
        $condition = array();
        $glue = ' , ';
        foreach ($pair as $key => $value) {
            $condition[] = "{$key} {$value}";
        }
        $condition = join($glue, $condition);
        return $condition;
    }




}