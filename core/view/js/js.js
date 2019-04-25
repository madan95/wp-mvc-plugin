
 jQuery(document).ready(function($){

    var ajax_url = params.ajaxurl+'?action=custom_ajax';

    function ajaxPCA(element) {
      var ajax_action = $(element).attr('name');
      update_primary_key_id_name(element);
      var dataToSend = $(element).parent().serializeArray(); //serializes the form input value
      dataToSend.push({name: 'ajax_action', value: ajax_action}); //what action on server using name attr of button
      var extra = {
        color: ['read', 'blue']
      };
      dataToSend.push({name: 'extra_tables', value : {'batter' : [{'id': '1', 'type':'regular'},{'id':'2', 'type':'magic'}]}});
        $.post(ajax_url, dataToSend, function (returnData) {
           $(element).after(returnData);

           update_primary_key_id_name(element);

        }).fail(function (data) {
                $('div#result').html(returnData);        //error failed in php message (need to be removed on live)
        });
    }


        function ajaxPCA2(element) {
          var ajax_action = $(element).attr('name');
          var table_name = $(element).data('table-name');
          var array_test = {ab: '1', cd: '2', ef: '4'};
          var dataToSend = {
            'table_name': table_name,
            'ajax_action': ajax_action,
            'array_test': array_test
          }
            $.post(ajax_url, dataToSend, function (returnData) {
               $(element).after(returnData);

            }).fail(function (data) {
                    $('div#result').html(returnData);        //error failed in php message (need to be removed on live)
            });
        }

    function update_primary_key_id_name(element){
        var primary_key_id = "";
        var primary_key_name = "";
        if($("input[id=primarykey]")){
            primary_key_id = $(element).parent().parent().find("input[id=primarykey]").val();
            primary_key_name = $(element).parent().parent().find("input[id=primarykey]").attr('name');
         }
        $(element).parent().parent().parent().find('form input[id][name$='+primary_key_name+']').val(primary_key_id);
        $('.modal-body').find('form input[id][name$='+primary_key_name+']').val(primary_key_id);
    }

    $(document).on('click', '.ajaxBtn', function(){
       ajaxPCA(this);
    });


        $(document).on('click', '.ajaxBtn2', function(){
           ajaxPCA2(this);
        });


/*
     function openCity(evt, cityName, uniqueID) {
         console.log('OPEN CITY ranN');
         var evt =
         var i, tabcontent, tablinks;
         tabcontent = document.getElementsByClassName("tabcontent-"+uniqueID);
         for (i = 0; i < tabcontent.length; i++) {
             tabcontent[i].style.display = "none";
         }
         tablinks = document.getElementsByClassName("tablinks-"+uniqueID);
         for (i = 0; i < tablinks.length; i++) {
             tablinks[i].className = tablinks[i].className.replace(" active", "");
         }
         if(cityName == 'addNewTab'){
             var newTabContent = tabcontent.length +1 ;
             $.addNewTab(evt, cityName, uniqueID, newTabContent);
         }else {
             document.getElementById(cityName).style.display = "block";
             evt.currentTarget.className += " active";
         }
     }*/

     // Get the element with id="defaultOpen" and click on it
       //document.getElementsByClassName("tabStart").click();

        $(document).on('click', '.tablinks', function () {
            console.log('.tablinks on click');
            openTab(this);
        });

        function openTab(evt) {
            console.log('openTab()');

            var evt = evt;
            var cityName = $(evt).data('tabcontentname');
            console.log(cityName);
            var uniqueID = $(evt).data('uniqueid');
            var i;
            var tabcontent = $('.tabcontent-'+uniqueID);
            var tablinks = $('.tablinks-'+uniqueID);

            $( tabcontent).each(function() {
                $( this ).css('display', 'none');
            });
            $( tablinks).each(function() {
                $( this ).removeClass('active');
            });
            if(cityName == 'addNewTab'){
                console.log('if city name = addNewTAB');
                var newTabContent = tabcontent.length ;
                $.addNewTab(evt, cityName, uniqueID, newTabContent);
                // make a ajax call to server to get new form field with unique
            }else{
                console.log('if city name != addNewTab');
                $('#'+cityName).css('display', 'block');
                console.log(cityName);
                $(evt).addClass(' active');
            }
        }

        jQuery.addNewTab = function (evt, cityName, uniqueID,  newTab) {
            console.log('addNewTab Running');
            console.log(cityName + uniqueID + newTab);
            $('#0-tabcontent-id-'+uniqueID).clone().appendTo('#tabHolder-'+uniqueID).attr({'id': newTab+'-tabcontent-id-'+uniqueID}).css('display', 'block').find("input").val("");
            $('#'+newTab+'-tabcontent-id-'+uniqueID).addClass('unique-tab');
            $('#'+newTab+'-tabcontent-id-'+uniqueID+'>.table_inputs').addClass('send-json');
            $('#tablinksAdd-'+uniqueID).before($('<button class="tablinks tablinks-'+uniqueID+' active" data-tabcontentname="'+newTab+'-tabcontent-id-'+uniqueID+'"  data-uniqueid="'+uniqueID+'">'+newTab+'</button>'));
          //  $('.tab').after('<div id="'+newTab+'" class="tabcontent" style="display: block;"><h3>Hello</h3></h3> </div> ');

        }


        function createForm(evt){
          var json_data = JSON.stringify($(evt).data('json_data'));

          var dataToSend = {json_data: json_data};
          if($(evt).data('action') == 'new'){
            $.post(ajax_url, dataToSend, function (returnData) {
              console.log('Ajax Inter Action Returned Data :: ' + returnData);
            //  var jsonObj = JSON.parse(returnData);
          //    $(evt).parent('div').find('.formform').append(jsonObj.body);
            //  $(evt).parent('div').find('.formform').append(returnData);
            $(evt).parent('div').find('.addExisting , .createForm').hide();

            $(evt).parent('div').append(returnData);
              console.log(returnData);
             //  console.log(jsonObj.body);

            }).fail(function (returnData) {
              console.log('createForm Failed');
            });
          }else if($(evt).data('action')=='existing'){
            $.post(ajax_url, dataToSend, function (returnData) {
              $(evt).parent('div').append(returnData);
                console.log(returnData);
            }).fail(function (returnData) {
              console.log('createForm Failed');
            });
          }
        }


        // tables = table1 (fields )
          // Tables =  [               { table_name1 , table_fields [{1 ,2 }] },                       { table_name2, table_fields [ {1, 2, 3},  {1, 2, 3}, {1, 2, 3} ] }                      ]
          // Tables =  [               { table_name1 , table_fields [{1 ,2 }] },                       { table_name2, table_fields [ {1, 2, 3},  {1, 2, 3}, {1, 2, 3} ] }                      ]

          /*
            json_data = {
                  'ajax_action' = 'action_name',
                  'tables' = [
                  {
                  'table_name' = 'customer',
                    'table_fields' = [{
                        'customer_name' = 'madan'
                  }]
                },
                {
                  'table_name' = 'client'
                  'table_fields' = [{
                  'clienbt_name' = 'layfon',
                  'client_last_name' = 'woflstien'
                },
              {
              'client_name' = 'json',
              'client_last_name' = 'jayjay'
            }]
              }
                ]
          }




          */


        function testVariables(evt){
          console.log('Test Variables Function Ran');
          var json_data = {};
          var table = {};
          var tables = {};
          var table_name = "";
          var innerMap = {};
          var map = [];

          if($(evt).data('ajax_action') == 'ajax_saver'){
          $(evt).parent('div').find('.table_inputs.send-json').each(function(){
            innerMap = {};
           if(table_name == $(this).data('table_name')){
           }else{
             map = [];
             table_name = $(this).data('table_name');
             table[table_name] = {};
             table[table_name]['relation_type'] = $(this).data('relation_type');
           }
           $(this).children('input').each(function(){
              innerMap[$(this).attr('name')] = $(this).val();
           });
           map.push(innerMap);
           table[table_name]['table_row'] = map;
          });
          var data_to_send = { 'ajax_action': 'ajax_saver', 'table': table};
          var json_data = JSON.stringify(data_to_send);
          var dataToSend = {json_data: json_data};
          $.post(ajax_url, dataToSend, function (returnData) {
            console.log(JSON.parse(returnData));
            var returnObj = JSON.parse(returnData);
            if(returnObj['action']=='hideBody'){
              $(evt).parent('div').find('#node_id_'+returnObj['pk_id_name']).val(returnObj['pk_id']);
              console.log(returnObj['pk_id_name']);
              console.log(returnObj['pk_id']);
            //  $(evt).before(returnObj['body']);
            }
          }).fail(function (data) {
            console.log('failed ajax');
                    });
        }else if($(evt).data('ajax_action') == 'ajax_saveMain'){
         console.log('else if');
            $(evt).parent('div').find('.normal.form-'+$(evt).data('table_name')+'>.table_inputs.send-json').each(function(){
              table_name = $(this).data('table_name');
              table[table_name] = {};
              table[table_name]['relation_type'] = $(this).data('relation_type');
              $(this).children('input').each(function(){
                 innerMap[$(this).attr('name')] = $(this).val();
              });
            });
$(evt).parent('div').find('.normal.form-'+$(evt).data('table_name')+'>.node .node-id').each(function(){
                innerMap[$(this).attr('name')] = $(this).val();
            });
            map.push(innerMap);
            table[table_name]['table_row'] = map;
            console.log(table);



            $(evt).parent('div').find('.normal.form-'+$(evt).data('table_name')+'>.tab').each(function(){
              console.log('outer loop');
              innerMap = {};
             if(table_name == $(this).data('table_name')){
             }else{
               map = [];
               table_name = $(this).data('table_name');
               table[table_name] = {};
               table[table_name]['relation_type'] = $(this).data('relation_type');
             }
            $(this).children('.holder').children('.unique-tab').each(function(){
              console.log('inner loop');
              innerMap = {};
             $(this).children('.table_inputs.send-json').find('input').each(function(){
               console.log('send-json' + $(this).val());
                innerMap[$(this).attr('name')] = $(this).val()+"22";
             });
             $(this).find('.node-id').each(function(){
               console.log($(this).val());
               innerMap[$(this).attr('name')] = $(this).val();
             });
             map.push(innerMap);
             table[table_name]['table_row'] = map;
            });

          });
            console.log(table);


              console.log('MAIN SAVER');
              console.log(table);
              var data_to_send = { 'ajax_action': 'ajax_saver', 'table': table};
              var json_data = JSON.stringify(data_to_send);
              var dataToSend = {json_data: json_data};
              $.post(ajax_url, dataToSend, function (returnData) {
                console.log(JSON.parse(returnData));
                var returnObj = JSON.parse(returnData);
                if(returnObj['action']=='hideBody'){
                  $(evt).parent('div').find('#node_id_'+returnObj['pk_id_name']).val(returnObj['pk_id']);
                  console.log(returnObj['pk_id_name']);
                  console.log(returnObj['pk_id']);
                //  $(evt).before(returnObj['body']);
                }
              }).fail(function (data) {
                console.log('failed ajax');
                        });

        }
      }
          /*
          console.log(stringf);
          var objectf = JSON.parse(stringf);
          console.log(objectf);

          console.log(JSON.stringify(table['customer']));
}        */
/*

        function testVariables(evt){
          var json_data = {};
          var table = [];
          var tables = [];
          var table_name = "";
          var innerMap = [];
          var map =[];
          var arrayCounter = 0;
          var arrayTable = [];
          var isSet = false;
          $(evt).parent('div').find('.table_inputs').each(function(){

            // check if same table as previous , if(true) = don't change name , increase i counter for array //// Else put all the value of array inside table with table_name and reset everything value
            //

          if(table_name == $(this).data('table_name')){
            console.log('if table_name == this.table_name ');
            //don't change anyhing
            innerMap = [];
            arrayCounter +=1;
            console.log('arrayCounter Count : ' + arrayCounter);

          }else{
            // reset everything
            console.log('else table_name != this.table_name , TABLE NAME = ' + $(this).data('table_name') );
            if(isSet){
              console.log('start');
              console.log(arrayTable);
              console.log('end');
              table['table_name'] = table_name;
              for (i=0; i<arrayTable.length; i++){
                table['table_fields'][i] = arrayTable[i];
              }
              console.log('How is arrayTABLE ');
              console.log([{arrayTable}]);
              console.log('How is table');
              console.log(table);
              console.log('How is arrayTABLE[[[000]]] ');
              console.log(arrayTable[0]);
              tables.push(table);
              console.log('Just after pushing table into tables :: ');
              console.log(tables);
              isSet = false;
            }

            table_name = $(this).data('table_name');
            table['table_name'] = table_name;
            table['table_fields'] = [];
            arrayCounter = 0;
            arrayTable = [];
            innerMap = [];

          }

          $(this).children('input').each(function(){
                innerMap[$(this).attr('name')] = $(this).val();
          });

          arrayTable[arrayCounter] = innerMap;
          isSet = true;
          console.log('arrayTable after innerMap is set as its 0 or 1 array counter :: ');
          console.log(arrayTable);


          });

          console.log(tables);
        }


*/

        $(document).on('click', '.saveNode', function () {
              console.log('save on click');
              testVariables(this);
        });



          $(document).on('click', '.createForm,.addExisting', function () {
                console.log('.createForm on click');
                createForm(this);
          });















     jQuery.listening = function listening_ajax(returnData){
         var returned = JSON.parse(returnData);
         console.log(returned);
         console.log(returnData);
         $.each(returned, function(id, value){
             console.log('id : '+ id);
             console.log('value : '+ value);
         });
         console.log(returned.name);
         if(returned.name == "madan"){
             $('.modal.fade.in .modal-body').append(returned.view);
         }else{
             $('.modal.fade.in .modal-body').append('<h1>Fagot</h1>');
         }
     };


     function ajaxCreate(element) {
        console.log('createBtn Clicked');
     }

         $(document).on('click', '.createBtn', function(){
		        ajaxCreate(this);
             });

});
