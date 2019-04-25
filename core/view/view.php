<?php
/**
 * Created by PhpStorm.
 * User: Madan
 * Date: 18/12/2017
 * Time: 2:11 AM
 */


class view
{
    public function __construct() {
    }

    //create bootgrid lists
    public function displayList($data){
            ob_start();
              componentModalBox($data);
              componentListBody($data);
            $body = ob_get_contents();
            ob_end_clean();
            echo $body;
                 ?>
        <script>
                 $( document ).ready(function() {
                 jQuery(document).ready(function($){
                     var ajax_url = params.ajaxurl+'?action=custom_ajax';




                   var id = "";
                   var grid = $('#grid<?php echo $data['unique_id'] ?>').bootgrid({
                     ajax: true,
                     rowSelect: true,
                     post: function(){
                       return{
                         ajax_action: 'ajax_lists',
                         table_name: '<?php echo $data['table_name'] ?>',
                         primary_key: '<?php echo $data['primary_key'] ?>',
                         default_sort: 'desc'
                       };
                     },
                     selection: true,
                     multiSelect: true,
                     url: ajax_url,
                     formatters: {
                         "commands": function(column, row)
                         {
                             return "<button type=\"button\" class=\"btn btn-xs btn-default command-edit-<?php echo $data['unique_id'] ?>\" data-row-id=\"" + row.id + "\"><span class=\"glyphicon glyphicon-edit\"></span></button> " +
                                 "<button type=\"button\" class=\"btn btn-xs btn-default command-delete-<?php echo $data['unique_id'] ?>\" data-row-id=\"" + row.id + "\"><span class=\"glyphicon glyphicon-trash\"></span></button>" +
                                 "<button type=\"button\" class=\"btn btn-xs btn-default command-detail-<?php echo $data['unique_id'] ?>\" data-row-id=\"" + row.id + "\"><span class=\"glyphicon glyphicon-list\"></span></button>" +
                                 "<button type=\"button\" class=\"btn btn-xs btn-default command-view-<?php echo $data['unique_id'] ?>\" data-row-id=\"" + row.id + "\"><span class=\"glyphicon glyphicon-zoom-in\"></span></button>";
                         }
                     }
               }).on("loaded.rs.jquery.bootgrid", function(){
                 grid.find(".command-edit-<?php echo $data['unique_id'] ?>").on("click", function(e){
                   var ele =$(this).parent();
                   id = $(this).parent().siblings(':first').html();
                   $('#edit_model_<?php echo $data['unique_id'] ?>').modal('show');
                 })
                       grid.find(".command-view-<?php echo $data['unique_id'] ?>").on("click", function(e){
                     var ele =$(this).parent();
                     id = $(this).parent().siblings(':first').html();
                     $('#view_model_<?php echo $data['unique_id'] ?>').modal('show');
                 })



                       grid.find(".command-detail-<?php echo $data['unique_id'] ?>").on("click", function(e){
                           var ele =$(this).parent();
                           id = $(this).parent().siblings(':first').html();
                           $('#detail_model_<?php echo $data['unique_id'] ?>').modal('show');
                       })



                 .end().find('.command-delete-<?php echo $data['unique_id'] ?>').on('click', function(e){
                   id = $(this).parent().siblings(':first').html();
                   var conf = confirm('Delete <?php echo str_replace(TABLE_PREFIX, " ", $data['table_name']) ?> Item?');
                   alert(conf);
                  if(conf){
                    var dataToSend = {id: id, table_name: "<?php echo $data['table_name'] ?>", ajax_action: "ajax_delete" }
                    $.post(ajax_url, dataToSend, function (returnData) { $('table.table-grid').bootgrid('reload');  })
                        .fail(function (data) { console.log('not ok');  });
                  }
                 })
               });


                     //Detail
                     $('#detail_model_<?php echo $data['unique_id'] ?>').on('hidden.bs.modal', function(){
                         $('#detail_model_<?php echo $data['unique_id'] ?> .modal-body').empty();
                       //  $('table.table-grid').bootgrid('reload');
                     });
                     $('#detail_model_<?php echo $data['unique_id'] ?>').on('show.bs.modal', function(){
                         var dataToSend = {id: id, table_name: "<?php echo $data['table_name'] ?>", ajax_action: "ajax_detail" }
                         $.post(ajax_url, dataToSend, function (returnData) {

                             // $.listening(returnData);
    					 $('#detail_model_<?php echo $data['unique_id'] ?> .modal-body').append(returnData);
                         })
                             .fail(function (data) {  console.log('not ok');  });
                     });




                     //view
                     $('#view_model_<?php echo $data['unique_id'] ?>').on('hidden.bs.modal', function(){
                         $('#view_model_<?php echo $data['unique_id'] ?> .modal-body').empty();
                         //$('table.table-grid').bootgrid('reload');
                     });
                     $('#view_model_<?php echo $data['unique_id'] ?>').on('show.bs.modal', function(){
                         var dataToSend = {id: id, table_name: "<?php echo $data['table_name'] ?>", ajax_action: "ajax_view" }
                         $.post(ajax_url, dataToSend, function (returnData) {
                             $('#view_model_<?php echo $data['unique_id'] ?> .modal-body').append(returnData);  })
                             .fail(function (data) {  console.log('not ok');  });
                     });

               //edit
               $('#edit_model_<?php echo $data['unique_id'] ?>').on('hidden.bs.modal', function(){
                 $('#edit_model_<?php echo $data['unique_id'] ?> .modal-body').empty();
                 $('table.table-grid').bootgrid('reload');
               });
              $('#edit_model_<?php echo $data['unique_id'] ?>').on('show.bs.modal', function(){
               var dataToSend = {id: id, table_name: "<?php echo $data['table_name'] ?>", ajax_action: "ajax_edit" }
               $.post(ajax_url, dataToSend, function (returnData) {   $('#edit_model_<?php echo $data['unique_id'] ?> .modal-body').append(returnData);  })
                   .fail(function (data) {  console.log('not ok');  });
             });

           //add
           $( "#command-add-<?php echo $data['unique_id'] ?>" ).click(function() { $('#add_model_<?php echo $data['unique_id'] ?>').modal('show');  });
           $('#add_model_<?php echo $data['unique_id'] ?>').on('hidden.bs.modal', function(){
             $('#add_model_<?php echo $data['unique_id'] ?> .modal-body').empty();
             $('table.table-grid').bootgrid('reload');
           });
           $('#add_model_<?php echo $data['unique_id'] ?>').on('show.bs.modal', function(){
             var dataToSend = {table_name: "<?php echo $data['table_name'] ?>", ajax_action: "ajax_add_table" }
             $.post(ajax_url, dataToSend, function (returnData) {
             //  $.listening(returnData);
                var data = JSON.parse(returnData);
                $('#add_model_<?php echo $data['unique_id'] ?> .modal-body').append(data.body);
            //    $('#defaultOpen').hide();
            //    $('.modal.fade.in .tabStart').trigger('click');
              })
                 .fail(function (data) {   console.log('not ok');    });
           });

             });
           });

     </script>
     <?php
          }
















































    public function createTabs($data){
        ?>
        <div id="tabHolder-<?php echo $data['unique_id'] ?>">
            <div class="tab">
                 <button class="tablinks tablinks-<?php echo $data['unique_id'] ?>"  data-tabcontentname="1-tabcontent-id-<?php echo $data['unique_id'] ?>" data-uniqueid="<?php echo $data['unique_id'] ?>" id="defaultOpen">1</button>
                 <button id="tablinksAdd-<?php echo $data['unique_id'] ?>" class="tablinks tablinks-<?php echo $data['unique_id'] ?>"  data-tabcontentname="addNewTab" data-uniqueid="<?php echo $data['unique_id'] ?>"  >Add More <?php echo $data['table_name'] ?></button>
            </div>
            <div id="1-tabcontent-id-<?php echo $data['unique_id'] ?>" class="tabcontent-<?php echo $data['unique_id'] ?>">
                  <span onclick="this.parentElement.style.display='none'" class="topright">x</span>
                 <?php
                    foreach  ($data['fields'] as $fields){
                          echo '<label for="'.$fields['field_name'].'">'.$fields['field_name'].'</label><input type="'.get_input_data_type($fields['field_type']).'" name="'.$fields['field_name'].'" /><br />';
                     }
                     /*
                     foreach($data['child_nodes'] as $table){
                        foreach ($table['fields_to_show'] as  $fields){
                            echo '<label for="'.$fields['field_name'].'">'.$fields['field_name'].'</label><input type="'.get_input_data_type($fields['field_type']).'" name="'.$fields['field_name'].'" /><br />';
                        }
                     }*/
                 ?>
            </div>
        </div>
        <?
    }






	    public function create_booking_form_group($data){
        $form_group = '<button data-toggle="collapse" data-target="#form-group-'.$data["unique_id"].'">
                                   Open Form
                        </button>
                        <div id="form-group-'.$data["unique_id"].'" class="collapse">
                                   Form Group
                        </div>';
        return $form_group;
        ?>

        <?php
    }











 //edit Data form page
 public function create_form_edit_ajax($data){     ?>
 <form>
     <table>
         <?php
         $primary_key_value = 0;
         foreach ($data['result'] as $name => $value){
             if($name == $data['primary_key']){
                 $primary_key_value = $value;
                 echo "<tr><th>".str_replace("_", " ", $name)."</th><td><input type='text'  readonly='readonly' name='$name' value='$value'/></td></tr>";
             }else {
                 echo "<tr><th>".str_replace("_", " ", $name)."</th><td>" . data_type2html_type($data['columns'][$name], $name, $value) . "</td></tr>";
             }
         }
         ?>
     </table>
     <input type="hidden" name="table_name" value="<?php echo $data['table_name'] ?>">
     <input type="hidden" name="id" value="<?php echo $primary_key_value ?>">
     <input  class="ajaxBtn" type='button' name='ajax_update' value='Update' >
 </form>
 <div id="result"></div>
 <?php }












 //crate add form for ajax to add new row in a table view
  public function create_form_add_ajax2($data){
    if($data['new_id']==''){ $data['new_id'] = 1; }       ?>
          <form>
              <table>
                <?php
                 foreach($data['columns'] as $name => $type){
                      if($name == $data['primary_key']){
                          echo "<tr><th>".str_replace("_", " ", $name)."</th><td>". data_type2html_type($type, $name, $data['new_id']). "</td></tr>";
                      }else{
                          echo "<tr><th>".str_replace("_", " ", $name)."</th><td>". data_type2html_type($type, $name, ""). "</td></tr>";
                      }
                  }
               ?>
              <?php foreach($data['fk'] as $f){ ?>
                      <?php echo "<tr><th>".$f[0]."</th><td>" ?><input type="hidden" id="<?php echo $f[0] ?>" name="<?php echo $f[0] ?>" value="">
              <?php } ?>

              </table>
              <input type="hidden" name="table_name" value="<?php echo $data['table_name'] ?>">
              <input  id='ajaxBtn' class="ajaxBtn" type='button' name='ajax_insert' value='Save <?php echo str_replace(TABLE_PREFIX, "" ,$data['table_name'])?>' >
          </form>
          <div id="result"></div>
        </br>
          <?php// foreach($data['fk'] as $f){ ?>
          <!--  <form>
                <input type="hidden" name="table" value="<?php //echo $f[1] ?>">
                <input  id='ajaxBtn' class="ajaxBtn" type='button' name='ajax_add' value='Add New <?php //echo str_replace(TABLE_PREFIX, "" ,$f[1])?>' >
            </form> -->
      <?php// } ?>
    </br>

    <?php
    foreach($data['relate'] as $f){ ?>
      <form>
          <input type="hidden" name="table_name" value="<?php echo $f[1] ?>">
          <input class="ajaxBtn" type='button' name='ajax_add' value='Add New <?php echo str_replace(TABLE_PREFIX ,"" ,$f[1])?>' >
      </form>
  <?php
     }
   }


    public function create_form_add_ajax_relate_select2($data)
    {

     foreach($data['fk_nodes'] as $table) {
         $table_hr = $table['hr_table'];
         $table_name = $table['table_name'];
         $field_name = $table['pk'];
         $display_name = $table['display'];
         $json_data = [];
         $data_select2 = [];
         ?>
         <tr>
             <th>
                 <label for="id_select_<?php echo $table_hr ?>"> <?php echo $table_hr ?></label>
             </th>
             <td>
                 <select id="id_select_<?php echo $table_hr ?>" class="js-data-example-ajax" name='<?php echo $field_name ?>' style="width: 75%">
                     <option></option>
                 </select>
             </td>
         </tr>

         <?php
         foreach ($data['ids_names'][$table_name] as $item){
             if($item[$display_name]==""){
                 $item[$display_name] = "Field Empty ATM";
             }
             array_push($json_data, array('id' => $item[$field_name], 'text' => $item[$display_name]));
         }
         $data_select2 = json_encode($json_data);
         ?>
         <script>
             $( document ).ready(function() {
                 jQuery(document).ready(function($){
                     $('#id_select_<?php echo $table_hr ?>').select2({
                         minimumInputLength: 0,
                         placeholder: "Select ",
                         allowClear: true,
                         data: <?php echo $data_select2 ?>
                     });
                 })
             });
         </script>
         <?php
     }
    }
        public function create_form_add_ajax($data){
            if($data['new_id']==''){ $data['new_id'] = 1; }   ?>
     <div class="form-group">
       <form>
           <table>
               <?php
               foreach($data['columns'] as $name => $type){
                   if($name == $data['primary_key']){
                       echo "<tr><th>".str_replace("_", " ", $name)."</th><td><input id='primarykey' type='number' name='".$name."' value='".$data['new_id']."'/></td></tr>";
                //    echo "<tr><th>".str_replace("_", " ", $name)."</th><td>". data_type2html_type($type, $name, $data['new_id']). "</td></tr>";

                   }else{
                       echo "<tr><th>".str_replace("_", " ", $name)."</th><td>". data_type2html_type($type, $name, ""). "</td></tr>";
                   }
               }
               $this->create_form_add_ajax_relate_select2($data);
               $this->create_add_new_node($data);

               ?>
           </table>
           <input type="hidden" name="table_name" value="<?php echo $data['table_name'] ?>">
           <input  data-fk-id="<?php echo $data['primary_key'] ?>" id='ajaxBtn' class="ajaxBtn" type='button' name='ajax_insert' value='Save <?php echo str_replace(TABLE_PREFIX, "" ,$data['table_name'])?>' >
       </form>
         <div id="result"></div>
     </div><!-- .form-group -->
    <?php


    }

   public function create_add_new_node($data){
     foreach($data['fk_nodes'] as $node){
         if($node['table_name']!=$data['parent_table']) {
             echo $node['table_name'];
             echo $data['parent_table'];
             ?>
             <tr>
                 <th>
                     <label> <?php echo $node['pk'] ?></label>
                 </th>
                 <td>
                     <form>
                         <input type="hidden" name="table_name" value="<?php echo $node['table_name'] ?>">
                         <input data-table-name="<?php echo $node['table_name'] ?>" class="ajaxBtn2" name='ajax_add'
                                type="button" value="Add new node of <?php echo $node['table_name'] ?>">
                         <input
                                 class="ajaxBtn" name='ajax_add' type="button"
                                 value="Add existing node <?php echo $node['table_name'] ?>">
                     </form>
                 </td>
             </tr>
             <?php
             echo $node['table_name'];
         }
     }
   }















 public function addData($data){

   if($data['new_id']==''){ $data['new_id'] = 1; }       ?>
   <select class="js-data-example-ajax"></select>
   <script>
   $( document ).ready(function() {
   jQuery(document).ready(function($){
     var ajax_url = params.ajaxurl+'?action=custom_ajax';
     var data = [
       {
         id: 0,
         text: 'enchanment'
       },
       {
         id:1,
         text: 'bugy'
       },
       {
         id:2,
         text: 'undo'
       }
     ];
   $('.js-data-example-ajax').select2({
     ajax:{
       url: ajax_url,
       dataType: 'json',
       delay: 250,
       data: function(params){
         return {
           q: params.term,
           ajax_action: 'ajax_search',
           table_name: '<?php echo $data['table_name'] ?>'
         };
       },
       processResults: function(data){
         return {
           results: data
         };
       },
       cache: true
     },
     minimumInputLength: 2
   });

 })
});
   </script>
         <form>
             <table>
               <?php
                foreach($data['columns'] as $name => $type){
                     if($name == $data['primary_key']){
                         echo "<tr><th>".str_replace("_", " ", $name)."</th><td>". data_type2html_type($data['columns'][$name], $name, $data['new_id']). "</td></tr>";
                     }else{
                         echo "<tr><th>".str_replace("_", " ", $name)."</th><td>". data_type2html_type($data['columns'][$name], $name, ""). "</td></tr>";
                     }
                 }
              ?>
             <?php foreach($data['fk'] as $f){ ?>
                     <?php echo "<tr><th>".$f[0]."</th><td>" ?><input type="hidden" id="<?php echo $f[0] ?>" name="<?php echo $f[0] ?>" value="">
             <?php } ?>
             </table>
             <input type="hidden" name="table_name" value="<?php echo $data['table_name'] ?>">
             <input  id='ajaxBtn' class="ajaxBtn" type='button' name='insert' value='Save <?php echo str_replace(TABLE_PREFIX, "" ,$data['table_name'])?>' >
         </form>
         <div id="result"></div>
       </br>
         <?php// foreach($data['fk'] as $f){ ?>
         <!--  <form>
               <input type="hidden" name="table" value="<?php //echo $f[1] ?>">
               <input  id='ajaxBtn' class="ajaxBtn" type='button' name='ajax_add' value='Add New <?php //echo str_replace(TABLE_PREFIX, "" ,$f[1])?>' >
           </form> -->
     <?php// } ?>
   </br>
   <?php
   foreach($data['relate'] as $f){ ?>
     <form>
         <input type="hidden" name="table_name" value="<?php echo $f[1] ?>">
         <input  id='ajaxBtn' class="ajaxBtn" type='button' name='ajax_add' value='Add New <?php echo str_replace(TABLE_PREFIX ,"" ,$f[1])?>' >
     </form>
 <?php
  } ?>

 <?php    }






    //Search Buttons Displayed, Search for table name which
    public static function displaySearch(){
        ?>
        <select class="js-data-example-ajax"></select>
        <script>
        $( document ).ready(function() {
        jQuery(document).ready(function($){
          var ajax_url = params.ajaxurl+'?action=custom_ajax';
        $('.js-data-example-ajax').select2({
          ajax:{
            type: 'POST',
            url: ajax_url,
            dataType: 'json',
            delay: 250,
            data: function(params){
              return {
                q: params.term,
                ajax_action: 'ajax_search',
                table_name: '<?php echo $data['table_name'] ?>'
              };
            },
            processResults: function(data){
              return {
                results: data
              };
            },
            cache: true
          },
          tags: true

        });

      })
    });
        </script>
        <div class="container"
            <div class="row">
                <div class="col-md-12">
        <form  method='get' name='search'>
            <p class='search-box'>
                <input type="hidden" name="action" value="lists" />
                <input type='search' name='table_name' placeholder='Search Table Name&hellip;' value='' />
                <input type="submit" name="submit" value="Search" />
            </p>
        </form>
                </div>
            </div>
        </div>
        <?php
    }

    //add table Button
    public static function displayAddNew($table_name){
        ?>
        <div class="container"
            <div class="row">
                <div class="col-md-12">
                    <?php
                        echo '<a href="?action=add&table_name='.$table_name.'">Add New</a>';
                    ?>
            </div>
        </div>
        </div>
        <?php
    }

    //list of table
    public function displayListOld($result, $table_name, $columns, $primary_key){
        $this->displaySearch();
        $this->displayAddNew($table_name);
?>
<table class="table">
    <thead>
	<tr>
        <?php
        foreach ($columns as $name => $type) {
            echo '<th>'.$name.'</th>';
        }
        ?>
		</tr>
    </thead>
<tbody>
<?php
$primary_key_value = 0;
foreach($result as $row){
    echo '<tr>';
    foreach ($row as $k => $v){
        if($k == $primary_key){
            $primary_key_value = $v;
        }
        echo '<td>'.  $v . '</td>';
    }
   // echo '<td><button type="button" data-id="'.$primary_key_value.'"  data-table="'.$table_name.'" data-action="delete" >Delete</button></td>';
    echo '<td><a href="?action=edit&table='.$table_name.'&id='.$primary_key_value.'">Edit</a></td>';
    echo '</tr>';
}
?>
</tbody>
</table>
<?php
    }

    public function displayList2($data){
      //  $this->displaySearch();
        $this->displayAddNew($data['table_name']);
        ?>
        <table class="table">
            <thead>
            <tr>
                <?php

                foreach ($data['columns'] as $name => $type) {
                    echo '<th>'.$name.'</th>';
                }

                ?>
            </tr>
            </thead>
            <tbody>
            <?php
            $primary_key_value = 0;
            foreach($data['result'] as $row){
                echo '<tr>';
                foreach ($row as $k => $v){
                    if($k == $data['primary_key']){
                        $primary_key_value = $v;
                    }
                    echo '<td>'.  $v . '</td>';
                }
                // echo '<td><button type="button" data-id="'.$primary_key_value.'"  data-table="'.$table_name.'" data-action="delete" >Delete</button></td>';
                echo '<td><a href="?action=edit&table='.$data['table_name'].'&id='.$primary_key_value.'">Edit</a></td>';
                echo '</tr>';
            }
            ?>
            </tbody>
        </table>
        <?php
    }





//edit Data form page
public function editData($data){
    ?>
<form>
    <table>
        <?php
        $primary_key_value = 0;
        foreach ($data['result'] as $name => $value){
            if($name == $data['primary_key']){
                $primary_key_value = $value;
            //    echo "<tr><th>$name</th><td>".data_type2html_type($columns[$name], $name, $value)."</td></tr>";
                echo "<tr><th>".$name."</th><td><input type='text'  readonly='readonly' name='$name' value='$value'/></td></tr>";
            }else {
                echo "<tr><th>$name</th><td>" . data_type2html_type($data['columns'][$name], $name, $value) . "</td></tr>";
            }
        }
        ?>
    </table>
    <input type="hidden" name="table_name" value="<?php echo $data['table_name'] ?>">
    <input type="hidden" name="id" value="<?php echo $primary_key_value ?>">
    <input id='ajaxBtn' class="ajaxBtn" type='button' name='update' value='Update' >
    <input id='ajaxBtn' class="ajaxBtn" type='button' name='delete' value='Delete' >
</form>
<div id="result"></div>
<?php
}

    //edit Data form page
    public function editData2($result, $table_name, $columns, $primary_key){
        ?>
    <form>
        <table>
            <?php
            $primary_key_value = 0;
            foreach ($result as $name => $value){
                if($name == $primary_key){
                    $primary_key_value = $value;
                //    echo "<tr><th>$name</th><td>".data_type2html_type($columns[$name], $name, $value)."</td></tr>";
                    echo "<tr><th>".$name."</th><td><input type='text'  readonly='readonly' name='$name' value='$value'/></td></tr>";
                }else {
                    echo "<tr><th>$name</th><td>" . data_type2html_type($columns[$name], $name, $value) . "</td></tr>";
                }
            }
            ?>
        </table>
        <input type="hidden" name="table_name" value="<?php echo $table_name ?>">
        <input type="hidden" name="id" value="<?php echo $primary_key_value ?>">
        <input id='ajaxBtn' class="ajaxBtn" type='button' name='update' value='Update' >
        <input id='ajaxBtn' class="ajaxBtn" type='button' name='delete' value='Delete' >
    </form>
    <div id="result"></div>
<?php
    }

    //Add Data Page
    public function addData2($result, $table_name, $columns, $primary_key, $new_id, $fk){
        ?>
        <form>
            <table>
                <?php
                if($new_id==''){
                  $new_id = 1;
                }
                foreach($columns as $name => $type){
                    if($name == $primary_key){
                        echo "<tr><th>$name</th><td>". data_type2html_type($columns[$name], $name, $new_id). "</td></tr>";
                    }else{
                        echo "<tr><th>$name</th><td>". data_type2html_type($columns[$name], $name, ""). "</td></tr>";
                    }
                }
                ?>
                <?php foreach($fk as $f){ ?>
                    <?php echo "<tr><th>".$f[0]."</th><td>" ?><input type="text" id="<?php echo $f[0] ?>" name="<?php echo $f[0] ?>" value="">
                <?php } ?>
            </table>
            <input type="hidden" name="table_name" value="<?php echo $table_name ?>">
            <input  id='ajaxBtn' class="ajaxBtn" type='button' name='insert' value='Add' >
        </form>
        <div id="result"></div>
        <?php foreach($fk as $f){ ?>
          <form>
              <input type="hidden" name="table_name" value="<?php echo $f[1] ?>">
              <input  id='ajaxBtn' class="ajaxBtn" type='button' name='ajax_add' value='add <?php echo $f[1]?>' >
          </form>
    <?php } ?>
<?php
    }





    //Testing Only Function
    public function displayTask($task){
        echo '<h1> ' .$task.'</h1>';
    }

    public function modalBox(){
      ?>
      <div class="modal fade" id="empModal" role="dialog">
   <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
     <div class="modal-header">
       <button type="button" class="close" data-dismiss="modal">&times;</button>
       <h4 class="modal-title">User Info</h4>
     </div>
     <div class="modal-body">

     </div>
     <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
     </div>
    </div>
   </div>
  </div>
      <?php
    }
}
