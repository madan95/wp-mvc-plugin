<?php
$db_product= array(
  array('table_name' => TABLE_PREFIX.'product'),
  array('field' => array('product_id', 'bigint(20)', 'NOT NULL AUTO_INCREMENT')),
  array('field' => array('product_name', 'varchar(255)')),
  array('field' => array('product_cost', 'varchar(255)')),
  array('extra' => array('PRIMARY KEY (product_id)')),
);
$db_location = array(
  array('table_name' => TABLE_PREFIX.'location'),
  array('field' => array('location_id', 'bigint(20)', 'NOT NULL AUTO_INCREMENT')),
  array('field' => array('location_name', 'varchar(255)')),
  array('field' => array('location_address', 'LONGTEXT')),
  array('extra' => array('PRIMARY KEY (location_id)')),
);


$db_customer2 = array(
  array('table_name' => TABLE_PREFIX.'customer'),
  array('field' => array('customer_id', 'bigint(20)', 'NOT NULL AUTO_INCREMENT')),
  array('field' => array('customer_name', 'varchar(255)')),
  array('extra' => array('PRIMARY KEY (customer_id)')),
  array('relate' => array('client', TABLE_PREFIX.'client'))
);

$db_client2 = array(
  array('table_name' => TABLE_PREFIX.'client'),
  array('field' => array('client_id', 'bigint(20)', 'NOT NULL AUTO_INCREMENT')),
  array('field' => array('customer_id', 'bigint(20)', 'NULL')),
  array('field' => array('first_name', 'varchar(255)')),
  array('field' => array('last_name', 'varchar(255)')),
  array('field' => array('mobile_number', 'varchar(255)')),
  array('field' => array('phone_number', 'varchar(255)')),
  array('field' => array('notes', 'LONGTEXT')),
  array('extra' => array('FOREIGN KEY (customer_id) REFERENCES '.TABLE_PREFIX.'customer(customer_id) ON DELETE CASCADE')),
  array('extra' => array('PRIMARY KEY (client_id)')),
  array('view' => array('customer_id', TABLE_PREFIX.'customer')),
  array('primary_key' => array('client_id', 'bigint(20)'))
);

$db_customer = array(
  'table_name' => TABLE_PREFIX.'customer',
  'field' => array(
    array('customer_id', 'bigint(20)', 'NOT NULL AUTO_INCREMENT'),
    array('customer_name', 'varchar(255)'),
    array('PRIMARY KEY (customer_id)')),
  'relate' => array('client', TABLE_PREFIX.'client')
);

$db_client = array(
  'table_name' => TABLE_PREFIX.'client',
  'field' => array(
     array('client_id', 'bigint(20)', 'NOT NULL AUTO_INCREMENT'),
    array('customer_id', 'bigint(20)', 'NULL'),
  array('first_name', 'varchar(255)'),
   array('last_name', 'varchar(255)'),
   array('mobile_number', 'varchar(255)'),
   array('phone_number', 'varchar(255)'),
  array('notes', 'LONGTEXT')
  ),
  'extra' => array(
    array('FOREIGN KEY (customer_id) REFERENCES '.TABLE_PREFIX.'customer(customer_id) ON DELETE CASCADE'),
    array('PRIMARY KEY (client_id)')
  ),
  'view' => array('customer_id', TABLE_PREFIX.'customer'),
  'primary_key' => array('client_id', 'bigint(20)')
);


$db_staff = array(
  array('table_name' => TABLE_PREFIX.'staff'),
  array('field' => array('staff_id', 'bigint(20)', 'NOT NULL AUTO_INCREMENT')),
  array('field' => array('first_name', 'varchar(255)')),
  array('field' => array('last_name', 'varchar(255)')),
  array('field' => array('mobile_number', 'varchar(255)')),
  array('field' => array('phone_number', 'varchar(255)')),
  array('field' => array('notes', 'LONGTEXT')),
  array('extra' => array('PRIMARY KEY (staff_id)'))
);
$db_group = array(
  array('table_name' => TABLE_PREFIX.'group'),
  array('field' => array('group_id', 'bigint(20)', 'NOT NULL AUTO_INCREMENT')),
  array('field' => array('group_name', 'varchar(255)')),
  array('extra' => array('PRIMARY KEY (group_id)')),
  array('relate' => array('groupstaff', TABLE_PREFIX.'groupstaff'))

);
$db_groupstaff = array(
  array('table_name' => TABLE_PREFIX.'groupstaff'),
  array('field' => array('group_staff_id', 'bigint(20)', 'NOT NULL AUTO_INCREMENT')),
  array('field' => array('group_id', 'bigint(20)', 'NULL')),
  array('field' => array('staff_id', 'bigint(20)', 'NULL')),
  array('extra' => array('FOREIGN KEY (group_id) REFERENCES '.TABLE_PREFIX.'group(group_id) ON DELETE CASCADE')),
  array('extra' => array('FOREIGN KEY (staff_id) REFERENCES '.TABLE_PREFIX.'staff(staff_id) ON DELETE CASCADE')),
  array('extra' => array('PRIMARY KEY (group_staff_id)')),
  array('view' => array('group_id', TABLE_PREFIX.'group')),
  array('view' => array('staff_id', TABLE_PREFIX.'staff'))
);
$db_booking = array(
   array( 'table_name' => TABLE_PREFIX.'booking'    ),
   array( 'field' => array( 'booking_id',  ' bigint(20) ', ' NOT NULL AUTO_INCREMENT ')),
   array( 'field' => array('start_date', 'DATE')),
   array( 'field' => array('due_date', 'DATE')),
   array('field' => array('customer_id', 'bigint(20)', 'NULL')),
   array('extra' => array('FOREIGN KEY (customer_id) REFERENCES '.TABLE_PREFIX.'customer(customer_id)  ON DELETE SET NULL')),
   array('extra' => array('PRIMARY KEY (booking_id) ')),
   array('view' => array('customer_id', TABLE_PREFIX.'customer')),
   array('relate' => array('customer', TABLE_PREFIX.'customer')),
   array('relate' => array('task', TABLE_PREFIX.'task'))

);
$db_task = array(
    array( 'table_name' => TABLE_PREFIX.'task'),
    array('field'=> array('task_id', 'bigint(20)', 'NOT NULL AUTO_INCREMENT')),
    array('field' => array('date_start', 'DATE')),
    array('field' => array('date_finish', 'DATE')),
    array('field' => array('description', 'LONGTEXT')),
    array('field' => array('product_id', 'bigint(20)', 'NULL')),
    array('field' => array('location_id', 'bigint(20)', 'NULL')),
    array('field' => array('group_id', 'bigint(20)', 'NULL')),
    array('field' => array('booking_id', 'bigint(20)', 'NULL')),
    array('extra' => array('FOREIGN KEY (booking_id) REFERENCES '.TABLE_PREFIX.'booking(booking_id) ON DELETE SET NULL')),
    array('extra' => array('FOREIGN KEY (group_id) REFERENCES '.TABLE_PREFIX.'group(group_id) ON DELETE SET NULL')),
    array('extra' => array('FOREIGN KEY (product_id) REFERENCES '.TABLE_PREFIX.'product(product_id)  ON DELETE SET NULL')),
    array('extra' => array('FOREIGN KEY (location_id) REFERENCES '.TABLE_PREFIX.'location(location_id) ON DELETE SET NULL')),
    array('extra' => array('PRIMARY KEY (task_id)')),
    array('view' => array('booking_id', TABLE_PREFIX.'booking')),
    array('view' => array('group_id', TABLE_PREFIX.'group')),
    array('view' => array('product_id', TABLE_PREFIX.'product')),
    array('view' => array('location_id', TABLE_PREFIX.'location'))
);
/*
function getDbTable($table_name){
  $table_view_value = [];
  $tables_array = [];
  array_push($tables_array,  $db_product, $db_location, $db_customer, $db_client, $db_staff, $db_group, $db_groupstaff, $db_task,  $db_booking);
  foreach($tables_array as $tableArray){
        $table = "";
        $fields = [];
        $extras = [];
  foreach($tableArray as $item ){
      foreach ($item as $key => $value){
          if($key == "table_name"){
            if($value == $table_name){

            }
          }
      }
  }
}
}
*/
