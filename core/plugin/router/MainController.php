      <?php
/**
 * Created by PhpStorm.
 * User: madan
 * Date: 13/12/2017
 * Time: 17:18
 */


class MainController
{
    function __construct(){
      $this->add_wordpress_action_hooks();
    }

    /*********************************************************************WP-HOOKS (ShortCode / Ajax Listener)*************************************************************************************/

    // add hooks to listen for ajax / admin post call or short-code
    public function add_wordpress_action_hooks(){
        add_action('wp_ajax_custom_ajax', array($this,'listen_ajax'));
        add_shortcode(SHORT_CODE_NAME, array($this, 'pageView'));
        add_action('admin_post_custom_action', array($this, 'custom_action'));
    }

    //custom admin post call directed to useMVC Function
    public function custom_action(){
        ob_clean();
        $this->useMVC('post');
    }

    //ajax Listener call directed to useMVC Function
    public function listen_ajax(){ //ajax listener
        ob_clean();
          $this->useMVC('ajax');
        wp_die();
    }

    // handel both custom post and ajax request from user
    public function useMVC($type_listen){
      $request_data = Helper::getRequestData(Helper::setRequest());
      $request_data['isAjax'] = ($type_listen == 'ajax' ? true : false);
      $action = isset($request_data['ajax_action']) ? $request_data['ajax_action'] : 'index' ;
      $this->executeFunctionIfPermits($action, $request_data);
    }

    //Handles all shortscode with any extra attribute pased as a array to be used by controllers/action/services
    public function pageView($request_data){
      if (!empty( $_GET ) || !empty($_POST)) {
        //use the url params to craete page
        if($request_data['listen_url']){
          // make sure only one of the short code is actually listening to url ortherwise multiple controller will handle single request ( [view_page listen_url=true] )
          $this->useMVC('post');
        }
      }else{
        //use shortcode params if the url doesn't have any parameters
        $action = isset($request_data['ajax_action']) ? $request_data['ajax_action'] : 'index' ;
        $this->executeFunctionIfPermits($action, $request_data);
      }
    }


    /******************************************************************************* Roles And Capabilities (Action/Permission/User) *******************************************************************************/

    //use the action and request['table_name'] to find appropriate Controller and method to run
    public function executeFunctionIfPermits($action, $request){
       if(!is_user_logged_in() || empty($request['table_name'])){return false;}
       $controller_name = Helper::convertToPascalCase(Helper::removeTablePrefix($request['table_name']));
       $controller = ControllerFactory::createController($controller_name);
       $request['unique_id'] = uniqid();
       if($controller){
         $controller->{$action}($request);
       }else{
         echo 'Sorry That Controller Name Not Found ';
      }
    }


}
