<?php
/**
 * Created by PhpStorm.
 * User: madan
 * Date: 19/01/2018
 * Time: 10:04
 */



//Print in the php error_log / php server for quick debugging
function console($data){
    ob_start();
    var_dump(' ++ Plugin Console +++');
    var_dump(' Start ');
    var_dump($data);
    var_dump(' End ');
    error_log(ob_get_clean(), 4);
}

function consoleData( $detail , $file_path, $data){
  ob_start();
  var_dump('');
  var_dump(' +++ Plugin Console +++');
  if($detail == ''){ }else{ var_dump(' - Detail => ' . $detail); }
  if($file_path == ''){ }else{ var_dump(' - File Path => ' . $file_path); }
  if($data == ''){ }else {
    var_dump(' Extra Data => [ ');
    var_dump( $data );
    var_dump(' ] ');
  }
  error_log(ob_get_clean(), 4);
}

function print_details(){
    console('TABLE _ PREFIX ==> ' . TABLE_PREFIX);
    console($_GET);
    console($_POST);
}


//Prints The data value in Console
function debug_to_console( $data ) {
    $output = $data;
    if ( is_array( $output ) )
        $output = implode( ',', $output);
    echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
}
