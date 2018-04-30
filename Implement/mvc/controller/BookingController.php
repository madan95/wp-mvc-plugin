<?php

class BookingController extends GenericController{

//create new booking and redirect it to booking view
  public function createNew($request){
    $this->service->createNewBooking($request);
  }


// View specific Item Details
  public function viewDetail($request){
    return require (BASEPATH. '/Implement/mvc/view/models/'.$request['table_name'].'/viewDetail.php');
  }

  //create dublicate table for order which won't change ever
  public function snapshot_order($request){

      $tables_to_dublicate = array(
          'booking',
          'location',
          'client',
          'customer',
          'task',
          'taskstaff',
          'product'
      );

      //Create Dublicate Table only if it doesn't Exist
      $dublicate = new dublicate();
      $dublicate->dublicateTables($tables_to_dublicate);

      $booking_id = $request['table_id'];
      $booking = $this->entity_manager->find('booking', $booking_id);
      $booking_location = $this->entity_manager->find('location', $booking->getValue('location_id'));
      $customer = $this->entity_manager->find('customer', $booking->getValue('customer_id'));
      $customer_location = $this->entity_manager->find('location', $customer->getValue('location_id'));
      $clients = $this->entity_manager->getMatch('client', 'customer_id', $customer->getValue('customer_id'));
      $tasks = $this->entity_manager->getMatch('task', 'booking_id', $booking->getValue('booking_id'));


      console($booking);

      //using this booking_id find all other table row and put it into dublicate tables


     /*global $wpdb;

      $booking_id = $request['table_id'];
      $wpdb->query( $wpdb->prepare(
        "SELECT * FROM pca_dummy_booking where booking_id = `$booking_id`"
      ));
*/


  }



























  public function save($request){
    $this->service->save($request);
  }

  public function view($request){
    if($request['id']){
      //View All Detail of this specific item
      $data = $this->service->viewDetail($request);
      return require (BASEPATH. '/Implement/mvc/view/models/'.$request['table_name'].'/viewDetail.php');
      }else{
      //View all The list of Type similllar to to this specific item
    }

  }


}
