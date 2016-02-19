function toast(string, id){
  switch(id) {
    case 'e':
      type = icon = 'error';
    break;
    case 'i':
      type = 'Information';
      icon = 'info';
    break;
    case 'w':
      type = icon = 'warning';
    break;
    default:
      type = icon = 'success';
  } 
  $.toast({
    heading: type,
    text: string,
    showHideTransition: 'slide',
    icon: icon
  })
}
function dialog(message){
  $("body").append('<div id="dialog"></div>');
  $("#dialog").dialog({
      modal: true,
      bgIframe: true,
      autoOpen: false,
      title: "Confirm",
      width: 'auto', // overcomes width:'auto' and maxWidth bug
      maxWidth: 600,
      height: 'auto',
      fluid: true, //new option
      resizable: false
  });
  $("#dialog").html(message);
  $("#dialog").dialog('open');
}
function reset() {
  $('.form-control, .input').val('');
}
function load(id){
  switch(id){
    case 1:
      $('.no').addClass('loading');
    break;
    case 2:
    default:
      $('.no').removeClass('loading');
    break;
  }
}
function nownow(){
  var c = new Date();
  var y = String(c.getFullYear());
  var m = fix(c.getMonth());
  var d = fix(c.getDate());
  var h = fix(c.getHours());
  var min = fix(c.getMinutes());
  var s = fix(c.getSeconds());
  return y+m+d+h+min+s;
}

function fix(x){
  y = String(x).length < 2 ? '0'+x : x;
  return y;
}
$(document).ready(function() { 
  $('[data-toggle="tooltip"]').bstooltip();
  $('[data-toggle="popover"]').popover();
  $('.confirm').click(function(){
    var a = $(this);
    dialog('Are you sure to exit?')
    $("#dialog").dialog('option', 'buttons', {
      "YES, I'm Sure" : function(){
        document.location.href=a.attr('href');
      },
      "No" : function(){
        $(this).dialog('close');
      }
    });
    return false;
  });
});