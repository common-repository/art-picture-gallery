<?php
/**
 * ArtPicture Plugin PHP Class
 * http://art-pictureDesign.de/WP-ArtTheme-Galerie
 * Copyright 2017, Jens Wiecker
 * https://art-picturedesign.de
 *
 */
if ( ! defined( 'ABSPATH' ) ) exit; 
add_action('apg_gallery_header', 'apg_header_function', 1);
function apg_gallery_header() {
     do_action('apg_gallery_header');
 }
add_action('apg_gallery_footer', 'apg_footer_function', 1);
function apg_gallery_footer() {
     do_action('apg_gallery_footer');
 }
add_action('apg_benutzer_page', 'apg_benutzer_page_function', 1);
function apg_benutzer_page() {
     do_action('apg_benutzer_page');
 }
add_action('apg_response_page', 'apg_response_page_function', 1);
function apg_response_page() {
     do_action('apg_response_page');
 }
add_action('apg_bluemGallery_select', 'apg_bluemGallery_select_function', 1);
function apg_bluemGallery_select() {
     do_action('apg_bluemGallery_select');
 }
/////////////////////////////////////////////////////////////////////////////////HOOKS////////////////////////////////////////////////////////////////
////////////////////////////////////////HEADER////////////////////////////////////////////////////
function apg_header_function(){
    require_once(dirname(__DIR__).'/apg.class/ApgSettings.php');
    $settings = APG\ArtPictureGallery\ApgSettings::load_settings('user_settings');
    if(empty($settings['license_aktiv'])){
    $header_txt=' <div class="col-md-2"><a href="'.ART_PICTURE_SALE.'"target="_blank"><img src="'.plugins_url('../assets/images/galerie-pro/verpackung-frei-small.png',__FILE__).'" class="img-responsive"     height="128" width="89"></a> </div> <br><br> <b class="text-center"style="font-size: 16px;"><b class="grey"> In der <u><a href="'.ART_PICTURE_SALE.'"target="_blank"><b class="dan">Pro</b><b class="prem">Version</b></a></u> haben Sie 
    unzählige Einsstellmöglichkeiten
    Ihrer Galerie-Freigaben.<br><br>
    </b></b>'; 
    }
    $header_txt = preg_replace(array('/<!--(.*)-->/Uis',"/[[:blank:]]+/"),array('',' '),str_replace(array("\n","\r","\t"),'',$header_txt)); 
    $header = '<div class="bootstrap-wrapper">
          <div class="container well"style="min-height: 850px;">
          <section>
          <div class="art-head">
          <div class="row">
          <div class="col-md-3">
          <img src="'.plugins_url('/../assets/images/Logo-Art-Picture-galerie-B.png',__FILE__).' "width="249" height="227"/>
          </div>
          <div class="col-md-8">
          <div class="alert alert-dismissible fade in"style="padding-top: 40px;"> 
          <hr class="hr-light">
          <br />
          <div class="h3 text-center" id="div2" class="divTimes " role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Schließen"><span aria-hidden="true"><b>×</b></span></button>
          <a href="'.ART_PICTURE_SALE.'"><b class="warn">Art</b><b class="grey">Picture</b></a><b class="grey"> Mehr als eine Galer<b class="warn">i</b>e!</b><br />
          </div>
          '.$header_txt.'  
          <b class="text-center"><b class=" grey">Falls Sie <b>Hilfe</b> benötigen, finden Sie <a href="admin.php?page=art-Picture-help"><b class="warn"> hier</b> </a> eine ausführliche Beschreibung einzelner Funtionen.
          </b></b>      
          <br />
          <hr class="hr-light">
          <br />
          </div>
          </div>
          </div>
          <h3><span class="warn">Galerie</span>  <small><strong id="header_title"></strong></small></h3>
		  <br/>
		  <div class="row">
		  <div id="galerie_header"></div>
          </div>
          </section>
          <br>'; 
      $header = preg_replace(array('/<!--(.*)-->/Uis',"/[[:blank:]]+/"),array('',' '),str_replace(array("\n","\r","\t"),'',$header));
      echo $header;    
}
///////////////////////////////////////////////////////FOOTER-STARTSEITE////////////////////////////////////////////////
function apg_footer_function(){
    echo '</div><!--Container-->
          </div><!--wrapper-->';
}
//////////////////////////////////////////////////////Benutzer-PAGE///////////////////////////////////////////
function apg_benutzer_page_function(){
    $modal_gallery = '<div class="bootstrap-wrapper">
    <div class="container well"style="height: 100%;">
    <div id="snackbar_error"></div>
    <div id="snackbar-success"></div>
    <div id="snackbar-warning"></div>
    <br />
    <div id="galerie_header"></div>
    <div id="err_message"></div>
    <div id="user_templates"></div>
    <div id="galerie_body"></div>
    <div id="new_user_template">
    </div>
<div class="container"style="background-color: #f5f5f5;">
<footer id="footer">
<div class="container">
<p class="text-muted"><span class="warn"><b> Art</b></span><b>Picture Galerie </b></p>
</div>
</footer>
</div><div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="GalerieModalLabel"data-backdrop="" style="padding-top: 45px;">
  <div class="modal-dialog" role="document">
    <div  id="dialog" class="modal-content">
      <div class="modal-header">
        <button type="button" id="GalerieModalClose" class="close" data-dismiss="modal" aria-label="Schließen"><span aria-hidden="true">&times;</span></button>
        <span class="modal-title" id="error_modal_titel"></span>
      </div>
      <div class="modal-body"id="error_modal_body"style="overflow: hidden;">
      </div>
      <small><b class="warn"style="padding-left: 15px;"><i class="fa fa-home"></i> artPicture</b>Galerie '.date('Y').'</small>
      <div class="modal-footer">
      <button id="error_exit" type="button" class="btn btn-default" data-dismiss="modal"><i class="dan fa fa-times"></i> Schließen</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="FreigabeModal" tabindex="-1" role="dialog" aria-labelledby="GalerieModalLabel"data-backdrop="" style="padding-top: 45px;">
  <div class="modal-dialog" role="document">
    <div  id="dialog" class="modal-content">
      <div class="modal-header">
        <button type="button" id="GalerieModalClose" class="close" data-dismiss="modal" aria-label="Schließen"><span aria-hidden="true">&times;</span></button>
        <span class="modal-title" id="modal_titel"></span>
      </div>
      <div class="modal-body"id="modal_body"style="overflow: hidden;">
      </div>
      <small><b class="warn"style="padding-left: 15px;"><i class="fa fa-home"></i> artPicture</b>Galerie  '.date('Y').'</small>
      <div class="modal-footer">
      <span id="modal_btn"></span>
       <button id="exit" type="button" class="btn btn-default" data-dismiss="modal"><i class="dan fa fa-times"></i> abbrechen</button>
      </div>
    </div>
  </div>
</div>
<div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-filter="">
<div class="slides"></div>
<h3 class="title"></h3>
<a class="prev">‹</a>
<a class="next">›</a>
<a class="close">×</a>
<a class="play-pause"></a>
<ol class="indicator"></ol>
</div>
</div></div>';
$modal_gallery = preg_replace(array('/<!--(.*)-->/Uis',"/[[:blank:]]+/"),array('',' '),str_replace(array("\n","\r","\t"),'',$modal_gallery)); 
echo $modal_gallery;    
}
/////////////////////////////////////////////////////////////RESPONSE_PAGE///////////////////////////////////////////////////////
function apg_response_page_function(){
$response_page='<div class="bootstrap-wrapper">
<div class="container well"style="height: 100%;">
<br />
<div id="galerie_header"></div>
<div id="err"></div>
<div id="user_template_close"></div>
<div id="user_template"></div>
<div id="snackbar_error"></div>
<div id="snackbar-success"></div>
<div id="snackbar-warning"></div>
</div>
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
<div class="container"style="background-color: #f5f5f5;">
        <footer id="footer">
        <div class="container">
        <p class="text-muted"><span class="warn"><b> Art</b></span><b>Picture Galerie </b></p>
        </div>
        </footer>
</div>
</div>';
$response_page = preg_replace(array('/<!--(.*)-->/Uis',"/[[:blank:]]+/"),array('',' '),str_replace(array("\n","\r","\t"),'',$response_page));
echo $response_page;    
}
function apg_bluemGallery_select_function(){
$return = '<div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-filter="">
<div class="slides"></div>
<h3 class="title"></h3>
<a class="prev">‹</a>
<a class="next">›</a>
<a class="close">×</a>
<a class="play-pause"></a>
</div>';
$return = preg_replace(array('/<!--(.*)-->/Uis',"/[[:blank:]]+/"),array('',' '),str_replace(array("\n","\r","\t"),'',$return));
    echo $return;
}
?>