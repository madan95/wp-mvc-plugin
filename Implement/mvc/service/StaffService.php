<?php
class StaffService extends GenericService{

  public function select2($request){
  /*  $table_name = $request['table_name'];
    $parent_table_name = $request['parent_table_name'];
    $column_to_display = $request['column'];
    $key_word = $request['search'];
    $array_models = $this->entity_manager->getAnyMatch($table_name, $key_word);
    foreach($array_models as $key => $model){
      $full_address = $model->getValue('first_name');
      if($full_address == ""){
        $full_address = 'No Address Given Yet';
      }
      $data[] = array('id' => $model->getValue($model->getPrimaryKey()), 'text' => $full_address);
    }
    return $data;
*/

    /*    $users = get_users();
        foreach($users as $key => $user){
          $user_display_name = $user->display_name;
          if($user_display_name == ""){
            $user_display_name = 'No Display Name Given Yet';
          }
          $data[] = array(
            'id' => $user->ID,
            'text' => $user_display_name
          );
        }
*/
        $staffs = $this->entity_manager->findAll('staff');
        foreach($staffs as $key => $staff){
          $staff_display_name = $staff->getFullName();
          if($staff_display_name == ""){
            $staff_display_name = 'No Display Name Given Yet';
          }
          $data[] = array(
            'id' => $staff->getValue('staff_id'),
            'text' => $staff_display_name
          );
        }
        return $data;
  }



  public function createNewStaff($request){
    $user_query = new WP_User_Query(array('count_total' => true));
    $total_user = $user_query->get_total();
    $user_name = 'user'.($total_user+1);
    $user_password = 'password';
    $user_email = '';
    $user_id = username_exists($user_name);
    if(!$user_id && email_exists($user_email) == false){
      $user_id = wp_create_user($user_name, $password, $user_email);
    }else{
      echo 'User Already Exists';
    }
    //create new staff and set user_id to above value
    parent::createOrUseExisting($request);
    $this->passable_model->setValue('user_id', $user_id);
    $this->entity_manager->update($this->passable_model);

  }



  public function getBootGridDataO($request){
/*    $staff_dao = $this->entity_manager->getDao('staff');
    $bootgrid_data = $staff_dao->getBootGridData($request);

    $new_user_id = wp_create_user('json2', 'json2', 'json2@gmail.com');
    console($new_user_id);
    echo $new_user_id;

    $users = get_users();
    print_r(get_users());
    foreach($users as $key => $user){
      echo $user->roles . '<br>';
      echo $user->id . '<br>';
      echo $user->user_login . '<br>';
      echo $user->user_pass . '<br>';
      echo $user->user_email . '<br>';
      echo $user->display_name . '<br>';
    }
    return true;
    */
    $users = get_users();
    $data_array = array();

    foreach($users as $key => $user){
      $temp_array = array();
      $temp_array['user_id'] = $user->ID;
      $temp_array['display_name'] = $user->display_name;
      $temp_array['user_login'] = $user->user_login;
      $temp_array['user_email'] = $user->user_email;

      $staff = $this->entity_manager->getMatch('staff', 'user_id', $user->ID);
      $temp_array['staff_id'] = $staff->getValue('staff_id');
      $temp_array['mobile_number'] = $staff->getValue('mobile_number');
      $temp_array['phone_number'] = $staff->getValue('phone_number');
      array_push($data_array, $temp_array);
    }

    ServiceHelper::createBootGridJSONResponse(
      $data_array,
      $request['current'],
      $request['rowCount'],
      $bootgrid_data['total']
    );

  }

  public function createNewNew($request){
    if($request['node_id']){
        $model = $this->entity_manager->find($request['table_name'], $request['node_id']);
    }else{
      $model = ModelFactory::getModel($request['table_name']);
      $model_id = $this->entity_manager->persist($model);
      $model->setValue($model->getPrimaryKey(), $model_id);

      $userdata = array(
        'user_login' => '',
        'user_pass' => 'password',
        'user_email' => '',
        'first_name' => '',
        'last_name' => '',
      );
      $user_id = wp_insert_user($userdata);

    }
    if($request['parent_table_name']!=null &&$request['parent_id']!=null){
      $parent =  $this->entity_manager->find($request['parent_table_name'], $request['parent_id']);
      $parent->setValue($model->getPrimaryKey(), $model->getValue($model->getPrimaryKey()));
      $this->entity_manager->update($parent);
    }
   }



  public function getBootGridData($request){
    $table_name = $request['table_name']; //staff
    $current = $request['current'];
    $rowCount = $request['rowCount'];

    $parent_table_name = $request['parent_table_name']; //(task)
    $parent_table_id;
    $hasParent = false;
    if($request['parent_table_name']){
      $hasParent = true;
      $parent_table_id = $request['parent_id'];
    }

    if(!$hasParent){
      $array_of_task_obj = $this->entity_manager->findAll($table_name);
      $data_array = array();
      foreach($array_of_task_obj as $key => $staff){
        $row_array = array();
        $row_array['staff_id'] = $staff->getValue('staff_id');
        $row_array['first_name'] = $staff->getValue('first_name');
        $row_array['last_name'] = $staff->getValue('last_name');
        $row_array['mobile_number'] = $staff->getValue('mobile_number');
        $row_array['phone_number'] = $staff->getValue('phone_number');

        $user = get_user_by('id', $staff->getValue('user_id'));
          $row_array['user_id'] = $user->ID;
          $row_array['display_name'] = $user->display_name;
          $row_array['user_login'] = $user->user_login;
          $row_array['user_email'] = $user->user_email;

        array_push($data_array, $row_array);
      }
    }else{

       $staff_dao = $this->entity_manager->getDao('staff');
      // console($staff_dao->test());
    //   console('jesus');
    $data_array = array();
       $array_bootgrid_data = ($staff_dao->findGridSearch($request));
       $array_of_task_obj = $array_bootgrid_data['array_of_model_obj'];
       $total = $array_bootgrid_data['total'];
       foreach($array_of_task_obj as $key => $staff){
         $row_array = array();

         $row_array['staff_id'] = $staff->getValue('staff_id');
         $row_array['first_name'] = $staff->getValue('first_name');
         $row_array['last_name'] = $staff->getValue('last_name');
         $row_array['mobile_number'] = $staff->getValue('mobile_number');
         $row_array['phone_number'] = $staff->getValue('phone_number');



         array_push($data_array, $row_array);
       }


       $grid_data = array(
         'current' => $current,
         'rowCount' => $rowCount,
         'rows' => $data_array,
         'total' => $total
       );

       wp_send_json(json_encode($grid_data));
       return false;
    }

      $grid_data = array(
        'current' => $current,
        'rowCount' => $rowCount,
        'rows' => $data_array
      );

      wp_send_json(json_encode($grid_data));

  }

  public function save($request){
    $staff = MapperHelper::mapRequestToObject($request['table_name'], $request['staff'][0]);
    $this->dao->save($staff);
    $request['selected_value'] = $staff->getValue('staff_id');
    if($request['isNode']){
      $this->createSelectForm($request);
    }else{
      echo 'Change Display To Sucess full Registeration Message';
    }
  }

  public function register($request){
    return require (BASEPATH . '/Implement/mvc/view/models/staff/new.php');
  }

  public function createSelectForm($request){
    console($request);
  $id_name_pair = Helper::getSelect2Data($this->dao->list_all(), 'staff_id', 'first_name');
  $body = include (BASEPATH . '/Implement/mvc/view/models/staff/select2.php');
  if($request['isNode']){
    $json_data = array(
      'body' => $body
    );
      wp_send_json(json_encode($json_data));
    }else{
      echo $body;
    }
  }

  public function relatedTasks($request){
    echo '<br>';
    echo 'Task Left To Do <br>';
    $staff_dao = DAOFactory::createDAO('staff');
    $staff = $staff_dao->get($request['staff_id']);
    echo 'staff first name : ' . $staff->getValue('first_name'). '<br>';


    $generic_model = ModelFactory::createGenericModel();
    $task_ids = $generic_model->genericFind('task_id', 'taskstaff', array('staff_id' => $request['staff_id']));
    $task_dao = DAOFactory::createDAO('task');
    $list_of_task_obj = array();
    foreach($task_ids as $key => $value){
      $temp_task = $task_dao->get($value);
      $list_of_task_obj[]  = $temp_task;
    //  if($temp_task->getValue('status')=='2'){
      echo '<h1>Task Number : '. ($key+1) . '</h1><br>';
      echo 'task date start : ' . $temp_task->getValue('date_start') .  '<br>';
      echo 'task date finish : ' . $temp_task->getValue('date_finish') . '<br>';
      echo 'task product name : ' . $temp_task->getProduct()->getValue('product_name') . '<br>';
  //  }
    }
    console($list_of_task_obj);
    //find the staff
    //find task_id using taskstaff with staff id
    //find the tasks related to that staff
    //find the incomplete task

  /*  $taskstaff = MapperHelper::mapRequestToObject('taskstaff', array('staff_id'=>$staff_id));
    $taskstaff_dao = DAOFactory::createDAO('taskstaff');
    $list_of_task_staff_obj = $taskstaff_dao->getMatch($taskstaff, $staff_id, 'staff_id');
    $task_ids = array();
    foreach($list_of_task_staff_obj as $key => $taskstaff){
      $task_ids = $taskstaff->getValue('task_id');
      console($task_ids);
    }
*/
  }


}
 ?>
