<?php
$task_data = array(
  'unique_id' => $request['unique_id'].'1',
  'unique_table_name' => 'task'.$request['unique_id'],
  'pk_id' => 'task_id',
  'table_name' => 'task',
  'table_columns' => array(
    array(
    'column_name' => 'Task ID',
    'element_attributes' =>  array(
      'data-column-id'=> 'task_id',
      'data-sortable' => 'true',
      'data-type' => 'numeric',
      'data-identifier'=> 'true',
      'data-formatter' => 'pca-viewdetail-link'

    )
  ),
    array(
      'column_name' => 'Date Start',
      'element_attributes' => array(
        'data-column-id'=> 'date_start',
        'data-sortable' => 'true',
        'data-formatter' => 'pca-editable-date'
    )
  ),
  array(
    'column_name' => 'Date Finish',
    'element_attributes' => array(
      'data-column-id' => 'date_finish',
      'data-sortable' => 'true',
      'data-formatter' => 'pca-editable-date'
    )
  ),
  array(
    'column_name' => 'Product ',
    'element_attributes' => array(
      'data-column-id'=> 'task_product',
      'data-sortable' => 'true',
      'data-formatter' => 'pca-editable-node'
      )
  ),
  array(
    'column_name' => 'Product Cost',
    'element_attributes' => array(
      'data-column-id' => 'product_cost',
      'data-formatter' => 'pca-class-with-column-id'
    )
  ),
  array(
    'column_name' => 'Product Quantity',
    'element_attributes' => array(
      'data-column-id' => 'product_quantity',
      'data-formatter' => 'pca-editable'
    )
  ),
  array(
    'column_name' => 'Total Cost of Task',
    'element_attributes' => array(
      'data-column-id' => 'total_task_cost'
    )
  ),
  array(
    'column_name' => 'Staffs',
    'element_attributes' => array(
      'data-column-id' => 'task_staffs',
      'data-sortable' => 'false',
      'data-formatter' => 'pca-editable-node'
    )
  ),
  array(
    'column_name'=> 'Commands',
    'element_attributes' => array(
      'data-column-id'=> 'commands',
      'data-sortable' => 'false',
      'data-formatter'=>'commands'
    )
  )
),
  'bootgrid_script' => array(
    'table_name' => 'task',
    'bootgrid_settings' => array(
      'ajax' => 'true',
      'navigation' => '0',
      'sorting' => 'true',
    ),
    'post_return' => array(
      'table_name' => 'task',
      'primary_key' => 'task_id',
      'sort' => array('task_id'=> 'desc'),
      'ajax_action' => 'viewTaskOfCurrentUser',
      'user_id' => $current_user_id
    )
  )
);

Page::createBootgridTable($task_data);
