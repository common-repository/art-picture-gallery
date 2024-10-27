/*
 * ART-PICTURE GALLERY JS
 * https://art-picturedesign.de/art-picture-gallery/
 *
 * Copyright 2017, Jens Wiecker
 * https://art-picturedesign.de
 */
jQuery(document).ready(function($) {
$('#fileupload').bind('fileuploadprocessdone', function (e, data) {
    $.each(data.files, function (index, file) {
         if(file.name !=''){
            $("#inner-wrapper").hide();  
        }
    });
    data.url = server.url;
    var jqXHR = data.submit()
    .success(function (result, textStatus, jqXHR) {
    if(result.files[0]=== false)
     {
     $('#uploadModal').modal('toggle')
     }else{
      update_apg_db(result.files[0].galerie_name,
                    result.files[0].name,
                    result.files[0].typ,
                    result.files[0].size,
                    result.files[0].deleteUrl,
                    result.files[0].url,
                    result.files[0].mediumUrl,
                    result.files[0].thumbnailUrl
                   )   
            }
        });
    });
     function update_apg_db(galerieName,name,typ,size,deleteUrl,url,mediumUrl,thumbnailUrl){
         var fehlerName= 0;
         if(!galerieName){
             var fehlerName = 1;
         }
            $.post(apg_ajax_obj.ajax_url, {        
           '_ajax_nonce': apg_ajax_obj.nonce,   
            'action': "add_apgHandle", 
            'class':"ImageUploadHandle",
	        'method': "image_add_db",
            'galerieName':galerieName,
            'name':name,
            'typ':typ,
            'size':size,
            'deleteUrl':deleteUrl,
            'url':url,
            'mediumUrl':mediumUrl,
            'thumbnailUrl':thumbnailUrl,
            'fehlerName':fehlerName    
        }, function(data) { 
            if(data.record.status === false){
            $("#error_upload").empty();
            $("#error_upload").html(data.record.message); 
           // $("#upload_message").html('<h5 class="dan">Upload fehlgeschlagen! kein Ordner angegeben.</h5>');    
             }else{
           // $("#upload_message").html('<h5 class="prem">Upload erfolgreich!</h5>');     
            $("#error_upload").empty();   
            }    
         }); 
        }
    $(".upload-wrapper").hide();
    $(".fileupload-buttonbar").hide();
    $("#header_title").text('Startseite');
});
 (function (jQuery) {
window.$ = jQuery.noConflict();
})(jQuery);
art_galerie_select() 
read_api_status()
   function new_galerie(){
           $.post(apg_ajax_obj.ajax_url, {        
           '_ajax_nonce': apg_ajax_obj.nonce,   
            'action': "add_apgHandle", 
            'class':"ModalHandler",
	        'method': "upload_create_new_galerie+upload",
            'name':$('input[name=new_galerie]').val()               
        }, function(data) {                
            if(data.record.status ===false) {
            error_message(data.record. error_msg)
            return false;
            }
            art_galerie_select($('input[name=new_galerie]' ).val(),"newname")
            $('input[name=new_galerie]' ).val("")
            $("#message").show().fadeOut(6000)
            });   
        }
      function art_galerie_select(select){
          var session = "";
          if(select){
            session = 1;  
          }
           $.post(apg_ajax_obj.ajax_url, {        
           '_ajax_nonce': apg_ajax_obj.nonce,   
            'action': "add_apgHandle", 
            'class':"ModalHandler",
	        'method': "start_load_galerie_select+upload",
            'select':select,
            'session':session,
            'sessionTyp':select   
        }, function(data) {                
            $("#select").show();   
            $("#no_images").html(data.record.message_gal);
            $("#select_galerie").html(data.record.select);
            $("#loaded_galerie").html(data.record.loaded);        
            if($("#art_galerie_select").val() == ""){
            return false
            }
            if(data.record.err_message == 'no_galerie'){
            $("#select").hide();
            $("#no_galerie").html(data.record.message);
            return false
            }
            if(data.record.status === false ){
            error_message(data.record.message);
            $("#message_galerie_loaded").empty();
            return false;
            }
            if(data.record.img_count == 0){
            $("#message_galerie_loaded").empty();
            }else{
            $("#message_galerie_loaded").html('<b class="warn">Galerie:</b> <b class="grey"> '+$("#art_galerie_select").val()+' geladen</b> <b class="warn">Bilder insg.:</b> <b class="grey">'+data.record.img_count+'</b>');    
            }
            $(".upload-startseite").remove();
            $(".upload-wrapper").show();
            $(".fileupload-buttonbar").show();
            $("#select_galerie_upload").html(data.record.select);
            $("#label-text").text("Gallery auswahl:")
            $("#select_galerie").html(data.record.select);
            var x = document.getElementById("snackbar")
            $("#snackbar").text("Galerie "+$("#art_galerie_select").val()+" gewählt...")
            x.className = "show";
            setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
           });   
         }
       function read_api_status(){
           $.post(apg_ajax_obj.ajax_url, {        
           '_ajax_nonce': apg_ajax_obj.nonce,   
            'action': "add_apgHandle", 
             'class':"APIHandler",
          }, function(data) {                
            if(data.record === true){
            $("#license_status").html('<small class="suss"> aktiv</small>'); 
            }else{
            $("#license_status").html('<small class="dan"> nicht aktiv</small>');   
            }
          });   
        }
         function error_message(message_gal) {
            var x = document.getElementById("snackbar_error")
            $("#snackbar_error").html(message_gal)
            x.className = "show";
            setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
          }
      $(function () {
            'use strict';
            $('#fileupload').fileupload({
            url: server.url
            });
            $('#fileupload').fileupload('option', {
            url: server.url,
            limitConcurrentUploads:1,
            disableImageResize: /Android(?!.*Chrome)|Opera/
            .test(window.navigator && navigator.userAgent),
            imageMaxWidth: server.max_widht,
            imageMaxHeight: server.max_height,
            imageCrop: true, // Force cropped images,
            acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
            });
            if ($.support.cors) {
            $.ajax({
            url: server.url,
            type: 'HEAD'
            }).fail(function () {
            $('<div class="alert alert-danger"/>')
            .text('Upload server currently unavailable - ' +
            new Date())
            .appendTo('#fileupload');
            });
            }
});