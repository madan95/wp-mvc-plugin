<?php
class ProductDAO extends GenericDAO{
  public function save($product){
    $product->save();
  }

  public function list_all(){
    $product = ModelFactory::createModel('product');
    return $product->list_all();
  }

  public function get($id){
    $product = ModelFactory::createModel('product');
    $product->find($id);
    return $product;
  }
} ?>
