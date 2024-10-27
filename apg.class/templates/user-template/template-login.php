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
wp_logout();
$meldung='';
if(isset($_GET['type']) && $_GET['type'] == 1){
$meldung = '<div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-label="Schließen"><span aria-hidden="true">&times;</span></button>
            <strong><span class="fa fa-exclamation-triangle"></span> FEHLER!</strong> Bitte füllen Sie alle Felder aus!
            </div>';    
}elseif(isset($_GET['type']) && $_GET['type'] == 2){
 $meldung = '<div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-label="Schließen"><span aria-hidden="true">&times;</span></button>
            <strong><span class="fa fa-exclamation-triangle"></span> FEHLER!</strong> Benutzername oder Passwort falsch!
            </div>';    
}elseif(isset($_GET['type']) && $_GET['type'] == 3){
$meldung = '<div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-label="Schließen"><span aria-hidden="true">&times;</span></button>
            <strong><span class="fa fa-info-circle "></span> INFO!</strong> Erfolgreich ausgeloggt. Vielen Dank für ihren Besuch.
            </div>';     
}
?>
<div class="container">
<br />
<h1 class="warn text-center"><a href="<?php echo ART_PICTURE_URL; ?>"> <img src="<?php echo plugins_url('../../../assets/images/Logo-Art-Picture-galerie-B.png',__FILE__); ?>" width="62" eight="57"></a>
 art<span class="grey">Picture Galerie</span></h1>
<hr class="hr-light">
<br />
<div class="col-md-6 col-md-offset-3 "style="min-height: 250px;margin-top: 95px;">
<?php echo $meldung; ?>
<div class="displaystyle displaystyle-fullborder displaystyle-warning displaystyle-sm">
<br />
<h4 class="text-center warn">
<img src="<?php echo plugins_url('../../../assets/images/newuser.png',__FILE__); ?>"> Art<span class="grey">Picture Gallery <b class="warn">LOGIN </span></h4>    
<br />
<hr class="hr-light">
<br />
<form method="post" action="?apg-user-gallery-template=12067103">
<div class="row">
<div class="col-md-8 col-md-offset-2">
  <div class="form-group">
    <label for="FeldBN"style="color: grey;"><span class="warn fa fa-user"></span> Benutzer Name:</label>
    <input type="text" class="form-control" name="name" placeholder="Benutzer Name"autocomplete="new-password"required>
  </div>
  <div class="form-group">
    <label for="FeldPW"style="color: grey;"><span class="warn fa fa-lock"></span> Passwort</label>
    <input type="password" class="form-control" name="passwort"autocomplete="new-password" placeholder="Passwort"required>
   </div>
  <button type="submit"name="gesendet" class="btn btn-primary btn-outline"><span class="fa  fa-share-square-o"></span> login</button>
</form>
<br />
</div>
</div>
<br />
<hr class="hr-light">
<br />
</div>
<?php
include('footer.php');
?>      