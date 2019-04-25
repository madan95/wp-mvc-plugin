<?php
/**
 * Created by PhpStorm.
 * User: madan
 * Date: 13/12/2017
 * Time: 17:18
 */


class MainController
{
    private $controller;

    function __construct()
    {
      $this->add_wordpress_action_hooks();
      $this->controller = new controller();
    }

    /*********************************************************************WP-HOOKS (ShortCode / Ajax Listener)*************************************************************************************/

    public function add_wordpress_action_hooks(){
        add_action('wp_ajax_custom_ajax', array($this,'listen_ajax'));
        add_shortcode(SHORT_CODE_NAME, array($this, 'pageView'));
        add_action('admin_post_custom_action', array($this, 'custom_action'));
    }

    public function custom_action(){
        ob_clean();
        $request = $this->setRequest();
        console($request['ajax_action']);
        if(isset($request['ajax_action'])) {
            $action = $request['ajax_action'];
            $this->executeFunctionIfPermits($action, $request);
        }else if(isset($request['json_data'])){
          console('JSON Custom Action');
          $request_data = json_decode(stripslashes($request['json_data']), TRUE);
          $this->executeFunctionIfPermits($request_data['ajax_action'], $request);
        }
    }

    public function listen_ajax(){ //ajax listener
      ob_clean();
      console('Listen Ajax');
        $request = $this->setRequest();
        if(isset($request['ajax_action'])) {
            $action = $request['ajax_action'];
            $this->executeFunctionIfPermits($action, $request);
        }else if(isset($request['json_data'])){
          console('pp');
          console($request['json_data']);
          console(stripslashes($request['json_data']));
          console(json_decode(stripslashes($request['json_data'])));
          console(json_decode(stripslashes($request['json_data']), TRUE));

          $request_data = json_decode(stripslashes($request['json_data']), TRUE);
          $this->executeFunctionIfPermits($request_data['ajax_action'], $request_data);
        }
        wp_die();
    }



    public function pageView($attr){
            $attr = shortcode_atts(array('page' => 'location', 'action' => 'lists'), $attr); //default values
            $pageType = $attr['page']; // What page like 'location', 'task' ? has to be same as view name
            $action = $attr['action']; // What is inside the page of 'location '  ??? list , graph ??
            switch ($action) {
                case 'lists':
                    $request['table_name'] = TABLE_PREFIX . $pageType;
                    $this->executeFunctionIfPermits($action, $request);
                   break;
                case 'graph':
                    break;
                default:
                    return '<h1>Default page : ' . $pageType . ' </h1>';
                    break;
            }
    }



    public function setRequest(){
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        console('POST - METHOD USED');
        return $_POST;
      }else if($_SERVER['REQUEST_METHOD'] == 'GET'){
        console('GET - METHOD USED');
        return $_GET;
      }
    }












    /******************************************************************************* Roles And Capabilities (Action/Permission/User) *******************************************************************************/

    //use action name to execute the controller function
    public function executeFunctionIfPermits($action, $request){
       // if($this->hasCapabilities($action, $request)){  //capability === action function name
       if(!is_user_logged_in()){return false;}
            $this->controller->{$action}($request);
        //}else{
         //   echo 'You Do Not Have Capabilities : '.$this->actionToCapability($action, $request).'<br>';
        //}
    }

    //Check if current user has capability
    public function hasCapabilities($action_name, $request){
        if(isset($request['table_name'])){
            if(!current_user_can($this->actionToCapability($action_name, $request))){
                return false;
            }else{
                return true;
            }
        }else{
            //if no table used, no permission required
            $this->actionToCapability($action_name, $request);
            return true;
        }
    }

    //Convert Action Name To Wordpress Capability Action Name + Table Name
    public function actionToCapability($action_name, $request){
        require CAPABILITIES_SETTINGS;
        $capability_action_name = $action_to_capability[$action_name];
        $table_name = "";
        $capability = "";
        if(isset($request['table_name']) && $capability_action_name){ // if both action name and table name present
            $table_name = str_replace(TABLE_PREFIX ,"" ,$request['table_name']);
            $capability = $capability_action_name.'_'.$table_name;
        }elseif($capability_action_name){ // if only action name is present
            $capability = $capability_action_name;
        }else{
            $capability = $action_name.$table_name;
        }
        return $capability;
    }

    /**************************************************************************************************************************************************************************************************************/

}
