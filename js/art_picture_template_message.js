/*
 * ART-PICTURE GALLERY JS
 * https://art-picturedesign.de/art-picture-gallery/
 *
 * Copyright 2017, Jens Wiecker
 * https://art-picturedesign.de
 */
jQuery(document).ready(function($) {
 $("#template_message").addClass('active');
$("#header_txt").html('<b class="warn">Art</b> <b class="grey">Picture Gallery Message.</b><p>' +
                      '<p>Falls Sie <b class="grey">Hilfe</b> benötigen, finden Sie <a href="?apg-user-gallery-template=12067105"><b class="warn">'+
                      'hier</b> </a> eine ausführliche Beschreibung einzelner Funtionen.</p></p>');    
});
(function (jQuery){
window.$ = jQuery.noConflict();
})(jQuery);    
user_message_template();
       function user_message_template(){
             $.post(apg_ajax_obj.ajax_url, {        
             '_ajax_nonce': apg_ajax_obj.nonce,   
             'action':"add_apgGalleryTemplate", 
             'class':"UserHandler",
	         'method':"load_user_message_template+load",
           }, function(data) {
              if(data.record.status){
              $("#messageTemplate").html(data.record.template);      
              }     
          });   
        }
       function send_message(){
             $.post(apg_ajax_obj.ajax_url, {        
             '_ajax_nonce': apg_ajax_obj.nonce,   
             'action':"add_apgGalleryTemplate", 
             'class':"UserHandler",
	         'method':"new_new_user_message+template",
             'message':$("textarea#new_message").val()
           }, function(data) {
              if(data.record.status){
              $("textarea#new_message").val("");      
              success_message('Nachricht erfolgreich gesendet.');
              }else{
              error_message('Ein Fehler ist aufgetreten!');   
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