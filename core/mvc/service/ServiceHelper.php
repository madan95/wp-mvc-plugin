<?php
class ServiceHelper{


//create a json reply to bootgrid ajax request
  public function createBootGridJSONResponse($data_array, $current = null, $rowCount=null, $total=null){
    $json_data = array(
      'current' => $current,
      'rowCount' => $rowCount,
      'total' => $total,
      'rows' => $data_array
    );
    wp_send_json(json_encode($json_data));
  }

  //Single place to set the reqt from request paramaeter can be cure used in futurue for multtiple place to set the paraever changing paramaeters
    static function setRequestParameters($req){
      $request = array(
        'booking_id' => isset($req['booking_id'])? $req['booking_id'] : '',
        'table_name' => $req['table_name'],
        'id' => $req['id'],
        'parent_table_name' => $req['parent_table_name'],
        'parent_id' => $req['parent_id'],
        'node_id' => $req['node_id'] //remembner it the ithe node vaklue of the exisitng item and used as a reference from the fk of t a table
      );
        return $request;
    }



}

 ?>
