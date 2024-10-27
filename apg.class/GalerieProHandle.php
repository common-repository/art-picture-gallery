<?php
/**
 * ArtPicture Plugin PHP Class
 * http://art-pictureDesign.de/WP-ArtTheme-Galerie
 * Copyright 2017, Jens Wiecker
 * https://art-picturedesign.de
 *
 */
require_once ('plugin_handler.php');
require_once ('db/class_db_handle.php');
use  APG\ArtPictureGallery\Settings as Settings;
use  APG\ArtPictureGallery\DbHandle as DbHandle;
$set=Settings::load_settings('user_settings',false);
$settings = $set->return;
 $a2 = array("method" =>"read_wp_db",
           "table"    =>"art_user",
           "select"   =>" *");
           $dat2 = new DbHandle($a2);
           $row=$dat2->return;
function aktiv_user($id,$typ,$aktiv){
 $update = array("method"         =>"update_wp_user_aktiv",
                 "table"          =>'art_user',
                 "data"           =>array(
                 "id"             =>$id,
                 "typ"            =>$typ,
                 "htaccess_aktiv" =>$aktiv));
  new DbHandle($update);
}
for($i=0; $i < $row['count']; $i++) {
    if(empty($settings['license_aktiv']) && $i >= 1){
    aktiv_user($row['data'][$i]->id,'htaccess_aktiv',0);
    }
}
?>