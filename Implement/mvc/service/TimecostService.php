<?php
class TimecostService extends GenericService{

  public function index($request){
    //find task's related to this booking_id
    //get the product cost by time required for it to be done
    console('something');

    $booking_id = $request['booking_id'];
    $task_dao = DAOFactory::createDAO('task'); //create client da
    $list_of_task_obj = $task_dao->getMatch($booking_id, 'booking_id');
    $time_cost_list = array();
    foreach($list_of_task_obj as $key => $task){
      console($task->findTotalTime());
      console($task->findTotalCost());
      console($task->getProduct()->getValue('product_name'));
      echo '<h1> Product Number : '.($key+1).'</h1>';
      echo 'Product Name : '. $task->getProduct()->getValue('product_name') .'<br>';
      echo 'Product Quanity : '. $task->getValue('product_quantity').'<br>';
      echo 'Total Time : '. $task->findTotalTime().'<br>';
      echo 'Total Cost : '. $task->findTotalCost().'<br>';
    }


  }



}
 ?>
