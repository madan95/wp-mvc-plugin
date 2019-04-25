<?php
/**
 * Created by PhpStorm.
 * User: madan
 * Date: 06/12/2017
 * Time: 17:28
 */

echo '<h1> Hello this is Admin Menu Options page ';
echo '<br>';
echo '<br>';
echo '<br>';
/*
		global $wpdb;
        $dbName = $wpdb->dbname;
		$arrayName = array(
			new Location(),
			new Task()
		);
		foreach($arrayName as $tableObject){
			$table = strtolower(get_class($tableObject));
			$tableName = $wpdb->prefix . $table;
			$fields = $tableObject::getColumn();

		

        // check if the table exist
        if($wpdb->get_var("SHOW TABLES LIKE '$tableName'")!= $tableName){
            //if it doesn't exist create one
           $sql = create_table($fields, $tableName);
        }else{
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
					//then add new column (infuture check for datatype and dataname and columnName diffrence too...
					addNewColumn($tableName, $columnName, $dataType);
                }
            }
        }
    }*/
		

    ?>