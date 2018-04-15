<?php
function data_type2html_type($input){
  $label = $input['field_label'];
  $type = $input['field_type'];
  $name = $input['field_name'];
  $value = $input['field_value'];
  if($input['field_hidden']){
    return "<input type='hidden' name='$name' value='$value'/>";
  }else{
    switch ($type){
        // numeric
        case "bigint(20)":
        case "int":
        case "real":
        case "3":
        case "8":
        return "<input type='number' name='$name' value='$value'/>";

        // date
        case "DATE":
        case "date":
        case "10":
        return "<input type='date' name='$name' value='$value'/>";

        //time
        case "time":
        case "11":
        return "<input type='time' name='$name' value='$value'/>";

        case "datetime":
        case "timestamp":
        case "7":
        case "12":
        $name = 'ff';
        return "<input type='text' name='$name' value='$value'/>";

        // long text
        case "blob":
        case "252":
        case "LONGTEXT":
        return "<textarea name='$name'>$value</textarea>";

        default:
            return "<input type='text' name='$name' value='" . htmlspecialchars($value, ENT_QUOTES) . "'/>";
    }
  }
}

function createSaveScript($data){
  ?>
  <script>
    $(document).ready(function(){
      var
        form = $('#<?php echo $data['table_name'] ?>-form-<?php echo $data['unique_id'] ?>'),
        fieldset = form.find('fieldset');

        form.on('click', 'button.save', function(e){
          var data= {};
          var temp={};
          e.preventDefault();
          $(fieldset).each(function(){
            if($(this).data('fieldtype')==='single'){
              temp = {};
              data['customer'] = [];
              $(this).find('input, select, textarea').each(function(){
                temp[this.name] = this.value;
                console.log(this.name);
              });
              data['customer'].push(temp);
            }else if($(this).data('fieldtype')==='many'){
              data['client'] = [];
              $(this).find('tbody tr').each(function(){
                temp = {};
                console.log('tr');
                $(this).find('input,select,textarea').each(function(){
                  temp[this.name] = this.value;
                  console.log(this.name);
                });
                data['client'].push(temp);
              });
            }
          });
          console.log(data);
          var json_data = JSON.stringify(data);
          console.log(JSON.stringify(data));
          var object_data = JSON.parse(json_data);
          console.log(object_data);

        });
    });
  </script>
  <?php
}
