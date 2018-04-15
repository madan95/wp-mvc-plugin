<?php

class ClientDAO extends GenericDAO{

  public function save($client){
    $client->save();
  }

  public function getMatchd($id, $column){
    $client = ModelFactory::createModel('client');
    return $client->getMatch($id, $column);
  }


}
