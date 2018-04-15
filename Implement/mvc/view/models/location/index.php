<?php
$data =array(
  'table_name' => 'location',
  'table_columns' => array(
    array(
      'column_name' => 'Location Id',
      'element_attributes' => array(
        'data-column-id' => 'location_id',
        'data-sortable' => 'true',
        'data-type' => 'numeric',
        'data-identifier' => 'true'
      )
    ),
    array(
      'column_name' => 'Street Address',
      'element_attributes' => array(
          'data-column-id' => 'street_address',
          'data-formatter' => 'pca-editable'
        )
      ),
      array(
        'column_name' => 'City',
        'element_attributes' => array(
          'data-column-id' => 'city',
          'data-formatter' => 'pca-editable'
        )
      ),
      array(
        'column_name' => 'ZIP Code',
        'element_attributes'=> array(
          'data-column-id' => 'zip',
          'data-formatter' => 'pca-editable'
        )
      ),
      array(
        'column_name' => 'Country',
        'element_attributes' => array(
          'data-column-id' => 'country',
          'data-formatter' => 'pca-editable'
        )
      ),
      array(
        'column_name' => 'Commands',
        'element_attributes' => array(
          'data-column-id'=> 'commands',
          'data-sortable' => 'false',
          'data-formatter'=>'commands'
        )
      )
    ),
    'buttons' => array(
      array('button_name' => 'Create New Location',
      'element_attributes' => array(
        'data-ajax_action'=>'createNew',
        'data-table_name' =>'location',
        'class' => 'button-bootgrid-action')
      )
    ),
    'bootgrid_script' => array(
      'table_name' => 'location',
      'bootgrid_settings' => array(
        'ajax' => 'true',
        'navigation' => '3',
        'sorting' => 'true'
      ),
      'post_return' => array(
        'table_name'=> 'location',
        'primary_key' => 'location_id',
        'sort' => array('location_id' => 'desc'),
        'ajax_action' => 'getGridData',
        'parent_id' => $request['parent_id'],
        'parent_table_name' => $request['parent_table_name']
      )
    )
);

return $data;

/*
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

function createBootgridSettingsJS($bootgrid_settings){
  foreach($bootgrid_settings as $name => $value){
    echo $name.' : '.$value.' , ';
  }
}

function createBootgridScriptJS($bootgrid_script){
  ?>
  <script>
  $(document).ready(function(){
     $(function(){
       var grid = $('#<?php echo $bootgrid_script['table_name'] ?>-data').bootgrid({
         <?php createBootgridSettingsJS($bootgrid_script['bootgrid_settings']) ?>
         post:function(){
           return <?php echo json_encode($bootgrid_script['post_return']) ?>
         },
         url: ajax_url,
         formatters:{
           //function to formatter data inside row / cell of table
           "pca-editable": function(column, row){
             return `<div class="wrapper-editable"><div data-column-name="${column.id}" class="pca-editable" >${row[column.id]}</div></div>`;
           },
           "commands": function(column, row){
             return `
             <button type="button" class="command-edit" data-row-id="${row['staff_id']}" ><span class="glyphicon glyphicon-pencil"></span></button>
             <button type="button" class="command-delete" data-row-id="${row['staff_id']}" ><span class="glyphicon glyphicon-trash"></span></button>`;
           }
         }
       }).on('loaded.rs.jquery.bootgrid', function(){
         //on loaded event functions to run
         grid.find('.pca-editable').each(function(){
           $(this).editable({
             params: function(params){
               params.table_name= '<?php echo $bootgrid_script['table_name'] ?>';
               params.ajax_action= 'update';
               params.id= $(this).closest('tr').data('row-id');
               params.column= $(this).data('column-name');
               return params;
             },
             url: ajax_url,
             send: 'always',
             success: function (response, newValue){
               $.notify('Item Sucessfully Changed',  {className: 'success', globalPosition: 'bottom right'});
             }
           })
         });

         grid.find('.command-delete').on('click', function(e){
           if(confirm('Are you sure of this action ?')){
             var id = $(this).data('row-id');
             var table_name = '<?php echo $bootgrid_script['table_name'] ?>';
             var ajax_action = 'delete';
             var data_to_send = {json_data: JSON.stringify({
               'id': id,
               'table_name': table_name,
               'ajax_action': ajax_action
             })};
             $.post(ajax_url, data_to_send, function(returnData){
               grid.bootgrid('reload');
               $.notify('Item Deleted Sucessfully', {globalPosition: 'bottom right'});
             }).fail(function(returnData){
               $.notify('Server Failed to Respond, Sorry your action wasn\'t Completed', {globalPosition: 'bottom right'});
             });
           }
         });


       })

       $(document).on('click', 'button.button-bootgrid-action', function(e){
         e.preventDefault();
         var table_name = $(this).data('table_name');
         var ajax_action = $(this).data('ajax_action');
         var data_to_send = {json_data: JSON.stringify({
           'table_name': table_name,
           'ajax_action': ajax_action
         })};
         $.post(ajax_url, data_to_send, function(returnData){
           grid.bootgrid('reload');
           $.notify('Item Created Sucessfully',  {className: 'success', globalPosition: 'bottom right'});
         }).fail(function(returnData){
           $.notify('Server Failed to Respond, Sorry your action wasn\'t Completed', {className: 'error', globalPosition: 'bottom right'});
         });
       });

     });
  });
  </script>
  <?php
}

?>


<div class='table-reponsive <?php echo $data['table_name'] ?>'>
  <table id='<?php echo $data['table_name'] ?>-data' class='table table-condensed table-hover table-striped'>
    <thead>
      <tr>
        <?php createBootgridTableTH($data['table_columns']); ?>
     </tr>
   </thead>
 </table>
 <div class='button-wrapper'>
   <?php if($data['buttons']){createBootgridButton($data['buttons']);} ?>
 </div>
   <?php createBootgridScriptJS($data['bootgrid_script']) ?>
</div>
