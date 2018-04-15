<?php
$booking_data = array(
  'table_name' => 'booking',
  'table_columns' => array(
    array(
      'column_name'=> 'Booking Id',
      'element_attributes' => array(
        'data-column-id'=> 'booking_id',
        'data-sortable' => 'true',
        'data-type' => 'numeric',
        'data-identifier'=> 'true',
        'data-formatter' => 'pca-viewdetail-link'
      )
    ),
    array(
      'column_name'=> 'Start Date',
      'element_attributes' => array(
        'data-column-id'=> 'start_date',
        'data-sortable' => 'true',
        'data-formatter'=>'pca-editable')
      ),
    array(
      'column_name'=> 'Due Date',
      'element_attributes' => array(
        'data-column-id'=> 'due_date',
        'data-sortable' => 'true',
        'data-formatter'=>'pca-editable')
      ),
    array(
      'column_name'=> 'Customer ID',
      'element_attributes' => array(
        'data-column-id'=> 'customer_id',
        'data-sortable' => 'true',
        'data-formatter'=>'pca-editable')
      ),
    array(
      'column_name'=> 'Client ID',
      'element_attributes' => array(
        'data-column-id'=> 'client_id',
        'data-sortable' => 'true',
        'data-formatter'=>'pca-editable')
      ),
    array(
      'column_name'=> 'Commands',
      'element_attributes' => array(
        'data-column-id'=> 'commands',
        'data-sortable' => 'false',
        'data-formatter'=>'commands')
      ),
  ),
  'buttons' => array(
    array('button_name' => 'Create New Booking',
    'element_attributes' => array(
      'data-ajax_action'=>'createNew',
      'data-table_name' =>'booking',
      'class' => 'button-bootgrid-action')
    )
  ),
  'bootgrid_script' => array(
    'table_name' => 'booking',
    'bootgrid_settings' => array(
      'ajax' => 'true',
      'navigation' => '3',
      'sorting' => 'true',
    ),
    'post_return' => array(
      'table_name' => 'booking',
      'sort' => array('booking_id'=> 'desc'),
      'ajax_action' => 'getBootGridData'
    )
  )
);

Page::createBootgridTable($booking_data);
