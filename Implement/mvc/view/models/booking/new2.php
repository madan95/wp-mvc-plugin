<?php
$registerType = ViewHelper::getRegisterType($request['registerType']);

$unique_id = $request['unique_id'];
$main_unique_id = $unique_id; //main form unique id to wrap whole fieldset at end

$is_node = $request['isNode'];

$table_name = 'booking';
$main_table_name = $table_name;

$fields = array(
 array('field_label'=> 'Booking ID', 'field_name'=>'booking_id',  'field_type'=>' bigint(20) '),
 array('field_label'=> 'Booking Location',  'field_name'=>'location_id', 'field_type'=>'bigint(20)', 'field_ability' => 'node', 'table_name'=> 'location'),
 array('field_label'=> 'Start Date', 'field_name'=>'start_date', 'field_type'=>'DATE'),
 array('field_label'=> 'Due Date', 'field_name'=>'due_date', 'field_type'=>'DATE'),
 array('field_label'=> 'Customer', 'field_name'=>'customer_id', 'field_type'=>'bigint(20)',  'field_ability' => 'node', 'table_name'=> 'customer')
);







$booking_body = require(BASEPATH . '/Implement/mvc/view/general/register/'.$registerType.'.php');

$task_body = ViewHelper::createFieldSetForOther('task', 'registerRow');

$cover_many = '<fieldset>'.$task_body.'</fieldset>';

$body = $booking_body.$cover_many;

return Organism::returnType($main_table_name, $body, $request['returnFieldSet'], $request['isNode'], $main_unique_id);

 ?>
