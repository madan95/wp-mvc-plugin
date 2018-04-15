<?php

$table_unique_id = $table_name.'_table_'.$unique_id; //table name identifior for javascript to add or ermeove child tables

return Organism::createTableProxiesSkeleton(
  $table_name,
  $table_unique_id,
   Molecules::createTableRowScript(
     $table_unique_id,
      Organism::createTrProxyForNode(
        $fields,
        $table_name
      )));
