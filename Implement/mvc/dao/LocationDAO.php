<?php
class LocationDAO extends GenericDAO{

  public function save($location){
    $location->save();
  }

  public function list_all(){
    $location = ModelFactory::createModel('location');
    return $location->list_all();
  }

  public function get($id){
    $location = ModelFactory::createModel('location');
    $location->find($id);
    return $location;
  }



}
