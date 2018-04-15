<?php
class BootGridDAO{

  private $current = '';
  private $rowCount = '';
  private $sort = '';
  private $searchPhrase = '';
  private $table_name = '';
  private $ajax_action = '';
  private $isAjax = '';
  private $unique_id = '';

  private $order_by ='';
  private $order ='';
  private $end_row = 10;
  private $page = 1;
  private $begin_row = '';
  private $total = '';
  private $key_word = '';
  private $db_table_name = '';
  private $columns_with_value = '';
  private $db;
  private $data_result = '';

  public function __construct($request){
    global $wpdb;
    $this->db = $wpdb;
    $this->columns_with_value = $request['columns_with_value'];
    $this->db_table_name = $request['db_table_name'];
    $this->setOrder($request);
    $this->setKeyWord($request);
    $this->setEndRowAndPage($request);
    $this->setBeginRow();
  }

  public function getGridDataSingleTable(){
    $where_qry = Query::whereQueryGenerator($this->key_word, $this->columns_with_value);
    $order_qry = Query::orderQueryGenerator($this->order_by, $this->order);
    if($this->end_row < 0){
      $sql = Query::selectWithWhereQueryGenerator($this->db_table_name, $where_qry);
    }else{
      $sql = Query::selectWithLimitQueryGenerator($this->db_table_name, $where_qry, $this->begin_row, $this->end_row);
    }
    return $this->db->get_results($sql, 'ARRAY_A');
  }


//TOTAL NUMBER OF RESULT AVIABLE
  public function get_count_total(){
    $where_qry = Query::whereQueryGenerator($this->key_word, $this->columns_with_value);
    $count_sql = Query::createCountQuery($this->db_table_name, $where_qry);
    return $this->db->get_var($count_sql);
  }

//set the row to begin to get data from
  public function setBeginRow(){
    $this->begin_row = ($this->page * $this->end_row) - $this->end_row;
  }

//used to make sure how many data to retrive
  public function setEndRowAndPage($request){
    if(isset($request['rowCount'])){
      $this->end_row = $request['rowCount'];
    }
    if(isset($request['current'])){
      $this->page = $request['current'];
    }
  }


//set order by parameter for sql
  public function setOrder($request){
    if(isset($request['sort'])){
      foreach($request['sort'] as $name => $value){
        $this->order_by = $name;
        $this->order = $value;
      }
    }
  }

//if there is search phrase set it in sql
  public function setKeyWord($request){
    if(!empty($request['searchPhrase'])){
      $this->key_word = $request['searchPhrase'];
    }
  }

}
 ?>
