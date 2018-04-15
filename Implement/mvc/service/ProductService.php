<?php
class ProductService extends GenericService{

  public function getGridData($request){
    console($request);
    
    $task_id = $request['parent_id'];
    $task = $this->entity_manager->find('task', $task_id);
    $product = $this->entity_manager->find('product', $task->getValue('product_id'));
    $data_array = array();
    array_push($data_array,  $product->getColumnsWithValue());
    ServiceHelper::createBootGridJSONResponse($data_array);
}

  public function getBootGridData($request){
    $product_dao = $this->entity_manager->getDao('product');
    $bootgrid_data =  $product_dao->getBootGridData($request);

    $data_array = array();
    foreach($bootgrid_data['array_of_model_obj'] as $key => $model){
    //  $temp_array = array();

    //  $temp_array['product_id'] = $model->getValue('product_id');
    //$temp_array['product_name'] = $model->getValue('product_name');
    //  $temp_array['product_cost'] = $model->getValue('product_cost');
      //console($temp_array);
  //    console($model->getColumnsWithValue());
    //  $temp_array = $model->getColumnsWithValue();
      array_push($data_array,  $model->getColumnsWithValue());
    }

    ServiceHelper::createBootGridJSONResponse(
      $data_array,
      $request['current'],
      $request['rowCount'],
      $bootgrid_data['total']
    );
  }


  public function register($request){
    return require (BASEPATH . '/Implement/mvc/view/models/product/new.php');
  }

  public function save($request){
    $product = MapperHelper::mapRequestToObject($request['table_name'], $request['product'][0]);
    $this->dao->save($product);

if($request['staff']){
    $staff_dao = DAOFactory::createDAO('staff');
    $productstaff_dao = DAOFactory::createDAO('productstaff');
    foreach ($request['staff'] as $key => $value) {
      $staff = $staff_dao->find($value['staff_id']);
      $productstaff = ModelFactory::createModel('productstaff');
      $productstaff->setValue('product_id', $product->getValue('product_id'));
      $productstaff->setValue('staff_id', $staff->getValue('staff_id'));
      $productstaff_dao->save($productstaff);
    }
  }

  if($request['isNode']){
    $request['selected_value'] = $product->getValue('product_id');
    $this->createSelectForm($request);
  }else{
    echo 'Change Display To Sucess full Registeration Message';
  }
  /*  if($request['staff']){
      $staff_dao = DAOFactory::createDAO('staff');
      $productstaff_dao = DAOFactory::createDAO('productstaff');

      foreach ($request['staff'] as $key => $value) {
        $staff = MapperHelper::mapRequestToObject('staff', $value);
      //  $staff_dao->save($staff);
      $staff_dao->find($id);
        console($staff);

        $productstaff = ModelFactory::createModel('productstaff');
        $productstaff->setValue('product_id', $product->getValue('product_id'));
        $productstaff->setValue('staff_id', $staff->getValue('staff_id'));
        $productstaff_dao->save($productstaff);

      }
    }*/
  }



  public function createSelectForm($request){
    console($request);
  $id_name_pair = Helper::getSelect2Data($this->dao->list_all(), 'product_id', 'product_name');
  $body = include (BASEPATH . '/Implement/mvc/view/models/product/select2.php');
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
 ?>
