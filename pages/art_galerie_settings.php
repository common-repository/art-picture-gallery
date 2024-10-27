<?php
/**
 * ArtPicture Plugin PHP Class
 * http://art-pictureDesign.de/WP-ArtTheme-Galerie
 * Copyright 2017, Jens Wiecker
 * https://art-picturedesign.de
 *
 */
require_once(dirname(__DIR__).'/apg.class/db/settings-remote.php');
$da= new APG\ArtPictureGallery\remote();
$da->settings_select("4");
$data=$da->return;
?>
<div class="bootstrap-wrapper">
<div class="container">
<div class="page-header">
<div class="row">
<div class="col-md-2">
<img src = "<?php echo plugins_url('../assets/images/Logo-Art-Picture-galerie-B.png',__FILE__); ?>"width="149" height="127">
</div>
 <br /><br />                      
<h2 class="warn"><span class="fa fa-gears"></span> Galerie <small>Settings</small></h2>                       
</div>
</div>
<div>
<div id="snackbar_error"></div>
<div id="snackbar-success"></div>
<!-- Tabs-Navs -->
<ul class="nav nav-tabs" role="tablist">
<li role="presentation" class=" active"><a href="#email" role="tab" data-toggle="tab">eMail Settings</a></li>
<li role="presentation"><a href="#galerieLicense" role="tab" data-toggle="tab">Galerie <b class="dan">Pro</b> License Key</a></li>    
<li role="presentation"><a href="#googlemaps" role="tab" data-toggle="tab">GoogleMaps API-Key</a></li>
<li role="presentation"><a href="#designSettings" role="tab" data-toggle="tab">WP Design</a></li>    
</ul>
<!-- Tab-Inhalte -->
<div id="imgSettingsForm">
<!-- Tab-Inhalte IMAGE-SETTINGS -->
<div class="tab-content">
<div role="tabpanel" class="tab-pane fade in active" id="email">
<br />
<hr class="hr-light">
<br />
<ul class="nav nav-tabs" role="tablist">
<li role="presentation"class=" active"><a href="#smtp" role="tab" data-toggle="tab">SMTP Settings</a></li>
<li role="presentation"><a href="#mailtxt" role="tab" data-toggle="tab">EMAIL Settings</a></li>
</ul>
<br />
<div class="tab-content">
<div role="tabpanel" class="tab-pane fade in active " id="smtp">
<div class="well"style="min-height: 400px;">
<h4 class="warn"><span class="fa fa-gears"></span> SMTP <small>Settings</small></h4>
<div class="row">
<!-----------------------------------------------------------------------------------GMAIL---------------------------------------------------->
<div class="col-md-8 col-md-offset-2 grey"style="border: 1px solid #ffe7bb;min-height: 300px;">
<br />
<fieldset id="email_aktiv" <?php echo htmlspecialchars($data['email_aktiv'] ); ?> >
<div id="image_settings"class="form-horizontal">
<div id="email_host" class="form-group" >
<label class="col-lg-4 control-label">SMTP Host: <a class="wptool" data-toggle="tooltip" title="<?php echo  $data['tt_smtp_host']; ?>"><span  class="prem fa fa-question-circle">   </span></a> </label>
<div class="col-xs-6 col-lg-6">
<input type="text" class="form-control" id="gmail_host"value="<?php echo htmlspecialchars($data['gmail_host'] ); ?>  "autocomplete="new-password"/>
<span id="host_feedback"  aria-hidden="true"></span>
<small id="host_message" class="dan"></small>    
    </div>
</div>
<div id="email_smtp" class="form-group" >
<label class="col-lg-4 control-label">SMTP Port: <a class="wptool" data-toggle="tooltip" title="<?php echo  $data['tt_smtp_port']; ?>"><span  class="prem fa fa-question-circle">   </span></a> </label>
<div class="col-xs-4 col-lg-4">
<input type="text" class="form-control" id="gmail_smtp"value="<?php echo htmlspecialchars($data['gmail_smtp'] ); ?>  "autocomplete="new-password"/>
<span id="smtp_feedback"  aria-hidden="true"></span>
<small id="smtp_message" class="dan"></small>  
</div>
</div>
<div id="email_SMTPSecure" class="form-group" >
<label class="col-lg-4 control-label">SMTP Secure: <a class="wptool" data-toggle="tooltip" title="<?php echo  $data['tt_gmail_SMTPSecure']; ?>"><span  class="prem fa fa-question-ircle">    </span></a> </label>
<div class="col-xs-4 co-lg-4">
<input type="text" class="form-control" id="gmail_SMTPSecure"value="<?php echo htmlspecialchars($data['gmail_SMTPSecure'] ); ?>  "autocomplete="new-password"/>
<span id="SMTPSecure_feedback"  aria-hidden="true"></span>
<small id="SMTPSecure_message" class="dan"></small> 
</div>
</div>
<div class="form-group">
<label class="col-lg-4 control-label">Authentifizierung:  <a class="wptool" data-toggle="tooltip" title="<?php echo $data['tt_authentication'] ; ?>"><span  class="prem fa fa-question-circle">    </span></a> </label>
<div class="col-lg-4">
<div class="checkbox">
<label>
<input type="checkbox" id="gmail_SMTPAuth" onClick="change_SMTPAuth();"  value="<?php echo htmlspecialchars($data['gmail_SMTPAuth'] ); ?>" /> ja
</label>
</div>
</div>
</div>
<div id="email_Username" class="form-group" >
<label class="col-lg-4 control-label">Benutzername: <a class="wptool" data-toggle="tooltip" title="<?php echo  $data['tt_smtp_Username']; ?>"><span  class="prem fa fa-question-circle">   </span></a> </label>
<div class="col-xs-6 col-lg-6">
<input type="text" class="form-control" id="gmail_Username"value="<?php echo htmlspecialchars($data['gmail_Username'] ); ?>  "autocomplete="new-password"/>
<span id="Username_feedback"  aria-hidden="true"></span>
<small id="Username_message" class="dan"></small> 
</div>
</div>
<div id="email_Password"  class="form-group" >
<label class="col-lg-4 control-label">Passwort: <a class="wptool" data-toggle="tooltip" title="<?php echo  $data['tt_smtp_Passwort']; ?>"><span  class="prem fa fa-question-circle">    </span></a> </label>
<div class="col-xs-6 col-lg-6">
<input type="password" class="form-control" placeholder="<?php echo htmlspecialchars($data['smtp_Password_placeholder']); ?>" id="gmail_Password"value=""autocomplete="new-password"/>
<span id="Password_feedback"  aria-hidden="true"></span>
<small id="Password_message" class="dan"></small>     
</div>
</div>
    <div class="form-group" >
<div class="col-md-4 col-md-offset-2">        
    <button class="btn btn-primary btn-outline" onClick="send_email_settings();"><span class="fa fa-save"> speichern</span></button>  
    </div>
    </div>  
</div><!--form-horizontal-->
</fieldset>
<br />
<div class="btn-group">
<button class="btn btn-success btn-outline btn-sm"onclick="load_smtp_check();" ><span class="fa fa-gear"></span> Einstellungen Testen</button>
<button class="btn btn-warning btn-outline btn-sm"onclick="load_mail_check();" ><span class="fa fa-envelope-o"></span> Test Email senden</button>
</div><!--btn-group-->
<br /><br />
</div><!--col-md-6-->
</div><!--row-->
</div><!--well-->
<?php $pro_txt='<div id="pro_version" class="col-md-12 text-center"> <div id="div2" class="divTimes">
                 In der <a role="button" class="prem" href="'.ART_PICTURE_SALE.'" target="_blank"><b class="grey">pro</b><b class="dan">Version</a></b> können Sie erstellten Benutzern automatisch eMails senden. </div> 
                <p><a role="button"  href="'.ART_PICTURE_SALE.'" target="_blank"><strong class="dan"> CLICK </strong></a>für die Vollversion der <b class="grey"><a class="warn" role="button" href="https://art-picturedesign.de/" target="_blank"><span class="grey fa fa-home "></span> Art</b><b class="grey">Picture Galerie</a></b></p> </div>'; 
if(empty($data['license_aktiv'])){
    echo $pro_txt;
}else{
    $pro_txt = '<b class="grey"><a class="warn" role="button" href="https://art-picturedesign.de/" target="_blank"><span class="grey glyphicon glyphicon-copyright-mark  "></span> Art</b><b class="grey">Picture Galerie</a></b> <b class="warn"> '.date('Y').'</b>';
    echo $pro_txt;
}    
?>
</div><!--tabpanel-->
<div role="tabpanel" class="tab-pane fade in " id="mailtxt">
<div class="modal fade" id="newMailVorlageModal" tabindex="-1" role="dialog" aria-labelledby="newMailVorlage" style="padding-top: 25px;" >
  <div class="modal-dialog" role="document" style="overflow-y: initial !important;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Schließen"><span aria-hidden="true">&times;</span></button>
        <h4 class="warn modal-title" id="beispielModalLabel"><span class="fa fa-gears"></span> neue <small> eMail Vorlage</small></h4>
      </div>
      <div class="modal-body" style="max-height: calc(100vh - 200px);overflow-y: auto;">
            
          <div class="form-group">
          <div class="col-md-8 col-md-offset-2">
            <label for="name-vorlage" class="control-label"style="color: grey;"><b class="warn">Name</b> der Vorlage:</label>
            
            <input type="text" class="form-control" id="new_email_vorlage">
          </div>
          <br /><br /><br />
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-outline" data-dismiss="modal"><span class="dan fa fa-times"></span> Schließen</button>
        <button type="button" class="btn btn-primary btn-outline "onclick="new_email_template();"><span class="fa fa-save"></span> Vorlage speicherm</button>
      </div>
    </div>
  </div>
</div>
<!--------------------------------------------------------------------TINYMCE------------------------------------------------>
<?php
include dirname(__DIR__).'/apg.class/tinymce/index.php';
?>
<!--------------------------------------------------------------------TINYMCE------------------------------------------------>  
<br />
<hr class="hr-footer">
<br /></b>
<br>
 <?php echo $pro_txt; ?>   
<br />
<br />
</div>
</div>
</div>
<div role="tabpanel" class="tab-pane fade in " id="image">
<br />
<div class="row">
<h2 class="prem">Image <small>settings</small> </h2>
<div class="col-lg-6">
<div id="image_settings"class="form-horizontal">
<div class="form-group">
<h4 class="warn">Image <small>Upload größe</small> </h4>
<label class="col-lg-4 control-label">medium max-width: <a class="wptool" data-toggle="tooltip" title="<?php echo $data['tt_upl_max_width_medium']; ?>"><span  class="prem fa fa-question-circle">    </span></a> </label>
<div class="col-xs-4 col-lg-3">
<input type="text" class="form-control" name="medium_max_width"value="<?php echo $data['medium_max_width']; ?>" autocomplete="new-password" />
</div>
</div>
<div class="form-group">
<label class="col-lg-4 control-label">medium max-height:  <a class="wptool" data-toggle="tooltip" title="<?php echo $data['tt_upl_max_height_medium'] ; ?>"><span  class="prem fa fa-question-circle">    </span></a> </label>
<div class=" col-xs-4 col-lg-3">
<input type="text" class="form-control" name="medium_max_height"value="<?php echo htmlspecialchars($data['medium_max_height']); ?>" autocomplete="new-password"  />
</div>
</div>
<div class="form-group">
<label class="col-lg-4 control-label">thumb max-width:  <a class="wptool" data-toggle="tooltip" title="<?php echo $data['tt_upl_max_width_thumb'] ; ?>"><span  class="prem fa fa-question-circle">    </span></a> </label>
<div class="col-xs-4 col-lg-3">
<input type="text" class="form-control" name="thumb_max_widht"value="<?php echo htmlspecialchars($data['thumb_max_width']); ?>" autocomplete="new-password"  />
</div>
</div>
</div>
</div><!-- EINS ENDE -->
 <div class="col-lg-6">
<div id="defaultForm"class="form-horizontal">
<div class="form-group">
<h4 class="warn">Image <small>Upload Settings</small> </h4>
<label class="col-lg-3 control-label">upload max filesize (mb):  <a class="wptool" data-toggle="tooltip" title="<?php echo $data['tt_img_size'] ; ?>"><span  class="prem fa fa-question-circle">    </span></a> </label>
<div class="col-xs-4 col-lg-3">
<input type="text"class="form-control" name="max_size"value="<?php echo htmlspecialchars($data['max_size']); ?>" autocomplete="new-password" />
</div>
</div>
  <!--   
<div class="form-group">
<label class="col-lg-3 control-label">post_max_size:  <a class="wptool" data-toggle="tooltip" title="<?php //echo $data['tt_post_max_size'] ; ?>"><span  class="prem fa fa-question-circle">    </span></a> </label>
<div class="col-xs-4 col-lg-3">
<input type="text"class="form-control" name="post_max_size"value="<?php //echo htmlspecialchars($data['post_max_size']); ?>" autocomplete="new-password" />
</div>
</div>    
<div class="form-group">
<label class="col-lg-3 control-label">memory_limit:  <a class="wptool" data-toggle="tooltip" title="<?php //echo $data['tt_post_memory_limit'] ; ?>"><span  class="prem fa fa-question-circle">    </span></a> </label>
<div class="col-xs-4 col-lg-3">
<input type="text"class="form-control" name="post_memory_limit"value="<?php //echo htmlspecialchars($data['post_memory_limit']); ?>" autocomplete="new-password" />
</div>
</div>  
 -->   
<div class="form-group">
<label class="col-lg-3 control-label">correct-image-extensions:  <a class="wptool" data-toggle="tooltip" title="<?php echo $data['tt_image_extensions'] ; ?>"><span  class="prem fa fa-question-circle">    </span></a> </label>
<div class="col-lg-3">
<div class="radio">
<label>
<input type="radio" name="image_extensions" value="1" onclick="RadioClick(this,'image_extensions')" <?php echo htmlspecialchars($data['image_extensions_check1']); ?>/> ja
</label>
</div>
<div class="radio">
<label>
<input type="radio" name="image_extensions" value="2" onclick="RadioClick(this,'image_extensions')" <?php echo htmlspecialchars($data['image_extensions_check2']); ?> /> nein
</label>
</div>
</div>
</div>
<fieldset>
<div class="form-group">
<label class="col-lg-3 control-label">max-height:   <a class="wptool" data-toggle="tooltip" title="<?php echo $data['tt_extens_max_height']; ?>"><span  class="prem fa fa-question-circle">    </span></a> </label>
<div class="col-xs-4 col-lg-3">
<input type="text" class="form-control" name="extens_max_height"value="<?php echo htmlspecialchars($data['max_height']); ?>" autocomplete="new-password"placeholder="<?php echo $data['max_height_placeholder']; ?>" />
</div>
</div>
<div class="form-group">
<label class="col-lg-3 control-label">max-width:  <a class="wptool" data-toggle="tooltip" title="<?php echo $data['tt_extens_max_widht']; ?>"><span  class="prem fa fa-question-circle">    </span></a> </label>
<div class="col-xs-4 col-lg-3">
<input type="text" class="form-control" name="extens_max_width"value="<?php echo htmlspecialchars($data['max_width']); ?>"  autocomplete="new-password" placeholder="<?php echo $data['max_width_placeholder']; ?>" />
</div>
</div>
<div class="form-group">
<label class="col-lg-3 control-label">min-height:  <a class="wptool" data-toggle="tooltip" title="<?php echo $data['tt_extens_min_height']; ?>"><span  class="prem fa fa-question-circle">    </span></a> </label>
<div class="col-xs-4 col-lg-3">
<input type="text" class="form-control" name="extens_min_height" value="<?php echo htmlspecialchars($data['min_height']); ?>"autocomplete="new-password" />
</div>
</div>
<div class="form-group">
<label class="col-lg-3 control-label">min-width:  <a class="wptool" data-toggle="tooltip" title="<?php echo $data['tt_extens_min_widht']; ?>"><span  class="prem fa fa-question-circle">    </span></a> </label>
<div class="col-xs-4 col-lg-3">
<input type="text" class="form-control" name="extens_min_width"value="<?php echo htmlspecialchars($data['min_width']); ?>" autocomplete="new-password" />
</div>
</div>
</fieldset>
</div>
</div><!-- ZWEI ENDE -->
</div> <!-- ROW -->
</div> <!-- Tab-IMAGE SETTINGS ENDE -->
<!-- Tab-Inhalte SYSTEM-SETTINGS START-->
<div role="tabpanel" class="tab-pane" id="system">
<br />
<div class="row">
<h2 class="prem">System <small>Settings</small> </h2>
<div class="col-lg-6">
<div id="upload-settings"class="form-horizontal">
<div class="form-group">
<h4 class="warn">Image <small>library </small> </h4>
<label class="col-lg-3 control-label">Image library  <a class="wptool" data-toggle="tooltip" title="<?php echo $data['tt_library']; ?>"><span  class="prem fa fa-question-circle"> </span></a> </label>
<div class="col-lg-4">
<select class="form-control"name="image_library" id="imagelibrary" onchange="fieldsetFunction('imagelibrary')">
<option>...</option>
<?php echo $data['sel_library']; ?>
</select>
</div>
</div>
<fieldset id="fieldset_imagick" <?php echo $data['disabled_imagick']; ?>>
<div class="form-group">
<h4 class="warn">Convert <small>binary </small> </h4>
<label class="col-lg-3 control-label">convert-bin: <a class="wptool" data-toggle="tooltip" title="<?php echo $data['tt_convert_bin']; ?>"><span  class="prem fa fa-question-circle">   </span></a> </label>
<div class="col-lg-3">
<input type="text" class="form-control" name="convert_bin"value="<?php echo htmlspecialchars($data['convert_bin']); ?>" autocomplete="new-password " />
</div>
</div>
<div class="form-group">
<label class="col-lg-3 control-label">identify-bin:   <a class="wptool" data-toggle="tooltip" title="<?php echo $data['tt_identify_bin']; ?>"><span  class="prem fa fa-question-circle">    </span></a> </label>
<div class="col-lg-3">
<input type="text" class="form-control" name="identify_bin"value="<?php echo htmlspecialchars($data['identify_bin']); ?>" autocomplete="new-password" />
</div>
</div>
<div class="form-group">
<h4 class="warn">Convert <small>parameter </small> </h4>
<label class="col-lg-3 control-label">limit memory:   <a class="wptool" data-toggle="tooltip" title="<?php echo $data['tt_limit_memory']; ?>"><span  class="prem fa fa-question-circle">    </span></a> </label>
<div class="col-lg-3">
<input type="text" class="form-control" name="limit_memory"value="<?php echo htmlspecialchars($data['limit_memory']); ?>" autocomplete="new-password" />
</div>
</div>
<div class="form-group">
<label class="col-lg-3 control-label">limit map: <a class="wptool" data-toggle="tooltip" title="<?php echo $data['tt_limit_map']; ?>"><span  class="prem fa fa-question-circle">    </span></a> </label>
<div class="col-lg-3">
<input type="text" class="form-control" name="limit_map"value="<?php echo htmlspecialchars($data['limit_map']); ?>" autocomplete="new-password" />
</div>
</div>
</fieldset>
</div>
</div><!-- EINS ENDE -->
<div class="col-lg-6">
<div id="pagination_settings"class="form-horizontal">
<div class="form-group">
<h4 class="warn">Pagination <small> Settings</small> </h4>
<label class="col-lg-4 control-label">Pagination anzeigen:   <a class="wptool" data-toggle="tooltip" title="<?php echo $data['tt_pag_anzeige']; ?>"><span  class="prem fa fa-question-circle">    </span></a> </label>
<div class="col-lg-4">
<label>
<input type="radio" name="pagination_aktiv"  value="1" onclick="RadioClick(this,'pagination_aktiv')" <?php echo htmlspecialchars($data['pag_check1']); ?>> ja
</label>
<label>
<input type="radio" name="pagination_aktiv" value="2"onclick="RadioClick(this,'pagination_aktiv')" <?php echo htmlspecialchars($data['pag_check2']); ?>> nein
</label>
</div>
</div>
<fieldset id="pagination_aktiv" <?php echo htmlspecialchars($data['disabled_pagination']); ?>>
<div class="form-group">
<label class="col-lg-4 control-label">Pagination größe:   <a class="wptool" data-toggle="tooltip" title="<?php echo $data['tt_pag_size']; ?>"><span  class="prem fa fa-question-circle">    </span></a> </label>
<div class="col-lg-4">
<select class="form-control" name="pag_size">
<option >...</option>
<?php echo $data['sel_pag_class'];  ?>
</select>
</div>
</div>
<div class="form-group">
<label class="col-lg-4 control-label">erste Seite anzahl:  <a class="wptool" data-toggle="tooltip" title="<?php echo $data['tt_pag_anzahl_start']; ?>"><span  class="prem fa fa-question-circle">    </span></a> </label>
<div class="col-lg-3">
<select class="form-control" name="anzahl_pag_start">
<option>...</option>
<?php echo $data['sel_start_limit']; ?>
</select>
</div>
</div>
</fieldset>
</div>
</div><!-- ZWEI ENDE -->
</div> <!-- ROW -->
</div>  <!-- Tab-Inhalte SYSTEM-SETTINGS ENDE-->
<div role="tabpanel" class="tab-pane" id="googlemaps"style="min-height: 450px;">
<br />
<!-- Tab-Inhalte GOOGLEMAPS-->
<h2 class="prem">Google <small>Maps: API-Key  <a class="wptool" data-toggle="tooltip" title="<?php echo $data['tt_htaccess']; ?>"><span  class="prem fa fa-question-circle">    </span></a> </small> </h2>
<div class="col-md-6 col-md-offset-3"style="padding-top:100px;">
  <div class="form-group">
       <div class="input-group">
      <div class="input-group-addon"><span class="prem fa fa-hand-o-right"></span> Key</div>
      <input type="text" class="form-control" id="google_api_key" value="<?php echo $data['google_maps_api_key']; ?>" placeholder="Google Maps API-Key">
    </div>
  </div>
  <button type="button" class="btn btn-primary btn-outline"onclick="google_maps_api();"><span class="fa fa-save"></span> Key speichern</button>
<div style="margin-top: 120px;"></div>
 <span class="prem fa fa-question-circle fa-2x"></span>&nbsp;<b class="grey">Hier (</span><a href="https://developers.google.com/maps/documentation/javascript/get-api-key?hl=de#key" target="_blank"><b class="prem"> Schlüssel für die Standard-API</a></b>) finden Sie eine Anleitung wie Sie einen Standard GoogleMaps apiKey anlegen.</b>
</div>
</div> <!-- TABINHALT SICHERT ENDE -->
<div role="tabpanel" class="tab-pane" id="galerieLicense" style="min-height: 450px;">
    <!--------------------------------------------PRO-License--------------------------------------------------------------------->
    <h3 style="color: #777;">Art Picture Galerie <span class="dan">Pro</span> License Key</h3>
&nbsp;
<hr class="hr-light">
    <br>
<p class="text-center">
    <b class="warn fa fa-arrow-right "></b> <b class="prem">Bitte</b> geben SIe ihre Daten ein. Der <b class="grey">License KEY</b> und die <b class="grey">Bestell ID</b>, haben Sie nach dem Kauf per E-Mail erhalten.<br>
    Bei <b class="grey">Problemen</b> wenden Sie sich bitte an den Art-Picture Galerie <a href="mailto:support@art-picturedesign.de"><b>SUPPORT</b></a>.
</p><br>
<?php
   if(empty($data['license_aktiv'])) {
    $lic_txt='<small class="dan"> nicht aktiv</small>'; 
   }else{
    $lic_txt='<small class="suss"> aktiv</small>';
   }
    ?>
    <h4  class="prem">License:<span id="license_status"> <?php echo $lic_txt; ?></span></h4>    
<hr class="hr-light">
<br>    
<div class="row">
<div class="col-md-5 col-md-offset-3">
<div class="login-panel panel panel-default">
<div class="panel-heading">
<h3 class="panel-title warn"><span class="grey fa fa-gears "></span> Art-Picture Galerie <b class="dan">Pro</b> License Key</h3>
</div>
<div id="key_response"></div>   
<div class="panel-body">
<fieldset>
<div class="form-group"><input class="form-control" type="text" id="orderid" autocomplete="new-password" name="orderid"  value="<?php echo $data['order_id']; ?>" autofocus placeholder="Bestell ID:" required ></div>
<div class="form-group"><input class="form-control" type="text" id="license_key" autocomplete="new-password" name="license_key" value="<?php echo $data['license_key']; ?>" placeholder="License KEY:" required></div>
<button class="btn btn-outline btn-warning" onClick="validate_key();"><span class="grey fa fa-gears"></span> Speichen</button></fieldset>
</div>
</div>
</div>
</div>
<hr />
</div>
  <!-----------------------------------------------------------------------------------WP-SETTINGS START---------------------------------------------------->  
<div role="tabpanel" class="tab-pane" id="designSettings" style="min-height: 450px;">
<div class="well"style="min-height: 400px;">
<h4 class="warn"><span class="fa fa-gears"></span> Wordpress <small>Design Settings</small></h4>
<div class="row">

<div class="col-md-8 col-md-offset-2 grey"style="border: 1px solid #ffe7bb;min-height: 380px;">
<br />

<div id="image_settings"class="form-horizontal">
    
<div class="form-group">
<label class="col-lg-4 control-label">Bootstrap-CSS aktiv:  <a class="wptool" data-toggle="tooltip" title="<?php echo $data['tt_wp_settings_bootstrap_css'] ; ?>"><span  class="prem fa fa-question-circle">    </span></a> </label>
<div class="col-lg-4">
<div class="checkbox">
<label>
<input type="checkbox" id="wp_settings_bootstrap_css" onClick="change_wp_settings_bootstrap_css();"  value="<?php echo htmlspecialchars($data['wp_settings_bootstrap_css'] ); ?>" /> ja
</label>
</div>
</div>
</div>     
    
<div class="form-group">
<label class="col-lg-4 control-label">Bootstrap-Javascript aktiv:  <a class="wptool" data-toggle="tooltip" title="<?php echo $data['tt_wp_settings_bootstrap_js'] ; ?>"><span  class="prem fa fa-question-circle">    </span></a> </label>
<div class="col-lg-4">
<div class="checkbox">
<label>
<input type="checkbox" id="wp_settings_bootstrap_js" onClick="change_wp_settings_bootstrap_js();"  value="<?php echo htmlspecialchars($data['wp_settings_bootstrap_js'] ); ?>" /> ja
</label>
</div>
</div>
</div>  
<div class="form-group">
<label class="col-lg-4 control-label">Javascript Galerie aktiv:  <a class="wptool" data-toggle="tooltip" title="<?php echo $data['tt_wp_galerie_js'] ; ?>"><span  class="prem fa fa-question-circle">    </span></a> </label>
<div class="col-lg-4">
<div class="checkbox">
<label>
<input type="checkbox" id="wp_galerie_js" onClick="change_wp_galerie_js();"  value="<?php echo htmlspecialchars($data['wp_galerie_js'] ); ?>" /> ja
</label>
</div>
</div>
</div> 
    
    
    
<div class="form-group">
<label class="col-lg-4 control-label">Bild-Details:  <a class="wptool" data-toggle="tooltip" title="<?php echo $data['tt_Bilddetails'] ; ?>"><span  class="prem fa fa-question-circle">    </span></a> </label>
<div class="col-lg-4">
<div class="checkbox">
<label>
<input type="checkbox" id="wp_settings_img_details" onClick="change_settings_img_details();"  value="<?php echo htmlspecialchars($data['wp_settings_img_details'] ); ?>" /> ja
</label>
</div>
</div>
</div>    
 
<div id="settings_header" class="form-group" >
<label class="col-lg-4 control-label">Bild Dtails Image: <a class="wptool" data-toggle="tooltip" title="<?php echo  $data['tt_header_box']; ?>"><span  class="prem fa fa-question-circle">    </span></a> </label>
<div class="col-xs-8 co-lg-8">
<input type="text" class="form-control" id="header_box"value="<?php echo htmlspecialchars($data['header_box'] ); ?>  "autocomplete="new-password"/>
</div>
</div>    
    
<div id="settings_padding_top" class="form-group" >
<label class="col-lg-4 control-label">Padding Top: <a class="wptool" data-toggle="tooltip" title="<?php echo  $data['tt_padding_top']; ?>"><span  class="prem fa fa-question-circle">    </span></a> </label>
<div class="col-xs-4 co-lg-4">
<input type="text" class="form-control" id="padding_top"value="<?php echo htmlspecialchars($data['padding_top'] ); ?>  "autocomplete="new-password"/>
</div>
</div>
    
<div id="settings_padding_bottom" class="form-group" >
<label class="col-lg-4 control-label">Padding Bottom: <a class="wptool" data-toggle="tooltip" title="<?php echo  $data['tt_padding_bottom']; ?>"><span  class="prem fa fa-question-circle">    </span></a> </label>
<div class="col-xs-4 co-lg-4">
<input type="text" class="form-control" id="padding_bottom"value="<?php echo htmlspecialchars($data['padding_bottom'] ); ?>  "autocomplete="new-password"/>
</div>
</div>      

<div id="background_color" class="form-group" >
<label class="col-lg-4 control-label">Details Site Background-Color <a class="wptool" data-toggle="tooltip" title="<?php echo  $data['tt_site_background_color']; ?>"><span  class="prem fa fa-question-circle">    </span></a> </label>
<div class="col-xs-4 co-lg-4">
<input type="text" class="form-control" id="site_background_color"value="<?php echo htmlspecialchars($data['site_background_color'] ); ?>  "autocomplete="new-password"/>
</div>
</div>  
    
<div id="box-background_color" class="form-group" >
<label class="col-lg-4 control-label">Details Box Background-Color <a class="wptool" data-toggle="tooltip" title="<?php echo  $data['tt_box_background_color']; ?>"><span  class="prem fa fa-question-circle">    </span></a> </label>
<div class="col-xs-4 co-lg-4">
<input type="text" class="form-control" id="box_background_color"value="<?php echo htmlspecialchars($data['box_background_color'] ); ?>  "autocomplete="new-password"/>
</div>
</div>     
<div class="form-group" >
<div class="col-md-4 col-md-offset-2">        
    <button class="btn btn-primary btn-outline" onClick="send_design_settings();"><span class="fa fa-save"> speichern</span></button>  
    </div>
    </div>  
</div><!--form-horizontal-->

<br />

</div><!--col-md-6-->
</div><!--row-->
</div><!--well-->
<!---------------------------------ENDE WP-DESIGN --------------------------------------------->    
    </div>    
</div>
</div> <!-- Tab-Inhalte -->
</div>
<div style="padding-top:30px ;"></div>
<br /><br />
<p><strong class="dan">default </strong> Settings laden.. </p>
<button class="btn btn-danger btn-sm"id="load_defaults" name="resetSettings"onclick="load_reset_modal('load_reset_modal');">alle Settings zurücksetzen</button>
<br /><br />
<div id="snackbar_error"></div>
<div id="snackbar-success"></div>
<div id="snackbar-warning"></div>
<hr class="hr-footer">
<div id="testausgabe"></div>
<div id="load_modal"></div>
</div>