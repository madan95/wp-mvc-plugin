<?php
/**
 * Created by PhpStorm.
 * User: madan
 * Date: 06/12/2017
 * Time: 17:12
 */

include BASEPATH . '/core/model/Location.php';
include BASEPATH . '/core/model/Task2.php';
    function pcajob_activate()
    {       	
		global $wpdb;
        $dbName = $wpdb->dbname;
		$arrayName = array(
			new Location(),
			new Task2()
		);
		foreach($arrayName as $tableObject){
			$table = strtolower(get_class($tableObject));
			$tableName = $wpdb->prefix . $table;
			$fields = $tableObject::getColumn();
			

        // check if the table exist
        if($wpdb->get_var("SHOW TABLES LIKE '$tableName'")!= $tableName){
            //if it doesn't exist create one
           $sql = create_table($fields, $tableName);
        }

       /* else{
            //if exist check if column are same or if it needs to be altered (new fields ??)
            $columnNameArray = $fields;
            foreach ($columnNameArray as $key => $value) {
                  $columnName = $key;
                  $dataType = $value;
                    //preg_match("/\(([^\)]*)\)/", $value, $dataMaxValue);
                if(doesColumnExist($dbName, $tableName, $columnName)){
					//If the column matches the object value do nothing with that column
				}else{
                    //if the column doesn't match with the object value alter the column
					//then add new column (infuture check for datatype and dataname and columnName diffrence too....
					addNewColumn($tableName, $columnName, $dataType);
                }
            }
        }*/
    }
}
	
	function addNewColumn($tableName, $columnName, $dataType){
		global $wpdb;
		$sql = "ALTER TABLE " . $tableName . " ADD " . $columnName . " " . $dataType . "; ";
		$wpdb->query($sql);
	}
	
//Gets condition from array and attach sql cmd which is then returned
    function create_table(array $sqlArray, $tableName)
    {
		global $wpdb;
        $condition = create_sql_condition($sqlArray);
        $sql = "CREATE TABLE " . $tableName . " ( " . $condition . " );"; 
        $wpdb->query($sql);
    }

//Creates Condition from the key value array passed on, could change glue to make different sql statements
    function create_sql_condition(array $pair)
    {
        $condition = array();
        $glue = ' , ';
        foreach ($pair as $key => $value) {
            $condition[] = "{$key} {$value}";
        }
        $condition = join($glue, $condition);
        return $condition;
    }

// Checks if the column in the table already exist so no duplicate will occurs or overrides
function doesColumnExist($dbName, $tableName, $columnName/*, $dataType, $dataMaxValue*/){
    global $wpdb;
    $sql = "SELECT * FROM information_schema.COLUMNS WHERE
                          TABLE_SCHEMA = '$dbName' 
                          AND TABLE_NAME = '$tableName'
                          AND COLUMN_NAME = '$columnName'";
    if($wpdb->get_results($sql)){
        return true;
    }else{
        return false;
    }
}



/*
    public function update2($get, $model){
        $blueprint = $model->get_columns();
        $pk = $model->get_primary_key();
        $newValue = array();
        $tableName = $get['table'];
        echo '<br>';
        foreach($blueprint as $name => $type) {
            echo $name . " : " . $get[(string)$name] . '<br> ';
            if ((string)$name != $pk) {
                $newValue[(string)$name] = $get[(string)$name];
            }
        }
        $where = array();
        $where[$pk] = $get[$pk];

        $db = $this->db;
        return $db->update($tableName, $newValue, $where);
    }

    public function getList($tableName)
    {
        $db = $this->db;
        return $db->select($tableName);
    }

    public function edit2($get, $model){
           $db = $this->db;
           $colDetails = $db->select($get['table'], '*', null, ''.$get[table].'Id='.$get['id'], null, null);
           $view = new view();
           $view->editData($colDetails, $get['table']);
            return false;
    }
*/