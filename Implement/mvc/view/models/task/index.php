<?php
$data = array(
  'table_name' => 'task',
  'table_columns' => array(
    array(
      'column_name' => 'Task Id',
      'element_attributes' => array(
        'data-column-id' => 'task_id',
        'data-sortable' => 'true',
        'data-type' => 'numeric',
        'data-identifier' => 'true'
      )
    ),
    array(
      'column_name' => 'Date Start',
      'element_attributes' => array(
        'data-column-id'=> 'date_start',
        'data-sortable' => 'true',
        'data-formatter' => 'pca-editable-node'
    )
  )
),
'buttons' => array(
  array('button_name' => 'Create New Task')
)
);
