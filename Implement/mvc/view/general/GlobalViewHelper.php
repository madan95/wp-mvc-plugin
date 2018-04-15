<?php

class GlobalViewHelper{

//Gets (Key => Value) Pair Array
//(Element-Attribute => Elment-Attribute-Value)
  public static function setElementAttributes($elementAttributes){
    $attributes = "";
    foreach($elementAttributes as $attribute_name => $attribute_value){
      $attributes .= " ".$attribute_name." = '".$attribute_value."' ";
    }
    return $attributes;
  }


}
