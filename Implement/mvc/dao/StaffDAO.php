<?php
class StaffDAO extends GenericDAO{
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
