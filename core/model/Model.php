<?php
/**
 * Created by PhpStorm.
 * User: Madan
 * Date: 18/12/2017
 * Time: 3:17 AM
 */

class Model
{
    private $table_name;
    private $primary_key;
    private $columns;
    private $columns_length;
    private $table_name_no_prefix;


    private $db;
    private $pk_is_int;
    private $fk_keys;
    private $relate;


    public function __construct()
    {

    }

    public function init($table_name){
        global $wpdb;
        $this->db = $wpdb;

        $this->setTableName($table_name);
        $this->setTableNameNoPrefix($table_name);
        $this->setPrimaryKey($table_name);
        $this->setColumns($table_name);
        $this->setColumnsLength($this->columns);

        $this->set_relate($table_name);

        // Use Following if getting table details from database instead of variable files
        //$this->table_name = $this->primary_key=$this->columns=$this->relate=$this->columns_length="";
      // $this->db->get_row("SELECT * FROM `$this->table_name`"); //get column info
    //   $this->columns = array();
    //   foreach($this->db->get_col_info('name') as $i => $name ){
    //      $this->columns[$name] =  $this->db->col_info[$i]->type;
      //    }
        //$row = $this->db->get_row("SHOW FIELDS FROM `$this->table_name` WHERE `Key` = 'PRI'");
        /*$this->primary_key  = $row->Field; // set primary_key
        $this->pk_is_int = false;
        if(stristr($row->Type, 'int')){ // check if primary key is int (auto incrementer or string) need later for candinate/new key to display
            $this->pk_is_int = true;
        }*/

    }

    public function setTableName($table_name){
      $this->table_name = $table_name;
    }

    public function getTableName(){
      return $this->table_name;
    }

    public function setTableNameNoPrefix($table_name){
      $this->table_name_no_prefix =  str_replace(TABLE_PREFIX, '', $table_name);
    }

    public function getTableNameNoPrefix(){
      return $this->table_name_no_prefix;
    }

    public function setPrimaryKey($table_name){
      $db_prefix = str_replace(TABLE_PREFIX, "", $table_name);
      require TABLE_VARIABLES;
      $this->primary_key = ${"db_$db_prefix"}['primary_key'][0] ;
    }

    public function getPrimaryKey(){
      return $this->primary_key;
    }

    public function setColumns($table_name){
      $db_prefix = str_replace(TABLE_PREFIX, "", $table_name);
      require TABLE_VARIABLES;
      foreach (${"db_$db_prefix"}['fields'] as $field ){
        $this->columns[$field[0]] = $field[1];
      }
    }

    public function getColumns(){
      return $this->columns;
    }

    public function setColumnsLength($columns){
      $this->columns_length = count($columns);
    }

    public function getColumnsLength(){
      return $this->columns_length;
    }
















    public function get_csv(){
        $this->db->query('SELECT * FROM pca_peach22_booking INTO OUTFILE \'/tmp/orders.csv\' FIELDS TERMINATED BY \',\' ENCLOSED BY \'"\' LINES TERMINATED BY \'\n\';');
    }

    public function get_human_readable_table_name(){
      return str_replace(TABLE_PREFIX, "", $this->table_name);
    }

    public function get_table_name(){
        return $this->table_name;
    }

    public function get_columns(){
        return $this->columns;
    }

    public function get_primary_key(){
        return $this->primary_key;
    }












    public function set_relate($table_name){
      $db_prefix = str_replace(TABLE_PREFIX, "", $table_name);
      require TABLE_VARIABLES;
      if(${"db_$db_prefix"}['relate'] ){
      foreach(${"db_$db_prefix"}['relate'] as $item){
        $this->relate[] = $item;
      }
    }
    }







    public function get_row_specific($pk_fk, $id){
        if($id) {
            $like = $this->db->prepare(" `$pk_fk` LIKE %s ", '' . $id . '');
            $sql = "SELECT * FROM `$this->table_name` WHERE $like ";
            return $this->db->get_results($sql);
        }
    }



    public function get_relate(){
      return $this->relate;
    }

    public function remove_fks($relate){
        $temp_columns = $this->columns;
        foreach ($relate as $item){
            unset($temp_columns[$item['pk']]);
        }
        return $temp_columns;
    }

/*
    public function get_fk_table_name($table_name){
      $db_prefix = str_replace(TABLE_PREFIX, "", $table_name);
      include BASEPATH . "/core/model/variables.php";
      $fk = [];
      foreach(${"db_$db_prefix"} as $item ){
       foreach ($item as $key => $value){
           if($key == "view"){
             $fk[] = $value;
           }
       }
   }
   return $fk;
 }*/
 public function get_fk_table_name(){
   $fk_nodes = [];
   $db_prefix = str_replace(TABLE_PREFIX, "", $this->table_name);
     require TABLE_VARIABLES;

     //include BASEPATH . "/core/model/variables.php";
   if(${"db_$db_prefix"}['view'] ){
   foreach(${"db_$db_prefix"}['view'] as $item){
     $fk_nodes[] = $item;
   }
   return $fk_nodes;
 }
 }

    public function get_relate2($table_name){
      $db_prefix = str_replace(TABLE_PREFIX, "", $table_name);
        require TABLE_VARIABLES;

        // include BASEPATH . "/core/model/variables.php";
      $relate = [];
      foreach(${"db_$db_prefix"} as $item ){
       foreach ($item as $key => $value){
           if($key == "relate"){
             $relate[] = $value;
           }
       }
      }
   return $relate;
    }



    public function get_columns_field_type($table_name){
      $db_prefix = str_replace(TABLE_PREFIX, "", $table_name);
        require TABLE_VARIABLES;

        //  include BASEPATH . "/core/model/variables.php";
      $field_type = [];
      foreach (${"db_$db_prefix"} as $item){
        foreach ($item as $key => $value) {
         if($key == "field"){
          $field_type[$value[0]] = $value[1];
        }
      }
    }
      return $field_type;
    }



    public function select_all(){
        return $this->db->get_results("SELECT * FROM `$this->table_name` ");
    }
/*
    public function get_model($params){
      global $wpdb;
      $order_by ="";
        if(isset($params['sort']) && is_array($params['sort'])){
          foreach($params['sort'] as $k => $v){
            $order_by .=" $k $v";
          }
        }
        $rp = isset($params['rowCount']) ? $params['rowCount'] : 10;
        if (isset($params['current'])) { $page  = $params['current']; } else { $page=1; };
        $start_from = ($page-1) * $rp;
        $sql = $sqlRec = $sqlTot = $where = '';
        if( !empty($params['searchPhrase']) ) {
           $where .=" WHERE ( ";
           $keys = array_keys($this->columns);
           for($i=0; $i<$this->columns_length; $i++){
             if($i!=$this->columns_length-1){
             $where .= " ".$keys[$i]." LIKE '".$params['searchPhrase']."%' OR ";
           }else{
             $where .= " ".$keys[$i]." LIKE '".$params['searchPhrase']."%' ) ";
           }
           }
          }
          $sql = "SELECT * FROM `$this->table_name` ";
          $sqlTot .= $sql;
           $sqlRec .= $sql;

           //concatenate search sql if value exist
           if(isset($where) && $where != '') {
             $sqlTot .= $where;
             $sqlRec .= $where;
           }
           if($order_by!=""){
             $sqlRec .= " ORDER BY ".$order_by;
           }
           if ($rp!=-1){
            $sqlRec .= " LIMIT ". $start_from .",".$rp;
          }
          //  $qtot = $wpdb->query($sqlTot);
           $qtot = $wpdb->get_var("SELECT COUNT(*) FROM `$this->table_name` ".$where);
           $data = $wpdb->get_results($sqlRec);

 $json_data = array(
  "current"            => intval($params['current']),
  "rowCount"            => $rp,
  "total"    => $qtot,
  "rows"            => $data,   // total data array,
  "sqled" => $sqlRec
  );
return $json_data;

    }
    */



    public function get_limited_row($params){
      $order_by = "";
      $order = "";
      $key_word = "";

      if(isset($params['sort'])){
        foreach($params['sort'] as $name => $value){
          $order_by = $name;
          $order = $value;
        }
      }else{
        console('SOMETHIGN SOMETHING');

        $order_by = $params['primary_key'];
        $order =  $params['default_sort'];
      }

      if(!empty($params['searchPhrase'])) {
        $key_word = $params['searchPhrase'];
      }

      $end_row = isset($params['rowCount']) ? $params['rowCount'] : 10;
      if (isset($params['current'])) { $page  = $params['current']; } else { $page=1; };
      $begin_row = ($page-1) * $end_row;
      $total = $this->get_count_total($key_word);
      $data = $this->select_condition($key_word, $order_by, $order, $begin_row, $end_row);
      $json_data = array(
       "current"    => intval($params['current']),
       "rowCount"   => $end_row,
       "total"      => $total,
       "rows"       => $data
                 );
      return $json_data;
    }

    public function get_count_total($key_word){
      $where_qry = $this->where_query_generator($key_word);
      $sql = "SELECT COUNT(*) FROM `$this->table_name` ".$where_qry;
      return $this->db->get_var($sql);
    }

    public function select_condition($key_word, $order_by, $order, $begin_row, $end_row){
        $where_qry = $this->where_query_generator($key_word);
        $order_qry = $this->order_query_generator($order_by, $order);
        $sql = "SELECT * FROM `$this->table_name` $where_qry $order_qry LIMIT  $begin_row, $end_row";
        $this->debug = $sql;
        return $this->db->get_results($sql);
    }


    public function select_condition2($key_word){
        $where_qry = $this->where_query_generator2($key_word);
      //  $order_qry = $this->order_query_generator($order_by, $order);
        $sql = "SELECT * FROM `$this->table_name` $where_qry ";
        $this->debug = $sql;
        return $this->db->get_results($sql);
    }

    public function where_query_generator2($key_word){
        $qry = "";
        if($key_word != ""){
            $like_statements = array();
            foreach ($this->columns as $name => $type){
                foreach ($key_word as $key_word_name => $key_word_type){
                    if($key_word_name == $name){
                        if($key_word_type == 'IS NULL'){
                            $like_statements[] = $this->db->prepare(" $key_word_name $key_word_type ");
                        }else{
                            $like_statements[] = $this->db->prepare(" $key_word_name = $key_word_type ");
                        }
                    }
                }
            }
            $qry = " WHERE " .implode(" AND ",$like_statements);
        }
        return $qry;
    }

    public function where_query_generator($key_word){
        $qry = "";
        if($key_word != ""){
            $like_statements = array();
            foreach ($this->columns as $name => $type){
                $like_statements[] = $this->db->prepare(" `$name` LIKE %s ", '%'.$key_word.'%');
            }
            $qry = " WHERE " .implode(" OR ",$like_statements);
        }
        return $qry;
    }

    public function select_joined($table1, $table2, $id1, $id2 ){
        $sql = "SELECT * FROM $table2 JOIN $table1 ON $table1"."$id1=$table2"."$id2;";
        return $this->db->get_results($sql);
    }

    public function order_query_generator($order_by, $order){
        $qry ="";
        if($order_by != ""){
            $order = esc_sql($order);
            $order_by = esc_sql($order_by);
            $qry = " ORDER BY `$order_by` $order";
        }
        return $qry;
    }

    public function get_row_related($field_name, $fk_id){
        $sql = $this->db->prepare("SELECT * FROM `$this->table_name` WHERE `$field_name` = '%s'", $fk_id);
        return $this->db->get_results($sql);
    }



    public function get_row($id){
        $sql = $this->db->prepare("SELECT * FROM `$this->table_name` WHERE `$this->primary_key` = '%s'", $id);
        return $this->db->get_row($sql);
    }

    public function get_field($field_name, $fk_id){
        $sql = $this->db->prepare("SELECT * FROM `$field_name` WHERE `$this->primary_key` = '%s'", $fk_id);
        return $this->db->get_row($sql);
    }

    public function checkIfNull($values){
      if(empty($values)){
        return null;
      }else{
        return $values;
      }
    }

    public function update($values){
        $update_values = array();
        foreach($this->columns as $name => $type){
            $update_values[$name] = $this->checkIfNull($values[$name]);
        }
        if($this->db->update($this->table_name, $update_values, array($this->primary_key=>$values[$this->primary_key]))){
                return true;
        }else{
            return false;
        }
    }

    public function delete($id){
        $sql = $this->db->prepare("DELETE FROM `$this->table_name` WHERE `$this->primary_key` = '%s'", $id);
        if($this->db->query($sql)){
            return true;
        }else{
            return false;
        }
    }

    public function get_new_id(){
        $new_id="";
      /*  if($this->pk_is_int){
            $new_id = $this->db->get_var("SELECT MAX(`$this->primary_key`)+1 FROM `$this->table_name`");
        }else{
            $new_id = $this->db->get_var("SELECT MAX(`$this->primary_key`) FROM `$this->table_name`");
            $new_id .= " ..String PK Add";
        }*/
        $new_id = $this->db->get_var("SELECT MAX(`$this->primary_key`)+1 FROM `$this->table_name`");
        if($new_id==""){
          $new_id=1;
        }
        return $new_id;
    }

    public function insert($values){
        $insert_values = array();
        foreach($this->columns as $name => $type){
            $insert_values[$name] = $this->checkIfNull($values[$name]);
        }
        //check if the primary key already exist
        $sql = $this->db->prepare("SELECT `$this->primary_key` FROM `$this->table_name` WHERE `$this->primary_key`='%s'", $insert_values[$this->primary_key]);
        $exists = $this->db->get_var($sql);

        if($exists == ""){
           if($this->db->insert($this->table_name, $insert_values)){
               return true;
           }else{
               return false;
           }
        }else{
            return false;
        }
    }


        public function insert2($values){
            $insert_values = array();
            foreach($this->columns as $name => $type){
                $insert_values[$name] = $this->checkIfNull($values[$name]);
            }

               if($this->db->insert($this->table_name, $insert_values)){
                   return $this->db->insert_id;
               }else{
                   return false;
               }
        }

    public function create_json_form_field(){
      $form_columns = [];
      foreach($this->columns as $key => $value){
        $temp_array = [];
        $temp_array['field_name'] = $key;
        $temp_array['field_type'] = $value;
        $temp_array['label'] = str_replace("_", " ", $key);
        $temp_array['type'] = get_input_data_type($value);
        if($key == $this->primary_key){
          $temp_array['node'] = 'true';
          $temp_array['value'] = $this->get_new_id();
        }else{
          $temp_array['node'] = 'false';
        }
        array_push($form_columns, $temp_array);
      }
      return $form_columns;
    }


}
