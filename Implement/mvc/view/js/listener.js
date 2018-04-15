var ajax_url = params.ajaxurl+'?action=custom_ajax';

$(document).ready(function(){
//Listen to ajax_button button for even and fire action written in data-actoin Attributes
  $(document).on('click', 'button.ajax_button', function(e){
    e.preventDefault();
    var ajax_action = $(this).data('action');
    window["thisModule"][ajax_action](this);
  });

  $(document).on('click', 'button.ajax_action', function(e){
    e.preventDefault();
    console.log('ajaxon');
  });

  $(document).on('click', 'button.testBtn', function(e){
    e.preventDefault();
    var ajax_action = $(this).data('action');
    var form_data = window["formModule"][ajax_action](this);
    window['ajaxModule'][ajax_action](this, form_data);

  });

});
