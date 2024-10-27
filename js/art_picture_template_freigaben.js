/*
 * ART-PICTURE GALLERY JS
 * https://art-picturedesign.de/art-picture-gallery/
 *
 * Copyright 2017, Jens Wiecker
 * https://art-picturedesign.de
 */
jQuery(document).ready(function($) {
$("#gallery_details").hide();   
$("#template_gallery").addClass('active');
$("#header_txt").html('<b class="warn">Art</b> <b class="grey">Picture Gallery Freigaben.</b><p>' +
                      '<p>Falls Sie <b>Hilfe</b> benötigen, finden Sie <a href="?apg-user-gallery-template=12067105"><b class="warn">'+
                      'hier</b> </a> eine ausführliche Beschreibung einzelner Funtionen.</p></p>'); 
               var latgrad = null;
               var lnggrad = null;
               var GPSAltitude = null;
      function initMap(latgrad,lnggrad,GPSAltitude) {
           if(latgrad == null || lnggrad == null){
           return false;
           }    
           var uluru = {lat: latgrad , lng: lnggrad };
           var map = new google.maps.Map(document.getElementById('map'), {
           center: new google.maps.LatLng(uluru),
           mapTypeId: 'hybrid'
           });
           var geocoder = new google.maps.Geocoder;
           var infowindow = new google.maps.InfoWindow;
           var elevator = new google.maps.ElevationService;
           displayLocationElevation(uluru, elevator, infowindow)
           function displayLocationElevation(location, elevator, infowindow) {
           elevator.getElevationForLocations({
           'locations': [location]
           }, function(results, status) {
           infowindow.setPosition(location);
           if (status === 'OK') {
           if (results[0]) {
           $("#gpsheight").show();
           function integer (nr) {
           var str = nr.toString();
           str = str.substring(0, str.indexOf(".") + 3);
           return Number(str);
           }
           var res = GPSAltitude - results[0].elevation;
           var trace = integer(res);
           $("#gpsAltitude").html(Math.abs(trace) + ' m');
           //alert(Math.abs(trace) + ' meter');
           } else {
           infowindow.setContent('No results found');
           }
           } else {
           infowindow.setContent('Elevation service failed due to: ' + status);
           }
          });
         }
           geocodeLatLng(geocoder, map, infowindow)
           function geocodeLatLng(geocoder, map, infowindow) {
           geocoder.geocode({'location': uluru}, function(results, status) {
           if (status === 'OK') {
           if (results[1]) {
           map.setZoom(16);
           var marker = new google.maps.Marker({
           position: uluru,
           map: map
           });
           infowindow.setContent(results[0].formatted_address);
           infowindow.open(map, marker);
           } else {
           window.alert('No results found');
           }
           } else {
           window.alert('Geocoder failed due to: ' + status);
          }
         });
        }
       }
     $('#exifDetailsModal').on('shown.bs.modal', function (event) { 
            var button = $(event.relatedTarget) 
            var recipient = button.data('whatever') 
            var modal = $(this)
            $.post(apg_ajax_obj.ajax_url, {        
           '_ajax_nonce': apg_ajax_obj.nonce,   
            'action': "add_apgGalleryTemplate", 
            'class':"ModalHandler",
            'method': recipient,
            'galerieTyp':'userGallery'    
            }, function(data) {                
            if(data.record.status === false){
            return false;
            }
            $(".strip"+data.record.id+"").addClass('info'); 
            $("#modal_body_lg").html(data.record.modal_body)    
            $("#gpsheight").hide();
            var latitude = data.record.GPSLatGrad;
            var longtitude = data.record.GPSLongGrad;
            var GPSAltitude =data.record.GPSAltitude;
            initMap(latitude,longtitude,GPSAltitude)
            if(data.record.canvas === false){
            return false;
            }else{
            var c = document.getElementById("GpsCanvas");
            var ctx = c.getContext("2d");
            var img = document.getElementById("thumb"+data.record.id+"");
            ctx.drawImage(img, 10, 10);
            }    
        });       
    });
     $('#GalerieModal').on('show.bs.modal', function (event) { 
            var button = $(event.relatedTarget) 
            var recipient = button.data('whatever') 
            var modal = $(this)
            $.post(apg_ajax_obj.ajax_url, {        
           '_ajax_nonce':apg_ajax_obj.nonce,   
            'action': "add_apgGalleryTemplate", 
            'class':"ModalHandler",
            'method': recipient,
            'galeriename':$( 'input[name=galerie_loaded]' ).val(),
            'galeriename_details':$( 'input[name=galerie_loaded_details]' ).val()    
            }, function(data) {                
            if(data.record.modal_typ == "lg"){
            $("#dialog").addClass("modal-lg"); 
            }else{
            $("#dialog").removeClass("modal-lg"); 
            }
            if(data.record.details === true){
            var details = true; 
           }    
           $("#modal_body").html(data.record.body)
           $("#modal_titel").html(data.record.header)
           $("#modal_btn").html(data.record.btn)
           $("#new_beschreibung").html(data.record.beschreibung)
           $('input[name=new_tags]').val(data.record.tags)
           if(data.record.status === false){
           return false;
           }
           if(data.record.canvas === false){
           return false;
           }else{
           var c = document.getElementById("editCanvas");
           var ctx = c.getContext("2d");
           var img = document.getElementById("thumb"+data.record.id+"");
           ctx.drawImage(img, 0, 0);
           }   
        });       
    });
});
(function (jQuery){
window.$ = jQuery.noConflict();
})(jQuery);
       function art_galerie_select(select,id){
             $.post(apg_ajax_obj.ajax_url, {        
             '_ajax_nonce': apg_ajax_obj.nonce,   
             'action':"add_apgGalleryTemplate", 
             'class':"ModalHandler",
	         'method':id+"_load_user_galerie_select+"+$("#galerie_typ").val()+"",
             'select':select     
           }, function(data) {
              $("#galerie_typ").val(data.record.type);
              $("#loaded_galerie").html(data.record.loaded);
              $("#freigaben_startseite").hide();
              if(data.record.type == 'user_galerie_typ1' || data.record.type == 'user_galerie_typ2' || data.record.type == 'user_galerie_typ3'){
              load_user_galerie_typ(1,data.record.type,data.record.name);
              }
          });   
        }
       function load_user_galerie_typ( wertselect,typ,galerieName ){
             var last =  $( 'input[name=last]' ).val();
             var limit = $( '#select_pag :selected' ).text();
             var total = $("#image_total").html();
             $.post(apg_ajax_obj.ajax_url, {        
             '_ajax_nonce': apg_ajax_obj.nonce,   
             'action':"add_apgGalleryTemplate", 
             'class':"GalerieHandler",
             'method': "artgalerie",
		     'search':$( 'input[name=galerie_loaded]' ).val(),
             'page': wertselect,
			 'limit':limit,
             'type'  : typ,    
           }, function(data) {
              //new
                $("#template_freigaben").hide(); 
                 $("#gallery_details").show(); 
              //new     
              $("#galerie_total").html(data.record.total);
              $("#galerie_beschreibung").html(data.record.beschreibung);
              $("#galerie_aktuell").html($( 'input[name=galerie_loaded]' ).val());
              if(data.record.status === false){
              $("#template_pagination-up").hide(); 
              $("#template_galerie" ).hide();
              $("#no_images").html(data.record.message);
              return false;
              }
              $("#template_pagination-up").empty();
              $("#template_pagination-up").html(data.record.pagination); 
			  $("#template_galerie" ).html(data.record.template);
              $("#template_pagination-up").show(); 
              $("#template_galerie" ).show();
              $("#close_galerie").show();
          });   
        }
       function checkedAuswahl(auswahl){
             var last =  $( 'input[name=last]' ).val();
             var limit = $( '#select_pag :selected' ).text();
             var total = $("#image_total").html();
             $.post(apg_ajax_obj.ajax_url, {        
             '_ajax_nonce': apg_ajax_obj.nonce,   
             'action':"add_apgGalleryTemplate", 
             'class':"UserHandler",
		     'method': "user_user_auswahl+select",
             'auswahl':auswahl   
           }, function(data) {
              if(data.record.status){
              if(data.record.wahl)
              {
              success_message(unescape( 'Bild ausgew%E4hlt'));
              }else{
              warning_message(unescape('Bild abgew%E4hlt'));   
              }
          }     
          });   
    }
       function load_galerie_pag(id,type,search){
          var last =  $( 'input[name=last]' ).val();
          var limit = $( '#select_pag :selected' ).text();
          var total = $("#image_total").html();
        $.post(apg_ajax_obj.ajax_url, {        
           '_ajax_nonce': apg_ajax_obj.nonce,   
           'action': "add_apgGalleryTemplate", 
           'class':"galerie_handler",
           'method': "artgalerie",
           'search':$( 'input[name=galerie_loaded]' ).val(),
           'page': id,
           'type'  : type   
        }, function(data) {                
            $("#galerie_total").html(data.record.total);
            $("#galerie_beschreibung").html(data.record.beschreibung);
            $("#galerie_aktuell").html($( 'input[name=galerie_loaded]' ).val());
            if(data.record.status === false){
            $("#template_pagination-up").hide(); 
            $("#template_galerie" ).hide();
            $("#no_images").html(data.record.message);
            return false;
            }
            $("#template_pagination-up").empty();
            $("#template_pagination-up").html(data.record.pagination); 
			$("#template_galerie" ).html(data.record.template);
            $("#template_pagination-up").show(); 
            $("#template_galerie" ).show();
            $("#close_galerie").show();
         });   
        }
       function new_user_kommentar(id){
        $('#GalerieModal').modal('toggle');   
        $.post(apg_ajax_obj.ajax_url, {        
           '_ajax_nonce': apg_ajax_obj.nonce,   
           'action': "add_apgGalleryTemplate", 
           'class':"UserHandler",
           'method':$('input[name=galerie_loaded]').val()+"_new_user_kommentar+"+id+"",
           'kommentar':$('textarea#new_user_kommentar').val() 
        }, function(data) {                
           if(data.record.status){
           success_message('kommentar gespeichert');
           }
         });   
        }
       function error_message(msg) {
              var x = document.getElementById("snackbar_error")
              $("#snackbar_error").html(msg)
              x.className = "show";
              setTimeout(function(){ x.className = x.className.replace("show", ""); }, 4500);
              }
              function success_message(msg){
              var x = document.getElementById("snackbar-success")
              $("#snackbar-success").text(msg)
              x.className = "show";
              setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
              }
       function warning_message(msg) {
              var x = document.getElementById("snackbar-warning")
              $("#snackbar-warning").text(msg)
              x.className = "show";
              setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
              }