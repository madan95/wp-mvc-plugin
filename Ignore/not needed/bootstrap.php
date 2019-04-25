<?php
/**
 * Created by PhpStorm.
 * User: madan
 * Date: 13/12/2017
 * Time: 11:14
 */

require('config.php');
require('core/helper/autoload.php');

$autoloader = new Autoload();

spl_autoload_register([$autoloader, 'load']);

try {
    $autoloader->register('viewloader', function () {
        return require(BASEPATH . '/core/view/viewLoader.php');
    });
} catch (Exception $e) {
}

$view = new View(new ViewLoader(BASEPATH.'/view/'));
$router = new Router();