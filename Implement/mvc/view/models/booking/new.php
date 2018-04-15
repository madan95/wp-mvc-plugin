<?php

?>


<?php


function createInputFields($fields){
  echo '<div>';
  $unique_id = uniqid();
  foreach($fields as $key => $value){
    echo '<div class=\'user_inputs\'>';
    if($value['field_ability']=='node'){
      ?>
      <div class='form-group'>

        <button data-table_name='<?php echo $value['table_name'] ?>' data-action='addNewNode' type='button' class='btn btn-primary btn-sm ajax_button' >Create New <?php echo $value['field_label'] ?> </button>
        <button data-table_name='<?php echo $value['table_name'] ?>' data-action='addExisting' type='button' class='btn btn-outline secondary btn-sm ajax_button' >Use Exisiting <?php echo $value['field_label'] ?></button>
        <?php if($value['field_help']){ ?>
        <small id='<?php echo $value['field_name'].$unique_id.'Help' ?>' class="form-text text-muted"><?php echo $value['field_help'] ?></small>
      <?php } ?>
      </div>

      <?php
    }else{
      $type = ViewHelper::convertSQLDataTypeToHtmlType($value['field_type']);
      if($value['field_hidden']){
        $type = 'hidden'; ?>
          <input type='<?php echo $type ?>' name='<?php echo $value['field_name'] ?>' id='<?php echo $value['field_name'].$unique_id ?>' ><br>
        <?php
      }else{
    ?>
    <div class='form-group'>
      <label  for='<?php echo $value['field_name'].$unique_id ?>'><?php echo $value['field_label'] ?></label>
      <input type='<?php echo $type ?>' name='<?php echo $value['field_name'] ?>' id='<?php echo $value['field_name'].$unique_id ?>' >
      <?php if($value['field_help']){ ?>
      <small id='<?php echo $value['field_name'].$unique_id.'Help' ?>' class="form-text text-muted"><?php echo $value['field_help'] ?></small>
    <?php } ?>
    </div>
    <?php
    }
  }
  echo '</div>';
  }
  echo '</div>';
}

?>
<?php
$unique_id = uniqid();
?>
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="main-node-form form">
      <fieldset>
        <div id="<?php echo 'booking-table-id-'.$unique_id ?>" data-table="booking" class="input-fields">
          <div class="cover">
            <h4> Booking  </h4>
            <hr>

<?php
$booking_fields = array(
 array('field_label'=> 'Booking ID', 'field_name'=>'booking_id',  'field_type'=>' bigint(20)', 'field_hidden'=>'true'),
 array('field_label'=> 'Customer', 'field_name'=>'customer_id', 'field_type'=>'bigint(20)',  'field_ability' => 'node', 'table_name'=> 'customer'),
 array('field_label'=> 'Start Date', 'field_name'=>'start_date', 'field_type'=>'DATE'),
 array('field_label'=> 'Due Date', 'field_name'=>'due_date', 'field_type'=>'DATE'),
 array('field_label'=> 'Booking Location',  'field_name'=>'location_id', 'field_type'=>'bigint(20)', 'field_ability' => 'node', 'table_name'=> 'location', 'field_help'=>'By Default Customer Location will be used.'),

);
echo createInputFields($booking_fields);
?>

                <div id='<?php echo 'task-table-id-'.$unique_id?>' data-table='task' class='input-fields'>
                  <?php
                  ob_start();

                  ?>
                  <div class='cover'>
                    <h4>Tasks </h4>
                    <hr>

                    <?php
                    $task_fields = array(
                      array('field_label'=> 'Task Id', 'field_name'=>'task_id', 'field_type'=>'bigint(20)', 'field_hidden'=>'true'),
                      array('field_label'=> 'Date Start', 'field_name'=>'date_start', 'field_type'=>'DATE'),
                      array('field_label'=> 'Date Finish', 'field_name'=>'date_finish', 'field_type'=>'DATE'),
                      array('field_label'=> 'Description', 'field_name'=>'description', 'field_type'=>'LONGTEXT'),
                      array('field_label'=> 'Product', 'field_name'=>'product_id', 'field_type'=>'bigint(20)', 'field_ability' => 'node', 'table_name'=> 'product'),
                      array('field_label'=> 'Product Quantity', 'field_name'=>'product_quantity', 'field_type'=>'bigint(20)'),
                      array('field_label'=>'Product Location', 'field_name'=>'location_id', 'field_type'=>'bigint(20)', 'field_ability' => 'node', 'table_name'=> 'location')
                    );
                    echo createInputFields($task_fields);

                    ?>

                      <div id='<?php echo 'staff-table-id-'.$unique_id ?>' data-table='staff' class='input-fields'>

                        <?php
                        ob_start();

                        ?>
                        <div class='cover'>
                          <h4>Staffs</h4>
                          <hr>

                          <?php
                          $staff_fields = array(
                            array('field_label'=>'Staff ID', 'field_name'=>'staff_id', 'field_type'=>'bigint(20)', 'field_hidden' => 'true'),
                            array('field_label'=>'First Name', 'field_name'=>'first_name', 'field_type'=>'varchar(255)'),
                            array('field_label'=>'Last Name', 'field_name'=>'last_name', 'field_type'=>'varchar(255)'),
                            array('field_label'=>'Mobile Number', 'field_name'=>'mobile_number', 'field_type'=>'varchar(255)'),
                            array('field_label'=>'Phone Number', 'field_name'=>'phone_number', 'field_type'=>'varchar(255)'),
                            array('field_label'=>'Notes', 'field_name'=>'notes', 'field_type'=>'longtext')
                          );
                          echo createInputFields($staff_fields);

                          ?>
                          <button class='btn btn-danger btn-sm remove' >Remove This Staff </button>
                        </div><!-- .cover -->
                        <?php
                        $staff_table_old = ob_get_contents();
                        ob_end_clean();
                        //echo $staff_table;

                        ob_start();

                        ?>                        <div class='cover'>
                          <h4>Staffs</h4>
                          <hr>
<div>
                          <div class='user_inputs'>

                        <div class='form-group'>
                          <button data-table_name='<?php echo 'staff' ?>' data-action='addNewNode' type='button' class='btn btn-primary btn-sm ajax_button' >Create New Staff </button>
                          <button data-table_name='<?php echo 'staff' ?>' data-action='addExisting' type='button' class='btn btn-outline  btn-sm ajax_button' >Use Exisiting Staff</button>
  </div>
</div>
                          <button class='btn btn-danger btn-sm remove' >Remove This Staff </button>
</div>
</div><!-- .cover -->

                        <?php
                        $staff_table = ob_get_contents();
                        ob_end_clean();
                      echo $staff_table;

                        ?>

                        <button class='btn btn-info btn-sm add'>Add More Staff</button>
                      </div><!-- STAFF -->
                      <button class='btn btn-danger btn-sm remove'>Remove This Task </button>
                  </div><!-- .cover -->
                  <?php
                 $task_table = ob_get_contents();
                  ob_end_clean();
                 echo $task_table;
                  ?>
                  <button class='btn btn-info btn-sm add'>Add More Task</button>
                </div><!-- Task -->


          </div><!-- .cover -->
        </div><!-- .input-fields -->
        <script>
          $(document).ready(function(){
            $('.main-node-form').on('click', 'button.add', function(e){
              e.preventDefault();
            //  var template = $(this).parent().find('>.cover:first').clone(true, true);
              var template;
              var staff_template = "<?php echo  trim(preg_replace('/\s+/', ' ', $staff_table)) ?>";
              var task_template = "<?php echo  trim(preg_replace('/\s+/', ' ', $task_table)) ?>";
              if($(this).parent().data('table')=='staff'){
                template = staff_template;
              }else if($(this).parent().data('table')=='task'){
                template = task_template;
              }
              if($(this).parent().find('>.cover').length>0){
                $(this).parent().find('>.cover:last').after($(template));
              }else{
                $(this).parent().prepend($(template));
              }
                            return false;
            });

            $('.main-node-form').on('click', 'button.remove', function(e){
              e.preventDefault();
              $(this).parent().remove();
              return false;
            });
          });
        </script>

        <button data-table_name="booking" data-action="save" class="btn btn-success btn-sm testBtn">Save Booking</button>
      </fieldset>
    </div><!-- .main-node-form .form -->
    </div><!-- .col-md-12 -->
  </div><!-- .row -->
</div><!-- .container -->


<?php


?>
