<?php

class ScriptCreator{

  function createBootgridSettingsJS($bootgrid_settings){
    foreach($bootgrid_settings as $name => $value){
      echo $name.' : '.$value.' , ';
    }
  }

  function productTotalFinder($data){
    ?>
    <?php
  }

//uses parameter NODE_ID to select from exisiting item as node instead of creating new
  function createSelect2JS($data){
    ?>
    <select class="js-data-example-ajax js-data-example-ajax-<?php echo $data['unique_id']?>" style="width:50%"></select>
    <button
     data-table_name= "<?php echo $data['select2']['select2_data_settings']['table_name'] ?>"
     data-parent_table_name= "<?php echo $data['select2']['select2_data_settings']['parent_table_name'] ?>"
     data-parent_id= "<?php echo $data['select2']['select2_data_settings']['parent_id'] ?>"
     data-ajax_action= "useExisting"
     data-target = "js-data-example-ajax-<?php echo $data['unique_id'] ?>"
     id="select2-action-<?php echo $data['unique_id'] ?>">
     Use Exisiting Item
   </button>

    <script>
    $(document).ready(function(){
       $(function(){

         //on clickling slect from existing item
       $('#select2-action-<?php echo $data['unique_id'] ?>').on('click', function(e){
           e.preventDefault();
           var data_to_send_obj =  $(this).data();
           data_to_send_obj['node_id'] =  $('.js-data-example-ajax-<?php echo $data['unique_id']?>').val();
           var data_to_send = {json_data: JSON.stringify( data_to_send_obj )};
           $.post(ajax_url, data_to_send, function(returnData){
             $('.table').bootgrid('reload');
             $.notify('Item Changed Sucessfully',  {className: 'success', globalPosition: 'bottom right'});
           }).fail(function(returnData){
             $.notify('Server Failed to Respond, Sorry your action wasn\'t Completed', {className: 'error', globalPosition: 'bottom right'});
           });
         });

         //Ajax to get select2 options
         $('.js-data-example-ajax-<?php echo $data['unique_id']?>').select2({
           ajax: {
             url: ajax_url,
             dataType: 'json',
             data: function(params){
               return {
                 search: params.term,
                 table_name: "<?php echo $data['select2']['select2_data_settings']['table_name'] ?>",
                 column: "<?php echo $data['select2']['select2_data_settings']['column'] ?>",
                 ajax_action: "<?php echo $data['select2']['select2_data_settings']['ajax_action'] ?>"
               };
             },
             processResults: function(data){
               return {
                 results: data
               };
             }
           },
           placeholder: 'Use Exisiting Item'
           });

       });
    });
    </script>
    <?php
  }



  function createBootgridScriptJS($data){
    ?>
    <script>
    $(document).ready(function(){
       $(function(){
         var grid<?php echo $data['unique_table_name'] ?> = $('#<?php echo $data['unique_table_name'] ?>-data').bootgrid({
           <?php ScriptCreator::createBootgridSettingsJS( $data['bootgrid_script']['bootgrid_settings']) ?>
           post:function(){
             return <?php echo json_encode( $data['bootgrid_script']['post_return']) ?>
           },
           url: ajax_url,
           formatters:{
             "pca-viewdetail-link": function(column, row){
               return `<a href="?table_name=<?php echo $data['table_name'] ?>&ajax_action=viewdetail&id=${row[column.id]}">${row[column.id]}</a>`;
             },
             "pca-class-with-column-id": function(column, row){
               return `<div data-column-name="${column.id}" class="${column.id}">${row[column.id]}</div>`;
             },
             //function to formatter data inside row / cell of table
             "pca-editable": function(column, row){
               return `<div class="wrapper-editable"><div  data-column-name="${column.id}" data-column-name="${column.id}" class="pca-editable" >${row[column.id]}</div></div>`;
             },
             "pca-editable-node": function(column, row){
               var parent_table_name, parent_id, node_id, table_name, display = 'Fields Not Set Yet';
               if(row[column.id]===null){
                 console.log('nulled');
               }else{
                 parent_table_name = row[column.id].parent_table_name;
                 parent_id = row[column.id].parent_id;
                 node_id = row[column.id].node_id;
                 table_name = row[column.id].table_name;
                 display = row[column.id].display;
               }
               return `<div class="wrapper-editable">
                          <div data-column-name="${column.id}" data-parent-table-name="${parent_table_name}" data-parent-id="${parent_id}" data-node-id="${node_id}" data-table-name="${table_name}" data-column-name="${column.id}" class="pca-node inline-block ">
                            ${display}
                          </div>
                            <div data-column-name="${column.id}" type="button" data-toggle="modal" data-target="#modal-id-<?php echo $data['unique_id']?>" class="modal-edit inline-block"  data-parent-table-name="${parent_table_name}" data-parent-id="${parent_id}" data-node-id="${node_id}" data-table-name="${table_name}" data-column-name="${column.id}" ><span class="glyphicon glyphicon-pencil"></span></div>
                        </div>`;
             },
             "pca-editable-date": function(column, row){
               return `<div class="wrapper-editable"><div data-type="date"  data-template="YYYY/MMM/D"  data-column-name="${column.id}" class="pca-editable" >${row[column.id]}</div></div>`;
             },
             "commands": function(column, row){
               return `
               <button style="display:none;" type="button" class="command-edit" data-ajax-action="edit" data-row-id="${row[<?php echo '"'.$data['table_name'].'_id"' ?>]}" ><span class="glyphicon glyphicon-pencil"></span></button>
               <button type="button" class="command-delete" data-ajax-action="delete" data-row-id="${row[<?php echo '"'.$data['table_name'].'_id"' ?>]}" ><span class="glyphicon glyphicon-trash"></span></button>`;
             },
             "remove": function(column, row){
               return `<button type="button" class="command-remove"
               data-parent-id="<?php echo $data['parent_id'] ?>"
               data-parent-table-name="<?php echo $data['parent_table_name'] ?>"
               data-node-id="${row['<?php echo $data['pk_id'] ?>']}"
               data-node-pk="<?php echo $data['pk_id'] ?>"
               data-table-name="<?php echo $data['table_name']?>"
               data-ajax-action="remove" >
                <span class="glyphicon glyphicon-remove"></span>
               </button>`;
             }
           }
         }).on('loaded.rs.jquery.bootgrid', function(){
           //on loaded event functions to run
           grid<?php echo $data['unique_table_name'] ?>.find('.pca-editable').each(function(){
             $(this).editable({
               params: function(params){
                 params.table_name= '<?php echo  $data['bootgrid_script']['table_name'] ?>';
                 params.ajax_action= 'update';
                 params.id= $(this).closest('tr').data('row-id');
                 params.column= $(this).data('column-name');
                 return params;
               },
               url: ajax_url,
               send: 'always',
               format: 'yyyy-mm-dd',
               viewformat: 'yyyy-mm-dd',
               datepicker: {
                 weekStart: 1
               },
               mode: 'inline',
               success: function (response, newValue){
                 grid<?php echo $data['unique_table_name'] ?>.bootgrid('reload');
                 $.notify('Item Sucessfully Changed',  {className: 'success', globalPosition: 'bottom right'});
                 refresh();
               }
             })
           });

           grid<?php echo $data['unique_table_name'] ?>.find('.command-remove').on('click', function(e){
              if(confirm('Are you sure of this action ?')){
                var id = $(this).data('node-id');
                var table_name = $(this).data('table-name');
                var parent_table_name = $(this).data('parent-table-name');
                var parent_id = $(this).data('parent-id');
                var ajax_action = 'remove';
                var node_pk = $(this).data('node-pk');
                var data_to_send = {json_data: JSON.stringify({
                  'id': id,
                  'table_name': table_name,
                  'parent_table_name': parent_table_name,
                  'parent_id': parent_id,
                  'ajax_action': ajax_action,
                  'node_pk':node_pk
                })};
                $.post(ajax_url, data_to_send, function(returnData){
                  grid<?php echo $data['unique_table_name'] ?>.bootgrid('reload');
                  refresh();

                  $.notify('Item Deleted Sucessfully', {globalPosition: 'bottom right'});

                }).fail(function(returnData){
                  $.notify('Server Failed to Respond, Sorry your action wasn\'t Completed', {globalPosition: 'bottom right'});
                });
              }
           });

           grid<?php echo $data['unique_table_name'] ?>.find('.command-delete').on('click', function(e){
             if(confirm('Are you sure of this action ?')){
               var id = $(this).data('row-id');
               var table_name = '<?php echo  $data['bootgrid_script']['table_name']  ?>';
               var ajax_action = 'delete';
               var data_to_send = {json_data: JSON.stringify({
                 'id': id,
                 'table_name': table_name,
                 'ajax_action': ajax_action
               })};
               $.post(ajax_url, data_to_send, function(returnData){
                 grid<?php echo $data['unique_table_name'] ?>.bootgrid('reload');
                 refresh();

                 $.notify('Item Deleted Sucessfully', {globalPosition: 'bottom right'});
               }).fail(function(returnData){
                 $.notify('Server Failed to Respond, Sorry your action wasn\'t Completed', {globalPosition: 'bottom right'});
               });
             }
           });


           grid<?php echo $data['unique_table_name'] ?>.find('.modal-edit').on('click', function(e){
             e.preventDefault();
             $($(this).attr('data-target')).modal('show');
             var data_to_send = {json_data: JSON.stringify({
               'id': $(this).data('node-id'),
               'table_name': $(this).data('table-name'),
               'parent_table_name': $(this).data('parent-table-name'),
               'parent_id': $(this).data('parent-id'),
               'ajax_action': 'viewDetail'
             })}
             $.post(ajax_url, data_to_send, function(returnData){
               $('.modal .modal-body-<?php echo $data['unique_id'] ?>').append(returnData);
               refresh();

             }).fail(function(returnData){
             });
           });
           refresh();

         })

         var refresh = function(){
           $('.refresh').each(function(){
             var action = $(this).data('use');
             action_to_execute[action]($(this));
           });

  /*        var total = 0.00;
          grid.find('tr').each(function(i, el){
            var $tds = $(this).find('td'),
            product_cost = $tds.find('*[data-column-name="product_cost"]').html(),
            product_quantity = $tds.find('*[data-column-name="product_quantity"]').html(),
            total_row =  (product_cost * product_quantity);
            if(isNaN(total_row) == false) { //Check to make sure value is not NAn or total might become Nan
              total += total_row;
            }
           });
           $('.refresh.total_cost<?php //echo $data['unique_id'] ?>').html("Total Price : "+ total);*/
        };

        var action_to_execute = {
          find_total_cost: function(refresh_element){
            console.log('Refreshing Total Costs Ran');
//            var boot_grid_table = $(refresh_element).data('boot_grid_table');
            var data_to_send = {json_data: JSON.stringify( $(refresh_element).data() )};
            $.post(ajax_url, data_to_send, function(returnData){
              console.log(returnData);
              var result = JSON.parse(returnData);
              $(refresh_element).html('Total Price : ' + result.total_booking_price);
            }).fail(function(returnData){
              console.log('failed refresh find total cost');
            });
          }
        };
        /*    var total = 0;
            $('.'+boot_grid_table).find('tr').each(function(i, el){
              var $tds = $(this).find('td');
              var product_quantity = $tds.find('*[data-column-name="product_quantity"]').html();
              var product_cost = $tds.find('*[data-column-name="product_cost"]').html();

            total_row = product_quantity  * product_cost;
            if(isNaN(total_row) == false) { //Check to make sure value is not NAn or total might become Nan
                total += total_row;
              }
            });
            $(refresh_element).html('Total Price : ' + total);
          }*/
          /*var find_total_cost = function(){
            console.log('find_total_cost');
          }
          var find_total_cost_row = function(){
            console.log('total cost row');
          }
          return{
            find_total_cost: find_total_cost,
            find_total_cost_row: find_total_cost_row
          }*/
      //  };


/*
         $(document).on('click', 'button.button-bootgrid-action<?php // echo $data['unique_id'] ?>', function(e){
           e.preventDefault();
           var parent_table_name = $(this).data('parent-table-name');
           var parent_id = $(this).data('parent-id');
           var table_name = $(this).data('table_name');
           var ajax_action = $(this).data('ajax_action');
           var data_to_send = {json_data: JSON.stringify({
             'table_name': table_name,
             'parent_table_name': parent_table_name,
             'parent_id': parent_id,
             'ajax_action': ajax_action
           })};
           $.post(ajax_url, data_to_send, function(returnData){
             $('.table').bootgrid('reload');
             $.notify('Item Created Sucessfully',  {className: 'success', globalPosition: 'bottom right'});
           }).fail(function(returnData){
             $.notify('Server Failed to Respond, Sorry your action wasn\'t Completed', {className: 'error', globalPosition: 'bottom right'});
           });
         });
*/

         //Upon closing the modal remove all the data in empty
         $('.modal-close-<?php echo $data['unique_id'] ?>').on('click', function(){
          grid<?php echo $data['unique_table_name'] ?> .bootgrid('reload');
           $('.modal-body-<?php echo $data['unique_id'] ?>').empty();
           $('#modal-id-<?php echo $data['unique_id']?>').modal('hide');
         });

         //Bring back the focus to the intial modal
         $('.modal').on('hidden.bs.modal', function(e){
           if($('.modal').hasClass('in')){
             $('body').addClass('modal-open');
           }
         });


        // $('#modal-id-<?php echo $data['unique_id'] ?>').on('hide.bs.modal' , function(e){
      //     grid.bootgrid('reload');
      //     $('.modal-body-<?php echo $data['unique_id'] ?>').empty();
    //     });



       });
    });
    </script>
    <?php
  }
}
