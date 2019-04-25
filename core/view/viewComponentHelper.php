<?php
function componentModalBox($data){

          $type_data = [];
          $type_action = ['add', 'edit', 'view', 'detail'];
          foreach($type_action as $action){
            $modal_header_title = $action.' '.$data['table_name_human_readable'];
              $type_data['modal_header'] = createModalBoxHeader($modal_header_title);
              $type_data['type_action'] = $action;
              $type_data['modal_box_id'] = $action.'_model_'.$data['unique_id'];
              echo createModalBox($data, $type_data);
          }
}

function componentListBody($data){
      echo createClearFix($data);
      echo createDownloadBtn($data);
      echo createBootGridTable($data);
}

?>
