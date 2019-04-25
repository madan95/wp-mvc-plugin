<?php
/**
 * Created by PhpStorm.
 * User: madan
 * Date: 13/12/2017
 * Time: 11:04
 */
//used publicly for view loading
class View
{
    public function __construct($viewLoader)
    {
        $this->viewLoader = $viewLoader;
    }

    public function display($viewName){
        echo $this->viewLoader->load($viewName);
    }
}