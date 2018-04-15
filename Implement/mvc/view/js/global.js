var thisModule = {};

$(document).ready(function(){

//To avoid over population in global namesapce use thisModule to expose the function names
  $(function(){


    $(document).on('click', 'button.button-bootgrid-action', function(e){
      e.preventDefault();
  /*    var parent_table_name = $(this).data('parent-table-name');
      var parent_id = $(this).data('parent-id');
      var table_name = $(this).data('table_name');
      var id = $(this).data('id');
      var ajax_action = $(this).data('ajax_action');
      console.log($(this).data());
  */    
      var data_to_send = {json_data: JSON.stringify(
        $(this).data()
      )};

      $.post(ajax_url, data_to_send, function(returnData){
        $('.table').bootgrid('reload');
        $.notify('Item Created Sucessfully',  {className: 'success', globalPosition: 'bottom right'});
      }).fail(function(returnData){
        $.notify('Server Failed to Respond, Sorry your action wasn\'t Completed', {className: 'error', globalPosition: 'bottom right'});
      });
    });




    var addExisting = function(element){
      console.log('Add Existing Function Called');
      registerNode(element, 'addExisting');
    };
    var addNewNode = function(element){
      console.log('Add New Node Function Called');
      registerNode(element, 'addNewNode');
    };
    var save = function(element){
      console.log('Save Function Called');
      registerNode(element, 'save');
    };
    var remove = function(element){
      console.log('Remove Function Called');
      $(element).parent().parent().find('button').show();
      $(element).parent().parent().find('script').remove();
      $(element).parent().remove();
    };
    thisModule.addExisting = addExisting;
    thisModule.addNewNode = addNewNode;
    thisModule.save = save;
    thisModule.remove = remove;
  });




function registerNode(element, functionName){
      var data_to_send = {};
      var json_data = {};
      switch (functionName) {
        case 'save':
        data_to_send = {json_data: getFieldSetData(element)}
          break;
        case  'addNewNode':
        data_to_send = {json_data:  JSON.stringify({
           'table_name': $(element).data('table_name'),
           'ajax_action': $(element).data('action'),
           'is_node': $(element).data('is_node'),
           'isNode': true
         })};
          break;
        case 'addExisting':
        data_to_send = {json_data: JSON.stringify({
           'table_name': $(element).data('table_name'),
           'ajax_action': $(element).data('action'),
           'is_node': $(element).data('is_node'),
           'isNode': true
         })};
          break;
        default:
      }
      console.log(functionName + ' Function Called, Data To Send Created According to Funciton Name : ' + data_to_send);

      //Make ajax Call to the server with data according to the method/data-action used
      $.post(ajax_url, data_to_send, function(returnData){
        console.log('Sucessfull Ajax Add New Node : ' + returnData);
        var returnObj = JSON.parse(returnData);

        switch (functionName) {
          case 'save':
          $(element).parent().after(returnObj.body);
          $(element).parent().remove();
            break;
          case  'addNewNode':
          $(element).parent().append(returnObj.body);
          $(element).parent().children('button').hide();
            break;
          case 'addExisting':
          $(element).parent().append(returnObj.body);
          $(element).parent().children('button').hide();
            break;
          default:
          $(element).parent().append(returnObj.body);
          $(element).parent().children('button').hide();
        }
      }).fail(function(returnData){
        console.log('Faield Ajax Add New Node : ' + returnData);
      });
    }


    function recursiveFindTableInputFields(element){
      console.log('first method ran');
      var input_fields;
      var form = $(element).parent().parent(),
          fieldset = form.find('fieldset');
          $(fieldset).each(function(){
            input_fields = $(this).find('> .input-fields');
            var main_data;
            $(input_fields).each(function(){
              main_data = findRecursively(input_fields);
              console.log(main_data);
              var json_data = JSON.stringify(main_data);
              console.log(json_data);
            });
          });
    }

    function findRecursively(input_fields){
      var input_field;
  //    var main_data = {};
      var data= {};
      var temp= {};
      var table_name = '';
    //  main_data = [];

  //    $(input_fields).each(function(){
        table_name = $(input_fields).data('table');
        data[table_name] = [];
          $(input_fields).find('>div').each(function(){
            temp = {};
            $(this).find('>input, select, textarea').each(function(){
              temp[this.name] = this.value;
           });
            input_field = $(this).find('>.input-fields');
            if($(input_field).length){
              $(input_field).each(function(){
                temp[$(this).data('table')]=findRecursively(this);
              });
            }
            data[table_name].push(temp);
          });
    //    main_data[table_name] = [];
  //      main_data[table_name].push(data[table_name]);
  //    });
      return data[table_name];
    }




    //Get the data from fieldset when clicked save , deep loop
      function getFieldSetData(element){
        var
          form = $(element).parent(),
          fieldset = form.find('fieldset');
            var data= {};
            var temp={};
            var table_name = '';
            $(fieldset).each(function(){
              if($(this).data('field_type')==='single'){
                table_name = $(this).data('table_name');
                temp = {};
                data[table_name] = [];
                $(this).find('input, select, textarea').each(function(){
                  temp[this.name] = this.value;
                                });
                data[table_name].push(temp);
              }else if($(this).data('field_type')==='many'){
                table_name = $(this).data('table_name');
                data[table_name] = [];
                $(this).find('.table_body_proxy>.tr_proxy').each(function(){
                  temp = {};
                  $(this).find('input,select,textarea').each(function(){
                    temp[this.name] = this.value;
                  });
                  data[table_name].push(temp);
                });
              }
            });

            data.ajax_action = $(element).data('action');
            data.table_name = $(element).data('table_name');
            data.isNode = $(element).data('is_node');
            data.callerFunction = 'save';

            console.log(data);
            var json_data = JSON.stringify(data);
            console.log(JSON.stringify(data));
            var object_data = JSON.parse(json_data);
            console.log(object_data);
            return json_data;
      }







});
