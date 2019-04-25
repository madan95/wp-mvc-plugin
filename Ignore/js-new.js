jQuery(document).ready(function($){

    var ajax_url = params.ajaxurl+'?action=custom_ajax';
    function ajaxPCA(element) {
      var ajax_action = $(element).attr('name');
      var dataToSend = $(element).parent().serializeArray(); //serializes the form input value
      dataToSend.push({name: 'ajax_action', value: ajax_action}); //what action on server using name attr of button
    //  var dataToSend = { id: "1", type: "regular" };
    //  console.log(JSON.stringify(dataToSend));
    //  dataToSend.push({name: 'extra_tables', value : ok});

      //dataToSend = JSON.stringify(dataToSend);
      //  $.post(ajax_url, dataToSend,  function (returnData) {
        //  $.listening(returnData);
        //  $(element).after(returnData);
      //      console.log(returnData);
        //    console.log(returnData['action']);
/*
           $(element).after(returnData);
            console.log('AJAX SEND');
            var primary_key_id = "";
            var primary_key_name = "";
            if($("input[id=primarykey]")){
                primary_key_id = $(element).parent().parent().find("input[id=primarykey]").val();
                primary_key_name = $(element).parent().parent().find("input[id=primarykey]").attr('name');
                console.log('key_id : '+primary_key_id);
                console.log('key_name : '+primary_key_name);
            }
            $(element).parent().parent().parent().parent().find('form input[id][name$='+primary_key_name+']').val(primary_key_id);
*/

//}, 'json' ).fail(function (data) {
    //            $('div#result').html(returnData);        //error failed in php message (need to be removed on live)
    //    });
    $.ajax({
      url: ajax_url,
    //  dataType: 'json',
      type: 'post',
      data: dataToSend,
      success: function(data, textStatus, jQxhr){
         $(element).after(returnData);
      console.log(data);
      },
    error: function(jqXhr, textStatus, errorThrown){
        console.log(errorThrown);
      }
    });

    }


    $(document).on('click', '.ajaxBtn', function(){
       ajaxPCA(this);
    });





























    jQuery.listening = function listening_ajax(returnData){
      console.log('Listening to Evertything');
      var returned = JSON.parse(returnData);
      var main_form =[];
      var relate_form = [];
      console.log(returned);
      console.log(returned.main_table);

      $.each(returned, function(id, value){
        if(id == 'main_table'){
          $.each(value, function(id, value){
            main_form.push(value);
          })
        }else if(id == 'relate'){
          relate_form.push(value);
        }
        console.log('id : '+ id);
        console.log('value : '+ value);
      });
      console.log('MAIN TABLE NAME ' + returned.table_name);
      console.log(main_form);
      console.log(relate_form);
      create_form_json_data(main_form, returned.table_name);
    };


      function create_form_label_and_input(form_schema, formFragment){
        var label =  document.createElement('label');
        $(label).attr({'for': form_schema.field_name}).text(form_schema.label);

        var input_field =  document.createElement('input');
        $(input_field).attr({'type': form_schema.type, 'id': form_schema.field_name, 'name': form_schema.field_name, 'value': form_schema.value});


          formFragment.append(label);
          formFragment.append(input_field);
          formFragment.append(document.createElement('br'));
        }

      function create_node_buttons(form_schema, formFragment){

      }


    function create_form_json_data(main_form, main_table_name){
      var formFragment = document.createDocumentFragment();
      $.each(main_form, function(id, value){
        console.log('Using Object to get Name : '+ value.field_name);

          create_form_label_and_input(value, formFragment);

      });

      var submit_table = document.createElement('input');
      $(submit_table).attr({'type': 'hidden', 'name': 'table', 'value': main_table_name});
      var submit_table3 = document.createElement('input');
      $(submit_table3).attr({'type': 'hidden', 'name': 'extra_table', 'value': 'pca_peach_customer'});
      var submit_table4 = document.createElement('input');
      $(submit_table4).attr({'type': 'hidden', 'name': 'extra_table', 'value': 'pca_peach_task'});
      var submit_table2 = document.createElement('input');
      $(submit_table2).attr({'id': 'ajaxBtn', 'class': 'ajaxBtn', 'type': 'button', 'name': 'ajax_insert', 'value': 'Save New '+main_table_name});

      formFragment.append(submit_table);
      formFragment.append(submit_table2);
      formFragment.append(submit_table3);

      var add_form = $('<div />').append(
        $('<form />').attr({'action': '#'}).append(
            formFragment
        ));

      $('.modal.fade.in .modal-body').prepend(
        $(add_form)
      );
    }


















    function convert_object_to_array(Obj){
      var array = $.map(Obj, function(value, index){
        return {[index]: value};
      });
      return array;
    }


    function update_primary_key_id_name(element){
        var primary_key_id = "";
        var primary_key_name = "";
        if($("input[id=primarykey]")){
            primary_key_id = $(element).parent().parent().find("input[id=primarykey]").val();
            primary_key_name = $(element).parent().parent().find("input[id=primarykey]").attr('name');
            console.log('key_id : '+primary_key_id);
            console.log('key_name : '+primary_key_name);
        }
        $(element).parent().parent().parent().find('form input[id][name$='+primary_key_name+']').val(primary_key_id);
    }

});
