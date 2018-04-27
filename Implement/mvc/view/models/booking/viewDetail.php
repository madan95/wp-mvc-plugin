<?php
$booking_data = array(
  'unique_id' => $request['unique_id'],
  'unique_table_name' => 'booking'.$request['unique_id'],
  'pk_id' => 'booking_id',
  'table_name' => 'booking',
  'table_columns' => array(
    array(
    'column_name' => 'Booking ID',
    'element_attributes' =>  array(
      'data-column-id'=> 'booking_id',
      'data-sortable' => 'true',
      'data-type' => 'numeric',
      'data-identifier'=> 'true'
    )
  ),
    array(
      'column_name' => 'Booking Address',
      'element_attributes' => array(
        'data-column-id'=> 'booking_location',
        'data-formatter' => 'pca-editable-node'
    )
  ),
  array(
    'column_name' => 'Start Date',
    'element_attributes' => array(
      'data-column-id' => 'start_date',
      'data-formatter' => 'pca-editable-date',
      'data-type' => 'date'
    )
  ),
  array(
    'column_name' => 'Due Date',
    'element_attributes' => array(
      'data-column-id' => 'due_date',
      'data-formatter' => 'pca-editable-date',
      'data-type' => 'date'
    )
  ),
  array(
    'column_name' => 'Booking Customer Name',
    'element_attributes' => array(
      'data-column-id' => 'booking_customer',
      'data-formatter' => 'pca-editable-node'
    )
  )
),
  'bootgrid_script' => array(
    'table_name' => 'booking',
    'bootgrid_settings' => array(
      'ajax' => 'true',
      'navigation' => '0',
      'sorting' => 'true',
    ),
    'post_return' => array(
      'table_name' => 'booking',
      'primary_key' => 'booking_id',
      'sort' => array('booking_id'=> 'desc'),
      'ajax_action' => 'getGridData',
      'id' => $request['id'],
      'inital_id' => $request['id']
    )
  )
);



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
'buttons' => array(
  'button' => array(
    'button_name' => 'Create New Task',
    'element_attributes' => array(
      'data-ajax_action' => 'createNew',
      'data-table_name' => 'task',
      'data-parent_id' => $request['id'],
      'data-parent_table_name' => 'booking',
      'class' => 'button-bootgrid-action button-bootgrid-action'.$request['unique_id'].'1'
    )
  ),
  'button2' => array(
    'button_name' => 'Snap Shot Order',
    'element_attributes' => array(
      'data-ajax_aciton' => 'snapshot_order',
      'data-table_name' => 'booking',
      'data-table_id' => $request['id'],
        'class' => 'ajax_action'
    )
  )
),
'extra' => array(
  'total' => array(
    'element_attributes' => array(
      'data-use' => 'find_total_cost',
      'data-table_name' => 'task',
      'class' => 'refresh product_total_cost total_cost'.$request['unique_id'].'1',
      'data-boot_grid_table' => 'task'.$request['unique_id'].'1',
      'data-ajax_action' => 'getTotalPrice',
      'data-booking_id' => $request['id']
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
      'ajax_action' => 'getGridData',
      'booking_id' => $request['id'],
      'parent_id' => $request['id'],
      'parent_table_name' => 'booking',
      'parent_table_column' => 'booking_id'
    )
  )
);
//echo 'happy';

//echo View::loadTwig()->render('viewdetail.html.twig', array('content' => 'jesus is way'));

Page::createBootgridTable($booking_data);
Page::createBootgridTable($task_data);
