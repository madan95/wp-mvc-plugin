<?php
class BootStrapWrapperView{


public static function bootstrapWrapper($data){
  ?>
  <div class='container-fluid'>
    <div class='row'>
      <div class='<?php echo $data['colClass'] ?>'>
        <?php echo $data['body'] ?>
      </div><!-- Col-md-* -->
    </div><!-- Row -->
  </div><!-- Container-Fluid -->
  <?php
}

}?>
