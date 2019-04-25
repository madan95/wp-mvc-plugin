<?php
$db_table_prefix = 'peach22_';

$db_tables = array(
    'product',
    'location',
    'customer',
    'client',
    'staff',
    'group',
    'groupstaff',
    'booking',
    'task'
);

//table form == normal form group field
//child_table == add more option/ tab
//fk_table == add new or use existing one (durpal node like)

//task[1][product]->1or2 task[1][location]->2  and task[2][product]->1 .... product and location also drupal like nodes (fk_table)

//Once Whole Page is Saved Task's Created , Booking with Customer and Then BookingID put on Task fk table

// Child_table ==> Add More / tab
// FK_TABLE ==> Create New or Select Existing one (NODES)

//location->product->staff->group->groupstaff->customer->client->booking->task
$db_create_group_staff= array(
   'group'=> array('table_name'=>'group','id'=>'group_id','fk'=> array('task', 'groupstaff')),
   'staff' => array('table_name'=>'staff','id'=>'staff_id','fk'=> array('groupstaff')),
   'groupstaff'=>array('table_name'=>'groupstaff','id'=>'groupstaff')
);

$db_relationships = array(
  'group' => array('child' => array('groupstaff', 'task')),
  'staff' => array('child' => array('groupstaff') ),
  'groupstaff' => array('fk' => array('group', 'staff')),
  'task' => array('fk' => array('product', 'location', 'booking', 'group'))
);

//$db_many_to_many = array(

//);

$db_create_booking =  array(
     'booking' =>  array(
         array(
        'table' => array(
          'table_name' =>'booking',
          'type' => 'normal',
          'fields_to_show' =>  array(
              array('field_name'=>'start_date', 'field_type'=>'DATE'),
              array('field_name'=>'due_date', 'field_type'=>'DATE'),
          )
        ),
        'fk_table' => array(
            array(
                'table' => array('table_name'=>'customer', 'type' => 'node', 'main_parent' => 'booking' ,
                'fields_to_show' => array(
                     array('field_name'=>'customer_name', 'field_type'=>'varchar(255)')
                 )),
                'child_table' => array(
                    array(
                        'table' => array('table_name' =>'client', 'type' => 'tab', 'display' => 'false'),
                    )
                )
            )
        ),
        'child_table' => array(
        array(
            'table' =>  array('table_name'=>'task', 'type' => 'tab', 'display' => 'true',
             'fields_to_show' => array(
              array('field_name'=>'description', 'field_type'=>'LONGTEXT'),
              array('field_name'=>'date_start', 'field_type'=>'DATE'),
              array('field_name'=>'date_finish', 'field_type'=>'DATE')
            )),
            'fk_table' => array(
                array(
                    'table' => array('table_name'=>'product', 'type' => 'node', 'main_parent' => 'booking')
                ),
                array(
                    'table' => array('table_name'=>'location', 'type' => 'node', 'main_parent' => 'booking')
                ),
             array(
                    'table' => array('table_name'=>'group', 'type' => 'node', 'main_parent' => 'booking'),
                    'child_table' => array(
                        array(
                            'table' => array('table_name'=>'staff', 'type'=> 'tab', 'display' => 'false')
                        )
                    )
                )
            /*       array(
                  'table' => array('table_name' => 'group' => 'node', 'main_parent' => 'booking'),
                  'child_table' => array(
                    array(
                      'table' => array(
                        'table_name' => 'staff', 'type' => 'none', 'main_parent' => 'booking'
                      )
                    )
                  )
                                  )*/
            )
        )
    )
       )
     ),
    'booking2' =>  array(
        'fields_to_show' => array(
            array('field_name'=>'start_date', 'field_type'=>'DATE'),
            array('field_name'=>'due_date', 'field_type'=>'DATE'),
        )
    ),
  /*  'customer' => array(
        'fields_to_show' => array(
            array('field_name'=>'customer_name', 'field_type'=>'varchar(255)')
        ),
        'child_table' => array(
          array(
            'table' => array('table_name' => 'client', 'type' => 'tab', 'display' => 'true')
          )
        )
    )*/
    'customer' => array(
      array(
        'table' => array(
          'table_name'=>'customer',
         'type'=>'normal',
         'fields_to_show' => array(
              array('field_name'=>'customer_name', 'field_type'=>'varchar(255)')

          )),
        'child_table' => array(
          array(
            'table' => array('table_name' => 'client', 'type' => 'tab', 'display' => 'true' ,
             'fields_to_show' => array(
                      array('field_name'=>'first_name', 'field_type'=>'varchar(255)'),
                      array('field_name'=>'last_name', 'field_type'=>'varchar(255)'),
                      array('field_name'=>'phone_number', 'field_type'=>'varchar(255)'),
                      array('field_name'=>'notes', 'field_type'=> 'LONGTEXT')

                  )
                )
          )
        )
      )
    ),
    'client' => array(
      array(
        'table' => array(
          'table_name' => 'client',
          'type' => 'tab',
          'fields_to_show' => array(
            array('field_name'=>'first_name', 'field_type'=>'varchar(255)'),
            array('field_name'=>'last_name', 'field_type'=>'varchar(255)'),
            array('field_name'=>'phone_number', 'field_type'=>'varchar(255)'),
            array('field_name'=>'notes', 'field_type'=> 'LONGTEXT')
          )
        )
      )

    ),
   'task' => array(
      array(
        'table' => array(
          'table_name' => 'task',
          'type' => 'normal',
          'fields_to_show' => array(
            array('field_name'=>'description', 'field_type'=>'LONGTEXT'),
            array('field_name'=>'date_start', 'field_type'=>'DATE'),
            array('field_name'=>'date_finish', 'field_type'=>'DATE')
          )
        ),
        'fk_table' => array(
            array(
                'table' => array('table_name'=>'product', 'type' => 'node', 'main_parent' => 'booking')
            ),
            array(
                'table' => array('table_name'=>'location', 'type' => 'node', 'main_parent' => 'booking')
            ),
            array(
                'table' => array('table_name'=>'group', 'type' => 'node', 'main_parent' => 'booking'),
                'child_table' => array(
                    array(
                        'table' => array('table_name'=>'staff', 'type'=> 'tab', 'display' => 'false')
                    )
                )
            )
        )
      )
    ),
  /*  'task' => array(
      array(
        'table' => array(
          'table_name' => 'task',
          'type' => 'tab',
          'fields_to_show' => array(
            array('field_name'=>'description', 'field_type'=>'LONGTEXT')
          )
        ),
        'child_table' => array(
          array(
            'table' => array('table_name' => 'product', 'type'=> 'node', 'main_parent' => 'booking')
          ),
          array(
            'table' => array('table_name' => 'location', 'type'=> 'node', 'main_parent' => 'booking')
          )
        )
      )
    ),*/
    'product' => array(
      array(
        'table' => array(
          'table_name' => 'product',
          'type' => 'normal',
          'fields_to_show' => array(
              array('field_name' => 'product_name', 'field_type'=>'varchar(255)')
          )
        )
      )
    ),
    'location' => array(
      array(
        'table' => array(
          'table_name' => 'location',
          'type' => 'normal',
          'fields_to_show' => array(
              array('field_name' => 'location_name', 'field_type'=>'varchar(255)')
          )
        )
      )
    ),
    'group' => array(
      array(
        'table' => array(
          'table_name'=>'group',
          'type'=>'normal',
          'fields_to_show' => array(
               array('field_name'=>'group_name', 'field_type'=>'varchar(255)')
           ),
           'manytomany' => 'staff'
         ),
        'child_table' => array(
          array(
            'table' => array('table_name' => 'staff', 'type' => 'tab', 'display' => 'true',
             'fields_to_show' => array(
                      array('field_name'=>'first_name', 'field_type'=>'varchar(255)')
                  )
                )
          )
        )
      )
    ),
    'staff' => array(
      array(
        'table' => array(
          'type' => 'normal',
          'table_name' =>'staff',
          'fields_to_show' => array(
            array('field_name' => 'first_name', 'field_type'=>'varchar(255)')
          )
        )
      )
    )
);















$db_product = array(
  'table_name' => TABLE_PREFIX.'product',
  'primary_key' => array('product_id', 'bigint(20)'),
  'fields' => array(
    array('product_id', 'bigint(20)', 'NOT NULL AUTO_INCREMENT'),
    array('product_name', 'varchar(255)'),
    array('product_cost', 'varchar(255)')
  ),
  'extra' => array(
    array('PRIMARY KEY (product_id)')
  )
);

$db_location = array(
  'table_name' => TABLE_PREFIX.'location',
  'primary_key' => array('location_id', 'bigint(20)'),
  'fields' => array(
    array('location_id', 'bigint(20)', 'NOT NULL AUTO_INCREMENT'),
    array('location_name', 'varchar(255)'),
    array('location_address', 'LONGTEXT'),
 ),
   'extra' => array(
     array('PRIMARY KEY (location_id)')
   )
);

$db_customer = array(
  'table_name' => TABLE_PREFIX.'customer',
  'primary_key' => array('customer_id', 'bigint(20)'),
  'fields' => array(
    array('customer_id', 'bigint(20)', 'NOT NULL AUTO_INCREMENT'),
    array('customer_name', 'varchar(255)')
  ),
  'extra' => array(
    array('PRIMARY KEY (customer_id)')
  ),
  'relate' => array(
    array('pk'=>'client_id', 'table_name'=>TABLE_PREFIX.'client')
  )
);

$db_client = array(
  'table_name' => TABLE_PREFIX.'client',
  'primary_key' => array('client_id', 'bigint(20)'),
  'fields' => array(
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
  'view' => array(
    array('pk'=>'customer_id', 'table_name'=>TABLE_PREFIX.'customer')
  )
);

$db_staff = array(
  'table_name' => TABLE_PREFIX.'staff',
  'primary_key' => array('staff_id', 'bigint(20)'),
  'fields' => array(
        array('staff_id', 'bigint(20)', 'NOT NULL AUTO_INCREMENT'),
        array('first_name', 'varchar(255)'),
        array('last_name', 'varchar(255)'),
        array('mobile_number', 'varchar(255)'),
        array('phone_number', 'varchar(255)'),
        array('notes', 'LONGTEXT')
 ),
  'extra' => array(
    array('PRIMARY KEY (staff_id)')
  ),
    'relate' => array(
        array('pk'=>'group_staff_id', 'table_name'=>TABLE_PREFIX.'groupstaff')
    )
);

$db_group = array(
  'table_name' => TABLE_PREFIX.'group',
  'primary_key' => array('group_id', 'bigint(20)'),
  'fields' => array(
    array('group_id', 'bigint(20)', 'NOT NULL AUTO_INCREMENT'),
    array('group_name', 'varchar(255)')
),
   'extra' => array(
     array('PRIMARY KEY (group_id)')
   ),
   'relate' => array(
     array('pk'=>'group_staff_id', TABLE_PREFIX.'groupstaff')
   ),
   'manytomany' => array('child' => 'staff', 'table' => 'groupstaff')
);

$db_groupstaff = array(
  'table_name' => TABLE_PREFIX.'groupstaff',
  'primary_key' => array('group_staff_id', 'bigint(20)'),
  'fields' => array(
  array('group_staff_id', 'bigint(20)', 'NOT NULL AUTO_INCREMENT'),
  array('group_id', 'bigint(20)', 'NULL'),
  array('staff_id', 'bigint(20)', 'NULL')
),
'extra' => array(
  array('FOREIGN KEY (group_id) REFERENCES '.TABLE_PREFIX.'group(group_id) ON DELETE CASCADE'),
  array('FOREIGN KEY (staff_id) REFERENCES '.TABLE_PREFIX.'staff(staff_id) ON DELETE CASCADE'),
  array('PRIMARY KEY (group_staff_id)')
),
'view' => array(
   array('pk'=>'group_id', 'table_name'=>TABLE_PREFIX.'group'),
   array('pk'=>'staff_id', 'table_name'=>TABLE_PREFIX.'staff')
 )
);

$db_booking = array(
   'table_name' => TABLE_PREFIX.'booking',
   'primary_key' => array('booking_id', 'bigint(20)'),
   'fields' => array(
    array( 'booking_id',  ' bigint(20) ', ' NOT NULL AUTO_INCREMENT '),
    array('start_date', 'DATE'),
    array('due_date', 'DATE'),
    array('customer_id', 'bigint(20)', 'NULL')
 ),
 'extra' => array(
    array('FOREIGN KEY (customer_id) REFERENCES '.TABLE_PREFIX.'customer(customer_id)  ON DELETE SET NULL'),
    array('PRIMARY KEY (booking_id) ')
 ),
 'view' => array(
   array('pk'=>'customer_id', 'table_name'=>TABLE_PREFIX.'customer')
 ),
 'relate' => array(
    array('hr_table'=>'task', 'table_name'=> TABLE_PREFIX.'task', 'pk' => 'task_id', 'display'=>'task_id')
)
);

$db_task = array(
    'table_name' => TABLE_PREFIX.'task',
    'primary_key' => array('task_id', 'bigint(20)'),
    'fields' => array(
    array('task_id', 'bigint(20)', 'NOT NULL AUTO_INCREMENT'),
    array('date_start', 'DATE'),
    array('date_finish', 'DATE'),
    array('description', 'LONGTEXT'),
    array('product_id', 'bigint(20)', 'NULL'),
    array('location_id', 'bigint(20)', 'NULL'),
    array('group_id', 'bigint(20)', 'NULL'),
    array('booking_id', 'bigint(20)', 'NULL')
  ),
  'extra' => array(
    array('FOREIGN KEY (booking_id) REFERENCES '.TABLE_PREFIX.'booking(booking_id) ON DELETE SET NULL'),
    array('FOREIGN KEY (group_id) REFERENCES '.TABLE_PREFIX.'group(group_id) ON DELETE SET NULL'),
    array('FOREIGN KEY (product_id) REFERENCES '.TABLE_PREFIX.'product(product_id)  ON DELETE SET NULL'),
    array('FOREIGN KEY (location_id) REFERENCES '.TABLE_PREFIX.'location(location_id) ON DELETE SET NULL'),
    array('PRIMARY KEY (task_id)')
  ),
  'view' => array(
    array('pk'=>'booking_id', 'table_name'=>TABLE_PREFIX.'booking'),
    array('pk'=>'group_id', 'table_name'=>TABLE_PREFIX.'group'),
    array('pk'=>'product_id', 'table_name'=>TABLE_PREFIX.'product'),
    array('pk'=>'location_id', 'table_name'=>TABLE_PREFIX.'location')
  )
);
