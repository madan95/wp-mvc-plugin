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
