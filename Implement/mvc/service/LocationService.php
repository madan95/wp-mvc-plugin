<?php
class LocationService extends GenericService{

  public function select2($request){
    $table_name = $request['table_name'];
    $parent_table_name = $request['parent_table_name'];
    $column_to_display = $request['column'];
    $key_word = $request['search'];
    $array_models = $this->entity_manager->getAnyMatch($table_name, $key_word);
    foreach($array_models as $key => $model){
      $full_address = $model->getFullAddress();
      if($full_address == ""){
        $full_address = 'No Address Given Yet';
      }
      $data[] = array('id' => $model->getValue($model->getPrimaryKey()), 'text' => $full_address);
    }
    return $data;
  }

  public function getGridData($request){
    $location;
    $data_array;
    if(!empty($request['id'])){
      //get location using the it's id
      $location = $this->entity_manager->find('location', $request['id']);

      $data_array = array(
        array(
          'location_id' => $location->getValue('location_id'),
          'street_address' => $location->getValue('street_address'),
          'city' => $location->getValue('city'),
          'zip' => $location->getValue('zip'),
          'country' => $location->getValue('country')
        )
      );

    }else if(!empty($request['parent_table_name'] && !empty($request['parent_id']))){
      //get location using the parent table relationship
      $parent_model = $this->entity_manager->find($request['parent_table_name'], $request['parent_id']);
      $location = $this->entity_manager->find('location', $parent_model->getValue('location_id'));

      $data_array = array(
        array(
          'location_id' => $location->getValue('location_id'),
          'street_address' => $location->getValue('street_address'),
          'city' => $location->getValue('city'),
          'zip' => $location->getValue('zip'),
          'country' => $location->getValue('country')
        )
      );

    }else{
      //get full list of location
      $data_array = array();

             $model_dao = $this->entity_manager->getDao($request['table_name']);
             $array_bootgrid_data = ($model_dao->findGridSearch($request));
             $array_of_model_obj = $array_bootgrid_data['array_of_model_obj'];
             $total = $array_bootgrid_data['total'];

             foreach($array_of_model_obj as $key => $model){
               $row_array = array();
               $row_array['location_id'] = $model->getValue('location_id');
               $row_array['street_address'] = $model->getValue('street_address');
               $row_array['city'] = $model->getValue('city');
               $row_array['zip'] = $model->getValue('zip');
               $row_array['country'] = $model->getValue('country');
               array_push($data_array, $row_array);
             }

    }


    $json_data = array(
      'current' => $request['current'],
      'rowCount' => $request['rowCount'],
      'rows' => $data_array,
      'total' => $total
    );

    wp_send_json(json_encode($json_data));
  }



  public function register($request){
    return require (BASEPATH . '/Implement/mvc/view/models/location/new.php');
  }

  public function save($request){
    $location = MapperHelper::mapRequestToObject($request['table_name'], $request['location'][0]);
    $this->dao->save($location);
    if($request['isNode']){
      $request['selected_value'] = $location->getValue('location_id');
      $this->createSelectForm($request);
    }else{
      echo 'Change Display To Sucess full Registeration Message';
    }
  }

  public function createSelectForm($request){
  $id_name_pair = Helper::getSelect2Data($this->dao->list_all(), 'location_id', 'location_name');
  $body = include (BASEPATH . '/Implement/mvc/view/models/location/select2.php');
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
