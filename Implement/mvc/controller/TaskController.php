<?php
class TaskController  extends GenericController{

  public function viewTaskOfCurrentUser($request){
    $current_user = wp_get_current_user();
    $current_user_id = $current_user->ID;
    $this->service->viewTaskOfCurrentUser($current_user_id);
  }

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


  public function getGridDatad($request){
      console($request);
  }






}
