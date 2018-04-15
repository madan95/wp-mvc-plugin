<?php

class TableView{


public static function bootstrapWrapper($data){
  ?>
  <div class='container-fluid'>
    <div class='row'>
      <div class='<?php echo $data['colClass'] ?>'>
        <?php echo $data['body'] ?>
      </div><!-- Col-md-* -->
    </div><!-- Row -->
  </div><!-- Container-Fluid -->
  <?php
}


public static function bootgridTableCreator($data){
  ?>
  <div class='table-responsive <?php echo $data['table_name'] ?>'>
    <table id='<?php echo $data['table_name'] ?>-data' class='table table-condensed table-hover table-striped'>
      <thead>
        <tr>
          <?php
          foreach($data['table_columns'] as $key => $column){
            ?>
            <th
            data-column-id='<?php echo $column['column_id'] ?>'
            data-type='<?php echo $column['data_type'] ?>'
            data-formatter='<?php echo $column['formatter'] ?>'
            data-sortable='<?php echo $column['sortable'] ?>'
             >
              <?php echo $column['column_name'] ?>
            </th>
            <?php
          }
          ?>
        </tr>
      </thead>
    </table>
    <div class='button-wrapper'>
      <?php
      foreach($data['buttons'] as $key => $button){
        ?>
        <button
        data-table_name='<?php echo $data['table_name'] ?>'
        data-action='<?php echo $button['button_action_name'] ?>'
        type='button'
        class='btn btn-primary btn-sm test_button'
        >
          <?php echo $button['button_name'] ?>
        </button>
        <?php
      }
      ?>
    </div><!--button.button-wrapper -->
    <?php
    $script_data = array(
      'table_name' => $data['table_name'],
      'bootgrid_setting' => array(
        'ajax' => 'true',
        'navigation' => '3',
        'sorting' => 'true',
      ),
      'post_return' => array(
        'table_name' => $data['table_name'],
        'parent_table_name' => '',
        'parent_table_id' => '',
        'ajax_action' => 'getGridData',
        'primary_key' =>$data['table_name'].'_id',
        'sort' => array($data['table_name'].'_id' => 'desc')
      )
    );
    TableView::bootgridScriptCreator($script_data);
    ?>
  </div><!-- div.table-reponsive -->
  <?php
}


public static function bootgridScriptCreator($data){
  ?>
  <script>
  $(document).ready(function(){
    $(function(){
    var grid = $('#<?php echo $data['table_name'] ?>-data').bootgrid({
      <?php
      foreach($data['bootgrid_setting'] as $name => $value){
        echo $name.' : '.$value.' , ';
      }
      ?>
      post: function(){
        return <?php echo json_encode($data['post_return']) ?> ;
      },
      url: ajax_url,
      formatters:{
        "pca-editable": function (column, row){
          return `<div><div class="pca-editable" >${row[column.id]}</div></div>`;
        },
        "commands": function(column, row){
          return `
          <button type="button" class="command-edit" data-row-id="${row['staff_id']}" ><span class="glyphicon glyphicon-pencil"></span></button>
          <button type="button" class="command-delete" data-row-id="${row['staff_id']}" ><span class="glyphicon glyphicon-trash"></span></button>`;
        }
      }
    }).on("loaded.rs.jquery.bootgrid", function(){
      grid.find('.pca-editable').editable({url: ajax_url, ajax_action: 'saveNew' });
      grid.find('.command-delete').on('click', function(e){
        var selected_row_id = $(this).data('row-id');

        if(confirm(`Are you sure about deleting the item ( Item ID : ${selected_row_id})?`)){
          console.log('Item Deleted');
          console.log(grid.bootgrid('getCurrentRows'));
          console.log(grid.find(`tr[data-row-id=${selected_row_id}]`).find('td'));
        }else{
          console.log('Item not Deleted');
        }
      });
    })
    })
  });
  </script>
  <?php
}


}
