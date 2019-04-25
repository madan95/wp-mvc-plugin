<?php
class Product{
  private $productId;
  private $productName;
  private $productCost;
  private $nominalCode;

  public function __construct(){

  }


  function getProductName() {
      return $this->productName;
  }

  function getProductCost() {
      return $this->productCost;
  }

  function getNominalCode() {
      return $this->nominalCode;
  }

  function setProductName($productName) {
      $this->productName = $productName;
  }

  function setProductCost($productCost) {
      $this->productCost = $productCost;
  }

  function setNominalCode($nominalCode) {
      $this->nominalCode = $nominalCode;
  }


  function getProductId() {
      return $this->productId;
  }

  function setProductId($productId) {
      $this->productId = $productId;
  }



}

 ?>
