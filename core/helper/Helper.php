<?php

class Helper{

//Single place to set the reqt from request paramaeter can be cure used in futurue for multtiple place to set the paraever changing paramaeters
  static function setRequestParameters($req){
    $request = array(
      'booking_id' => isset($req['booking_id'])? $req['booking_id'] : '',
      'table_name' => $req['table_name'],
      'id' => $req['id'],
      'parent_table_name' => $req['parent_table_name'],
      'parent_id' => $req['parent_id'],
      'node_id' => $req['node_id'] //remembner it the ithe node vaklue of the exisitng item and used as a reference from the fk of t a table
    );
      return $request;
  }


//For quick use to find the primary key of a Obejct / uses config variable file
  static function getPrimaryKey($table_name){
    require TABLE_VARIABLES;
    return ${"db_$table_name"}['primary_key']['field_name'];
  }

  //returns the url of current request page
  static function getCurrentUrl(){
    return $_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
  }

  //redierect page after header has been send
  static function redirectJS($url){
    echo '<script type="text/javascript"> window.location = "'.$url.'"</script>';
  }

  //Returns Wheather the request is POST OR GET
  static function setRequest(){
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
      return $_POST;
    }else if($_SERVER['REQUEST_METHOD'] == 'GET'){
      return $_GET;
    }else{
      return $_SERVER;
    }
  }

//Converts any JSON request data from user to ARRAY and return it back to controller to use
  public static function getRequestData($request){
    if(isset($request['json_data'])){
      return json_decode(stripslashes($request['json_data']), TRUE);
    }else if(isset($request['ajax_action'])){
      return $request;
    }else{
      return $request;
    }
  }

  //Convert Array To stdObject Recursively
  static function arrayToStdObj($array){
    return json_decond(json_encode($array), FALSE);
  }

  //Convert stdObject To Array
  static function stdObjToArray($stdObj){
    return json_decode(json_encode($stdObj), True);
  }

  //Convert Object with Private Properties as-well To Array
  static function privStdObjToArray($privObj){
    $reflectionClass = new ReflectionClass(get_class($object));
    $array = array();
    foreach ($reflectionClass->getProperties() as $property) {
        $property->setAccessible(true);
        $array[$property->getName()] = $property->getValue($object);
        $property->setAccessible(false);
    }
    return $array;
  }

// Convert only First Letter of string to capital
  static function convertToPascalCase($string){
    return ucfirst(strtolower($string));
  }

//Removes any table prefix from the string
  static function removeTablePrefix($string){
    return str_replace(TABLE_PREFIX, '', $string);
  }

  //add prefix to string while safety checkin
  static function convertToTableName($string){
    return TABLE_PREFIX.Helper::removeTablePrefix($string);
  }

//Converts arrays to JSON of "id" and "text" for SELECT2 plugin to use and if the text is empty then name it No Name Given
  static function getSelect2Data($all_list, $id, $text){
    $temp_array = array();
    foreach($all_list  as $key => $value){
      if($value->$text == null){
        $value->$text = "No Name Given";
      }
      array_push($temp_array, array('id'=>$value->$id, 'text'=>$value->$text));
    }
    return json_encode($temp_array);
  }

//Gets the file path and chckec it Exists
  public static function checkIfFileExists($file_path){
    if(file_exists($file_path)){
      include_once  ($file_path);
      return true;
    }else{
      return false;
    }
  }


}
