<?php
//@Needs Fields Variable
//@Needs Table Name

return Molecules::createFieldset(
  Organism::createInputField($fields),
  ViewHelper::createElementExtra(array(
    'data-field_type' => 'single',
    'data-table_name' =>  $table_name
  )),
  $table_name);

 ?>
