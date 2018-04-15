<?php
?>
<div class"container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="table-reponsive staff-table">
        <table id="staff-data" class="table table-condensed table-hover table-striped">
          <thead>
            <tr>
              <th data-column-id="staff_id"   data-identifier="true"  data-type="numeric">Staff ID</th>
              <th data-column-id="first_name" data-formatter="pca-editable">First Name</th>
              <th data-column-id="last_name" data-formatter="pca-editable">Last Name</th>
              <th data-column-id="mobile_number" data-formatter="pca-editable commands">Mobile Number</th>
              <th data-column-id="phone_number" data-formatter="pca-editable">Phone Number</th>
              <th data-column-id="commands" data-formatter="commands" data-sortable="false">Commands</th>
            </tr>
          </thead>
        </table>
        <button  data-table_name='staff' data-action='createNew' type="button" class="btn btn-primary btn-sm test_button">Add New Staff</button>
        <script>
        $(document).ready(function(){
          $(function() {
            $(document).on('click', 'button.test_button', function(e){
              e.preventDefault();
              var table_name = $(this).data('table_name');
              var ajax_action = $(this).data('action');
              var data_to_send = {json_data:  JSON.stringify({
                 'table_name': table_name,
                 'ajax_action': ajax_action
                        })};
              $.post(ajax_url, data_to_send, function(returnData){
                console.log('Sucessfull Ajax Add ');
                $('#staff-data').bootgrid();
              }).fail(function(returnData){
                console.log('Faield Ajax Add');
              });
            });
          });
        });
        </script>
        <script>
          $(document).ready(function(){
            $(function(){
              var grid = $('#staff-data').bootgrid({
                ajax: true,
                navigation: 3,
                sorting: true,
                rowSelect: true,
                selection: true,
multiSelect: true,
rowSelect: true,
keepSelection: true,
                post: function(){
                  return{
                    table_name: 'staff',
                    parent_table_name: 'task',
                    parent_table_id: '1' ,
                    ajax_action: 'getGridData',
                    primary_key: 'staff_id',
                    sort:{'staff_id': 'desc'}
                  };
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
              }).on('click.rs.jquery.bootgrid', function(e, columns, row){
                console.log(e);
                console.log(columns);
                console.log(row);
              }).on("loaded.rs.jquery.bootgrid", function()
              {
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
              });
            });
          });
        </script>
      </div>
    </div>
  </div>
</div>
