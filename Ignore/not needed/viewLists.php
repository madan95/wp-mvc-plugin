<?php
/**
 * Created by PhpStorm.
 * User: Madan
 * Date: 18/12/2017
 * Time: 3:23 AM
 */

class viewLists
{

    public function __construct() {

    }

    public function outputList($data){
        echo '<table>';
        array_walk($data, 'render');
        echo '</table>';
    }
    public function render(&$item){
        echo('<tr>');
        echo('<td>');
        echo(implode('</td><td>', $item));
        echo('</td>');
        echo('</tr>');
    }
}