<?php

class ClientService extends  GenericService{


  public function getGridData($request){
  //  $request = Helper::setRequestParameters($req);

    $parent_table_id = '';
    if(isset($request['booking_id'])){
      $booking = $this->entity_manager->find('booking', $request['booking_id']);
      $customer_id = $booking->getValue('customer_id');
      $parent_table_id = $customer_id;
    }else{
      $parent_table_id = $request['parent_id'];
    }
    $parent_table_column = 'customer_id';
    $parent_table_name=  $request['parent_table_name'];

    $array_of_client_obj = $this->entity_manager->getMatch('client', $parent_table_column, $parent_table_id);

    $data_array = array();

    foreach($array_of_client_obj as $key => $client){
      $temp_array = array();
      $temp_array['client_id'] = $client->getValue('client_id');
      $temp_array['first_name'] = $client->getValue('first_name');
      $temp_array['last_name'] = $client->getValue('last_name');

      $client_location = $this->entity_manager->find('location', $client->getValue('location_id'));
      if($client_location){
      $temp_array['client_location'] = array(
        'parent_table_name' => 'client',
        'parent_id' => $client->getValue('client_id'),
        'table_name' => 'location',
        'nodeid' => $client->getValue('location_id'),
        'display' => $client_location->getFullAddress()
      );
    }else{
      $temp_array['client_location']  = array(
        'parent_table_name' => 'client',
        'parent_id' => '',
        'table_name' => 'location',
        'nodeid' => '',
        'display' => ''
      );
    }

      $temp_array['mobile_number'] = $client->getValue('mobile_number');
      $temp_array['phone_number'] = $client->getValue('phone_number');

      array_push($data_array, $temp_array);
    }

    $grid_data = array(
      'current' =>1,
      'rowCount' => 10,
      'rows' => $data_array
    );

    wp_send_json(json_encode($grid_data));
  }

  public function register($request){
    return require (BASEPATH . '/Implement/mvc/view/models/client/new.php');
  }

  public function save($request){
//    foreach($request['client'] as $key => $value){
      $client = MapperHelper::mapRequestToObject('client', $value);
      $this->dao->save($client);
  //  }
  }


  public function createNew($req){
    $request = Helper::setRequestParameters($req);

    if($request['node_id']){
      //Check if chossen from node
      $model = $this->entity_manager->find($request['table_name'], $request['node_id']);
   }else{
      $model = ModelFactory::getModel($request['table_name']);
      $model->setValue($model->getPrimaryKey(), $this->entity_manager->persist($model));
    }

    if(!empty($request['booking_id'])){
      $booking = $this->entity_manager->find('booking', $request['booking_id']);
      $customer_id = $booking->getValue('customer_id');
      $parent_table_id = $customer_id;
      $request['parent_id'] = $parent_table_id;
    }
    console($request['parent_id']);

    if(!empty($request['parent_table_name']) && !empty($request['parent_id'])){
      $parent =  $this->entity_manager->find($request['parent_table_name'], $request['parent_id']);
      if($parent->hasColumn($model->getPrimaryKey())){
          /// if parent has the fk of the model
            console('parent will set');
            $parent->setValue($model->getPrimaryKey(), $model->getValue($model->getPrimaryKey()));
            $this->entity_manager->update($parent);
      }else if($model->hasColumn($parent->getPrimaryKey())){
        // if model has the primary key of the parent
            console('model to set');
            $model->setValue($parent->getPrimaryKey(), $parent->getValue($parent->getPrimaryKey()));
            $this->entity_manager->update($model);
      }else{
            console('middle man to set');
      }
    }

  }

}
