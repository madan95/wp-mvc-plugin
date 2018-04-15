<?php

$fieldset_name = "Task";

$fields = array(
 array('field_label'=> 'Booking ID', 'field_name'=>'booking_id',  'field_type'=>' bigint(20) '),
 array('field_label'=> 'Booking Location',  'field_name'=>'location_id', 'field_type'=>'bigint(20)', 'field_ability' => 'node', 'table_name'=> 'location'),
 array('field_label'=> 'Start Date', 'field_name'=>'start_date', 'field_type'=>'DATE'),
 array('field_label'=> 'Due Date', 'field_name'=>'due_date', 'field_type'=>'DATE'),
 array('field_label'=> 'Customer', 'field_name'=>'customer_id', 'field_type'=>'bigint(20)',  'field_ability' => 'node', 'table_name'=> 'customer')
);



ob_start();
$unique_label_id = uniqid();
echo '<fieldset>';
echo '<legend>'.$fieldset_name.'</legend>';
foreach($fields as $key => $value){
  if($value['field_ability']){
    echo '<div>';
    echo '<button data-table_name="'.$value['table_name'].'" data-action="addNewNode" type="submit" class="btn btn-primary ajax_button" >Add New</button>';
    echo '<button data-table_name="'.$value['table_name'].'" data-action="addExisting" type="submit" class="btn btn-primary ajax_button" >Add Existing</button>';
    echo '</div>';
  }else if(!$value['field_hidden']){ //if not hidden type of field
    echo '<div>';
    echo '<label for="'.$value['field_name'].'_label_'.$unique_label_id.'">'.$value['field_label'].'</label>';
    echo '<input type="'.$value['field_type'].'" name="'.$value['field_name'].'" id="'.$value['field_name'].'_label_'.$unique_label_id.'" >';
    echo '</div>';
  }
}
echo '</fieldset>';
$fieldset = ob_get_contents();
ob_end_clean();
return $fieldset;
