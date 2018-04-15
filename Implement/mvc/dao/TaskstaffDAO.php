<?php
class TaskstaffDAO extends GenericDAO{
  public function save($taskstaff){
    $taskstaff->save();
  }

  public function getMatch($id, $column){
    $taskstaff = ModelFactory::createModel('taskstaff');
    return $taskstaff->getMatch($id, $column);
  }


} ?>
