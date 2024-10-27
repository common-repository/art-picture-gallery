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
<div style="min-height: 400px">
<div class="container">
<div id="messageTemplate"></div>
    </div><!--container-->
</div>  
<div class="container">
    <hr class="hr-light">
    <p><a class="grey" role="button" href="<?php echo ART_PICTURE_URL;?>" target="_blank"> <i class="grey glyphicon glyphicon-copyright-mark"></i><b class="warn">Art</b><b class="grey">Picture Design <?php echo date('Y'); ?></b></a> </p>    
    </div>
<div id="snackbar_error"></div>
<div id="snackbar-success"></div>
<div id="snackbar-warning"></div> 
<script>
$("#template_message").addClass('active')    
$("#sites_header").html('<div style="padding-left:150px;"><h3 class="grey text-center"> ' +
                        '<b><span class="warn">Art</span>-Picture Gallery <span class="warn">Freigaben</span>.</b></h3>'+ 
                         '<p><b class="warn">Ihre</b><b class="grey"> Galerie Freigaben!</b></p><br /><br /></div>')    
</script>
<?php
include('footer.php');
}
?>