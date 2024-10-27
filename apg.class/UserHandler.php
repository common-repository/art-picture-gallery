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

require_once ('ApgCore.php');
require_once ('db/class_db_handle.php');
require_once ('site_templates.php');
require_once ('ApgSettings.php');
require_once('UserLogHandler.php');

use  APG\ArtPictureGallery\UserLogHandler as UserLogHandler;    
use  APG\ArtPictureGallery\Core as Core;
use  APG\ArtPictureGallery\ApgSettings as ApgSettings;
use  APG\ArtPictureGallery\DbHandle as DbHandle;
use  APG\ArtPictureGallery\SiteTemplates as SiteTemplates;

class UserHandler extends Core
{
     public function __construct($method){
     $this->method = $method;
     $this->settings = ApgSettings::load_settings('user_settings');
     $this->tt = ApgSettings::load_settings('tooltip');     
    }
    public function execute(){
        
        $status = false;
        $result = false;
        $error_msg = null;
        $return = false;
        $method = $this->method;
        $res = parent::extract_method($method);

        
       switch ($res['method'])
    { 
case'user_message_template':
        $template = $this->user_message_template();
        $responseJson = new \stdClass(); 
        $responseJson->status   = true;
        $responseJson->template = $template;       
        $result = $responseJson;          
        break;
case'load_user_selected_image':
        isset($_POST['fid']) && is_string($_POST['fid'])  ? $fid = esc_attr($_POST['fid']) : $fid = "";       
        $template = $this->load_user_selected_image($fid);       
        $responseJson = new \stdClass(); 
        $responseJson->status   = true;
        $responseJson->template = $template;       
        $result = $responseJson;       
         break; 
case'user_selected':
        $template = $this->user_selected();       
        $responseJson = new \stdClass(); 
        $responseJson->status   = true;
        $responseJson->template = $template;       
        $result = $responseJson;       
         break;       
               
         break;
case 'new_user_db':
         $return = $this->usr_handler();   
         $result = $return;       
          break;
case'editor_button_select':
         $result =  $this->editor_button_select();
        break;
case'new_user_template':
        $template = $this-> new_user_template();
        $responseJson = new \stdClass();
        $responseJson->template = $template;
        $responseJson->status   = true;
        $result = $responseJson;
        break;
case'delete_usr_message':
        $responseJson = new \stdClass();
        
        isset($_POST['value']) && is_string($_POST['value'])  ? $value = esc_attr($_POST['value']) : $value = "";
        isset($_POST['id']) && is_numeric($_POST['id'])  ? $id = esc_attr($_POST['id']) : $id = "";
         if(empty($value) || empty($id)){
        $responseJson->status   = $status;
        return  $responseJson;    
        }
        $a1 = array("method"   =>"read_wp_db",
                    "table"    =>"art_user",
                    "select"   =>  ' *',
                    "where"    =>" where id = %d",
                    "search"   =>$id);
        $usr = new DbHandle($a1);
        $data=$usr->return;
        $msg = unserialize($data['data'][0]->user_message);
        foreach($msg as $tmp)
        {
          $message[] = $tmp;
         
        }
        $Amsg = array_filter(array_values($message));
      
         for($i = 0; $i <= count($Amsg); $i++) { 
         $datum_msg = substr($Amsg[$i],0,strpos($Amsg[$i],'_'));
         if($datum_msg == $value){
         continue;
         }else{
          $datei_upd[] = $Amsg[$i]; 
         }   
        }
        $datei_upd = array_filter(array_values($datei_upd));
        $Update = serialize($datei_upd);
        $u = array("method"   =>"update_wp_user_nachricht",
                   "table"    =>"art_user",
                   "data"     =>array("id"=>$id,"message"=>$Update) ,
                    "session" =>false);
        new DbHandle($u);
        $responseJson->status = true;
        $result = $responseJson;
        break;
        case 'delete_log_eintrag':
        $responseJson = new \stdClass();
        isset($_POST['value']) && is_string($_POST['value'])  ? $value = esc_attr($_POST['value']) : $value = "";
    
        if(empty($value)){
        $responseJson->status   = $status;
        return $responseJson;    
        }
        
        $zeile = substr($value,0,strpos($value,'_'));
        $dir = __DIR__.'/templates/userLog/';
        $file = substr($value,strpos($value,'_')+1).'.txt';
        $datei = $dir . $file;
        $line = file($datei);
        $f = pathinfo($datei);
        $monat = substr($f['filename'],3,2);
        $jahr   = substr($f['filename'],6,4);
        $userID = substr($f['filename'],strpos($f['filename'],'_')+1);
        
        for($i = 0; $i <= count($line); $i++) {
        if($i == $zeile){
            continue;
        }
         $update[] = $line[$i]; 
        }
        $update = array_filter($update);
        unlink($datei);
        foreach($update as $tmp)
        {
        $dh = fopen($datei, "a+");
        fwrite($dh, $tmp);
        }
        fclose($dh);
        $responseJson->monat   = $monat;
        $responseJson->jahr    = $jahr;
        $responseJson->id      = $userID;
        $responseJson->status = true;
        $result = $responseJson ; 
        break;
case'delete_day_log':
         $responseJson = new \stdClass();
        isset($_POST['value']) && is_string($_POST['value'])  ? $value = esc_attr($_POST['value']) : $value = "";
        if(empty($value)){
        $responseJson->status   = $status;
        return  $responseJson;    
        }
        $dir = __DIR__.'/templates/userLog/';
        $file = $value.'.txt';
        $datei = $dir . $file;
        unlink ($datei);
        $responseJson->status = true;
        $result = $responseJson ; 
        break;
case'load_user_log':
        isset($_POST['typ']) && is_string($_POST['typ'])  ? $typ = esc_attr($_POST['typ']) : $typ = "";
        $responseJson = new \stdClass();
        if(empty($typ)){
        $responseJson->status   = $status;
        return  $responseJson;   
        }
        $template = $this->read_user_log($typ);
        $responseJson->status = true;
        $responseJson->template = $template;
        $result =  $responseJson ;      
        break;
case'load_userLog_jahr':
        isset($_POST['id']) && is_numeric($_POST['id'])  ? $id = esc_attr($_POST['id']) : $id = "";
        $responseJson = new \stdClass();
        if(empty($id)){
        $responseJson->status   = $status;
        return $responseJson;   
        }
        $this->id = $id;
        $template = $this->read_user_log("jahr");
        $responseJson->status = true;
        
        $responseJson->template = $template;
        $result = $responseJson;
        break;
case'load_userLog_monat':
        isset($_POST['id']) && is_numeric($_POST['id'])  ? $id = esc_attr($_POST['id']) : $id = "";
        isset($_POST['jahr']) && is_numeric($_POST['jahr'])  ? $jahr =esc_attr($_POST['jahr']) : $jahr = "";
        $responseJson = new \stdClass();
        if(empty($id) || empty($jahr)){
        $responseJson->status   = $status;
        return  $responseJson;   
        }
        $this->id = $id;
        $this->jahr = $jahr;
        $template = $this->read_user_log("monat");
        $responseJson->status = true;
        $responseJson->template = $template;
        $result =  $responseJson;
        break;
case 'user_Log_details':
        isset($_POST['id']) && is_numeric($_POST['id'])  ? $id = esc_attr($_POST['id']) : $id = "";
        isset($_POST['jahr']) && is_numeric($_POST['jahr'])  ? $jahr = esc_attr($_POST['jahr']) : $jahr = "";
        isset($_POST['monat']) && is_numeric($_POST['monat'])  ?$monat = esc_attr($_POST['monat']) : $monat = "";
        $responseJson = new \stdClass();
        if(empty($id) || empty($jahr) || empty($monat)){
        $responseJson->status   = $status;
        return  $responseJson;   
        }
        $this->id = $id;
        $this->jahr = $jahr;
        $this->monat = $monat;
        $template = $this->read_user_log("details");
        $responseJson->status = true;
        $responseJson->template = $template;
        $result = $responseJson;
        break;
case'user_help':
        isset($_POST['typ']) && is_string($_POST['typ'])  ? $typ = esc_attr($_POST['typ']) : $typ = "";
        $responseJson = new \stdClass();
        if(empty($typ)){
        $responseJson->status   = $status;
        return $responseJson;   
        }
        if($typ == 'freigaben'){
        @ob_start();
        $template = file_get_contents(__DIR__.'/templates/help/freigaben.txt',FILE_USE_INCLUDE_PATH);
        @ob_end_flush();
        }
        if($typ == 'auswahl'){
        @ob_start();
        $template = file_get_contents(__DIR__.'/templates/help/auswahl.txt',FILE_USE_INCLUDE_PATH);
        @ob_end_flush();
        }
        if($typ == 'optionen'){
        @ob_start();
        $template = file_get_contents(__DIR__.'/templates/help/auswahl.txt',FILE_USE_INCLUDE_PATH);
        @ob_end_flush();
        }
        $responseJson->template = $template;
        $responseJson->status = true;
        $result = $responseJson;
        
        break;
        
 case'template_read_messages':
        $template = $this->read_user_message();
        $responseJson = new \stdClass();
        $responseJson->template = $template;
        $responseJson->status = true;
        $result =  $responseJson ; 
        break;
case 'new_user_message':
        @session_start();       
        isset($_POST['message']) && is_string($_POST['message'])  ? $message = esc_attr($_POST['message']) : $message = "";
        $responseJson = new \stdClass();
        if(empty($message)){
        $responseJson->status   = $status;
        return $responseJson;   
        }
        $a1 = array("method"   =>"read_wp_db",
                     "table"    =>"art_user",
                     "select"   =>  ' *',
                     "where"    =>" where id = %d",
                     "search"   =>$_SESSION['id']);
                     ;
       $usr = new DbHandle($a1);
       $data=$usr->return;
        date_default_timezone_set("Europe/Berlin");
        $heute = date("Y-m-d H:i:s");  
        $newMessage = $heute.'_'.$message;   
       if(empty($data['data'][0]->user_message)){
        $msgUpdate = serialize(array($newMessage));
       }else{
        $msgnew =array($newMessage);
        $allMsg = unserialize($data['data'][0]->user_message);
        $msgUpdate = serialize(array_merge($allMsg,$msgnew));
        }
         $upd = array("method"  =>"new_wp_user_message",
                      "table"   =>"art_user",  
                      "data"    =>array("id"=>$_SESSION['id'],
                      "message" =>$msgUpdate)
                      );
        $update = new DbHandle($upd);                     
        $responseJson->status = true;
        $result = $responseJson;
        break;
case 'load_selected_image':
        $responseJson = new \stdClass();
        isset($_POST['value']) && is_string($_POST['value'])  ? $value = esc_attr($_POST['value']) : $value = "";
        isset($_POST['fid']) && is_numeric($_POST['fid'])  ? $fid = esc_attr($_POST['fid']) : $fid = "";
        if(empty($value) || empty($fid)){
        $responseJson->status   = $status;
        return $responseJson;    
        }
        $entry = $this->load_user_selected_image((string)$value,(int)$fid);
        $responseJson->template = $entry;
        $responseJson->status = true;
        $result = $responseJson;
       
        break;
case 'new_email_template':
       
        isset($_POST['name']) && is_string($_POST['name'])  ? $name = esc_attr($_POST['name']) : $name = "";
        $responseJson = new \stdClass(); 
        if(empty($name)){
         $responseJson->status = $status;   
         return $responseJson;   
        }

       $temp = self::new_email_template($name);
            
        $responseJson->status    = true;
        $responseJson->head_links= $temp['links'];
        $responseJson->daten     = $temp['daten'];
        $responseJson->message   = $temp['message'];
        $responseJson->loaded    = $name;
        $result = $responseJson;       
        break;
case 'read_user_email_content':
        
        $entry = self::read_usermail_verzeichnis();
        if($entry['status'] === false){
        $entry = self::read_usermail_verzeichnis();  
        }
        $btn_head  = '<hr class="hr-light"><br /><h5 class="warn"><span class="fa fa-angle-double-down"></span> eMail <small>Templates</small></h5><div class="btn-group">';
        $btn_foot  = '<br /><br /></div><hr class="hr-light">';
        $allFiles = array_reverse($entry['files']);
        foreach ($allFiles as $tmp)
        {
     
        $datei = substr($tmp,0,strpos($tmp,'.txt'));
        if($datei =='zugangsdaten eMail')
        {
         $dateiActiv = '<b><u>'.$datei.'</u></b>';   
         $btnTyp = 'primary';   
        }else{
         $dateiActiv = $datei;   
         $btnTyp = 'default';   
        }
          $btn  .= '<button class="btn btn-'.$btnTyp.' btn-outline btn-xs" role="button" onclick="change_mail_template(\''.$datei.'\');"><span class="fa fa-envelope-o"></span> '.$dateiActiv.' </button>';
        }
        $button = $btn_head .$btn . $btn_foot;
    
        $responseJson = new \stdClass();
        $responseJson->status = true;
        $responseJson->links  = $button;
        $responseJson->daten  = $entry['daten'];
        $responseJson->loaded = 'zugangsdaten eMail';
        $result = $responseJson;
        break;
case 'change_mail_template':
        isset($_POST['name']) && is_string($_POST['name'])  ? $name = esc_attr($_POST['name']) : $name = "";
        
        $responseJson = new \stdClass();
        if(empty($name)){
        $responseJson->status   = $status;
        $responseJson->message  = 'leere Eingabe!';
        return $responseJson;   
        }
        $temp = UserHandler::change_email_template($name);
        $responseJson->status    = true;
        $responseJson->links     = $temp['links'];
        $responseJson->daten     = $temp['daten'];
        $responseJson->message   = $temp['message'];
        $responseJson->loaded    = $name;
        $result = $responseJson;
        break;
case'save_user_email_template':
        isset($_POST['name']) && is_string($_POST['name'])  ? $name = esc_attr($_POST['name']) : $name = "";
        isset($_POST['value']) && is_string($_POST['value'])  ? $value = esc_attr($_POST['value']) : $value = "";
        $responseJson = new \stdClass();
        if(empty($value)){
        $responseJson->status   = $status;
        $responseJson->message  = 'leere Eingabe!';
        return $responseJson;   
        }
               
        $entry = self::save_user_email_template(htmlspecialchars_decode($value),$name);
        $responseJson->status    = $entry['status'];
        $responseJson->message   = $entry['message'];
        $result = $responseJson;
        break;
case'delete_email_template':
        isset($_POST['name']) && is_string($_POST['name'])  ? $name = esc_attr($_POST['name']) : $name = "";
        $responseJson = new \stdClass();
        if(empty($name)){
        $responseJson->status   = $status;
        $responseJson->message  = 'leere Eingabe!';
        return $responseJson;   
        }
        $ent = self::del_email_template($name);
        if($ent !== true)
        {
        $responseJson->status   = $status;
        $responseJson->loaded   = $name;
        $responseJson->message  = '<b style="color:#d73814;"><span class="fa fa-exclamation-triangle"></span> Die E-Mail, mit den Zugangsdaten kann nicht gelöscht werden!</b>';
        return $responseJson;   
        }else{
        $entry = self::read_usermail_verzeichnis();
        if($entry['status'] === false){
        $entry = self::read_usermail_verzeichnis();  
        }
        $btn_head  = '<hr class="hr-light"><br /><h5 class="warn"><span class="fa fa-angle-double-down"></span> eMail <small>Templates</small></h5><div class="btn-group">';
        $btn_foot  = '<br /><br /></div><hr class="hr-light">';
        $allFiles = array_reverse($entry['files']);
        foreach ($allFiles as $tmp)
        {
     
        $datei = substr($tmp,0,strpos($tmp,'.txt'));
        if($datei =='zugangsdaten eMail')
        {
         $dateiActiv = '<b><u>'.$datei.'</u></b>';   
         $btnTyp = 'primary';   
        }else{
         $dateiActiv = $datei;   
         $btnTyp = 'default';   
        }
          $btn  .= '<button class="btn btn-'.$btnTyp.' btn-outline btn-xs" role="button" onclick="change_mail_template(\''.$datei.'\');"><span class="fa fa-envelope-o"></span> '.$dateiActiv.' </button>';
        }
        $button = $btn_head .$btn . $btn_foot;
    
        $responseJson = new \stdClass();
        $responseJson->status   = true;
        $responseJson->links    = $button;
        $responseJson->message  = $name .' gelöscht!';
        $responseJson->daten    = $entry['daten'];
        $responseJson->loaded   = 'zugangsdaten eMail';
        $result = $responseJson;   
        }
     
       
        break;
case 'benutzer_freigaben_start':
        $responseJson = new \stdClass();
        $return = $this->benutzer_freigaben(array("auswahl"=>'benutzer_freigaben'));
       if($res['id']=='response'){
        $template = $this->start_user_response_template();
        $responseJson->body = $template['template'];
        $responseJson->close = $template['close'];
        }else{
        $responseJson->body = $return['body'];  
        }
      $responseJson->status = true;
      $responseJson->header = $return['header'];
      $result = $responseJson;
     break; 
case 'load_freigaben':
        $close = '<a class="dan" role="button"onclick="close_details();">
                        <p class="dan text-right"style="margin-right:25px;">
	                    <i class="fa fa-times fa-2x"></i>
                        <strong>&nbsp;schließen</strong></a></p><br>'.self::user_details_auswahl().'';
        $responseJson  = new \stdClass(); 
        $optionen = array("template"=>"user_freigaben_start");
        $dat = new SiteTemplates($optionen);
        $data = $dat->return;
        if(isset($data['status'])){
       $responseJson->message  = $data['message'];
       $responseJson->status   = $data['status'];
       return $responseJson;    
        }          
       $responseJson->status    = true;
       $responseJson->close    = $close;
       $responseJson->template  = $data;
       $result = $responseJson; 
        break;

  case 'create_new_user':
        $responseJson  = new \stdClass();
        $responseJson->status    = true;
        $result = $responseJson;
        break;
  case 'create_new_freigabe_template':
        $template =  $this->user_templates(array("method"=>"new_freigabe"));
        $responseJson  = new \stdClass();
        $responseJson->status    = $template['status'];
        $responseJson->template  = $template['template'];
        $result = $responseJson;
        break;       
  case 'new_freigabe_galerie':
        isset($_POST['galerie']) && is_string($_POST['galerie'])  ? $galerie = esc_attr($_POST['galerie']) : $galerie = "";
        isset($_POST['user']) && is_string($_POST['user'])  ? $user = esc_attr($_POST['user']) : $user = "";
        $responseJson  = new \stdClass();
        
        //wenn eingaben leer : wenn nicht fehlermeldung zurück
        if(empty($galerie) || empty($user)){
        $msg = parent::response('16');
        $responseJson->message   = $msg['response_msg'];     
        $responseJson->status    = $status;
        return $responseJson;    
        }
        $a1 = array("method"   =>"read_wp_db",
                         "table"    =>"art_user",
                         "select"   =>  ' *',
                         "where"    =>  " where htaccess_user = %s",
                         "search"   =>  $user);
       $usr = new DbHandle($a1);
       $userDB=$usr->return;
       
       $a2 = array("method"=>"read_wp_db",
                         "table"    =>"art_galerie",
                         "select"   =>   '*',
                         "where"    =>  " where galerie_name = %s",
                         "search"   =>  $galerie);
       $gal = new DbHandle($a2);
       $galerieDB=$gal->return;
       
       
       //überprüfen ob es user und galerien gibt wenn nicht fehlermeldung zurück
       if(empty($userDB['count']) || empty($galerieDB['count'])){
        $msg = parent::response('16');
        $responseJson->message   = $msg['response_msg'];     
        $responseJson->status    = $status;
        return $responseJson;
       }
       //überprüfen ob Eintrag schon vorhanden ist wenn nicht fehlermeldung zurück
       $a3 = array("method"   =>"user_wp_freigabe_start");
       $data3 = new DbHandle($a3);
       $r=$data3->return;
     
      
       for ($x = 1; $x <= $r['count']; $x++) {
       if($r['data'][$x -1]->galerie_name === $galerie && $r['data'][$x -1]->htaccess_user === $user) {
        $msg = parent::response('4');
        $responseJson->message   = $msg['response_msg'];     
        $responseJson->status    = $status;
        return $responseJson;
        }
       }
     //default Werte erzeugen
       $settings = serialize(
                    array( "gps"        =>(int)0,
                           "exif"       =>(int)0,
                           "auswahl"    =>(int)1,
                           "kommentar"  =>(int)1,
                           "log"        =>(int)1,
                           "selected"   =>(int)1,
                           "nachricht"  =>(int)1,                
                           ));
        //array für insert erzeugen
        $freigabe  = array("method"         =>"new_wp_freigabe",
                           "table"          =>"art_freigaben",
                           "data"           =>array(
                           "settings"       =>(string)$settings,
                           "htaccess_id"    =>(int)$userDB['data'][0]->id,
                           "galerie_typ"    =>(int)2,
                           "freigabe_aktiv" =>(int)1,
                           "galerie_id"     =>(int)$galerieDB['data'][0]->id, 
                           "htaccess_aktiv" =>(int)1,));
                           
                           
        //eintrag in DB schreiben
       $upd = new DbHandle($freigabe);
       $insertDB=$upd->return;
        
        //response zurück
        $responseJson->insert_id = $insertDB;
        $responseJson->status    = true;
        $result = $responseJson;
        break;
   case 'delete_freigabe':
       $a1 = array("method"  =>"read_wp_db",
                  "table"    =>"art_freigaben",
                  "select"   =>  ' id',
                  "where"    =>  " where id = %d",
                  "search"   =>  $res['id']);
       $usr = new DbHandle($a1);
       $userDB=$usr->return;
       $responseJson  = new \stdClass();
       if(empty($userDB['count'])) {
        $msg = parent::response('23');
        $responseJson->message   = $msg['response_msg']; 
        $responseJson->status    = $status;
        return $responseJson; 
       }
       $delete = array("method"=>"delete_wp_freigabe",
                       "table"   =>"art_freigaben",
                       "id"      =>  $res['id']);
        new DbHandle($delete);
        
        $responseJson->delete_id = $res['id'];
        $responseJson->status    = true;
        $result = $responseJson;           
        break;
   case 'load_delete_user_template':
        $template =  $this->user_templates(array("method"=>"user_delete_template"));
         $responseJson  = new \stdClass();
        $responseJson->status    = $template['status'];
        $responseJson->template  = $template['template'];
        $result = $responseJson;
        break;
   case 'delete_user':
        isset($_POST['uid']) && is_numeric($_POST['uid'])  ? $uid = esc_attr($_POST['uid']) : $uid = "";
        $responseJson  = new \stdClass();
        if(empty($uid)){
        $msg = parent::response('23');
        $responseJson->message   = $msg['response_msg'];
        $responseJson->status    = $status;
        return $responseJson;    
        }
        $abfrage2 = array("method"=>"read_wp_db",
                    "table"    =>"art_freigaben",
                    "select"   =>  '*',
                    "where"    =>  " where htaccess_id = %d",
                    "search"   =>  (int)$uid);
       $del = new DbHandle($abfrage2);
       $userDel=$del->return;

       foreach ($userDel['data'] as $tmp)
        {
         if($tmp->htaccess_id == $uid){
           $delete1 = array("method"=>"delete_wp_freigabe",
                           "table"   =>"art_freigaben",
                           "id"      =>  $tmp->id);
        new DbHandle($delete1);
         }
      }
        $delete2 = array("method"=>"delete_wp_freigabe",
                        "table"   =>"art_user",
                        "id"      =>  $uid);
        new DbHandle($delete2);
       //DELETE-LOGDATEN 
      $dir= __DIR__ . '/templates/userLog';
      $alledateien = scandir($dir); 
       foreach ($alledateien as $files)
       {
        $fileinfo = pathinfo($dir."/".$files);
        if($fileinfo['extension'] != 'txt'){
        $files = '.';  
        }
        if ($files != "." && $files != ".."  && $files != "_notes" && $fileinfo['basename'] != "Thumbs.db") {
        $file[] .= $files;
        }
       }
       
       if(!empty($file)){
        foreach ($file as $tmp)
        {
          $f = pathinfo($dir."/".$tmp);
          $tag    = substr($tmp,0,2);  
          $monat  = substr($tmp,3,2);
          $jahr   = substr($tmp,6,4);
          $userID = substr($f['filename'],strpos($f['filename'],'_')+1);
         if($userID == $uid){
           unlink($dir.'/'.$tag.'-'.$monat.'-'.$jahr.'_'.$uid.'.txt'); 
         }
        }
       }
      
        $responseJson->status    = true;
        //$responseJson->delete_id = $tmp['id'];
        $result = $responseJson; 
        break;
 
  case 'user_aktiv': //user, freigabe und email Aktiv
        isset($_POST['daten']) && is_string($_POST['daten'])  ? $daten = esc_attr($_POST['daten']) : $daten = "";
        $responseJson  = new \stdClass();
        if(empty($daten)){
        $responseJson->status = $status;
        return $responseJson;   
        }
        $checktyp    = substr($daten,strpos($daten,'_')+1);
        $htaccess_id = substr($daten,0,strpos($daten,'_'));
        if($checktyp == 'freigabe_aktiv'){
          $table     = 'art_freigaben';
          $checktyp  = 'htaccess_aktiv';  
        }else{
            $table = 'art_user';
        }
        $a1 = array("method"  =>"read_wp_db",
                   "table"    => $table,
                   "select"   =>  $checktyp,
                   "where"    =>  " where id = %d",
                   "search"   =>  $htaccess_id);
       $dat1 = new DbHandle($a1);
       $data=$dat1->return;
      if(empty($data['data'][0]->$checktyp)){
        $checked = 1;
      }else{
        $checked = 0;
      }

      $upd = array("method"=>"update_wp_user_aktiv",
                         "table" => $table,
                         "data"  =>array("htaccess_aktiv"=>$checked,
                                         "id"=>$htaccess_id,
                                         "typ"=>$checktyp));
        new DbHandle($upd);
        if(substr($daten,strpos($daten,'_')+1) == 'freigabe_aktiv'){
        $checked = 'freigabe_aktiv';
        }
        $responseJson->checked = $checked;
        $responseJson->value = $data['data'][0]->$checktyp;
        $responseJson->check =  $htaccess_id.'_'.$checktyp;
        $responseJson->status = true;
        $result = $responseJson;
        break;
 case 'checked_details':
        isset($_POST['checked']) && is_string($_POST['checked'])  ? $checked = esc_attr($_POST['checked']) : $checked = "";
          $freigabe_id  = substr($checked,strpos($checked,'_') +1);
          $typ          = substr($checked,0,strpos($checked,'_'));
          $entry = self::update_user_settings($typ,$freigabe_id);  
          $auswahl = substr($entry['typ'],0,strpos($entry['typ'],'-'));
        if(empty($entry['check'])){
            $message = $auswahl .' deaktiviert';
        }else{
            $message = $auswahl . ' aktiviert';
        } 
           
        $responseJson  = new \stdClass();
        $responseJson->check = $entry['check'];
        $responseJson->typ = $entry['typ'];
        $responseJson->message = $message;
        $responseJson->status = true;
        $result = $responseJson; 
           
        break;
 case'select_change_galerie_typ':
        isset($_POST['select']) && is_string($_POST['select'])  ? $select = esc_attr($_POST['select']) : $select = "";
        $htaccess_id = (int) substr($select,0,strpos($select,'_'));
        $selected    = (int) substr($select,strpos($select,'_')+1);
        $responseJson  = new \stdClass();
        //PRO-VERSION       
        if(empty($this->settings['license_aktiv'])) {
         $selected = 2;
        }      
        //PRO-VERSION ENDE       
        if(empty($selected)){
         $responseJson->status  = $status; 
         $responseJson->message = 'Standard Galerie (2) gewählt';
         $new_selected = 2;
        }else{
         $responseJson->status  = true; 
         $responseJson->message = 'Galerie Typ ('.$selected.') gewählt';    
         $new_selected = $selected;
        }
        $upd = array("method"=>"update_wp_user_aktiv",
                     "table" => 'art_freigaben',
                     "data"  => array("htaccess_aktiv"=>(int)$new_selected,
                                     "id"=>(int)$htaccess_id,
                                     "typ"=>(string)'galerie_typ'),                       
                     "session"=>false);
        new DbHandle($upd);
        $result = $responseJson;
        break;
  case 'user_auswahl':

       isset($_POST['auswahl']) && is_string($_POST['auswahl'])  ? $auswahl = esc_attr($_POST['auswahl']) : $auswahl = "";
       $TypTxt = '<b class="prem"> checked</b> <span class ="prem fa fa-check"></span>';
       $responseJson  = new \stdClass();
       if(empty($auswahl)){
       $responseJson->status = $status;
       return $responseJson;    
       }
       $det = parent::extract_method($auswahl);
       $htaccess_id = $det['method'];
       $image_id    = $det['id'];
    
       $abfrage = array("method"  =>"read_wp_db",
                        "table"   =>"art_images",
                        "select"  =>"galerie_name,id",
                        "where"   =>" where id = %d",
                        "search"  =>$image_id);
       $dat = new DbHandle($abfrage);
       $data = $dat->return; 
       $a2 = array("method" =>"read_wp_db",
                  "table"   =>"art_galerie",
                  "select"  =>"id",
                  "where"   =>" where galerie_name = %s",
                  "search"  =>$data['data'][0]->galerie_name);
       $dat2 = new DbHandle($a2);
       $data2 = $dat2->return;
       
       $a3 = array("method"=>"freigabe_wp_id",
                "table"    =>"art_freigaben",
                "select"   =>"*",
                "data"     => array("htaccess_id"=>$htaccess_id,
                                    "galerie_id"=>$data2['data'][0]->id));
               
       $dat3 = new DbHandle($a3);
       $data3=$dat3->return;

       //überprüfen ob freigaben vorhanden sind 
       if(empty($data3['count'])) {
       $err=parent::response('22');
       return array("status"=>false,"message"=>$err['response_msg']);
       }
       //überprüfen ob log aktiv ist
       $s = unserialize($data3['data'][0]->settings);
       $this->log_aktiv = $s['log'];
       //wenn keine Freigaben vorhanden, ersten Eintrag erzeugen
       if(empty($data3['data'][0]->select_image)){
       //Eintrag in DB schreiben         
       $select = serialize(array($image_id));
       $upd = array("method"=>"user_wp_auswahl",
                 "table"    =>"art_freigaben",
                 "checked"  =>$select,
                 "id"       =>$data3['data'][0]->id);
       if(!empty($this->log_aktiv)){
       $this->write_user_log($htaccess_id,$TypTxt,$image_id,$checktxt);   
       }       
       new DbHandle($upd);
       $responseJson->status = true;
       $responseJson->wahl = 1;
       return $responseJson;    
       }
       $dbs = unserialize($data3['data'][0]->select_image);
       if(in_array($image_id,$dbs)){
       $checkAuswahl = 0; 
       $checktxt = '<span class="dan fa fa-thumbs-o-down"></span> <b class="dan"> abgewählt</b>';
       if(!empty($this->log_aktiv)){
        
       $this->write_user_log($htaccess_id,$TypTxt,$image_id,$checktxt);   
       }  
       $entfernen = array($image_id);
       //callbck function
       $callback = function ($value)use ($entfernen){
       return !(in_array($value, $entfernen, true));
       };
       $update = array_filter($dbs, $callback);
       $select = serialize($update);
       $upd = array("method"   =>"user_wp_auswahl",
                    "table"    =>"art_freigaben",
                    "checked"  =>$select,
                    "id"       =>$data3['data'][0]->id);
               
       new DbHandle($upd);
       $responseJson->status = true;
       return $responseJson; 
       }else{
        $checkAuswahl = 1;
        $checktxt = '<span class="suss fa fa-thumbs-o-up"></span> <b class="suss"> gewählt</b>';
       $ns = implode(",",$dbs);
       $news = $ns.','.$image_id;
       $select = serialize(explode(",",$news));   
       }   
       $upd = array("method"   =>"user_wp_auswahl",
                    "table"    =>"art_freigaben",
                    "checked"  =>$select,
                    "id"       =>$data3['data'][0]->id);
               
       new DbHandle($upd);
         if(!empty($this->log_aktiv)){
         $this->write_user_log($htaccess_id,$TypTxt,$image_id,$checktxt);   
         } 
       //private function write_user_log()
       $responseJson->status = true;
       $responseJson->wahl = $checkAuswahl;
       $result = $responseJson; 
       break;
 case 'new_user_kommentar':
       isset($_POST['kommentar']) && is_string($_POST['kommentar'])  ? $kommentar = esc_attr($_POST['kommentar']) : $kommentar = "";
        $TypTxt = '<b class="prem"> Kommentar</b> <span class ="prem fa fa-comment-o"></span>';
       $responseJson  = new \stdClass();
       if(empty($kommentar)){
       $responseJson->status = $status;
       return $responseJson; 
       }
        
       session_start();
       $galerie_name = $res['id'];
       $htaccess_id  = $_SESSION['id'];
       $image_id     = trim((int)$res['typ']);
       $a1 = array("method" =>"user_wp_freigabe_auswahl",
                   "data"   =>array("galerie_name"=>$galerie_name,
                                    "htaccess_id"=>$htaccess_id));
       $dat = new DbHandle($a1);
       $data = $dat->return;
       
       $this->update_image_posts($galerie_name,$image_id,$htaccess_id,$kommentar);
       
       $s = unserialize($data['data'][0]->settings);
       $this->log_aktiv = $s['log']; 
       
       if(empty($data['data'][0]->message)){
       $ne = array();
       $ne[] = $image_id.'_'.$kommentar;
       $msg = serialize($ne);
       $upd = array("method"   =>"update_wp_user_kommentar",
                    "table"    =>"art_freigaben",
                    "data"     =>array("id"=>$data['data'][0]->freigabe_id,
                                       "message"=>$msg));
       new DbHandle($upd);              
       $responseJson->status    = true;
       return $responseJson; 
       }
       $db_message = unserialize($data['data'][0]->message);
  
       for ($x = 0; $x <= count($db_message); $x++) {  
        
       $id  = substr($db_message[$x],0,strpos($db_message[$x],'_'));
       $msg = substr($db_message[$x],strpos($db_message[$x],'_')+1);
       if($id === $image_id){

       unset($db_message[$x]);
       $db_message = array_values($db_message);
       }
      }

       $newEintrag = array($image_id.'_'.$kommentar);
       $na = serialize(array_merge($db_message,$newEintrag));
       $upd = array("method"    =>"update_wp_user_kommentar",
                      "table"   =>"art_freigaben",
                      "data"    =>array("id"=>$data['data'][0]->freigabe_id,
                                        "message"=>$na));
 
       new DbHandle($upd);
            
       if(!empty($this->log_aktiv)){

        $newKommentar = $date . '_' . $kommentar;
        $this->write_user_log($htaccess_id,$TypTxt,$image_id,$kommentar);   
        } 
       
       $responseJson->msg       = $new_msg;
       $responseJson->status    = true;
       $result =  $responseJson;  
       break;        
 case 'passwort_generieren':
 
        $klartext_pass = parent::generate_callback_pw();
        $template = '<div id="pw_generieren">
                     <input type="text" class="form-control" id="add_passwort" value="'.$klartext_pass.'" autocomplete="new-password"placeholder="Passwort" required />
                     </div>';
       $template = preg_replace(array('/<!--(.*)-->/Uis', "/[[:blank:]]+/"), array('', ' '), str_replace(array("\n","\r","\t"), '', $template));              
       $responseJson  = new \stdClass();              
       $responseJson->status = true;
       $responseJson->template = $template;
       $result =  $responseJson ;                        
        break;
 case 'change_user_data':
        isset($_POST['daten'])   && is_string($_POST['daten'])   ? $daten   = esc_attr($_POST['daten'])   : $daten   = "";
        isset($_POST['newdata']) && is_string($_POST['newdata']) ? $newdata = esc_attr($_POST['newdata']) : $newdata = "";
        isset($_POST['email'])   && is_numeric($_POST['email'])  ? $email   = esc_attr($_POST['email'])   : $email   = "";

        $responseJson  = new \stdClass(); 
        if(empty($daten) || empty($newdata)){
        $responseJson->status = $status;
        $responseJson->message = "leere eingabe";     
  
        return  $responseJson ;    
        }
        $settings = $this->get_db_settings('1');
        $htaccess_id = (int)substr($daten,0,strpos($daten,'_'));
        $upd_typ     = (string)substr($daten,strpos($daten,'_')+1);
        
        
        if($upd_typ == 'htaccess_passwort' && strlen($newdata) < 8){
        $responseJson->status = $status;
        $responseJson->message = "passwort zu kurz";    
     
        return  $responseJson ;   
        }
        if($upd_typ == 'htaccess_email'){
        if(filter_var($newdata, FILTER_VALIDATE_EMAIL)  === false){
        $responseJson->status = $status;
        $responseJson->message = "email falsches Format";    
     
        return $responseJson ; 
           }
        }
       if(!empty($settings['email_aktiv']) && $upd_typ == 'htaccess_passwort' && !empty($email) ){
       $sendMail    = $this->sende_user_mail('new_passwort',$htaccess_id,"",$newdata);
       $mailStatus  = $sendMail['status'];
       $mailMessage = $sendMail['message'];
       }else{
       $mailStatus  = $status;
       $mailMessage = 'keine E-Mail versendet!'; 
      }    
       if($upd_typ == 'htaccess_passwort'){
       
         $newData = parent::crypt_password($newdata);  
        }else{
         $newData = $newdata;   
        }        
        $upd = array("method" =>"update_wp_user_new_passwort",
                    "table"  =>"art_user",
                    "data"   =>array("htaccess_data"=>(string)$newData,
                                     "id"=>(int)$daten,
                                     "typ"=>$upd_typ));
                    
       $msgtyp = substr($upd_typ,strpos($upd_typ,'_')+1);            
       new DbHandle($upd);
       if($settings){
           $proVersion  = true;
       }else{

           $proVersion  = false;
       }

       $responseJson->status      = true;
       $responseJson->mailstatus  = $mailStatus;
       $responseJson->mailmessage = $mailMessage;
       $responseJson->proversion  = $proVersion;
       $responseJson->message     = $msgtyp." erfolgreich geändert"; 
       $result = $responseJson ; 
       break;
  case 'load_template_user_details':
        $responseJson  = new \stdClass();
        $a2 = array("method"   =>"read_wp_db",
                   "table"    =>"art_user",
                   "select"   =>"*");

       $dat2 = new DbHandle($a2);
       $data2=$dat2->return;

        if(empty($data2['count'])){
        $err=parent::response('21');
         
        $responseJson->status = $status;
        $responseJson->message = $err['response_msg'];
        return  $responseJson ;
        }
       foreach ($data2['data'] as $tmp){
           $return .= $this->template_user_details($tmp);
        }
        $responseJson  = new \stdClass(); 
        $responseJson->status   = true;
      
        $responseJson->template = $this->close_btn() . $return;    
        $result = $responseJson;
       break;
  case 'new_user_notiz':
        isset($_POST['notiz'])&& is_string($_POST['notiz'])? $notiz = esc_attr($_POST['notiz']) : $notiz   = "";
        isset($_POST['uid'])  && is_numeric($_POST['uid']) ? $uid   = esc_attr($_POST['uid'])   : $uid = "";
        $responseJson  = new \stdClass();
        if(empty($uid)){
        $responseJson->status =  $status;
        $responseJson->message =  '<h4 class="warn"><b class="dan fa fa-exclamation"></b> Info: <small> fehler ist aufgetreten </small></h4>'; 
        return $responseJson;   
        }
         $upd = array("method"=>"update_wp_user_new_passwort",
                         "table" =>"art_user",
                         "data"  =>array("htaccess_data"=>(string)$notiz,
                                         "id"=>(int)$uid,
                                         "typ"=>'notiz'));
        new DbHandle($upd);        
        $responseJson->status = true;
        $responseJson->message =  'Notiz erfolgreich gespeichert.';
        $result = $responseJson ;
       break;
  case 'load_freigaben_select':
        isset($_POST['data'])&& is_string($_POST['data'])? $data = esc_attr($_POST['data']) : $data   = "";
        
        $responseJson  = new \stdClass();
        if(empty($data)){
        $responseJson->status = $status;
        $responseJson->message =  'keine auswahl';
        return  $responseJson ;    
        }
        $auswahl_type = substr($data,0,strpos($data,'_'));
        $auswahl_wert = substr($data,strpos($data,'_')+1);
        $wahl = '';
        if($auswahl_type == 'user'){
            $select = 'htaccess_user';
            $wahl = '<div class="col-md-4">
            <br>
                    <hr class="hr-footer">
                    <h4 class="warn">Freigaben <small>  von user: <span class="prem">'.$auswahl_wert.' </span></small><h4>
                    <hr class="hr-footer">
                    </div><br><br><br>';
        }
        if($auswahl_type == 'galerie'){
            $select = 'galerie_name';
           $wahl = '<div class="col-md-4">
           <br>
                    <hr class="hr-footer">
                    <h4 class="warn">Freigaben <small>der Galerie <span class="prem">'.$auswahl_wert.'</span></small><h4>
                    <hr class="hr-footer">
                    </div><br><br><r>';
        }
        $optionen = array("template"=>"user_freigaben_start",
                           "data"   =>array(
                           "where"  =>$select,
                           "typ"    =>$auswahl_wert));
                                          
        $dat = new SiteTemplates($optionen);
        $data = $dat->return;
        if(isset($data['status'])){
         
        $responseJson->message  = $data['message'];
        $responseJson->status   = $data['status'];
       return  $responseJson ;    
        }
       $sel = $wahl . $this->close_btn('select');
                 
       $responseJson->status    = true;
       $responseJson->template  = $sel . $data ;
       $result = $responseJson; 
       break;
  case 'user_response_template':
        isset($_POST['value']) && is_string($_POST['value']) ? $value = esc_attr($_POST['value']) : $value = "";
        isset($_POST['loaded']) && is_string($_POST['loaded']) ? $loaded = esc_attr($_POST['loaded']) : $loaded = "";
        $responseJson  = new \stdClass();
        
        if(empty($res['id'])){
        $responseJson->status = $status;
        return $responseJson ; 
        }
        $id = $res['id'];      
        if(!empty($value)){
        $id = (int)substr($value,0,strpos($value,'_'));
        $typ = (string)substr($value,strpos($value,'_')+1);
        if($res['id'] == 'grid' || $res['id'] == 'details'){
        $load = $res['id'];
        $template = $this->user_response_template($id,$typ,$load); 
        $btn = self::btn_group_response($id,$load); 
        }else{
        $load = $loaded;
        $template = $this->user_response_template($id,$typ,$load); 
        $btn = self::btn_group_response($id,$load); 
        }
        $template = $this->user_response_template($id,$typ,$load); 
        $btn = self::btn_group_response($id,$load);  
        }else{
        $load = $loaded;    
        $template = $this->user_response_template($id,'alle',$load); 
        $btn = self::btn_group_response($id,$load);   
        }
        $close = $this->close_btn();
        $header = '<br>'.$this->close_btn().'<br>' .'<br>'.$btn;

        $responseJson->typ       = $load; 
        $responseJson->close     = $header; 
        $responseJson->total     = $template['total'];       
        $responseJson->status    = $template['status'];
        $responseJson->template  = $template['template'];
        $result =  $responseJson;
       break;
   case'user_email_senden':
       isset($_POST['typ'])   && is_string($_POST['typ'])   ? $typ   = esc_attr($_POST['typ'])   : $typ   = "";
       isset($_POST['id'])    && is_numeric($_POST['id'])   ? $id    = esc_attr($_POST['id'])    : $id    = "";
       isset($_POST['email']) && is_string($_POST['email']) ? $email = esc_attr($_POST['email']) : $email = "";
       $responseJson  = new \stdClass();
        if(empty($typ) || empty($id) || empty($email)){
        $responseJson->status  = $status;
        $responseJson->message = 'fehler Übergabehandling';
        return $responseJson; 
       }
        $sendeMail = $this->sende_user_mail($typ,$id,$email);
        if($sendeMail === true){
        $message ='Email erfolgreich gesendet!';    
        }else{
        $message ='Email konnte nicht gesendet werden!';    
        }       
        $responseJson->status    = $sendeMail;
        $responseJson->message   = $message;
        $result =  $responseJson;
       
       break;

   }//endeSwitch 
 return $result;
        
        }
 private function usr_handler(){

           isset($_POST['bn'])          && is_string($_POST['bn'])           ? $bnname      = esc_attr($_POST['bn'])           : $bnname      = "";
           isset($_POST['pw'])          && is_string($_POST['pw'])           ? $passwort    = esc_attr($_POST['pw'])           : $passwort    = "";
           isset($_POST['vn'])          && is_string($_POST['vn'])           ? $vorname     = esc_attr($_POST['vn'])           : $vorname     = "";
           isset($_POST['nn'])          && is_string($_POST['nn'])           ? $nachname    = esc_attr($_POST['nn'])           : $nachname    = "";
           isset($_POST['em'])          && is_string($_POST['em'])           ? $email       = esc_attr($_POST['em'])           : $email       = "";
           isset($_POST['no'])          && is_string($_POST['no'])           ? $notiz       = esc_attr($_POST['no'])           : $notiz       = "";
           isset($_POST['ua'])          && is_numeric($_POST['ua'])          ? $user_aktiv  = esc_attr ($_POST['ua'])          : $user_aktiv  = "";
           isset($_POST['ea'])          && is_numeric($_POST['ea'])          ? $email_aktiv = esc_attr($_POST['ea'])           : $email_aktiv = "";
           
           if(empty($user_aktiv)){
            $user_aktiv = (int)0;
           }else{
            $user_aktiv= (int)1;
           }
            if(empty($email_aktiv)){
            $email_aktiv = (int)0;
           }else{
            $email_aktiv= (int)1;
           }
           if(filter_var($email, FILTER_VALIDATE_EMAIL)  === false){
            $fehler .= 'fehler email<br>';
           }else{
            $newEmail = $email;
           }
            if(empty($vorname)){
            $fehler .= 'fehler vorname<br>';
            }else{
            $new_vorname = $vorname;   
            }
            if(empty($nachname)){
            $fehler .= 'fehler nachname<br>';
            }else{
            $new_nachname = $nachname;   
            } 
           if(empty($bnname)){
            $fehler .= 'fehler name<br>';
            }elseif(strlen($bnname) < 6){
            $fehler .= 'fehler name zu kurz <br>';    
            }else{
            $newname = $bnname;   
            }
            if(empty($passwort)){
            $fehler .= 'fehler name<br>';
            }elseif(strlen($passwort) < 8){
            $fehler .= 'fehler name zu kurz <br>';    
            }else{
            $newpasswort = $passwort;   
            }
             if(strlen($fehler) !== 0){
             $em = parent::response('7');
             $fehler = $em['response_msg'];
             }
           $abfrage = array("method"   =>"read_wp_db",
                             "table"    =>"art_user",
                             "select"   =>"*",
                             "where"    =>" where htaccess_user = %s",
                             "search"   =>$newname);
                             
            $dat = new DbHandle($abfrage);
            $dataDB=$dat->return;
                        
            if($dataDB['count'] !== 0){
              $em = parent::response('20');
              $fehler = $em['response_msg'].'<br/>';
             }

            if(strlen($fehler) !== 0) {
                 
             return array("status"=>false,"message"=>$fehler);
            }
            $password = parent::crypt_password($newpasswort);
            $user = array("username"    =>$newname,
                          "passwort"    =>$password,
                          "notiz"       =>$notiz,
                          "nachname"    =>$new_nachname,
                          "vorname"     =>$new_vorname,
                          "email"       =>$newEmail,
                          "user_aktiv"  =>$user_aktiv,
                          "email_aktiv" =>$email_aktiv);
                          
           $new_user = array("method"    =>"new_wp_user",
                              "data"     =>$user);
                              
                             
             $in = new DbHandle($new_user);
             $ret = $in->return;
            if($email_aktiv === 1){
             $url = substr(admin_url(),0,strpos(admin_url(),'wp-admin')).'artpicture-galerie-login';    
             $daten = array("url"      =>'<a href="'.$url.'"><span style="color:orange;">'.$site_title.'</span></a>',
                            "text_url" =>$url,
                            "vorname"  =>$new_vorname,
                            "nachname" =>$new_nachname,
                            "bn"       =>$newname,
                            "pw"       =>$newpasswort,
                            "email"    =>$newEmail ); 
 
            $result_email = $this->send_userdaten_mail($daten);   
         }
      
     
        $return = array("status"=>true,"message"=>$ret,"email"=>$result_email);
        return $return;
    }
    
    private function user_templates($data)
    {
       $status = false;
        switch ($data['method'])
        {
         case 'new_freigabe':
             
                       $abfrage = array("method"=>"read_wp_db",
                             "table"    =>"art_galerie",
                             "select"   =>"*");
                       $a1 = new DbHandle($abfrage);
                       $ret = $a1->return;
                           if(!empty($ret['count'])){
                             $status = true;
                           }

                        $abfrage2 = array("method"=>"read_wp_db",
                             "table"    =>"art_user",
                             "select"   =>"*");
                       $a2 = new DbHandle($abfrage2);
                       $ret2 = $a2->return;
                       if(!empty($ret2['count'])){
                          $status = true;
                       }
                          $select_galerie  = '<select class="form-control" id="art_galerie_select" name="galerieSelect"required>';
                          $select_galerie .='<option value="">Galerie wählen</option>';
                          $select_galerie_footer ='</select>';
                          foreach($ret['data'] as $tmp){
                          $select_galerie .= '<option class="'.$color1.'" value="'.$tmp->galerie_name.'"onchange="art_galerie_select(this.value)">'.$tmp->galerie_name.'</option>'."\n";
                          }
                                              
                          $select_user  = '<select class="form-control" id="htaccessUser" name="htaccessUser"required>';
                          $select_user .='<option  value="">Benutzer wählen</option>';
                          $select_user_footer ='</select>';
                        //PRO_USER
                             if(empty($this->settings['license_aktiv'])) {
                              $select_user .= '<option value="'.$ret2['data'][0]->htaccess_user.'">'.$ret2['data'][0]->htaccess_user.'</option>'."\n";
                              $txt='<br><hr class="hr-light"> <h5 class="grey"><span class="dan fa fa-asterisk "></span> In der Standart Version kann nur der erste angelegte Benutzer ausgew&auml;hlt werden, desweiteren  werden nur die ersten 10 Bilder der gew&auml;hlten Galerie, den Benutzer im Front-End angezeigt. <br><hr class="hr-light"><br>
                              <hr class="hr-light"><br>
                            <span class="warn fa fa-arrow-right "></span>  In der <a class="prem" role="button" href="'.ART_PICTURE_SALE.'" target="_blank"> Art-Picture Galerie <b class="dan"> Pro</b></a> k&ouml;nnen Sie unbegrenzt viele Benutzer und Freigaben erstellen. Eine erstellte Galerie kann für jeden erstellten Benutzer freigegeben werden.  </h5><hr class="hr-light">';
                              $txt = preg_replace(array('/<!--(.*)-->/Uis', "/[[:blank:]]+/"), array('', ' '), str_replace(array("\n","\r","\t"), '', $txt));
                            $stern='<span class="dan fa fa-asterisk "></span> ';  
                          }else{
                             foreach($ret2['data'] as $tmp){
                             $select_user .= '<option value="'.$tmp->htaccess_user.'">'.$tmp->htaccess_user.'</option>'."\n";
                             }   
                          }
                         //PRO_USER
                          
            $template = '<a class="dan" role="button"onclick="close_details();">
                         <p class="dan text-right"style="margin-right:25px;">
	                     <i class="fa fa-times fa-2x"></i>
                         <strong>&nbsp;schließen</strong></a></p>
                         <div class="aktion_menue">
                         <div class=" col-md-8 col-md-offset-2">
                          <p class="grey"><b >Die Login Url des User-Templates ist:<br> <a role="button" class="prem" href="'.site_url().'?apg-user-gallery-template=12067102">'.site_url().'?apg-user-gallery-template=12067102</a></b></p>
                          <div class="inner-aktion_menue neue_freigabe">
                         
                          <h4 class="text-center warn"><span class="fa fa-user"></span> Neue <small>freigabe erstellen...</small> </h4><br>
                         <div class="row">
                          <div class="col-md-4 col-md-offset-2">   
                         <div class="form-group">
                         <label class="title warn text-center">'.$stern.' Benutzer</label>
                          
                          '.$select_user.$select_galerie_footer.'
                         </div>
                         </div>
                          <div class="col-md-4 ">
                         <div class="form-group">
    
                         <label class="title warn text-center">'.$stern.' Galerie</label>
                        '.$select_galerie.$select_galerie_footer.'
                         </div>
                         </div>
                         </div><div class="col-md-3 col-md-offset-2"style="padding-top:15px;" >
                         <button type="submit" class="btn btn-warning"onclick="save_new_freigabe();"><span class="fa fa-save"></span> speichern</button>        
                         </div>
                         
                         </div>'.$txt.'</div></div>';
            break;//endeSwitch
        }
        
       
        $template = preg_replace(array('/<!--(.*)-->/Uis', "/[[:blank:]]+/"), array('', ' '), str_replace(array("\n","\r","\t"), '', $template));
       return array("template"=>$template,"status"=>$status);
        
    }
private static function update_user_settings($method,$id) {
   $a1 = array("method" =>"read_wp_db",
               "table"  =>"art_freigaben",
               "select" =>"settings",
               "where"  =>" where id = %d",
               "search" =>$id);
    $dat1               = new DbHandle($a1);
    $data               = $dat1->return; 
    $settings           = unserialize($data['data'][0]->settings);
    
    $gps_check          = $settings['gps'];
    $exif_check         = $settings['exif'];
    $auswahl_check      = $settings['auswahl'];
    $kommentar_check    = $settings['kommentar'];
    $email_check        = $settings['log'];
    $nachricht_check    = $settings['nachricht'];
    //PRO VERSION
    $user_settings = ApgSettings::load_settings('user_settings');
    if(empty($user_settings['license_aktiv'])){
     $new_gps_check=1; 
     $new_exif_check=1;    
    }else{
     $new_gps_check = $gps_check;
     $new_exif_check = $exif_check;    
    }
    //PRO VERSION ENDE
    switch ($method)
    {
    case 'gps':
      if(empty($new_gps_check)){
        $gps_check = 1;
        $check = 1;
       }else{
        $gps_check = 0;
        $check = 0;
      }
       break;
    case 'exif':
      if(empty($new_exif_check)){
        $exif_check = 1;
        $check = 1;
      }else{
        $exif_check = 0;
        $check = 0;
      }
      break;
    case 'auswahl':
      if(empty($auswahl_check)){
        $auswahl_check = 1;
        $check = 1;
      }else{
        $auswahl_check = 0;
        $check = 0;
      }
      break;
    case 'kommentar':
      if(empty($kommentar_check)){
        $kommentar_check = 1;
        $check = 1;
      }else{
        $kommentar_check = 0;
        $check = 0;
      }
      break;
    case 'log':
      if(empty($email_check)){
        $email_check = 1;
        $check = 1;
      }else{
        $email_check = 0;
        $check = 0;
      }
      break;
      $new_select = preg_replace(array('/<!--(.*)-->/Uis', "/[[:blank:]]+/"), array('', ' '), str_replace(array("\n","\r","\t"), '', $new_select)); 
      $id=$data2['data'][0]->freigabe_id;

      break;
  case 'nachricht':
      if(empty($nachricht_check)){
        $nachricht_check = 1;
        $check = 1;
      }else{
        $nachricht_check = 0;
        $check = 0;
      }
      break;
  }//endeSwitch    
    $newsettings = serialize(array(  "gps"         =>$gps_check,
                                     "exif"        =>$exif_check,
                                     "auswahl"     =>$auswahl_check,
                                     "kommentar"   =>$kommentar_check,
                                     "log"          =>$email_check,
                                     "selected"    =>$selected_check,
                                     "nachricht"   =>$nachricht_check,
                                    ));

    $update = array("method" =>"update_wp_user_details",
                    "table"  =>"art_freigaben",
                    "data"   =>$newsettings,
                    "id"     =>$id);
           new DbHandle($update);
           
       $return = array("typ"=>$method.'-aktiv'.$id,"check"=>$check);
       return $return;    
    }
 protected function benutzer_freigaben($data)
   {
    switch ($data['auswahl'])
    {
       
        case 'benutzer_freigaben':
   
            //init
            $colclass_uc='huge-no';
            $colclass_ch='huge-no';
            $colclass_fr='huge-no';
            $colclass_ms='huge-no';
            $uc=0;
            $ch=0;
            $fr=0;
            $ms=0;
            
   $a1 = array("method" =>"read_wp_db",
               "table"  =>"art_freigaben",
               "select" =>"*",

               "session"=>false);
    $dat1               = new DbHandle($a1);
    $data               = $dat1->return;
    $a3 = array("method" =>"read_wp_db",
               "table"  =>"art_user",
               "select" =>"*");
    $dat3               = new DbHandle($a3);
    $data3              = $dat3->return;  
            if(empty($data['count'])){
             $uc=0;
             $ch=0;
             $fr=0;
             $ms=0;
           }else{
           $a2 = array("method"   =>"user_wp_freigabe_start");
            $dat2 = new DbHandle($a2);
            $data2=$dat2->return;
           }
            for ($i = 0; $i <= $data2['count']; $i++) {
            $msg .= $data2['data'][$i]->message.',';
            $usr_check .= $data2['data'][$i]->select_image.',';
            }
            $galerie_msg = array_filter(explode(",",$msg));
            $user_check  = array_filter(explode(",",$usr_check));

            $uc = $data3['count'];
            if(empty($uc) ? $colclass_uc = 'huge-no' : $colclass_uc = 'huge' );
            $fr = $data['count'];
            if(empty($fr) ? $colclass_fr = 'huge-no' : $colclass_fr = 'huge' );
            foreach ($galerie_msg as $tmp) {
            $ms += count(array_filter(unserialize($tmp)));
            if(empty($ms) ? $colclass_ms = 'huge-no' : $colclass_ms = 'huge' );
           }
           foreach ($user_check as $val) {
           $ch += count(array_filter(unserialize($val)));
           if(empty($ch) ? $colclass_ch = 'huge-no' : $colclass_ch = 'huge' );
           }
            if(empty($this->settings['license_aktiv'])){
                $pro_txt='<br><br>
                        <div class="container">
                       
                       <div id="pro_version" class="col-md-12 text-center">
                        <div class="alert alert-default alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Schließen"><span aria-hidden="true"><b class="dan">&times;</b></span></button>
                       <div class="col-md-2"><a href="'.ART_PICTURE_SALE.'"target="_blank"><img src="'.plugins_url('../assets/images/galerie-pro/verpackung-frei-small.png"',__FILE__).' class="img-responsive" height="128" width="89"></a> <br>
                       <b class="grey"><a class="grey" role="button" href="'.ART_PICTURE_SALE.'" target="_blank">Art-Picture Galerie</b><b class="dan"> Pro</a></b></b></div>
                       <div id="div2" class="divTimes">
                       <b class="grey">In der <b class="prem"><a class="prem" role="button" href="'.ART_PICTURE_SALE.'" target="_blank" <u> pro</b><b class="dan">Version</a></b></u> unbegrenzt Benutzer und Freigaben erstellen.
                       </div>
                       <p><a role="button" href="'.ART_PICTURE_SALE.'"target="_blank"><strong class="dan"> CLICK </strong></a>für die Vollversion der <a class="grey" role="button" href="https://art-picturedesign.de/"target="_blank"><b class="warn">Art</b>Picture Galerie</a></b></p>
                       </div><br />
                       </div></div></div>';
            }else{
                $pro_txt='<br><br><div class="col-md-12"><p><div class="col-md-3"><hr class="hr-light"></div><br><span class="grey glyphicon glyphicon-copyright-mark"></span><a role="button" href="https://art-picturedesign.de/"target="_blank"> <b class="warn">Art</b><b class="grey">Picture Design </a></b><b class="warn"> '.date('Y').'</b></p><div class="col-md-3"><hr class="hr-light"></div><br></div>';
            }
            global $user_info;
            $user_info = get_userdata(get_current_user_id());       
            $header = '
                       <div class="row">
                       <div class="col-md-3">
                       <img src = "'.plugins_url('../assets/images/Logo-Art-Picture-galerie-B.png',__FILE__).'"width="249" height="227">
                       </div>
                       <div class="col-md-9">
                       <br /><br />
                       <div class="col-lg-3 col-md-5 col-sm-5">
				       <div class="panel panel-edit ">
					   <div class="panel-heading">
					   <div class="row">
					   <div class="col-xs-3">
					   <i class="fa fa-user fa-5x"></i>
					   </div>
    				   <div class="col-xs-9 text-right">
					   <div class="'.$colclass_uc.'" id="image_total">'.$uc.'</div>
					   <div class="galerie-head">User</div>
					   </div>
					   </div>
					   </div>
					   <a role="button" onclick="template_user_details();"  '.$disab1ed1.'>
			           <div class="panel-footer">
			           <span class="pull-left"><b class="warn">CLICK</b> für Details</span>
					   <span class="pull-right"><i class=" fa fa-arrow-circle-right "></i></span>
			           <div class="clearfix"></div>
			           </div>
					   </a>
				       </div>
			           </div>
                       <div class="col-lg-3 col-md-5 col-sm-5">
				       <div class="panel panel-edit ">
					   <div class="panel-heading">
					   <div class="row">
					   <div class="col-xs-3">
					   <i class="fa fa-share-square-o fa-5x"></i>
					   </div>
					   <div class="col-xs-9 text-right">
					   <div class="'.$colclass_fr.'" id="image_total">'.$fr.'</div>
					   <div class="galerie-head">Freigaben</div>
					   </div>
					   </div>
					   </div>
					   <a role="button" onclick="load_user_freigaben();" '.$disab1ed1.'>
					   <div class="panel-footer">
					   <span class="pull-left"><b class="warn">CLICK</b> für Details</span>
					   <span class="pull-right"><i class=" fa fa-arrow-circle-right "></i></span>
					   <div class="clearfix"></div>
					   </div>
					   </a>
				       </div>
			           </div>
                       <div class="col-lg-3 col-md-5 col-sm-5">
				       <div class="panel panel-edit ">
					   <div class="panel-heading">
					   <div class="row">
					   <div class="col-xs-3">
					   <i class="fa fa-check-square-o fa-5x"></i>
					   </div>
	     		       <div class="col-xs-9 text-right">
					   <div class="'.$colclass_ch.'" id="image_total">'.$ch.'</div>
					   <div class="galerie-head">checked</div>
					   </div>
					   </div>
					   </div>
					   <a role="button" onclick="load_user_freigaben();" ' .$disab1ed1.'>
					   <div class="panel-footer">
					   <span class="pull-left"><b class="warn">CLICK</b> für Details</span>
					   <span class="pull-right"><i class=" fa fa-arrow-circle-right "></i></span>
					   <div class="clearfix"></div>
					   </div>
					   </a>
				       </div>
			           </div>
                       <div class="col-lg-3 col-md-5 col-sm-5">
				       <div class="panel panel-edit ">
					   <div class="panel-heading">
					   <div class="row">
					   <div class="col-xs-3">
					   <i class="fa fa-comments-o fa-5x"></i>
					   </div>
			           <div class="col-xs-9 text-right">
					   <div class="'.$colclass_ms.'" id="image_total">'.$ms.'</div>
					   <div class="galerie-head">Message</div>
					   </div>
					   </div>
					   </div>
					   <a role="button" onclick="load_user_freigaben();" ' .$disab1ed1.'>
					   <div class="panel-footer">
					   <span class="pull-left"><b class="warn">CLICK</b> für Details</span>
			           <span class="pull-right"><i class=" fa fa-arrow-circle-right "></i></span>
					   <div class="clearfix"></div>
					   </div>
					   </a>
				       </div>
			           </div>
                       </div>
                       </div>
                       </section>
                       <div class="row">
                       <div class="col-md-8">
                       <div id="menue_title">
                       <h3 class="warn">Benutzer <small>freigaben</small></h3>
                       </div> </div><br />
                       <div class="pull-right"style="padding-left:15px;">
                       <i class="text-right warn fa fa-user"></i><b style="color:#868686;">&nbsp; eingeloggt als</b><b class="warn"> '.$user_info->user_nicename.'</b>
                       </div>
                       </div>
                       <hr class="hr-gray">';
             $header = preg_replace(array('/<!--(.*)-->/Uis', "/[[:blank:]]+/"), array('', ' '), str_replace(array("\n","\r","\t"), '', $header));
             $body = ' <div class="aktion_menue">
                       <div class="col-md-8 col-md-offset-2">
                       <div class="table-responsive">
                       <table class="table text-center">
                       <tbody>
                       <tr>
                       <td>
                       <h4 class="warn"><span class="fa fa-angle-double-right"></span> Benutzer<small> Einstellungen</small> <span class="fa fa-angle-double-left"></span></h4>
                       <hr class="hr-gray"><br>
                       <button class="chip btn-user"role="button"onclick="new_user_template();">
                       <span class="menue"><b class="warn fa fa-user fa-2x"></b></span>
                       <b class="warn"><b style="color: #868686;">&nbsp; neuer</b> Benutzer</b>
                       </button><br /><br />
                       <button class="chip btn-user "role="button"onclick="template_user_details();">
                       <span class="menue"><b class="warn fa fa-cogs fa-2x"></b></span>
                       <b class="warn"><b style="color: #868686;"> Benutzer</b> settings</b>
                       </button>
                       <br><br>
                       <button class="chip btn-user "role="button"onclick="template_read_messages();">
                       <span class="menue"><b class="warn fa fa-comments-o fa-2x"></b></span>
                       <b class="warn"><b style="color: #868686;"> Benutzer</b> Message</b>
                       </button>
                        <br><br><br>
                        <hr class="hr-light">
                        <br>
                       <a href="admin.php?page=art-Picture-help"><button class="chip btn-user "role="button"onclick="load_help();">
                       <span class="menue"><b class="warn fa fa-lightbulb-o fa-2x"></b></span>
                       <b class="warn"><b style="color: #868686;"> ArtPicture</b> Hilfe</b>
                       </button></a>
                       <br /><br />
                       </td>
                       <td>
                        <h4 class="warn"><span class="fa fa-angle-double-right"></span> Freigabe<small> Einstellungen</small> <span class="fa fa-angle-double-left"></span></h4>
                       <hr class="hr-gray"><br>
                       <button class="chip btn-user "role="button"onclick="new_freigabe_template();">
                       <span class="menue"><b class="warn fa fa-folder-open-o fa-2x"></b></span>
                       <b class="warn"><b style="color: #868686;">&nbsp; neue</b> Freigabe</b>
                       </button>
                       <br /><br />
                       <button class="chip btn-user "role="button"onclick="load_user_freigaben();">
                       <span class="menue"><b class="warn fa fa-cogs fa-2x"></b></span>
                       <b class="warn"><b style="color: #868686;"> Freigabe</b> Settings</b>
                       </button>
                        <br /><br />
                       <button class="chip btn-user "role="button"onclick="load_user_log(\'start\');">
                       <span class="menue"><b class="warn fa fa-inbox fa-2x"></b></span>
                       <b class="warn"><b style="color: #868686;"> Benutzer</b> Logdatei</b>
                       </button>
                       <br><br>
                      <br>
                       <hr class="hr-light">
                       </td>
                       </tr>
                    
                       </tbody>
                       </table>
                       </div>
                       <span class="prem fa fa-info-circle fa-2x"></span>   <b class="prem">Die Login Url des User-Templates ist:</b><br>
                       <a class="grey" role="button" href="'.site_url().'?apg-user-gallery-template=12067102" target="_blank">'.site_url().'?apg-user-gallery-template=12067102</a>
                       </div>
                      '.$pro_txt.'
                    
                       <br /> ';
            $body = preg_replace(array('/<!--(.*)-->/Uis', "/[[:blank:]]+/"), array('', ' '), str_replace(array("\n","\r","\t"), '', $body));
            $return = array("header"=>$header,"body"=>$body);
            return $return;
        }
    
    }
       private function template_user_details($daten)
   {       
          $modal1 = '#FreigabeModal"data-whatever=" '.$daten->id.'_load_notiz_modal+user"'; 

            //if PRO VERSION
           
      
    $a2 = array("method" =>"read_wp_db",
                        "table"    =>"art_user",
                        "select"   =>" *");
            $dat2 = new DbHandle($a2);
            $row=$dat2->return;
            if(empty($this->settings['license_aktiv']) && $row['count'] >= 1){
           $pro_text='
           <h5 class="grey">Der erste Benutzer ist aktiv. Alle anderen Benutzer sind deaktiviert. Mit der <a class="prem" role="button" href="'.ART_PICTURE_SALE.'" target="_blank"> Art-Picture Galerie <b class="dan">Pro</b></a> können Sie unbegrenzt viele Benutzer Freigaben erstellen.</h5>';
            
            $pw_senden_value= 0;
            $enabled_pro_mail =' disabled';
            $txt ='<i><a role="button" href="'.ART_PICTURE_SALE.'" target="_blank"> <b class="dan"> Pro</b><b class="grey">Version</b></a></i>'; 
            $checked_pro ='';    
            }else{
            $pw_senden_value= 1;
            $enabled_pro_mail ='';
            $txt ='';
            $checked_pro=' checked';    
            }
          $tt = $this->tt;  
          $date1 = new \DateTime($data['created_at']); 
          $datum1 = $date1->format('d.m.Y');
          if(empty($daten->last_update)){
            $datum2 = 'unbekannt';
          }else{
          $date2 = new \DateTime($data['last_update']); 
          $datum2 = $date2->format('d.m.Y'); 
          }
          if(empty($daten->email_aktiv)){
            $aktiv1 = 0;
            $check1 = '';
          }else{
            $aktiv1 = 1;
            $check1 = 'checked';
          }
            if(empty($daten->htaccess_aktiv)){
            $aktiv2 = 0;
            $check2 = '';
          }else{
            $aktiv2 = 1;
            $check2 = 'checked';
          }
            
           $template ='
                <div class="displaystyle displaystyle-fullborder displaystyle-warning displaystyle-sm">
                 <div class="table-responsive">
                 <h4 class="warn">'.$daten->htaccess_vorname.' <span class="prem">'.$daten->htaccess_nachname.'</span> <small>(<span class="prem">letztes Update:</span> '.$datum2.' )</small></h4>
                 <table class="details table ">
                 <thead>
                 <tr>
                 <th>ID</th>
                   
                 <th>
                 <i class="fa fa-check-square-o"></i> user aktiv<a class="wptool" data-toggle="tooltip" title="'.$tt['tt_htaccess_aktiv'].'">
                 <span class="prem fa fa-question-circle"></span></a>
                 </th>
                 <th><i class="fa fa-check-square-o"></i> message
                 <a class="wptool" data-toggle="tooltip" title="'.$tt['tt_email_aktiv'].'">
                 <span class="prem fa fa-question-circle"></span></a>
                 </th>
                 <th><i class="fa fa-calendar-o"></i> hinzugefügt </th>
                 <th><i class="fa fa-envelope-o"></i> email 
                 <a class="wptool" data-toggle="tooltip" title="'.$tt['tt_user_email'].'">
                 <span class="prem fa fa-question-circle"></span></a>
                 </th>
                 <th><i class="fa fa-user"></i> user Login 
                 <a class="wptool" data-toggle="tooltip" title="'.$tt['tt_user_login'].'">
                 <span class="prem fa fa-question-circle"></span></a>
                 </th>
                 <th><i class="fa fa-lock"></i> user Passwort
                 <a class="wptool" data-toggle="tooltip" title="'.$tt['tt_user_passwort'].'">
                 <span class="prem fa fa-question-circle"></span></a>
                 </th>
                 <th><i class="fa fa-trash"></i> user löschen 
                 <a class="wptool" data-toggle="tooltip" title="'.$tt['tt_user_delete'].'">
                 <span class="prem fa fa-question-circle"></span></a>
                 </th>
             
                 </tr>
                 </thead>  
                 <tr>
                 <td>'.$daten->id.'</td>
                 <td>
                 <label class="switch">                                                                
                 <input id="'.$daten->id.'_htaccess_aktiv" value="'.$aktiv2.'"type="checkbox" onclick="htaccess_aktiv(\''.$daten->id.'_htaccess_aktiv\');"
                 '.$check2.'> 
                  <span class="slider round"></span>
                  </label>
                 <br><br><a role="button"data-toggle="modal"data-target="'.$modal1.' style="color:#7d7d7d;"><span class="prem fa fa-info-circle"></span><b class="warn"> Benutzer</b><u> Notiz</u></a>
                 </td>
                  <td>
                 <label class="switch">                                                                
                 <input id="'.$daten->id.'_email_aktiv" value="'.$aktiv1.'"type="checkbox" onclick="htaccess_aktiv(\''.$daten->id.'_email_aktiv\');"
                 '.$check1.'> 
                  <span class="slider round"></span>
                  </label>
                 <br><br><a role="button"data-toggle="modal"data-target="#FreigabeModal"data-whatever=" '.$daten->id.'_load_send_email_modal+user" style="color:#7d7d7d;"><span class="prem fa fa-info-circle"></span><b class="warn"> eMail</b> <u>Senden</u></a>
                 
                 
                 <td><b style="color:#7d7d7d;">'.$datum1.'</b></td>
                 <td>
                 <input name="'.$daten->id.'_htaccess_email"type="email"autocomplete="new-password"placeholder="'.$daten->htaccess_email.'"required> <br><br>
                 <button type="button"class="btn btn-primary btn-outline btn-xs"
                 onclick="change_user_data(\''.$daten->id.'_htaccess_email\');"><span class="fa fa-save"></span> neue eMail Adresse</button>
                 </td>
                 <td><b style="color:#7d7d7d;">'.$daten->htaccess_user.'</b></td>
                 <td>
                 <input name="'.$daten->id.'_htaccess_passwort"type="password"autocomplete="new-password"placeholder="Passwort gesetzt"required> <br><br>
                 <button type="button"class="btn btn-primary btn-outline btn-xs"
                 onclick="change_user_data(\''.$daten->id.'_htaccess_passwort\',\''.$daten->id.'\');"><span class="fa fa-save"></span> neues Passwort</button>
                <div class="checkbox">
                <label>
                <input type="checkbox" name="'.$daten->id.'_send_new_pw"onchange="checked_send_email_newpw(\''.$daten->id.'\');" id="'.$daten->id.'_send_new_pw" value="'.$pw_senden_value.'"
                '.$enabled_pro_mail.' '.$checked_pro.'><span class="prem fa fa-envelope-o"></span> neues Passwort senden? '.$txt.'
                </label>
                </div>
                 </td>
                  <td class="text-center"style="padding-top:25px;">
                   <a  role="button" class="btn btn-danger btn-outline btn-circle btn-sm"
                   data-toggle="modal"data-target="#FreigabeModal"data-whatever="'.$daten->id.'_load_delete_user_modal+galerieLoadDetails">
                   <p style="margin-top:3px; " class="fa fa-trash-o"></p></a><br><b class="dan">löschen</b></td>
                 </tr>
                 </table>
                  '.$pro_text.'
                 </div><hr class="hr-footer"></div>';
                  $template = preg_replace(array('/<!--(.*)-->/Uis', "/[[:blank:]]+/"), array('', ' '), str_replace(array("\n","\r","\t"), '', $template));
                return $template;
                //
   }
  private static function user_details_auswahl($select="")
   {
            $select_user          = '<hr class="hr-light"><h5 class="prem">&nbsp;&nbsp; Auswahl <small>eingrenzen</small></h5>
                                    <div class="form-inline">&nbsp;&nbsp;
                                    <select class="form-control"onchange="freigabe_details_user_select(this.value)">';
            $select_user         .= '<option value="">auswahl Benutzername</option>';
            $select_galerie       = '<select class="form-control"onchange="freigabe_details_user_select(this.value)">';
            $select_galerie      .= '<option value="">auswahl Galerie</option>';
            $select_user_footer   = '</select>';
            $div                  = '</div><br><hr class="hr-light">';  
   
   
            $a2 = array("method"   =>"user_wp_freigabe_start");
            $dat2 = new DbHandle($a2);
            $data2=$dat2->return;
            for ($i = 0; $i <= $data2['count']; $i++) {
            $gal .= $data2['data'][$i]->galerie_name.',';
            $usr .= $data2['data'][$i]->htaccess_user.',';
            }
            $galerie_select = array_filter(array_unique(explode(",",$gal)));
            $user_select    = array_filter(array_unique(explode(",",$usr)));

            foreach ($user_select as $tmp){
             if($tmp == $select){
               $sel1 = ' selected="selected"'; 
             }else{
                $sel1 = '';
             }   
            $select_user .= '<option value="user_'.(string)$tmp.'" '.$sel1.'>'.$tmp.'</option>';
            }
            foreach ($galerie_select as $tmp1){
               if($tmp1 == $select){
               $sel2 = ' selected="selected"'; 
             }else{
                $sel2 = '';
             }   
            $select_galerie .= '<option value="galerie_'.(string)$tmp1.'" '.$sel2.'>'.$tmp1.'</option>';
            }
            $galerie = $select_galerie .  $select_user_footer; 
            $user = $select_user . $select_user_footer;
            $return = $user . '&nbsp;&nbsp;' . $galerie . $div;
            $return = preg_replace(array('/<!--(.*)-->/Uis', "/[[:blank:]]+/"), array('', ' '), str_replace(array("\n","\r","\t"), '', $return));
            return $return;
   
   }
 protected function close_btn($select="")
 {
    if(empty($select)){
        $typ = 'close_details();';
    }else{
        $typ = 'close_select();';
    }
  $close = '<a class="dan" role="button"onclick="'.$typ.'">
            <p class="dan text-right"style="margin-right:25px;">
	        <i class="fa fa-times fa-2x"></i>
            <strong>&nbsp;schließen</strong></p></a>';
  $close = preg_replace(array('/<!--(.*)-->/Uis', "/[[:blank:]]+/"), array('', ' '), str_replace(array("\n","\r","\t"), '', $close));           
 return $close;
 }
 protected static function btn_group_response($htaccess_id,$load)
 {
    $btn = '<input id="loaded_typ" type="hidden" value="'.$load.'">
            <div class ="row"><h4>&nbsp;&nbsp;&nbsp;&nbsp;<small class="prem">Grid</small> 
            <a role="button" id="grid" class="prem fa fa-th"onclick ="show_response_details(\'grid\',\''.$htaccess_id.'_start\');"></a>
            <a role="button" id="list"class="font-inaktiv fa fa-th-list"onclick ="show_response_details(\'details\',\''.$htaccess_id.'_start\');"></a>
            <small class="prem"> Liste</small></h4></div>
            <div class="row"><div class="col-md-6 col-sm-6"><hr class="hr-footer"><br><div class="btn-group">
            <button type="button" class="btn btn-warning btn-outline btn-sm" onclick ="show_response_details(\'start\',\''.$htaccess_id.'_kommentar\');"><span class="fa fa-comments"></span> nur mit Kommentar</button>
            <button type="button" class="btn btn-primary btn-outline btn-sm" onclick ="show_response_details(\'start\',\''.$htaccess_id.'_alle\');"><span class="fa fa-angle-double-right"></span> alle <span class="fa fa-angle-double-left"></span></button>
            <button type="button" class="btn btn-warning btn-outline btn-sm" onclick ="show_response_details(\'start\',\''.$htaccess_id.'_checked\');"><span class="fa fa-check-square-o"></span>  nur ausgewählte</button>
            </div><br><br><hr class="hr-footer"><br></div></div>';
             $btn = preg_replace(array('/<!--(.*)-->/Uis', "/[[:blank:]]+/"), array('', ' '), str_replace(array("\n","\r","\t"), '', $btn));
             return $btn;
 } 
   private static function user_response_auswahl()
   {
       $a1 = array("method"   =>"user_wp_freigabe_start");
       $dat1 = new DbHandle($a1);
       $data=$dat1->return;
     
      if(empty($data['count'])){
        $return = array("status"=>false,"message"=>"keine freigaben vorhanden!");
        return $return;
      }
      $select_user          = '<hr class="hr-light"><h5 class="prem">&nbsp;&nbsp; schnell <small>Auswahl</small></h5>
                               <div class="form-inline">&nbsp;&nbsp;
                               <select class="form-control"onchange="show_response_details(this.value)">';
      $select_user         .= '<option value="">auswahl Benutzer-Galerie</option>';
      $select_user_footer   = '</select></div><br><hr class="hr-light">';
      foreach ($data['data'] as $tmp)
      {
       if(!empty($tmp->select_image)){ 
           $check = array_filter(unserialize($tmp->select_image));
           $cc = count($check);  
        }else{
            $cc = 0;
        }
        if(!empty($tmp->message)){
           $msg = array_filter(unserialize($tmp->message));  
           $mc = count($msg); 
        }else{
            $mc = 0;
        }
        $count = $cc + $mc;
        if($count > 0){
        $select_user .= '<option value="'.(int)$tmp->freigabe_id.'" >'.$tmp->htaccess_vorname.' '.$tmp->htaccess_nachname. '  |  '.$tmp->galerie_name.'</option>';
        }else{
           
        $select_user .='';   
        }
       }
       $return = $select_user . $select_user_footer; 
       $return = preg_replace(array('/<!--(.*)-->/Uis', "/[[:blank:]]+/"), array('', ' '), str_replace(array("\n","\r","\t"), '', $return));
       return $return; 
      
   }
 protected function user_response_template($htaccess_id,$wahl,$layout="")
 {
           //daten aus DB holen 
           if(empty($layout)){
            $layout = 'grid';
           }
          $a1 = array("method"  => "user_wp_response",
                      "data"   => array("freigabe_id"  => $htaccess_id));
            $dat1 = new DbHandle($a1);
            $data=$dat1->return;
            if(empty($data['count'])){
            return array("status"=>false,"template"=>"");   
            }
         
            //message zerlegen und für array vorbereiten
           if(!empty($data['data'][0]->message)){ 
            $mc = array_filter(array_unique(unserialize($data['data'][0]->message)));
              if(count($mc) > 0){
                 for ($x = 0; $x <= count($mc); $x++) {
                 $mid .= substr($mc[$x],0,strpos($mc[$x],'_')).',';
                 $me  .= substr($mc[$x],strpos($mc[$x],'_')+1).',';    
                }
              }
            }
        
            //checked array vorbereiten
            if(!empty($data['data'][0]->select_image)){
              $cc = array_filter(array_unique(unserialize($data['data'][0]->select_image)));
              if(count($cc) > 0){
                foreach($cc as $key => $val){
                  $cid .= $val.',';  
                }
              }
            }
            // alle arrays erstellen
           $message_id = array_filter(array_unique(explode(",",$mid)));
           $message    = array_filter(explode(",",$me));             
           $check_id   = array_filter(explode(",",$cid));
          
               //auf doppelte Einträge überprüfen und array mit imageID für Bild abruf vorbereiten 
               if($wahl == 'start'){
                  $wahl = 'alle';
               }
                if($wahl == 'checked'){
                    if(count($check_id) == 0){
                    $response = self::response('22');    
                    $return = array("template"=>$response['response_msg'],"status"=>false,"total"=>0);

                    return $return;    
                    }
                for ($y = 0; $y <= count($check_id); $y++) {
                if(!empty($check_id[$y])){
                if(!in_array($check_id[$y],$message_id)) {   
                $img_id .= $check_id[$y].',';
                }
               }
              }
             }elseif($wahl == 'kommentar'){
             if (count($mc) == 0){
             $response = self::response('25');    
             $return = array("template"=>$response['response_msg'],"status"=>false,"total"=>0);
             return $return;    
             } 
               for ($z = 0; $z <= count($mc); $z++) {
               $img_id .= $message_id[$z].',';
               } 
              }elseif($wahl == 'alle'){
                for ($y = 0; $y <= count($check_id); $y++) {
                if(!empty($check_id[$y])){
                if(!in_array($check_id[$y],$message_id)) {   
                $img_id .= $check_id[$y].',';
                }
               }else{
                for ($z = 0; $z <= count($mc); $z++) {
                $img_id .= $message_id[$z].',';
                }
               }
              }
             }else{
               return false;
               }
            //array mit Image ID erzeugen
            $id = array_filter(array_unique(explode(",",$img_id)));
            
            //abruf der Daten aus der Image Tabelle
            for ($t = 1; $t <= count($id); $t++) {
            //Überprüfen ob für diese ID eine Message vorhanden ist
            if(in_array($id[$t -1],$message_id)){
              for ($v = 1; $v <= count($message_id); $v++) {
                if($id[$t -1] == $message_id[$v -1] )
                $msg = $message[$v -1];
                }
               }
             //überprüfen ob Bild checked und Layout anpassen   
             if(in_array($id[$t -1],$check_id)){
                 $checked = '<span class="suss fa fa-check"></span>';
                 $color  =  'suss';   
                }else{
                 $checked = '<span class="dan fa fa-times"></span>';
                 $color = 'dan';    
                }
          
             //abfrage image table
            $a2 = array("method" =>"read_wp_db",
                       "table"  =>"art_images",
                       "select" =>"*",
                       "where"  =>" where id = %d",
                       "search" =>$id[$t -1]);
             $dat2 = new DbHandle($a2);
             $data2 = $dat2->return; 
             
             //datum last update
             if(empty($data['data'][0]->freigabe_update)){
             $datum = 'unbekannt';
             }else{
             $date = new \DateTime($data['data'][0]->freigabe_update); 
             $datum = $date->format('d.m.Y');
             }
             $date2 = new \DateTime(); 
             $datum2 = $date2->format('Y');
             switch ($layout)
             {
                    //ausgabe template mit allen Daten  
         case 'grid':
         $template .= '<div class="col-sm-3 col-md-3">
                       <hr class="hr-light">
                       <h5 class="warn"><span class="fa fa-user"></span> '.$data['data'][0]->htaccess_vorname.' <span style="color: grey;">'.$data['data'][0]->htaccess_nachname.'
                       </span><small class="prem"> (Galerie: '.$data2['data'][0]->galerie_name.')</small></h5>
                       <hr class="hr-footer">
                       <small><b class="prem">NAME:</b>&nbsp;'.$data2['data'][0]->name.'</small> 
                       <br />
                       <small><b class="prem">ID:</b>&nbsp;&nbsp;'.$data2['data'][0]->id.'</small> 
                       <br />
                       <hr class="hr-light">
                       <br />
                       <div class="thumbnail displaystyle-warning">
                       <br>
                       <a data-gallery="" href="'.htmlspecialchars(trim($data2['data'][0]->url)).'" title="kommentar: '.$msg.'">
                       <img src="'.htmlspecialchars(trim($data2['data'][0]->thumbnailUrl)).'" alt="'.$data2['data'][0]->name.'" style="width: 180px; height: 100%;  display: block;"></a>
                       <div class="caption">
                       <div class=" kommentar">
                       <strong class="'.$color.'"> Checked:</strong>&nbsp; '.$checked.'
                       </div>
                       <hr class="hr-light">
                       <b style="color: grey;">User Kommentar:</b>
                       <div class="user-response">
                       '.$msg.'
                       </div>
                       <h5 class="prem"><span class="warn fa fa-calendar"></span> last update:</span><small> '.$datum.'</small> </h5> 
                       <hr class="hr-light">
                       <small class="prem"><small><strong>Art<span class="warn">Picture <strong class="prem">Galerie '.$datum2.'</strong></strong></span></small></small>
                       </div>
                       </div>
                       </div>';
                       break;
         case 'details':
         $template .= '
                 <div class="details table-responsive">
                 <div class="col-sm-4 col-md-4">
                       <hr class="hr-footer">
                       <h5 class="warn"><span class="fa fa-user"></span> '.$data['data'][0]->htaccess_vorname.' <span style="color: grey;">'.$data['data'][0]->htaccess_nachname.'
                       </span><small class="prem"> (Galerie: '.$data2['data'][0]->galerie_name.')</small></h5>
                       <hr class="hr-footer"></div> 
                 <table class="table">
                 <thead>
                 <tr>
                 <th><i class="prem fa fa-photo"></i> Bild 
                 </th>
                 <th><i class="prem fa fa-info"></i> ID:  
                 </th>
                 <th><i class="prem fa fa-info"></i> Name 
                 </th>
                 <th><i class="prem fa fa-user"></i> User 
                 </th>
                 <th><i class="prem fa fa-photo"></i> Galerie 
                 </th>
                 <th><i class="prem fa fa-check"></i> Checked 
                 </th>
                 <th><i class="prem fa fa-comment"></i> Kommentar 
                 </th>
                 </tr>
                 </thead>  
                 <tr>
                 <td>
                 <a data-gallery="" href="'.htmlspecialchars(trim($data2['data'][0]->url)).'" title="kommentar: '.$msg.'">
                 <img src="'.htmlspecialchars(trim($data2['data'][0]->thumbnailUrl)).'" alt="'.$data2['data'][0]->name.'" style="width: 45px; height: 45px;  display: block;"></a>
                 </td>
                 <td>
                 <strong class="prem">'.$data2['data'][0]->id.'</strong>
                 </td>
                 <td>
                <strong class ="grey"> '.$data2['data'][0]->name.'</strong>  
                 </td>
                 <td>
                  <strong class="grey">'.$data['data'][0]->htaccess_user.'</strong>  
                 </td>
                 <td>
                <strong class="grey">'.$data2['data'][0]->galerie_name.'</strong>
                 </td>
                 <td>

                  <strong class="'.$color.'"> Checked:</strong>&nbsp; '.$checked.'  
                 </td>
                 <td>
                <strong class="grey">'.$msg.'</strong>
                </td>
                </tr>
                </table>
                </div>
                <hr class="hr-light">
                <h5 class="prem"><span class="fa fa-calendar-o"></span> last update<small> ('.$datum.') </small></h5>
                <hr class = "hr-light">
                <br>';               
                break;
           }
        }
   
        $template = preg_replace(array('/<!--(.*)-->/Uis', "/[[:blank:]]+/"), array('', ' '), str_replace(array("\n","\r","\t"), '', $template));
        $return = array("template"=>$template,"status"=>true,"total"=>count($id));
        return $return;
 } 
private function start_user_response_template() {
       $a1 = array("method"   =>"user_wp_freigabe_start");
       $dat1 = new DbHandle($a1);
       $data=$dat1->return;
      if(empty($data['count'])){
        $return = array("status"=>false,"message"=>"keine freigaben vorhanden!");
        return $return;
      }
       $close = self::user_response_auswahl();
       foreach ($data['data'] as $tmp)  
         {
         if(!empty($tmp->select_image)){ 
         $check = array_filter(unserialize($tmp->select_image));
         $cc = count($check);
         }else{
         $cc = 0;
        }
        if($cc > 0){
             $badge1 = ' style="background-color:green;"';
        }else{
            $badge1 = ' style="background-color:#c75e47;"';
        }
        if(!empty($tmp->message)){
         $msg = array_filter(unserialize($tmp->message));  
         $mc = count($msg); 
        }else{
          $mc = 0;
          
        }
        if($mc > 0){
         $badge2 = ' style="background-color:green;"';   
        }else{
         $badge2 = ' style="background-color:#c75e47;"';   
        }

        $count = $cc + $mc;
        if(!empty($count ))
        {
        $date1 = new \DateTime($tmp->created_at); 
        $datum1 = $date1->format('d.m.Y'); 
        if(empty($tmp->freigabe_update)){
        $datum2 = 'unbekannt';    
        }else{
        $date2 = new \DateTime($tmp->freigabe_update); 
        $datum2 = $date2->format('d.m.Y');    
        }
           
        $template .= ' 
                 <div class="displaystyle displaystyle-fullborder displaystyle-warning displaystyle-sm">  
                 <div class="table-responsive">
                 <div class="panel-heading panel-primary"><h5 class="warn"><span class="warn fa fa-user"></span>
                 '.$tmp->htaccess_vorname.' <span class ="prem">'.$tmp->htaccess_nachname.'</span><span class="grey">
                  | Galerie: '.$tmp->galerie_name.' <small>( <span class="prem fa fa-calendar-o"></span> erstellt am: '.$datum1.' )</small></span></h5>
                 </div>
                 <div class="panel-body">
                 <table class="details table ">
                 <thead>
                 <tr>
             
                 <th>ID: 
                 </th>
                 <th><i class="fa fa-info"></i> User ID: 
                 <a class="wptool" data-toggle="tooltip" title="'.$this->tt['tt_gps_aktiv'].'">
                 <span class="prem fa fa-question-circle"></span></a>
                 </th>
                 <th><i class="fa fa-user"></i> User Login: 
                 <a class="wptool" data-toggle="tooltip" title="'.$this->tt['tt_gps_aktiv'].'">
                 <span class="prem fa fa-question-circle"></span></a>
                 </th>
                 <th><i class="fa fa-photo"></i> Galerie 
                 <a class="wptool" data-toggle="tooltip" title="'.$this->tt['tt_exif_aktiv'].'">
                 <span class="prem fa fa-question-circle"></span></a>
                  </th>
                 <th><i class="fa fa-comments"></i> Message 
                 <a class="wptool" data-toggle="tooltip" title="'.$this->tt['tt_auswahl_aktiv'].'">
                 <span class="prem fa fa-question-circle"></span></a>
                 </th>
                 <th><i class="fa fa-check"></i> check 
                 <a class="wptool" data-toggle="tooltip" title="'.$this->tt['tt_kommentar_aktiv'].'">
                 <span class="prem fa fa-question-circle"></span></a>
                 </th>
                 <th><i class="fa fa-search"></i> anzeigen</th>
                 </tr>
                 </thead>  
                 <tr>
              
                  <td>
                  <b class ="prem">'.$tmp->freigabe_id.'</b>
                 </td>
                 <td>
                 <b class ="grey">'.$tmp->id.'</b>   
                 </td>
                 <td><b class ="grey">'.$tmp->htaccess_user.'</b> </td>
                 <td>
                 <b class ="grey">'.$tmp->galerie_name.'</b>
                 </td>
                 <td>
                 <span class="badge" '.$badge2.'>'.$mc.'</span>
                 </td>
                 <td>
                 <span class="badge" '.$badge1.'>'.$cc.'</span>
                 </td>
                 <td>
                 <button class="btn btn-primary btn-outline btn-sm" onclick="show_response_details(\''.$tmp->freigabe_id.'\');"><span class="fa fa-search"></span> anzeigen</button>
                 </td>
                 
                </tr>
                </table>
                </div></div>
                <div class="panel-footer panel-primary">
                <h5 class="prem"><span class="fa fa-calendar-o"></span> last update<small> ('.$datum2.') </small></h5>
                <br></div></div>';
                }}
                $template = preg_replace(array('/<!--(.*)-->/Uis', "/[[:blank:]]+/"), array('', ' '), str_replace(array("\n","\r","\t"), '', $template)); 
                $close = preg_replace(array('/<!--(.*)-->/Uis', "/[[:blank:]]+/"), array('', ' '), str_replace(array("\n","\r","\t"), '', $close)); 
                return array("template"=>$template,"close"=>$close);
          
   }
   public  function send_userdaten_mail($daten)
   {
            $settings = ApgSettings::load_settings('user_settings');
             if(empty($settings['license_aktiv'])){
              return false;   
             }
             $url=site_url().'?apg-user-gallery-template=12067102';
            global $user_info;
            $user_info = get_userdata(get_current_user_id());
            $text         = 'Hallo '.$daten['vorname'].' '.$daten['nachname'].''."\n\n".
                            'es wurde eine Galerie fuer Sie erstellt. In dieser E-Mail erhalten Sie die Zugangsdaten zum Login'."\n\n".
                            'URL:'.$url.''."\n".
                            'Name:'.$daten['bn'].''."\n".
                            'Passwort:'.$daten['pw'].''."\n\n".
                            'Wir wuenschen Ihnen viel Spass und Freude mit Ihrer Galerie.';
            $text = htmlspecialchars($text);                
            $logo = plugins_url('../assets/images/Logo-Art-Picture-galerie-B.png "height="227" width="249"  alt="artPictureGalerie',__FILE__);
            $html_url ='<a href="'.$url.'" style="color:orange;">Galerie Login</a>';
            $newLoginUrl='<a href="'.$url.'">'.$url.'</a>';
            $Userurl = get_site_url();
            @ob_start();
            $user_text = file_get_contents('templates/user-mail/zugangsdaten eMail.txt',FILE_USE_INCLUDE_PATH);
            $user_text = str_replace("[loginurl]",   $newLoginUrl, $user_text);
            $user_text = str_replace("[vorname]",    $daten['vorname'], $user_text);
            $user_text = str_replace("[nachname]",   $daten['nachname'], $user_text);
            $user_text = str_replace("[loginname]",  $daten['bn'], $user_text);
            $user_text = str_replace("[passwort]",   $daten['pw'], $user_text);
            $user_text = str_replace("###ABSEMAIL###", $user_info->user_email, $user_text);
            $user_text = str_replace("###ABSURL###",   $Userurl, $user_text);
            

            $html_text = file_get_contents('mail/send_new_user_daten.html',FILE_USE_INCLUDE_PATH);
            $html_text = str_replace("###IMAGE_LOGO###", $logo, $html_text);
            $html_text = str_replace("###LOGINURL1###",  $url, $html_text);
            $html_text = str_replace("###USERMAIL###",   $user_text, $html_text);
            $html_text = preg_replace(array('/<!--(.*)-->/Uis',"/[[:blank:]]+/"),array('',' '),str_replace(array("\n","\r","\t"),'',$html_text)); 
            @ob_end_flush();
            $attachment = '';
            $subject = 'Zugangsdaten Art-Picture Gallery'; 
            $to = $daten['email'];
            $subject = $subject;
            $body = $html_text;
           $return = wp_mail( $to, $subject, $body );
           remove_filter( 'wp_mail_content_type', 'set_html_content_type' );
           return $return;
            }

private function get_db_settings($result_typ)
 {
            /**  *
            * @result 1 return settings + htaccess 
            * @result 2 return settings + tooltip
            * @result 3 return tooltip
            */
            global $wpdb;
            $table_name = $wpdb->prefix . 'art_config';
            $result = $wpdb->get_results( 
	        "SELECT * 
		    FROM $table_name" );
            $settings = unserialize($result[0]->user_settings);
            $tooltip  = unserialize($result[0]->tooltip);
            switch ($result_typ)
            {
        case '1':
            $this->return    = $settings;
            break;
        case '2':
            $this->return   = array_merge($settings,$tooltip);
            break;
        case '3':
            $this->return   = $tooltip;
            break;
            }
            return $this->return;
 }

private static function read_usermail_verzeichnis()
 {
    $dir = __dir__ . '/templates/user-mail';
        if (!is_dir($dir)){
        mkdir($dir, 0755, true);
        self::standard_user_email_userdaten(true);
        return array("status"=>false,"files"=>null,"count"=>0);
        }
    $alledateien = scandir($dir);
   if(empty($alledateien)){
    self::standard_user_email_userdaten(true);
    $return = array("status"=>false,"files"=>null,"count"=>0);
    }else{
     foreach ($alledateien as $files)
     {
        $fileinfo = pathinfo($dir."/".$files);
        if($fileinfo['extension'] != 'txt'){
          $files = '.';  
        }
      if ($files != "." && $files != ".."  && $files != "_notes" && $fileinfo['basename'] != "Thumbs.db") {
       $file[] .= $files;
       }
     }
    
     $email = file_get_contents($dir . '/zugangsdaten eMail.txt',FILE_USE_INCLUDE_PATH);
     $return = array("status"=>true,"files"=>$file,"count"=>count($file),"daten"=>$email);
   }
   return $return;
}
private static function standard_user_email_userdaten($methode) {
    $url = get_site_url();
    global $user_info;
    $user_info = get_userdata(get_current_user_id());
    $template = '<p>&nbsp;</p>
                <hr />
                <p>&nbsp;</p>
                <p><span style="font-family: verdana, geneva; font-size: small;">Hallo [vorname] [nachname],</span></p>
                <p><span style="font-family: verdana, geneva; font-size: small;">es wurde eine Galerie f&uuml;r Sie erstellt. In dieser E-Mail erhalten Sie die Zugangsdaten zum Login.</span></p>
                <p>&nbsp;</p>
                <table style="height: 68px; width: 238px;" border="0">
                <tbody>
                <tr>
                <td><strong><span style="font-size: small;">URL:</span></strong></td>
                <td><span style="font-size: small;">[loginurl]</span></td>
                </tr>
                <tr>
                <td><strong><span style="font-size: small;">Name:</span></strong></td>
                <td><span style="font-size: small;">[loginname]</span></td>
                </tr>
                <tr>
                <td><strong><span style="font-size: small;">Passwort:</span></strong></td>
                <td><span style="font-size: small;">[passwort]</span></td>
                </tr>
                </tbody>
                </table>
                <p>&nbsp;</p>
                <p><span style="font-family: verdana, geneva; font-size: small;">F&uuml;r weitere Fragen, stehen wir Ihnen gerne zur Verf&uuml;gung.</span></p>
                <p><span style="color: #ff9900;"><span style="font-family: verdana, geneva; font-size: small;" data-mce-mark="1">
                <span style="font-family: verdana, geneva; font-size: small;" data-mce-mark="1">
                <a href="mailto:'.$user_info->user_email.'">
                <span style="font-family: verdana, geneva; font-size: small; color: #ff9900;" data-mce-mark="1">'.$user_info->user_email.'</span>

                </a></span>&nbsp;</span>&nbsp;|&nbsp; <span style="font-family: verdana, geneva; font-size: small;" data-mce-mark="1">&nbsp;
                <span style="font-family: verdana, geneva; font-size: small;" data-mce-mark="1">
                <a href="'.$url.'">
                <span style="color: #ff9900;">'.$url.'</span></a></span></span></span></p>
                <p>&nbsp;</p>
                <p><span style="font-family: verdana, geneva; font-size: small;" data-mce-mark="1"><span style="font-family: verdana, geneva; font-size: small;" data-mce-mark="1">Wir w&uuml;nschen Ihnen viel Spass und Freude mit&nbsp;</span><span style="color: #ff9900;"><strong>Art</strong></span><strong><span style="color: #808080;">Picture-Galerie</span>.</strong></span></p>
                <p><span style="font-family: verdana, geneva; font-size: small;">&nbsp;</span></p>
                <hr />
                <p>&nbsp;</p>';
    $template = preg_replace(array('/<!--(.*)-->/Uis',"/[[:blank:]]+/"),array('',' '),str_replace(array("\n","\r","\t"),'',$template));             
    if($methode === true)
    {
    $dir = __DIR__ . '/templates/user-mail/zugangsdaten eMail.txt';    
    $dh = fopen($dir, "w+");
    fwrite($dh, $template);
    fclose($dh);
    return true;
    }if($methode === false){
    return $template;   
    }
}
protected static function change_email_template($name)
{
    $dir = __dir__ . '/templates/user-mail';
    $templates = scandir($dir);
    foreach ($templates as $tmp)
   {
    $fileinfo = pathinfo($dir."/".$tmp);
     if($fileinfo['extension'] != 'txt'){
     $tmp = '.';  
     }
    if ($tmp != "." && $tmp != ".."  && $tmp != "_notes" && $fileinfo['basename'] != "Thumbs.db") {
        $file[] = $tmp;
       }
    }
    $allFiles = array_reverse($file);
    $btn_head  = '<hr class="hr-light"><br /><h5 class="warn"><span class="fa fa-angle-double-down"></span> eMail <small>Templates</small></h5><div class="btn-group">';
    $btn_foot  = '<br /><br /></div><hr class="hr-light">';
    foreach($allFiles as $val)
    {
    $fileinfo = pathinfo($dir."/".$val);    
    if($fileinfo['filename'] == $name){
    $active_class = 'primary';
    $loaded_template = $name;
    $btn_text = '<b><u>'.$fileinfo['filename'].'</u></b>';
    }else{
    $active_class = 'default';
    $btn_text = $fileinfo['filename'];
    }    
    $btn  .= '<button class="btn btn-'.$active_class.' btn-outline btn-xs" role="button" onclick="change_mail_template(\''.$fileinfo['filename'].'\');">
              <span class="fa fa-envelope-o"></span> '.$btn_text.' </button>';   
    }
    $email_template = file_get_contents($dir . '/'.$name.'.txt',FILE_USE_INCLUDE_PATH);
    $btn = preg_replace(array('/<!--(.*)-->/Uis',"/[[:blank:]]+/"),array('',' '),str_replace(array("\n","\r","\t"),'',$btn));
    $button = $btn_head . $btn .$btn_foot;
    $return = array(
                   "status" =>true,
                   "message"=>$name.' eMail Template!',
                   "links"  =>$button,
                   "daten"  =>$email_template,
                   "loaded" =>$fileinfo['filename']
                   );
    return $return;
      
}
protected static function new_email_template($name)
{
  $dir = __DIR__ . '/templates/user-mail';
  $templates = scandir($dir);

  
  foreach($templates as $files)
  {
    $template_info = pathinfo($dir."/".$files);
    if($template_info['filename'] == $name){
      return array("status"=>false,"message"=>"Name schon vorhanden");  
    }
  }
    $new_template = $dir . '/'.$name.'.txt';
    $dh = fopen($new_template, "w+");
    fwrite($dh, $name);
    fclose($dh);

    $templates = scandir($dir);
   foreach ($templates as $tmp)
   {
    $fileinfo = pathinfo($dir."/".$tmp);
     if($fileinfo['extension'] != 'txt'){
     $tmp = '.';  
     }
    if ($tmp != "." && $tmp != ".."  && $tmp != "_notes" && $fileinfo['basename'] != "Thumbs.db") {
        $file[] = $tmp;
       }
    }
    $allFiles = array_reverse($file);
    $btn_head  = '<hr class="hr-light"><br /><h5 class="warn"><span class="fa fa-angle-double-down"></span> eMail <small>Templates</small></h5><div class="btn-group">';
    $btn_foot  = '<br /><br /></div><hr class="hr-light">';
    foreach($allFiles as $val)
    {
    $fileinfo = pathinfo($dir."/".$val);
    if($fileinfo['filename'] == $name){
       $active_class = 'primary';
       $loaded_template = $name;
       $btn_text = '<b><u>'.$fileinfo['filename'].'</u></b>';
    }else{
       $active_class = 'default';
       $btn_text = $fileinfo['filename'];
    }
    $btn  .= '<button class="btn btn-'.$active_class.' btn-outline btn-xs" role="button" onclick="change_mail_template(\''.$fileinfo['filename'].'\');">
             <span class="fa fa-envelope-o"></span> '.$btn_text.' </button>';
    }

     $email_template = file_get_contents($dir . '/'.$name.'.txt',FILE_USE_INCLUDE_PATH);
     $btn = preg_replace(array('/<!--(.*)-->/Uis',"/[[:blank:]]+/"),array('',' '),str_replace(array("\n","\r","\t"),'',$btn));
  
   $button = $btn_head . $btn . $btn_foot;
   $return = array(
                   "status" =>true,
                   "message"=>$name.' erstellt!',
                   "links"  =>$button,
                   "daten"  =>$email_template,
                   "loaded" =>$fileinfo['filename']);
    return $return;
}
protected static function save_user_email_template($value,$name)
{
    $dat ='';
    $dir = __DIR__ . '/templates/user-mail';
    $templates = scandir($dir);
    foreach ($templates as $tmp)
   {
    $fileinfo = pathinfo($dir."/".$tmp);
     if($fileinfo['extension'] != 'txt'){
     $tmp = '.';  
     }
    if ($tmp != "." && $tmp != ".."  && $tmp != "_notes" && $fileinfo['basename'] != "Thumbs.db") {
        $file[] = $tmp;
      }
    }
    $open = $dir.'/'.$name.'.txt';
    foreach ($file as $val){
    $datei = substr($val,0,strpos($val,'.txt'));
    if($datei == $name){
   	$value=stripslashes($value);   
    $dh = fopen($open, "w+");
    fwrite($dh, $value);
    fclose($dh);   
     }   
    }
    return array("status"=>true,"message"=>$name. ' erfolgreich gespeichert!');   
}
private static function del_email_template($name)
{
    if($name == 'zugangsdaten eMail'){
      return false;
    }
    $dir = __dir__ . '/templates/user-mail';
    $templates = scandir($dir);
    foreach ($templates as $tmp)
   {
    $fileinfo = pathinfo($dir."/".$tmp);
     if($fileinfo['extension'] != 'txt'){
     $tmp = '.';  
     }
    if ($tmp != "." && $tmp != ".."  && $tmp != "_notes" && $fileinfo['basename'] != "Thumbs.db") {
        $file[] = $tmp;
      }
    }
    foreach($file as $val)
    {
     $datei = substr($val,0,strpos($val,'.txt'));
     if($datei == $name) {
      unlink($dir.'/'.$name.'.txt');  
     }
        
    }
    return true;
}
private function sende_user_mail($typ,$id="",$email="",$pwd="")
{
        //verzeichnis mit templates einlesen
        $dir = __DIR__ . '/templates/user-mail';
        //standard template verzeichnis 
        $standard_dir = __DIR__ . '/templates/standard-mail';
    switch ($typ)
    {
        case'select':
            $templates = scandir($dir);
            foreach ($templates as $tmp)
            {
            $fileinfo = pathinfo($dir."/".$tmp);
            if($fileinfo['extension'] != 'txt'){
            $tmp = '.';  
            }
            if ($tmp != "." && $tmp != ".."  && $tmp != "_notes" && $fileinfo['basename'] != "Thumbs.db") {
            $file[] = $tmp;
             }
            }
            //template suchen was gewählt wurde
            foreach($file as $val)
            {
            if($val == $email){
            $email_template = file_get_contents($dir . '/'.$email,FILE_USE_INCLUDE_PATH);    
             }
            }
            break;
        case 'text':
           $email_template = file_get_contents($standard_dir . '/mail.txt',FILE_USE_INCLUDE_PATH);
           break;
        case'new_passwort':
           $email_template = file_get_contents($standard_dir . '/newPwMail.txt',FILE_USE_INCLUDE_PATH);
        break;
    }
       //abbrechen wenn Template leer
        if(empty($email_template)){
        return false;
        }
     //abfrage user Daten von DB
             $abfrage = array("method" =>"read_wp_db",
                              "table"  =>"art_user",
                              "select" =>"*",
                              "where"  =>" where id = %d",
                              "search" =>$id);
             $dat = new DbHandle($abfrage);
             $daten = $dat->return; 
             $data = $daten['data'][0];

            $settings = ApgSettings::load_settings('user_settings');

            global $user_info;
            $user_info = get_userdata(get_current_user_id());
            $absName     = 'ArtPicture-Galerie';
            $subject      = 'Nachricht von ArtPicture-Galerie ('.$user_info->user_email.')';  
            $smtpSecure   = $secure;
            $text = 'kein Text vorhanden';                          
            $text = htmlentities($text, ENT_QUOTES);
            $logo = plugins_url('../assets/images/Logo-Art-Picture-galerie-B.png',__FILE__).' "height="227" width="249"  alt="artPictureGalerie';
            //Login Url für User Benutzeroberfläsche
            //$url = substr(admin_url(),0,strpos(admin_url(),'wp-admin')).'artpicture-galerie-login';
            $url=site_url().'?apg-user-gallery-template=12067102';
         
            //Daten wenn select Platzhalter eintragen 
     @ob_start();
            $email_template = str_replace("[loginurl]",   $url, $email_template);
            $email_template = str_replace("[vorname]",    $data->htaccess_vorname, $email_template); 
            $email_template = str_replace("[nachname]",   $data->htaccess_nachname, $email_template);
            $email_template = str_replace("[loginname]",  $data->htaccess_user, $email_template);
            $email_template = str_replace("[passwort]",   $pwd, $email_template);
            $email_template = str_replace("###MESSAGE###", htmlentities($email), $email_template);
            $email_template = str_replace("###ABSURL###", htmlentities($user_info->user_email), $email_template);
            
            $html_text = file_get_contents('mail/send_user_email.html',FILE_USE_INCLUDE_PATH);
            $html_text = str_replace("###IMAGE_LOGO###", $logo, $html_text);
            $html_text = str_replace("###LOGINURL1###",  $url, $html_text);
            $html_text = str_replace("###USERMAIL###",   $email_template, $html_text);
            $html_text = preg_replace(array('/<!--(.*)-->/Uis',"/[[:blank:]]+/"),array('',' '),str_replace(array("\n","\r","\t"),'',$html_text)); 
          @ob_end_flush();

            $attachment = '';
            $to = $data->htaccess_email;
            $subject = $subject;
            $body = $html_text;
           $return = wp_mail( $to, $subject, $body );
           remove_filter( 'wp_mail_content_type', 'set_html_content_type' );
           return $return;  
}

private function write_user_log($uid,$typ,$imgID,$msg)
{
    
     new UserLogHandler(array("method"=>"write",
                           "user_name"=>$name,
                           "user_id"  =>$uid,
                           "log_typ"  =>$typ,
                           "log_msg"  =>"Bild ID:".$imgID."-" .$msg));    
}
private function read_user_log($typ)
{
   $dir = __DIR__ . '/templates/userLog';
   date_default_timezone_set("Europe/Berlin");
   $alledateien = scandir($dir); 
       foreach ($alledateien as $files)
       {
        $fileinfo = pathinfo($dir."/".$files);
        if($fileinfo['extension'] != 'txt'){
        $files = '.';  
        }
        if ($files != "." && $files != ".."  && $files != "_notes" && $fileinfo['basename'] != "Thumbs.db") {
        $file[] .= $files;
        }
       }

  $header = $this->benutzer_freigaben(array("auswahl"=>"benutzer_freigaben"));
  $header_close = '<a class="dan" role="button"onclick="close_log();">
                     <p class="dan text-right"style="margin-right:25px;">
                     <i class="fa fa-times fa-2x"></i>
                     <strong>&nbsp;schließen</strong></a></p>
                     <div style="min-height:420px;"><h3 class="warn text-left">';
                     
  $return_header = $header['header'] . $header_close;

   $return_footer = '</div><br><hr class="hr-light"></div>';
    switch($typ)
    {
      case'start':
      $start = new UserLogHandler(array("method"=>"all_user"));
      $datLog = $start->return;
        if(empty($datLog['userID'])){
         $template = '<h3 class="dan text-center"style="padding-top:50px;"><span class="fa fa-exclamation-triangle"></span> KEINE <small> Log-Daten vorhanden!</small></h3>';   
        }else{
         foreach ($datLog['userID'] as $tmp)
         {
            
       $abfrage = array("method" =>"read_wp_db",
                        "table"  =>"art_user",
                        "select" =>"*",
                        "where"  =>" where id = %d",
                        "search" =>$tmp);
       $dat = new DbHandle($abfrage);
       $daten = $dat->return; 
       $data = $daten['data'][0];  
        
       $template .= '<div class="col-md-3"><a role="button"onclick="userLog_jahr(\''.$tmp.'\');"><span class="fa fa-folder fa-2x" style="color:#e8cd3d;"></span>&nbsp;&nbsp;<b class="grey"style="font-size:16px;">'.$data->htaccess_user.'</b><a/>&nbsp;&nbsp;<br><br></div>'; 
        }
       }
      
     $return = $return_header . $template . $return_footer;
      break;
  case'jahr':
       if(!empty($file))
       {
         foreach ($file as $tmp)
        {
          $f            = pathinfo($this->dir."/".$tmp);
          $jahre[]      = substr($tmp,6,4);
          $userID       = substr($f['filename'],strpos($f['filename'],'_')+1);
          if($userID    == $this->id){
          
          }
        }
        $jahr = array_unique($jahre);
        $jahr = array_values($jahr);
  
        foreach ($jahr as $val)
        {
      $template .= '<div class="col-md-3"><a role="button"onclick="userLog_monat(\''.$this->id.'\',\''.$val.'\');"><span class="fa fa-folder fa-2x" style="color:#e8cd3d;"></span>&nbsp;&nbsp;<b class="grey"style="font-size:16px;">'.$val.'</b><a/>&nbsp;&nbsp;<br><br></div>';   
        }
      }
      
      $return = $return_header . $template . $return_footer;
      break; 
 case'monat':
      
         if(!empty($file))
       {
         foreach ($file as $tmp)
        {
          $f = pathinfo($this->dir."/".$tmp);
          
          $jahr     = substr($f['filename'],6,4);
          $userID   = substr($f['filename'],strpos($f['filename'],'_')+1);
          if($jahr  == $this->jahr && $userID == $this->id){
          $monat    = substr($f['filename'],3,2);
          $datum    = substr($f['filename'],0,10).' 00:00:00';
          $date2    = new \DateTime($datum);
          $datum2[] = $date2->format('m');

         }
        }
         $usrMonat = array_unique($datum2);
         $usrMonat = array_values($usrMonat);

      foreach ($usrMonat as $m)
      {  
        $dat = $this->date_deutsche($datum);
        $deutschDatum = $dat['monat_lang'];
        $template .= '<div class="col-md-3"><a role="button"onclick="userLog_details(\''.$this->id.'\',\''.$m.'\',\''.$this->jahr.'\');"><span class="fa fa-folder fa-2x" style="color:#e8cd3d;"></span>&nbsp;&nbsp;<b class="grey"style="font-size:16px;">'.$m.'</b><a/>&nbsp;&nbsp;<br><br></div>';
      }
     }
       $return = $return_header . $template . $return_footer;
      
      break;
case'details':
      if(!empty($file)){
      foreach ($file as $tmp){
       $this->f = pathinfo($this->dir."/".$tmp);
       if(strpos($this->f['filename'],$this->monat.'-'.$this->jahr.'_'.$this->id) !== false){
       $tag    = substr($this->f['filename'],0,2);
       $datei = $dir . '/' . $tag. '-' . $this->monat . '-' . $this->jahr . '_' . $this->id . '.txt';
       $this->deleteDatei = $this->f['filename'];
       $datum = $tag. '-' . $this->monat. '-' . $this->jahr . ' 00:00:00';              
       $this->dat = $this->date_deutsche($datum); 

        $eintraege = $this->read_log_details($datei);
        $eintrag = array_filter($eintraege);
        $x=0;
        $tmp_header = $this->details_template('table-header');
       
        
        $tmp_footer  = $this->details_template('table-footer');  
        $event    = $this->event($datei);
        $r .= $tmp_header . $event . $tmp_footer;
        }
     
   }
 
      $return = $return_header.$r.$return_footer; ;
  }
      break;   
    }
    return  $return;
}
private function event($datei)
         
{
         $eintraege = $this->read_log_details($datei);
       $x=0;
         $eintrag = array_pop($eintraege);          
         foreach($eintraege as $val)
         {
          if(empty($val)){
          return;  
          }  
         $date = $val[1];  
         $date1  = new \DateTime($date);
         $this->uhrzeit = $date1->format('H:i:s');
         $this->typ   = $val[2];
         $this->event = $val[3];
         $i1=strpos($val[3],':')+1;
         $i2=strpos($val[3],'-');
         $IMGid = substr($val[3],$i1,$i2 - $i1);
         $abfrageImg = array("method" =>"read_wp_db",
                             "table"  =>"art_images",
                             "select" =>"*",
                             "where"  =>" where id = %d",
                             "search" =>$IMGid );
      $dat = new DbHandle($abfrageImg);
      $image = $dat->return; 
      $this->img = $image['data'][0];                           
      $this->delete = $x.'_'.$this->f['filename'];  
      $event .= $this->details_template('event');
      $x++;
      
     }
     return $event;
     
}

private function read_log_details($datei)
{
        $dh = fopen($datei, "r");
        while (!feof($dh)) {
        $zeile = fgets($dh);
        $tE             =  strpos($zeile,'|typ|') + 5 ;
        $tI             =  strpos($zeile,'|id|') ;
        $ID1            =  strpos($zeile,'|id|') + 4 ;
        $ID2            =  strpos($zeile,'|message|')  ;
        $datumEintrag   =  substr($zeile,6,19);
        $EintragTyp     =  substr($zeile,$tE,$tI-$tE);
        $EintragID      =  substr($zeile,$ID1,$ID2-$ID1);
        $EintragMSG     =  substr($zeile,strpos($zeile,'|message|')+9);
        $eintrag[] = array($EintragID, $datumEintrag,$EintragTyp,$EintragMSG);
        }
        fclose($dh);
        $return = array_filter($eintrag);
        return $return;
        
       
}
private function details_template($typ)

{
    switch($typ)
    {
        case'table-header':
               $table_header = ' 
                                 <div class="table-responsive">
                                 <table class=" details table">
                                 <thead>
                                 <tr>
                                 <th>
                                 <div class="agenda">
                                 <div class="agenda-date" class="active" rowspan="3">
                                 <div class="prem dayofmonth"><u class="warn"><b class="prem">'.$this->dat['tag_kurz'].'</b></u></div>
                                 <div class=" dayofweek">'.$this->dat['tag_lang'].'</div>
                                 <div class="shortdate text-muted grey">'.$this->dat['monat_lang'].', '.$this->dat['jahr'].'</div>
                                 </div>
                                 </div>
                                 </th>
                                 <th>Datei</th>
                                 <th>Typ</th>
                                 <th>Message</th>
                                 <th>
                                 <a class="dan" role="button"onclick="delete_day_log(\''.$this->deleteDatei.'\');"><span class="fa fa-trash"></span> alle löschen </a>
                                 </th>
                                 </tr>
                                 </thead>
                                 <tbody>';
         $table_header = preg_replace(array('/<!--(.*)-->/Uis',"/[[:blank:]]+/"),array('',' '),str_replace(array("\n","\r","\t"),'',$table_header));                        
         return $table_header;              

        case'event':
        
        $event = '     <tr>
                       
                       <td><span class="prem fa fa-clock-o"></span> '.$this->uhrzeit.'</td>
                       <td>
                       <a data-gallery="" href="'.htmlspecialchars(trim($this->img->url)).'" title="Event: am '.$this->dat['tag_kurz'].'. '.$this->dat['monat_lang'].' '.$this->dat['jahr']. ' um ' .$this->uhrzeit.'">
                       <img src="'.htmlspecialchars(trim($this->img->thumbnailUrl)).'" alt="" width="45" height="45"></a>
                       </td>
                       <td>'.$this->typ.'</td>
                       <td>'.$this->event.'</td>
                       <td><button class="btn btn-danger btn-outline btn-xs"onclick="delete_log_eintrag(\''.$this->delete.'\');"><span class="fa fa-trash"></span> Eintrag löschen</button>  </td>
                       </tr>';
        $event = preg_replace(array('/<!--(.*)-->/Uis',"/[[:blank:]]+/"),array('',' '),str_replace(array("\n","\r","\t"),'',$event));
        return $event;               
        break;
        case'table-footer':
        $table_footer = '</tbody>
                         </div>
                         ';
        return $table_footer;              
        break;
    }

}
private function read_user_message()
{
          $a1 = array("method"   =>"read_wp_db",
                  "table"        =>"art_user",
                  "select"       =>  '*');
          $usr = new DbHandle($a1);
          $dat=$usr->return;
          $data = $dat['data'];
          foreach( $data as $tmp)
          {
            $msg = unserialize($tmp->user_message);
         
           for($i = 0; $i <= count($msg); $i++) { 
            $datum = substr($msg[$i],0,strpos($msg[$i],'_'));
            $datum1 = substr($msg[$i],0,10);
            $zeit   = substr($msg[$i],10,9);
            $message = substr($msg[$i],strpos($msg[$i],'_')+1);
              if(empty($message)){
              continue;  
              }
              
              $this->all[] = array("datumAll"=>$datum,
                             "datum"=>$datum1,
                             "zeit"=>$zeit,
                             "message"=>$message,
                             "id"=>$tmp->id,
                             "user"=>$tmp->htaccess_user,
                             "vorname"=>$tmp->htaccess_vorname,
                             "nachname"=>$tmp->htaccess_nachname);
           }    
          }
          $header_close = '<br><br><a class="dan" role="button"onclick="close_messages();">
                           <p class="dan text-right"style="margin-right:25px;">
                           <i class="fa fa-times fa-2x"></i>
                           <strong>&nbsp;schließen</strong></a></p>
                           <div style="min-height:420px;"><h3 class="warn text-left">';
          $this->count = count($this->all);
          if(empty($this->count)){
            return $header_close . $template ='<h3 class="dan text-center"><span class="fa fa-exclamation-triangle"></span> keine <small>Nachrichten vorhanden!</smal></h3>';
          }

          $header_close = preg_replace(array('/<!--(.*)-->/Uis',"/[[:blank:]]+/"),array('',' '),str_replace(array("\n","\r","\t"),'',$header_close));                  
         
          foreach ($this->all as $val) $datum_count[] = $val['datum'];

          $eintraege = array_values(array_unique($datum_count));
          for($y = 1; $y <= count($eintraege); $y++) {
            $d = $this->date_deutsche($eintraege[$y -1].' 00:00:00');
            
            $this->ins = $y;
           $result = $this->user_messages($eintraege[$y -1]);
            $template .= '<div class="table-responsive">
                                 <table class=" details table">
                                 <thead>
                                 <tr>
                                 <th>
                                 <div class="agenda table_datum">
                                 <div class="agenda-date" class="active" rowspan="3">
                                 <div class="prem dayofmonth"><u class="warn"><b class="prem">'.$d['tag_kurz'].'</b></u></div>
                                 <div class=" dayofweek">'.$d['tag_lang'].'</div>
                                 <div class="shortdate text-muted grey">'.$d['monat_lang'].', '.$d['jahr'].'</div>
                                 </div>
                                 </div>
                                 </th>
                                 <th class="table_msg_benutzer">Benutzer</th>
                                 <th class="table_msg_name">Benutzer Name</th>
                                 <th class="table_msg">Message</th>
                                 
                                 <th>
                                 <span class="fa fa-trash"></span> löschen
                                 </th>
                                 </tr>
                                 </thead>
                                 '.$result['event'].'
                                 <tbody>
                                 </tbody>
                                 </div>';
                                 
            
            }
           $template = preg_replace(array('/<!--(.*)-->/Uis',"/[[:blank:]]+/"),array('',' '),str_replace(array("\n","\r","\t"),'',$template)); 
          return  $header_close . $template;   
}
private function user_messages($datum)
{
    $i = 1;
    foreach($this->all as $tmp)
    if($datum == $tmp['datum']){
    $datum2 = str_replace('-','',$tmp['datum']);    
    $msg = substr($tmp['message'],0,20).'...';    
        
                               $event .= '
                               <tr>
                               <td><span class="prem fa fa-clock-o"></span> '.$tmp['zeit'].'</td>
                               <td >
                               '.$tmp['user'].' 
                               </td>
                               <td>'.$tmp['vorname'].' '.$tmp['nachname'].'</td>
                               <td><a class="prem"role="button" data-toggle="collapse" data-parent="#accordion" href="#'.$i.$datum2.'" aria-expanded="false" aria-controls"'.$i.$datum2.'"><u>'.$msg.'</u></a> 
                               <br><br>
                               <div id ="'.$i.$datum2.'" class="panel-collapse collapse " role="tabpanel" aria-labelledby="'.$i.$datum2.'">
                               <div class="panel-body">
                               <h4 class="warn">Message <small class="grey"> von '.$tmp['vorname'].' '.$tmp['nachname'].' gesendet am '.$tmp['datum'].' um '.$tmp['zeit'].' </small></h4>
                               <span style="color:#666;"> '.$tmp['message'].'</span>
                               </div>
                               </div>
                               </td>
                              <td><button class="btn btn-danger btn-outline btn-sm" onclick="delete_usr_message(\''.$tmp['datumAll'].'\',\''.$tmp['id'].'\');"><span class="fa fa-trash"></span> löschen</button></td>
                              </tr>';
                                
                               $i++; 
                             
  }
   return array("event"=>$event,"collapse"=>$collapse);
}
private function new_user_template(){

    //if PRO VERSION
    $a2 = array("method" =>"read_wp_db",
                        "table"    =>"art_user",
                        "select"   =>" *");
       $dat2 = new DbHandle($a2);
       $row=$dat2->return;
      if(empty($this->settings['license_aktiv']) && $row['count'] >= 1){
       $btn='<b class="dan"><span class="fa fa-exclamation-circle"> INFO:</span></b><b class="grey"> Sie haben 1 Benutzer angelegt. Mit der <a class="prem" role="button" href="'.ART_PICTURE_SALE.'" target="_blank">Art-Picture Galerie <b class="dan">Pro</b></a> k&ouml;nnen Sie unbegrenzt viele Benutzer anlegen.</b>';
      }else{
       $btn='<button role="button"class="btn btn-primary btn-sm " onclick="add_new_user();"><i class="fa fa-save"></i>&nbsp; speichern</button>'; 
      }
    if(empty($this->settings['license_aktiv'])){
      $checked ='<input type="checkbox"name ="email_aktiv" value="0" disabled> Zugangsdaten schicken <a class="prem" role="button" href="'.ART_PICTURE_SALE.'" target="_blank"><b class="dan">Pro</b><b class="gray">Version</b></a>';   
    }else{
      $checked ='<input type="checkbox" onclick="click_email_aktiv();" id="add_email_aktiv"  value="1"checked> Zugangsdaten schicken';   
    }

    
    
    //if PRO VERSION
        
    $template = '<a class="dan" role="button"onclick="close_new_user();">
                        <p class="dan text-right"style="margin-right:25px;">
	                    <i class="fa fa-times fa-2x"></i>
                        <strong>&nbsp;schlie&szlig;en</strong></a></p>
                        <div class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2" id="error_messages_user"></div>
                        <div class="row">
                        <div class="col-lg-8 col-lg-offset-2">
                        <input id="new_user_loaded" type="hidden"name="send_user"value="'.$uri.'">
                        <br/><br/><div class="form-group">
                        <div class="row">
                        <label class="col-sm-2 control-label"style="color:#868686;">Vorname</label>
                        <div class="col-sm-4">
                        <input type="text" class="form-control" id="add_vorname" name="vorname" value="'.$vn.'" autocomplete="new-password"placeholder="Vorname" required />
                        </div>
                        <label class="col-sm-2 control-label"style="color:#868686;">Nachname</label>
                        <div class="col-sm-4">
                        <input type="text" class="form-control" id="add_nachname" name="nachname" value="'.$nn.'" autocomplete="new-password"placeholder="Nachname" required />
                        </div>
                        </div>
                        </div>
                        <div class="form-group">
                        <div class="row">
                        
                        <label class="col-sm-2 control-label"style="color:#868686;">Passwort</label>
                        <div class="col-sm-4">
                        <div id="pw_generieren">
                        <input type="password" class="form-control" id="add_passwort" autocomplete="new-password"placeholder="Passwort" required />
                        </div>
                        <button id="passwort_generieren"  class="btn btn-default btn-outline btn-xs"type="button"onclick="pw_generieren();">Passwort generieren</button>
                        </div>
                        <label class="col-sm-2 control-label"style="color:#868686;">eMail</label>
                        <div class="col-sm-4">
                        <input type="email" class="form-control" id="add_email" name="email" value="'.$em.'"autocomplete="new-password"placeholder="eMail" required />
                        </div>
                        </div>
                        </div>
                        <div class="form-group">
                        <div class="row">
                        <label class="col-sm-2 control-label"style="color:#868686;">Benutzername</label>
                        <div class="col-sm-4">
                        <input type="text" class="form-control" id="add_username" name="username"value="'.$bn.'" autocomplete="new-password"placeholder="Benutzername" required />
                        </div>
                        <label class="col-sm-2 control-label"style="color:#868686;">Notiz</label>
                        <div class="col-sm-4">
                        <textarea name="notiz" id="add_notiz" class="form-control" rows="2"placeholder="Notiz">'.$no.'</textarea>
                        </div>         
                        </div>
                        </div>
                        <div class="form-group">
                        <div class="row">
                        <label class="col-sm-2 checkbox-inline"style="padding-top: 10px;"></label>
                        <div class="col-sm-4">
                        '.$checked.'
                        </div>
                        <div class="col-sm-4"></div>  
                        </div>
                        </div>
                        <div class="form-group">
                        <div class="row">
                        <label class="col-sm-2 checkbox-inline"style="padding-top: 10px;"></label>
                        <div class="col-sm-4">
                        <input type="checkbox" onclick="click_user_aktiv();" id="add_user_aktiv" value="1" checked> Benutzer aktiv
                        </div>
                        <div class="col-sm-4"></div>  
                        </div>
                        </div>

                        <div class="form-group"style="padding-bottom: 110px;">
                        <div class="col-sm-10 col-sm-offset-2">
                        '.$btn.'
                        </div>
                        </div>

                        </div><!--col-md-8 offset2-->
                        </div><!--row-->
                      
                        </div><!--template_ende-->';
         
                       
          $return = preg_replace(array('/<!--(.*)-->/Uis',"/[[:blank:]]+/"),array('',' '),str_replace(array("\n","\r","\t"),'',$return));
          
          return $template;                
}
public function editor_button_select()
{
        $abfrage = array("method" =>"read_wp_db",
                          "table"  =>"art_galerie",
                          "select" =>"*");
        $dat = new DbHandle($abfrage);
        $gal = $dat->return; 
        $galerie = $gal['data'];
       if(!empty($gal['count']))
       {
        $files= array();
        foreach($galerie as $tmp)
        {
        
         $file = new \stdClass();
         $file->text = $tmp->galerie_name;
         $file->value = $tmp->galerie_name;
         array_push($files,$file);
        }
        $return =  $files;
        return $return;
     
       }

}
public function update_image_posts($galerie_name,$image_id,$htaccess_id,$kommentar)
{
    
   $abfrage = array("method"   =>"read_wp_db",
                    "table"    =>"art_images",
                    "select"   =>"*",
                    "where"    =>" where id = %d",
                    "search"   =>$image_id );
                             
    $dat = new DbHandle($abfrage);
    $data=$dat->return;
    $post_id = $data['data'][0]->post_id;
     date_default_timezone_set("Europe/Berlin");     
    if(empty($post_id)){
     $send[] =array("imageID"=>$image_id,"galerieName"=>$galerie_name,"htaccessID"=>$htaccess_id,"message"=>$kommentar,"time"=>date('Y-m-d H:i:s') );
     $senden = serialize($send);   
    }else{
     $db_msg = unserialize($post_id); 
     foreach($db_msg as $tmp) {
      if($tmp['htaccessID'] == $htaccess_id && $tmp['imageID'] == $image_id){
      return;}
    }
     $send[] =array("imageID"=>$image_id,"galerieName"=>$galerie_name,"htaccessID"=>$htaccess_id,"message"=>$kommentar,"time"=>date('d.m.Y H:i:s') );   
     $newEintrag = array_merge($db_msg,$send);
     $senden=serialize($newEintrag);

    }
    $upd = array("method" =>"update_wp_posts_wpSeite",
               "table"    =>"art_images",
               "id"       => $image_id,
               "data"     => $senden);
     new DbHandle($upd);
    
    
}

    protected function UmlautINS($umlautINS){ 

   $sucheuml = array('Ãƒâ€ž','ÃƒÂ¤','Ãƒâ€“','ÃƒÂ¶','ÃƒÅ“','ÃƒÂ¼','ÃƒÅ¸',"&Auml;","&auml;","&Ouml;","&ouml;","&Uuml;","&uuml;","&szlig;");    
   $ersetzel = array('Ã„','ä','Ã–','ö','Ü','ü','ß','Ã„','ä','Ã–','ö','Ü','ü','ß'); 
   $guteuml  = str_replace($ersetzel,$sucheuml,$umlautINS); 

   return $guteuml; 
   }
    
    
    private function user_selected(){
           @session_start();
            $a1 = array("method" =>"read_wp_db",
                        "table"  =>"art_freigaben",
                        "select" =>"*",
                        "where"  =>" where htaccess_id = %d",
                        "search" =>$_SESSION['id'] );
            $dat = new DbHandle($a1);
            $dataFreigabe = $dat->return;
            $noSelect = '<h3 class="dan text-center"style="padding-top:65px;">
                                  <span class="dan fa fa-angle-double-right"></span><span class="dam fa fa-angle-double-right"></span>&nbsp;Sie <span class="grey"> haben noch 
                                  <b class="dan"> keine</b> Bilder ausgewählt!
                                  </span><b class="dam fa fa-angle-double-left"></b><b class="dam fa fa-angle-double-left"></b></h3>';
            $noSelect = preg_replace(array('/<!--(.*)-->/Uis',"/[[:blank:]]+/"),array('',' '),str_replace(array("\n","\r","\t"),'',$noSelect));
            $select_start_header = '<h2 class="warn text-center"><span class="warn fa fa-camera"></span> <span class="grey"> Ihre </span><span class="warn fa fa-angle-double-right"></span> <small> gewählten Bilder</small> <span class="warn fa fa-angle-double-left"></span>  </h2><div class="row"style="padding-top:65px;">';
            $select_start_footer = '</a></div>';
            $a1 = array("method"   =>"user_wp_freigabe_start");
          if(empty($dataFreigabe['count'])){
            return  $noSelect ;  
          }

           $usr = new DbHandle($a1);
           $userDB=$usr->return;
           $db = array_filter($userDB['data']);
           $y=0; 
            foreach($db as $tmp)
            {
            if($tmp->id == $_SESSION['id'] && !empty($tmp->freigabe_aktiv) && !empty($tmp->htaccess_aktiv)){
              $sel_img = unserialize($tmp->select_image);
              $count=count($sel_img);
              $gnl = strlen($tmp->galerie_name);
               if($gnl > 23) {
               $cg = '...'; 
               $c = 20; 
               }else{
               $cg = ''; 
               $c = 23;
               }
               if(!empty($count)){
               $galeriename = substr($tmp->galerie_name,0,$c).$cg;
               $select .='<a role="button" onclick="load_user_selected_image(\''.$tmp->freigabe_id.'\');">
                          <div class="col-md-2 col-sm-3">
                          <div class="selected-image ">
                          <div class="panel-body">
                          <img src="'.plugins_url('../assets/images/newuser.png',__FILE__).'">&nbsp;<b class="warn"> Galerie:</b>
                          <h4 class="grey"> '.$galeriename.'</h4>
                          <b class="grey">Bilder: <b class="prem">'.$count.'</b> </b>
                          </div>
                          </div>
                          </div>';
                          $y++; 
               }
              }
            }
             
            if($y == 0) {
            return $noSelect;
            }
           $selected = $select_start_header . $select .$select_start_footer;
           $selected = preg_replace(array('/<!--(.*)-->/Uis',"/[[:blank:]]+/"),array('',' '),str_replace(array("\n","\r","\t"),'',$selected));
           return $selected;   
       
}
 private function load_user_selected_image($fid){
       
       $a1 = array("method"   =>"user_wp_response",
                        "data"    => array("freigabe_id"=>(int)$fid));
       $dat1 = new DbHandle($a1);
       $data=$dat1->return;
       if(empty($data['count'])){
        return false;
        }
        $sel_img = unserialize($data['data'][0]->select_image);
        if(empty($sel_img)){
         return $return ='<h4 class="dan text-center"><span class="fa fa-exclamation-triangle"></span> Noch <small> keine Bilder ausgewählt!</small></h4>';   
        }
        $image = array_filter(array_unique($sel_img));
        $back = '<a role="button" href="'.$this->assets['user_selected'].'"><h4 class="prem"><b class="fa fa-angle-double-left"></b><b class="fa fa-angle-double-left"></b> zurück </h4></a><br>';
        $return_header = '<div id="grid"><div class="grid-sizer"></div>';
        $return_footer = '</div>';
        foreach ($image as $val)
        {
       global $wpdb;
       $table_name = $wpdb->prefix . 'art_images';
       $row = $wpdb->get_results( $wpdb->prepare(
       "SELECT *
       FROM  ".$table_name." 
       where id = %d ", 
       $val));
       $url = $row[0]->url;
        $mediumurl = $row[0]->thumbnailUrl;
        $name      = $this->basename($row[0]->name);
        $return .= ' <div class="grid-item">
                     <a data-gallery="" title="'.$name.'" href ="'.$url.'"> <img src = "'.$mediumurl.'"></a></div> ';
        
        }
        $enter = $back. $return . $return_footer;

       $enter = preg_replace(array('/<!--(.*)-->/Uis',"/[[:blank:]]+/"),array('',' '),str_replace(array("\n","\r","\t"),'',$enter));
        return $enter; 
    }
      private function user_message_template(){
      @session_start();      
      global $wpdb;
      $table_name = $wpdb->prefix . 'art_user';
      $row = $wpdb->get_results( $wpdb->prepare(
     "SELECT *
      FROM  ".$table_name." 
      where id = %d ", 
     $_SESSION['id'] ));
     if(empty($row[0]->email_aktiv)){
        $message = '<h4 class ="dan text-center"style="padding-top:25px;"><span class="fa fa-exclamation-triangle"></span> INFO: <span class="grey"> Das Senden von Nachrichten ist nicht aktiviert.</span></h4>
                    <p class= "text-center"><span class ="warn fa fa-angle-double-right"></span><b class ="grey"> Für weitere Informationen, wenden sie sich bitte an den </b>
                    <a href="mailto:'.get_option('admin_email').'"><b class="warn"> Galerie-Ersteller</b> </a> <span class="warn fa fa-angle-double-left"></span></p>';
     }else{
        $message = '<br><h3 class="text-center"><span class="grey fa fa-envelope-o"></span> <span class="warn"> Senden </span> <small> Sie eine Nachricht an den Galerie-Ersteller.</small></h3><br><hr class="hr-light"><br><p class="text-center">
                <div class="col-md-8 col-md-offset-2"style="min-height:400px;">
                <div class="form-horizontal">
                <div class="form-group">
                <textarea class="form-control"id="new_message"placeholder="Ihre Nachricht..." rows="6"></textarea><br><br>
                <button role="button" class="btn btn-primary btn-outline"onclick="send_message(\''.$_SESSION['id'].'\');"><span class="fa fa-envelope-o"></span> senden</button>
                </div></div>
                </div>
                </p>';
                }
        $message = preg_replace(array('/<!--(.*)-->/Uis',"/[[:blank:]]+/"),array('',' '),str_replace(array("\n","\r","\t"),'',$message));
        return $message;  
      }
  protected static function date_deutsche($dateDB){
  date_default_timezone_set("Europe/Berlin");
        $date = new \DateTime($dateDB);
        $tage = array(
            "Mon" => "Montag",
            "Tue" => "Dienstag",
            "Wed" => "Mittwoch",
            "Thu" => "Donnerstag",
            "Fri" => "Freitag",
            "Sat" => "Samstag",
            "Sun" => "Sonntag");
        $monate = array(
            "Jan" => "Januar",
            "Feb" => "Februar",
            "Mar" => "März",
            "Apr" => "April",
            "Mai" => "Mai",
            "Jun" => "Juni",
            "Jul" => "Juli",
            "Aug" => "August",
            "Sep" => "September",
            "Oct" => "Oktober",
            "Nov" => "November",
            "Dec" => "Dezember");
        $datumDB = array();
        $datumDB['monat_lang'] = $monate[$date->format('M')];
        $datumDB['monat_kurz'] = $date->format('M');
        $datumDB['tag_lang'] = $tage[$date->format('D')];
        $datumDB['tag_kurz'] = $date->format('d');
        $datumDB['jahr'] = $date->format('Y');
        return $datumDB;

    }
}//endClass
?>