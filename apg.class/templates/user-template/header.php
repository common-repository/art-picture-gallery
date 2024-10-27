<?php
/**
 * ArtPicture Plugin PHP Class
 * http://art-pictureDesign.de/WP-ArtTheme-Galerie
 * Copyright 2017, Jens Wiecker
 * https://art-picturedesign.de
 *
 */
if ( ! defined( 'ABSPATH' ) ) exit;
$template_js = APG_ART_PICTURE_GALLERY_PLUGIN_URL.'apg.class/templates/user-template/templates.class.php';
wp_logout();
?>
<!DOCTYPE html>
<html lang="de">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Art Picture Galerie Plugin Für Wordpress">
    <meta name="author" content="Jens Wiecker art-pictureDesign">
    <link rel="icon" href="<?php echo plugins_url('../../templates/user-template/',__FILE__); ?>favicon.ico">
    <title>Art-Picture Gallery</title>
 <link rel="stylesheet" href="<?php echo plugins_url('../../../assets/dist/css/bootstrap.css',__FILE__); ?>"> 
 <link rel="stylesheet" href="<?php echo plugins_url('../../../assets/css/galerie.css',__FILE__); ?>">
 <link rel="stylesheet" href="<?php echo plugins_url('../../../apg.class/file-upload/css/blueimp-gallery.min.css',__FILE__); ?>">      
</head>
<body style="background: #f7f7f7;">
<div class="bootstrap-wrapper"> 