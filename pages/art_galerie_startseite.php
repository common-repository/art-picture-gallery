<?php
/**
 * ArtPicture Plugin PHP Class
 * http://art-pictureDesign.de/WP-ArtTheme-Galerie
 * Copyright 2017, Jens Wiecker
 * https://art-picturedesign.de
 *
 */
require_once (dirname(__DIR__).'/apg.class/db/class_db_handle.php');
require_once (dirname(__DIR__).'/apg.class/ApgSettings.php');
require_once (dirname(__DIR__).'/apg.class/artPictureApi.php');
use  APG\ArtPictureGallery\DbHandle as DbHandle;    
use  APG\ArtPictureGallery\ApgSettings as ApgSettings;
$settings = ApgSettings::load_settings('user_settings');
APG\ArtPictureGallery\validate_api_key();
apg_gallery_header();
?>
 <br>
   <section>
 <hr class="hr-light">
 <br>
 <div id="galerie_details"></div>
 <span id="loaded_galerie"></span>
 <input type="hidden" id="galerie_typ" name="galerie_type" value="galerieLoad" >
 <div id="galerie_template_all">
 <div class="galerie-header"><!--BEGINN MENU-->
 <nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Navigation ein-/ausblenden</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <span class="navbar-brand font-inaktiv"style="margin-top: 5px;">
      <div class ="row"><h4>&nbsp;&nbsp;&nbsp;&nbsp;<small class="prem">Grid</small> 
      <i id="grid" class="prem fa fa-th" role="button"onclick="galerietyp('galerieLoad')"></i> 
      <i id="details" class="font-inaktiv fa fa-th-list"role="button"onclick="galerietyp('galerieLoadDetails');"></i>
      <small class="prem"> Liste</small></h4></div>
       </span>
       </div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <div class="navbar-form navbar-left" role="select">
        <div class="form-group"style="margin-top:5px ;">
             <select id="select_galerie" class="form-control" name="art_galerie_select"></select>   
                 
            <small><i class="warn fa fa-folder-open-o"></i> <b class="warn">Galerie</b> <b class="prem"> wählen</b></small>&nbsp;&nbsp;
        </div>
      </div>
      <ul class="nav navbar-nav navbar-right">
      <span id="create_button"></span>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
  </nav>
  </div><!--ENDE MENU-->
  <hr class="hr-light">
  <br>
  <div class="col-lg-12  col-md-12  col-sm-12 col-xs-12">
  <div class="row">
  <div class="col-md-10 col-md-offset-1">
    <ul id="template_pagination-up"  class="pagination pagination-sm"> </ul>    

 <!-- <span id="template_pagination-up" class="sel_pagination-up"></span>-->
  <span id="template_galerie"></span>
  <span id="template_startseite"></span>
  </div>
  </div>
  <hr>
  </div>
  </div><!--ID-galerie_template_all-->
  <br/><br />
  <!-- The blueimp Gallery widget -->
  <div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-filter="">
  <div class="slides"></div>
  <h3 class="title"></h3>
  <a class="prev">‹</a>
  <a class="next">›</a>
  <a class="close">×</a>
  <a class="play-pause"></a>
  <ol class="indicator"></ol>
  </div>
  <div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-filter="details">
  <div class="slides"></div>
  <h3 class="title"></h3>
  <a class="prev">‹</a>
  <a class="next">›</a>
  <a class="close">×</a>
  <a class="play-pause"></a>
  <ol class="indicator"></ol>
  </div>
  </section>
  <div id="exif_details_modal"></div>
  <p class="text-right" id="no_images"></p>
  <div id="snackbar_error"></div>
  <div id="snackbar-success"></div>
  <div id="snackbar-warning"></div>
  </div><!--container-->
  <div class="container"style="background-color: #f5f5f5;">
  <footer id="footer">
  <div class="container">
  <p class="text-muted"><span class="warn"><b> Art</b></span><b>Picture Galerie </b></p>
  </div>
  </footer>
  <input type="hidden"id="loaded_page"value="startseite"> 
  <div id="app"></div>
  <div class="modal" id="exifDetailsModal" tabindex="-1" role="dialog" aria-labelledby="meinModalLabel"data-backdrop="" style="padding-top: 5px;">
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
<div class="modal fade" id="GalerieModal" tabindex="-1" role="dialog" aria-labelledby="GalerieModalLabel"data-backdrop="" style="padding-top: 45px;">
  <div class="modal-dialog" role="document" style="overflow-y: initial !important;">
    <div  id="dialog" class="modal-content">

      <div class="modal-header">
        <button type="button" id="GalerieModalClose" class="close" data-dismiss="modal" aria-label="Schließen"><span aria-hidden="true">&times;</span></button>
        <span class="modal-title" id="modal_titel"></span>
       
      </div>
      <div class="modal-body"id="modal_body" style="max-height: calc(100vh - 200px);overflow-y: auto;">
      
      </div>
    <a href="<?php echo ART_PICTURE_URL; ?>" target="_blank">  <small><b class="warn"style="padding-left: 15px;"><i class="fa fa-home"></i> artPicture</b>Galerie </a><?php echo date('Y') ?></small>
      <div class="modal-footer">
      <span id="modal_btn"></span>
       <button id="exit" type="button" class="btn btn-default" data-dismiss="modal"><i class="dan fa fa-times"></i> abbrechen</button>
    
      </div>
    </div>
  </div>
</div>
<?php      
 apg_gallery_footer();    
?>      