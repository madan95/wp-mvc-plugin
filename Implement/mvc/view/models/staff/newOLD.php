<?php
$registerType = ViewHelper::getRegisterType($request['registerType']);

$unique_id = $request['unique_id'];
$main_unique_id = $unique_id; //main form unique id to wrap whole fieldset at end

$is_node = $request['isNode'];

$table_name = 'staff';
$main_table_name = $table_name;

$fields = array(
  array('field_label'=>'Staff ID', 'field_name'=>'staff_id', 'field_type'=>'bigint(20)', 'field_hidden' => 'true'),
  array('field_label'=>'First Name', 'field_name'=>'first_name', 'field_type'=>'varchar(255)'),
  array('field_label'=>'Last Name', 'field_name'=>'last_name', 'field_type'=>'varchar(255)'),
  array('field_label'=>'Mobile Number', 'field_name'=>'mobile_number', 'field_type'=>'varchar(255)'),
  array('field_label'=>'Phone Number', 'field_name'=>'phone_number', 'field_type'=>'varchar(255)'),
  array('field_label'=>'Notes', 'field_name'=>'notes', 'field_type'=>'longtext')
);

$body = require(BASEPATH . '/Implement/mvc/view/general/register/'.$registerType.'.php');

return Organism::returnType($main_table_name, $body, $request['returnFieldSet'], $request['isNode'], $main_unique_id);


 ?>
