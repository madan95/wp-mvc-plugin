<?php
class LocationtaskController extends GenericController{

  public function locationRelatedTask($request){
    $this->service->locationRelatedTask($request);
  }

  public function taskOnCalendar($request){
    $this->service->taskOnCalendar($request);
  }




}
