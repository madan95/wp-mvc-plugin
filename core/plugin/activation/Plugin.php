<?php
/**
 * Created by PhpStorm.
 * User: Madan
 * Date: 13/01/2018
 * Time: 9:47 PM
 */

class Plugin
{
  private $database;

    public function __construct()
    {
        console(' Plugin Class Constructor Initiated ',__FILE__, '');
    }

    public function createDatabase(Database $database){
      $this->database = $database;
      $this->database->createDatabase();
      }


}
