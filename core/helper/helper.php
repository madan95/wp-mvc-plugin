<?php

    function remove_fk_from_columns($columns, $fk){
      $fk_length = sizeof($fk);
      for($i = 0; $i <= $fk_length; $i ++){
      unset($columns[$fk[$i][0]]);
      }
      return $columns;
    }

    function objectToArray($d) {
         if (is_object($d)) {
             // Gets the properties of the given object
             // with get_object_vars function
             $d = get_object_vars($d);
         }

        // if (is_array($d)) {
             /*
             * Return array converted to object
             * Using __FUNCTION__ (Magic constant)
             * for recursive call
             */
             //return array_map(__FUNCTION__, $d);
      //   }
      //   else {
             // Return array
             return $d;
      //   }
     }

    function stdObjctToArray($stdObj){
    return json_decode(json_encode($stdObj), True);
    }