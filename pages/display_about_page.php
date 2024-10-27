<?php
/**
 * ArtPicture Plugin PHP Class
 * http://art-pictureDesign.de/WP-ArtTheme-Galerie
 * Copyright 2017, Jens Wiecker
 * https://art-picturedesign.de
 *
 */
?>
<div class="bootstrap-wrapper">
<div class="container well">
   <?php
$dir = ABSPATH.'APG-FILES/';
   if(!is_dir($dir)){
     $txt='Options -Indexes'; 
     $dirImg=$dir.'/img';
     $dirMed=$dir.'/medium';
     $dirThu=$dir.'/thumb';   
     mkdir ( $dirImg, 0750, true );
     mkdir ( $dirMed, 0750, true ); 
     mkdir ( $dirThu, 0750, true );
     $dh = fopen($dirImg.'/.htaccess', "w");
     fwrite($dh,$txt);
     fclose($dh); 
     $dh = fopen($dirMed.'/.htaccess', "w");
     fwrite($dh,$txt);
     fclose($dh);  
     $dh = fopen($dirThu.'/.htaccess', "w");
     fwrite($dh,$txt);
     fclose($dh);     
   } 
?> 
<h2 class="warn">ABOUT<i class="fa fa-home"></i> <small> Art Picture Gallery Plugin</small></h2>
<hr class="hr-footer">
<br /><br /><br />
<div class="col-md-12 col-xs-12">
    <div class="row">
<div class="col-md-3">
     <img class="img-responsive" src="<?php echo plugins_url('../assets/images/galerie-pro/Logo-Art-Picture-galerie-B.png',__FILE__); ?>">
</div>
    <div class="col-md-8"style="padding-top: 60px;">
    <h2> <small><span class="warn fa fa-arrow-right "></span> Wir wünschen Ihnen viel Spaß und Freude mit Art-Picture Gallery</small></h2>
        </div>
</div><!--row-->   
        <br><br>
        <p class="text-center"><b class="grey">Wenn Sie Fragen zu unserem Produkt haben oder Probleme bei der Verwendung auftreten,<br> kontaktieren Sie uns bitte unter: <a class="warn" role="button" href="mailto:support@art-picturedesign.de">support@art-picturedesign.de</a> oder über den <a class="warn" role="button" href="admin.php?page=art-Picture-help"> Support-Bereich.</a></b></p><br><br>
    <div class="row">
    <div class="col-sm-8 col-md-8 col-md-offset-4 col-sm-offset-4">
            <h4 class="grey">Kompatibilität:</h4>
            <img src="<?php echo plugins_url('../assets/images/galerie-pro/art-picture-logo2.png',__FILE__); ?>">&nbsp;&nbsp;
            <img src="<?php echo plugins_url('../assets/images/galerie-pro/wordpress-logo.png',__FILE__); ?>">&nbsp;&nbsp;
            <img src="<?php echo plugins_url('../assets/images/galerie-pro/php-logo.png',__FILE__); ?>">
            <br>
        <div class="col-md-5">
            <hr class="hr-light">
     </div><br>
            <p><br>
                <b class="grey"> <span class="warn">Art</span>-Picture Gallery ist vollständig <u class="warn"><span class="grey">kompatibel</span></u> und<br> getestet mit Wordpress-Version ab 4.8 , PHP 5.4, PHP 5.6 &amp; PHP 7.1 .</b>
            </p>
            <hr>
          </div>
        </div>
    <hr class="hr-light">
    <br>
    <td colspan="5" class="up-arrow-container">
        <h2 class="text-center"><span class="grey"><a role="button" class="grey" href="<?php echo ART_PICTURE_SALE; ?>" target="_blank"> Art-Piture Gallery <b class="dan">PRO</a></b></span></h2>
        <h3 class="warn text-center">Ein <span class="grey"> <u class="warn"><span class="grey">muss</span></u> für Fotografen und Veranstalter!</span> </h3>    
                <div class="bs-callout bs-callout-info">
                  <div class="row">
                    <div class="col-md-3 col-sm-3">
                     <a role="button" class="grey" href="<?php echo ART_PICTURE_SALE; ?>" target="_blank"> <img src="<?php echo plugins_url('../assets/images/galerie-pro/verpackung-frei-small.png',__FILE__); ?>" class="img-responsive" alt="Art-Picture Galerie"><br>
                         <em><small><b>Art-Picture Gallery<span class="dan"> Pro</span></b></small></em></a>
                    </div>
                    <div class="col-md-9 col-sm-9">
                      <div class="row">
                          <h4 class="page-header"><b class="warn">Zeitlich </b><span class="grey"> befristetes Angebot! </span></h4>
                        <div class="col-md-6 col-sm-6">                          
                          <p><a role="button" href="<?php echo ART_PICTURE_SALE; ?>" target="_blank"> <strong class="grey">ArtPicture Galerie <b class="dan">Pro</b></strong></a> Wordpress Galerie Plugin  <b class="dan"><u>20%</u></b> Rabatt.</p>
                          </div>
                        <div class="col-md-6 col-sm-6">
                          <ul class="emsisoft-benefits list-unstyled">                        
                            <li> <img src="<?php echo plugins_url('../assets/images/galerie-pro/pfeil.png',__FILE__); ?>"><b class="grey"> 3 Galerie Layouts</b></li>
                            <li> <img src="<?php echo plugins_url('../assets/images/galerie-pro/pfeil.png',__FILE__); ?>"><b class="grey"> user Freigaben</b></li>
                            <li> <img src="<?php echo plugins_url('../assets/images/galerie-pro/pfeil.png',__FILE__); ?>"><b class="grey"> user Verwaltung</b></li>
                            <li> <img src="<?php echo plugins_url('../assets/images/galerie-pro/pfeil.png',__FILE__); ?>"><b class="grey"> user checked</b></li>
                            <li> <img src="<?php echo plugins_url('../assets/images/galerie-pro/pfeil.png',__FILE__); ?>"><b class="grey"> user Messagesv</li>  
                            <li> <img src="<?php echo plugins_url('../assets/images/galerie-pro/pfeil.png',__FILE__); ?>"><b class="grey"> Image Exif &amp; GPS</b></li>
                            </ul>
                        </div>
                          </div>
                    </div>
                  </div>
                </div>
              </td>
</div>
</div>
<div class="col-md-12">
<div class="pull-left copyright-text">
                               <ul class="credit">
                                    <li>© <?php echo date('Y'); ?> Art-Picture Design</li>
                                    <li>Proudly powered by  <a class="prem" href="http://wordpress.org/">WordPress</a>.</li>
                                    <li> <a role="buttun" href="https://art-picturedesign.de"><b class="warn"><span class="fa fa-home "></span> ART</b><b class="grey">-PICTURE DESIGN</b></a> <small>(Grafik-Design, Web-Design, 3D Design)</small> |   <a class="prem" href="mailto:info@art-picturedesign.de"><span class="warn fa fa-envelope-o "></span> Info@Art-PictureDesign.de</a></li>
                                </ul><!-- end .credit -->
                            </div>
                        <div class="footer-menu-wrapper">
                        </div>
                    </div>
</div><!--wrapper-->