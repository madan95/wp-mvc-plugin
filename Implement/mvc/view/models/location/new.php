<?php
$registerType = ViewHelper::getRegisterType($request['registerType']); //What Type of Register Template to use Single or Row (Tables)

$unique_id = $request['unique_id'];
$main_unique_id = $unique_id; //main form unique id to wrap whole fieldset at end

$is_node = $request['isNode']; //Need to check if node to send json or just echo out / save button ??

$table_name = 'location'; //current table name
$main_table_name = $table_name;
$fields = array(
  array('field_label'=>'Location ID', 'field_name'=>'location_id', 'field_type'=>'bigint(20)', 'field_hidden'=>'true'),
  array('field_label'=>'Location Name', 'field_name'=>'location_name', 'field_type'=>'varchar(255)'),
  array('field_label'=>'Location Address', 'field_name'=>'location_address', 'field_type'=>'LONGTEXT'),
); //Fields inside the fieldset



$body = require (BASEPATH . '/Implement/mvc/view/general/register/'.$registerType.'.php'); //get form body (fieldset)
//How to return the result of this page
return Organism::returnType($main_table_name, $body, $request['returnFieldSet'], $request['isNode'], $main_unique_id);
