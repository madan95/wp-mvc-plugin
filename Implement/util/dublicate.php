<?php

class dublicate{

    protected $db;

    public function __construct()
    {
        global $wpdb;
        $this->db = $wpdb;
    }

    //create dublicate table
    public function dublicateTable($table_name){
            $dublicate_table_name = DatabaseHelper::getDublicateTableName($table_name);
            if(!(DatabaseHelper::hasTable($dublicate_table_name))){
                $this->db->query("CREATE TABLE `$dublicate_table_name` LIKE `$table_name`");
            }
    }

        //create dublicateTable for array of tables
    public function dublicateTables($tables_name){
        foreach ($tables_name as $key => $table_name){
            $this->dublicateTable(TABLE_PREFIX.$table_name);
        }
    }

}

?>