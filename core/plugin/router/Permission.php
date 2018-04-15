<?php
class Permission{


      //Check if current user has capability
      static function hasCapabilities($action_name, $request){
          if(isset($request['table_name'])){
              if(!current_user_can($this->actionToCapability($action_name, $request))){
                  return false;
              }else{
                  return true;
              }
          }else{
              //if no table used, no permission required
              $this->actionToCapability($action_name, $request);
              return true;
          }
      }

      //Convert Action Name To Wordpress Capability Action Name + Table Name
      static function actionToCapability($action_name, $request){
          require CAPABILITIES_SETTINGS;
          $capability_action_name = $action_to_capability[$action_name];
          $table_name = "";
          $capability = "";
          if(isset($request['table_name']) && $capability_action_name){ // if both action name and table name present
              $table_name = str_replace(TABLE_PREFIX ,"" ,$request['table_name']);
              $capability = $capability_action_name.'_'.$table_name;
          }elseif($capability_action_name){ // if only action name is present
              $capability = $capability_action_name;
          }else{
              $capability = $action_name.$table_name;
          }
          return $capability;
      }


 ?>
