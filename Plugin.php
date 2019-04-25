<?php
/**
 * Created by PhpStorm.
 * User: Madan
 * Date: 13/01/2018
 * Time: 9:47 PM
 */
require BASEPATH . '/core/model/Database.php'; //Database to Create Database Tables

class Plugin
{
    public function __construct()
    {
        console(' Plugin Class Constructor Initiated ',__FILE__, '');
    }

    public function createDatabase(){
        $database = new Database();
        $database->createDatabase();
    }


}
