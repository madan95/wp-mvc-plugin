<?php
class TaskDAO extends GenericDAO{


  public function save($task){
    $task->save();
  }

//  public function getMatch($id, $column){
//    $task = ModelFactory::createModel('task');
//    return $task->getMatch($id, $column);
  //  $list_of_task_obj = array();
  //  foreach($array_task as $key => $value){
  //    $list_of_task_obj[] = MapperHelper::mapRequestToObject('task', $value);
//    }
//    return $list_of_task_obj;
//  }


    public function get($id){
      //crud

      try{
        $data = Query::getTable('task')->find($id);
      }catch(Exception $e){
        throw new Exceipton($e);
      }

      if(!$data){return null;}

      $task = ModelFactory::getModel('task');
      $task =
      $task = ModelFactory::justCeateModel('task');
      $task =

      $task = ModelFactory::createModel('task');
      $task->find($id);
      return $task;
    }

    public function findOld($id){
      $task = ModelFactory::getModel('task');
      $data = Query::getTable('task')->find($id);

    }



} ?>
