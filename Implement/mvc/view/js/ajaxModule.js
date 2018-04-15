var ajaxModule = {};

$(document).ready(function(){
  $(function(){
    var save = function(element, form_data){
      console.log('Save function ran from ajax Module');
      sendAjaxData(createDataToSend(form_data, getDataFromElement(element)));
    };
    ajaxModule.save = save;
  });

  function getDataFromElement(element){
    var element_data = {};
    element_data['ajax_action'] = $(element).data('action');
    element_data['table_name'] = $(element).data('table_name');
    element_data['isNode'] = $(element).data('is_node');
    return element_data;
  }

  function createDataToSend(form_data, extra){
      $.extend(form_data, extra);
      var json_data = JSON.stringify(form_data);
      var data_to_send = {json_data : json_data};
      return data_to_send;
  }

  function sendAjaxData(data_to_send){
    console.log(data_to_send);
    $.post(ajax_url, data_to_send, function(returnData){
      console.log('Sucessfull Ajax Add New Node : ' + returnData + ' ajaxurl :: ' + ajax_url);
      var returnObj = JSON.parse(returnData);
    }).fail(function(returnData){
      console.log('Faield Ajax Add New Node : ' + returnData);
    });
  }
});
