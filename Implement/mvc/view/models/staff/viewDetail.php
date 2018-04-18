<?php
$data = array(
  'unique_id' => $request['unique_id'],
  'pk_id' => 'staff_id',
  'table_name' => 'staff',
  'table_columns' => array(
    array(
    'column_name' => 'Staff ID',
    'element_attributes' =>  array(
      'data-column-id'=> 'staff_id',
      'data-sortable' => 'true',
      'data-type' => 'numeric',
      'data-identifier'=> 'true'
    )
  ),
  array(
    'column_name' => 'First Name',
    'element_attributes' => array(
      'data-column-id' => 'first_name',
      'data-sortable' => 'true'
    )
  )
),
'buttons' => array(
  'button' => array(
    'button_name' => 'Create New Staff',
    'element_attributes' => array(
      'data-ajax_action' => 'createNew',
      'data-table_name' => 'staff',
      'data-parent-id' => $request['parent_id'],
      'data-parent-table-name' => 'task',
      'class' => 'button-bootgrid-action'.$request['unique_id']
    )
  )
),
'bootgrid_script' => array(
  'table_name' => 'staff',
  'bootgrid_settings' => array(
    'ajax' => 'true',
    'navigation' => '0',
    'sorting' => 'true',
  ),
  'post_return' => array(
    'table_name' => 'staff',
    'primary_key' => 'staff_id',
    'sort' => array('staff_id'=> 'desc'),
    'ajax_action' => 'getGridData',
    'parent_id' => $request['parent_id'],
    'parent_table_name' => 'task',
    'parent_table_column' => 'task_id'
  )
)
);


if(isset($request['parent_table_name']) && isset($request['parent_id'])){
  $data['select2'] = array(
    'select2_data_settings' => array(
        'parent_table_name'=> $request['parent_table_name'],
        'parent_id' => $request['parent_id'],
        'table_name' => 'staff',
        'column' => 'display_name',
        'ajax_action' => 'select2'
    )
  );
}

Page::createBootgridTable($data);
