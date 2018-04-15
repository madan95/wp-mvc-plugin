<?php
class BookingService extends GenericService{

  public function getBootGridData($request){
    $booking = $this->entity_manager->getDao('booking');
    $bootgrid_data =  $booking->getBootGridData($request);

    $data_array = array();
    foreach($bootgrid_data['array_of_model_obj'] as $key => $model){
      $temp_array = array();
      $temp_array['booking_id'] = $model->getValue('booking_id');
      $temp_array['start_date'] = $model->getValue('start_date');
      $temp_array['due_date'] = $model->getValue('due_date');
      $temp_array['customer_id'] = $model->getValue('customer_id');
      $temp_array['client_id'] = $model->getValue('client_id');
      array_push($data_array, $temp_array);
    }

    ServiceHelper::createBootGridJSONResponse(
      $data_array,
      $request['current'],
      $request['rowCount'],
      $bootgrid_data['total']
    );
  }

  public function getGridData($request){
    $booking = $this->entity_manager->find('booking', $request['id']);
    $booking_location = $this->entity_manager->find('location', $booking->getValue('location_id'));
    $booking_customer = $this->entity_manager->find('customer', $booking->getValue('customer_id'));

    $data_array = array(
      array(
        'booking_id' => $booking->getValue('booking_id'),
        'start_date' => $booking->getValue('start_date'),
        'due_date' => $booking->getValue('due_date'),
        'booking_location' => array(
          'parent_table_name' => 'booking',
          'parent_id' => $booking->getValue('booking_id'),
          'table_name' => 'location',
          'node_id' => $booking_location->getValue('location_id'),
          'display' => $booking_location->getFullAddress()
        ),
        'booking_customer' => array(
          'parent_table_name' => 'booking',
          'parent_id' => $booking->getValue('booking_id'),
          'table_name' => 'customer',
          'nodeid' => $booking_customer->getValue('customer_id'),
          'display' => $booking_customer->getValue('customer_name')
        )
      )
    );

    ServiceHelper::createBootGridJSONResponse($data_array);
  }

  public function register($request){
    return require (BASEPATH . '/Implement/mvc/view/models/booking/new.php');
  }

  public function createNew($request){
    $model = ModelFactory::getModel($request['table_name']);
    $model->setValue($model->getPrimaryKey(), $this->entity_manager->persist($model));
    $current_url= 'http://'.Helper::getCurrentUrl();
    $url_to_redirect = $current_url.'?table_name=booking&ajax_action=viewdetail&id='.$model->getValue('booking_id');
    Helper::redirectJS($url_to_redirect);
    die();
  }

  public function getGridDataOld2($request){
      $booking = $this->entity_manager->find('booking', $request['id']);
      $booking_location = $this->entity_manager->find('location', $booking->getValue('location_id'));
      $booking_customer = $this->entity_manager->find('customer', $booking->getValue('customer_id'));
      $data_array = array(
        array(
          'booking_id' => $booking->getValue('booking_id'),
          'start_date' => $booking->getValue('start_date'),
          'due_date' => $booking->getValue('due_date'),


          'booking_location' => array(
            'parent_table_name'=>'booking',
            'parent_id'=> $booking->getValue('booking_id'),
            'table_name'=>'location',
            'nodeid'=>$booking_location->getValue('location_id'),
            'display' => $booking_location->getFullAddress()),


          'booking_location_id' => 1,


          'booking_customer' => array(
            'parent_table_name' => 'booking',
            'parent_id' => $booking->getValue('booking_id'),
            'table_name' => 'customer',
            'nodeid' => $booking_customer->getValue('customer_id'),
            'display' => $booking_customer->getValue('customer_name')
          )


        )
      );

      $json_data = array(
        'current' => $request['current'],
        'rowCount' => $request['rowCount'],

        'rows' => $data_array
      );

      wp_send_json(json_encode($json_data));
  }

  public function getGridDataOld($request){
    $booking = $this->entity_manager->find('booking', $request['id']);
    $booking_location = $this->entity_manager->find('location', $booking->getValue('location_id'));
    $customer = $this->entity_manager->find('customer', $booking->getValue('customer_id'));
    $customer_location = $this->entity_manager->find('location', $customer->getValue('customer_id'));
    $main_client = $this->entity_manager->find('client', $booking->getValue('client_id'));

    $data_array = array(
      'booking_id' => $booking->getValue('booking_id'),
      'booking_location' => $booking_location->getFullAddress(),
      'booking_start_date' => $booking->getValue('start_date'),
      'booking_due_date' => $booking->getValue('due_date'),
      'customer_name' => $customer->getValue('customer_name'),
      'customer_location' => $customer_location->getFullAddress(),
      'main_client_full_name' => $main_client->getFullName(),
      'main_client_contact_number' => $main_client->getContactNumbers()
    );
    $grid_data = array(
            'current'=> 1,
            'rowCount'=> 10,
            'rows'=> array(
                $data_array
            )
          );
    wp_send_json(json_encode($grid_data));
  }

  public function view($request){

          $booking_dao = DAOFactory::createDAO('booking');
          $product_dao = DAOFactory::createDAO('product');
          $location_dao = DAOFactory::createDAO('location');
          $taskstaff_dao = DAOFactory::createDAO('taskstaff');
          $customer_dao = DAOFactory::createDAO('customer');
          $client_dao = DAOFactory::createDAO('client');
          $task_dao = DAOFactory::createDAO('task');

          $booking = $booking_dao->get($request['booking_id']);
          $customer = $customer_dao->get($booking->getValue('customer_id'));
          $list_of_client = $client_dao->getMatch($customer->getValue('customer_id'), 'customer_id');
          $list_of_task = $task_dao->getMatch($booking->getValue('booking_id'), 'booking_id');

          foreach($list_of_task as $key => $task){
            $task->setProduct($product_dao->get($task->getValue('product_id'))); // product obj related to task
            $task->setLocation($location_dao->get($task->getValue('location_id'))); // location obj
            $task->setStaffs($taskstaff_dao->getMatch($task->getValue('task_id'), 'task_id')); // list of staff obj related to task
          }

          $data = array(
            'booking' => $booking,
            'customer' => $customer,
            'clients' => $list_of_client,
            'tasks' => $list_of_task
          );

          foreach($data['tasks'] as $key => $task){
            $product = $task->getProduct();
            echo $task->getValue('product_id');
            echo $product->getValue('product_id');
            echo $product->getValue('product_name');
            echo $product->getValue('product_cost');
          }


  }

  public function save($request){
    $booking = MapperHelper::mapRequestToObject($request['table_name'], $request['booking'][0]);
    $this->dao->save($booking);
    foreach($request['booking'] as $key => $value){
      $task_dao = DAOFactory::createDAO('task'); //create client dao

      foreach($value['task'] as $key => $value){
        $task = MapperHelper::mapRequestToObject('task', $value); // create client object instance
        $task->setValue('booking_id', $booking->getValue('booking_id')); //add customer id to client object instance
        $task_dao->save($task); // save these client object using client dao

        $staff_dao = DAOFactory::createDAO('staff'); //create client dao
        $taskstaff_dao = DAOFactory::createDAO('taskstaff'); //create client dao
        foreach($value['staff'] as $key => $value){
          if(!empty($value)){

          $staff = MapperHelper::mapRequestToObject('staff', $value); // create client object instance
          $staff_dao->save($staff);

          $taskstaff = MapperHelper::mapRequestToObject('taskstaff');
          $taskstaff->setValue('task_id', $task->getValue('task_id'));
          $taskstaff->setValue('staff_id', $staff->getValue('staff_id'));
          $taskstaff_dao->save($taskstaff);

        }
      }
      }
    }
    console($booking);
    //  foreach($request['booking'] as $key => $value){
          // save booking and get its ID
    //    foreach($value['task'] as $key => $value){
          // crate new task object with booking_id from above
          // save task using task service which also saves  staff
    //    }
  //    }
//  console($request['booking']);
//  $obj = json_decode(json_encode($request['booking']));
//  console($obj);
    }
    //conole($request);

}
 ?>
