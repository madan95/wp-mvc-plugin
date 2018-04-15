<?php
//Generci service class with implementation to set DAO , exteded by most of the service classes
class GenericService  {
  protected $dao;
  protected $entity_manager;
  protected $passable_model;
  protected $passable_parent;




  public function __construct(){
    $this->entity_manager = EntityManagerFactory::createEM();
  }

//Default Tables with default row and columns for bootgrid table
  public function getGridDataAll($request){
    $array_of_model = $this->entity_manager->findAll($request['table_name']);
    $total = $array_bootgrid_data['total'];
    $data_array = array();
    foreach($array_of_model as $key => $model){
      $row_array = $model->getColumnsWithValue();
      array_push($data_array, $row_array);
    }

    $json_data = array(
      'current' => $request['current'],
      'rowCount' => $request['rowCount'],
      'rows' => $data_array
    );

    wp_send_json(json_encode($json_data));
  }

  public function update($request){
    $this->entity_manager->update($request);
  }

  public function delete($request){
    $this->entity_manager->delete($request);
  }

  public function remove($request){
    $parent =  $this->entity_manager->find($request['parent_table_name'], $request['parent_id']);
    $parent->setValue($request['node_pk'], null);
    $this->entity_manager->update($parent);
  }

  /*public function createNewOld($req){
    $request = Helper::setRequestParameters($req);

    if($request['node_id']){
      //Check if chossen from node
      $model = $this->entity_manager->find($request['table_name'], $request['node_id']);
   }else{
      $model = ModelFactory::getModel($request['table_name']);
      $model->setValue($model->getPrimaryKey(), $this->entity_manager->persist($model));
    }
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
  }*/



  public function select2($request){
    $table_name = $request['table_name'];
    $parent_table_name = $request['parent_table_name'];
    $column_to_display = $request['column'];
    $search = $request['search'];
    $array_models = $this->entity_manager->findAll($table_name);
    foreach($array_models as $key => $model){
      $data[] = array('id' => $model->getValue($model->getPrimaryKey()), 'text' => $model->getValue($column_to_display));
    }
    return $data;
  }

  public function setDAO($dao){
    $this->dao = $dao;
  }

  public function view($request){
    if($request['id']){
        return $this->entity_manager->find($request['table_name'], $request['id']);
    }else{
        return $this->entity_manager->findAll($request['table_name']);
      }
  }



/********************************************Creating Or Using Exisiting Model From Select2 *****************************************/

  //Creating New Row / Model in Table
    public function createNew($request){
      $this->createOrUseExisting($request);
    }

  //When existing Node is chossen for FK
    public function useExisting($request){
      $this->createOrUseExisting($request);
    }

  //Create or Use Existing Model
    public function createOrUseExisting($request){
      if($request['node_id']){   //Check if chossen from node
        $model = $this->entity_manager->find($request['table_name'], $request['node_id']);
      }else{
        $model = ModelFactory::getModel($request['table_name']);
        $model->setValue($model->getPrimaryKey(), $this->entity_manager->persist($model));
      }
      if(!empty($request['parent_table_name']) && !empty($request['parent_id'])){
        $parent =  $this->entity_manager->find($request['parent_table_name'], $request['parent_id']);
        if($parent->hasColumn($model->getPrimaryKey())){    /// if parent has the fk of the model
          $parent->setValue($model->getPrimaryKey(), $model->getValue($model->getPrimaryKey()));
          $this->entity_manager->update($parent);
        }else if($model->hasColumn($parent->getPrimaryKey())){  // if model has the primary key of the parent
          $model->setValue($parent->getPrimaryKey(), $parent->getValue($parent->getPrimaryKey()));
          $this->entity_manager->update($model);
        }else{
          console('middle man to set');
        }
        $this->passable_parent = $parent;
      }
      $this->passable_model = $model;
    }

/****************************************************************************************************************************************************/
}
 ?>
