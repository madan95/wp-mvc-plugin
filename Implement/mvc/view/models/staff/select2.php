<?php
$unique_id = $request['unique_id'];
$label_name = 'Staff Name';
$label_input_id ='select2-location-'.$unique_id;
$field_name = 'staff_id';
$is_node = $request['isNode'];
$selected_value = null;
if($request['selected_value']){
  $selected_value = $request['selected_value'];
}

return Organism::createSelect2($id_name_pair, $label_name, $label_input_id, $field_name, $is_node, $selected_value);
