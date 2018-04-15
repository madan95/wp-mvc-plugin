<?php

class Atom{

  function createBootgridTableTH($table_columns){
    foreach($table_columns as $key => $column){
      echo "<th ".GlobalViewHelper::setElementAttributes($column['element_attributes'])." >".$column['column_name']."</th>";
    }
  }

  function createBootgridButton($buttons){
    foreach($buttons as $key => $button){
      echo "<button ".GlobalViewHelper::setElementAttributes($button['element_attributes'])." >".$button['button_name']."</button>";
    }
  }

  function createExtraDiv($extra_div){
    foreach($extra_div['extra'] as $key => $div){
      $div['element_attributes']['data-unique_table_name'] = $extra_div['unique_table_name'];
      echo "<div ".GlobalViewHelper::setElementAttributes($div['element_attributes'])." >Total : </div>";
    }
  }

}
