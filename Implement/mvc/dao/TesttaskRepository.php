<?php

class TesttaskRepository{
  private $persistence;

  public function __construct($persistence){
    $this->persistence = $persistence;
  }

  public function findById($id){
    $arrayData = $this->persistence->retrieve($id);
    return Testtask::fromState($arrayData);
  }

  public function save($testtask){
    $id = $this->persistence->persist([

    ]);

  }
}
