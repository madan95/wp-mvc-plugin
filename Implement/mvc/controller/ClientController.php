<?php

class ClientController extends GenericController{
  
    public function register($request){
      $this->service->register($request);
    }

    public function save($request){
      $this->service->save($request);
    }

}

 ?>
