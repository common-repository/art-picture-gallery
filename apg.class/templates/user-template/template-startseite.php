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
?>
<!--CONTENT-->
<div class="container ">
<div class="aktion_menue">
      <div class="row">
<div class="col-md-8 col-md-offset-2"style="min-height: 350px;">
<div class="table-responsive">
<table class="table text-center"> 
<tbody>
<tr class="apg_style">
<td class="apg_style">
<h4 class="warn">Freigaben<small> Übersicht</small></h4>
<hr class="hr-light">
<br>
<a  role="button" href="<?php echo site_url();?>?apg-user-gallery-template=12067106"> <span class="menue"><b class="warn fa fa-folder-open-o fa-2x"></b></span>
<b class="warn"><b style="color: #868686;">&nbsp; meine</b> Freigaben</b> </a>
<br><br>
<a  role="button"href="<?php echo site_url(); ?>?apg-user-gallery-template=12067107">
<span class="menue"><b class="warn fa fa-check-square-o fa-2x"></b></span>
<b class="warn"><b style="color: #868686;">&nbsp; gewählte</b> Bilder</b>
</a> <br><br> 
</td>
<td class="apg_style">
<h4 class="warn">Freigabe<small> Message</small></h4>
<hr class="hr-light">
<br>
<a role="button" href="<?php echo site_url(); ?>?apg-user-gallery-template=12067108">
<span class="menue"> <b class="warn fa fa-envelope-o fa-2x"></b></span>
<b class="warn"><b style="color: #868686;"> Nachricht</b> schreiben</b> </a>
<br><br>
<a  role="button" href="<?php echo site_url(); ?>?apg-user-gallery-template=12067105">
<span class="menue"><b class="warn fa fa-lightbulb-o fa-2x"></b></span>
<b class="warn"><b style="color: #868686;">Art-Galerie </b>
Hilfe</b> </a>
<br><br>
</td>
</tr>
<tr class="apg_style">
</tr>
</tbody>
</table>
</div>
</div>     
</div>
<div class="col-md-12">
    <hr class="hr-light">
    <p><a class="grey" role="button" href="<?php echo ART_PICTURE_URL;?>" target="_blank"> <i class="grey glyphicon glyphicon-copyright-mark"></i><b class="warn">Art</b><b class="grey">Picture Design <?php echo date('Y'); ?></b></a> </p>  
</div>    
</div>
<!--CONTENT-->    
</div><!--Container-->
<?php
include('footer.php');    
}else{
$extra = site_url().'?apg-user-gallery-template=12067102';
@header("Location: $extra");    
}
?>