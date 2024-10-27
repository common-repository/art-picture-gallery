<?php
if ( ! defined( 'ABSPATH' ) ) exit; 
function apgArtPictureAjaxHandel() {
        @session_destroy();
        isset($_POST['class']) && is_string($_POST['class'])  ? $class = esc_attr( $_POST['class']) : $class = ""; 
        isset($_POST['session']) && is_numeric($_POST['session'])  ? $session = esc_attr( $_POST['session']) : $session = ""; 
        isset($_POST['sessionTyp']) && is_string($_POST['sessionTyp'])  ? $sessionTyp = esc_attr( $_POST['sessionTyp']) : $sessionTyp = "";
        isset($_POST['method']) && is_string($_POST['method'])  ? $method = esc_attr( $_POST['method']) : $method = "";  
        if(!empty($session)){
        @session_start();
        $_SESSION['name'] = $sessionTyp;    
        }
        switch($class)
        {
     case'ModalHandler':
        isset($_POST['method']) && is_string($_POST['method']) ? $method = esc_attr( $_POST['method']) : $method = "";         
        require_once(dirname(__DIR__).'/apg.class/ModalHandler.php');
        $send = new APG\ArtPictureGallery\ModalHandler($method);
        $return = $send->execute();    
        $return = (array("record"=>$return));    
        break; 
     case'galerie_handler':
       require_once(dirname(__DIR__).'/apg.class/galerie/index.php');
        $send = new APG\ArtPictureGallery\ArtGalerieHandler();
        $return = $send->execute();    
        $return = (array("record"=>$return));     
        break;
     case'ImageUploadHandle':
        require_once(dirname(__DIR__).'/apg.class/db/imageUploadHandle.php');
        $send = new APG\ArtPictureGallery\UploadHandle();
        $return = $send->execute();    
        $return = (array("record"=>$return));     
        break; 
     case'UserHandler':
        require_once(dirname(__DIR__).'/apg.class/UserHandler.php');
        $send = new APG\ArtPictureGallery\UserHandler($method);
        $return = $send->execute();    
        $return = (array("record"=>$return));     
        break;
     case'SettingsHandler':
        require_once(dirname(__DIR__).'/apg.class/db/settings-remote.php');
        $send = new APG\ArtPictureGallery\remote($method);
        $return = $send->execute();    
        $return = (array("record"=>$return));     
        break; 
     case'APIHandler':
        require_once(dirname(__DIR__).'/apg.class/artPictureApi.php');
        $return = APG\ArtPictureGallery\validate_api_key(); 
        $return = (array("record"=>$return));     
        break; 
     case'GalerieHandler':
        require_once(dirname(__DIR__).'/apg.class/galerie/index.php');
        $send = new APG\ArtPictureGallery\ArtGalerieHandler();        
        $return = $send->execute();    
        $return = (array("record"=>$return));      
        break; 
        default:
        $return=''; 
    }
    return $return;
}
?>