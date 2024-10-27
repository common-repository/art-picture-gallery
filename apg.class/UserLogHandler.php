<?php
/**
 * ArtPicture Plugin PHP Class
 * http://art-pictureDesign.de/WP-ArtTheme-Galerie
 * Copyright 2017, Jens Wiecker
 * https://art-picturedesign.de
 *
 */
namespace APG\ArtPictureGallery;
require_once 'ApgCore.php';
use  APG\ArtPictureGallery\Core as Core;
class UserLogHandler extends Core
{
    public function __construct($userLog = null){
        $this->userLog = array("method"     =>null,
                               "user_id"    =>null,
                               "log_typ"    =>null,
                               "data"       =>null,
                               "log_msg"    =>null);
                            
          if ($userLog) {
             $this->userLog = $userLog + $this->userLog;
             $this->return = $this->user_log();
             }
                                    
    }
    private function user_log(){
        $this->dir      = __DIR__ . '/templates/userLog';
        $this->htaccess = '<Files "*.*">
        Deny from all
        </Files>';
       switch($this->userLog['method']) {
        case'write':
       return $this->write_new_user_log();
        break;
        case'read':
       return $this->read_log_eintrag();
        break;
       case'update':
       return $this->update_logfile();
        break;
        case'all_user':
        return $this-> all_user_logs();
        break;
       }//endSwitch 
    }//end usr_log
 private function write_new_user_log(){
        $file = array();
        date_default_timezone_set("Europe/Berlin");
        $date = new \DateTime();
        $this->datum = $date->format('d-m-Y'); 
        $this->newLogDatei = $this->dir.'/'.$this->datum.'_'.$this->userLog['user_id'].'.txt';
        if (!is_dir($this->dir)){
        mkdir($this->dir, 0755, true);
         //wenn nicht vorhanden Verzeichnis erzeugen und Eintrag schreiben
        $this->newLogDatei = $this->dir.'/'.$this->datum.'_'.$this->userLog['user_id'].'.txt';
        if(empty($this->userLog['user_id'])){
            return false;
        }
        $this->write_user_log("w+");
        $this->write_htaccess();
        return;
        }
       $alledateien = scandir($this->dir); 
       foreach ($alledateien as $files)
       {
        $fileinfo = pathinfo($this->dir."/".$files);
        if($fileinfo['extension'] != 'txt'){
        $files = '.';  
        }
        if ($files != "." && $files != ".."  && $files != "_notes" && $fileinfo['basename'] != "Thumbs.db") {
        $file[] .= $files;
        }
       }
        //wenn nicht vorhanden Eintrag schreiben
        if(count($file) == '0'){
        $this->newLogDatei = $this->dir.'/'.$this->datum.'_'.$this->userLog['user_id'].'.txt';
        $this->write_user_log("w+");
        return;
       }
       //neuer Eintrag in vorhandene Datei
       $this->write_user_log("a");
       }
   private function write_user_log($typ){
     $date2 = new \DateTime();
     $datum2 = $date2->format('d-m-Y H:i:s');
     $new_eintrag  = 'datum|'.$datum2.'|typ|'.$this->userLog['log_typ'].'|id|'.$this->userLog['user_id'].'|message|'.$this->userLog['log_msg']."\n";
     $dh = fopen($this->newLogDatei, $typ);
     fwrite($dh, $new_eintrag);
     fclose($dh);   
       
   }
   private function write_htaccess(){
    $htaccess_dir = $this->dir.'/.htaccess';
    $dh = fopen($htaccess_dir, "w+");
    fwrite($dh, $this->htaccess);
    fclose($dh); 
   }
   private function all_user_logs(){
    $alledateien = scandir($this->dir); 
    foreach ($alledateien as $files){
    $fileinfo = pathinfo($this->dir."/".$files);
    if($fileinfo['extension'] != 'txt'){
    $files = '.';  
    }
    if ($files != "." && $files != ".."  && $files != "_notes" && $fileinfo['basename'] != "Thumbs.db") {
    $file[] .= $files;
    }
   }
   if(!empty($file)) {
    foreach ($file as $tmp){
    $f = pathinfo($this->dir."/".$tmp);
    $tag[] = substr($tmp,0,2);  
    $monat[] = substr($tmp,3,2);
    $jahr[]  = substr($tmp,6,4);
    $userID[] = substr($f['filename'],strpos($f['filename'],'_')+1);
    }
    $tag = array_unique($tag);
    $monat = array_unique(($monat));
    $jahr = array_unique(($jahr));
    $userID = array_unique(($userID));
    $return = array("tage"=>$tag,"monate"=>$monat,"jahre"=>$jahr,"userID"=>$userID);
    return $return;     
   }
    return false;
}
 public function __destruct(){
    $this->userLog;
    $this->return;
    } 
 }//endClass
?>