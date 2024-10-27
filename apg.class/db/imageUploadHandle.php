<?php
namespace APG\ArtPictureGallery;
if ( ! defined( 'ABSPATH' ) ) exit;
require('exif_data.php');
use APG\ArtPictureGallery\Exif as Exif;
class UploadHandle
{
     public function execute(){
        global $wpdb;
        $status = false;
        $result = false;
        $error_msg = null;
        $rturn = false;
       isset($_POST['galerieName']) && is_string($_POST['galerieName']) ? $galerieName = esc_attr($_POST['galerieName']) : $galerieName = "";
       isset($_POST['name']) && is_string($_POST['name']) ? $name = esc_attr($_POST['name']) : $name = ""; 
       isset($_POST['typ']) && is_string($_POST['typ']) ? $typ = esc_attr($_POST['typ']) : $typ= "";
       isset($_POST['size']) && is_string($_POST['size']) ? $size = esc_attr($_POST['size']) : $size= ""; 
       isset($_POST['deleteUrl']) && is_string($_POST['deleteUrl']) ? $deleteUrl = esc_attr($_POST['deleteUrl']) : $deleteUrl = "";
       isset($_POST['url']) && is_string($_POST['url']) ? $url = esc_attr($_POST['url']) : $url = "";
       isset($_POST['mediumUrl']) && is_string($_POST['mediumUrl']) ? $mediumUrl = esc_attr($_POST['mediumUrl']) : $mediumUrl = "";
       isset($_POST['thumbnailUrl']) && is_string($_POST['thumbnailUrl']) ? $thumbnailUrl = esc_attr($_POST['thumbnailUrl']) : $thumbnailUrl = "";
       isset($_POST['fehlerName']) && is_numeric($_POST['fehlerName']) ? $fehlerName = esc_attr($_POST['fehlerName']) : $fehlerName = "";    
        if(!empty($fehlerName)){
        self::delete_image(htmlspecialchars_decode($name));
        $message =  '<h5 class="grey"><span class="dan fa fa-exclamation-circle"></span><b class="dan"> FEHLER:</b> <small>Bild <i> "'.$name.'" </i> &nbsp; nicht gespeichert. <b class="dan"> KEIN </b> Ordner gwewählt!</small></h5>';    
        $return = array("status"=>false,"message"=>$message);    
        return($return);
        exit();    
        }
        $exif =  Exif::exif_files($name);
        $table_image = $wpdb->prefix . 'art_images';
        $wpdb->insert( 
	    $table_image, 
	    array( 
		'name'          => rawurldecode($name), 
		'size'          => $size,
        'type'          => $typ,
        'galerie_name'  => $galerieName,
        'url'           => $url,
        'thumbnailUrl'  => $thumbnailUrl,
        'mediumUrl'     => $mediumUrl,
        'deleteUrl'     => $deleteUrl,
        'exif'          => $exif    
	   ), 
     array( 
		'%s', 
		'%d',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s'    
	));
      return array("status"=>true); 
}
private static function delete_image($name){
   @session_start();
   $path =  $_SESSION['UPLOAD_DIR'].'/files/';    
   //$path = dirname(__DIR__).'/file-upload/files/'; 
    unlink($path.'img/'.$name);
    unlink($path.'medium/'.$name);
    unlink($path.'thumb/'.$name);
   }
}
?>