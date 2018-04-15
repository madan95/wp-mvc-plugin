<?php


// More than one molecules together
// like baner. header
// could have same molecules many or many different molecules

class Organism{
  public function __construct(){}

  public static function createForm($array_element_extra, $body){
    return "<div $array_element_extra >$body</div>";
  }

  public static function createTableProxiesSkeleton($table_name, $table_unique_id, $tr_script){
    $div_table_body = Molecules::wrapWithDiv(ViewHelper::createElementExtra(array('class'=>'table_body_proxy')), $tr_script);
    $div_table_button = Atom::createButton('Add More '.$table_name , ViewHelper::createElementExtra(array('class'=>'btn btn-info btn-sm add', 'type'=>'submit')));
    $field_set_body = Molecules::wrapWithDiv(ViewHelper::createElementExtra(array('data-class'=>'table_proxy', 'id'=>$table_unique_id)), $div_table_body.$div_table_button);
    return Molecules::createFieldset($field_set_body, ViewHelper::createElementExtra(array('data-field_type'=>'many', 'data-table_name'=>$table_name)), $table_name);

  }

  public static function createSelect2($id_name_pair, $label_name, $label_input_id, $field_name, $is_node, $selected_value=null){
    $label_and_select =  Molecules::createSelect2($label_name, $label_input_id, $field_name, $is_node);
    $script = Molecules::createSelect2Script($id_name_pair, $label_input_id, $selected_value);
    $body = $label_and_select . $script;
    return Molecules::wrapWithDiv(
      ViewHelper::createElementExtra(
        array(
          'class'=>'select2_div_class form-group'
        )),
        $body);

        //return $body;
  }

  public static function createInputLabelField($field){
    if($field['field_ability']=='node'){
      return ViewHelper::createFieldWithNodeAbility($field['table_name']);
    }else {
      return ViewHelper::createNormalField($field);
    }
  }

  public static function createInputField($fields){
    $input_fields = '';
    foreach($fields as $key => $field){
      $label_and_input_fields = Organism::createInputLabelField($field);
      $form_group = Molecules::wrapWithDiv(ViewHelper::createElementExtra(array('class'=>'form-group')), $label_and_input_fields);
      $input_fields .= Molecules::wrapWithDiv(ViewHelper::createElementExtra(array('class'=>'input-field')), $form_group);
    }
    return $input_fields;
  }

  public static function createNormalSave($table_name, $main_unique_id, $body){
    $save_button = Atom::createButton('Save', ViewHelper::createElementExtra(array(
      'data-table_name'=>$table_name,
      'data-action'=>'save',
      'class'=>'btn btn-primary  ajax_button',
      'type'=>'submit'
    )));

    return Molecules::wrapWithDiv(ViewHelper::createElementExtra(array(
         'class' => $table_name.'-form form',
         'id' => $table_name.'-form-'.$main_unique_id
       )),
         $body.$save_button);
  }


  public static function createNodeSaveRemove($table_name, $body){
    $sr_button = Atom::createButton('Save '.$table_name, ViewHelper::createElementExtra(array(
      'data-table_name'=>$table_name,
       'data-is_node' => 'true',
        'data-action'=>'save',
         'class'=>'btn btn-success btn-sm ajax_button',
         'type'=>'submit'
       )));
    $sr_button .= Atom::createButton('Cancel  ', ViewHelper::createElementExtra(array(
      'data-table_name'=> $table_name,
      'data-action'=>'remove',
      'class'=>'btn btn-warning btn-sm ajax_button',
       'type'=>'submit'
     )));
    return  Molecules::wrapWithDiv(ViewHelper::createElementExtra(array('class'=> $table_name.'-form form')), $body.$sr_button);

  }

  public static function returnType($table_name , $body, $returnFieldSet = null, $isNode = null, $main_unique_id = null, $json_data = array() ){
    if($returnFieldSet){ //check if they only wants fields set, if so just send fieldset form
      return $body;
    }else{
    if($isNode){ // check if the request is NODE form, if so send it packed up in json
      $body = Organism::createNodeSaveRemove($table_name, $body);
      $json_data['body'] = $body;
      wp_send_json(json_encode($json_data));
    }else{ // if not fieldset or node , just echo output with save button
        echo Organism::createNormalSave($table_name, $main_unique_id, $body);
      }
    }
  }

  public static function createTrProxy($fields, $table_name){
    $input_fields = Organism::createInputField($fields);
    $remove_button = Atom::createButton('Remove This '.$table_name, ViewHelper::createElementExtra(array('class'=>'btn btn-danger btn-sm remove', 'type'=>'submit')));
    return Molecules::wrapWithDiv(ViewHelper::createElementExtra(array('class'=>'tr_proxy')), $input_fields.$remove_button);

  }

  public static function createTrProxyForNode($fields, $table_name){
    $label_and_input_fields = ViewHelper::createFieldWithNodeAbility($table_name);
    $input_fields = Molecules::wrapWithDiv(ViewHelper::createElementExtra(array('class'=>'input-field')), $label_and_input_fields);

    $remove_button = Atom::createButton('Remove This '.$table_name, ViewHelper::createElementExtra(array('class'=>'btn btn-primary remove', 'type'=>'submit')));
    return Molecules::wrapWithDiv(ViewHelper::createElementExtra(array('class'=>'tr_proxy')), $input_fields.$remove_button);

  }





}
