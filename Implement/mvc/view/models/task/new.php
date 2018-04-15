<?php
$registerType = ViewHelper::getRegisterType($request['registerType']);

$unique_id = $request['unique_id'];
$main_unique_id = $unique_id; //main form unique id to wrap whole fieldset at end

$is_node = $request['isNode'];

$table_name = 'task';
$main_table_name = $table_name;

$fields = array(
array('field_label'=> 'Task Id', 'field_name'=>'task_id', 'field_type'=>'bigint(20)', 'field_feature'=>'NOT NULL AUTO_INCREMENT'),
array('field_label'=> 'Date Start', 'field_name'=>'date_start', 'field_type'=>'DATE'),
array('field_label'=> 'Date Finish', 'field_name'=>'date_finish', 'field_type'=>'DATE'),
array('field_label'=> 'Description', 'field_name'=>'description', 'field_type'=>'LONGTEXT'),
array('field_label'=> 'Product', 'field_name'=>'product_id', 'field_type'=>'bigint(20)', 'field_ability' => 'node', 'table_name'=> 'product'),
array('field_label'=> 'Product Quantity', 'field_name'=>'product_quantity', 'field_type'=>'bigint(20)'),
array('field_label'=>'Product Location', 'field_name'=>'location_id', 'field_type'=>'bigint(20)', 'field_ability' => 'node', 'table_name'=> 'location')
);

$task_body = require(BASEPATH . '/Implement/mvc/view/general/register/'.$registerType.'.php');
console('THIS IS THE BEGINING');
console($task_body);
$staff_body = ViewHelper::createFieldSetForOther('staff', 'registerRowWithNode');
$body = $task_body.$staff_body;


return Organism::returnType($main_table_name, $body, $request['returnFieldSet'], $request['isNode'], $main_unique_id);


 ?>
