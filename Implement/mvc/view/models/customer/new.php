<?php
$registerType = ViewHelper::getRegisterType($request['registerType']); //What Type of Register Template to use Single or Row (Tables)

$unique_id = $request['unique_id'];
$main_unique_id = $unique_id; //main form unique id to wrap whole fieldset at end

$is_node = $request['isNode'];

$table_name = 'customer';
$main_table_name = $table_name;


$fields = array(
  array('field_label'=>'Customer ID', 'field_name'=>'customer_id', 'field_type'=>'hidden', 'field_hidden'=>'true'),
  array('field_label'=>'Customer Name', 'field_name'=>'customer_name', 'field_type'=>'varchar(255)'),
  array('field_label'=>'Customer Location', 'field_name'=>'location_id', 'field_type'=>'bigint(20)', 'field_ability' => 'node', 'table_name'=> 'location')
);

$customer_body = require (BASEPATH . '/Implement/mvc/view/general/register/'.$registerType.'.php');
$client_body = ViewHelper::createFieldSetForOther('client', 'registerRow');

$body = $customer_body.$client_body;


return Organism::returnType($main_table_name, $body, $request['returnFieldSet'], $request['isNode'], $main_unique_id);
