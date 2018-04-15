<?php

class Organism{


  function createModalTable($data){
    ?>
    <!-- Modal -->
    <div class="modal fade" id="modal-id-<?php echo $data['unique_id'] ?>"  role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body modal-body-<?php echo $data['unique_id'] ?>">

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary modal-close-<?php echo $data['unique_id'] ?>" >Close</button>
          </div>
        </div>
      </div>
    </div>
    <?php
  }
}
