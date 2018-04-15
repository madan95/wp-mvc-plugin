<?php

?>
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="table-responsive booking-customer-client-table">
<table id="booking-data" class="table table-condensed table-hover table-striped ">
    <thead>
        <tr>
            <th data-column-id="booking_id" data-type="numeric">Booking ID</th>
            <th data-column-id="booking_location">Booking Location</th>
            <th data-column-id="booking_start_date" data-order="desc">Booking Start Date</th>
            <th data-column-id="booking_due_date" data-order="desc">Booking Due Date</th>
            <th data-column-id="customer_name" data-order="desc">Customer Name</th>
            <th data-column-id="customer_location" data-type="numeric">Customer Location</th>
            <th data-column-id="main_client_full_name">Contact Client Name</th>
            <th data-column-id="main_client_contact_number" data-order="desc">Contact Numbers</th>
            <th data-column-id="" data-formatter="commands" data-sortable="false">commands</th>

      </tr>
    </thead>
</table>

<script>
$(document).ready(function(){
  $(function() {
    var grid = $("#booking-data").bootgrid({
    ajax: true,
    navigation: 0,
    sorting: false,
    post: function ()
    {
        return {
            id: "<?php echo  $data ?>",
            table_name: "booking",
            primary_key: "<?php echo  $data ?>",
            ajax_action: 'getGridData'
        };
    },
    url: ajax_url,
    formatters: {
        "commands": function(column, row)
        {
            return "<button type=\"button\" class=\"btn btn-xs btn-default command-edit\" data-row-id=\"" + row.id + "\"><span class=\"fa fa-pencil\"></span></button> " +
                "<button type=\"button\" class=\"btn btn-xs btn-default command-delete\" data-row-id=\"" + row.id + "\"><span class=\"fa fa-trash-o\"></span></button>";
        }
    }
}).on("loaded.rs.jquery.bootgrid", function()
{
    /* Executes after data is loaded and rendered */
    grid.find(".command-edit").on("click", function(e)
    {
        alert("You pressed edit on row: " + $(this).data("row-id"));
    }).end().find(".command-delete").on("click", function(e)
    {
        alert("You pressed delete on row: " + $(this).data("row-id"));
    });
});
});
});
</script>

        </div><!-- .table-reponsive-custom -->
    </div><!-- .col-md-12 -->
  </div><!-- .row -->
  <br>
  <div class="row">
    <div class="col-md-12">
      <div class="table-responsive task-staff-product-table">
        <table id="task-data" class="table table-condensed table-hover table-striped ">
            <thead>
                <tr>
                    <th data-column-id="id" data-type="numeric" data-identifier="true">Task ID</th>
                    <th data-column-id="booking_id">Booking ID</th>
                    <th data-column-id="task_start_date" data-formatter="pca-editable-date">Task Start Date</th>
                    <th data-column-id="task_finish_date">Task Finish Date</th>
                    <th data-column-id="product_name" data-formatter="editable">Product Name</th>
                    <th data-column-id="product_cost">Product Cost</th>
                    <th data-column-id="product_quantity">Product Quantity</th>
                    <th data-column-id="task_location" >Task Location</th>
                    <th data-column-id="task_status">Task Status</th>
                    <th data-column-id="staff_names">Staff Names</th>
                    <th data-column-id="" data-formatter="commands" data-sortable="false">commands</th>
              </tr>
            </thead>
        </table>

        <script>
        $(document).ready(function(){
          $(function() {
            var grid = $("#task-data").bootgrid({
            ajax: true,
            navigation: 1,
            sorting: true,
            rowSelect: true,
            post: function ()
            {
                return {
                    id: "<?php echo  $data ?>",
                    table_name: "task",
                    main_table: "booking",
                    booking_id: <?php echo $data ?>,
                    primary_key: "<?php echo  $data ?>",
                    ajax_action: 'getGridData'
                };
            },
            url: ajax_url,
            formatters: {
                "commands": function(column, row)
                {
                    return "<button type=\"button\" class=\"btn btn-xs btn-default command-edit\" data-row-id=\"" + row.id + "\"><span class=\"fa fa-pencil\"></span></button> " +
                        "<button type=\"button\" class=\"btn btn-xs btn-default command-delete\" data-row-id=\"" + row.id + "\"><span class=\"fa fa-trash-o\"></span></button>";
                },
                "commands2":function(column, row){
                    var id = {id: row.id};
                    console.log(row.id);
                    var test=  '<button class="editable" >dd</button>';
                    return test;
                    ;
                },
                "editable2": function(column,row){
                  return `<div class="editable sendValue">${row.product_name}</div>`;
                  console.log(row);
                },
                "pca-editable-date": function(column, row){
                  return `<div data-type="date" class="pca-editable-date">${row[column.id]}</div>`;
                }
            }
        }).on("loaded.rs.jquery.bootgrid", function()
        {
        //  $(grid).find('.editable').editable();
          //$(grid).find('.editable').editable();
          grid.find('.pca-editable-date').editable({
            format: 'yyyy-mm-dd',
            viewformat: 'yyyy-mm-dd',
            datepicker:{
              weekStart: 1
            }
          });

          //grid.find('.editable-date').datepicker({});
            /* Executes after data is loaded and rendered */
            grid.find(".command-edit").on("click", function(e)
            {
                var row_id = $(this).data("row-id");
                $(grid).find('tr').each(function(){
                  console.log($(this).find('.sendValue').html());
                });
                alert("You pressed edit on row: " + $(this).data("row-id"));
            }).end().find(".command-delete").on("click", function(e)
            {
                alert("You pressed delete on row: " + $(this).data("row-id"));
            });
        });


        });
        });
        </script>
        <script>
        $(document).ready(function(){
          $(function() {
            $('#wat1').editable({
              type: 'text',
              pk: 1,
              url: '/post',
              title: 'Enter User Name'
            });
          });
        });
        </script>

        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Add New Task</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="task-form form" id="task-some-unique-id">
                  <d
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
<button id="wat" >dd</button>

        <button  data-booking_id="<?php echo  $data ?>" data-table_name='<?php echo 'task' ?>' data-action='register' type="button" class="btn btn-primary btn-sm test_button2" data-toggle="modal" data-target="#exampleModalCenter">
Add New Task
</button>
<button data-booking_id="<?php echo  $data ?>" data-table_name='task' data-action='createNew' type="button" class="btn btn-primary btn-sm test_button">
Create New Tasks
</button>
        <script>
        $(document).ready(function(){
          $(function() {
            $(document).on('click', 'button.test_button2', function(e){
              e.preventDefault();
              var table_name = $(this).data('table_name');
              var ajax_action = $(this).data('action');
              var booking_id = $(this).data('booking_id');
              var data_to_send = {json_data:  JSON.stringify({
                 'table_name': table_name,
                 'ajax_action': ajax_action,
                 'booking_id': booking_id
               })};
              $.post(ajax_url, data_to_send, function(returnData){
                console.log('Sucessfull Ajax Add ');
              }).fail(function(returnData){
                console.log('Faield Ajax Add');
              });

              console.log(table_name);
            });
          });
        });
        </script>
      </div>
    </div>
  </div>
</div><!-- .container-fluid -->
