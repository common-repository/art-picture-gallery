<?php
/**
 * ArtPicture Plugin PHP Class
 * http://art-pictureDesign.de/WP-ArtTheme-Galerie
 * Copyright 2017, Jens Wiecker
 * https://art-picturedesign.de
 *
 */
namespace APG\ArtPictureGallery;
if ( ! defined( 'ABSPATH' ) ) exit; 

class ApgSettings
{
  public static function load_settings($method){
        global $wpdb;    
        $table = $wpdb->prefix . 'art_config';  
        switch ($method)
        {
            case 'user_settings':
                $row = $wpdb->get_results( "SELECT user_settings  FROM $table" );
                $return = unserialize($row[0]->user_settings);
                break;
            case 'tooltip':
                $row = $wpdb->get_results( "SELECT tooltip  FROM $table" );
                $return = unserialize($row[0]->tooltip);
                break;
            case 'all':
                $row1 = $wpdb->get_results( "SELECT tooltip  FROM $table" );
                $tt = unserialize($row1[0]->tooltip);
                $row2 = $wpdb->get_results( "SELECT user_settings  FROM $table" );
                $settings = unserialize($row2[0]->user_settings);
                $return = array_merge($tt,$settings);
                break;    
            default:
                $return = '';
                break;
        }
        return $return;
    }//END load_settings
}
?>