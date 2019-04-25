<?php
/**
 * Created by PhpStorm.
 * User: madan
 * Date: 13/12/2017
 * Time: 10:31
 */
// Automate the require statements to load files in script (autoloading)
class autoload
{
    private $autoloadable = [];

    public function register($name, $loader = false){
    if(is_callable($loader)||$loader == false){
        $this->autoloadable[$name] = $loader;
        return;
    }
    throw new Exception('Loader must be callable '.$name);
    }

    public function load($name){
        $name = strtolower($name);
        $filepath = BASEPATH. '/core/'.$name.'/'.$name.'.php';
        if(!empty($this->autoloadable[$name])){
            return $this->autoloadable[$name]($name);
        }
        if(file_exists($filepath)){
            return require ($filepath);
        }
        throw new Exception($name . ' is not loaded or registed for autoloading');
    }


}