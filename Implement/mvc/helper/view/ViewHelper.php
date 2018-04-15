<?PHP

class ViewHelper{

  public function __constrcut(){

  }


  public function getRegisterType($registerType){
      return ($registerType)? $registerType : 'registerSingle';
  }

  public static function createFieldWithNodeAbility($node_table_name){
    $node_add_existing_button = ucfirst($node_table_name);

    $field_with_node = Atom::createButton('Create New '.$node_add_existing_button,
                            ViewHelper::createElementExtra(array(
                              'data-table_name' => $node_table_name,
                              'data-action'=>'addNewNode',
                              'type'=>'submit',
                              'class'=>'btn btn-primary btn-sm ajax_button')
                            ));
    $field_with_node .= Atom::createButton('Use Exisiting '.$node_add_existing_button,
                            ViewHelper::createElementExtra(array(
                              'data-table_name' => $node_table_name,
                              'data-action'=>'addExisting',
                              'type'=>'submit',
                              'class'=>'btn btn-outline btn-sm ajax_button')
                            ));
    return $field_with_node;
  }


  public static function createNormalField($field){
    $normal_field = '';

    $field_type = ViewHelper::convertSQLDataTypeToHtmlType($field['field_type']);
    $field_label = $field['field_label'];
    $field_name = $field['field_name'];
    $label_input_id = $field_name.'-'.uniqid();
    $field_value = $field['field_value'];

    if($field['field_hidden']){
      $normal_field .= Atom::createInputField(ViewHelper::createElementExtra(array('type' => 'hidden', 'value' => $field_value, 'id' => $label_input_id, 'name' => $field_name)));
    }else{
      $normal_field .= Atom::createLabel($field_label, ViewHelper::createElementExtra(array('for' => $label_input_id)));
      $normal_field .= Atom::createInputField(ViewHelper::createElementExtra(array('type' => $field_type, 'value' => $field_value, 'id' => $label_input_id, 'name' => $field_name)));
    }
      return $normal_field;
  }

//Create Data Attributes using array with $key=>$value (data-$key=$value)
  public static function createDataAttributes($array_data_attributes){
    $data_attributes = "";
    foreach($array_data_attributes as $key => $value){
      $data_attributes .="data-".$key." = '".$value."' ";
    }
    return $data_attributes;
  }

  public static function createElementExtra($array_element_extra){
    $extra = "";
    foreach($array_element_extra as $key => $value){
      $extra .= " ".$key." = '".$value."' ";
    }
    return $extra;
  }

  public static function convertSQLDataTypeToHtmlType($type){
    switch ($type){
        // numeric
        case "bigint(20)":
        case "int":
        case "real":
        case "3":
        case "8":
        return "number";

        // date
        case "DATE":
        case "date":
        case "10":
        return "date";

        //time
        case "time":
        case "11":
        return "time";

        case "datetime":
        case "timestamp":
        case "7":
        case "12":
        return "text";

        // long text
        case "blob":
        case "252":
        case "LONGTEXT":
        return "textarea";

        case "hidden":
        return "hidden";
        default:
        return "text";
  }
}


  public static function createFieldSetForOther($table_name, $registerType){

    $controller_name = ucfirst($table_name);
    $serviceClass = $controller_name.'Service';
    include_once (BASEPATH.'/Implement/mvc/service/'. $controller_name . 'Service.php');
    $service = new $serviceClass();

    return $service->register(array('table_name'=>$table_name, 'unique_id'=>uniqid(), 'isNode' => 'true', 'returnFieldSet'=>'true', 'registerType'=>$registerType));



  }

}
