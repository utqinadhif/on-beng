var markers   = {};
var unchangedEnd;
var unchangedStart;
var temp   = null;

function nadhifMap() {
  var pati = new google.maps.LatLng(-6.7449933, 111.0460305);
  var map = new google.maps.Map(document.getElementById('map'), {
    center:            pati,
    zoom:              11,
    mapTypeId:         google.maps.MapTypeId.ROADMAP,
    mapTypeControl:    false,
    streetViewControl: false,
    scaleControl:      true,
    zoomControl:       true
  });

  $.each(data, function(index, val) {
    addMarker(new google.maps.LatLng(val.lat, val.lng), map, val.id_marker, 1);
  });

  google.maps.event.addListener(map, 'click', function(event) {
    checkUnchangedMarker();
    unsavedData();
    $('.float_form').hide('slide', { direction: "right" });
    reset();
  });

  google.maps.event.addListener(map, 'rightclick', function(event) {
    unsavedData();
    var uid = nownow();
    addMarker(event.latLng, map, uid, 1);
    temp = uid;
    $('.float_form').show('slide', { direction: "right" });
    reset();
    $('#latlng').val(event.latLng);
    $('#current_loc').val(event.latLng);
    $('#title').html("FORM INPUT");
    $('#submit').val('SIMPAN');
    $('#id_marker').val(uid);   
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
    draggable: true,
    label:     id_marker.toString(),
    map:       map,
    bounds:    true,
    animation: google.maps.Animation.DROP
  });
  markers[id_marker] = marker;
  marker.set("id", id_marker);

  var infowindow = new google.maps.InfoWindow();

  google.maps.event.addListener(marker, 'click', function(event) {
    checkUnchangedMarker();
    reset();
    if(id_marker == 'you'){
      toast('Your location', 'i');
      $('.float_form').hide('slide', { direction: "right" });
    }else
    {
      searchMarker(event.latLng, marker.get("id"));
    }
  });

  google.maps.event.addListener(marker, 'rightclick', function(event) {
    checkUnchangedMarker();
    if(marker.get("id") != 'you'){
      dialog('Are you sure to delete the data?')
      $("#dialog").dialog('option', 'buttons', {
        "YES, I'm Sure" : function(){
          deleteMarker(event.latLng, marker.get("id"));
          $(this).dialog('close');
        },
        "No" : function(){
          $(this).dialog('close');
        }
      });
    }else{
      toast('Your location', 'i');
    }
  });

  google.maps.event.addListener(marker,'drag',function(event) {
    $('#latlng').val(event.latLng);
  });

  google.maps.event.addListener(marker,'dragend',function(event) {
    searchMarker(event.latLng, marker.get("id"));
    setTimeout(function(){
      curloc = $('#current_loc').val().replace(/\(|\)|,/g, "").split(" ");
      unchangedStart = {
        id_marker: marker.get("id"),
        loc:       new google.maps.LatLng(curloc[0], curloc[1])
      };
      unchangedEnd = {
        id_marker: marker.get("id"),
        loc:       event.latLng
      };
    }, 500);
    toast('The location has changed', 'i');
  });
  google.maps.event.addListener(marker,'mouseover',function(event) {
    if(marker.get('id') != 'you'){
      $.ajax({
        url: base_url+'marker/searchMarker',
        type: 'POST',
        dataType: 'json',
        data: 'id_marker='+marker.get("id"),
        error: function (a, b, c) {
          toast(a+b+c, 'e')
        },
        cache: false,
        beforeSend: function() {
        },
        success: function(result){
          if(result.ok==1){
            infowindow.setContent(result.name);
            infowindow.open(map, marker);
          }
        }
      });
    }else{
      infowindow.setContent('Your position.');
      infowindow.open(map, marker);
    }
  });
  google.maps.event.addListener(marker,'mouseout',function(event) {
    infowindow.close();
  });
}
function searchMarker(latLng, id_marker){
  $.ajax({
    url: base_url+'marker/searchMarker',
    type: 'POST',
    dataType: 'json',
    data: 'id_marker='+id_marker,
    error: function (a, b, c) {
      load(2);
      toast(a+b+c, 'e')
    },
    cache: false,
    beforeSend: function() {
      load(1);
    },
    success: function(result){
      load(2);
      if(result.ok == 1){
        $('.float_form').show('slide', { direction: "right" });
        
        $('#name').val(result.name);
        $('#company').val(result.company);
        $('#contact').val(result.contact);
        $('#email').val(result.email);
        $('#location').val(result.location);
        $('#price').val(result.price);
        $('#latlng').val(latLng);
        $('#current_loc').val(result.latlng);
        $('#title').html("FORM EDIT");
        $('#submit').val('UBAH');
        $('#id_marker').val(result.id_marker);
      }else
      if(result.ok == 2){
        reset();
        $('#latlng').val(latLng);
        $('.float_form').show('slide', { direction: "right" });
        $('#judul').html("FORM INPUT");
        toast("Unsaved Data", 'e');
        $('#current_loc').val(latLng);
        $('#title').html("FORM EDIT");
        $('#id_marker').val(id_marker);
      }
    }
  });
}
function deleteMarker(latLng, id_marker) {
  $.ajax({
    url: base_url+'marker/deleteMarker',
    type: 'POST',
    dataType: 'json',
    data: 'id_marker='+id_marker,
    error: function (a, b, c) {
      load(2);
      toast(a+b+c, 'e')
    },
    cache: false,
    beforeSend: function() {
      load(1);
    },
    success: function(result){
      load(2);
      if(result.ok){
        toast("Data successfully deleted", 's');
        $('.float_form').hide('slide', { direction: "right" });
        markers[id_marker].setMap(null);
        delete markers[id_marker];
      }
    }
  }); 
}
function checkUnchangedMarker(){
  if(unchangedEnd != null){
    $.ajax({
      url: base_url+'marker/checkUnchangedMarker',
      type: 'post',
      dataType: 'json',
      data: 'id_marker='+unchangedEnd.id_marker,
      error: function (a, b, c) {
        load(2);
        toast(a+b+c, 'e')
      },
      cache: false,
      beforeSend: function() {
        load(1);
      },
      success: function(result){
        load(2);
        if(result.ok == 1){
          dialog('This data from database. Are you wanna ignore the unsaved data and restore data in position before?')
          $("#dialog").dialog('option', 'buttons', {
            "YES, I'm Sure" : function(){
              markers[unchangedEnd.id_marker].setPosition(unchangedStart.loc);
              unchangedEnd   = undefined;
              unchangedStart = undefined;
              $(this).dialog('close');
            },
            "No" : function(){
              $(this).dialog('close');
            }
          });
        }else
        if(result.ok == 2){
          dialog('New data dragged, if you dont save change, this data deleted by system. Are you sure?');
          $("#dialog").dialog('option', 'buttons', {
            "YES, I'm Sure" : function(){
              markers[unchangedEnd.id_marker].setMap(null);
              delete markers[unchangedEnd.id_marker];
              unchangedEnd   = undefined;
              unchangedStart = undefined;
              $(this).dialog('close');
            },
            "No" : function(){
              $(this).dialog('close');
            }
          });        
        }
        return result.ok;
      }
    });
  }
}
function unsavedData(){
  if(temp!=null){
    markers[temp].setMap(null);
    delete markers[temp];
    temp = null;
  }
}
$(document).ready(function() {
  $('#bengkel_data').submit(function(event) {
    if($('#submit').val() == 'SIMPAN')  // add new data
    {
      $.ajax({
        url: base_url+'marker/saveMarker',
        type: 'post',
        dataType: 'json',
        data: $(this).serialize(),
        error: function (a, b, c) {
          load(2);
          toast(a+b+c, 'e')
        },
        cache: false,
        beforeSend: function() {
          load(1);
        },
        success: function(result){
          load(2);
          reset();
          $('.float_form').hide('slide', { direction: "right" });
          toast('Data successfully inserted');
          unchangedEnd   = undefined;
          unchangedStart = undefined;
          temp = null;
        }
      });     
    }else // update data
    {
      $.ajax({
        url: base_url+'marker/updateMarker',
        type: 'post',
        dataType: 'json',
        data: $(this).serialize(),
        error: function (a, b, c) {
          load(2);
          toast(a+b+c, 'e')
        },
        cache: false,
        beforeSend: function() {
          load(1);
        },
        success: function(result){
          load(2);
          reset();
          $('.float_form').hide('slide', { direction: "right" });
          toast('Data successfully updated');
          unchangedEnd   = undefined;
          unchangedStart = undefined;
        }
      });
    }
    return false;
  });
  $('.cls').click(function(){
    $('.float_form').hide('slide', { direction: "right" });
    reset();
  });
  $('.float_form').hide();
  $('.item').hover(function(){
    if($(this).hasClass('op')){
      $(this).removeClass('op');
    }else{
      $(this).addClass('op');
    }
  });
  $('.open_modal').click(function() {
    $('.modal-title').html($(this).data('title'));
    $('.modal-body').html('<iframe id="frame" src="'+$(this).attr('href')+'"></iframe>')
    $('#myModal').modal();
    console.log($(this));
    return false;
  });
});