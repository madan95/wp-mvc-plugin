<?php
/**
 * Created by PhpStorm.
 * User: madan
 * Date: 06/12/2017
 * Time: 17:17
 */

function pcajob_menu(){
    $menuPage = add_menu_page('PCA-JOB-TITLE', 'PCA JOB MENU', 'manage_options', 'pcajob_menu', 'pcajob_menu_page' );
    add_submenu_page('pcajob_menu', 'PCA JOB Manage Page Title', 'PCA JOB Manage Menu Title', 'manage_options', 'pcajob_manage', 'pcajob_submenupage');
}

function pcajob_menu_page(){
    require_once(PCAJOB_PATH.'/view/adminmenu.php');
}

function pcajob_submenupage(){
    require_once(PCAJOB_PATH.'/view/adminsubmenu.php');

}

function pcajob_scripts(){
    wp_register_style('pcajob-css', plugins_url('pca_job/view/css/style.css'));
    wp_enqueue_style('pcajob-css');

    wp_enqueue_script('jquery');
    wp_enqueue_script('pcajob-script', plugin_dir_url('pca_job/view/js/js.js'));

}