<?php
/**
 * Created by PhpStorm.
 * User: madan
 * Date: 20/12/2017
 * Time: 10:02
 */

function data_type2html_type($type, $name, $value){
    switch ($type){
        // numeric
        case "bigint(20)":
        case "int":
        case "real":
        case "3":
        case "8":
      if($value==""){
        return "<input id='$name' type='number' name='$name' value='$value'/>";
      }else{
        return "<input id='primarykey' type='number' name='$name' value='$value'/>";
      }
        // date
        case "DATE":
        case "date":
        case "10":
        return "<input type='date' name='$name' value='$value'/>";

        //time
        case "time":
        case "11":
        return "<input type='time' name='$name' value='$value'/>";

        case "datetime":
        case "timestamp":
        case "7":
        case "12":
        return "<input type='text' name='$name' value='$value'/>";

        // long text
        case "blob":
        case "252":
        case "LONGTEXT":
        return "<textarea name='$name'>$value</textarea>";

        default:
            return "<input type='text' name='$name' value='" . htmlspecialchars($value, ENT_QUOTES) . "'/>";
    }
}

function get_input_data_type($sql_type){
  switch($sql_type){
    case "bigint(20)":
        return 'number';
    case "DATE":
        return 'date';
    default:
        return 'text';
  }
}
