<?php
class ProductstaffDAO extends GenericDAO{
  public function save($productstaff){
    $productstaff->save();
  }
} ?>
