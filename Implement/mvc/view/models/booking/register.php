<?php

 ?>
 <button
 type="button"
 class="button-bootgrid-action"
 data-ajax-action="createNew"
 data-table-name="booking"
  > Create New Booking </button>
<script>
$(document).ready(function(){
   $(function(){
     $(document).on('click', 'button.button-bootgrid-action', function(e){
       e.preventDefault();
       console.log('Clicked');
     });
   });
 });
</script>
