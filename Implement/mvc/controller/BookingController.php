<?php
class BookingController extends GenericController{

  public function save($request){
    $this->service->save($request);
  }

  public function view($request){
    if($request['id']){
      //View All Detail of this specific item
      $data = $this->service->viewDetail($request);
      return require (BASEPATH. '/Implement/mvc/view/models/'.$request['table_name'].'/viewDetail.php');
      }else{
      //View all The list of Type similllar to to this specific item
    }

  }


}
