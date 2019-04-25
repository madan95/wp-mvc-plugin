<?php
/**
 * Created by PhpStorm.
 * User: Madan
 * Date: 26/12/2017
 * Time: 6:31 PM
 */
//view::displaySearch();
//view::displayAddNew($data['table_name']);


public function edit_modal_box($data){       ?>
<div id="edit_model_<?php echo $data['unique_id'] ?>" class="modal fade">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">Edit <?php echo $data['table_name_human_readable'] ?></h4>
          </div>
            <div class="modal-body">

            </div>
      </div>
    </div>
</div>
<?php
}

public function add_modal_box($data){
 ?>
 <div id="add_model_<?php echo $data['unique_id'] ?>" class="modal fade">
     <div class="modal-dialog">
         <div class="modal-content">
             <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                 <h4 class="modal-title">Add <?php echo $data['table_name_human_readable'] ?></h4>
             </div>
             <div class="modal-body">
               <?php
           ?>
         </div>
     </div>
 </div>
</div>
<?php
}



?>
<table id="grid-basic" class="grid-basic table table-condensed table-hover table-striped">
    <thead>
    <tr>
        <?php
        foreach ($data['columns'] as $name=>$type){
            ?>
            <th data-column-id="<?php echo $name ?>" data-type="<?php echo $type ?>"><?php echo $name ?> </th>
            <?php
        }
        ?>
        <th data-column-id="commands" data-formatter="commands" data-sortable="false">Commands</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $primary_key_value=0;
    foreach ($data['result'] as $row){
        echo '<tr>';
        foreach ($row as $k => $v){
            if($k == $data['primary_key']){
                $primary_key_value = $v;
            }
            echo '<td>'. $v . '</td>';
        }
        echo '<td><a href="?action=edit&table='.$data['table_name'].'&id='.$primary_key_value.'">Edit</a></td>';
        echo '</tr>';
    }
    ?>
    </tbody>
</table>
<script>
    jQuery(document).ready(function($){
     $(".grid-basic").bootgrid();
    });
</script>
