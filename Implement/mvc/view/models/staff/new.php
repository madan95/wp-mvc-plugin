<?php
$data = array(
  'table_name' => 'staff',
  'table_columns' => array(
    array(
      'column_name'=> 'Staff Id',
      'element_attributes' => array(
        'column_id'=> 'staff_id',
        'sortable' => 'true')
    ),
    array(
      'column_name'=> 'First Name',
      'element_attributes' => array(
        'column_id'=> 'first_name',
        'sortable' => 'true',
        'formatter'=>'pca-editable')
      ),
    array(
      'column_name'=> 'Last Name',
      'element_attributes' => array(
        'column_id'=> 'last_name',
        'sortable' => 'true',
        'formatter'=>'pca-editable')
      ),
    array('column_name'=> 'Mobile Number', 'column_id'=> 'mobile_number', 'data_type' => '', 'sortable' => 'true', 'formatter'=>'pca-editable'),
    array('column_name'=> 'Phone Number', 'column_id'=> 'phone_number', 'data_type' => '', 'sortable' => 'true', 'formatter'=>'pca-editable'),
    array('column_name'=> 'Commands', 'column_id'=> 'commands', 'data_type' => '', 'sortable' => 'false', 'formatter'=>'commands'),
  ),
  'buttons' => array(
    array('button_action_name'=>'createNew', 'button_name' => 'Create New Staff')
  )
);

ob_start();
TableView::bootgridTableCreator($data);
$body = ob_get_contents();
ob_end_clean();

return TableView::bootstrapWrapper(array( 'body' =>  $body , 'colClass' => 'col-md-12'));
