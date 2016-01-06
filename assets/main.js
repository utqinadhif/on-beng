function nadhifMap() {
  var pati = {lat: -6.7449933, lng: 111.0460305};
  var map = new google.maps.Map(document.getElementById('map'), {
    center:            pati,
    zoom:              11,
    mapTypeId:         google.maps.MapTypeId.ROADMAP,
    mapTypeControl:    false,
    scrollwheel:       false,
    streetViewControl: false,
    scaleControl:      true,
    zoomControl:       true
  });

  map.setOptions({disableDoubleClickZoom: true });

  $.each(data, function(index, val) {
    addMarker({lat: parseFloat(val.lat), lng: parseFloat(val.lng)}, map, val.id_marker, 1);
  });

  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      var pos = {
        lat: position.coords.latitude,
        lng: position.coords.longitude
      };

      addMarker(pos, map, 'you', base_url+'assets/images/you.png');
      toast('Your location found', 'i');
      map.setCenter(pos);
    }, function() {
      handleLocationError(true);
    });
  }else{
    handleLocationError(false);
  }
  function handleLocationError(browserHasGeolocation) {
    var c = browserHasGeolocation ? 'Error: The Geolocation service failed.' : 'Error: Your browser doesn\'t support geolocation.';
    toast(c, 'e');
  }
}
function addMarker(location, map, id_marker, icon) {
  var i = icon == 1 ?
          base_url+'assets/images/icon.png' :
          icon;

  var marker = new google.maps.Marker({
    position:  location,
    icon:      i,
    draggable: false,
    label:     id_marker.toString(),
    map:       map,
    bounds:    true
  });
}
$(document).ready(function() {
  $('.item').hover(function(){
    if($(this).hasClass('op')){
      $(this).removeClass('op');
    }else{
      $(this).addClass('op');
    }
  });
  $('.login').hide();
  $('.open_hide').click(function(e){
    e.preventDefault();
    var a = $('.login').html();
    var b = $(this).attr('tit');
    $('#myModal').modal('show');
    $('.title').html(b);
    $('.content').html(a);
    $('#login').submit(function(){
      var u = $('#user').val();
      var p = $('#pass').val();
      if(u != '' && p != ''){
        $.ajax({
          url: base_url+'main/login',
          type: 'post',
          dataType: 'json',
          data: $(this).serialize(),
          error: function (a, b, c) {
            load(2);
            toast(a+b+c, 'e');
          },
          cache: false,
          beforeSend: function() {
            load(1);
          },
          success: function(result){
            load(2);
            if(result.ok){
              document.location.href = result.href;
            }else{
              toast(result.msg, 'e');
            }
          }
        });
      }else{
        toast('Empty username or password, please check again!', 'e');
      }
      return false;    
    });
  });
  $('.load_url').click(function(e){
    e.preventDefault();
    var a = $(this).attr('data-load');
    var b = $(this).attr('tit');
    $('#myModal').modal('show');
    $('.title').html(b);
    $('.content').load(a);
  });
});
