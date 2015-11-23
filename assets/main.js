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
  $('.item').hide();
  $('.btn_menu').click(function(){
    $('.item').toggle('fold');
  });
  $('[data-toggle="tooltip"]').tooltip();
  $('.login').hide();
  $('.open_hide').click(function(e){
    e.preventDefault();
    $('.login').toggle('size');
  });
  $('.load_url').click(function(e){
    e.preventDefault();
    var a = $(this).attr('data-load');
    var b = $(this).attr('tit');
    $('#myModal').modal('show');
    $('.title').html(b);
    $('.content').load(a);
  });
  $('#login').submit(function(){
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
    return false;    
  });
});
