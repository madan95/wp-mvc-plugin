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
        'class' => 'button-bootgrid-action button-bootgrid-action'.$request['uniuqe_id']
      )
    )
  ),
  'bootgrid_script' => array(
    'table_name' => 'product',
    'bootgrid_settings' => array(
      'ajax' => 'true',
      'navigation' => '3',
      'sorting' => 'true'
    ),
    'post_return' => array(
      'table_name' => 'product',
      'sort' => array('product_id' => 'desc'),
      'ajax_action' => 'getBootGridData'
    )
  )
);

Page::createBootgridTable($product_data);
