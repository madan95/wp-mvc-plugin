<?php
class TaskController  extends GenericController{

  public function getTotalPrice($request){
   $this->service->getTotalPrice($request);
  }

  public function register($request){
    $this->service->register($request);
  }

  public function save($request){
    $this->service->save($request);
  }

  public function view($request){
    //assign the service
    //assign view to the data return fromt the service
    $task_dao = DAOFactory::createDAO('task');
    if($request['task_id']){
      $task = $task_dao->find($request['task_id']);
    }else{
      $task_lists = $task_dao->findAll();
    }
  }







}
