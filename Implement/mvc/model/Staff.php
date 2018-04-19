<?php
class Staff extends Base{

  public function getFullName(){
    $user = get_user_by('id', $this->getValue('user_id'));
    return $user->display_name;
//    $row_array['display_name'] = $user->display_name;
//    return $this->getValue('first_name').' '.$this->getValue('last_name');
  }

  public function getContactNumbers(){
  $number = '';
  if($this->getValue('mobile_number')){
    $number .= '( '.$this->getValue('mobile_number').' )';
  }
  if($this->getValue('phone_number')){
    $number .= '( '.$this->getValue('phone_number').' )';
  }
  return $number;
}


} ?>
