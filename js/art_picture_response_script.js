/*
 * ART-PICTURE GALLERY JS
 * https://art-picturedesign.de/art-picture-gallery/
 *
 * Copyright 2017, Jens Wiecker
 * https://art-picturedesign.de
 */
/* global define, window, document */
jQuery(document).ready(function($) {
$('[data-toggle="tooltip"]').tooltip();
});
      (function (jQuery){
        window.$ = jQuery.noConflict();
        })(jQuery);
      load_start_user_freigaben()
      function load_start_user_freigaben(){
           $.post(apg_ajax_obj.ajax_url, {        
           '_ajax_nonce': apg_ajax_obj.nonce,   
            'action': "add_apgHandle", 
            'class':"UserHandler",
            'method': "response_benutzer_freigaben_start+start" 
          }, function(data) {                
             if(!data.record.body){
             var  no_freigaben = '<h3 class ="warn text-center" style="padding-top:145px;padding-bottom:280px;"> <span class="fa fa-info"></span>' +
                                 ' <span class="fa fa-angle-double-right"> </span> Noch <small>keine <span class="warn">'+
                                 ' Kommentare</span> oder ausgewählte <span class="warn">Bilder</span> vorhanden!</small></h3>';
             $("#err").html(no_freigaben);
             }
             $("#user_template_close").html(data.record.close);
             $("#galerie_header").html(data.record.header);
             $("#user_template").html(data.record.body);
          });   
        }
      function show_response_details(value,typ){
           $.post(apg_ajax_obj.ajax_url, {        
           '_ajax_nonce': apg_ajax_obj.nonce,   
            'action': "add_apgHandle", 
            'class':"UserHandler",
            'method': value+"_user_response_template+start",
            'value':typ,
            'loaded':$("#loaded_typ").val() 
          }, function(data) {                
             if(data.record.status === true){
             $("#user_template_close").html(data.record.close);    
             }
             if(!data.record.typ){
             $("#user_template").empty();
             $("#user_template").html(data.record.template);      
             }
             if(data.record.typ == 'details'){
             $("#grid").removeClass('prem');
             $("#grid").addClass('font-inaktiv');
             $("#list").removeClass('font-inaktiv');
             $("#list").addClass('prem');
             $("#user_template").empty();
             $("#user_template").html(data.record.template); 
             }if(data.record.typ == 'grid'){
             $("#grid").removeClass('font-inaktiv');
             $("#grid").addClass('prem');
             $("#list").removeClass('prem');
             $("#list").addClass('font-inaktiv');  
             $("#user_template").empty();
             $("#user_template").html(data.record.template);
             }
          });   
        }
      function close_details() {
             $("#user_templates").empty();
             load_start_user_freigaben();
          }
      function close_select(){
            $("#user_templates").empty();
            load_user_freigaben();
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
      function warning_message(msg){
            var x = document.getElementById("snackbar-warning")
            $("#snackbar-warning").text(msg)
            x.className = "show";
            setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
          } 