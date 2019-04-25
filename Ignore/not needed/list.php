<?php
/**
 * Created by PhpStorm.
 * User: madan
 * Date: 20/12/2017
 * Time: 13:36
 */

?>
<table>
    <thead>
        <?php
        foreach ($columns as $name => $type) {
            echo '<th>'.$name.'</th>';
        }
        ?>
    </thead>
<tbody>
<?php
$primary_key_value = 0;
foreach($result as $row){
    echo '<tr>';
    foreach ($row as $k => $v){
        if($k == $primary_key){
            $primary_key_value = $v;
        }
        echo '<td>'.  $v . '</td>';
    }
    //echo '<td><a href="?action=delete&table='.$table_name.'&id='.$primary_key_value.'">Delete</a></td>';
    echo '<td><a href="?action=edit&table='.$table_name.'&id='.$primary_key_value.'">Edit</a></td>';
    echo '<tr>';
}
?>
</tbody>
</table>
