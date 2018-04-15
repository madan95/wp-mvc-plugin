<?php
class Page{
  public function __construct(){

  }

  public static function createRegisterView($unique_id, $table_name, $fields, $is_node){
    ob_start();
    ob_start();
    foreach($fields as $key => $value){
      ob_start();
      $label_input_id = $value['field_name'].'-'.$unique_id;
      $type = ViewHelper::convertSQLDataTypeToHtmlType($value['field_type']);
      if($value['field_ability']=='node'){
          echo Atom::createButton('Add New '.$value['table_name'], ViewHelper::createElementExtra(array('data-table_name' => $value['table_name'], 'data-action'=>'addNewNode', 'data-is_node' >'true', 'type'=>'submit', 'class'=>'btn btn-primary ajax_button')));
          echo Atom::createButton('Add Exisiting '.$value['table_name'], ViewHelper::createElementExtra(array('data-table_name' => $value['table_name'], 'data-action'=>'addExisting', 'data-is_node'=>'true', 'type'=>'submit', 'class'=>'btn btn-primary ajax_button')));
      }else{
        if($type!='hidden'){
          echo Atom::createLabel($value['field_label'], ViewHelper::createElementExtra(array('for' => $label_input_id)));
        }
          echo Atom::createInputField(ViewHelper::createElementExtra(array('type' => $type, 'value' => $value['value'], 'id' => $label_input_id, 'name' => $value['field_name'])));
      }
      $label_and_input_fields = ob_get_contents();
      ob_end_clean();
      echo Molecules::wrapWithDiv(ViewHelper::createElementExtra(array('class'=>'input-field')), $label_and_input_fields);
    }
    $field_set_body = ob_get_contents();
    ob_end_clean();

    $field_set_node =  Molecules::createFieldset($field_set_body, ViewHelper::createElementExtra(array('data-field_type' => 'single', 'data-table_name' =>  $table_name)) , $table_name);
    if($is_node){
      $field_set_node .= Atom::createButton('Save', ViewHelper::createElementExtra(array('data-table_name'=>$table_name, 'data-action'=>'save', 'data-is_node' => 'true', 'class'=>'btn btn-primary ajax_button', 'type'=>'submit')));
      $field_set_node .= Atom::createButton('Remove', ViewHelper::createElementExtra(array('data-table_name'=>$table_name, 'data-action'=>'remove', 'class'=>'btn btn-primary ajax_button', 'type'=>'submit')));
    }else{
      $field_set_node .= Atom::createButton('Save', ViewHelper::createElementExtra(array('data-table_name'=>$table_name, 'data-action'=>'save', 'class'=>'btn btn-primary ajax_button', 'type'=>'submit')));
    }

    echo $field_set_node;


    $body = ob_get_contents();
    ob_end_clean();
    return $body;
  }


  public static function createRegisterViewRow(){
    ob_start();
    $input_fields = '';
    foreach($client_fields as $key => $value){
      $input_field = '';
      $label_input_id = $value['field_name'].'-'.$unique_id;
      $type = ViewHelper::convertSQLDataTypeToHtmlType($value['field_type']);
      if($value['field_ability']=='node'){
          $input_field .= Atom::createButton('Add New '.$value['table_name'], ViewHelper::createElementExtra(array('data-table_name' => $value['table_name'], 'data-action'=>'addNewNode', 'data-is_node' >'true', 'type'=>'submit', 'class'=>'btn btn-primary ajax_button')));
          $input_field .= Atom::createButton('Add Exisiting '.$value['table_name'], ViewHelper::createElementExtra(array('data-table_name' => $value['table_name'], 'data-action'=>'addExisting', 'data-is_node'=>'true', 'type'=>'submit', 'class'=>'btn btn-primary ajax_button')));
      }else{
        if($type!='hidden'){
          $input_field .= Atom::createLabel($value['field_label'], ViewHelper::createElementExtra(array('for' => $label_input_id)));
        }
          $input_field .= Atom::createInputField(ViewHelper::createElementExtra(array('type' => $type, 'value' => $value['$field_value'], 'id' => $label_input_id, 'name' => $value['field_name'])));
      }
      $input_fields .= Molecules::wrapWithDiv(ViewHelper::createElementExtra(array('class'=>'input-field')), $input_field);

    }
    $remove_button = Atom::createButton('Remove This '.$table_name, ViewHelper::createElementExtra(array('class'=>'btn btn-primary remove', 'type'=>'submit')));
    $tr_proxy = Molecules::wrapWithDiv(ViewHelper::createElementExtra(array('class'=>'tr_proxy')), $input_fields.$remove_button);

    echo Molecules::createTableRowScript($table_name.'-table-'.$unique_id, $table_name.$unique_id, $tr_proxy);


    $div_table_body = Molecules::wrapWithDiv(ViewHelper::createElementExtra(array('class'=>'table_body_proxy')), '');
    $div_table_button = Atom::createButton('Add New '.$table_name , ViewHelper::createElementExtra(array('class'=>'btn btn-primary add', 'type'=>'submit')));

    $field_set_body = Molecules::wrapWithDiv(ViewHelper::createElementExtra(array('data-class'=>'table_proxy', 'id'=>$table_name.'-table-'.$unique_id)), $div_table_body.$div_table_button);
    echo Molecules::createFieldset($field_set_body, ViewHelper::createElementExtra(array('data-field_type'=>'many', 'data-table_name'=>$table_name)), $table_name);

    $fullBody = ob_get_contents();
    ob_end_clean();
    return $fullBody;
  }





}

 ?>
