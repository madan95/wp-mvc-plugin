<?php
/**
 * Created by PhpStorm.
 * User: madan
 * Date: 22/01/2018
 * Time: 16:28
 */


//factory method to create model of a particullar table
 function model_factory($table_name)
{
    $model = new Model();
    $model->init($table_name);
    return $model;
}


function create_booking_summary($request){
            $booking_id = $request['id'];
            $booking_row = $customer_row = $client_row = $task_row = $task_array= [];

            $booking_model = model_factory(TABLE_PREFIX.'booking');
            $customer_model = model_factory(TABLE_PREFIX.'customer');
            $client_model = model_factory(TABLE_PREFIX.'client');
            $task_model = model_factory(TABLE_PREFIX. 'task');
            $product_model = model_factory(TABLE_PREFIX. 'product');
            $location_model =model_factory(TABLE_PREFIX. 'location');
            $group_model = model_factory(TABLE_PREFIX. 'group');
            $staff_model = model_factory(TABLE_PREFIX. 'staff');
            $groupstaff_model = model_factory(TABLE_PREFIX. 'groupstaff');


            $booking_row = $booking_model->get_row($booking_id);
            $customer_row = $customer_model->get_row($booking_row->customer_id);
            $client_row = $client_model->get_row_specific('customer_id', $booking_row->customer_id);
            $task_row = $task_model->get_row_specific('booking_id', $booking_id);



            foreach ($task_row as $task_number => $task){
                $staff_row = [];
                $product_row = $product_model->get_row($task->product_id);
                $location_row = $location_model->get_row($task->location_id);
                $group_row = $group_model->get_row($task->group_id);
                $group_id = $task->group_id;
                $groupstaff_row = $groupstaff_model->get_row_specific('group_id', $group_id);
                $task_array[$task_number]['task'] = stdObjctToArray($task);
                $task_array[$task_number]['product'] = stdObjctToArray($product_row);
                $task_array[$task_number]['location'] =stdObjctToArray($location_row);
                $task_array[$task_number]['group'] = stdObjctToArray($group_row);
                $task_array[$task_number]['groupstaff'] = stdObjctToArray($groupstaff_row);
                foreach ($groupstaff_row as $groupstaff_number => $groupstaff){
                    $staff_id = $groupstaff->staff_id;
                    $staff_row[] = $staff_model->get_row($staff_id);
                }
                $task_array[$task_number]['staff'] = stdObjctToArray($staff_row);
            }


            $booking_array = stdObjctToArray($booking_row);
            $customer_array =  stdObjctToArray($customer_row);
            $client_array =  stdObjctToArray($client_row);


             $data = array(
               'booking' => $booking_array,
               'customer' => $customer_array,
               'client' => $client_array,
               'tasks' => $task_array
             );

             showBookingDetails($data);
        }

        function showBookingDetails($data){
                foreach ($data as $data_name => $array_value){
                    create_booking_form_group($data, $data_name, uniqid());
                }
        }

        function array_print($item, $key){
         if(is_array($item)){
            array_walk($item, 'array_print');
                 echo '<br>';
         }else{
             echo $key. " => ". $item . "<br>";
         }
    }

 function create_booking_form_group($data, $data_name, $unique_id){
       echo  '<button style="width:100%;" data-toggle="collapse" data-target="#form-group-'.$unique_id.'">
                                   View Detail on '.$data_name.'
                        </button>
                        <div id="form-group-'.$unique_id.'" class="collapse"> ';
              array_walk($data[$data_name], 'array_print');
        echo    ' </div> </br> </br> ';
    ?>

    <?php
}

