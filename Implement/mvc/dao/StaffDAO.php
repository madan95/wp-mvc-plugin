<?php
class StaffDAO extends GenericDAO{//update the model in database


  public function update($model){
    parent::update($model);

    $staff = ModelFactory::getModel('staff');
    if($staff->hasColumn($model['column'])){
      //MIght NEED TO COME BACK IN FUTURE FOR THIS / user and staff has different properties
      parent::update($model);
    }else{
      //if not staff update users
      $staff = $this->entity_manager->find('staff', $model['id']);
      $user_id = $staff->getValue('user_id');
      return $this->db->update( $this->db->prefix .'users', array($model['column'] => $model['value']), array('ID' => $user_id));
    /*  wp_update_user(array(
        'ID' => $model['id']
      ))*/
    }
  }


  public function save($staff){
    $staff->save();
  }

  public function list_all(){
    $staff = ModelFactory::createModel('staff');
    return $staff->list_all();
  }

//  public function find($id){
////    $staff = ModelFactory::createModel('staff');
//    $staff->find($id);
  //  return $staff;
//  }

  public function get($id){
    $staff = ModelFactory::createModel('staff');
    $staff->find($id);
    return $staff;
  }
} ?>
