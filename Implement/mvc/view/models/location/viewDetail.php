<?php
if(isset($request['parent_table_name']) && isset($request['parent_id'])){
  $command_id = 'remove';
  $parent_table_name = $request['parent_table_name'];
  $parent_id = $request['parent_id'];
}else{
  $command_id = 'commands';
}
$data = array(
  'pk_id' => 'location_id',
  'parent_table_name' => $parent_table_name,
  'parent_id' => $parent_id,
  'table_name' => 'location',
  'table_columns' => array(
    array(
    'column_name' => 'Location ID',
    'element_attributes' =>  array(
      'data-column-id'=> 'location_id',
      'data-sortable' => 'true',
      'data-type' => 'numeric',
      'data-identifier'=> 'true'
    )
  ),
    array(
      'column_name' => 'Street Address',
      'element_attributes' => array(
        'data-column-id'=> 'street_address',
        'data-sortable' => 'true',
        'data-formatter' => 'pca-editable'
    )
  ),
  array(
    'column_name' => 'City',
    'element_attributes' => array(
      'data-column-id'=> 'city',
      'data-sortable' => 'true',
      'data-formatter' => 'pca-editable'
  )
),
array(
  'column_name' => 'Zip Code',
  'element_attributes' => array(
    'data-column-id'=> 'zip',
    'data-sortable' => 'true',
    'data-formatter' => 'pca-editable'
)
),
array(
  'column_name' => 'Country',
  'element_attributes' => array(
    'data-column-id'=> 'country',
    'data-sortable' => 'true',
    'data-formatter' => 'pca-editable'
)
),
array(
'column_name'=> 'Commands',
'element_attributes' => array(
  'data-column-id'=> $command_id,
  'data-sortable' => 'false',
  'data-formatter'=> $command_id,
  'data-parent-table-name' => $parent_table_name,
  'data-parent-id' => $parent_table_id)
)
),
'buttons' => array(
  array(
    'button_name' => 'Create New Location',
    'element_attributes' => array(
      'data-ajax_action' => 'createNew',
      'data-table_name' => 'location',
      'data-parent_table_name' => $parent_table_name,
      'data-parent_id' => $parent_id,
      'class' => 'button-bootgrid-action'
    )
  )
),
  'bootgrid_script' => array(
    'table_name' => 'location',
    'bootgrid_settings' => array(
      'ajax' => 'true',
      'navigation' => '0',
      'sorting' => 'true',
    ),
    'post_return' => array(
      'table_name' => 'location',
      'primary_key' => 'location_id',
      'sort' => array('location_id'=> 'desc'),
      'ajax_action' => 'getGridData',
      'parent_table_name' => $request['parent_table_name'],
      'parent_id' => $request['parent_id'],
      'inital_id' => $request['id']
    )
  )
);

if(isset($request['parent_table_name']) && isset($request['parent_id'])){
  $data['select2'] = array(
    'select2_data_settings' => array(
        'parent_table_name'=> $parent_table_name,
        'parent_id' => $parent_id,
        'table_name' => 'location',
        'column' => 'street_address',
        'ajax_action' => 'select2'
    )
  );
}

Page::createBootgridTable($data);
