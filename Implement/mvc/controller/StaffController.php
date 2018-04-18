<?php
class StaffController extends GenericController{


  public function save($request){
    $this->service->save($request);
  }

  public function addNewNode($request){
    $this->service->register($request);
  }

  public function addExisting($request){
    $this->service->createSelectForm($request);
  }

  public function relatedTasks($request){
    $this->service->relatedTasks($request);
  }

  public function createNew($request){
    $this->service->createNewStaff($request);
  }
}
