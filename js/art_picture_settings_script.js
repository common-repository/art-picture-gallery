/*
 * ART-PICTURE GALLERY JS
 * https://art-picturedesign.de/art-picture-gallery/
 *
 * Copyright 2017, Jens Wiecker
 * https://art-picturedesign.de
 */
(function (jQuery) {
            window.$ = jQuery.noConflict();
            })(jQuery);

jQuery(document).ready(function($) {
  $('[data-toggle="tooltip"]').tooltip(); 
  if($("#gmail_save_mail").val() == 0){
  $("#gmail_save_mail").prop('checked', ''); 
  }else{
  $("#gmail_save_mail").prop('checked', 'true');
  }
  if($("#gmail_SMTPAuth").val() == 1){
   $("#gmail_SMTPAuth").prop('checked', 'true');
  }else{
  $("#gmail_SMTPAuth").prop('checked', '');  
  } 
  if($("#wp_settings_img_details").val() == 1){
   $("#wp_settings_img_details").prop('checked', 'true');
  }else{
  $("#wp_settings_img_details").prop('checked', '');  
  } 
  if($("#wp_settings_bootstrap_css").val() == 1){
   $("#wp_settings_bootstrap_css").prop('checked', 'true');
  }else{
  $("#wp_settings_bootstrap_css").prop('checked', '');  
  }
  if($("#wp_settings_bootstrap_js").val() == 1){
   $("#wp_settings_bootstrap_js").prop('checked', 'true');
  }else{
  $("#wp_settings_bootstrap_js").prop('checked', '');  
  }
  if($("#wp_galerie_js").val() == 1){
   $("#wp_galerie_js").prop('checked', 'true');
  }else{
  $("#wp_galerie_js").prop('checked', '');  
  }     
});
 $(document).ready(function () {
    	tinyMCE.init({
   		mode : "textareas",
		theme : "advanced",
		plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave,visualblocks",
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect,|,print",
		theme_advanced_buttons2 : "bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,code,|,insertdate,inserttime,preview,|,forecolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,|,sub,sup,|,insertlayer,|,styleprops,|,fullscreen",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,
		style_formats : [
			{title : 'Fett', inline : 'b'},
		],
	});
     });
        function change_SMTPAuth(){
            if($("#gmail_SMTPAuth").val() == 1){
            $("#gmail_SMTPAuth").val('0');
            }else{
            $("#gmail_SMTPAuth").val('1');      
            }
         }
        function change_settings_img_details(){
            if($("#wp_settings_img_details").val() == 1){
            $("#wp_settings_img_details").val('0');
            }else{
            $("#wp_settings_img_details").val('1');      
            }
         }
        function change_wp_settings_bootstrap_css(){
            if($("#wp_settings_bootstrap_css").val() == 1){
            $("#wp_settings_bootstrap_css").val('0');
            }else{
            $("#wp_settings_bootstrap_css").val('1');      
            }
         }
        function change_wp_settings_bootstrap_js(){
            if($("#wp_settings_bootstrap_js").val() == 1){
            $("#wp_settings_bootstrap_js").val('0');
            }else{
            $("#wp_settings_bootstrap_js").val('1');      
            }
         }
        function change_wp_galerie_js(){
            if($("#wp_galerie_js").val() == 1){
            $("#wp_galerie_js").val('0');
            }else{
            $("#wp_galerie_js").val('1');      
            }
         }
        function send_email_settings(){
            $.post(apg_ajax_obj.ajax_url, {        
            '_ajax_nonce': apg_ajax_obj.nonce,   
            'action': "add_apgHandle", 
            'class':"SettingsHandler",
            'method':"save_email_settings",
            'gmail_host':$("#gmail_host").val(),
            'gmail_smtp':$("#gmail_smtp").val(),
            'gmail_SMTPSecure':$("#gmail_SMTPSecure").val(),
            'gmail_Username':$("#gmail_Username").val(),
            'gmail_Password':$("#gmail_Password").val(),
            'gmail_SMTPAuth':$("#gmail_SMTPAuth").val()    
          }, function(data) {                
             if(data.record.status_host){
            $("#email_host").removeClass('has-error has-feedback');
            $("#email_host").addClass('has-success has-feedback');
            $("#host_message").empty();
            $("#host_feedback").removeClass('glyphicon glyphicon-remove form-control-feedback');     
            $("#host_feedback").addClass('glyphicon glyphicon-ok form-control-feedback');
            }else{
            $("#email_host").addClass('has-error has-feedback');
            $("#host_message").text('Bitte SMTP-Host eintrag überprüfen!');     
            $("#host_feedback").addClass('glyphicon glyphicon-remove form-control-feedback');   
            }
            if(data.record.status_smtp){    
            $("#email_smtp").removeClass('has-error has-feedback');
            $("#email_smtp").addClass('has-success has-feedback');
            $("#smtp_message").empty(); 
            $("#smtp_feedback").removeClass('glyphicon glyphicon-remove form-control-feedback');    
            $("#smtp_feedback").addClass('glyphicon glyphicon-ok form-control-feedback');     
            }else{
            $("#email_smtp").addClass('has-error has-feedback');
            $("#smtp_message").text('Bitte SMTP-Port eintrag überprüfen!');     
            $("#smtp_feedback").addClass('glyphicon glyphicon-remove form-control-feedback');    
            }
            if(data.record.status_SMTPAuth){    
            $("#email_SMTPSecure").removeClass('has-error has-feedback');
            $("#email_SMTPSecure").addClass('has-success has-feedback');
            $("#SMTPSecure_message").empty(); 
            $("#SMTPSecure_feedback").removeClass('glyphicon glyphicon-remove form-control-feedback');    
            $("#SMTPSecure_feedback").addClass('glyphicon glyphicon-ok form-control-feedback');     
            }else{
            $("#email_SMTPSecure").addClass('has-error has-feedback');
            $("#SMTPSecure_message").text('Bitte SMTP Secure eintrag überprüfen!');     
            $("#SMTPSecure_feedback").addClass('glyphicon glyphicon-remove form-control-feedback');    
            }
           if(data.record.status_Username){    
            $("#email_Username").removeClass('has-error has-feedback');
            $("#email_Username").addClass('has-success has-feedback');
            $("#Username_message").empty(); 
            $("#Username_feedback").removeClass('glyphicon glyphicon-remove form-control-feedback');    
            $("#Username_feedback").addClass('glyphicon glyphicon-ok form-control-feedback');     
            }else{
            $("#email_Username").addClass('has-error has-feedback');
            $("#Username_message").text('Bitte Benutzername eintrag überprüfen!');     
            $("#Username_feedback").addClass('glyphicon glyphicon-remove form-control-feedback');    
            }
            if(data.record.status_Password){    
            $("#email_Password").removeClass('has-error has-feedback');
            $("#email_Password").addClass('has-success has-feedback');
            $("#Password_message").empty(); 
            $("#Password_feedback").removeClass('glyphicon glyphicon-remove form-control-feedback');    
            $("#Password_feedback").addClass('glyphicon glyphicon-ok form-control-feedback');     
            }else{
            $("#email_Password").addClass('has-error has-feedback');
            $("#Password_message").text('Bitte Passwort eintrag überprüfen!');     
            $("#Password_feedback").addClass('glyphicon glyphicon-remove form-control-feedback');    
            }
            if(data.record.status == 'false'){
             error_message('<b style="color:#a94442;">Bitte überprüfen Sie ihre Eingaben!</b>')   
            }else{
             success_message('E-Mail Settings erfolgreich gespeichert!')   
            }    
          });   
        }
       function load_smtp_check(){
             $.post(apg_ajax_obj.ajax_url, {        
             '_ajax_nonce': apg_ajax_obj.nonce,   
             'action': "add_apgHandle", 
             'class':"SettingsHandler",
             'method' :"load_smtp_check"
          }, function(data) {
             $("#load_modal").html(data.record.message);     
             $('#warningModal').modal('toggle'); 
          });   
        }
       function load_mail_check(){
             $.post(apg_ajax_obj.ajax_url, {        
             '_ajax_nonce': apg_ajax_obj.nonce,   
             'action': "add_apgHandle", 
             'class':"SettingsHandler",
             'method' :"load_mail_check"
          }, function(data) {
             $("#load_modal").html(data.record.message);     
             $('#warningModal').modal('toggle'); 
          });   
        }
     function send_testmail(){
           $('#warningModal').modal('toggle');
             $.post(apg_ajax_obj.ajax_url, {        
             '_ajax_nonce': apg_ajax_obj.nonce,   
             'action': "add_apgHandle", 
             'class':"SettingsHandler",
             'method' :"send_testmail",
            'value':$('input[name=testmail]').val()     
          }, function(data) {
            success_message('Testemail gesendet!')     
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
       function warning_message(msg){
             var x = document.getElementById("snackbar-warning")
             $("#snackbar-warning").text(msg)
             x.className = "show";
             setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
             }
       function validate_key(){
           $.post(apg_ajax_obj.ajax_url, {        
           '_ajax_nonce': apg_ajax_obj.nonce,   
            'action': "add_apgHandle", 
            'class':"SettingsHandler",
            'method' :"galerie_pro_license",
            'order_id'  :$("#orderid").val(),
            'license_key':$("#license_key").val()  
          }, function(data) {                
             $("#key_response").html(data.record.message);
             read_api_status();
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
       function google_maps_api(){
            $.post(apg_ajax_obj.ajax_url, {        
            '_ajax_nonce': apg_ajax_obj.nonce,   
            'action': "add_apgHandle", 
            'class':"SettingsHandler",
            'method':"google_maps_api_key",
            'value':$("#google_api_key").val()   
          }, function(data) {                
             if(data.record.status === true){
             success_message(data.record.message); 
             }else{
             error_message(data.record.message);
             }
          });   
        }
       //WP-DESIGN-Settings
       function send_design_settings(){
             $.post(apg_ajax_obj.ajax_url, {        
             '_ajax_nonce': apg_ajax_obj.nonce,   
             'action': "add_apgHandle", 
             'class':"SettingsHandler",
             'method' :"sed_design_settings",
             'wp_settings_img_details':$("#wp_settings_img_details").val(),
             'header_box':$("#header_box").val(),     
             'padding_top':$("#padding_top").val(),
             'wp_settings_bootstrap_css':$("#wp_settings_bootstrap_css").val(),
             'wp_settings_bootstrap_js':$("#wp_settings_bootstrap_js").val(),
             'wp_galerie_js':$("#wp_galerie_js").val(),     
             'padding_bottom':$("#padding_bottom").val(),
             'site_background_color':$("#site_background_color").val(),
             'box_background_color':$("#box_background_color").val()     
          }, function(data) {
             if(data.record.status === true){
             success_message(data.record.message); 
             }else{
             error_message(data.record.message);
             }
          });   
        }


//tinyMCE
read_user_email_content()
       function save_user_email_template(value){
            $.post(apg_ajax_obj.ajax_url, {        
            '_ajax_nonce': apg_ajax_obj.nonce,   
            'action': "add_apgHandle", 
            'class':"UserHandler",
            'method':"start_save_user_email_template+start",
            'value':value,
            'name':$("#loaded_template").val()  
          }, function(data) {                
             success_message(data.record.message);
          });   
        }
       function change_mail_template(value){
            $.post(apg_ajax_obj.ajax_url, {        
            '_ajax_nonce': apg_ajax_obj.nonce,   
            'action': "add_apgHandle", 
            'class':"UserHandler",
            'method':"start_change_mail_template+start",
            'name':value
          }, function(data) {                
             $("#email_links").html(data.record.links);
             $("#loaded_template").val(data.record.loaded);
             success_message('eMail Template '+ data.record.loaded);
             $("#loaded").html(data.record.loaded); 
             tinymce.get('elm1').setContent(data.record.daten);
          });   
        }
       function read_user_email_content(){
            $.post(apg_ajax_obj.ajax_url, {        
            '_ajax_nonce': apg_ajax_obj.nonce,   
            'action': "add_apgHandle", 
            'class':"UserHandler",
            'method': "start_read_user_email_content+start"
          }, function(data) {                
             $("#email_links").html(data.record.links);
             $("#loaded_template").val(data.record.loaded);
             $("#loaded").html(' Userdaten');
             tinymce.get('elm1').setContent(data.record.daten);
            });   
           }
       function delete_email_template(){
            $.post(apg_ajax_obj.ajax_url, {        
            '_ajax_nonce': apg_ajax_obj.nonce,   
            'action': "add_apgHandle", 
            'class':"UserHandler",
            'method':"start_delete_email_template+start",
            'name':$("#loaded_template").val() 
          }, function(data) {                
             if(data.record.status === true){
             success_message(data.record.message);    
             $("#email_links").html(data.record.links);
             $("#loaded_template").val(data.record.loaded); 
             $("#loaded").html(' Userdaten');
             success_message(data.record.message);
             tinymce.get('elm1').setContent(data.record.daten);
             }else{
             error_message(data.record.message);
            }
            });   
           }
       function new_email_template(){
            $('#newMailVorlageModal').modal('toggle')
             $.post(apg_ajax_obj.ajax_url, {        
            '_ajax_nonce': apg_ajax_obj.nonce,   
            'action': "add_apgHandle",
            'class':"UserHandler",
            'method':"start_new_email_template+start",
            'name':$("#new_email_vorlage").val()
          }, function(data) {                
           if(data.record.status == true){
             $("#new_email_vorlage").val('');    
             $("#email_links").html(data.record.head_links); 
             $("#loaded_template").val(data.record.loaded); 
             success_message(data.record.message);
             tinymce.get('elm1').setContent(data.record.daten);
             }
          });   
        }
       function load_reset_modal(value){
              $.post(apg_ajax_obj.ajax_url, {        
            '_ajax_nonce': apg_ajax_obj.nonce,   
            'action': "add_apgHandle",
            'class':"SettingsHandler",
            'method':"load_reset_modal",
            'typ':value
          }, function(data) {
            $("#load_modal").html(data.record.modal);     
            $('#warningModal').modal('toggle');      
          });   
        }
       function resetSettings(){
             $.post(apg_ajax_obj.ajax_url, {        
            '_ajax_nonce': apg_ajax_obj.nonce,   
            'action': "add_apgHandle",
            'class':"SettingsHandler",
            'method':"reset_settings"
            }, function(data) {
             if(data.record.status == true){
             location.reload(true)
             }else{
            $("#errResponse").html('ein fehler ist aufgetreten!');
            }    
          });   
        }    