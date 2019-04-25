<?php
/**
 * Created by PhpStorm.
 * User: madan
 * Date: 13/12/2017
 * Time: 11:06
 */
//handle view file loading
class ViewLoader
{
    public function __construct($path)
    {
        $this->path = $path;
    }

    public function load($viewName){
        if(file_exists($this->path.$viewName)){
            return file_get_contents($this->path.$viewName);
        }
        throw new Exception("View does not Exist: ".$this->path.$viewName);
    }
}