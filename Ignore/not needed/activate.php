<?php
/**
 * Created by PhpStorm.
 * User: madan
 * Date: 22/12/2017
 * Time: 12:34
 */

include BASEPATH . '/core/model/Booking.php';

function createDatabase(){
    $table = Booking::getColumn();
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    $table_name = "";
    $array_fields = array();
    $qry = "";
    $tests ="";
    foreach ($table as $items){ // main array
                foreach($items as $name => $value) { // inside array of array of array
                    if ($name == 'table_name') {
                        $table_name = $value;
                    } else if($name == 'field') {
                     //   $qry .= $value;
                     //   $qry .= ' , ';
                        $tests = $name['field']." ".$name['type'];
                        array_push($array_fields, $tests);
                    }
                }

    }
    echo $tests;
    $qry = implode(' , ', $array_fields);
    $sql = "CREATE TABLE $table_name ( $qry )$charset_collate;";
    echo $sql;
    require_once (ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}