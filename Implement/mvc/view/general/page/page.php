<?php

class Page{

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


function createModalTable($data){
  ?>
  <!-- Modal -->
  <div class="modal fade" id="locationTable" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
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
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <?php
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
           "pca-editable-node": function(column, row){
             console.log(row);
             console.log(column);
             console.log(row[column.id].parent_table_name);
             return `<div class="wrapper-editable">
                        <div  data-parent-table-name="${row[column.id].parent_table_name}" data-parent-id="${row[column.id].parent_id}" data-node-id="${row[column.id].nodeid}" data-table-name="${row[column.id].table_name}" data-column-name="${column.id}" class="pca-node inline-block ">
                          ${row[column.id].display}
                        </div>
                          <div type="button" data-toggle="modal" data-target="#locationTable" class="modal-edit inline-block" ><span class="glyphicon glyphicon-pencil"></span></div>
                      </div>`;
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


         grid.find('.modal-edit').on('click', function(e){
           e.preventDefault();
           console.log('df');
           $($(this).attr('data-target')).modal('show');
           console.log($(this));
           var data_to_send = {json_data: JSON.stringify({
             'id': $(this).data('node-id')
           })}
           $.post(ajax_url, data_to_send, function(returnData){
             $.notify('Item Deleted Sucessfully', {globalPosition: 'bottom right'});
           }).fail(function(returnData){
             $.notify('Server Failed to Respond, Sorry your action wasn\'t Completed', {globalPosition: 'bottom right'});
           });
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
           $('.table').bootgrid('reload');
           $.notify('Item Created Sucessfully',  {className: 'success', globalPosition: 'bottom right'});
         }).fail(function(returnData){
           $.notify('Server Failed to Respond, Sorry your action wasn\'t Completed', {className: 'error', globalPosition: 'bottom right'});
         });
       });



       $('.modal').on('hide.bs.modal' , function(e){
         grid.bootgrid('reload');
       });



     });
  });
  </script>
  <?php
}

function createBootgridTable($data){
//  $data['table_name'] = $data['table_name'].$data['unique_id'];
//$data['unique_table_name'] = $data['table_name'].$data['unique_id'];

  ?>
  <div class='table-bootgrid-wrapper'>
<div class='table-responsive <?php echo $data['table_name'] ?>'>
  <table id='<?php echo $data['unique_table_name'] ?>-data' class='table table-condensed table-hover table-striped'>
    <thead>
      <tr>
        <?php Atom::createBootgridTableTH($data['table_columns']); ?>
     </tr>
   </thead>
 </table>
</div>
<div class='total_cost'>
  <?php
  if($data['extra']){ Atom::createExtraDiv($data); }
  ?>
</div>
<div class='button-wrapper'>
  <?php if($data['buttons']){ Atom::createBootgridButton($data['buttons']); }
      if($data['select2']){ ScriptCreator::createSelect2JS($data); }
  ?>
</div>
  <?php ScriptCreator::createBootgridScriptJS($data) ?>
  <?php Organism::createModalTable($data) ?>

  <!-- <a href="?table_name=booking&ajax_action=createNew" >hhh</a> -->

</div>

<?php }

}
