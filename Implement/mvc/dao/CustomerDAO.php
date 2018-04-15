<?php
class CustomerDAO extends GenericDAO{


    public function save($customer){
      $customer->save();
    }

    public function list_all(){
      $customer = ModelFactory::createModel('customer');
      return $customer->list_all();
    }

    public function get($id){
      $customer = ModelFactory::createModel('customer');
      $customer->find($id);
      return $customer;
    }

    public function remove($id){
      $customer = ModelFactory::createModel('customer');
      EM::remove($customer);

    }

}
