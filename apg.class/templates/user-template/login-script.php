<?php
/**
 * ArtPicture Plugin PHP Class
 * http://art-pictureDesign.de/WP-ArtTheme-Galerie
 * Copyright 2017, Jens Wiecker
 * https://art-picturedesign.de
 *
 */
if ( ! defined( 'ABSPATH' ) ) exit;
@session_start();
isset($_POST['name']) && is_string($_POST['name'])  ? htmlspecialchars(trim( $name = ($_POST['name']))) : $name = "";
isset($_POST['passwort']) && is_string($_POST['passwort'])  ? htmlspecialchars(trim($passwort = ($_POST['passwort']))) : $passwort = "";
if (isset($_POST["gesendet"]) ) {
    global $wpdb;
    $table=$wpdb->prefix .'art_user';
    $data = $wpdb->get_results( $wpdb->prepare(
   "SELECT *
   FROM  ".$table." 
   WHERE htaccess_user = %s ", 
   $name ));  
    }else{
    return false;    
    }
if(count($row) === 0){
   $extra = site_url().'?apg-user-gallery-template=12067102&type=2';
   @header("Location: $extra");
}  
if (crypt($passwort, $data[0]->htaccess_passwort) == $data[0]->htaccess_passwort) {
   $_SESSION['SID']  = strtoupper(md5(@session_id()));    
   $_SESSION["name"] = $name;
   $_SESSION["login"] = "12067101";
   $_SESSION["id"] = $data[0]->id;
   $_SESSION["aktiv"] = $data[0]->htaccess_aktiv;
   $extra = site_url().'?apg-user-gallery-template=12067101';
} else {
  $extra = site_url().'?apg-user-gallery-template=12067102&type=2';
}
@header("Location: $extra");
?>