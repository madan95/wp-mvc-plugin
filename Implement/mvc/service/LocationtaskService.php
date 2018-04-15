<?php
class LocationtaskService extends GenericService{

  public function locationRelatedTask($request){
    //Get Location ID
    //Find Task Related to the Location
    // Display Task in location table while ordering them in Latest to Furthest Date order
    $location_dao = DAOFactory::createDAO('location');
    $location = $location_dao->get($request['location_id']);
    $location_id = $location->getValue('location_id');

    $task_dao = DAOFactory::createDAO('task');
    $list_of_task_obj = $task_dao->getMatch($location_id, 'location_id');

    echo $location->getValue('location_name').'<br>';
    echo 'Task List In This Location :: <br>';

    foreach($list_of_task_obj  as $key => $task){
      echo '<h3>TASK NUMBER : '.($key+1).'</h3><br>';
      echo 'Product Name : '. $task->getProduct()->getValue('product_name') .'<br>';
      echo 'Product Quanity : '. $task->getValue('product_quantity').'<br>';
      echo 'Start Date : '. $task->getValue('date_start').'<br>';
      echo 'End Date : '. $task->getValue('date_finish').'<br>';
      echo 'Total Time : '. $task->findTotalTime().'<br>';
      echo 'Total Cost : '. $task->findTotalCost().'<br>';

        }
        return $list_of_task_obj;

  }

  public function taskOnCalendar($request){
    $location_dao = DAOFactory::createDAO('location');
    $location = $location_dao->get($request['location_id']);
    $list_of_task_obj = $this->locationRelatedTask($request);
    $events = array();
    foreach($list_of_task_obj as $key => $task){
      $events[$task->getValue('date_start')] = array('text' => $task->getValue('description'), 'href' => 'google.com');
    }
    $month = $request['month'] ? $request['month'] : date("m");
    $year = $request['year'] ? $request['year'] : date("Y");

  /*  $events = [
      '2018-03-05' => [
        'text' => "An event for the 5 july 2015",
        'href' => "http://example.com/link/to/event"
      ],
      '2018-03-23' => [
        'text' => "An event for the 23 july 2015",
        'href' => "/path/to/event"
      ],
    ];
*/
    echo $this->build_html_calendar($year, $month, $events);
  }



    public function build_html_calendar($year, $month, $events = null) {

    // Table headings
    $headings = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
    $calendar = "<div class='div-table'>";
    // Days and weeks
    $running_day = date('N', mktime(0, 0, 0, $month, 1, $year));
    $days_in_month = date('t', mktime(0, 0, 0, $month, 1, $year));
    $dayOfWeek = $running_day;

    $monthNum  = $month;
    $dateObj   = DateTime::createFromFormat('!m', $monthNum);
    $monthName = $dateObj->format('F');
    // Keep going with days...
      $calendar .="<div class='div-table-row'>";
      $calendar .= "<div class='div-table-col'>";
      $calendar .= "<div>Date</div>";
      $calendar .= "</div>";
      $calendar .= "<div class='div-table-col'>";
      $calendar .= "<div>Task Description</div>";
      $calendar .= "</div>";
      $calendar .="</div>";
    for ($day = 1; $day <= $days_in_month; $day++) {
      $calendar .="<div class='div-table-row'>";

      // Check if there is an event today
      $cur_date = date('Y-m-d', mktime(0, 0, 0, $month, $day, $year));
      $draw_event = false;
      if (isset($events) && isset($events[$cur_date])) {
        $draw_event = true;
      }

      // Add the day number
      $calendar .= "<div class='div-table-col'>";
      $calendar .= "<div>" .$headings[$dayOfWeek-1]." ". $day . " ".$monthName."</div>";
      $calendar .="</div>";
      // Insert an event for this day
      if ($draw_event) {
        $calendar .=
        "<div class='div-table-col'>".
        "<div>" .
        "<a href='{$events[$cur_date]['href']}'>" .
        $events[$cur_date]['text'] .
        "</a>" .
        "</div>".
          "</div>";
      }
      if($dayOfWeek == 7){
        $dayOfWeek = 0;
      }
      $dayOfWeek ++;

      $calendar .="</div>";

    } // for $day

    // End the table
    $calendar .= '</div>';

    // All done, return result
    return $calendar;
  }

}
 ?>
