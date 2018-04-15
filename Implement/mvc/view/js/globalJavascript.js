$(document).on('click', 'button.button-bootgrid-action', function(e){
  e.preventDefault();
  var table_name = $(this).data('table_name');
  var ajax_action = $(this).data('ajax_action');
  var data_to_send = {json_data: JSON.stringify({
    'table_name': table_name,
    'ajax_action': ajax_action
  })};
  $.post(ajax_url, data_to_send, function(returnData){
    $('table').bootgrid('reload');
    $.notify('Item Created Sucessfully',  {className: 'success', globalPosition: 'bottom right'});
  }).fail(function(returnData){
    $.notify('Server Failed to Respond, Sorry your action wasn\'t Completed', {className: 'error', globalPosition: 'bottom right'});
  });
});
