<?php
/*
Plugin Name: PCA Job Booking
*/
/**
 * Created by PhpStorm.
 * User: Luke
 * Date: 30/11/2017
 * Time: 18:24
 */

global $wpdb;
define('BASEPATH', __DIR__); // Base path of plugin
define('PLUGIN_PATH', __FILE__ ); // file path of plugin
define('SHORT_CODE_NAME', 'view_page'); // name of short-code used in plguin
define('TABLE_VARIABLES', BASEPATH . '/core/config/variables.php'); //table variable location
define('TABLE_PREFIX',  $wpdb->prefix . 'peach22_'); //Prefix of databse + plugin
define('CAPABILITIES_SETTINGS', BASEPATH . '/core/config/capabilities.php'); // ??
define('DELMITER', ','); //??

require BASEPATH .'/core/helper/debug.php'; // Contains methods for debuging
require BASEPATH . '/core/config/variables.php'; //Contains Variables need for database and settings

require BASEPATH . '/core/view/globalView.php'; // ??
require BASEPATH . '/core/config/capabilities.php'; //??


require BASEPATH .'/core/helper/helper.php'; // Helper methods like converting arrray to class or removing foregin key from array ...
require BASEPATH .'/core/helper/util.php'; // Util methods to get result from given parameters e

require BASEPATH . '/core/model/Model.php'; //Model class taht interacts with database and store the model info
require BASEPATH . '/core/helper/booking_handler.php'; // ???

require BASEPATH . '/core/view/viewHelper.php';//view class with methods for view
require BASEPATH . '/core/view/viewComponentHelper.php';//view class with methods for view
require BASEPATH . '/core/view/view.php';//view class with methods for view
require BASEPATH. '/core/controller/controller.php'; // controller class with controller methods which create model and give data to chossen view
require (BASEPATH .'/core/controller/MainController.php'); // Controller Factory class that Handles REST/ URL (to create right controller)

require BASEPATH . '/Plugin.php'; // Class that creates DATABASE and tables
require BASEPATH . '/BasicActive.php'; // Bringing all Together
