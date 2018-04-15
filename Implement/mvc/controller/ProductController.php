<?php
class ProductController extends GenericController{

  public function register($request){
    return require (BASEPATH . '/Implement/mvc/view/models/product/new.php');
  }

  public function save($request){
    $this->service->save($request);
  }

  public function addNewNode($request){
    $this->service->register($request);
  }

  public function addExisting($request){
    $this->service->createSelectForm($request);
  }

}
