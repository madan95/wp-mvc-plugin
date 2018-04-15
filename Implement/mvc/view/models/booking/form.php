<?php


$booking_fields = array(
 array('field_label'=> 'Booking ID', 'field_name'=>'booking_id',  'field_type'=>' bigint(20) '),
 array('field_label'=> 'Booking Location',  'field_name'=>'location_id', 'field_type'=>'bigint(20)', 'field_ability' => 'node', 'table_name'=> 'location'),
 array('field_label'=> 'Start Date', 'field_name'=>'start_date', 'field_type'=>'DATE'),
 array('field_label'=> 'Due Date', 'field_name'=>'due_date', 'field_type'=>'DATE'),
 array('field_label'=> 'Customer', 'field_name'=>'customer_id', 'field_type'=>'bigint(20)',  'field_ability' => 'node', 'table_name'=> 'customer')
);

Organism::createInputField($booking_fields);
