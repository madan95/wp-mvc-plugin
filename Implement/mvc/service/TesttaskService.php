<?php
class TaskService extends GenericService{

  public function viewSingle($request){
    $task_id = $request['task_id'];
    $repo = RepositoryFactory::createNewRepository('task');
    $task = $repo->findById($task_id);

    echo $task_id;
    $task_dao = DAOFactory::createDAO('task');
    $task_dao->get($task_id);
  }

}
 ?>
