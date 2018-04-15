<?php

require_once (BASEPATH . '/Implement/mvc/view/general/ViewHelper.php');

  function create_input_select($data){
    ob_start();

    ?>
    <div>
    <label> <?php echo $data['field_label'] ?>
    <select class="form-control-<?php echo $data['unique_id'] ?>" name='<?php echo $data['field_name'] ?>'>
    </select>
  </label>
  <?php if($data['isNode']){
    ?>
    <button data-table_name="<?php echo $data['table_name'] ?>" data-action="remove" class="btn btn-primary ajax_button" type="submit">Remove</button>
    <?php
    }
  ?>
  </div>
    <script>
         $(document).ready(function(){
           function formatID(item){
             if(!item.id){
               return item.text;
             }
             var fk_id = item.element.value;
             $(item.element).parent().parent().find('#<?php echo $data['input_id'] ?>').val(fk_id);
             return item.text;
           }

           var data = <?php echo $data['id_name_pair'] ?>;

           $('.form-control-<?php echo $data['unique_id'] ?>').select2({
             data: data
           });

  <?php         if($data['select_value']){ ?>
             $('.form-control-<?php echo $data['unique_id'] ?>').val('<?php echo $data['select_value'] ?>');
             $('.form-control-<?php echo $data['unique_id'] ?>').trigger('change');
  <?php       } ?>
         });

    </script>

    <?php
    $body = ob_get_contents();
    ob_end_clean();
    return $body;
  }

  function wrapperSave($data){
    ob_start();
    ?>

    <?php
    $body = ob_get_contents();
    ob_end_clean();
    return $body;
  }

  function submitWrapper($data){
    ob_start();
    ?>
    <div id="<?php echo $data['form_name'] ?>-form-<?php echo $data['unique_id'] ?>" class="<?php echo $data['form_name']; ?> form" style="border:2px solid black; margin-bottom: 10px;">
      <?php echo $data['body'] ?>
      <button data-table_name="<?php echo $data['table_name'] ?>" data-action="save" class="btn btn-primary ajax_button" type="submit">Save</button>
      <?php if($data['isNode']){
        ?>
        <button data-table_name="<?php echo $data['table_name'] ?>" data-action="remove" class="btn btn-primary ajax_button" type="submit">Remove</button>
        <?php
      }
      ?>
    </div> <!-- form -->
    <?php
    $data_js = array(
      'table_name' => $data['form_name'],
      'unique_id' => $data['unique_id']
    );
    //createSaveScript($data_js); ?>
    <?php
    $body = ob_get_contents();
    ob_end_clean();
    return $body;
  }

  //Wrap the input with bootstrap container-row-col
  function wrapper($data){
    ob_start();
    ?>
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <?php echo $data ?>
        </div> <!-- .col-12 -->
      </div> <!-- .row -->
    </div> <!-- .container -->
    <?php
    $body = ob_get_contents();
    ob_end_clean();
    return $body;
  }

    function createAddNewOrExistingButton($field_data){
      ?>
      <button data-table_name='<?php echo $field_data['table_name'] ?>' data-action='addNewNode' class='btn btn-primary ajax_button' type='submit'>Add New <?php echo $field_data['table_name'] ?> </button>
      <button data-table_name='<?php echo $field_data['table_name'] ?>' data-action='addExisting' class='btn btn-primary ajax_button' type='submit'>Add Exisiting <?php echo $field_data['table_name'] ?></button>
      <?php
    }

    //Creates Input Fields with option to select with label or without label
    function createInputField($field_data){
      if($field_data['withLabel']&&!($field_data['field']['field_hidden'])){
        $input_field = data_type2html_type($field_data['field']);
        $input_label = '<label> '.$field_data['field']['field_label'].$input_field.'</label>';
        return $input_label;
      }else{
        $input_field = data_type2html_type($field_data['field']);
        return $input_field;
      }
    }

    //Create a Normal FieldSet with Input Fields inside it
      function createFieldSet($data){
        ob_start();
        ?>
          <fieldset data-fieldtype="single" data-table_name="<?php echo $data['table_name'] ?>">
            <legend><?php echo $data['table_name']?></legend>
            <?php
              foreach($data['fields'] as $key => $value){
                echo '<div class="input-field">';
                $field_data = array(
                  'field' => $value,
                  'withLabel' => $data['withLabel']
                );
                if($value['field_ability']=='node'){
                  echo createAddNewOrExistingButton($value);
                }else{
                  echo createInputField($field_data);
                }
                echo '</div>';
                echo '<br>';
              }
            ?>
          </fieldset>
        <?php
        $fieldset = ob_get_contents();
        ob_end_clean();
        return $fieldset;
      }

      //Create a Normal FieldSet with Input Fields inside it
        function createFieldSetRow($data){
          ob_start();
          ?>
            <fieldset data-fieldtype='many' data-table_name='<?php echo $data['table_name'] ?>'>
              <div class='table_proxy' id='<?php echo $data['table_name'] ?>-table-<?php echo $data['unique_id'] ?>'>
                <div class='table_body_proxy'>
              <?php
              ob_start();
              ?>
              <div class='tr_proxy'>
              <legend><?php echo $data['table_name']?></legend>
              <?php
                foreach($data['fields'] as $key => $value){
                  ?>
                  <div class='input-field'>
                    <?php
                  $field_data = array(
                    'field' => $value,
                    'withLabel' => $data['withLabel']
                  );
                  if($value['field_ability']=='node'){
                    echo createAddNewOrExistingButton($value);
                  }else{
                    echo createInputField($field_data);
                  }
                  echo '</div>';
                  echo '<br>';
                }
              ?>
              <button class='btn btn-primary remove' type='submit'>Remove this <?php echo $data['table_name'] ?></button>
            </div>
              <?php
                $fieldset = ob_get_contents();
                ob_end_clean();


                ?>

                          </div><!-- .table_Body_proxy -->
                          <button class="btn btn-primary add" type="submit">Add New <?php echo $data['table_name'] ?></button>

                        </div><!-- table_proxy -->
            </fieldset>
          <?php
          $data_js =array(
            'table_name'=> $data['table_name'],
            'unique_id' => $data['unique_id'],
            'child_template' => $childTemplate
          );
          createFieldSetRowSetScript($data_js);
          $fullBody = ob_get_contents();
          ob_end_clean();
          return $fullBody;
        }


        //Script for table Field script to add and remove row of fields
        function createFieldSetRowSetScript($data){
          ?>
          <script>
          $(document).ready(function(){
            var
              table = $('#<?php echo $data['table_name'] ?>-table-<?php echo $data['unique_id'] ?>'),
              tableBody =  table.find('.table_body_proxy'),
              numberRows = table.find('.table_body_proxy > tr_proxy').length,
              childTemplate<?php echo $data['table_name'] ?> = "<?php echo $data['child_template'] ?>";

              table.on('click', 'button.add', function(e){
                e.preventDefault();
                $(childTemplate<?php echo $data['table_name'] ?>).appendTo(tableBody).fadeIn('fast');
              }).on('click', 'button.remove', function(e){
                e.preventDefault();
                $(this).closest('.tr_proxy').fadeOut('fast', function(){ $(this).remove();});
              });

              if(numberRows === 0){
                table.find('button.add').click();
              }
          });
      /*PERSONAL TEMPLATE ENGINE MIGHT HAVE USE IN THE FUTURE
          var template = '<h1>Hello <%this.name%></h1>';
          console.log(tableTempl);
          console.log('button.add');
          console.log(TemplateEngine(template, {name: 'Madan'}));
          var output =  TemplateEngine(template, {name: 'Madan'});
          */
          </script>
          <?php
        }











//Creates Table Fieldset
  function createTableFieldSet($data){
    $tableTempl = '';
    $number_of_col = 0;
    ob_start();
?>
<fieldset data-fieldtype="many" data-table_name="<?php echo $data['table_name'] ?>">
  <legend><?php echo $data['table_name']?></legend>
  <table id="<?php echo $data['table_name'] ?>-table-<?php echo $data['unique_id'] ?>" class="table table-striped table-responsive ">
    <thead>
      <tr>
        <?php
          foreach($data['fields'] as $key => $value){
            $number_of_col += 1;
            echo '<th>'.$value['field_label'].'</th>';
          }
        ?>
      </tr>
    </thead>
    <tbody>
      <?php
      $childTemplate.= '<tr>';
        foreach($data['fields'] as $key => $value){
          $field_data = array(
            'field' => $value,
            'withLabel' => $data['withLabel']
          );
          if($value['field_ability']=='node'){
            $childTemplate .= '<td>'.createAddNewOrExistingButton($value).'</td>';
          }else{
            $childTemplate .= '<td>'.createInputField($field_data).'</td>';
          }
      //    $childTemplate .= '<td>'.createInputField($field_data).'</td>';
        }
      $childTemplate .= '<td><button class=\"btn btn-primary remove\" type=\"submit\">Remove this '.$data['table_name'].'</button> </td>';
      $childTemplate .= '</tr>';
      ?>
    </tbody>
    <tfoot>
      <tr>
        <?php
        for($i=0; $i<$number_of_col; $i++){
            echo '<td></td>';
          }
        ?>
        <td class="actions">
          <button class="btn btn-primary add" type="submit">Add New <?php echo $data['table_name'] ?></button>
        </td>
      </tr>
    </tfoot>
  </table>
</fieldset>

<?php
$data_js =array(
  'table_name'=> $data['table_name'],
  'unique_id' => $data['unique_id'],
  'child_template' => $childTemplate
);
createTableFieldSetScript($data_js);
$table_field_set = ob_get_contents();
ob_end_clean();
return $table_field_set;
  }



  //Script for table Field script to add and remove row of fields
  function createTableFieldSetScript($data){
    ?>
    <script>
    $(document).ready(function(){
      var
        table = $('#<?php echo $data['table_name'] ?>-table-<?php echo $data['unique_id'] ?>'),
        tableBody =  table.find('tbody'),
        numberRows = table.find('tbody > tr').length,
        childTemplate<?php echo $data['table_name'] ?> = "<?php echo $data['child_template'] ?>";

        table.on('click', 'button.add', function(e){
          e.preventDefault();
          $(childTemplate<?php echo $data['table_name'] ?>).appendTo(tableBody).fadeIn('fast');
        }).on('click', 'button.remove', function(e){
          e.preventDefault();
          $(this).closest('tr').fadeOut('fast', function(){ $(this).remove();});
        });

        if(numberRows === 0){
          table.find('button.add').click();
        }
    });
/*PERSONAL TEMPLATE ENGINE MIGHT HAVE USE IN THE FUTURE
    var template = '<h1>Hello <%this.name%></h1>';
    console.log(tableTempl);
    console.log('button.add');
    console.log(TemplateEngine(template, {name: 'Madan'}));
    var output =  TemplateEngine(template, {name: 'Madan'});
    */
    </script>
    <?php
  }



 ?>
