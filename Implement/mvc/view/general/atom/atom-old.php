<?php

// label
//input
//button
class Atom{

  public function __construct(){}

  public static function createInputField($array_element_extra){
    return "<input $array_element_extra />";
  }

  public static function createButton($button_name, $array_element_extra){
    return "<button $array_element_extra >$button_name</button>";
  }

  public static function createLabel($label_name, $array_element_extra){
    return "<label $array_element_extra >$label_name</label>";
  }

  public static function createTextArea($array_element_extra){
    return "<textarea $array_element_extra ></textarea>";
  }

  public static function createLegend($legend_name){
    return "<legend>$legend_name</legend>";
  }

  public static function createSelect($array_element_extra){
    return "<select $array_element_extra ></select>";
  }


}
