/*
 * ART-PICTURE GALLERY JS
 * https://art-picturedesign.de/art-picture-gallery/
 *
 * Copyright 2017, Jens Wiecker
 * https://art-picturedesign.de
 */
jQuery(document).ready(function($) {
     $('.collapse').collapse() 
       load_start_user_freigaben()
       $('[data-toggle="tooltip"]').tooltip();
       $('#FreigabeModal').on('show.bs.modal', function (event) {
           var button = $(event.relatedTarget) 
           var recipient = button.data('whatever') 
           var modal = $(this)
           $.post(apg_ajax_obj.ajax_url, {        
           '_ajax_nonce': apg_ajax_obj.nonce,   
            'action': "add_apgHandle", 
            'class':"ModalHandler",
            'method': recipient,   
            'user':$("#art_galerie_user :selected").val()               
        }, function(data) {                
            $("#modal_body").html(data.record.modal_body)
            $("#modal_titel").html(data.record.header)
            $("#modal_btn").html(data.record.btn)
       });   
    })
});
      (function (jQuery){
        window.$ = jQuery.noConflict();
        })(jQuery);
      read_api_status()
      function click_user_aktiv(){
        if($("#add_user_aktiv").val() == 1){
            $("#add_user_aktiv").val('0');
        }else{
            $("#add_user_aktiv").val('1'); 
        }
      }
        function click_email_aktiv(){
        if($("#add_email_aktiv").val() == 1){
            $("#add_email_aktiv").val('0');
        }else{
            $("#add_email_aktiv").val('1'); 
        }
      }
      function art_user_select(loaded){
           $("#user_loaded").val($("#art_galerie_user :selected").val());
           }
      function load_start_user_freigaben(){
           $.post(apg_ajax_obj.ajax_url, {        
           '_ajax_nonce': apg_ajax_obj.nonce,   
            'action': "add_apgHandle", 
            'class':"UserHandler",
            'method': "start_benutzer_freigaben_start+start"  
          }, function(data) {                
             $("#galerie_header").html(data.record.header);
             $("#galerie_body").html(data.record.body);
             if(!data.record.status){
             $("#err_message").html(data.record.message);  
             }
             if($("#new_user_loaded").val() == 'error'){
             $("#err_message").empty();   
             $("#new_user_template").show();
             $("#galerie_body").empty();
             $("#galerie_header").html(data.record.header);
             $("#galerie_body").html(data.record.body);
             }
          });   
        }
      function template_read_messages(){
           $.post(apg_ajax_obj.ajax_url, {        
           '_ajax_nonce': apg_ajax_obj.nonce,   
            'action': "add_apgHandle", 
            'class':"UserHandler",
            'method': "start_template_read_messages+start" 
          }, function(data) {                
             $("#galerie_body").empty();
             $("#galerie_body").html(data.record.template);
          });   
        }
      function load_user_freigaben(){
           $.post(apg_ajax_obj.ajax_url, {        
           '_ajax_nonce': apg_ajax_obj.nonce,   
            'action': "add_apgHandle", 
            'class':"UserHandler",
            'method': "start_load_freigaben+start"
          }, function(data) {                
             if(data.record.status === false){
             error_message(data.record.message);
             $("#user_templates").empty();
             load_start_user_freigaben();
             return false;  
             }else{
             $("#galerie_body").html(data.record.close + data.record.template);
             $("#menue_title").html('<h3 class="warn">Benutzer <small> Freigaben & Settings</small></h3>');
             }
          });   
        }
      function new_freigabe_template(){
           $.post(apg_ajax_obj.ajax_url, {        
           '_ajax_nonce': apg_ajax_obj.nonce,   
            'action': "add_apgHandle", 
            'class':"UserHandler",
            'method': "start_create_new_freigabe_template+start"
          }, function(data) {                
             if(!data.record.status){
             return false;
            }
             $("#err_message").empty();
             $("#galerie_body").empty();
             $("#galerie_body").html(data.record.template);
             $("#menue_title").empty();
             $("#menue_title").html('<h3 class="warn">Benutzer <small>Freigabe hinzufügen</small></h3>');
          });   
        }
       function loadnewUserTemplate(){
            $("#galerie_body").empty();
            $("#err_message").empty();
            $("#menue_title").empty();
            $("#new_user_template").show();
            $("#menue_title").html('<h3 class="warn">Benutzer <small>hinzufügen</small></h3>'); 
         }
        function close_new_user() {
            $("#new_user_template").empty();
            load_start_user_freigaben();
         }
       function save_new_freigabe(){
            if(!$("#art_galerie_select :selected").val() || !$("#htaccessUser :selected").val()){
            error_message('<h3 class="text-center"style="padding-top: 15px;"><small><i class="dan fa fa-info fa-2x"></i> <span class="dan fa fa-angle-double-right"></span>Bitte Benutzer und Galerie <span class="dan"> wählen.</span></small></h5>');
            return false;
            }
            $.post(apg_ajax_obj.ajax_url, {        
            '_ajax_nonce': apg_ajax_obj.nonce,   
            'action': "add_apgHandle", 
            'class':"UserHandler",
            'method': "start_new_freigabe_galerie+start",
            'user':$("#htaccessUser :selected").val(),
            'galerie':$("#art_galerie_select :selected").val()
          }, function(data) {                
             $("#err_message").empty();
             if(data.record.status === false){
             error_message(data.record.message);  
             }else{
             success_message('Freigabe mit der ID: '+data.record.insert_id +' erfolgreich erstellt ');  
             }
             load_start_user_freigaben();
          });   
        }
       function delete_freigabe(id){
            $('#FreigabeModal').modal('toggle');
            $.post(apg_ajax_obj.ajax_url, {        
            '_ajax_nonce': apg_ajax_obj.nonce,   
            'action': "add_apgHandle", 
            'class':"UserHandler",
            'method': id+"_delete_freigabe+start"
          }, function(data) {                
             if(data.record.status === true){
             warning_message('freigabe mit ID:' +data.delete_id + '  gelöscht!');  
             }else{
             warning_message('ein fehler ist aufgetreten');
             } 
             load_user_freigaben();
          });   
        }
       function delete_user(id){
            $.post(apg_ajax_obj.ajax_url, {        
            '_ajax_nonce': apg_ajax_obj.nonce,   
            'action': "add_apgHandle", 
            'class':"UserHandler",
            'method': id+"_delete_user+start",
            'uid':id    
          }, function(data) {   
             $('#FreigabeModal').modal('toggle');
             if(data.record.status===true){
              success_message('Freigaben und Benutzer mit der ID: '+id+' erfolgreich gelöscht!');   
             }else{
             warning_message('ein fehler ist aufgetreten');    
             }    
             load_start_user_freigaben();
          });   
        }
       function load_all_freigaben(){
            $.post(apg_ajax_obj.ajax_url, {        
            '_ajax_nonce': apg_ajax_obj.nonce,   
            'action': "add_apgHandle", 
            'class':"UserHandler",
			'method':"user_delete_user+start",
            'user': $("#art_galerie_user :selected").val()
          }, function(data) {                
             });   
        }
       function checkedHtaccess(value){
            $.post(apg_ajax_obj.ajax_url, {        
            '_ajax_nonce': apg_ajax_obj.nonce,   
            'action': "add_apgHandle", 
            'class':"UserHandler",
  		    'method':"user_checked_details+start",
            'checked': value
          }, function(data) {
             if(data.record.status){
              if(data.record.check == 1){
              success_message(data.record.message);  
             }else{
             warning_message(data.record.message);
             }    
             $("#"+data.record.typ+"").val(data.record.check);   
             }
          });   
        }
       function save_beschreibung(value){
            $.post(apg_ajax_obj.ajax_url, {        
            '_ajax_nonce': apg_ajax_obj.nonce,   
            'action': "add_apgHandle", 
            'class':"UserHandler",
  		    'method':value+"_checked_details+start",
            'galerie_beschreibung':$('textarea#beschreibung'+value+'').val(),
            'head':$('input[name=galeriehead'+value+']').val(),
          }, function(data) {
          });   
        }
       function galerie_typ_select(value){
            $.post(apg_ajax_obj.ajax_url, {        
            '_ajax_nonce': apg_ajax_obj.nonce,   
            'action': "add_apgHandle", 
            'class':"UserHandler",
		    'method':"select_checked_details+start",
            'select':value 
          }, function(data) {
          });   
        }
       function freigabe_aktiv(daten){
            $.post(apg_ajax_obj.ajax_url, {        
            '_ajax_nonce': apg_ajax_obj.nonce,   
            'action': "add_apgHandle", 
            'class':"UserHandler",
		    'method':"click_freigabe_aktiv+freigabe",
            'id':daten
          }, function(data) {
             $("#"+data.record.value+"").val(data.record.checked);
          });   
        }
       function htaccess_aktiv(daten){
            $.post(apg_ajax_obj.ajax_url, {        
            '_ajax_nonce': apg_ajax_obj.nonce,   
            'action': "add_apgHandle", 
            'class':"UserHandler",
            'method':"click_user_aktiv+freigabe",
            'daten':daten
          }, function(data) {
             if(data.record.value == 0){
             success_message('aktiviert');   
            }else{
             warning_message('deaktiviert');   
            }
            $("#"+data.record.check+"").val(data.record.checked);
          });   
        }
            var id="";
       function change_user_data(daten,id){
            $.post(apg_ajax_obj.ajax_url, {        
            '_ajax_nonce': apg_ajax_obj.nonce,   
            'action': "add_apgHandle", 
            'class':"UserHandler",
            'method':"click_change_user_data+freigabe",
            'newdata':$("input[name="+daten+"]" ).val(),
            'daten':daten,
            'email':$("input[name="+id+"_send_new_pw]" ).val()
          }, function(data) {
             if(data.record.value == 0){
             success_message('aktiviert');   
            }else{
             warning_message('deaktiviert');   
            }
            if(data.recordstatus === true){
             success_message(data.record.message);
             }else{
             warning_message(data.record.message);
            }
          });   
        }
       function select_galerietyp(daten){
            $.post(apg_ajax_obj.ajax_url, {        
            '_ajax_nonce': apg_ajax_obj.nonce,   
            'action': "add_apgHandle", 
            'class':"UserHandler",
			'method':"click_select_change_galerie_typ+freigabe",
            'select':daten
          }, function(data) {
             if(data.record.status === true){
             success_message(data.record.message);
             }else{
             warning_message(data.record.message);
             } 
          });   
        }
       function  pw_generieren(){
            $.post(apg_ajax_obj.ajax_url, {        
            '_ajax_nonce': apg_ajax_obj.nonce,   
            'action': "add_apgHandle", 
            'class':"UserHandler",
            'method':"click_passwort_generieren+freigabe"
          }, function(data) {
             if(data.record.status){
             $("#pw_generieren").empty();
             $("#pw_generieren").html(data.record.template);
             } 
          });   
        }
       function template_user_details(){
            $.post(apg_ajax_obj.ajax_url, {        
            '_ajax_nonce': apg_ajax_obj.nonce,   
            'action': "add_apgHandle", 
            'class':"UserHandler",
            'method':"click_load_template_user_details+freigabe"
          }, function(data) {
             if(data.record.status === true){
             $("#err_message").empty();
             $("#galerie_body").empty();
             $("#galerie_body").html(data.record.template);
             $("#menue_title").empty();
             $("#menue_title").html('<h3 class="warn">Benutzer <small>settings</small></h3>');
            }else{
             error_message(data.record.message); 
              } 
          });   
        }
       function freigabe_details_user_select(value){
            $.post(apg_ajax_obj.ajax_url, {        
            '_ajax_nonce': apg_ajax_obj.nonce,   
            'action': "add_apgHandle", 
            'class':"UserHandler",
            'method':"click_load_freigaben_select+freigabe",
            'data':value
          }, function(data) {
             if(data.record.status){
             $("#err_message").empty();
             $("#galerie_body").empty();
             $("#galerie_body").html(data.record.template);
             $("#menue_title").empty();
             }
          });   
        }
       function new_user_notiz(daten){
             $.post(apg_ajax_obj.ajax_url, {        
             '_ajax_nonce': apg_ajax_obj.nonce,   
             'action': "add_apgHandle", 
             'class':"UserHandler",
			 'method':"click_new_user_notiz+freigabe",
             'notiz':$("textarea#new_user_notiz"+daten+"").val(),
             'uid':daten
          }, function(data) {
              $('#FreigabeModal').modal('toggle'); 
             if(data.record.status === true){
             success_message(data.record.message);     
             }else{
             error_message('ein FEHLER ist aufgetreten!');   
             }     
          });   
        }
       function email_select_change(value){
             if(value == ''){
             document.getElementById("new_email_txt").disabled = '';
             }if(value != ''){
             document.getElementById("new_email_txt").disabled = 'false';
             }
            }
        function send_user_email(value){
            var send_mail = "";
            var send_typ = "";
            if($("#art_email_select" ).val() == ''){
            send_mail = $("textarea#new_email_txt").val();
            send_typ = 'text';
            }else{
            send_mail = $("#art_email_select" ).val();
            send_typ = 'select';   
            }
            if(send_mail == ''){
            error_message('<h4 style="color: #d73814;"><span class="fa fa-exclamation"></span> Bitte <small> eMail <b class="dan">Text</b> eingeben, oder <b class="dan">Vorlage</b> wählen!</small></h4>');
            return;
            }
            user_email_senden(send_mail,value,send_typ)
            }
       function user_email_senden(send_mail,id,typ){
             $("#FreigabeModal").modal('toggle'); 
             $.post(apg_ajax_obj.ajax_url, {        
             '_ajax_nonce': apg_ajax_obj.nonce,   
             'action': "add_apgHandle", 
             'class':"UserHandler",
			 'method':"click_user_email_senden+freigabe",
             'email':send_mail,
             'id':id,
             'typ':typ
          }, function(data) {
             if(data.record.status === true){
             success_message(data.record.message);
             }else{
             error_message('<h4 style="color:#d73814;">'+data.record.message+'</h4>'); 
             } 
          });   
        }
       function load_user_log(value){
             $.post(apg_ajax_obj.ajax_url, {        
             '_ajax_nonce': apg_ajax_obj.nonce,   
             'action': "add_apgHandle", 
             'class':"UserHandler",
			 'method':"click_load_user_log+log",
             'typ':value
          }, function(data) {
             $("#galerie_body").hide();
             $("#galerie_header").hide();
             $("#user_templates").html(data.record.template); 
          });   
        }
       function checked_send_email_newpw(id){
             if($("input[name="+id+"_send_new_pw]" ).val() == 1){
             $("input[name="+id+"_send_new_pw]" ).val(0) 
             }else{
             $("input[name="+id+"_send_new_pw]" ).val(1) 
             }
             return;
             }
       function userLog_jahr(value){
             $.post(apg_ajax_obj.ajax_url, {        
             '_ajax_nonce': apg_ajax_obj.nonce,   
             'action': "add_apgHandle", 
             'class':"UserHandler",
			 'method':"click_load_userLog_jahr+log",
             'id':value
          }, function(data) {
             $("#user_templates").html(data.record.template); 
          });   
        }
       function userLog_monat(id,usrjahr){
             $.post(apg_ajax_obj.ajax_url, {        
             '_ajax_nonce': apg_ajax_obj.nonce,   
             'action': "add_apgHandle", 
             'class':"UserHandler",
			 'method':"click_load_userLog_monat+log",
             'id':id,
             'jahr':usrjahr
          }, function(data) {
             $("#user_templates").html(data.record.template); 
          });   
        }
       function userLog_details(id,usrmonat,usrjahr){
             $.post(apg_ajax_obj.ajax_url, {        
             '_ajax_nonce': apg_ajax_obj.nonce,   
             'action': "add_apgHandle", 
             'class':"UserHandler",
             'method':"click_user_Log_details+log",     
             'id':id,
             'monat':usrmonat,
             'jahr':usrjahr
          }, function(data) {
             $("#user_templates").html(data.record.template);
          });   
        }
       function close_log(){
             $("#user_templates").empty();
             $("#galerie_body").show();
             $("#galerie_header").show(); 
             }
       function delete_log_eintrag(value){
             $.post(apg_ajax_obj.ajax_url, {        
             '_ajax_nonce': apg_ajax_obj.nonce,   
             'action': "add_apgHandle", 
             'class':"UserHandler",
			  'method':"click_delete_log_eintrag+log",
              'value':value
          }, function(data) {
             userLog_details(data.record.id,data.record.monat,data.record.jahr);
          });   
        }
       function delete_day_log(value){
             $.post(apg_ajax_obj.ajax_url, {        
             '_ajax_nonce': apg_ajax_obj.nonce,   
             'action': "add_apgHandle", 
             'class':"UserHandler",
			 'method':"click_delete_day_log+log",
             'value':value
          }, function(data) {
             if(data.record.status === true){
             warning_message('eintrag gelöscht!');   
             load_user_log('start');  
            }
          });   
        }
       function delete_usr_message(value,id){
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
             var bn="";
             var vn="";
             var nn="";
             var em="";
             var no="";
             var me=""; 
       function new_user_template(bn,vn,nn,em,no,me){
             $.post(apg_ajax_obj.ajax_url, {        
             '_ajax_nonce': apg_ajax_obj.nonce,   
             'action': "add_apgHandle", 
             'class':"UserHandler",
			 'method':"click_new_user_template+log",
             'bn':bn,
             'vn':vn,
             'nn':nn,
             'em':em,
             'no':no
          }, function(data) {
             $("#galerie_body").empty();
             $("#menue_title").empty();
             $("#new_user_template").html(data.record.template);
             $("#new_user_template").show();
             $("#menue_title").html('<h3 class="warn">Benutzer <small>hinzufügen</small></h3>');
          });   
        }
       function add_new_user(){
             $.post(apg_ajax_obj.ajax_url, {        
             '_ajax_nonce': apg_ajax_obj.nonce,   
             'action': "add_apgHandle", 
             'class':"UserHandler",
			 'method':"add_new_user_db+log",
             'bn':$("#add_username").val(),
             'vn':$("#add_vorname").val(),
             'pw':$("#add_passwort").val(),     
             'nn':$("#add_nachname").val(),
             'em':$("#add_email").val(),
             'no':$("#add_notiz").val(),
             'ua':$("#add_user_aktiv").val(),
             'ea':$("#add_email_aktiv").val(),       
          }, function(data) {
              if(data.record.status == true){
              $("#error_messages_user").remove();      
              $("#new_user_template").empty();
              success_message(data.record.message);
              close_messages();   
              }else{
              var errMsg='<div class="alert alert-danger alert-dismissible"> '+
                         '<button type="button" class="close" data-dismiss="alert" aria-label="Schließen"><span aria-hidden="true">&times;</span></button>'+
                           data.record.message  +'</div>';  
              $("#error_messages_user").html(errMsg);       
            }     
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
       function close_messages(){
             load_start_user_freigaben() 
             }  
       function close_details() {
             $("#user_templates").empty();
             $("#err_message").empty(); 
             load_start_user_freigaben();
             }
       function close_select(){
             $("#user_templates").empty();
             $("#err_message").empty();  
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