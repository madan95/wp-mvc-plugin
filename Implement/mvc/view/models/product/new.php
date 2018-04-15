<?php
$registerType = ViewHelper::getRegisterType($request['registerType']);

$unique_id = $request['unique_id'];
$main_unique_id = $unique_id; //main form unique id to wrap whole fieldset at end

$is_node = $request['isNode'];

$table_name = 'product';
$main_table_name = $table_name;

$fields = array(
  array('field_label'=>'Product ID', 'field_name'=>'product_id', 'field_type'=>'bigint(20)', 'field_hidden' => 'true'),
  array('field_label'=>'Product Name', 'field_name'=>'product_name', 'field_type'=>'varchar(255)'),
  array('field_label'=>'Product Cost', 'field_name'=>'product_cost', 'field_type'=>'decimal(14,4)')
);

$product_body = require(BASEPATH . '/Implement/mvc/view/general/register/'.$registerType.'.php');
$staff_body = ViewHelper::createFieldSetForOther('staff', 'registerRowWithNode');

$body = $product_body;

return Organism::returnType($main_table_name, $body, $request['returnFieldSet'], $request['isNode'], $main_unique_id);


 ?>
