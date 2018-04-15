<?php

class TableViewOld{


// Create Table Header for Mobile Friendly Table
public static function createTableHeader($header){
  foreach($header as $column_key => $column){
    ?>
    <div class="divTableHead">
      <?php echo $column['header_name'] ?>
    </div><!--.divTableHead-->
    <?php
  }//Header Columns Loop
}

// Create Table Row With Data
public static function createTableRow($table_row){
  foreach($table_row as $row_key => $row){  ?>
      <div class="divTableRow">
        <?php    foreach($row as $column_key => $column){   ?>
          <div class="divTableCell" >
            <?php echo $column['field_value'] ?>
          </div> <!--.divTableCell-->
        <?php }  ?>
    </div> <!--.divTableRow-->
  <?php } //Columns Loop
} //Rows Loop

}
?>
