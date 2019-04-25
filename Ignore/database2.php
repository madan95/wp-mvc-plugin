<?php
/**
 * Created by PhpStorm.
 * User: madan
 * Date: 22/12/2017
 * Time: 14:21
 */

function createDatabase(){
    global $wpdb;
    $table_name = $wpdb->prefix. 'booking';
    $charset_collate = $wpdb->get_charset_collate();


    $sql = "CREATE TABLE $table_name (booking_id bigint(20) NOT NULL AUTO_INCREMENT, booking_start_date DATE, booking_task_id bigint(20), PRIMARY KEY(booking_id),  FOREIGN KEY (booking_task_id) REFERENCES pca_task(pca_task_id)) $charset_collate;";
  echo $sql;
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
}
register_activation_hook( __FILE__, 'my_plugin_create_db' );

function my_plugin_create_db() {

    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    $table_name = $wpdb->prefix . 'my_analysis';

    $sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		views smallint(5) NOT NULL,
		clicks smallint(5) NOT NULL,
		UNIQUE KEY id (id)
	) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );




}

/*CREATE TABLE pca_booking (
    booking_id int NOT NULL AUTO_INCREMENT,
    booking_location_id int ,
    booking_detail varchar(244),
    PRIMARY KEY (booking_id),
    FOREIGN KEY (booking_location_id) REFERENCES pca_location(locationId)
);*/