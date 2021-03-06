<?php
$registerType = ViewHelper::getRegisterType($request['registerType']); //What Type of Register Template to use Single or Row (Tables)

$unique_id = $request['unique_id'];
$main_unique_id = $unique_id;

$is_node = $request['isNode'];

$table_name = 'client';
$main_table_name = $table_name;

$fields = array(
  array('field_label'=>'Client Id', 'field_name'=>'client_id', 'field_type'=>'bigint(20)', 'field_hidden'=>'true'),
  array('field_label'=>'First Name', 'field_name'=>'first_name', 'field_type'=>'varchar(255)'),
  array('field_label'=>'Last Name', 'field_name'=>'last_name', 'field_type'=>'varchar(255)'),
  array('field_label'=>'Mobile Number', 'field_name'=>'mobile_number', 'field_type'=>'varchar(255)'),
  array('field_label'=>'Phone Number', 'field_name'=>'phone_number', 'field_type'=>'varchar(255)'),
  array('field_label'=>'Notes', 'field_name'=>'notes', 'field_type'=> 'LONGTEXT'),
  array('field_label'=>'Customer Location', 'field_name'=>'location_id', 'field_type'=>'bigint(20)', 'field_ability' => 'node', 'table_name'=> 'location')
);


$client_body = require (BASEPATH . '/Implement/mvc/view/general/register/'.$registerType.'.php');
//$location_body = ViewHelper::createFieldSetForOther('location', 'registerSingle');

$body = $client_body;//.$location_body;

return Organism::returnType($main_table_name, $body, $request['returnFieldSet'], $request['isNode'], $main_unique_id);
