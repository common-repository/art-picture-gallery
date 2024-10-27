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
<div style="min-height: 500px">
<div class="container">
<div id="select_template"></div>
</div><!--container-->
<?php
apg_bluemGallery_select();    
?>
</div>
<div class="container"style="padding-top: 25px;"> 
    <hr class="hr-light">
    <p><a class="grey" role="button" href="<?php echo ART_PICTURE_URL;  ?>" target="_blank"> <i class="grey glyphicon glyphicon-copyright-mark"></i><b class="warn">Art</b><b class="grey">Picture Design <?php echo date('Y'); ?></b></a> </p>    
    </div>
<?php
include('footer.php');
}else{
$extra = site_url().'?apg-user-gallery-template=12067102';
@header("Location: $extra");    
}
?>