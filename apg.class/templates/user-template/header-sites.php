<?php
/**
 * ArtPicture Plugin PHP Class
 * http://art-pictureDesign.de/WP-ArtTheme-Galerie
 * Copyright 2017, Jens Wiecker
 * https://art-picturedesign.de
 *
 */
if ( ! defined( 'ABSPATH' ) ) exit;
include('header.php');
?>
<section>
<div class="container">
<div class="row">    
<div class="col-md-3">
<a href="http://art-picturedesign.de"> <img src="<?php echo plugins_url('../../../assets/images/Logo-Art-Picture-galerie-B.png',__FILE__); ?>" width="249" height="227"></a>
</div>
<div class="col-md-7">
  <h1 class="text-center warn"style="padding-top: 55px;"><span class="grey fa fa-camera"></span> Art<span class="grey">Picture Galer<span class="warn">i</span>e</span></h1>
</div>
</div>    
<div class="col-md-12 text-center">
<div id="header_txt"></div>     
<br />
<hr class="hr-light">  
<div class="row">   
<div class="pull-right">
  | <span class="grey fa  fa-user"></span> <b class="warn"> <?php echo $_SESSION['name']; ?> </b> | <a class="grey" role="button" href="<?php echo site_url();?>?apg-user-gallery-emplate=12067104"> <span class="warn fa fa-sign-out"></span> <b class="grey"> logout</b></a> |
    <br><br>
    </div>
    <br>
    </div> 
 </div>
<ul class="nav nav-tabs">
  <li role="presentation" id="template_startseite"><a href="<?php echo site_url().'?apg-user-gallery-template=12067101';?>">Startseite</a></li>
  <li role="presentation" id="template_gallery"><a href="<?php echo site_url().'?apg-user-gallery-template=12067106';?>">meine Freigaben</a></li>    
  <li role="presentation" id="template_auswahl"><a href="<?php echo site_url().'?apg-user-gallery-template=12067107';?>">Bilder Auswahl</a></li>
  <li role="presentation" id="template_message"><a href="<?php echo site_url().'?apg-user-gallery-template=12067108';?>">Nachricht schreiben</a></li>
  <li role="presentation" id="template_help"><a href="<?php echo site_url().'?apg-user-gallery-template=12067105';?>">Hilfe</a></li>    
</ul>    
</div><!--container-->
</section>