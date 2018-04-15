<?php
 class Template{

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
     </div>
     <?php
   }
 }
