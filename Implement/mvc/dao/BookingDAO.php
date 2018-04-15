<?php

class BookingDAO extends GenericDAO{
  public function save($booking){
    $booking->save();
  }

  public function get($id){
    $booking = ModelFactory::createModel('booking');
    $booking->find($id);
    return $booking;
  }

}
