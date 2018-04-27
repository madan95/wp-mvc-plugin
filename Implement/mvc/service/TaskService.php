<?php
class TaskService extends GenericService{

  public function createOrUseExisting2($booking_id){
    $task = ModelFactory::getModel('task');
    $task->setValue('booking_id', $booking_id);
    $task->setValue('task_id', $this->entity_manager->persist($task));
  }

  public function getTotalPrice($request){
    $data_array = $this->getTasksRelatedToBooking($request);
    console($data_array);
    $json_data= array(
    'total_booking_price' => $data_array['total_booking_price']
    );
    wp_send_json(json_encode($json_data));
  }

  public function getTasksRelatedToBooking($request){
    $booking_id = $request['parent_id'];
    $tasks = $this->entity_manager->getMatch(
      'task',
      'booking_id',
      $booking_id
    );
    if(is_array($tasks)){
      $array_of_task_obj = $tasks;
    }else{
      $array_of_task_obj[0] = $tasks;
    }
    $taskstaff_dao = $this->entity_manager->getDao('taskstaff');

    $data_array['rows'] = array();
    $total_booking_price = 0;
    foreach($array_of_task_obj as $key => $task){
      $temp_array = array();
      $temp_array['task_id'] = $task->getValue('task_id');
      $temp_array['booking_id'] = $task->getValue('booking_id');
      $temp_array['date_start'] = $task->getValue('date_start');
      $temp_array['date_finish'] = $task->getValue('date_finish');

      $task_product = $this->entity_manager->find('product', $task->getValue('product_id'));

      $temp_array['product_id'] = $task_product->getValue('product_id');
      $temp_array['product_name'] = $task_product->getValue('product_name');
      $temp_array['product_cost'] = $task_product->getValue('product_cost');
      $temp_array['product_quantity'] = $task->getValue('product_quantity');
      $temp_array['total_task_cost'] = $task_product->getValue('product_cost') * $task->getValue('product_quantity');
      $total_booking_price = $total_booking_price + $temp_array['total_task_cost'];
      console('THE PRICEEEEEEEEEEEE');
      console($task->getValue('product_quantity'));

      $temp_array['task_product'] = array(
        'parent_table_name' => 'task',
        'parent_id' => $task->getValue('task_id'),
        'table_name' => 'product',
        'node_id' => $task_product->getValue('product_id'),
        'display' => $task_product->getValue('product_name')
      );


      $task_location = $this->entity_manager->find('location', $task->getValue('location_id'));

      $temp_array['task_location'] = $task_location->getFullAddress();
      $temp_array['task_status'] = $task->getValue('status');

      $array_of_staff_id = $this->entity_manager->getMatchValue('taskstaff', 'task_id', $task->getValue('task_id'), 'staff_id');
      $temp_array['staff_names'] = array();
      foreach($array_of_staff_id as $key => $staff_id){
        $temp_staff= $this->entity_manager->find('staff', $staff_id);
        array_push($temp_array['staff_names'], $temp_staff->getFullName());
      }

      $temp_array['task_staffs'] = array(
        'parent_table_name' => 'task',
        'parent_id' => $task->getValue('task_id'),
        'table_name' => 'staff',
        'display' => implode(", ", $temp_array['staff_names'])
      );

      array_push($data_array['rows'], $temp_array);
    }
    $data_array['total_booking_price'] = $total_booking_price;
    return $data_array;
  }


  public function getGridData($request){
    console('task getGrid data');
/*    $booking_id = $request['parent_id'];
    $task_booking_column = 'booking_id';
    $array_of_task_obj = $this->entity_manager->getMatch('task', $task_booking_column, $booking_id);
    $taskstaff_dao = $this->entity_manager->getDao('taskstaff');

    $data_array = array();
    foreach($array_of_task_obj as $key => $task){
      $temp_array = array();
      $temp_array['task_id'] = $task->getValue('task_id');
      $temp_array['booking_id'] = $task->getValue('booking_id');
      $temp_array['date_start'] = $task->getValue('date_start');
      $temp_array['date_finish'] = $task->getValue('date_finish');

      $task_product = $this->entity_manager->find('product', $task->getValue('product_id'));

      $temp_array['$task_product'] = array(
        'parent_table_name' => 'task',
        'parent_id' => $task->getValue('task_id'),
        'table_name' => 'product',
        'display' => implode
      );

      $temp_array['product_id'] = $task_product->getValue('product_id');
      $temp_array['product_name'] = $task_product->getValue('product_name');
      $temp_array['product_cost'] = $task_product->getValue('product_cost');
      $temp_array['product_quantity'] = $task->getValue('product_quantity');
      $temp_array['total_task_cost'] = $task->getTotalCost();

      $task_location = $this->entity_manager->find('location', $task->getValue('location_id'));

      $temp_array['task_location'] = $task_location->getFullAddress();
      $temp_array['task_status'] = $task->getValue('status');

      $array_of_staff_id = $this->entity_manager->getMatchValue('taskstaff', 'task_id', $task->getValue('task_id'), 'staff_id');
      $temp_array['staff_names'] = array();
      foreach($array_of_staff_id as $key => $staff_id){
        $temp_staff= $this->entity_manager->find('staff', $staff_id);
        array_push($temp_array['staff_names'], $temp_staff->getFullName());
      }
      $temp_array['task_staffs'] = array(
        'parent_table_name' => 'task',
        'parent_id' => $task->getValue('task_id'),
        'table_name' => 'staff',
        'display' => implode(", ", $temp_array['staff_names'])
      );
      array_push($data_array, $temp_array);

    }*/

    $data_array =  $this->getTasksRelatedToBooking($request);
    //console($request);
    ServiceHelper::createBootGridJSONResponse($data_array['rows']);
  }


  public function viewTaskOfCurrentUser($current_user_id){
    $staff_id = $this->entity_manager->getMatchValue('staff', 'user_id', $current_user_id, 'staff_id');
    $array_task_id = $this->entity_manager->getMatchValue('taskstaff', 'staff_id', $staff_id[0] , 'task_id');
    $tasks = array();
    foreach($array_task_id as $key => $value){
      array_push($tasks, $this->entity_manager->find('task', $value));
    }


    $taskstaff_dao = $this->entity_manager->getDao('taskstaff');

    $data_array['rows'] = array();
    $total_booking_price = 0;
    foreach($tasks as $key => $task){
      $temp_array = array();
      $temp_array['task_id'] = $task->getValue('task_id');
      $temp_array['booking_id'] = $task->getValue('booking_id');
      $temp_array['date_start'] = $task->getValue('date_start');
      $temp_array['date_finish'] = $task->getValue('date_finish');

      $task_product = $this->entity_manager->find('product', $task->getValue('product_id'));

      $temp_array['product_id'] = $task_product->getValue('product_id');
      $temp_array['product_name'] = $task_product->getValue('product_name');
      $temp_array['product_cost'] = $task_product->getValue('product_cost');
      $temp_array['product_quantity'] = $task->getValue('product_quantity');
      $temp_array['total_task_cost'] = $task_product->getValue('product_cost') * $task->getValue('product_quantity');
      $total_booking_price = $total_booking_price + $temp_array['total_task_cost'];
      $temp_array['task_product'] = array(
        'parent_table_name' => 'task',
        'parent_id' => $task->getValue('task_id'),
        'table_name' => 'product',
        'node_id' => $task_product->getValue('product_id'),
        'display' => $task_product->getValue('product_name')
      );


      $task_location = $this->entity_manager->find('location', $task->getValue('location_id'));

      $temp_array['task_location'] = $task_location->getFullAddress();
      $temp_array['task_status'] = $task->getValue('status');

      $array_of_staff_id = $this->entity_manager->getMatchValue('taskstaff', 'task_id', $task->getValue('task_id'), 'staff_id');
      $temp_array['staff_names'] = array();
      foreach($array_of_staff_id as $key => $staff_id){
        $temp_staff= $this->entity_manager->find('staff', $staff_id);
        array_push($temp_array['staff_names'], $temp_staff->getFullName());
      }

      $temp_array['task_staffs'] = array(
        'parent_table_name' => 'task',
        'parent_id' => $task->getValue('task_id'),
        'table_name' => 'staff',
        'display' => implode(", ", $temp_array['staff_names'])
      );
      array_push($data_array['rows'], $temp_array);
    }
    $data_array['total_booking_price'] = $total_booking_price;


    ServiceHelper::createBootGridJSONResponse($data_array['rows']);
  }

  public function getGridData2($request){
    $parent_table_id = $request['parent_id'];
    $parent_table_column = $request['parent_table_column'];

    $array_of_task_obj= $this->entity_manager->getMatch('task', $parent_table_column, $parent_table_id);
    $taskstaff_dao = $this->entity_manager->getDao('taskstaff');

    $data_array = array();

    foreach($array_of_task_obj as $key => $task){
      $temp_array = array();
      $temp_array['task_id'] = $task->getValue('task_id');
      $temp_array['booking_id'] = $task->getValue('booking_id');
      $temp_array['date_start'] = $task->getValue('date_start');
      $temp_array['date_finish'] = $task->getValue('date_finish');

      $task_product = $this->entity_manager->find('product', $task->getValue('product_id'));

      $temp_array['product_id'] = $task_product->getValue('product_id');
      $temp_array['product_name'] = $task_product->getValue('product_name');
      $temp_array['product_cost'] = '<div class="editable">'.$task_product->getValue('product_cost').'</div>';
      $temp_array['product_quantity'] = $task->getValue('product_quantity');

      $task_location = $this->entity_manager->find('location', $task->getValue('location_id'));

      $temp_array['task_location'] = $task_location->getFullAddress();
      $temp_array['task_status'] = $task->getValue('status');

      $array_of_staff_id = $this->entity_manager->getMatchValue('taskstaff', 'task_id', $task->getValue('task_id'), 'staff_id');
      $temp_array['staff_names'] = array();
      foreach($array_of_staff_id as $key => $staff_id){
        $temp_staff= $this->entity_manager->find('staff', $staff_id);
        array_push($temp_array['staff_names'], $temp_staff->getFullName());
      }
      $temp_array['task_staffs'] = array(
        'parent_table_name' => 'task',
        'parent_id' => $task->getValue('task_id'),
        'table_name' => 'staff',
        'display' => implode(", ", $temp_array['staff_names'])
      );
      array_push($data_array, $temp_array);

    }

    $grid_data = array(
      'current'=>1,
      'rowCount'=>10,
      'rows' =>  $data_array
    );

    wp_send_json(json_encode($grid_data));
  }


  public function register($request){
    return require (BASEPATH . '/Implement/mvc/view/models/task/new.php');
  }

  public function viewOld($request){
    $task_id = $request['task_id'];
    echo $task_id;
    $task_dao = DAOFactory::createDAO('task');
    $task_dao->get($task_id);
  }

  public function view($request){
    //use the dao to create model from the information given
    // use this model and it's method to do any business logic
    // result data put in the viewModelData
    // vieModelData return back to controller for view to use it ( may be create univeral data strcuture so different data can be used in different method )
    $task = $dao->find($request['task_id']);

  }

}
 ?>
