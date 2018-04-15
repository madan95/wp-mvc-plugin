<?php
class TesttaskController extends GenericController{

  public function view($request){
    if($request['task_id']){
      $viewModelData = $this->service->viewSingle($request);
    }else{
      $viewModelData = $this->service->viewAll($request);
    }
  }

}
