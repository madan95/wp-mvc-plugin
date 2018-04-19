<?php
class EntityManager{
///  private $db;
//  private $unitOfWork;

  public function __construct(){
  //  global $wpdb;
//    $this->db = $wpdb;
  //  $this->unitOfWork = new UnitOfWork($this);
  }

  public function beginTransaction(){
//    $this->db->query('START TRANSACTION');
  }

  public function commit(){
  //  $this->db->query('COMMIT');
  }

  public function rollback(){
  //  $this->db->query('ROLLBACK');
  }

  public function createQueryBuilder(){
  //  return new QueryBuilder($this);
  }



// Returns DAO of them model type given using this we can use DAO Specific Methods
  public function getDao($model_name){
    return DAOFactory::createDAO($model_name);
  }

  public function find($model_name, $id){
    $model_dao = DAOFactory::createDAO($model_name);
    return $model_dao->find($id);
  }

  public function findAll($model_name){
    $model_dao = DAOFactory::createDAO($model_name);
    return $model_dao->findAll();
  }

  public function getAnyMatch($model_name, $key_word){
    $model_dao = DAOFactory::createDAO($model_name);
    return $model_dao->getAnyMatch($key_word);
  }

  public function persist($model){
    $model_dao = DAOFactory::createDAO($model->getTableName());
    return $model_dao->persist($model);
  }

  public function update($model){
    $table_name;
    if(is_object($model)){
      $table_name = $model->getTableName();
    }else{
      $table_name = $model['table_name'];
    }
    $model_dao = DAOFactory::createDAO($table_name);
    return $model_dao->update($model);
  }

  public function delete($model){
    $table_name;
    if(is_object($model)){
      $table_name = $model->getTableName();
    }else{
      $table_name = $model['table_name'];
    }
    $model_dao = DAOFactory::createDAO($table_name); //create client dao
    return $model_dao->delete($model);
  }

// get the table and check if the colmn has key and send back the result
  public function getMatch($model_name, $column, $keyword){
    $model_dao = DAOFactory::createDAO($model_name);
    return $model_dao->getMatch($column , $keyword);
  }

// return specific column  from the match
  public function getMatchValue($model_name, $column, $keyword, $column_to_return){
    $model_dao = DAOFactory::createDAO($model_name);
    return $model_dao->getMatchValue($column, $keyword, $column_to_return);
  }

  //return child / parent table of currect table
  //table to search = booking
  //table to search primary key (row)= 1
  //column to find table to return fk/pk = (row)
  //table to return = customer
  public function getRelationshipModel($table_to_search, $column_to_search, $value_to_search, $table_to_return){

  }

  public function getRelatedModelOld($model_to_search_on, $model_to_return){
    $model_dao = DAOFactory::createDAO($model_to_search_on);
    $model_related = $model_dao->joinLeft($model_to_return);
    return $model_related;
  }

  public function getRelatedModel($model_to_return, $model_to_search){
    $model_to_return_dao = DAOFactory::createDAO($model_to_return);
    return $model_to_return_dao->getRelatedModel($model_to_search);
  }

  public function getRelatedModelWithWhere($model_to_return, $model_to_search,  $where_column_table, $where_value){
      $where_column = ModelFactory::getModel($where_column_table)->getPrimaryKey();
      $model_to_return_dao = DAOFactory::createDAO($model_to_return);
      return $model_to_return_dao->getRelatedModelWithWhere($model_to_search, $where_column, $where_value);
  }

}
 ?>
