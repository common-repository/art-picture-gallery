/*
 * ART-PICTURE GALLERY JS
 * https://art-picturedesign.de/art-picture-gallery/
 *
 * Copyright 2017, Jens Wiecker
 * https://art-picturedesign.de
 */
jQuery(document).ready(function($) {
$("#template_auswahl").addClass('active');  
$("#header_txt").html('<b class="warn">Art</b> <b class="grey">Picture Gallery Freigaben.</b><p>' +
                      '<p>Falls Sie <b>Hilfe</b> benötigen, finden Sie <a href="?apg-user-gallery-template=12067105"><b class="warn">'+
                      'hier</b> </a> eine ausführliche Beschreibung einzelner Funtionen.</p></p>'); 
});
(function (jQuery){
window.$ = jQuery.noConflict();
})(jQuery);
user_selected()
       function load_user_selected_image(fid){
             $.post(apg_ajax_obj.ajax_url, {        
             '_ajax_nonce': apg_ajax_obj.nonce,   
             'action':"add_apgGalleryTemplate", 
             'class':"UserHandler",
		     'method': "load_load_user_selected_image+load",
             'fid':fid   
           }, function(data) {
             if(data.record.status){     
              $("#select_template").empty();
              $("#select_template").html(data.record.template); 
              }
          });   
        }
       function user_selected(){
             $.post(apg_ajax_obj.ajax_url, {        
             '_ajax_nonce': apg_ajax_obj.nonce,   
             'action':"add_apgGalleryTemplate", 
             'class':"UserHandler",
		     'method': "load_user_selected+load",
            }, function(data) {
            $("#select_template").html(data.record.template);   
          });   
        }