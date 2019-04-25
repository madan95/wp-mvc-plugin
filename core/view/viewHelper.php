<?php
//crate generic modal box for edit and add
 function createModalBox($data, $type_data){
   if($type_data['modal_box_id']){ ?>
            <div id="<?php echo $type_data['modal_box_id'] ?>" class="modal fade">
    <?php  }else{     ?>
            <div id="modal-box" class="modal fade">
    <?php  }   ?>
       <div class="modal-dialog modal-lg">
           <div class="modal-content">
                <?php
                    if($type_data['modal_header']){
                      echo $type_data['modal_header'];
                    }else{
                      ?>
                      <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                      <?php
                    }
                  ?>
                 <?php
                   if($type_data['modal-body']){
                     echo $type_data['modal-body'];
                   }else{
                     echo '<div class="modal-body">';
                     echo '</div>';
                   }
                 ?>
       </div>
   </div>
 </div>
<?php
 }

 function createModalBoxHeader($title){
   ob_start();

   ?>
   <div class="modal-header">
     <h4 class="modal-title"><?php echo $title ?></h4>
       <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
   </div>
   <?php

   $body = ob_get_contents();
   ob_end_clean();
   return $body;
 }

 function createClearFix($data){
   ob_start();

   ?>
                          <div class="well clearfix">
                            <div class="pull-left"> <h4><?php echo $data['table_name_human_readable'] ?></h4> </div> <!-- .pull-left -->
                            <div class="pull-right">
                              <a href="<?php echo admin_url().'admin-post.php?action=custom_action&ajax_action=addPage&table_name='.$data['table_name_human_readable'] ?>">Visit New Add Page</a>

                              <button type="button" class="btn btn-xs btn-primary" id="command-add-<?php echo $data['unique_id'] ?>" data-row-id="0">
                              <span class="glyphicon glyphicon-plus"></span> Add New <?php echo $data['table_name_human_readable'] ?> </button>
                           </div> <!-- .pull-right -->
                            <div class="pull-right">
                              <button type="button" class="btn btn-xs btn-primary" id="command-add-<?php echo $data['unique_id'] ?>" data-row-id="0">
                              <span class="glyphicon glyphicon-plus"></span> Add New <?php echo $data['table_name_human_readable'] ?> </button>
                           </div> <!-- .pull-right -->
                        </div><!-- .clearfix -->

<?php
$body = ob_get_contents();
ob_end_clean();
return $body;
 }

 function createDownloadBtn($data){
   ob_start();

?>


                           <div id="test">
                              <form action="<?php echo admin_url().'admin-post.php'; ?>" method="post"  >
                                  <input type="hidden" name="action" value="custom_action">
                                  <input type="hidden" name="ajax_action" value="download_xml"><br>
                                  <input type="hidden" name="table_name" value="<?php echo $data['table_name']; ?>"><br>
                                  <input type="submit"  value="Download XML File">
                              </form>
                           </div>

                           <?php
                           $body = ob_get_contents();
                           ob_end_clean();
                           return $body;
 }

 function createBootGridTable($data){
   ob_start();

   ?>
   <div class="table-responsive">
 <table id="grid<?php echo $data['unique_id'] ?>" class="table-grid table table-condensed table-hover table-striped " width="100%" cellspacing="0" data-toggle="bootgrid">
   <thead>
     <tr>
<?php  foreach ($data['columns'] as $name => $type) {
           echo '<th  data-column-id='.$name.' data-type='.$type.'>'.str_replace("_", " ",$name).'</th>';
       }  ?>
       <th data-column-id="commands" data-formatter="commands" data-sortable="false"> Edit/Delete </th>
     </tr>
   </thead>
   <tbody>
     <!-- ajax to get result -->
   </tbody>
 </table> <!-- #grid -->
   </div><!-- .table-responsive -->
   <?php
   $body = ob_get_contents();
   ob_end_clean();
   return $body;
 }






 function containerWrapper($data){
   ob_start();

   ?>
   <div class="container-fluid">
     <div class="row">
       <div class="col-sm-12 ">
<?php
  echo  $data['body'];
?>
       </div>
     </div>
   </div>
         <?php
         $body = ob_get_contents();
         ob_end_clean();
         return $body;
 }
