<?php
/**
 * Created by PhpStorm.
 * User: madan
 * Date: 19/01/2018
 * Time: 16:17
 */


// Capabilitiy Name == Action Name _ Table Name
// In Future Capability
//  # Action Name = ajax_insert($table_name)
//  # Capability Name = add_booking  ::  (action = add ) (table = booking)
//  # Real Capability Name = array( 'ajax_insert' = > 'add');
//  # Check Capability Name = CapabilityName['action']+_+$request['table_name'];
// Capability Name _ Table Name == Action Name

//Match The Controller Action Name with the Action Name Part of Capability in Wordpress
// Capability Name in Wordpress ===== $action_to_capability['$controller_action_name'] + '_' + $table_name
$action_to_capability = array(
  'ajax_insert' => 'add',
  'lists' => 'list',
  'ajax_lists'  => 'list',
    'ajax_edit' => 'edit',
    'ajax_detail' => 'view_detail',
    'ajax_view' => 'view_detail'
);