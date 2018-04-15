<?php
//$db_table_prefix = 'voeguer_';

$db_tables = array(
    'location',
    'group',
    'staff',
    'groupstaff',
    'product',
    'productstaff',
    'customer',
    'client',
    'booking',
    'task',
    'taskstaff',
    'note',
    'bookingnotes',
    'customernotes',
    'clientnotes'
);


$db_task = array(
    'table_name' => TABLE_PREFIX.'task',
    'primary_key' => array('field_name'=>'task_id', 'field_type'=>'bigint(20)'),
    'fields' => array(
    array('field_name'=>'task_id', 'field_type'=>'bigint(20)', 'field_feature'=>'NOT NULL AUTO_INCREMENT'),
    array('field_name'=>'date_start', 'field_type'=>'DATE'),
    array('field_name'=>'date_finish', 'field_type'=>'DATE'),
    array('field_name'=>'description', 'field_type'=>'LONGTEXT'),
    array('field_name'=>'product_id', 'field_type'=>'bigint(20)', 'field_feature'=>'NULL'),
    array('field_name'=>'product_quantity', 'field_type'=>'bigint(20)'),
    array('field_name'=>'location_id', 'field_type'=>'bigint(20)', 'field_feature'=>'NULL'),
    array('field_name'=>'booking_id', 'field_type'=>'bigint(20)', 'field_feature'=>'NULL'),
    array('field_name'=>'status', 'field_type'=>'varchar(255)') //1 started, 2 on progress, 3 finished,
  ),
  'extra' => array(
    'FOREIGN KEY (booking_id) REFERENCES '.TABLE_PREFIX.'booking(booking_id) ON DELETE SET NULL',
    'FOREIGN KEY (product_id) REFERENCES '.TABLE_PREFIX.'product(product_id)  ON DELETE SET NULL',
    'FOREIGN KEY (location_id) REFERENCES '.TABLE_PREFIX.'location(location_id) ON DELETE SET NULL',
    'PRIMARY KEY (task_id)'
  )
);

$db_product = array(
  'table_name' => TABLE_PREFIX.'product',
  'primary_key' => array('field_name'=>'product_id', 'field_type' => 'bigint(20)'),
  'fields' => array(
    array('field_name' => 'product_id', 'field_type'=>'bigint(20)', 'field_feature' => 'NOT NULL AUTO_INCREMENT'),
    array('field_name' => 'product_name', 'field_type' => 'varchar(255)'),
    array('field_name' => 'product_cost', 'field_type' => 'decimal(14,4)')
    ),
  'extra' => array(
    'PRIMARY KEY (product_id)'
    )
);

$db_group = array(
  'table_name' => TABLE_PREFIX.'group',
  'primary_key' => array('field_name'=>'group_id', 'field_type'=>'bigint(20)'),
  'fields' => array(
    array('field_name'=>'group_id', 'field_type'=>'bigint(20)', 'field_feature'=>'NOT NULL AUTO_INCREMENT'),
    array('field_name'=>'group_name', 'field_type'=>'varchar(255)')
  ),
   'extra' => array(
     'PRIMARY KEY (group_id)'
   )
);



$db_location = array(
  'table_name' => TABLE_PREFIX.'location',
  'primary_key' => array('field_name'=>'location_id', 'field_type' => 'bigint(20)'),
  'fields' => array(
    array('field_name'=>'location_id', 'field_type'=>'bigint(20)', 'field_feature'=>'NOT NULL AUTO_INCREMENT'),
    array('field_name'=>'street_address', 'field_type'=>'varchar(255)', 'field_feature'=>' NULL'),
    array('field_name'=>'city', 'field_type'=>'varchar(255)'),
    array('field_name'=>'zip', 'field_type'=>'varchar(255)', 'field_feature'=>' NULL'),
    array('field_name'=>'country', 'field_type'=>'varchar(255)', ' NULL')
 ),
   'extra' => array(
     'PRIMARY KEY (location_id)'
   )
);

$db_customer = array(
  'table_name' => TABLE_PREFIX.'customer',
  'primary_key' => array('field_name'=>'customer_id', 'field_type'=>'bigint(20)'),
  'fields' => array(
    array('field_name'=>'customer_id', 'field_type'=>'bigint(20)', 'field_feature'=>'NOT NULL AUTO_INCREMENT'),
    array('field_name'=>'customer_name', 'field_type'=>'varchar(255)'),
    array('field_name'=>'location_id', 'field_type'=>'bigint(20)', 'field_feature'=>'NULL')
  ),
  'extra' => array(
    'PRIMARY KEY (customer_id)',
    'FOREIGN KEY (location_id) REFERENCES '.TABLE_PREFIX.'location(location_id) ON DELETE SET NULL'
  )
);

$db_client = array(
  'table_name' => TABLE_PREFIX.'client',
  'primary_key' => array('field_name'=>'client_id', 'bigint(20)'),
  'fields' => array(
     array('field_name'=>'client_id', 'field_type'=>'bigint(20)', 'field_feature'=>'NOT NULL AUTO_INCREMENT'),
     array('field_name'=>'customer_id','field_type'=> 'bigint(20)', 'field_feature'=>'NULL'),
     array('field_name'=>'location_id', 'field_type'=> 'bigint(20)', 'field_feature'=>'NULL'),
     array('field_name'=>'first_name', 'field_type'=>'varchar(255)'),
     array('field_name'=>'last_name', 'field_type'=>'varchar(255)'),
     array('field_name'=>'mobile_number', 'field_type'=>'varchar(255)'),
     array('field_name'=>'phone_number', 'field_type'=>'varchar(255)')
     ),
  'extra' => array(
    'FOREIGN KEY (customer_id) REFERENCES '.TABLE_PREFIX.'customer(customer_id) ON DELETE CASCADE',
    'FOREIGN KEY (location_id) REFERENCES '.TABLE_PREFIX.'location(location_id) ON DELETE SET NULL',
    'PRIMARY KEY (client_id)'
  )
);


$db_booking = array(
   'table_name' => TABLE_PREFIX.'booking',
   'primary_key' => array('field_name'=>'booking_id', 'field_type'=>'bigint(20)'),
   'fields' => array(
    array( 'field_name'=>'booking_id',  'field_type'=>' bigint(20) ',  'field_feature'=>'NOT NULL AUTO_INCREMENT'),
    array('field_name'=>'location_id', 'field_type'=> 'bigint(20)', 'field_feature'=>'NULL'),
    array('field_name'=>'start_date', 'field_type'=>'DATE'),
    array('field_name'=>'due_date', 'field_type'=>'DATE'),
    array('field_name'=>'customer_id', 'field_type'=>'bigint(20)',  'field_feature'=>'NULL'),
    array('field_name'=>'client_id', 'field_type'=>'bigint(20)', 'field_feature'=>'NULL')
 ),
 'extra' => array(
    'FOREIGN KEY (client_id) REFERENCES '.TABLE_PREFIX.'client(client_id) ON DELETE SET NULL',
    'FOREIGN KEY (customer_id) REFERENCES '.TABLE_PREFIX.'customer(customer_id)  ON DELETE SET NULL',
    'FOREIGN KEY (location_id) REFERENCES '.TABLE_PREFIX.'location(location_id) ON DELETE SET NULL',
    'PRIMARY KEY (booking_id) '
 )
);




/****************************staff**********************************/


$db_staff = array(
  'table_name' => TABLE_PREFIX.'staff',
  'primary_key' => array( 'field_name' => 'staff_id',  'field_type' => 'bigint(20)' ),
  'fields' => array(
    array('field_name' =>'staff_id', 'field_type' => 'bigint(20)', 'field_feature' =>'NOT NULL AUTO_INCREMENT'),
    array('field_name' =>'first_name', 'field_type' => 'varchar(255)'),
    array('field_name' =>'last_name', 'field_type' => 'varchar(255)'),
    array('field_name' =>'mobile_number', 'field_type' => 'varchar(255)'),
    array('field_name' =>'phone_number', 'field_type' => 'varchar(255)')
      ),
  'extra' => array(
    'PRIMARY KEY (staff_id)'
  ),
);

$db_taskstaff = array(
  'table_name' => TABLE_PREFIX.'taskstaff',
  'primary_key' => array('field_name' => 'taskstaff_id', 'field_type' => 'bigint(20)'),
  'fields' => array(
    array('field_name' => 'taskstaff_id', 'field_type' => 'bigint(20)', 'field_feature' => 'NOT NULL AUTO_INCREMENT'),
    array('field_name' => 'task_id',  'field_type' => 'bigint(20)' , 'field_feature'=>'NULL'),
    array('field_name' => 'staff_id',  'field_type' => 'bigint(20)' , 'field_feature'=>'NULL')
  ),
  'extra' => array(
    'PRIMARY KEY (taskstaff_id)',
    'FOREIGN KEY (task_id) REFERENCES '.TABLE_PREFIX.'task(task_id) ON DELETE CASCADE',
    'FOREIGN KEY (staff_id) REFERENCES '.TABLE_PREFIX.'staff(staff_id) ON DELETE CASCADE'
  )
);

$db_productstaff = array(
  'table_name' => TABLE_PREFIX.'productstaff',
  'primary_key' => array('field_name'=>'productstaff_id', 'field_type'=>'bigint(20)'),
  'fields' => array(
    array('field_name'=>'productstaff_id', 'field_type'=>'bigint(20)', 'field_feature'=>'NOT NULL AUTO_INCREMENT'),
    array('field_name'=>'product_id', 'field_type'=>'bigint(20)', 'field_feature'=>'NULL'),
    array('field_name'=>'staff_id', 'field_type'=>'bigint(20)', 'field_feature'=>'NULL')
  ),
  'extra' => array(
    'FOREIGN KEY (product_id) REFERENCES '.TABLE_PREFIX.'product(product_id) ON DELETE CASCADE',
    'FOREIGN KEY (staff_id) REFERENCES '.TABLE_PREFIX.'staff(staff_id) ON DELETE CASCADE',
    'PRIMARY KEY (productstaff_id)'
  )
);

$db_groupstaff = array(
  'table_name' => TABLE_PREFIX.'groupstaff',
  'primary_key' => array('field_name'=>'groupstaff_id', 'field_type'=>'bigint(20)'),
  'fields' => array(
    array('field_name'=>'groupstaff_id', 'field_type'=>'bigint(20)', 'field_feature'=>'NOT NULL AUTO_INCREMENT'),
    array('field_name'=>'group_id', 'field_type'=>'bigint(20)', 'field_feature'=>'NULL'),
    array('field_name'=>'staff_id', 'field_type'=>'bigint(20)', 'field_feature'=>'NULL')
  ),
  'extra' => array(
    'FOREIGN KEY (group_id) REFERENCES '.TABLE_PREFIX.'group(group_id) ON DELETE CASCADE',
    'FOREIGN KEY (staff_id) REFERENCES '.TABLE_PREFIX.'staff(staff_id) ON DELETE CASCADE',
    'PRIMARY KEY (groupstaff_id)'
  )
);



/******************************note********************************/

$db_note = array(
  'table_name' => TABLE_PREFIX.'note',
  'primary_key' => array('field_name'=>'notes_id', 'field_type'=>'bigint(20)'),
  'fields' => array(
    array('field_name'=>'note_id', 'field_type'=>'bigint(20)', 'field_feature'=>'NOT NULL AUTO_INCREMENT'),
    array('field_name'=>'note', 'field_type'=>'LONGTEXT'),
    array('field_name'=>'staff_id', 'field_type'=>'bigint(20)', 'field_feature'=>'NULL'),
    array('field_name'=>'timestamp', 'field_type'=>'timestamp', 'field_feature'=>'NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')
  ),
  'extra' => array(
    'FOREIGN KEY (staff_id) REFERENCES '.TABLE_PREFIX.'staff(staff_id) ON DELETE SET NULL',
    'PRIMARY KEY (note_id) '
  )
);

$db_bookingnotes = array(
  'table_name'=> TABLE_PREFIX.'bookingnotes',
  'primary_key' => array('field_name' => 'bookingnotes_id', 'field_type' => 'bigint(20)'),
  'fields' => array(
    array('field_name'=>'bookingnotes_id', 'field_type'=>'bigint(20)', 'field_feature'=>'NOT NULL AUTO_INCREMENT'),
    array('field_name'=>'booking_id', 'field_type'=>'bigint(20)', 'field_feature'=>'NULL'),
    array('field_name'=>'note_id', 'field_type'=>'bigint(20)', 'field_feature'=>'NULL' )
  ),
  'extra' => array(
    'FOREIGN KEY (booking_id) REFERENCES '.TABLE_PREFIX.'booking(booking_id) ON DELETE CASCADE',
    'FOREIGN KEY (note_id) REFERENCES '.TABLE_PREFIX.'note(note_id) ON DELETE CASCADE',
    'PRIMARY KEY (bookingnotes_id) '
  )
);

$db_customernotes = array(
  'table_name'=> TABLE_PREFIX.'customernotes',
  'primary_key' => array('field_name' => 'customernotes_id', 'field_type' => 'bigint(20)'),
  'fields' => array(
    array('field_name'=>'customernotes_id', 'field_type'=>'bigint(20)', 'field_feature'=>'NOT NULL AUTO_INCREMENT'),
    array('field_name'=>'customer_id', 'field_type'=>'bigint(20)', 'field_feature'=>'NULL'),
    array('field_name'=>'note_id', 'field_type'=>'bigint(20)', 'field_feature'=>'NULL' )
  ),
  'extra' => array(
    'FOREIGN KEY (customer_id) REFERENCES '.TABLE_PREFIX.'customer(customer_id) ON DELETE CASCADE',
    'FOREIGN KEY (note_id) REFERENCES '.TABLE_PREFIX.'note(note_id) ON DELETE CASCADE',
    'PRIMARY KEY (customernotes_id) '
  )
);

$db_clientnotes = array(
  'table_name'=> TABLE_PREFIX.'clientnotes',
  'primary_key' => array('field_name' => 'clientnotes_id', 'field_type' => 'bigint(20)'),
  'fields' => array(
    array('field_name'=>'clientnotes_id', 'field_type'=>'bigint(20)', 'field_feature'=>'NOT NULL AUTO_INCREMENT'),
    array('field_name'=>'client_id', 'field_type'=>'bigint(20)', 'field_feature'=>'NULL'),
    array('field_name'=>'note_id', 'field_type'=>'bigint(20)', 'field_feature'=>'NULL' )
  ),
  'extra' => array(
    'FOREIGN KEY (client_id) REFERENCES '.TABLE_PREFIX.'client(client_id) ON DELETE CASCADE',
    'FOREIGN KEY (note_id) REFERENCES '.TABLE_PREFIX.'note(note_id) ON DELETE CASCADE',
    'PRIMARY KEY (clientnotes_id) '
  )
);
