<?php
$product_data = array(
  'table_name' => 'product',
  'table_columns' => array(
    array(
      'column_name' => 'Product Id',
      'element_attributes' => array(
        'data-column-id' => 'product_id',
        'data-sortable' => 'true',
        'data-type' => 'numeric',
        'data-identifier' => 'true'
      )
    ),
    array(
      'column_name' => 'Product Name',
      'element_attributes' => array(
        'data-column-id' => 'product_name',
        'data-sortable' => 'true',
        'data-formatter' => 'pca-editable'
      )
    ),
    array(
      'column_name' => 'Product Cost',
      'element_attributes' => array(
        'data-column-id' => 'product_cost',
        'data-sortable' => 'true',
        'data-formatter' => 'pca-editable'
      )
    )
  ),
  'buttons' => array(
    array(
      'button_name' => 'Create New Product',
      'element_attributes' => array(
        'data-ajax_action' => 'createNew',
        'data-table_name' => 'product',
        'data-parent_table_name' => $request['parent_table_name'],
        'data-parent_id' => $request['parent_id'],
        'class' => 'button-bootgrid-action button-bootgrid-action'.$request['uniuqe_id']
      )
    )
  ),
  'bootgrid_script' => array(
    'table_name' => 'product',
    'bootgrid_settings' => array(
      'ajax' => 'true',
      'navigation' => '0',
      'sorting' => 'true'
    ),
    'post_return' => array(
      'table_name' => 'product',
      'sort' => array('product_id' => 'desc'),
      'id' => $request['id'],
      'parent_table_name' => $request['parent_table_name'],
      'parent_id' => $request['parent_id'],
      'ajax_action' => 'getGridData'
    )
  )
);
$product_data['select2'] = array(
  'select2_data_settings' => array(
      'parent_table_name'=> 'task',
      'parent_id' => $request['parent_id'],
      'table_name' => 'product',
      'column' => 'product_name',
      'ajax_action' => 'select2'
  )
);
Page::createBootgridTable($product_data);
?>
