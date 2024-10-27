<?php
/**
 * ArtPicture Plugin PHP Class
 * http://art-pictureDesign.de/WP-ArtTheme-Galerie
 * Copyright 2017, Jens Wiecker
 * https://art-picturedesign.de
 *
 */
$upload_dir = wp_upload_dir();
$img_dir = $upload_dir['basedir'];
$img_url = $upload_dir['baseurl'];
@session_start();
$_SESSION['UPLOAD_DIR'] = $img_dir.'/art-picture-gallery';
$_SESSION['UPLOAD_URL'] = $img_url.'/art-picture-gallery';
require_once(dirname(__DIR__).'/apg.class/ApgSettings.php');
use  APG\ArtPictureGallery\ApgSettings as ApgSettings;
       $settings = ApgSettings::load_settings('user_settings');
        if($settings['correct_image_extensions'] == '1'){
         $imageCrop = 1;   
        }else{
         $imageCrop =0;   
        }
        if(empty($settings['max_width'])){
          $maxWidht = 'null';  
        }else{
          $maxWidht = $settings['max_width'];  
        }
         if(empty($settings['max_height'])){
          $maxHeight = 'null';  
        }else{
          $maxHeight = $settings['max_height'];  
        }

        if(empty($settings['license_aktiv'])){
         $pro_txt='  <div class="alert alert-default alert-dismissible">
                     <button type="button" class="close" data-dismiss="alert" aria-label="Schließen"><span aria-hidden="true"><b>x</b></span></button>
                     <div class="col-md-1">
                     <a href="'. ART_PICTURE_SALE.'"target="_blank"><img src="'.plugins_url('../assets/images/galerie-pro/verpackung-frei-small.png',__FILE__).'" class="img-responsive" height="128" width="89"></a> </div>
                     <div class="col-md-7">
                     <br><br>
                     <b style="font-size: 16px;"><b class="grey"> In der <u><a href="'.ART_PICTURE_SALE.'" target="_blank"><b class="dan">Pro</b><b class="prem">Version</b></a></u> haben Sie unzählige Einsstellmöglichkeiten Ihrer Galerie-Freigaben.<br><br> </b></b> </div></div>';  
        $pro_txt = preg_replace(array('/<!--(.*)-->/Uis',"/[[:blank:]]+/"),array('',' '),str_replace(array("\n","\r","\t"),'',$pro_txt));      
        }else{
         $pro_txt='';    
        }
?>
<script>
var server = {
url:"<?php echo htmlspecialchars(plugins_url('../apg.class/file-upload/',__FILE__));?>",    
image_crop:"<?php echo $imageCrop;?>",
max_widht:"<?php echo $maxWidh;?>",
max_height:"<?php echo $maxHeight;?>",
};
</script>
<div class="bootstrap-wrapper">
<div class="container well">
    <h2 class="grey text-center"><span class="warn fa fa-camera"></span> File Upload</h2>
<div id="snackbar_error"></div>
<hr class="hr-light">
<br />
<div class="art-head">
<div class="row">    
<div class="col-md-3">
<canvas id="LogoCanvas"width="248" height="65">
</div>
<?php echo $pro_txt; ?>
<br> 
<div class="col-md-7 col-md-offset-4">
<p class="text-center"><div class="col-md-10"> <hr class="hr-light"></div><br><b class=" grey">Falls Sie <b>Hilfe</b> benötigen, finden Sie <a href="admin.php?page=art-Picture-help"><b class="warn"> hier</b> </a> eine ausführliche Beschreibung einzelner Funtionen.
 </b><div class="col-md-10"><br> <hr class="hr-light"></div></p> 
</div>
</div><!--row--> 
<br /><br /><br />
</div>
<br /><br />
<hr class="hr-light">
<h4 class="warn"><span class="prem fa fa-info-circle"></span>&nbsp; Wählen <small> Sie eine Galerie aus um Bilder hinzuzufügen oder erstellen Sie eine neue Galerie.</small></h4>
<hr class="hr-light">
<br />
<span id="error_upload"> </span>  
<br />
<div class="upload-startseite" >
<div class="inner-uploads-startseite">
<h2 class="text-center">
Galerie <span class="warn"> auswählen</span> oder <span class="warn">neu</span> erstellen.
</h2>
<p class="text-center">
<label id="select" class="title prem text-center">
<span>Gallery auswahl:</span><br>
 <span id="select_galerie"></span>
</label>
<label class="title prem text-center">
<span><b>neue Galerie erstellen:</b></span><br>
 <input type="text" class="form-control" name="new_galerie" value="" placeholder="Galerie Name"required>
</label>
<label class="title prem text-center">
<span>Gallery speichern:</span><br>
<button type="submit" class="btn btn-default btn-outline"onclick="new_galerie();"><i class="fa fa-save"></i>&nbsp; neue Galerie speichern</button>
</label>
</p><span id="no_galerie"></span>
</div>
</div>
<label class="title prem text-center">
<span id="label-text"></span><br>
<span id="select_galerie"></span>
</label>
<br /><br />
<form id="fileupload" action="<?php echo htmlspecialchars(plugins_url('../apg.class/file-upload/',__FILE__));?>" method="POST" enctype="multipart/form-data">
<span id="loaded_galerie"></span>
<span id ="err_msg"></span>
<span id="message_galerie_loaded"></span>
<br /><br />
<div class="row fileupload-buttonbar">
<div class="col-lg-7">
<span  class="btn btn-success btn-outline fileinput-button">
<i class="fa fa-plus"></i>
<span>Hinzufügen...</span>
<input id="input" type="file" name="files[]" multiple>
</span>
<button type="submit" class="btn btn-primary btn-outline start">
<i class="fa fa-upload"></i>
<span>Start upload</span>
</button>
<span id="button_bar">
<button type="reset" role="button" id="abbrechen" class="btn btn-warning btn-outline cancel">
<i class="fa fa-ban"></i>
<span>upload abbrechen</span>
</button>
</span>
<span class="fileupload-process"></span>
</div>
<div class="col-lg-5 fileupload-progress fade">
<div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
<div class="progress-bar progress-bar-success" style="width:0%;"></div>
</div>
<div class="progress-extended">&nbsp;</div>
</div>
<div class="upload-wrapper">
<div id="inner-wrapper" class="inner-upload">
<p class="drag_drop  text-center">
<span class="cloud fa fa-cloud-upload fa-3x"></span><br />
DRAG & DROP<br />
<small> oder </small></p>
<p class="text-center">
<span  class="btn btn-warning btn-outline fileinput-button">
<i class="fa fa-plus"></i><span>&nbsp; Datei hinzufügen</span>
<input id="input" type="file" name="files[]" multiple>
</span>
</p>
</div>
<table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>
</form>
<br>
<div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-filter=":even">
<div class="slides"></div>
<h3 class="title"></h3>
<a class="prev">‹</a>
<a class="next">›</a>
<a class="close">×</a>
<a class="play-pause"></a>
<ol class="indicator"></ol>
</div>
</div><!--UPLOAD-WRAPPER-->
</div>
<div class="footer">
      <div class="container">
          <p class="text-muted"><span class="grey  glyphicon glyphicon-copyright-mark"></span><a role="button" href="<?php echo ART_PICTURE_SALE; ?>" target="_blank"><b class="warn"><b> Art</b><b class="grey">Picture Galerie</a></b> <?php echo date('Y'); ?> </b></p>
      </div>
    </div>
<div id="snackbar"></div>
<span id="testImg"></span>
</div>
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
<tr class="template-upload fade">
<td>
<span class="preview"></span>
</td>
<td>
<p class="name">{%=file.name%}</p>
<strong class="error text-danger"></strong>
</td>
<td>
<p class="size">Processing...</p>
<div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
</td>
<td>
{% if (!i && !o.options.autoUpload) { %}
<button class="btn btn-primary start" disabled>
<i class="glyphicon glyphicon-upload"></i>
<span>Start</span>
</button>
{% } %}
{% if (!i) { %}
<button class="btn btn-warning cancel">
<i class="glyphicon glyphicon-ban-circle"></i>
<span>Cancel</span>
</button>
{% } %}
</td>
</tr>
{% } %}
</script>
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
<tr class="template-download fade">
<td>
<span class="preview">
{% if (file.thumbnailUrl) { %}
<a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
{% } %}
</span>
</td>
<td>
<p class="name">
{% if (file.url) { %}
<a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
{% } else { %}
<span>{%=file.name%}</span>
{% } %}
</p>
{% if (file.error) { %}
<div><span class="label label-danger">Error</span> {%=file.error%}</div>
{% } %}
</td>
<td>
<span class="size">{%=o.formatFileSize(file.size)%}</span>
</td>
<td>
{% if (file.deleteUrl) { %}
<h5 class="suss"><span class="fa fa-check"></span> Upload erfolgreich!</h5>
{% } else { %}
<button class="btn btn-warning cancel">
<i class="glyphicon glyphicon-ban-circle"></i>
<span>Cancel</span>
</button>
{% } %}
</td>
</tr>
{% } %}
</script>
<script>
    var canvas = document.getElementById('LogoCanvas');
    var context = canvas.getContext('2d');
    var imageObj = new Image();
    imageObj.onload = function() {
    context.drawImage(imageObj, 10, 10);
    };
    imageObj.src = '<?php  echo plugins_url('../assets/images/header_logo.png',__FILE__).''; ?>'; 
</script>
</div>