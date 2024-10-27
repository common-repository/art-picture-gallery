/*
 * ART-PICTURE GALLERY JS
 * https://art-picturedesign.de/art-picture-gallery/
 *
 * Copyright 2017, Jens Wiecker
 * https://art-picturedesign.de
 */
/* global define, window, document */
jQuery(document).ready(function($) {
    switch($("#loaded_page").val())
    {
    case'startseite':
    $("#header_title").text('Startseite');
     Load_responsive_design("btn")        
    break;        
    }
//////////////////////////////////////////////GOOGLE-MAPS////////////////////////////////////////////    
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
            'action': "add_apgHandle", 
            'class':"ModalHandler",
            'method': recipient   
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
           '_ajax_nonce': apg_ajax_obj.nonce,   
            'action': "add_apgHandle", 
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
        $("#select_galerie").change(function() { 
         $.post(apg_ajax_obj.ajax_url, {        
           '_ajax_nonce': apg_ajax_obj.nonce,   
           'action': "add_apgHandle", 
           'class':"ModalHandler",
           'method': "start_load_galerie_select+"+$("#galerie_typ").val()+"",
           'select':this.value          
        }, function(data) {                
           if (data.record.details){
            galerieLoad(0);
            }
           $("#no_images").html(data.record.message_gal);
           $("#loaded_galerie").html(data.record.loaded);
           $("#select_galerie").html(data.record.select);
           if(data.record.type == 'galerieLoad' ){
           galerieLoad(1)
           }
           if(data.record.type == 'galerieLoadDetails'){
           galerieLoadDetails(1)
           }
        });   
    });
});
 (function (jQuery) {
window.$ = jQuery.noConflict();
})(jQuery);
      function Load_responsive_design(btn=""){
           $.post(apg_ajax_obj.ajax_url, {        
           '_ajax_nonce': apg_ajax_obj.nonce,   
            'action': "add_apgHandle", 
            'class':"ModalHandler",
            'method': screen.width+"_load_responsives_template+start",   
            'load_btn': btn                
        }, function(data) {                
           $("#galerie_header").html(data.record.header);
           $("#create_button").html(data.record.btn);
           $("#template_startseite").html(data.record.body);
           $("#select_galerie").html(data.record.select); 
        });   
    }
      function load_galerie_pag(id,type,search){
          var last =  $( 'input[name=last]' ).val();
          var limit = $( '#select_pag :selected' ).text();
          var total = $("#image_total").html();
        $.post(apg_ajax_obj.ajax_url, {        
           '_ajax_nonce': apg_ajax_obj.nonce,   
           'action': "add_apgHandle", 
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
         function new_img_beschreibung(id){
           $('#GalerieModal').modal('toggle') 
           $.post(apg_ajax_obj.ajax_url, {        
           '_ajax_nonce': apg_ajax_obj.nonce,   
           'action': "add_apgHandle", 
           'class':"ModalHandler",
	       'method': id+"_new_img_beschreibung+"+$( 'input[name=galerie_loaded]' ).val()+"",
           'tags'        : $( 'input[name=new_tags]' ).val(),
           'beschreibung': $('textarea#new_beschreibung').val(),
           'image'       : $('input[name=loaded_image'+id+']').val(),             
        }, function(data) {                
           if(data.record.status === true){
           success_message('Image ID: ' +data.record.id + ' beschreibung und Tags gespeichert') 
           }
        });   
      }
         function new_gal_beschreibung(id){
           $('#GalerieModal').modal('toggle') 
           $.post(apg_ajax_obj.ajax_url, {        
           '_ajax_nonce': apg_ajax_obj.nonce,   
           'action': "add_apgHandle", 
           'class':"ModalHandler",
	       'method': id+"_new_galerie_beschreibung+galerie",
           'tags': $( 'input[name=new_tags]' ).val(),
           'beschreibung': $('textarea#new_beschreibung').val()            
        }, function(data) {                
           if (data.record.details){
           galerieLoad(0);
           }
           success_message('Galerie ID: ' + data.record.id + ' beschreibung und Tags gespeichert')
        });   
      }
          function delete_galerie_select() {
            var gal_delete = $("#select_loaded_delete_galerie").val();
            success_message('<h5><span class="fa fa-trash fa-2x"></span> <b> Galerie "'+gal_delete+'" erfolgreich gelöscht!</b></h5>');
            delete_galerie(gal_delete);
            Load_responsive_design("btn");  
            }
          function load_user_freigaben() {
            $.post(apg_ajax_obj.ajax_url, {        
            '_ajax_nonce': apg_ajax_obj.nonce,   
            'action': "add_apgHandle", 
            'class':"UserHandler",
            'method': "start_load_freigaben+start"
          },function(data) {                
            if(data.record.status === false){
            error_message(data.record.message);
            $("#user_templates").empty(); 
            return false;  
            }else{
            $("#galerie_body").html(data.record.close + data.record.template);
            $("#menue_title").html('<h3 class="warn">Benutzer <small> Freigaben & Settings</small></h3>');
            }
          });   
         }
          function close_details() {
            $("#galerie_details").empty(); 
            $("#galerie_template_all").show();
            }
          function error_message(msg) {
            var x = document.getElementById("snackbar_error")
            $("#snackbar_error").html(msg)
            x.className = "show";
            setTimeout(function(){ x.className = x.className.replace("show", ""); }, 4500);
            } 
          function success_message(msg) {
            var x = document.getElementById("snackbar-success")
            $("#snackbar-success").html(msg)
            x.className = "show";
            setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
            }
          function warning_message(msg){
            var x = document.getElementById("snackbar-warning")
            $("#snackbar-warning").html(msg)
            x.className = "show";
            setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
            } 
         function delete_img (id){
           $('#GalerieModal').modal('toggle')
           var page = $( 'input[name=page' +id + ']' ).val();
           var limit = $( 'input[name=limit' +id + ']' ).val();      
           $.post(apg_ajax_obj.ajax_url, {        
           '_ajax_nonce': apg_ajax_obj.nonce,   
           'action': "add_apgHandle", 
           'class':"ModalHandler",
	       'method': "start_delete_image+"+$("#galerie_typ").val()+"",
	       'id':id,
           'page':page,
           'limit':limit,
           'galerie':$( 'input[name=galerie_loaded]' ).val()         
        }, function(data) {                
           success_message('Image ID: ' + data.record.id + ' erfolgreich gelöscht!'); 
           if(data.record.total === 0){
           $("#template_pagination-up").hide(); 
           $("#template_galerie" ).hide();
           $("#no_images").html(data.record.error_msg);
           }
           $( "#image_total" ).html( data.record.total );
           $( "#small_img_total" ).html( data.record.total );
           if(data.record.type == 'galerieLoad' ){
           galerieLoad(data.record.page)
           }
           if(data.record.type == 'galerieLoadDetails' ){
           galerieLoadDetails(data.record.page)
           }
         });   
        }
         function create_new_galerie(){
           $('#GalerieModal').modal('toggle')
           $.post(apg_ajax_obj.ajax_url, {        
           '_ajax_nonce': apg_ajax_obj.nonce,   
           'action': "add_apgHandle", 
           'class':"ModalHandler",
	       'method': "start_create_new_galerie+start",
           'name': $( 'input[name=new_name]' ).val(),
           'beschreibung': $('textarea#new_gal_beschreibung').val()        
        }, function(data) {                
           if(data.record.name === false){
           error_message(data.record.error_msg);
           return false;
           }
           $( "#galerie_count" ).html( data.record.galerie_count);
           $( "#image_total" ).html( data.record.image_count );
           $( "#htaccess_total" ).html( data.record.image_freigaben );
           $( "#nachrichten_total" ).html( data.record.image_message );
             window.location.assign("admin.php?page=art-Picture-new")
         });   
        }
         function galerieLoad(wert){
           var last =  $("#last").val();
           var limit = $( '#select_pag :selected' ).text();
           var total = $("#image_total").html();
           var  last = Math.ceil(total / limit);
           if(wert > last || wert == 0){ return false;}
           $.post(apg_ajax_obj.ajax_url, {        
           '_ajax_nonce': apg_ajax_obj.nonce,   
           'action': "add_apgHandle", 
           'class':"galerie_handler",
           'method': "artgalerie",
           'search':$( 'input[name=galerie_loaded]' ).val(),
           'page': wert,
           'limit':limit,
           'type'  : $("#galerie_typ").val()     
        }, function(data) {                
            if(data.record.status === false){
            $("#template_pagination-up").hide(); 
            $("#template_galerie" ).hide();
            $("#no_images").html(data.record.message);
            return false;
            }
            $("#template_pagination-up").html(data.record.pagination); 
			$( "#template_galerie" ).html(data.record.template);
            $("#template_pagination-up").show(); 
            $("#template_galerie" ).show();
         });   
        }
         function galerieLoadDetails( wertselect ){
            var last =  $("#last").val();
            var limit = $( '#select_pag :selected' ).text();
            var total = $("#image_total").html();
            var  last = Math.ceil(total / limit);
			 if ( limit == "" ) {
                  limit = 10
		      }
             if(wertselect > last || wertselect == 0){ return false;}
           $.post(apg_ajax_obj.ajax_url, {        
           '_ajax_nonce': apg_ajax_obj.nonce,   
           'action': "add_apgHandle", 
           'class':"galerie_handler",
           'method': "artgalerie",
		   'search':$( 'input[name=galerie_loaded]' ).val(),
           'page': wertselect,
		   'limit':limit,
           'type'  : $("#galerie_typ").val()  
        }, function(data) {                
           if(data.record.status === false){
           $("#template_pagination-up").hide(); 
           $("#template_galerie" ).hide();
           $("#no_images").html(data.record.message);
           return false;
           }
           $("#template_pagination-up").empty();
           $("#template_pagination-up").html(data.record.pagination); 
           $( "#template_galerie" ).html(data.record.template);
           $("#template_pagination-up").show(); 
           $("#template_galerie" ).show();
         });   
        }
         function load_post_msg_modal(id){
           $.post(apg_ajax_obj.ajax_url, {        
           '_ajax_nonce': apg_ajax_obj.nonce,   
           'action': "add_apgHandle", 
           'class':"ModalHandler",
           'method': 'modal_load_post_msg_modal+modal',   
           'id': id                
        }, function(data) {                
           if(data.record.status === true){
           $("#modal_titel").html('<b class="warn">User</b><b class="grey"> Message</b>');
           $("#modal_body").html(data.record.body);
           $("#modal_btn").html('<button class="btn btn-success btn-outline"data-dismiss="modal">ok</button>');
           $('#GalerieModal').modal('toggle')  
           }
        });   
      }
         function delete_galerie(galerie){
           $('#GalerieModal').modal('toggle')
           $.post(apg_ajax_obj.ajax_url, {        
           '_ajax_nonce': apg_ajax_obj.nonce,   
           'action': "add_apgHandle", 
           'class':"ModalHandler",
           'method': "start_delete_galerie+start",
           'name':galerie        
        }, function(data) {                
           $("#galerie_count" ).html( data.record.galerie_count);
           $("#image_total" ).html( data.record.image_count);
           $("#htaccess_total" ).html( data.record.image_freigaben);
           $("#nachrichten_total" ).html( data.record.image_message);
           $("#template_galerie").empty();
           $("#template_pagination-up").empty();
           galerieLoad(1);
           if ($('input[name=details_loaded]').val() =='loaded'){
           load_galerie_details();   
           }else{
           Load_responsive_design("btn");
           }
         }); 
          Load_responsive_design("btn");     
        }
            ////Select-Change
           $( ".sel_pagination-up" ).change( function () {
           if($("#galerie_typ").val() == 'galerieLoad' ){
           galerieLoad(1)
           }else if($("#galerie_typ").val() == 'galerieLoadDetails'){
           $("#grid").removeClass("prem");
           $("#grid").addClass("font-inaktiv");
           $("#details").addClass("prem");
           galerieLoadDetails(1)
           }else{
           return false;
           }
       	});
         function galerietyp(typ){
           $("#details").removeClass("font-inaktiv");
           $("#galerie_typ").val(typ)
           if(typ == 'galerieLoad'){
           $("#grid").addClass("prem");
           $("#details").removeClass("prem");
           $("#details").addClass("font-inaktiv");
           galerieLoad(1)
           }else if(typ == 'galerieLoadDetails'){
           $("#grid").removeClass("prem");
           $("#grid").addClass("font-inaktiv");
           $("#details").addClass("prem");
           galerieLoadDetails(1)
           }else{
           return false;
           }
        }
         function load_startseite() {
            $.post(apg_ajax_obj.ajax_url, {        
            '_ajax_nonce': apg_ajax_obj.nonce,   
            'action': "add_apgHandle", 
            'class':"ModalHandler",
            'method': "start_load_startseite+start"
          }, function(data) {                
             if(data.record.status === true){
             $("#template_startseite").html(data.record.template);  
            }  
          });   
         }
          function load_galerie_details(load_details) {
            $.post(apg_ajax_obj.ajax_url, {        
            '_ajax_nonce': apg_ajax_obj.nonce,   
            'action': "add_apgHandle", 
            'class':"ModalHandler",
            'method': load_details+"_load_galerie_details+start"
          }, function(data) {                
             $("#galerie_template_all").hide();
             $("#galerie_details").html(data.record.template);
             $("#galerie_details").show(); 
          });   
         }
          function template_read_messages() {
            $.post(apg_ajax_obj.ajax_url, {        
            '_ajax_nonce': apg_ajax_obj.nonce,   
            'action': "add_apgHandle", 
            'class':"UserHandler",
            'method': "start_template_read_messages+start"
          }, function(data) {                
             $("#galerie_template_all").hide();
             $("#galerie_details").html(data.record.template);
          });   
         }
          function close_messages(){
             $("#galerie_details").empty();
             $("#galerie_template_all").show(); 
           }
          function delete_usr_message(value,id) {
            $.post(apg_ajax_obj.ajax_url, {        
            '_ajax_nonce': apg_ajax_obj.nonce,   
            'action': "add_apgHandle", 
            'class':"UserHandler",
            'method':"click_delete_usr_message+log",
            'value':value,
            'id':id
          }, function(data) {                
             if(data.record.status === true){
             template_read_messages();
             }
          });   
         }
          function  change_delete_galerie(value) {
             $("#select_loaded_delete_galerie").val(value); 
             if(value == ''){
             document.getElementById("delete_galerie_select").disabled = 'false';
             $("#delete_galerie_details").html('<p class="text-center"><b class="dan">alle</b> Bilder aus dieser Galerie werden gelöscht!</p>'); 
             }else{
             document.getElementById("delete_galerie_select").disabled = '';
             }
             change_select_delete(value)
            }
          function change_select_delete(value) {
            $.post(apg_ajax_obj.ajax_url, {        
            '_ajax_nonce': apg_ajax_obj.nonce,   
           'action': "add_apgHandle", 
            'class':"ModalHandler",
            'method':"click_change_select_delete+log",
            'value':value
          }, function(data) {                
             if(data.record.status === true){
             $("#delete_galerie_details").html(data.record.message);   
            }
          });   
         }
