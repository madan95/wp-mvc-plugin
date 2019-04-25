<?php
/**
 * Created by PhpStorm.
 * User: Madan
 * Date: 18/12/2017
 * Time: 1:44 AM
 */

class Database3{

    function __construct()
    {
    }



    public function select($tableName, $rows = '*', $join=null, $where = null, $order = null, $limit = null ){
        global $wpdb;
        $table = $wpdb->prefix. $tableName;
        //Query from variable passed to function
        $q = 'SELECT '.$rows.' FROM '.$table;
        if($join != null){
            $q .= ' JOIN '.$join;
        }
        if($where != null){
            $q .= ' WHERE ' .$where;
        }
        if($order != null){
            $q .= ' ORDER BY '.$order;
        }
        if($limit != null){
            $q .= ' LIMIT '.$limit;
        }

        return $wpdb->get_results($q);
    }

    public function insert($tableName, $params=array()){
        global $wpdb;
        $table = $wpdb->prefix. $tableName;
        $sql='INSERT INTO `'.$table.'` (`'.implode('`, `',array_keys($params)).'`) VALUES ("' . implode('", "', $params) . '")';
        $wpdb->query($sql);
    }

    public function delete($tableName, $where = null){
        global $wpdb;
        $table = $wpdb->prefix. $tableName;
            if($where!=null) {
                $delete = 'DELETE FROM ' . $table . ' WHERE ' . $where;
            }else{
              //  $delete = 'DROP TABLE .' .$table;
            }
        $wpdb->query($delete);
    }

    public function update($tableName, $params, $where){
        global $wpdb;
        $table = $wpdb->prefix. $tableName;
        echo $table;
        echo $where;
        print_r($params);

       // $args = array(); //hold all columns to be updated
      //  foreach ($params as $field=>$value){
      //      $args[]=$field. '="'.$value.'"'; //set each column and its value
//        $update = 'UPDATE '.$table.' SET '.implode(',', $args).' WHERE '.$where;
        $wpdb->update($table, $params, $where);
    }


}