<?php
class Genericmodel extends BaseModel{

  public function genericFind($what, $from, $where){
    global $wpdb;
    $from = TABLE_PREFIX.$from;
    $where_qry = $this->whereGenerator($where);
    return Helper::stdObjToArray($wpdb->get_results("SELECT $what FROM `$from` $where_qry "));
  }

  public function whereGenerator($where){
    global $wpdb;
    $where_statements =  array();
    foreach($where as $key => $value){
      $where_statements[] = $wpdb->prepare(" `$key` = '%d'", $value);
    }
    $qry =" WHERE ". implode(" AND ", $where_statements);
    return $qry;
  }


} ?>
