<?php
  echo $data;

  $task_table_header = array(
    array('header_name'=> 'Task Id'),
    array('header_name' => 'Product Name (Product ID)'),
    array('header_name' => 'Product Quantity'),
    array('header_name' => 'Location'),
    array('header_name' => 'Staffs'),
    array('header_name' => 'Task Status')
  );
  $booking_table_header = array(
    array('header_name'=>'Booking Id'),
    array('header_name'=>'Location')
  );
  $customer_table_header = array(
    array('header_name'=>'Customer Name'),
    array('header_name'=>'Location')
  );
  $client_table_header = array(
    array('header_name'=>'First Name'),
    array('header_name'=>'Last Name'),
    array('header_name'=>'Location')
  );
  $customer_table_row = array(
    array(
      array('field_value'=>'Google'),
      array('field_value'=>'Kignston, Road')
    )
  );
  $client_table_row = array(
    array(
      array('field_value'=>'Madan'),
      array('field_value'=>'limbu'),
      array('field_value'=>'Kingston Road, London ')
    )
  );
  $booking_table_row = array(
    array(
      array('field_value'=>'1'),
      array('field_value'=>'Ashford, Kent, 44 Kings Road, TN23 9JJ')
    )
  );
  $task_table_row = array(
    array(
      array('field_value' => '1'),
      array('field_value' => 'Photography'),
      array('field_value' => '4'),
      array('field_value' => 'London, Picadely Cirus, T23 5UJ'),
      array('field_value' => 'Madan, Layfon, Wolfstien'),
      array('field_value' => 'Started')
    ),
    array(
      array('field_value' => '2'),
      array('field_value' => 'Printing'),
      array('field_value' => '22'),
      array('field_value' => 'Ashford, Kent, R35 4ET'),
      array('field_value' => 'Layfon'),
      array('field_value' => 'Complete')
    )
  );




?>
<div class="container">
  <div class="row">
    <div class="col-md-12">
<h4>Booking</h4>
<div class="divTableWrapper">
  <div class="divTable">
    <div class="divTableHeading">
      <div class="divTableRow">
      <?php      TableView::createTableHeader($booking_table_header);    ?>
    </div><!-- .divTableRow -->
    </div> <!-- .divTableHeading -->
    <div class="divTableBody">
      <?php       TableView::createTableRow($booking_table_row);   ?>
    </div><!-- .divTableBody -->
  </div><!-- .divTable -->
</div><!-- .divTableWrapper -->

</div><!-- .col-md-12 -->
</div><!-- .row -->
<br>
<div class="row">
  <div class="col-md-12">
    <h4>Task</h4>

<div class="divTableWrapper">
  <div class="divTable">
    <div class="divTableHeading">
      <div class="divTableRow">
      <?php      TableView::createTableHeader($task_table_header);    ?>
    </div><!-- .divTableRow -->
    </div> <!-- .divTableHeading -->
    <div class="divTableBody">
      <?php       TableView::createTableRow($task_table_row);   ?>
    </div><!-- .divTableBody -->
  </div><!-- .divTable -->
</div><!-- .divTableWrapper -->

    </div><!--.col-md-12-->
  </div><!-- .row -->

  <br>
  <div class="row">
    <div class="col-md-12">
      <h4>Customer</h4>

  <div class="divTableWrapper">
    <div class="divTable">
      <div class="divTableHeading">
        <div class="divTableRow">
        <?php      TableView::createTableHeader($customer_table_header);    ?>
      </div><!-- .divTableRow -->
      </div> <!-- .divTableHeading -->
      <div class="divTableBody">
        <?php       TableView::createTableRow($customer_table_row);   ?>
      </div><!-- .divTableBody -->
    </div><!-- .divTable -->
  </div><!-- .divTableWrapper -->

      </div><!--.col-md-12-->
    </div><!-- .row -->


    <br>
    <div class="row">
      <div class="col-md-12">
        <h4>Client</h4>

    <div class="divTableWrapper">
      <div class="divTable">
        <div class="divTableHeading">
          <div class="divTableRow">
          <?php      TableView::createTableHeader($client_table_header);    ?>
        </div><!-- .divTableRow -->
        </div> <!-- .divTableHeading -->
        <div class="divTableBody">
          <?php       TableView::createTableRow($client_table_row);   ?>
        </div><!-- .divTableBody -->
      </div><!-- .divTable -->
    </div><!-- .divTableWrapper -->

        </div><!--.col-md-12-->
      </div><!-- .row -->


</div><!-- .container -->









<button type="button" data-table_of= "task-table" class="btn btn-info front_end_button" >Add New Task</button>

<script>
  $(document).ready(function(){
    $(function() {

      var tableRowNumber = { number: 1};

      const taskFormProperties = {
        col2 : 'Madan',
        row2table : '<h1>Hello Friend</h1>'
      }

      function getTask(){
      return `
      <div class="separator">
        <div data-table_row_identity="" class="Table-row table-id-${tableRowNumber.number}-parent">
          <div data-child_table_row="table-id-${tableRowNumber.number}-child" class="Table-row-item expand">+</div>
          <div class="Table-row-item u-Flex-grow2" data-header="Header1">row1 col1</div>
          <div class="Table-row-item" data-header="Header2">${taskFormProperties.col2}</div>
          <div class="Table-row-item" data-header="Header3">row1 col3</div>
          <div class="Table-row-item" data-header="Header4">row1 col4</div>
          <div class="Table-row-item u-Flex-grow3" data-header="Header5">row1 col5</div>
          <div class="Table-row-item" data-header="Header6">row1 col6</div>
          <div class="Table-row-item" data-header="Header7">row1 col7</div>
        </div>
        <div style="display:none;" data-table_row_identity="" class="another-child Table-row table-id-${tableRowNumber.number}-child">
          <div class="Table-row-item">
              <div class="another-table">
                ${taskFormProperties.row2table}
              </div>
          </div>
        </div>
      </div>
      `;
    }
    //    $('.task-table>.Table-row').after(getTask());
    //    $(".another-child").hide();
    $('.Table').on('click', '.expand', function (e){
      e.preventDefault();
      var child_table_row = $(this).data('child_table_row');
      var child_row = $('.'+child_table_row);
      console.log('.expand clicekd');
      if($(child_row).is(":visible")){
        console.log(':viaisble section');
        $(child_row).hide();
        $(this).html("+");
      }else{
        console.log('show Section');

        $(child_row).show();
        $(this).html("-");
      }
    });


        $('.front_end_button').on('click', function(e){
          var table_of = $(this).data('table_of');
          tableRowNumber.number = tableRowNumber.number+1;
          $('.'+table_of).append(getTask());
        });
    });
});
</script>
