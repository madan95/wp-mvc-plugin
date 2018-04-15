<?php
class CustomerService extends GenericService{


  //Use Generic to create customer and set booking location same as customer if it empty
    public function createOrUseExisting($request){
      parent::createOrUseExisting($request);
      if($this->passable_parent->getTableName() == 'booking' && empty($this->passable_parent->getValue('location_id'))){
        $this->passable_parent->setValue('location_id', $this->passable_model->getValue('location_id'));
        $this->entity_manager->update($this->passable_parent);
      }
    }

    public function update($request){
      parent::update($request);
      if($request['column'] == 'location_id'){
        console('IT IS CUSTOMJER ');
      }
    }

  public function getGridData($req){
    $request = Helper::setRequestParameters($req);
    if(!empty($request['parent_id'] && !empty($request['parent_table_name']))){
      $parent = $this->entity_manager->find($request['parent_table_name'], $request['parent_id']);

      $model = ModelFactory::getModel($request['table_name']);

      if($parent->hasColumn($model->getPrimaryKey())){
        //many(parent/booking) to one(child/customer)

        //find model/child of that has parent with parent_idr
        $model_to_search_on = $parent->getTableName();
        $model_to_return = $model->getTableName();
        $model_obj = $this->entity_manager->find($model->getTableName(), $parent->getValue($model->getPrimaryKey()));
      //  $array_of_model_obj = $this->entity_manager->getRelatedModel($model_to_return, $model_to_search_on);


        $data_array = array();
      //  foreach($array_of_model_obj as $key => $model_obj){
          $temp_array = array(
            'customer_id' => $model_obj->getValue('customer_id'),

            'customer_location' => array(
              'parent_table_name' => 'customer',
              'parent_id' => $model_obj->getValue('customer_id'),
              'table_name' => 'location',
              'nodeid' => '',
              'display' => $model_obj->getFullAddress()
            ),


            'customer_name' => $model_obj->getValue('customer_name')
          );
          array_push($data_array, $temp_array);
      //  }

        $json_data = array(
          'current' => $request['current'],
          'rowCount' => $request['rowCount'],
          'rows' => $data_array
        );

        wp_send_json(json_encode($json_data));

        // we know we wasn the child ( which in this case is only one)
        // hence no need to create a array of the object
    /*    $model = $this->entity_manager->getMatch(
          $request['table_name'], //many/parent (booking)
          $model->getPrimaryKey(), //pk of child/one (customer_id) or fk on parent table
          $
        );
*/

/*
        $array_of_model_id = $this->entity_manager->getMatchValue(
          $request['parent_table_name'],
          $parent->getPrimaryKey(),
          $request['parent_id'],
          $model->getPrimaryKey()
        );
        $array_of_model_object = array();
        foreach($array_of_model_id as $key => $pk_id){
          $temp_model_obj = $this->entity_manager->find($request['table_name'], $pk_id);
          array_push($array_of_model_object, $temp_model_obj);
        }
*/
        // do what you want with this $arry_of_model_object

      }else if($model->hasColumn($parent->getPrimaryKey())){
        //many(model) to one(parent)
      }else{
        // many to many
      }
    }else{
      //solo table data
    }
/*
    $customer = $this->entity_manager->find($request['table_name'], $request['parent_id']);
    $customer_location = $this->entity_manager->find('location', $customer->getValue('location_id'));

    $data_array = array(
      array(
        'customer_id' => $customer->getValue('customer_id'),

        'customer_location' => array(
          'parent_table_name' => 'customer',
          'parent_id' => $customer->getValue('customer_id'),
          'table_name' => 'location',
          'nodeid' => $customer->getValue('location_id'),
          'display' => $customer_location->getFullAddress()
        ),

        'customer_name' => $customer->getValue('customer_name')

      )
    );

    $json_data = array(
      'current' => $request['current'],
      'rowCount' => $request['rowCount'],
      'rows' => $data_array
    );

    wp_send_json(json_encode($json_data));*/
  }

  public function save($request){

    $customer = MapperHelper::mapRequestToObject('customer', $request['customer'][0]);
    //$this->dao->save($customer);

    if($request['client']){
      $client_service = DAOFactory::createDAO('client'); //create client dao
      foreach ($request['client'] as $key => $value) {
        $client = MapperHelper::mapRequestToObject('client', $value); // create client object instance
      //  $client->setValue('customer_id', $customer->getValue('customer_id')); //add customer id to client object instance
    //    $client_service->save($client); // save these client object using client dao
      }
    }

    // begin transaction
    try{
      //save customer
      //set client->customer_id
      // save client
      //commit
    }catch(Exception $e){
      //roll back
    }

    if($request['isNode']){
      $request['selected_value'] = $customer->getValue('customer_id');
      $this->createSelectForm($request);
    }else{
      echo 'Change Display To Sucess full Registeration Message';
    }

  }

  public function register($request){
    return require (BASEPATH . '/Implement/mvc/view/models/customer/new.php');
  }

  public function createSelectForm($request){
  $id_name_pair = Helper::getSelect2Data($this->dao->list_all(), 'customer_id', 'customer_name');
  $body = include (BASEPATH . '/Implement/mvc/view/models/customer/select2.php');
  if($request['isNode']){
    $json_data = array(
      'body' => $body
    );
      wp_send_json(json_encode($json_data));
    }else{
      echo $body;
    }
  }


}
