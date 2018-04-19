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
define('TABLE_VARIABLES', BASEPATH . '/core/plugin/config/variables.php'); //table variable location
define('TABLE_PREFIX',  $wpdb->prefix . 'dummy_'); //Prefix of databse + plugin
define('TWIG_TEMPLATE', BASEPATH .'/Implement/mvc/view/');

//Twig / COmposer libaries
require_once(BASEPATH .'/vendor/autoload.php');


//Entity Manger
require_once (BASEPATH .'/core/ORM/EntityManager.php');
require_once (BASEPATH .'/core/ORM/EntityManagerFactory.php');
require BASEPATH .'/core/ORM/Query.php';


//Controllers Dependents
require_once (BASEPATH . '/core/mvc/controller/ControllerInterface.php');
require_once (BASEPATH . '/core/mvc/controller/GenericController.php');
require_once (BASEPATH . '/core/mvc/controller/ControllerFactory.php');

//Services Dependents
require_once (BASEPATH . '/core/mvc/service/GenericService.php');
require_once (BASEPATH . '/core/mvc/service/ServiceFactory.php');
require BASEPATH .'/core/mvc/service/ServiceHelper.php';

//DAO Dependents
require_once (BASEPATH . '/core/mvc/dao/GenericDAO.php');
require_once (BASEPATH . '/core/mvc/dao/DAOFactory.php');
require_once (BASEPATH . '/core/mvc/dao/DAOHelper.php');
require_once (BASEPATH . '/core/mvc/dao/BootGridDAO.php');


//Model Interface could add to it in ffor futher additoin of funciton of model
require_once (BASEPATH . '/core/mvc/model/ModelHelper.php');
require_once (BASEPATH . '/core/mvc/model/Base.php');
require_once (BASEPATH . '/core/mvc/model/ModelFactory.php');
require_once (BASEPATH . '/Implement/mvc/helper/model/MapperHelper.php');
require BASEPATH .'/core/mvc/model/ModelMapper.php';



// Atom Pattern View Classes
require_once (BASEPATH . '/Implement/mvc/view/general/atom/Atom.php');
require_once (BASEPATH . '/Implement/mvc/view/general/molecules/molecules.php');
require_once (BASEPATH . '/Implement/mvc/view/general/organism/Organism.php');
require_once (BASEPATH . '/Implement/mvc/view/general/page/page.php');
require_once (BASEPATH . '/Implement/mvc/view/general/View.php'); //??
require_once (BASEPATH . '/Implement/mvc/view/general/GenericView.php');
require_once (BASEPATH . '/Implement/mvc/view/general/TableViewOLD.php');
require_once (BASEPATH . '/Implement/mvc/view/general/table/TableView.php');
require_once (BASEPATH . '/Implement/mvc/view/general/js/ScriptCreator.php');

//Utils to clutter less
require BASEPATH .'/core/mvc/utils/Utils.php';




//Model and View Helper Classes
require BASEPATH .'/core/helper/Helper.php'; // Helper methods like converting arrray to class or removing foregin key from array ...
require_once (BASEPATH . '/Implement/mvc/helper/view/ViewHelper.php');
require_once (BASEPATH . '/Implement/mvc/view/general/GlobalViewHelper.php');

//Main Core Classes for Routing/Debuging/Initiallising
require BASEPATH .'/core/helper/debug.php'; // Contains methods for debuging
require BASEPATH . '/core/plugin/config/variables.php'; //Contains Variables need for database and settings
require BASEPATH .'/core/plugin/router/MainController.php'; // Controller Factory class that Handles REST/ URL (to create right controller)
require BASEPATH . '/core/plugin/activation/Database.php';
require BASEPATH . '/core/plugin/activation/Plugin.php'; // Class that creates DATABASE and tables
require BASEPATH . '/BasicActive.php'; // Bringing all Together
