<?php

//group of atom
// form  with label , seach input and submit button

class Molecules{
  public function __construct(){

  }

  public static function createFieldset($field_set_body, $array_element_extra, $legend_name){
    return "<fieldset $array_element_extra >". Atom::createLegend($legend_name) ."$field_set_body</fieldset>";
  }


  public static function wrapWithSaveButton($is_node, $table_name, $body){
    ob_start();

    echo $body;
    if($is_node){
      echo  Atom::createButton('Save', ViewHelper::createElementExtra(array('data-table_name'=>$table_name, 'data-action'=>'save', 'data-is_node' => 'true', 'class'=>'btn btn-primary ajax_button', 'type'=>'submit')));
      echo  Atom::createButton('Remove', ViewHelper::createElementExtra(array('data-table_name'=>$table_name, 'data-action'=>'remove', 'class'=>'btn btn-primary ajax_button', 'type'=>'submit')));
    }else{
      echo  Atom::createButton('Save', ViewHelper::createElementExtra(array('data-table_name'=>$table_name, 'data-action'=>'save', 'class'=>'btn btn-primary ajax_button', 'type'=>'submit')));
    }

    $fullBody = ob_get_contents();
    ob_end_clean();
    return $fullBody;
  }

  public static function wrapWithDiv($array_element_extra, $body){
    return "<div $array_element_extra >$body</div>";
  }

  public static function wrapWithScript($body){
    return "<script>$(document).ready(function(){ $body });</script>";
  }

  public static function createSelect2($label_name, $label_input_id, $field_name, $is_node){
    ob_start();
    echo Atom::createLabel($label_name , ViewHelper::createElementExtra(array('for' => $label_input_id)));
    echo Atom::createSelect(ViewHelper::createElementExtra(array('id' => $label_input_id, 'name' => $field_name, 'style'=>'width: 75%;')));
    if($is_node){
    echo Atom::createButton('Remove', ViewHelper::createElementExtra(array('data-table_name' => $table_name, 'data-action' => 'remove', 'class' => 'btn btn-warning btn-sm ajax_button', 'type' => 'submit', 'style'=>'margin-left: 10px;' )) );
    }
    $select2_body = ob_get_contents();
    ob_end_clean();
    return $select2_body;
  }

  public static function createSelect2Script($id_name_pair, $select2_selector, $selected_value=null){
    ob_start();
    ?>
  <script>
    $(document).ready(function(){
      var data = <?php echo $id_name_pair ?>;
      $('#<?php echo $select2_selector ?>').select2({
        placeholder: 'Select an option',
        data: data
      });
      <?php if($selected_value!=null) { ?>

                $('#<?php echo $select2_selector ?>').val('<?php echo $selected_value?>');
                $('#<?php echo $select2_selector ?>').trigger('change');
      <?php } ?>
    });
  </script>
    <?php
    $select2_script = ob_get_contents();
    ob_end_clean();
    return $select2_script;
  }

  public static function createTableRowScript($table_selector, $childTemplate){
    ob_start();

    ?>
    <script>
      $(document).ready(function(){
          var
          table = $('#<?php echo $table_selector ?>'),
          tableBody = table.find('.table_body_proxy'),
          numberRows = table.find('table_body_proxy>tr_proxy').length,
          <?php echo $table_selector ?> = "<?php echo $childTemplate ?>";

          table.on('click', 'button.add', function(e){
            e.preventDefault();
            $(<?php echo $table_selector ?>).appendTo(tableBody).fadeIn('fast')
          }).on('click', 'button.remove', function(e){
            e.preventDefault();
            $(this).closest('.tr_proxy').fadeOut('fast', function(){
              $(this).remove();
            });
          });

          if(numberRows === 0){
            table.find('button.add').click();
          }
      });
    </script>
    <?php
    $script_table = ob_get_contents();
    ob_end_clean();
    return $script_table;
  }


}
