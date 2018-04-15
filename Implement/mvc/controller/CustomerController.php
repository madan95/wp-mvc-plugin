<?php
class CustomerController extends GenericController{

  //Used to create new row on a table
  public function createNew($request){
   $this->service->createOrUseExisting($request);
  }
  //Use exisiting model
  public function useExisting($request){
    $this->service->createOrUseExisting($request);
  }


    public function save($request){
      $this->service->save($request);
    }

    public function register($request){
      $this->service->register($request);
    }

    public function addNewNode($request){
      $this->service->register($request);
    }

    public function addExisting($request){
      $this->service->createSelectForm($request);
    }

}

 ?>
