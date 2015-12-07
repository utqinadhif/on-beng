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
    var a = 0;

    $("body").append('<div id="dialog"></div>');
    $("#dialog").dialog({
        modal: true,
        bgIframe: true,
        width: 400,
        autoOpen: false,
        title: "Confirm"
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