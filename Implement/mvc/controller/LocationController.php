<?php
class LocationController extends GenericController{

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


    //location fields
    public function addLocation($request){
      $this->service->addLocation($request);
    }

}

 ?>
