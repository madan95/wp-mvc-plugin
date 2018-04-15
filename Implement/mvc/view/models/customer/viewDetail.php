<?php
//request = id, table_name, parent_table_name, parent_id, ajax_action

$customer_parent_table_name = 'booking';

$customer_data =  array(
  'unique_id' => $request['unique_id'],
  'unique_table_name' => 'customer'.$request['unique_id'],
  'pk_id' => 'customer_id',
  'table_name' => 'customer',
  'table_columns' => array(
    array(
    'column_name' => 'Customer ID',
    'element_attributes' =>  array(
      'data-column-id'=> 'customer_id',
      'data-sortable' => 'true',
      'data-type' => 'numeric',
      'data-identifier'=> 'true'
    )
  ),
    array(
      'column_name' => 'Customer Address',
      'element_attributes' => array(
        'data-column-id'=> 'customer_location',
        'data-formatter' => 'pca-editable-node'
    )
  ),
  array(
    'column_name' => 'Customer Name',
    'element_attributes' => array(
      'data-column-id' => 'customer_name',
      'data-formatter' => 'pca-editable'
    )
),
array(
'column_name'=> 'Commands',
'element_attributes' => array(
  'data-column-id'=> 'remove',
  'data-sortable' => 'false',
  'data-formatter'=> 'remove',
  'data-parent-table-name' =>  $request['parent_table_name'],
  'data-parent-id' => $request['parent_id']
    )
  )
),
'buttons' => array(
  array(
    'button_name' => 'Create New Customer',
    'element_attributes' => array(
      'data-ajax_action' => 'createNew',
      'data-table_name' => 'customer',
      'data-parent_table_name' =>  $request['parent_table_name'],
      'data-parent_id' => $request['parent_id'],
      'class' => 'button-bootgrid-action button-bootgrid-action'
    )
  )
),
  'bootgrid_script' => array(
    'table_name' => 'customer',
    'bootgrid_settings' => array(
      'ajax' => 'true',
      'navigation' => '0',
      'sorting' => 'true',
    ),
    'post_return' => array(
      'table_name' => 'customer',
      'primary_key' => 'customer_id',
      'inital_id' => $request['id'],
      'sort' => array('customer_id'=> 'desc'),
      'ajax_action' => 'getGridData',
      'parent_table_name' => $customer_parent_table_name,
      'parent_id' => $request['parent_id']
    )
  )
);


if(isset($request['parent_table_name']) && isset($request['parent_id'])){
  $customer_data['select2'] = array(
    'select2_data_settings' => array(
        'parent_table_name'=> 'booking',
        'parent_id' => $request['parent_id'],
        'table_name' => 'customer',
        'column' => 'customer_name',
        'ajax_action' => 'select2'
    )
  );
}


$client_data = array(
  'unique_id' => $request['unique_id'].'1',
  'unique_table_name' => 'customer'.$request['unique_id'].'1',

  'pk_id' => 'client_id',
  'table_name' => 'client',
  'table_columns' => array(
    array(
    'column_name' => 'Client ID',
    'element_attributes' =>  array(
      'data-column-id'=> 'client_id',
      'data-sortable' => 'true',
      'data-type' => 'numeric',
      'data-identifier'=> 'true'
    )
  ),
    array(
      'column_name' => 'First Name',
      'element_attributes' => array(
        'data-column-id'=> 'first_name',
        'data-sortable' => 'true',
        'data-formatter' => 'pca-editable'
    )
  ),
  array(
    'column_name' => 'Last Name',
    'element_attributes' => array(
      'data-column-id'=> 'last_name',
      'data-sortable' => 'true',
      'data-formatter' => 'pca-editable'
  )
),
array(
  'column_name' => 'Mobile Number',
  'element_attributes' => array(
    'data-column-id'=> 'mobile_number',
    'data-sortable' => 'true',
    'data-formatter' => 'pca-editable'
)
),
array(
  'column_name' => 'Phone Number',
  'element_attributes' => array(
    'data-column-id'=> 'phone_number',
    'data-sortable' => 'true',
    'data-formatter' => 'pca-editable'
)
),
  array(
    'column_name' => 'Client Address',
    'element_attributes' => array(
      'data-column-id'=> 'client_location',
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
    'button_name' => 'Create New Client',
    'element_attributes' => array(
      'data-ajax_action' => 'createNew',
      'data-table_name' => 'client',
      'data-parent_id' =>  $request['id'],
      'data-parent_table_name' => 'customer',
      'class' => 'button-bootgrid-action button-bootgrid-action'.$request['unique_id'].'1',
      'data-booking_id' => isset($request['parent_id']) ? $request['parent_id'] :  ''

    )
  )
),
  'bootgrid_script' => array(
    'table_name' => 'client',
    'bootgrid_settings' => array(
      'ajax' => 'true',
      'navigation' => '0',
      'sorting' => 'true',
    ),
    'post_return' => array(
      'table_name' => 'client',
      'primary_key' => 'client_id',
      'sort' => array('client_id'=> 'desc'),
      'ajax_action' => 'getGridData',
      'parent_id' => $request['parent_id'],
      'booking_id' => $request['parent_id'],
      'parent_table_name' => 'customer',
      'parent_table_column' => 'customer_id'
    )
  )
);

Page::createBootgridTable($customer_data);
Page::createBootgridTable($client_data);
