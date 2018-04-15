var formModule = {};

$(document).ready(function(){

$(function(){
  var save = function(element){
    console.log('Saveing function of Form Module activated');
    return recursiveFindTableInputFields(element);
  };
  formModule.save = save;
});





    function recursiveFindTableInputFields(element){
      var input_fields;
      var main_data = {};
      var form = $(element).parent().parent(), fieldset = form.find('fieldset');
              input_field = $(fieldset).find('> .input-fields');
              main_data[$(input_field).data('table')] = findRecursively(input_field);
              return main_data;
    }

    function findRecursively(input_fields){
      var input_field;
      var data= {};
      var temp= {};
      var table_name = '';

        table_name = $(input_fields).data('table');
        data[table_name] = [];
          $(input_fields).find('>div.cover').each(function(){
            temp = {};
            $(this).find('>div>div.user_inputs input, >div>div.user_inputs select, >div>div.user_inputs textarea').each(function(){
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
      return data[table_name];
    }

});
