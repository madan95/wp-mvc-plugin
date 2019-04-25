<?php
/**
 * Created by PhpStorm.
 * User: Madan
 * Date: 18/12/2017
 * Time: 2:17 AM
 */


class controller
{
    private $view;
    private $current_table_name;

    public function __construct()
    {
        $this->view = new view();
    }

    //factory method to create model of a particullar table
        public function createModel($table_name)
        {
            $model = new Model();
            $model->init($table_name);
            return $model;
        }


      //create lists of table using shortcode of wordpress
      public function lists($request)
        {
            $model = $this->createModel($request['table_name']);

            $table_name = $model->getTableName();
            $columns = $model->getColumns();
            $primary_key = $model->getPrimaryKey();
            $table_name_human_readable = $model->getTableNameNoPrefix();
            $unique_id = uniqid();

            $data = array(
                'table_name' => $table_name,
                'columns' => $columns,
                'primary_key' => $primary_key,
                'unique_id' => $unique_id,
                'table_name_human_readable' => $table_name_human_readable
            );

            $this->view->displayList($data);
        }


        //Used by bootgrid to get ajax_lists of json data
            public function ajax_lists($request)
            {
                $model = $this->createModel($request['table_name']);
                $data = $model->get_limited_row($request);
              console(json_encode($data));
              wp_send_json(json_encode($data));
            }








public function ajax_saver($request){
    //echo 'welldone';
    //print_r($request);

    $pk_id_name = '';
    $pk_id = '';
    $manytomany = false;
    $manytomany_table = '';
    $manytomany_child = '';
    $node = false;
    foreach($request['table'] as $table_name => $value ){
      $model = $this->createModel(TABLE_PREFIX.$table_name);
      if($value['relation_type'] == 'node'){
        $node = true;
      }else{
        $node = false;
      }
      foreach($value['table_row'] as $row){
        //if child
        //else get returned id and save it as parent id

     //if($db_create_booking[$table_name][0]['child_table']){
     if($node){
          $manytomany = false;
          $pk_id_name = $model->getPrimaryKey();
          $pk_id = $model->insert2($row);
          require TABLE_VARIABLES;
          console($table_name);
         if(${"db_$table_name"}['manytomany']){
            $manytomany = true;
            $manytomany_table = ${"db_$table_name"}['manytomany']['table'];
            $manytomany_child = ${"db_$table_name"}['manytomany']['child'];
         }else{
           console('Doont god');
         }
        }else{
          $row[$pk_id_name] = $pk_id;
          $child_pk_id_name = $model->getPrimaryKey();
          $child_pk_id = $model->insert2($row);
          $row[$child_pk_id_name] = $child_pk_id;
          if($manytomany == true && $table_name == $manytomany_child){
            $model_many = $this->createModel(TABLE_PREFIX.$manytomany_table);
            $model_many->insert2($row);
            console('TRUE TRUE TRUE Chidl');
            console($row);
          }
        }
        $row[$pk_id_name] = $pk_id;
    }
    require TABLE_VARIABLES;

    /*
    $pk_id_name = $model->get_primary_key();
    $pk_id = $request[$pk_id_name];
    $related = $model->get_relate();
    */
}

$data = array(
  'pk_id' => $pk_id,
  'pk_id_name' => $pk_id_name,
  'body' => '<input id="node-id-'.$pk_id_name.'" class="node-id" type="hidden" name="'.$pk_id_name.'" value="'.$pk_id.'">',
  'action' => 'hideBody'
);
wp_send_json(json_encode($data));
}









    public function ajax_add_table($request){
        ob_start();
        require TABLE_VARIABLES;
        echo '<div class="full-form" data-store="">';
      //  $this->ajax_loop_table_form($db_create_group_staff['']   db_create_booking[str_replace(TABLE_PREFIX, '', $request['table_name'])], 'normal');
// Group form
// staffs form
// Send
// G:[{fields , GS:[{ S1{fields}, S2{fields} ,S3{fields} }]}]
//or
// T1 : G ... , T2: S ... ,
// Returned Data :: Id's of Task's
// Check if Id's has empty field
// Check if current fields has booking-id fields

//If Group and Staff Send
//Check this Table Relationships
//


//customer (relationship = childs = client, booking )
// client (relationship = parent = customer )
// booking (relationship = paretnt = customer )
// create customer ( create customer set parent_id )
// create client ( create client if parents (set fk_fields = parent_id )else () )
// send back client id , set client id on browser


// group ( realationship = childs = task, groupstaff  )
// staff ( relationship = childs = groupstaff / many_to_many = groupstaff )
// groupstaff ( relationship = parents = group, staff)
// create group ( create group set group id )
// create staff ( create staff set staff id ) and (if many_to_many (create many_to_many))
// craete groupstaff ( if parents ( set fk_fields = parents_ids ) else () )
// set group id in browser for the task1

// produbct (relationship = childs = task)
// location (relationship = childs = task)
// task (relationship = parents = product, location)
// create group ( create group and store id ) set g_id for task in browser
// create product ( create product and store id ) set p_id for task in browser
// create location ( create location and store id ) set l_id for task in browser
// create task ( check if parents (set fk_fields = parent_id) else () )



// set all table name and id ( send by user )
// customer sends (task1, task2 ... , customer_id, booking_details)
// set customer_id
// booking ( relationship = parents = customer )
// create booking ( create booking if parents (set fk_fields = parent_id )else () )
// create task (check if parents (set fk_fields = parent_id)else ())



//JSON (action: create rows, tables : table1(customer1), table2(client1, client2, client3), )
//Check if table1 has relationship (many to many)
        $current_table_name =  str_replace(TABLE_PREFIX, '', $request['table_name']);
        $this->ajax_loop_table_form($db_create_booking[$current_table_name], 'normal');
        echo '<button type="button" data-ajax_action="ajax_saveMain" class="saveNode  addNew" data-table_name="'.$current_table_name.'">Save Main</button>';
        echo '</div>';
        $body = ob_get_contents();
        ob_end_clean();
        $data = array(
          'body' => $body,
          'extra' => 'story'
        );
     wp_send_json(json_encode($data));
    }

    public function ajax_loop_table_form($tables, $formType){
      foreach($tables as $table){
      echo '<div data-relation_type="tab" data-table_name="'.$table['table']['table_name'].'" class="formform '.$formType.' form-'.$table['table']['table_name'].'" >';
      if($formType == 'tab' && $table['table']['display']=='true'){
        require TABLE_VARIABLES;
        $data = array(
                  'fields' =>  $table['table']['fields_to_show'],
                  'unique_id' => uniqid(),
                  'table_name' => $table['table']['table_name']
              );
              ?>
          <div id="tabHolder-<?php echo $data['unique_id'] ?>" class="holder">
              <div class="tab new">
                   <button class="tablinks tablinks-<?php echo $data['unique_id'] ?>"  data-tabcontentname="0-tabcontent-id-<?php echo $data['unique_id'] ?>" data-uniqueid="<?php echo $data['unique_id'] ?>" id="defaultOpen-<?php echo $data['unique_id'] ?>">0</button>

                  <button id="tablinksAdd-<?php echo $data['unique_id'] ?>" class="tabStart-<?php echo $data['unique_id'] ?> tabStart tablinks tablinks-<?php echo $data['unique_id'] ?>"  data-tabcontentname="addNewTab" data-uniqueid="<?php echo $data['unique_id'] ?>"  >Add More <?php echo $data['table_name'] ?></button>
              </div>

              <div id="0-tabcontent-id-<?php echo $data['unique_id'] ?>" class="tabcontent-<?php echo $data['unique_id'] ?> tab-<?php echo $table['table']['table_name']?> " data-relation_type= "tab" data-table_name="<?php echo $table['table']['table_name']?>">
                  <span onclick="this.parentElement.style.display='none'" class="topright">x</span>
                  <?php
                  echo '<div data-relation_type="tab" data-table_name="'.$data['table_name'].'" class="table_inputs  '.$data['table_name'].'">';

                  foreach  ($data['fields'] as $fields){
                      echo '<label for="'.$fields['field_name'].'">'.$fields['field_name'].'</label><input type="'.get_input_data_type($fields['field_type']).'" name="'.$fields['field_name'].'" /><br />';
                  }
                  echo '</div>';
                  $this->create_inner_loop($table, $formType);
                  ?>
              </div>
          </div>
          <script>
            console.log('core is core');
            $('#defaultOpen-<?php echo $data['unique_id'] ?>').hide();
        //    $('#defaultOpen').css('display', 'none');
            $('.tabStart.tabStart-<?php echo $data['unique_id'] ?>').trigger('click');
          </script>
<?php
          }else {
              $this->create_inner_loop($table, $formType);
          }
          echo '</div>';
      }
    }

    public function create_inner_loop($table, $formType){
                      require TABLE_VARIABLES;
                      foreach ($table as $key => $value){
                          if($key == 'table'){
                              //echo 'Form = '.$value['table_name'] .' And Type = '.$formType.'<br>';
                              if($formType == 'normal'){
                                  //    echo ' normal';
                                  //    echo ' table_name : '.$value['table_name'];
                                  //    echo ' Type : '. $formType;

                                  //   print_r( $db_create_booking[$value['table_name']]);
                      //  foreach ($db_create_booking[$value['table_name']]['fields_to_show'] as $field){
                      echo '<div data-relation_type="node" data-table_name="'.$value['table_name'].'" class="table_inputs send-json '.$value['table_name'].'">';

                      foreach ($value['fields_to_show'] as $field){
                        echo '<label for="'.$field['field_name'].'">'.$field['field_name'].'</label>';
                        echo '<input type="'.get_input_data_type($field['field_type']).'" name="'.$field['field_name'].'" /><br />';
                                  }
                                  echo '</div>';

                              }else if($formType == 'node'){
                                $nodeData['ajax_action'] = 'create_node_form';
                                $nodeData['main_parent'] = $value['main_parent'];
                                $nodeData['table_name'] = $value['table_name'];
                                $nodeData['select2'] = $value['select2'];

                                  echo "<button data-action='new' type='button' data-json_data='".json_encode($nodeData)."' class='createForm addNew' data-table_name='".$value['main_parent']."' data-node-name='".$value['table_name']."'>Add new Node of ".$value['table_name']."</button>";
                                $nodeData['ajax_action']= 'add_existing_node';
                                  echo "<button data-action='existing' type='button' data-json_data='".json_encode($nodeData)."' class='addExisting' data-table_name='booking'>Add Exisiting of ".$value["table_name"]."</button>";
                              }else if($formType == 'tab'){
                                  if($value['display']=='true'){
                                  //     echo $value['table_name'];
                                  }
                              }
                              // $this->createForm($value, $formType);
                          }else if($key == 'fk_table') {
                              //   echo 'create new or existing node <br>';
                              //  echo '<div class="node">';
                              $this->ajax_loop_table_form($value, 'node');
                              // echo '</div>';
                          }else if($key == 'child_table') {
                              //  echo 'create tab for dadd more <br>';
                              //    echo '<div class="tab">';
                              //  print_r( $value);
                              $this->ajax_loop_table_form($value, 'tab');
                              //     echo '</div>';
                          }
                      }
    }


    public function create_node_form($request){
      $main_parent = $request["main_parent"];
      $table_name = $request["table_name"];
      require TABLE_VARIABLES;
      echo '<div class="node-form">';
      console($request["main_parent"]);
      $this->ajax_loop_table_form($db_create_booking[$table_name], 'normal');
              echo '<input id="node_id_'.$table_name.'_id" class="node-id" type="hidden" name="'.$table_name.'_id" value="" />';
              echo '<button type="button" data-ajax_action="ajax_saver" class=" saveNode addNew" data-table_name="booking">Save '.$table_name.'</button>';
              echo '</div>';
              echo '<br>';

  }

  public function add_existing_node($request){
    $model = $this->createModel(TABLE_PREFIX.$request['table_name']);
    $allValue = stdObjctToArray($model->select_all());
    $primaryKey = $model->getPrimaryKey();
    $select2Name = $request['select2'];

    //$id_name_pair = array_column(stdObjctToArray($allValue), $select2Name, $primaryKey);
    $map_array = array(
      'id' => $primaryKey,
      'text' => $select2Name
    );
  //  array_map('getIdAndText', stdObjctToArray($allValue), $map_array);

    $newArray = array_map(function($elem) use($primaryKey, $select2Name) {
      console($elem);
      console($primaryKey);
      console($select2Name);
      if($elem[$select2Name]){
        return array('id'=>$elem[$primaryKey], 'text'=>$elem[$select2Name]);
      }else{
        return array('id'=>$elem[$primaryKey], 'text'=>'null');
      }
    }, $allValue);
    console(json_encode($newArray));
    $data = array(
      'ajax_url' => admin_url( 'admin-ajax.php' ),
      'unique_id' => uniqid(),
      'id_name_pair' => json_encode($newArray),
      'input_id' => 'node_id_'.$request['table_name'].'_id'
    );
    //console(stdObjctToArray($allValue));
    //console($data['id_name_pair']);

    $this->create_input_select2($data);

    echo '<input id="node_id_'.$request["table_name"].'_id" class="node-id" type="hidden" name="'.$request["table_name"].'_id" value="" />';
  }


  public function create_input_select2($data){

    ?>
    <select class="form-control">
    </select>
    <script>
    jQuery(document).ready(function($){

      function formatID(item){
        if(!item.id){
          return item.text;
        }
        var fk_id = item.element.value;
        console.log(fk_id);
        console.log($(item.element).parent().parent());
        $(item.element).parent().parent().find('#<?php echo $data['input_id']?>').val(fk_id);
        console.log(<?php echo $data['input_id'] ?>);
        return item.text;

      }

        var data = <?php echo $data['id_name_pair'] ?>;
        console.log(data);
        $(".form-control").select2({
          data: data,
          templateSelection: formatID

            /*,
          createTag: function(params){
            var term = $.trim(params.term);
            if(term == ''){
              console.log('select2 term is null.')
              return null;
            }else{
              console.log('select2 term is not empty');
            }
            return{
              id: term,
              text: term,
              newTag: true
            }
          }*/
        });
        });
    </script>
    <?php

  }





        public function loopTableForm($tables, $formType){
            foreach($tables as $table){
            echo '<div class="formform '.$formType.'" >';
    if($formType == 'tab' && $table['table']['display']=='true'){
        require TABLE_VARIABLES;
        $data = array(
                        'fields' =>  $db_create_booking[$table['table']['fields_to_show']],
                        'unique_id' => uniqid(),
                        'table_name' => 'Tabed Table'
                    );
                    console($table['table']['table_name']);
                    console($data['fields']);
                    ?>
                <div id="tabHolder-<?php echo $data['unique_id'] ?>">
                    <div class="tab">
                         <button class="tablinks tablinks-<?php echo $data['unique_id'] ?>"  data-tabcontentname="0-tabcontent-id-<?php echo $data['unique_id'] ?>" data-uniqueid="<?php echo $data['unique_id'] ?>" id="defaultOpen">0</button>

                        <button id="tablinksAdd-<?php echo $data['unique_id'] ?>" class="tabStart tablinks tablinks-<?php echo $data['unique_id'] ?>"  data-tabcontentname="addNewTab" data-uniqueid="<?php echo $data['unique_id'] ?>"  >Add More <?php echo $data['table_name'] ?></button>
                    </div>

                    <div id="0-tabcontent-id-<?php echo $data['unique_id'] ?>" class="tabcontent-<?php echo $data['unique_id'] ?>">
                        <span onclick="this.parentElement.style.display='none'" class="topright">x</span>
                        <?php
                        foreach  ($data['fields'] as $fields){
                            echo '<label for="'.$fields['field_name'].'">'.$fields['field_name'].'</label><input type="'.get_input_data_type($fields['field_type']).'" name="'.$fields['field_name'].'" /><br />';
                        }
                        $this->createInnerLoop($table, $formType);

                        ?>
                    </div>
                </div>
    <?php
                }else {

                    $this->createInnerLoop($table, $formType);
                }
                echo '</div>';
            }

        }














    public function addPage($request){
      wp_head();
      echo createContainer('open');
      $current_table_name = $request['table_name'];
        echo '<div class="full-form">';
          require TABLE_VARIABLES;
          $this->loopTableForm(${"db_create_$current_table_name"}['form'], 'normal');
        echo '<button type="button" class="addNew btn btn-primary btn-lg btn-block" data-table_name="'.$table_name.'">Save New '.$table_name.'</button>';
      echo '</div>';
      echo createContainer('close');
      wp_footer();
    }

    public function loopTableForm2($tables, $formType){
      $return_inner = "";

        foreach($tables as $table){
            echo '<div class="formform '.$formType.'" >';
            if($formType == 'tab' && $table['table']['display']=='true'){
                require TABLE_VARIABLES;
                $data = array(
                    'fields' =>  $db_create_booking[$table['table']['fields_to_show']],
                    'unique_id' => uniqid(),
                    'table_name' => 'Add new '. $db_create_booking[$table['table']['table_name']]
                );

                ?>

            <div id="tabHolder-<?php echo $data['unique_id'] ?>">
                <div class="tab">
                    <button style="display: none;" class="tablinks tablinks-<?php echo $data['unique_id'] ?>"  data-tabcontentname="0-tabcontent-id-<?php echo $data['unique_id'] ?>" data-uniqueid="<?php echo $data['unique_id'] ?>" id="defaultOpen">0</button>
                    <button class="tablinks tablinks-<?php echo $data['unique_id'] ?>"  data-tabcontentname="1-tabcontent-id-<?php echo $data['unique_id'] ?>" data-uniqueid="<?php echo $data['unique_id'] ?>" id="defaultOpen">1</button>
                    <button id="tablinksAdd-<?php echo $data['unique_id'] ?>" class="tabStart tablinks tablinks-<?php echo $data['unique_id'] ?>"  data-tabcontentname="addNewTab" data-uniqueid="<?php echo $data['unique_id'] ?>"  >Add More <?php echo $data['table_name'] ?></button>
                </div>
                <div style="display: none;" id="0-tabcontent-id-<?php echo $data['unique_id'] ?>" class="tabcontent-<?php echo $data['unique_id'] ?>">
                    <span onclick="this.parentElement.style.display='none'" class="topright">x</span>
                    <?php
                    foreach  ($data['fields'] as $fields){
                        echo '<label for="'.$fields['field_name'].'">'.$fields['field_name'].'</label><input type="'.get_input_data_type($fields['field_type']).'" name="'.$fields['field_name'].'" /><br />';
                    }
                    $return_inner = $this->createInnerLoop2($table, $formType);
                    ?>
                </div>
                <div style="display: none;" id="1-tabcontent-id-<?php echo $data['unique_id'] ?>" class="tabcontent-<?php echo $data['unique_id'] ?>">
                    <span onclick="this.parentElement.style.display='none'" class="topright">x</span>
                    <?php
                    foreach  ($data['fields'] as $fields){
                        echo '<label for="'.$fields['field_name'].'">'.$fields['field_name'].'</label><input type="'.get_input_data_type($fields['field_type']).'" name="'.$fields['field_name'].'" /><br />';
                    }
                    $return_inner;
                    ?>
                </div>
            </div>
<?php
            }else {
                $this->createInnerLoop2($table, $formType);
            }
            echo '</div>';
        }
    }

    public function createNodeForm2($tableName){
        echo '<div class="form-group">';
        echo '<h2>'.$tableName.'</h2>';
        echo '<button class="nodeBtn" type="button" data-table_name="'.$tableName.'" data-ajax_action="nodeNew">Add new </button>';
        echo '<button class="nodeBtn" type="button" data-table_name="'.$tableName.'" data-ajax_action="nodeExisting">Add Exsiting</button>';
        echo '</div>';
    }


        public function createInnerLoop2($table, $formType){
          console('CREATE INNER LOOP');

            require TABLE_VARIABLES;

            foreach ($table as $key => $value){
                if($key == 'table'){
                    //echo 'Form = '.$value['table_name'] .' And Type = '.$formType.'<br>';
                    if($formType == 'normal'){
                        //    echo ' normal';
                        //    echo ' table_name : '.$value['table_name'];
                        //    echo ' Type : '. $formType;

                        //   print_r( $db_create_booking[$value['table_name']]);
            //  foreach ($db_create_booking[$value['table_name']]['fields_to_show'] as $field){
            foreach ($value['fields_to_show'] as $field){

          echo '<label for="'.$field['field_name'].'">'.$field['field_name'].'</label>';
          echo '<input type="'.get_input_data_type($field['field_type']).'" name="'.$field['field_name'].'" /><br />';
                        }
                    }else if($formType == 'node'){
                      $nodeData['ajax_action'] = 'createNodeForm';
                      $nodeData['main_parent'] = $value['main_parent'];
                      $nodeData['table_name'] = $value['table_name'];
                      $nodeData['select2'] = $value['select2'];
                        echo "<button type='button' data-json_data='".json_encode($nodeData)."' class='createForm addNew' data-table_name='".$value['main_parent']."' data-node-name='".$value['table_name']."'>Add new Node of ".$value['table_name']."</button>";
                        echo '<button type="button" class="addExisting" data-table_name="booking">Add Exisiting of '.$value['table_name'].'</button>';
                    }else if($formType == 'tab'){
                        if($value['display']=='true'){
                        //     echo $value['table_name'];
                        }
                    }
                    // $this->createForm($value, $formType);
                }else if($key == 'fk_table') {
                    //   echo 'create new or existing node <br>';
                    //  echo '<div class="node">';
                    $this->loopTableForm2($value, 'node');
                    // echo '</div>';
                }else if($key == 'child_table') {
                    //  echo 'create tab for dadd more <br>';
                    //    echo '<div class="tab">';
                    //  print_r( $value);

                    $this->loopTableForm2($value, 'tab');
                    //     echo '</div>';
                }
            }

        }



























    public function createFormGroup($table){
        ?>
        <div id="tableFields">
        <?php
            foreach ($table as $table_fields => $value){
                if($table_fields == "fields"){
                    foreach ($value as $key => $input_field){
                        $this->createInput($input_field);
                    }
                }
            }
            ?>
        </div>
        <?php
    }

    public function createInput($input_field){
        echo '<label for="$value">'.$input_field.'</label><input type="text" name="'.$input_field.'" /><br />';
    }








    public function ajax_add($request){
      ob_start();
        require TABLE_VARIABLES;
        echo '<div class="full-form" data-store="">';

        $this->loopTableForm($db_create_booking[str_replace(TABLE_PREFIX, '', $request['table_name'])], 'normal');

        echo '<button type="button" class="  saveNode  addNew" data-table_name="booking">Save Node</button>';
        echo '</div>';
/*
        echo '
        <button>+</button>
        <table id="table">

      </table>';



      echo "<script>

  var data = [{
    'booking_id': '1.1',
    'booking_name': '1.2',
    'nested': [{
      'col3': '1.3',
      'col4': '1.4',
      'col5': '1.5'
    }]
  }, {
    'booking_id': '2.1',
    'booking_name': '2.2',
    'nested': [{
      'col3': '2.3',
      'col4': '2.4',
      'col5': '2.5'
    }]
  }, {
    'col1': 'lucy',
    'col2': 'ivan',
    'nested': [{
      'col3': 'garry',
      'col4': 'jules',
      'col5': 'larry',
      'other': [{
        'col6': 'garry',
        'col7': 'jules',
      }]
    }]
  }]


  var table = $('#table');
  $(function() {

    table.bootstrapTable({
      columns: [{
        field: 'booking_id',
        title: 'Booking ID'
      }, {
        field: 'booking_name',
        title: 'Booking Name'
      }],
      data: data,
      detailView: true,
      onExpandRow: function(index, row, detail) {
        console.log(row)
        console.log(detail);
        console.log(index);
        detail.html('<button>+</button><table></table>').find('table').bootstrapTable({
          columns: [{
            field: 'task_id',
            title: 'Task ID'
          }, {
            field: 'task_name',
            title: 'Task Name'
          }, {
            field: 'task_end',
            title: 'Task_End'
          }],
          data: row.nested,
          // Simple contextual, assumes all entries have further nesting
          // Just shows example of how you might differentiate some rows, though also remember row class and similar possible flags
          detailView: row.nested[0]['other'] !== undefined,
          onExpandRow: function(indexb, rowb, detailb) {
            detailb.html('<button>+</button><table></table>').find('table').bootstrapTable({
              columns: [{
                field: 'another_one',
                title: 'Another One'
              }, {
                field: 'another_one',
                title: 'Another One'
              }],
              data: rowb.other
            });
          }
        });

      }
    });
  });

      </script>";
      $out1 = ob_get_contents();
      ob_end_clean();
      //echo $out1;
      $var['name'] = 'madan';
      $var['body'] = $out1;
      echo json_encode($var);
          console($out1);
        /*
            $table_name_row = str_replace(TABLE_PREFIX, '', $request['table_name']);
            require TABLE_VARIABLES;
            ?>
            <div id="createForm">
            <?php
            foreach (${"db_create_$table_name_row"} as $table){
                $this->createFormGroup($table);
            }
            ?>
                <input class="createBtn" type="button" value="Submit" onclick="" />
            </div>
            <?php

            $this->view->createtab();

            /* $create_table_row_name = $request['table_name'];

             if(table.hasChild($create_table_row_name)){
                 create
             }

             require TABLE_VARIABLES;

             $tables = array();
             foreach ($db_tables as $table_name){
                 $tables[$table_name] = ${"db_$table_name"};
                 //   array_push($tables, $table_name => ${"db_$table_name"});
             }
            // print_r($tables);
             foreach($tables as $table) {
                 array_walk($table, array($this, 'walk_array_table'));
             }*/
    }


    public function createInnerLoop($table, $formType){
      console('CREATE INNER LOOP');

        require TABLE_VARIABLES;

        foreach ($table as $key => $value){
            if($key == 'table'){
                //echo 'Form = '.$value['table_name'] .' And Type = '.$formType.'<br>';
                if($formType == 'normal'){
                    //    echo ' normal';
                    //    echo ' table_name : '.$value['table_name'];
                    //    echo ' Type : '. $formType;

                    //   print_r( $db_create_booking[$value['table_name']]);
        //  foreach ($db_create_booking[$value['table_name']]['fields_to_show'] as $field){
        foreach ($value['fields_to_show'] as $field){

      echo '<label for="'.$field['field_name'].'">'.$field['field_name'].'</label>';
      echo '<input type="'.get_input_data_type($field['field_type']).'" name="'.$field['field_name'].'" /><br />';
                    }
                }else if($formType == 'node'){
                  $nodeData['ajax_action'] = 'createNodeForm';
                  $nodeData['main_parent'] = $value['main_parent'];
                  $nodeData['table_name'] = $value['table_name'];
                  $nodeData['select2'] = $value['select2'];
                    echo "<button type='button' data-json_data='".json_encode($nodeData)."' class='createForm addNew' data-table_name='".$value['main_parent']."' data-node-name='".$value['table_name']."'>Add new Node of ".$value['table_name']."</button>";
                    echo '<button type="button" class="addExisting" data-table_name="booking">Add Exisiting of '.$value['table_name'].'</button>';
                }else if($formType == 'tab'){
                    if($value['display']=='true'){
                    //     echo $value['table_name'];
                    }
                }
                // $this->createForm($value, $formType);
            }else if($key == 'fk_table') {
                //   echo 'create new or existing node <br>';
                //  echo '<div class="node">';
                $this->loopTableForm($value, 'node');
                // echo '</div>';
            }else if($key == 'child_table') {
                //  echo 'create tab for dadd more <br>';
                //    echo '<div class="tab">';
                //  print_r( $value);

                $this->loopTableForm($value, 'tab');
                //     echo '</div>';
            }
        }

    }

    public function createNodeForm($request){
      $main_parent = $request['main_parent'];
      $table_name = $request['table_name'];
      require TABLE_VARIABLES;
      echo '<div class="node-form">';

      $this->loopTableForm($db_create_booking[$table_name], 'normal');

              echo '<button type="button" class=" saveNode addNew" data-table_name="booking">Save</button>';
              echo '</div>';
              echo '<br>';
    //  $json_data->body = '<div class="form">hi</div>';
    //  $json_data->action = 'happy';
    //  echo json_encode($json_data);

  }

  public function loopTableCreate($variable){
    require TABLE_VARIABLES;
    foreach ($variable as $key => $value) {
      # code...
    }
  }




    public function createForm($tableName, $formType){
        switch ($formType){
            case 'normal':
                $this->createNormalForm($tableName);
                break;
            case 'node':
              //  echo $tableName.'node';
         //       $this->createNodeForm($tableName);
                break;
            case 'tab':
                //echo $tableName.'   tab     ';
                $this->createTabForm($tableName);
                break;
        }
    }


    public function ajax_view_outstanding_task($request){
        $group = $request['group_id'];
        $booking = $request['booking_id'];
        $staff= $request['staff_id'];
    }
    public function ajax_view($request){
        $task_model = $this->createModel(TABLE_PREFIX.'task');
      //  $group_model=$this->createModel($request['table_name']);
       // $group_model_pk = $group_model->get_primary_key();
     //   $task_model_row = $task_model->get_row_specific($group_model_pk,$request['id']);
       // print_r($task_model_row);

        $key_word = array(
            'date_finish' => 'IS NULL',
            'group_id' => $request['id']
        );
        $task_model_row = $task_model->select_condition2($key_word);
        print_r($task_model_row);



/*        $delimiter = ",";
        $filename = "export_".date('Y-m-d').'.csv';

        $f = fopen('php://memory', 'w');
        $fields = array();

        foreach($model->get_columns() as $k => $v){
            array_push($fields, $v);
        }

        fputcsv($f, $fields, $delimiter);

        foreach ($select_all as $k => $v){
            $lineData = [];
            foreach ($v as $k => $value){
                array_push($lineData, $value);
            }
            fputcsv($f, $lineData, $delimiter);
        }

        fseek($f, 0);

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="'.$filename.'";');

        fpassthru($f);
*/
/*
        $csv_export = '';
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename=csvtable.csv;");
        $model = $this->createModel(TABLE_PREFIX. 'booking');
        foreach ($model->get_columns() as $name => $type) {
            $csv_export .= ($name . DELMITER);
        }
        $csv_export .=(NEW_LINE);

        foreach ($model->select_all() as $row ){
            foreach ($row as $k => $v ) {
                $str = preg_replace('/"/', '""', $v);
                $csv_export .=("\"" . mb_convert_encoding($str, 'UTF-8', 'UTF-8')."\"" . DELMITER);
            }
            echo $csv_export;
        }

*/
    }


	   public function ajax_detail3($request)
    {
        $unique_id = uniqid();
        $data = array(
            'unique_id' => $unique_id
        );

        $form = $this->view->create_booking_form_group($data);
        $response_array = array(
            'view' => $form,
            'name' => 'madan'
        );
        echo json_encode ( $response_array );
    }

    public function ajax_detail2($request){
       // if($request['table_name']==TABLE"")
        //Get Booking Detail
        //Get Customer Related to Booking
        //Get Clients Related to Customer
        //Get Tasks Related to Booking Detail
        //Get Product / Location / Group Related to Task
        //Get Staffs Releated to Group
        $unique_id = uniqid();
        $data = array(
          'unique_id' => $unique_id
        );
        $this->create_booking($request);
        $this->view->create_booking($data);
       /* if($request['table_name'] == TABLE_PREFIX."booking") {
            $booking_id = $request['id'];

            $booking_model = $this->createModel($request['table_name']);
            $customer_model = $this->createModel(TABLE_PREFIX.'customer');
            $client_model = $this->createModel(TABLE_PREFIX.'client');
            $task_model = $this->createModel(TABLE_PREFIX. 'task');

            $booking_row = $booking_model->get_row($booking_id);
            $customer_id = $booking_row->customer_id;

            $customer_row = $customer_model->get_row($customer_id);

            $client_row = $client_model->get_row_related($customer_model->get_primary_key(), $customer_id);

            $task_row = $task_model->get_row_related($booking_model->get_primary_key(), $booking_id);

            print_r($booking_row);
            echo '<br>';
            print_r($customer_row);
            echo '<br>';
            print_r($client_row);
            echo '<br>';
            print_r($task_row);

            }*/
    }

    public function create_booking($request){
        $booking_model = $this->createModel(TABLE_PREFIX.'booking');
        $customer_model = $this->createModel(TABLE_PREFIX.'customer');
        $client_model = $this->createModel(TABLE_PREFIX.'client');
        $task_model = $this->createModel(TABLE_PREFIX. 'task');
        $product_model = $this->createModel(TABLE_PREFIX. 'product');
        $location_model = $this->createModel(TABLE_PREFIX. 'location');
        $group_model = $this->createModel(TABLE_PREFIX. 'group');
        $staff_model = $this->createModel(TABLE_PREFIX. 'staff');
        $groupstaff_model = $this->createModel(TABLE_PREFIX. 'groupstaff');

        $booking_columns = $booking_model->get_columns();
        $task_columns = $task_model->get_columns();
        $customer_columns = $customer_model->get_columns();

        print_r($booking_columns);
        echo '<br>';
        print_r($task_columns);
        echo '<br>';
        print_r($customer_columns);
        echo '<br>';
    }





//delete data row in bootgrid
    public function ajax_delete($request)
    {
        $model = $this->createModel($request['table_name']);
        $result = $model->delete($request['id']);
        if ($result) {
            echo 'Data Deleted';
        } else {
            echo 'Could not Delete';
        }
    }

//get editable form for bootgrid modalbox using ajax
    public function ajax_edit($request)
    {
        $model = $this->createModel($request['table_name']);
        $result = $model->get_row($request['id']);
        $table_name = $model->get_table_name();
        $columns = $model->get_columns();
        $primary_key = $model->get_primary_key();
        $unique_id = uniqid();
        $data = array(
            'result' => $result,
            'table_name' => $table_name,
            'columns' => $columns,
            'primary_key' => $primary_key,
            'unique_id' => $unique_id
        );
        $this->view->create_form_edit_ajax($data);
    }

    //update existing row of table
    public function ajax_update($request)
    {
        $model = $this->createModel($request['table_name']);
        $result = $model->update($request);
        if ($result) {
            echo 'Data Updated';
        } else {
            echo 'Data Not Changed';
        }
    }

//insert new row to table
    public function ajax_insert($request)
    {
        $model = $this->createModel($request['table_name']);
        $result = $model->insert($request);
        $pk_id_name = $model->get_primary_key();
        $pk_id = $request[$pk_id_name];
        $related = $model->get_relate();
        if ($result == true) {
            if ($related) {
                foreach ($related as $key => $value) {
                    foreach ($value as $key => $value) {
                        if ($key == 'table_name') {
                            $table_names['table_name'] = $value;
                            $table_names['parenttable_name'] = $request['table_name'];
                            $this->ajax_add2($table_names);
                        }
                    }
                }
            } else {
                echo 'sucess';
            }
            //echo 'Inserted New Row '.$related;
            // print_r($related);
            //$results = json_decode($request['extra_tables'], true);
            //  print_r($results);
            //   echo($request['extra_tables']);
            //  echo $request['extra_table'];
            //echo 'Inserted New Row '.$related;
            //  echo($related[0]['table_name']);
            ////    $this->ajax_add($related[0]['table_name']);
        } else {
            //   $extra =  $related[0]['table_name'];
            foreach ($related as $key => $value) {
                foreach ($value as $key => $value) {
                    if ($key == 'table_name') {
                        $table_names['table_name'] = $value;
                        $this->ajax_add($table_names);
                    }
                }
            }
            //   print_r($extra);
            // $this->ajax_add($extra);
            //   $related = $model->get_relate();
            //echo 'Inserted New Row '.$related;
            //   echo($related[0]['table_name']);
            //   $this->ajax_add($related[0]['table_name']);
            //     echo 'Failed Adding new ';
//  $related = $model->get_relate();
            //echo 'Inserted New Row '.$related;
//  echo($related[0]['table_name']);
            //echo $realted[0]['table_name'];
            //print_r($realted);
//  $this->ajax_add($related[0]['table_name']);
        }
    }


    public function get_relate_id_name($relate_item)
    {
        $ids_names = array(
            'table1' => array(
                array('id' => 1, 'name' => 'something'),
                array('id' => 2, 'name' => 'anotherthing')
            ),
            'table2' => array(
                array('id' => 1, 'name' => 'something'),
                array('id' => 2, 'name' => 'anotherthing')
            )
        );
        $table_name = $relate_item['table_name'];
        $display_name = $relate_item['display'];
        $table_rows = [];

        $temp_model = $this->createModel($table_name);
        $primary_key = $temp_model->get_primary_key();
        $result = $temp_model->select_all();

        foreach ($result as $row) {
            $table_row = [];
            foreach ($row as $field_name => $field_value) {
                if ($field_name == $primary_key) {
                    $table_row[$relate_item['pk']] = $field_value;
                } elseif ($field_name == $display_name) {
                    $table_row[$relate_item['display']] = $field_value;
                }
            }
            array_push($table_rows, $table_row);
        }
        return $table_rows;
    }


    public function ajax_search($get, $model)
    {
        $data[] = array('id' => '1', 'text' => 'hello');
        echo json_encode($data);
    }

    public function lists2($get, $model)
    { //Lists all the data from the table
        $result = $model->select_all();
        $table_name = $model->get_table_name();
        $columns = $model->get_columns();
        $primary_key = $model->get_primary_key();
        $new_id = $model->get_new_id();
        $unique_id = uniqid();
        $table_name_human_readable = str_replace(TABLE_PREFIX, "", $table_name);
        $data = array(
            'result' => $result,
            'table_name' => $table_name,
            'columns' => $columns,
            'primary_key' => $primary_key,
            'unique_id' => $unique_id,
            'table_name_human_readable' => $table_name_human_readable
        );
        $this->view->displayList($data);

        $data = array(
            'unique_id' => $unique_id,
            'table_name_human_readable' => $table_name_human_readable
        );

        $type_action = "add";
        $this->view->create_modal_box($data, $type_action);
        $type_action = "edit";
        $this->view->create_modal_box($data, $type_action);
    }


    public function edit($get, $model)
    { //Gets Edit Page for A table
        $result = $model->get_row($get['id']);
        $table_name = $model->get_table_name();
        $columns = $model->get_columns();
        $primary_key = $model->get_primary_key();
        $unique_id = uniqid();
        $data = array(
            'result' => $result,
            'table_name' => $table_name,
            'columns' => $columns,
            'primary_key' => $primary_key,
            'unique_id' => $unique_id
        );
        $this->view->edit_modal_box($data);
        //  $this->view->editData($result, $table_name, $columns, $primary_key);
    }


    public function add($get, $model)
    { //add page for a table
        $result = $model->get_row($get['id']);
        $table_name = $model->get_table_name();
        $columns = $model->get_columns();
        $primary_key = $model->get_primary_key();
        $new_id = $model->get_new_id();
        $fk = $model->get_fk_table_name($table_name);
        $relate = $model->get_relate($table_name);
        $columns = remove_fk_from_columns($columns, $fk);
        $columns = remove_fk_from_columns($columns, $relate);
        $data = array(
            'result' => $result,
            'table_name' => $table_name,
            'columns' => $columns,
            'primary_key' => $primary_key,
            'new_id' => $new_id,
            'fk' => $fk,
            'relate' => $relate
        );
        $this->view->addData($data);
        //  $this->view->addData($result, $table_name, $columns, $primary_key, $new_id, $fk);
    }


    public function delete($get, $model)
    { //delete a row from table
        $result = $model->delete($get['id']);
        if ($result) {
            echo 'Data Deleted';
        } else {
            echo 'Could not Delete';
        }
    }

    public function download_xml($request){
        $model = $this->createModel($request['table_name']);
        $res = $model->select_all();
        $file_name = str_replace(TABLE_PREFIX, '', $request['table_name']).date('-Y-m-d-h.i.sa');
        $xml = new XMLWriter();

        $xml->openURI("php://output");
        // $xml->openURI(BASEPATH. '/tmp/'.date("Y-m-d-h.i.sa-").'test.xml');
        $xml->startDocument();
        $xml->setIndent(true);


        foreach ($res as $row) {
            $xml->startElement(str_replace(TABLE_PREFIX, '', $request['table_name']));
            foreach ($row as $k => $v){
                $xml->startElement($k);
                $xml->writeRaw($v);
                $xml->endElement();
            }
            $xml->endElement();

        }

        // header('Content-type: text/xml');

        header("Content-Type: text/html/force-download");
        header("Content-Disposition: attachment; filename='".$file_name.".xml'");

        $xml->flush();
    }


    public function ajax_detail($request)
    {
        if($request['table_name'] == TABLE_PREFIX.'booking'){
            create_booking_summary($request);
        }
      }
    }



       // $model = $this->createModel($request['table_name']);
        //$main_table_name = $request['table_name'];
        //$pk_id_name = $model->get_primary_key();
        //$id = $request['id'];

       // $fk = $model->get_relate();


       // $result = $model->select_joined($main_table_name, $fk[0]['table_name'], $pk_id_name, $pk_id_name );
     //   echo  $pk_id_name;
     //   echo '<br>';
     //   print_r($result);

       // $this->get_fk_id_and_name($main_table_name, $id);

        //$this->get_extra_tables($request['table_name']);

/*
        $result = [];

        $fk = $model->get_fk_table_name();
        foreach ($fk as $key => $value){
            $temp_model = $this->createModel($value);
            $result[] = $temp_model->get_row($id);
        }


        print_r($result);
*/
   //     $this->get_fk_id_and_name($request['table_name'], $request['id']);

        //$model = $this->createModel($request['table_name']);
        //$pk_fk_name = $model->get_primary_key();
       // $this->get_relate_id_and_name($request['table_name'], $request['id'], $pk_fk_name);
                       //$row =  $this->get_row_id($request['table_name'], $request['id']);

      /*  $array_tables = array(
            'booking',
            'customer',
            'table'
        );

        $array_booking = array(
            'fk' => array('table_name'=>TABLE_PREFIX.'customer', 'pk_name'=>'customer_id'),
            'child' => array('table_name'=>TABLE_PREFIX.'task', 'pk_name'=>'task_id', 'fk_name'=>'booking_id')
        );
        $array_customer = array(
          'child' => array('table_name'=>TABLE_PREFIX.'client', 'pk_name'=>'client_id', 'fk_name'=>'customer_id'),
            'child' => array('table_name'=>TABLE_PREFIX.'booking', 'pk_name'=>'booking_id', 'fk_name' => 'customer_id')
        );
        $array_task = array(
          'fk' => array('table_name'=>TABLE_PREFIX.'booking', 'pk_name'=>'booking_id')
        );

        foreach ($array_tables as $table){
            foreach (${"array_$table"} as $relation => $value){
                if($relation == 'fk'){

                }else if($relation == 'child'){

                }
            }
        }





        $id = $request['id'];
        $table_name = $request['table_name'];
        $result = $this->get_row_id($table_name, $id);
        print_r($result);
        foreach ($array_booking as $relation => $value){
            if($relation == 'fk'){
                //use pk and id
               $row =  $this->get_row_id($value['table_name'], $result->$value['pk_name']);
               print_r($row);
               foreach ($array_customer as $relation => $value){
                   $row2 = $this->get_row_id_from_child($value['table_name'], $value['fk_name'], $row->$value['fk_name']);
                   print_r($row2);
               }
            }else if($relation == 'child'){
                //use fk and id
               $row = $this->get_row_id_from_child($value['table_name'], $value['fk_name'], $id);
               print_r($row);
            }
        }
*/




        /*foreach ($array_table as $table_name => $primary_key_name){
            $model = $this->createModel($table_name);
            $row = $model->get_row_specific($primary_key_name, $id);
        }*/

/*
        $row = $this->get_row_id($table_name, $id);
        foreach ($row as $row_object => $object){
        }
        print_r($row);
    }

    public function another_looper($array_table_name){
        foreach ($array_table_name as $relation => $value){
            if($relation == 'fk'){
            }
            else if($relation == 'child'){

            }
        }
    }

    public function get_row_id($tableName, $id){
        $model = $this->createModel($tableName);
        $pk = $model->get_primary_key();
        $result = $model->get_row($id);
        return $result;
    }

    public function get_row_id_from_child($tableName, $fk_name, $id){
        $model = $this->createModel($tableName);
        $result = $model->get_row_specific($fk_name, $id);
        return $result;
    }

    public function ajax_view2($request){

        $id = $request['id'];
        $table_name = $request['table_name'];


    }


    public function get_fk_id_and_name($tableName, $id){
        $model = $this->createModel($tableName);
        $model_id = [];


        $fk= $model->get_fk_table_name();
        $result = $model->get_row($id);
        foreach($fk as $key => $value) {
                foreach ($result as $field => $field_value) {
                    if ($field == $value['pk']) {
                        $model_id[$value['table_name']] = $field_value;
                    }
                }
        }
            print_r($result);
       // print_r($model_id);

        foreach ($model_id as $table_name => $pk_id){

            $temp_model = $this->createModel($table_name);
            $pk_name = $temp_model->get_primary_key();
            echo $table_name;
            $this->get_relate_id_and_name($table_name, $pk_id, $pk_name );
            $this->get_fk_id_and_name($table_name, $pk_id);
        }
    }

    public function get_relate_id_and_name($tableName, $id, $pk_fk){
        $model = $this->createModel($tableName);

        $pk_name = $model->get_primary_key();

        $model_id= [];
        $relate = $model->get_relate();


        foreach ($relate as $key => $value){
                $model_id[$value['table_name']] =  $id;
                $temp_model = $this->createModel($value['table_name']);
                $result = $temp_model->get_row_specific($pk_fk, $id);
                var_dump($result);
        }



            foreach ($model_id as $table_name => $id) {
                $this->get_relate_id_and_name($table_name, $id, $pk_name);

            }

    }

    public function loop_return(){

    }


    /*public function  get_extra_tables($model){
        $relate = $model->get_relate();
        $fk = $model->get_fk_table_name();
        $relate_table = $this->get_table_name_from_variables($relate); // relate / task
        $fk_table = $this->get_table_name_from_variables($fk); //view / customer
        print_r($relate_table);
        print_r($fk_table);

        foreach ($relate_table as $key => $value){
                $temp_model = $this->createModel($value);
                $this->get_extra_tables($value)
            }
      //  $extra_tables = array_merge($extra_tables1, $extra_tables2);
    }

    public function get_table_name_from_variables($variable)
    {
        $extra_tables = [];
        foreach ($variable as $key => $value) {
            foreach ($value as $key => $value) {
                if ($key == 'table_name') {
                    $extra_tables[] = $value;
                }
            }
            return $extra_tables;
        }
    }*/
//}
