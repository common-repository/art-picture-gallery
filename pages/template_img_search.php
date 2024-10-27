<?php
/**
 * ArtPicture Plugin PHP Class
 * http://art-pictureDesign.de/WP-ArtTheme-Galerie
 * Copyright 2017, Jens Wiecker
 * https://art-picturedesign.de
 *
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
require_once (dirname(__DIR__).'/apg.class/ApgSettings.php');
use  APG\ArtPictureGallery\ApgSettings as ApgSettings;

function apg_image_search_temp(){
        isset($_GET['search']) && is_string($_GET['search'])  ? $search = esc_attr($_GET['search']) : $search = "";
         $settings = ApgSettings::load_settings('user_settings');
         global $wpdb;
         $table_name = $wpdb->prefix . 'art_images';
         $like = "%$search%";
         $row = $wpdb->get_results( $wpdb->prepare(
        "SELECT *
         FROM  ".$table_name." 
         WHERE tags LIKE %s ", 
         $like ));
         $temp_header = '<div class="bootstrap-wrapper">
                        <div class="container"style="min-height:850px;padding-top:'.$settings['padding_top'].'; background-color:'.$settings['site_background_color'].';">
                        <h3 class="grey"style="padding-top:25px;padding-bottom:35px;"><span class="fa fa-search"></span> Such <small>Ergebnis</small></h3>
                        <a href="'.$_SERVER['REDIRECT_URL'].'"><span class="fa fa-angle-double-left"></span> zurück </a>
                        
                        <div class="table-responsive">
                        <table class="table table-hover">
                        <thead>
                        <tr>
                        <th>Image:</th>
                        <th>Name:</th>
                        <th>Galerie:</th>
                        <th>erstellt:</th>
                        </tr>
                        </thead>
                        <tbody>';
       $temp_footer = '</tbody></table></div>
                      '.apg_bluemGallery_select().'
                        </div> 
                        </div>';
        foreach($row as $tmp){
        $temp_body .= '<tr>
                       <td><a data-gallery="" href="'.htmlspecialchars(trim($tmp->url)).'"title="'.htmlspecialchars(trim($tmp->name)).'">
                       <img src="'.htmlspecialchars(trim($tmp->thumbnailUrl)).'" id="thumb'.$tmp->id.'" alt="'.$tmp->name.'"width="45" height="45"/></a>
                       </td>
                       <td><b class="grey"><a role="button" class="prem" href="?apg-user-gallery-template=12067114&id='.$tmp->id.'">'.$tmp->name.'</b></td>
                       <td><b class="grey">'.$tmp->galerie_name.'</b></td>
                       <td><b class="grey">'.$tmp->created_at.'</b></td>
                       </tr>';
       }
      $return = $temp_header . $temp_body . $temp_footer; 
      $return = preg_replace(array('/<!--(.*)-->/Uis', "/[[:blank:]]+/"), array('', ' '), str_replace(array("\n","\r","\t"), '', $return));     
      return $return;
    }
echo apg_image_search_temp();
get_footer();
?>