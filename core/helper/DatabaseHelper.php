<?php

class DatabaseHelper{

    //check if table exist or not (true or false sent back)
    public static function hasTable($table_name){
        global $wpdb;
        return ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == NULL ? false : true);
    }

    //creates the name of the dublicateTableName using prefix set in index.php
    public static function getDublicateTableName($table_name){
        return TABLE_LOCKED.Helper::removeTablePrefix($table_name);
    }
}