<?php
/**
 * Created by PhpStorm.
 * User: Madan
 * Date: 18/12/2017
 * Time: 3:01 AM
 */

class Helper
{
    public function isLoggedIn(){
        //If user is not logged in, return false
        if( current_user_can('editor') || current_user_can('administrator')){
        }else{
            echo '<h1> Not Admin, Login as Admin to Access the Page';
            return false;
        }
    }

}