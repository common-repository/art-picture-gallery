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
require_once ('ApgSettings.php');
require_once ('db/settings-remote.php');
use APG\ArtPictureGallery\ApgSettings as ApgSettings;
use APG\ArtPictureGallery\remote as remote;
function encode_session($array){
 isset($array) ? $encode = $array : $encode = false;
 $encode = serialize($encode);
 $encode = @gzcompress($encode);
 $encode = base64_encode($encode);
 return $encode;
}
function send_ArtPictureGalleryKey($order_id,$license_key){
 $daten=array("order_id"=>$order_id,"lizense_key"=>$license_key);   
 $sha=encode_session($daten);
 $sha_sign = strtoupper(hash("sha512", $sha));
 $senden = array("order_id"=>$order_id,"lizense_key"=>$license_key,"shaSign"=>$sha_sign);
 $args = array(
    'body' => $senden,
    'timeout' => '5',
    'redirection' => '5',
    'httpversion' => '1.1',
    'blocking' => true,
    'headers' => array(),
    'cookies' => array()
  );
 $response = wp_remote_post( 'https://art-picturedesign.de/ipn/core/art_picture_api.php', $args );
 return json_decode($response['body']);  
}
function validate_api_key(){
 $settings = ApgSettings::load_settings('user_settings');
 $valid_key = false;
 if(!empty($settings['order_id']) || !empty($settings['license_key'])){
 $send_key = send_ArtPictureGalleryKey($settings['order_id'],$settings['license_key']); 
    if($send_key->record === true){
    $valid_key = true;
    }
  }
 $set = new remote();
 $set->set_db_settings("license_aktiv",$valid_key,'user_settings'); 
 return $valid_key;
}
?>