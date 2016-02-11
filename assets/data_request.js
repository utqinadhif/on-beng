$(document).ready(function(){
  $('.change-status').change(function(){
    var t     = $(this);
    var id    = $(this).attr('rel');
    var value = $(this).val();
    dialog('Are you sure to delete the data?')
    $("#dialog").dialog('option', 'buttons', {
      "Yes" : function(){
        var d = $(this);

        $.ajax({
          url: base_url+'data_request/change_status/'+id,
          type: 'POST',
          dataType: 'json',
          data: 'value='+value,
          error: function (a, b, c) {
            toast(a+b+c, 'e')
          },
          cache: false,
          beforeSend: function() {
          },
          success: function(result){
            if(result.ok){
              t.html(result.option);
              t.parents('tr').find('td.status').html(result.status_text);
              parent.toast('Data successfully changed', 'i');
              d.dialog('close');
            }
          }
        });
      },
      "No" : function(){
        t.prop('selectedIndex', 0);
        $(this).dialog('close');
      }
    });
  });
});
