<?php

//Create Database and Set Prefix for Table , All settings comes from variable.php
register_activation_hook( PLUGIN_PATH, 'activatePlugin' );

function activatePlugin(){
    $plugin = new Plugin();
    $plugin->createDatabase(new Database());
}

//Add Scripts and CSS Liabaries needed for Plugin
add_action('wp_enqueue_scripts', 'addScriptAndStyle');
function addScriptAndStyle(){

        //Jquery 3.3.1
        wp_enqueue_script('custom-jquery-script', plugins_url('/Implement/mvc/view/js/lib/jquery/jquery.js', __FILE__), array(), null, false);

        //Bootstrap 3.0.0
        wp_enqueue_style('custom-bootstrap-style', plugins_url('/Implement/mvc/view/js/lib/bootstrap/css/bootstrap.css', __FILE__ ), array(), null, 'all');
        wp_enqueue_style('custom-bootstrap-theme-style', plugins_url('/Implement/mvc/view/js/lib/bootstrap/css/bootstrap-theme.css', __FILE__ ), array(), null, 'all');
        wp_enqueue_script('custom-bootstrap-script', plugins_url('/Implement/mvc/view/js/lib/bootstrap/js/bootstrap.js', __FILE__), array(), null, false);

        //BootGrid
        wp_enqueue_style('custom-bootgrid-style', plugins_url('/Implement/mvc/view/js/lib/bootgrid/css/jquery.bootgrid.css', __FILE__ ), array(), null, 'all');
        wp_enqueue_script('custom-bootgrid-script', plugins_url('/Implement/mvc/view/js/lib/bootgrid/js/jquery.bootgrid.js', __FILE__), array(), null, false);

        //Select2
        wp_enqueue_style('custom-select2-style', plugins_url('/Implement/mvc/view/js/lib/select2/css/select2.css', __FILE__ ), array(), null, 'all');
        wp_enqueue_script('custom-select2-script', plugins_url('/Implement/mvc/view/js/lib/select2/js/select2.full.js', __FILE__), array(), null, false);

         //notify
         wp_enqueue_script('custom-notify-script', plugins_url('/Implement/mvc/view/js/lib/notify/notify.min.js', __FILE__), array(), null, false);

         //xeditable
         wp_enqueue_script('custom-moment-script', plugins_url('/Implement/mvc/view/js/lib/xeditable/moment/moment.js', __FILE__), array(), null, false);
         wp_enqueue_script('custom-moment-locals-script', plugins_url('/Implement/mvc/view/js/lib/xeditable/moment/moment-locals.min.js', __FILE__), array(), null, false);
    //     wp_enqueue_style('custom-bootstrap-xeditable-style', plugins_url('/Implement/mvc/view/js/lib/xeditable/css/bootstrap-editable.css', __FILE__ ), array(), null, 'all');
    //     wp_enqueue_script('custom-bootstrap-xeditable-script', plugins_url('/Implement/mvc/view/js/lib/xeditable/js/bootstrap-editable.js', __FILE__), array(), null, false);
         wp_enqueue_script('custom-jquery-poshy-script', plugins_url('/Implement/mvc/view/js/lib/xeditable/poshytip/jquery.poshytip.min.js', __FILE__), array(), null, false);
         wp_enqueue_style('custom-jquery-xeditable-style', plugins_url('/Implement/mvc/view/js/lib/xeditable/css/jquery-editable.css', __FILE__ ), array(), null, 'all');
         wp_enqueue_script('custom-jquery-xeditable-script', plugins_url('/Implement/mvc/view/js/lib/xeditable/js/jquery-editable-poshytip.js', __FILE__), array(), null, false);
         wp_enqueue_style('custom-jqueryui-xeditable-datepicker-style', plugins_url('/Implement/mvc/view/js/lib/xeditable/jquery-ui-datepicker/css/redmond/jquery-ui-1.10.3.custom.css', __FILE__ ), array(), null, 'all');
         wp_enqueue_script('custom-jqueryui-xeditable-datepicker-script', plugins_url('/Implement/mvc/view/js/lib/xeditable/jquery-ui-datepicker/js/jquery-ui-1.10.3.custom.min.js', __FILE__), array(), null, false);

        // CUSOTOMS scripts and css files
         wp_enqueue_style('custom-style', plugins_url('/Implement/mvc/view/css/style.css', __FILE__ ), array(), null, 'all');
         wp_enqueue_script('custom-formModule-script', plugins_url('/Implement/mvc/view/js/formModule.js', __FILE__), array(), null, false);
         wp_enqueue_script('custom-ajax odule-script', plugins_url('/Implement/mvc/view/js/ajaxModule.js', __FILE__), array(), null, false);
         wp_enqueue_script('custom-global-script', plugins_url('/Implement/mvc/view/js/global.js', __FILE__), array(), null, false);
         wp_enqueue_script('custom-newglobal-script', plugins_url('/Implement/mvc/view/js/newGlobal.js', __FILE__), array(), null, false);
         wp_enqueue_script('custom-table-script', plugins_url('/Implement/mvc/view/js/tableRow.js', __FILE__), array(), null, false);
         wp_enqueue_script('custom-script', plugins_url('/Implement/mvc/view/js/listener.js', __FILE__), array(), null, false);
         wp_enqueue_script('custom-view-script', plugins_url('/Implement/mvc/view/js/viewTemplate.js', __FILE__), array(), null, false);


         //set wordpress ajax url in javascript global
         $params = array ( 'ajaxurl' => admin_url( 'admin-ajax.php' ) );
         wp_localize_script( 'custom-script',  'params', $params);
    }

//Ajax, Action, ShortCode Listener
$mainController = new MainController();


?>
