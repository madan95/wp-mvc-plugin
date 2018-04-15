<?php

class BootGrid{


//get array of data to create bootgrid table
  public static function createBootGridTable($data){
    ?>
    <div class='table-responsive <?php echo $data['table_name'] ?>'>
      <table id='<?php echo $data['table_name'] ?>-data' class='table table-condensed table-hover table-striped'>
        <thead>
          <tr>
            <?php
              BootGrid::createBootGridTH($data['table_columns']);
            ?>
          </tr>
        </thead>
      </table>
    </div>
    <?php
  }

//get array of table_columns to populate table head columns
  public static function createBootGridTH($data){

    Atom::createTableTH($column_key_value);
    foreach($data as $key => $column){     ?>
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
  }

  public static function create

}

?>
