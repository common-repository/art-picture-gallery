<?php
/**
 * ArtPicture Plugin PHP Class
 * http://art-pictureDesign.de/WP-ArtTheme-Galerie
 * Copyright 2017, Jens Wiecker
 * https://art-picturedesign.de
 *
 */
@session_start();
if ( ! defined( 'ABSPATH' ) ) exit;
$sessionID = strtoupper(md5(@session_id()));
if(isset($_SESSION['login']) && $_SESSION["login"] == "12067101" && $_SESSION['SID'] == $sessionID ){
include('header-sites.php');
wp_logout();    
require_once('templates.class.php');
$freigaben = apg_art_piture_gallery_freigaben();
require_once (dirname(dirname(__DIR__)).'/ApgSettings.php');
$settings = APG\ArtPictureGallery\ApgSettings::load_settings('user_settings');    
 ?>
<div class="container">
<div class="modal" id="exifDetailsModal" tabindex="-1" role="dialog" aria-labelledby="meinModalLabel">
  <div class="modal-dialog" role="document" style="overflow-y: initial !important;">
    <div class="modal-content modal-lg">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Schließen"><span aria-hidden="true">&times;</span></button>
        <div class="modal-title" id="modal_titel_lg">
        </div>
      </div>
      <div class="modal-body"id="modal_body_lg" style="max-height: calc(100vh - 200px);overflow-y: auto;">
      </div>
      <div id="modal_lg_btn" class="modal-footer">
        <button type="button" class="btn btn-success btn-outline" data-dismiss="modal"><i class="fa fa-thumbs-up"></i> Schließen</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="GalerieModal" tabindex="-1" role="dialog" aria-labelledby="GalerieModalLabel" data-backdrop="">
  <div class="modal-dialog" role="document" style="overflow-y: initial !important;"> 
    <div  id="dialog" class="modal-content">
      <div class="modal-header">
        <button type="button" id="GalerieModalClose" class="close" data-dismiss="modal" aria-label="Schließen"><span aria-hidden="true">&times;</span></button>
        <span class="modal-title" id="modal_titel"></span> 
      </div>
      <div class="modal-body"id="modal_body"  style="max-height: calc(100vh - 200px);overflow-y: auto;"> 
      </div>
      <small><a class="grey" role="button" href="https://art-picturedesign.de" target="_blank"> <b class="warn"style="padding-left: 15px;"><i class="fa fa-home"></i> art</b><b lass="grey">PictureDesign</b></a> </small>
      <div class="modal-footer">
      <span id="modal_btn"></span>
       <button id="exit" type="button" class="btn btn-default" data-dismiss="modal"><i class="dan fa fa-times"></i> abbrechen</button>
     </div>
    </div>
  </div>
</div>
<?php
echo $freigaben['freigabenHeader'];    
echo $freigaben['details']; 
?>
<div id="template_freigaben">    
<?php    
echo $freigaben['freigaben'];
?>
</div>    
<?php    
echo $freigaben['freigaben_footer'];    
?>    
<div class="col-sm-12 col-md-9 col-md-offset-1  col-ld-8 col-lg-offset-2">
<div class="container">    
 <span id="loaded_galerie"></span>
 <input type="hidden" id="galerie_typ" name="galerie_type" value="" >
 
<span id="template_pagination-up" class="sel_pagination-up">
</span>
<span id="template_galerie"></span>
<hr/>
    </div>    
</div>    
<div class="row"> 
<div class="col-md-12">    
<div class="container">
    <hr class="hr-light">
    <p><a class="grey" role="button" href="<?php echo ART_PICTURE_URL;?>" target="_blank"> <i class="grey glyphicon glyphicon-copyright-mark"></i><b class="warn">Art</b><b lass="grey">Picture Design <?php echo date('Y'); ?></b></a> </p>    
    </div>
    </div>
    </div> 
<div id="snackbar_error"></div>
<div id="snackbar-success"></div>
<div id="snackbar-warning"></div> 
<div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-filter="">
<div class="slides"></div>
<h3 class="title"></h3>
<a class="prev">‹</a>
<a class="next">›</a>
<a class="close">×</a>
<a class="play-pause"></a>
<ol class="indicator"></ol>
</div>    
</div><!--container-->    
  <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $settings['google_maps_api_key']; ?>&callback=initMap"></script>   
<?php
include('footer.php');
}else{
$extra = site_url().'?apg-user-gallery-template=12067102';
@header("Location: $extra");    
}
?>