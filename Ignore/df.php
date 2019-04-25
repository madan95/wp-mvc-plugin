<?php
/**
 * Created by PhpStorm.
 * User: Madan
 * Date: 12/01/2018
 * Time: 12:25 AM
 */
  <?php
     foreach($data['relate'] as $table){
       $table_hr = $table['hr_table'];
       $table_name = $table['table_name'];
       $field_name = $table['pk'];
       $display_name = $table['display'];
       $json_data = [];
       $data = [];
       ?>
          <label for="id_select<?php echo $table_hr ?>"> <?php echo $table_hr ?></label>
            <select id="id_select<?php echo $table_hr ?>" class="js-data-example-ajax" name='<?php echo $field_name ?>' style="width: 75%">
              <option></option>
                <?php
              foreach( $data['ids_names'][$table_name] as $items){
                  echo $items[$field_name];
                  //echo "<option value='".$items[$field_name]."'>".$items[$display_name]."</option>";
                  array_push($json_data, array('id' => $items[$field_name], 'text' => $items[$display_name]));
              }
               ?>
            </select>
          </br>
       <?php
              foreach( $data['ids_names'][$table_name] as $items2){
                  echo 'oo';
                  //echo "<option value='".$items[$field_name]."'>".$items[$display_name]."</option>";
                //  array_push($json_data, array('id' => $items[$field_name], 'text' => $items[$display_name]));
              }
        $data = json_encode($json_data);
        echo 'ok';
        ?>
         <script>
             $( document ).ready(function() {
                 jQuery(document).ready(function($){
                     $('.js-data-example-ajax').select2({
                         theme: "classic",
                         minimumInputLength: 0,
                         placeholder: "Select a state",
                         allowClear: true,
                         data: <?php echo $data ?>
                     });
                 })
             });
         </script>
           <?php
     }
    ?>
    </br>
    <input class="ajaxBtn" type='button' name='ajax_update' value='Update' >
  </form>
  </div><!-- .form-group -->
