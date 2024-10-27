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
require_once ('ApgSettings.php');
use  APG\ArtPictureGallery\Core as Core;
use  APG\ArtPictureGallery\DbHandle as DbHandle;
use  APG\ArtPictureGallery\ApgSettings as ApgSettings;
class SiteTemplates extends Core 
{
  public function __construct($optionen = null)  {
             $this->settings = ApgSettings::load_settings('user_settings');
             $this->tt = ApgSettings::load_settings('tooltip');
            $this->optionen = array(
            "header"       => null,
            "footer"       => null,
            "footer2"      => null,
            "template"     => null,
            "temp-head"    => null,
            "name"         => null,
            "btn_name"     => null,
            "form_type"    => null,            
            "checked"      => null,
            "username"     => null,
            "disabled"     => null,
            "select"       => null,
            "data"         => null,
            "notiz"        => null,
            "placeholder"  => null,
            "input-type"   => 'text',  
            "datum1"       => null,
            "datum2"       => null,
            "color"        => null,
            "icon"         => null,
            "th-2"         => null,
            "th-3"         => null,
            "th-4"         => null,
            "th-5"         => null,
            "th-6"         => null,
            "th-7"         => null,
            "th-8"         => null,
            "th-9"         => null,
            "th-10"        => null,
            "th-11"        => null,
            "th-12"        => null,
            "td-1"         => null,
            "td-2"         => null,
            "td-3"         => null,
            "td-4"         => null,
            "td-5"         => null,
            "td-6"         => null,
            "td-7"         => null,
            "td-8"         => null,
            "td-9"         => null,
            "td-10"        => null,
            "td-11"        => null,
            "td-12"        => null,
            );
        if ($optionen) {
             $this->optionen = $optionen + $this->optionen;
             }
          $this->return = $this->templates();      
  } 
  private function templates(){
  switch ($this->optionen['template'])
  {
  case 'galerie_details':
          $this->optionen['icon'] = '<span class="fa fa-folder-open-o"></span>';
          $this->optionen['header'] = '<input type="hidden"name="details_loaded"value="loaded">
                                      <h3><span class="warn">Galerie</span>  <small><strong>details</strong></small></h3>
                                      <a class="dan" role="button"onclick="close_details();">
                                      <p class="dan text-right"style="margin-right:25px;">
	                                   <i class="fa fa-times fa-2x"></i>
                                      <strong>&nbsp;schließen</strong></a></p> ';
            $a1 = array("method"   =>"read_wp_db",
                        "table"    =>"art_galerie",
                        "select"   =>"*");
          $dat = new DbHandle($a1);
          $data1=$dat->return;
          for($i = 1; $i <= $data1['count']; $i++) {
           $a3 = array("method"   =>"read_wp_db",
                      "table"    =>"art_freigaben",
                      "select"   =>"*",
                      "where"    => " where galerie_id = %d",
                      "search"   => $data1['data'][$i -1]->id,
                      "session"  =>false);
          $dat3 = new DbHandle($a3);
         // $data3=$dat3->return;
          if(empty($data3['count'])){
            $freigabe_count = '<span class="dan">'.$data3['count'].'</span>';
          }else{
           $freigabe_count = '<span class="suss">'.$data3['count'].'</span>'; 
          }
          $btn_bearbeiten = '<p class="text-center"> <a  role="button" class="btn btn-warning btn-outline btn-sm"
                            data-toggle="modal"data-target="#GalerieModal"data-whatever="details_load_edit_galerie_modal+'.$data1['data'][$i -1]->galerie_name.'">
                            <span style="margin-top:3px; " class="fa fa-info"></span>&nbsp;bearbeiten</a>
                            </p>';
          $btn_new_freigabe ='<p class="text-center"> <a  role="button" class="btn btn-success btn-outline btn-sm"
                            data-toggle="modal"data-target="#GalerieModal"data-whatever="details_newFreigabeModal+'.$data1['data'][$i -1]->galerie_name.'">
                            <span style="margin-top:3px; " class="fa fa-plus"></span>&nbsp; neue freigabe</a>
                            </p>';
          $btn_new_delete = '<p class="text-center"><a  role="button" class="btn btn-danger btn-outline btn-sm"
                            data-toggle="modal"data-target="#GalerieModal"data-whatever="details_DeleteGalerieModal+'.$data1['data'][$i -1]->galerie_name.'">
                            <span style="margin-top:3px; " class="fa fa-trash-o"></span>&nbsp;löschen</a>
                           </p>';
          $date1 = new \DateTime($data2['data'][$i -1]->created_at); 
          $datum1 = $date1->format('d.m.Y');   
        if(empty($data1['data'][$i -1]->last_update)){
          $datum2='unbekannt';
          }else{
          $date2 = new \DateTime($data1['data'][$i -1]->last_update); 
          $datum2 = $date2->format('d.m.Y'); 
         }
         if(!empty($data1['data'][$i -1]->tags)){
            $tags = '<span class="suss">ja</span>' ;
            }else{
            $tags = '<span class="dan">nein</span>' ;    
            }
            if(!empty($data1['data'][$i -1]->beschreibung)){
            $beschreibung = '<span class="suss">ja</span>' ;
            }else{
            $beschreibung = '<span class="dan">nein</span>' ;    
            }
            $message        = 0;
         if(!empty($data1['data'][$i -1]->message)){
             $message++;
            }
        $a2 = array("method"   =>"read_wp_db",
                    "table"    =>"art_images",
                    "select"   =>"*",
                    "where"    => " where galerie_name = %s",
                    "search"   => $data1['data'][$i -1]->galerie_name );
            $dat2 = new DbHandle($a2);
            $data2=$dat2->return;
            $exif           = 0;
            $gps            = 0;
             for ($x = 1; $x <= $data2['count']; $x++)
             {
             $exifData = unserialize($data2['data'][$x -1]->exif);
              if(!empty($exifData['count'] )){
              $exif_result = '<span class="suss">'.$exif.'</span>';  
              $exif++;  
              }else{
              $exif_result = '<span class="dan">'.$exif.'</span>';
              }
              if(!empty($exifData['GPSLatitudeRef'])){
              $gps_result = '<span class ="suss">'.$gps.'</span>';
              $gps++;  
              }else{
              $gps_result = '<span class="dan">'.$gps.'</span>';  
              }
            }
          $this->optionen['name'] = $data1['data'][$i -1]->galerie_name;
          $this->optionen['datum1'] = $datum1;
          $this->optionen['datum2'] = $datum2;
          $this->optionen['footer2'] = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(freigabe user &nbsp;->&nbsp;<span class="dan"> rot </span> = nicht aktiv  | <span class="suss">grün</span> = aktiv)';
          $this->optionen['th1'] = 'ID';
          $this->optionen['th2'] = 'Bilder';            
          $this->optionen['th3'] = 'Galerie beschr.';
          $this->optionen['th4'] = 'Galerie Tags';
          $this->optionen['th5'] = 'GPS Daten';
          $this->optionen['th6'] = 'Exif Daten';
          $this->optionen['th7'] = '';
          $this->optionen['th8'] = 'Galerie freig.';
          $this->optionen['th10'] = 'Galerie beschr.';
          $this->optionen['th11'] = '';
          $this->optionen['th12'] = 'löschen';
          $this->optionen['td1'] = '<b>'.$data1['data'][$i -1]->id.'</b>';
          $this->optionen['td2'] = $data2['count'];
          $this->optionen['td3'] = $beschreibung;
          $this->optionen['td4'] = $tags;
          $this->optionen['td5'] = $gps_result;
          $this->optionen['td6'] = $exif_result;
          $this->optionen['td7'] = '';
          $this->optionen['td8'] = $freigabe_count;
          $this->optionen['td10'] = $btn_bearbeiten;
          $this->optionen['td11'] = '';
          $this->optionen['td12'] = $btn_new_delete;
          $template .= $this->get_template();
        } 
        break;
  case 'image_details':
          $this->optionen['icon'] = '<span class="fa fa-picture-o"</span>';  
          $this->optionen['header'] = '<input type="hidden"name="details_loaded"value="loaded">
                                       <h3><span class="warn">Image</span>  <small><strong>details</strong></small></h3>
                                       <a class="dan" role="button"onclick="close_details();">
                                       <p class="dan text-right"style="margin-right:25px;">
	                                   <i class="fa fa-times fa-2x"></i>
                                       <strong>&nbsp;schließen</strong></a></p> ';
          $a1 = array("method"   =>"read_wp_db",
                      "table"    =>"art_galerie",
                      "select"   =>"*");
          $dat = new DbHandle($a1);
          $data1=$dat->return;
          for($i  = 1; $i <= $data1['count']; $i++) {
          $a2 = array("method"   =>"read_wp_db",
                      "table"    =>"art_images",
                      "select"   =>"*",
                      "where"    => " where galerie_name = %s",
                      "search"   => $data1['data'][$i -1]->galerie_name);
            $dat2 = new DbHandle($a2);
            $data2=$dat2->return;
            $a3 = array("method"   =>"read_wp_db",
                        "table"    =>"art_freigaben",
                        "select"   =>"*",
                        "where"    => " where galerie_id = %s",
                        "search"   => $data1['data'][$i -1]->id);
            $dat3 = new DbHandle($a3);
            $data3=$dat3->return;
            $pid = unserialize($data3['data'][0]->select_image);
            $post_id =  count($pid);
            $msg = unserialize($data3['data'][0]->message);
            $message =  count($ms);
            $tags           = 0;
            $beschreibung   = 0;
            $exif           = 0;
            $gps            = 0;
          for ($x = 1; $x <= $data2['count']; $x++) {
              $exifData = unserialize($data2['data'][$x -1]->exif);
            if($exifData['count'] > 0){
              $exif++;  
              }
            if(!empty($exifData['GPSLatitudeRef'])){
              $gps++;  
              }
            if(!empty($data2['data'][$x -1]->tags)){
               $tags++;
             }
            if(!empty($data2['data'][$x -1]->beschreibung)){
               $beschreibung++;
             }
          }
          if(!empty($data3['count'])){
            $color8 = 'green';
            $txt = 'yes';
          }else{
            $color8 = '#c75e47';
            $txt = 'no';
          }
          if($post_id === 0){
                $disabled1       = 'disabled="disabled"';
                $color_badge1    = '#c75e47';
                $color1          = 'danger';
                $logo1           = ' fa-frown-o';
            }else{
                $disabled1       = '';
                $color_badge1    = 'green';
                $color1          = 'success';
                $logo1           = ' fa-smile-o';  
            }
            if($message === 0){
                $disabled2       = 'disabled="disabled"';
                $color_badge2    = '#c75e47';
                $color2          = 'danger';
                $logo2           = ' fa-frown-o';
            }else{
                $disabled2       = '';
                $color2          =' success';
                $color_badge2    = 'green';
                $logo2           = ' fa-envelope-o';  
            }
            $a3 = array("method"   =>"read_wp_db",
                        "table"    =>"art_images",
                        "select"   =>"created_at,galerie_name",
                        "where"    => " where galerie_name = %s ORDER BY created_at ASC LIMIT 1",
                        "search"   => $data1['data'][$i -1]->galerie_name);
            $dat3 = new DbHandle($a3);
            $data3=$dat3->return;
            $date1 = new \DateTime($data3['data'][0]->created_at); 
            $datum1 = $date1->format('d.m.Y'); 
            $a4 = array("method"   =>"read_wp_db",
                      "table"    =>"art_images",
                      "select"   =>"last_update",
                      "where"    => " where galerie_name = %s ORDER BY last_update DESC LIMIT 1",
                      "search"   => $data1['data'][$i -1]->galerie_name);
            $dat4 = new DbHandle($a4);
            $data4=$dat4->return;
        if(empty($data4['data'][0]->last_update)){
          $datum2='unbekannt';
          }else{
          $date2 = new \DateTime($data4['data'][0]->last_update); 
          $datum2 = $date2->format('d.m.Y'); 
         }
         if(empty($data2['count']) ? $color3 = '#c75e47' : $color3='green');
         if(empty($beschreibung) ? $color4 = '#c75e47' : $color4='green');
         if(empty($tags) ? $color5 = '#c75e47' : $color5='green');
         if(empty($gps) ? $color6 = '#c75e47' : $color6='green');
         if(empty($exif) ? $color7 = '#c75e47' : $color7='green');
          $btn1 = '<span class="badge" style="margin-left: 15px;background-color: '.$color_badge1.';">'.$post_id.'</span>';
          $btn2 = '<span class="badge" style="margin-left: 15px;background-color: '.$color_badge2.';">'.$message.'</span>';
          $this->optionen['name'] = $data1['data'][$i -1]->galerie_name;
          $this->optionen['datum1'] = $datum1;
          $this->optionen['datum2'] = $datum2;
          $this->optionen['th1'] = 'Galerie ID';
          $this->optionen['th2'] = 'Galerie Name';            
          $this->optionen['th3'] = 'Bilder';
          $this->optionen['th4'] = 'Bilder beschr.';
          $this->optionen['th5'] = 'Bilder Tags';
          $this->optionen['th6'] = 'GPS Daten';
          $this->optionen['th7'] = 'Exif Daten';
          $this->optionen['th8'] = 'freigaben';
          $this->optionen['th9'] = 'Checked';
          $this->optionen['th10'] = 'Message';
          $this->optionen['td1'] = '<span class="prem"><b>'.$data1['data'][$i -1]->id.'</span></b>';
          $this->optionen['td2'] = '<span class="warn"><b>'. $data1['data'][$i -1]->galerie_name.'</b></span>';
          $this->optionen['td3'] = '<span class="badge" style="margin-left: 15px;background-color: '.$color3.';">'.$data2['count'].'</span>';
          $this->optionen['td4'] = '<span class="badge" style="margin-left: 15px;background-color: '.$color4.';">'.$beschreibung.'</span>';
          $this->optionen['td5'] = '<span class="badge" style="margin-left: 15px;background-color: '.$color5.';">'.$tags.'</span>';
          $this->optionen['td6'] = '<span class="badge" style="margin-left: 15px;background-color: '.$color6.';">'.$gps.'</span>';
          $this->optionen['td7'] = '<span class="badge" style="margin-left: 15px;background-color: '.$color7.';">'.$exif.'</span>';
          $this->optionen['td8'] = '<span class="badge" style="margin-left: 15px;background-color: '.$color8.';">'.$txt.'</span>';
          $this->optionen['td9'] = $btn1;
          $this->optionen['td10'] =$btn2;
          $template .= $this->get_template();
        }
        break;
 case 'user_details':
        $a2 = array("method"   =>"read_wp_db",
                   "table"    =>"art_user",
                   "select"   =>"*");
       $dat2 = new DbHandle($a2);
       $data2=$dat2->return;
        if(empty($data2['count'])){
        $err=parent::response('21');
        return array("status"=>false,"message"=>$err['response_msg']);   
        }
        $abfrage = array("method"   =>"user_wp_freigabe_start");
       $dat = new DbHandle($abfrage);
       $data=$dat->return;
        if(empty($data['count'])) {
          $err=parent::response('22');
          return array("status"=>false,"message"=>$err['response_msg']);
          }
        foreach ($data['data'] as $tmp){
            $return = $this->template_user_details($tmp);
            }
        break;
 case 'user_freigaben_start':
        $a2 = array("method"   =>"read_wp_db",
                   "table"    =>"art_user",
                   "select"   =>"*");
        $dat2 = new DbHandle($a2);
       $data2=$dat2->return;
        if(empty($data2['count'])){
        $err=parent::response('22');
        return array("status"=>false,"message"=>$err['response_msg']);   
        }
        if(empty($this->optionen['data'])){
       $abfrage = array("method"   =>"user_wp_freigabe_start");
       $dat = new DbHandle($abfrage);
       $data=$dat->return;  
        }else{
       $abfrage = array("method"  =>"user_wp_freigabe_select",
                        "data"    =>array(
                        "where"   =>$this->optionen['data']['where'],
                        "typ"     =>$this->optionen['data']['typ']));
       $dat = new DbHandle($abfrage);
       $data=$dat->return; 
        }
        if(empty($data['count'])) {
          $err=parent::response('22');
          return array("status"=>false,"message"=>$err['response_msg']);
          }
        foreach ($data['data'] as $tmp){
          $date = new \DateTime($tmp->created_at); 
          $this->created_at = $date->format('d.m.Y'); 
          $date2 = new \DateTime($tmp->last_update); 
          $this->last_update = $date2->format('d.m.Y');
          $this->details = unserialize($tmp->settings);
          $this->htaccess_user = $tmp->htaccess_user ; 
          if(!empty($tmp->message)){
           $c = count(array_filter(unserialize($tmp->message))); 
          $color1 = ' green';
          $msgtxt1 = $c;  
         }else{
          $color1 ='#c75e47';
          $msgtxt1 = '0';  
         }
          if(!empty($tmp->select_image)){
           $d = count(array_filter(unserialize($tmp->select_image))); 
          $color2 = ' green';
          $msgtxt2 = $d;  
         }else{
          $color2 ='#c75e47';
          $msgtxt2 = '0';  
         }
         if(strlen($tmp->galerie_name) > 10 ? $p = '...'  : $p = '' );
         $gN = substr($tmp->galerie_name,0,10);
         $galerieName = $gN.$p;
         if(!empty($this->details['beschreibung'])){
          $this->checked_beschreibung = ' checked';
         }else{
          $this->checked_beschreibung ='';
         }
          if(!empty($this->details['gps'])){
          $this->checked_gps = ' checked';
          $this->valueGps=1;
         }else{
          $this->checked_gps ='';
          $this->valueGps=0;
         }
          if(!empty($this->details['exif'])){
          $this->checked_exif = ' checked';
          $this->valueExif=1;
         }else{
          $this->checked_exif ='';
          $this->valueExif=0;
         }
          if(!empty($this->details['auswahl'])){
          $this->checked_auswahl = ' checked';
          $this->valueAuswahl =1;
         }else{
          $this->checked_auswahl ='';
          $this->valueAuswahl =0;
         }
          if(!empty($this->details['kommentar'])){
          $this->checked_kommentar = ' checked';
          $this->valueKommentar =1;
         }else{
          $this->checked_kommentar ='';
          $this->valueKommentar =0;
         }
          if(!empty($this->details['log'])){
          $this->checked_log = ' checked';
          $this->valueLog =1;
         }else{
          $this->checked_log ='';
          $this->valueLog =0;
         }
          if(!empty($this->details['nachricht'])){
          $this->checked_nachricht = ' checked';
          $this->valueNachricht =1;
         }else{
          $this->checked_nachricht ='';
          $this->valueNachricht =0;
         }
          if(!empty($tmp->freigabe_aktiv)){
          $checked = ' checked';
          $this->value = 1;
         }else{
          $this->value = 0;  
          $checked ='';
         }
          $this->optionen['name'] = '<span class="warn">'.$tmp->htaccess_vorname.'</span><span class="prem"> '.$tmp->htaccess_nachname.'</span> <b style="color:#7d7d7d;"> | '.$tmp->galerie_name.'</b>
                                     <small style="color:#7d7d7d;">(erstellt am: '.$this->created_at.' <b class="warn"> | </b> eMail: '.$tmp->htaccess_email.' <b class="warn"> | </b> Login: '.$tmp->htaccess_user.' )</small>';
          $this->optionen['th1'] = 'ID';
          $this->optionen['th2'] = '<i class="fa fa-check-square-o"></i> freig. aktiv 
                                    <a class="wptool" data-toggle="tooltip" title="'.$this->tt['tt_freigabe_aktiv'].'">
                                    <span class="prem fa fa-question-circle"></span></a>';
          $this->optionen['th3'] = '<i class="fa fa-photo"></i> Galerie ID';            
          $this->optionen['th4'] = '<i class="fa fa-user"></i> Benutzer';
          $this->optionen['th6'] = '<i class="fa fa-envelope-o"></i> Message 
                                    <a class="wptool" data-toggle="tooltip" title="'.$this->tt['tt_image'].'">
                                    <span class="prem fa fa-question-circle"></span></a>';
          $this->optionen['th7'] = '<i class="fa fa-check-square-o"></i> check 
                                    <a class="wptool" data-toggle="tooltip" title="'.$this->tt['tt_check'].'">
                                    <span class="prem fa fa-question-circle"></span></a>';
          $this->optionen['th8'] = '<i class="fa fa-share-square-o"></i> freigabe';
          $this->optionen['th9'] = '<span class="dan"><i class="fa fa-trash"></i> freig. löschen
                                    <a class="wptool" data-toggle="tooltip" title="'.$this->tt['tt_delete'].'">
                                    <span class="prem fa fa-question-circle"></span></a>';
          $this->optionen['td1'] = $tmp->freigabe_id;
          $this->optionen['td2'] = '<label class="switch">
                                    <input type="checkbox"id="'.$tmp->freigabe_id.'_freigabe_aktiv"value="'.$this->value.'" onclick="htaccess_aktiv(\''.$tmp->freigabe_id.'_freigabe_aktiv\');"
                                    '.$checked.'> 
                                    <span class="slider round"></span>
                                    </label>';
          $this->optionen['td3'] = '<b class="prem">'.$tmp->galerie_id.'</b>';
          $this->optionen['td4'] = '<b class="prem">'.$tmp->htaccess_user.'</b>';
          $this->optionen['td6'] = '<span class="badge"style="margin-left: 25px;background-color: '.$color1.';">'.$msgtxt1.'</span>';
          $this->optionen['td7'] = '<span class="badge"style="margin-left: 15px;background-color: '.$color2.';">'.$msgtxt2.'</span>';
          $this->optionen['td8'] = '<h4 class="prem">'. $galerieName.'</h4>';
          $this->optionen['td9'] = ' <button class="btn btn-danger btn-outline btn-sm"data-toggle="modal"data-toggle="modal"data-target="#FreigabeModal"data-whatever="'.$tmp->freigabe_id.'_load_delete_freigabe_modal+freigabe" ><span class="fa fa-trash"></span> freig. löschen</button>';
          $this->optionen['freigabe-details'] = $this->template_freigabe_details($tmp);
          $template .= $this->get_template();
         }
        break;
        case 'get_user_response':
        $template .= $this->get_template();
        break;
}
     $this->optionen['header'] = preg_replace(array('/<!--(.*)-->/Uis', "/[[:blank:]]+/"), array('', ' '), str_replace(array("\n","\r","\t"), '',$this->optionen['header']));
     $template = preg_replace(array('/<!--(.*)-->/Uis', "/[[:blank:]]+/"), array('', ' '), str_replace(array("\n","\r","\t"), '', $template));
     return $this->optionen['header'] . $template;
   }
   private function template_freigabe_details($daten="") {
    $select = ' selected="selected"';
    if($daten->galerie_typ == 1 ? $select1 = $select : $select1 = '');
    if($daten->galerie_typ == 2 ? $select2 = $select : $select2 = '');
    if($daten->galerie_typ == 3 ? $select3 = $select : $select3 = '');
    $gTyp =     '<select class="form-control"onchange="select_galerietyp(this.value)">
                 <option value="'.(int)$daten->freigabe_id.'_0">Galerie Typ</option>
                 <option value="'.(int)$daten->freigabe_id.'_1" '.$select1.'>Typ 1</option>
                 <option value="'.(int)$daten->freigabe_id.'_2" '.$select2.'>Typ 2</option>
                 <option value="'.(int)$daten->freigabe_id.'_3" '.$select3.'>Typ 3</option>
                 </select>';
    if(empty($this->settings['license_aktiv'])){
       $txt='<br><hr class="hr-light"><br><h5 class="grey"><span class="dan fa fa-asterisk "></span> In der Standart Version sind GPS, EXIF und Galerie Typ-Auswahl deaktiviert.<br> <br> <hr class="hr-light"><br> <span class="warn fa fa-arrow-right "></span> In der <a class="prem" role="button" href="'.ART_PICTURE_SALE.'" target="_blank"> Art-Picture Galerie <b class="dan"> Pro</b></a> können Sie GPS und Exif Daten freigeben. Es stehen zuzätzlich 2 weitere Galerie-Layouts zur Verfügung.</h5>';
    $stern='<span class="dan fa fa-asterisk  "></span>';    
    }
    $template = ' 
                 <div class="table-responsive">
                 <table class="details table ">
                 <thead>
                 <tr>
                 <th>'.$stern.' <i class="fa fa-crosshairs "></i> Gps 
                 <a class="wptool" data-toggle="tooltip" title="'.$this->tt['tt_gps_aktiv'].'">
                 <span class="prem fa fa-question-circle"></span></a>

             </th>
                 <th>'.$stern.' <i class="fa fa-calendar-o"></i> exif 
                 <a class="wptool" data-toggle="tooltip" title="'.$this->tt['tt_exif_aktiv'].'">
                 <span class="prem fa fa-question-circle"></span></a>
                  </th>
                 <th><i class="fa fa-user"></i> auswahl 
                 <a class="wptool" data-toggle="tooltip" title="'.$this->tt['tt_auswahl_aktiv'].'">
                 <span class="prem fa fa-question-circle"></span></a>
                 </th>
                 <th><i class="fa fa-comments-o "></i> Kommentar 
                 <a class="wptool" data-toggle="tooltip" title="'.$this->tt['tt_kommentar_aktiv'].'">
                 <span class="prem fa fa-question-circle"></span></a>
                 </th>
                 <th><i class="fa fa-save "></i> user Log 
                 <a class="wptool" data-toggle="tooltip" title="'.$this->tt['tt_log_aktiv'].'">
                 <span class="prem fa fa-question-circle"></span></a>
                 </th>
                 </th>
                 <th>'.$stern.' <i class="fa  fa-gears"></i> galerie typ 
                 <a class="wptool" data-toggle="tooltip" title="'.$this->tt['tt_galerie_typ'].'">
                 <span class="prem fa fa-question-circle"></span></a>
                 </th>
                 </tr>
                 </thead>  
                 <tr>
                 <td>
                 <label class="switch">
                 <input type="checkbox"id="gps-aktiv'.$daten->freigabe_id.'"value="'.$this->valueGps.'" onclick="checkedHtaccess(\'gps_'.$this->optionen['td1'].'\');"
                               '.$this->checked_gps.'> 
                 <span class="slider round"></span>
                 </label>
                 </td>
                 <td>
                 <label class="switch">
                 <input type="checkbox"id="exif-aktiv'.$daten->freigabe_id.'"value="'.$this->valueExif.'"  onclick="checkedHtaccess(\'exif_'.$this->optionen['td1'].'\');"
                               '.$this->checked_exif.'> 
                 <span class="slider round"></span>
                 </label>
                 </td>
                 <td>
                 <label class="switch">
                 <input type="checkbox"id="auswahl-aktiv'.$daten->freigabe_id.'"value="'.$this->valueAuswahl.'" onclick="checkedHtaccess(\'auswahl_'.$this->optionen['td1'].'\');"
                               '.$this->checked_auswahl.'> 
                 <span class="slider round"></span>
                 </label>
                 </td>
                 <td>
                 <label class="switch">
                 <input type="checkbox"id="kommentar-aktiv'.$daten->freigabe_id.'"value="'.$this->valueKommentar.'" onclick="checkedHtaccess(\'kommentar_'.$this->optionen['td1'].'\');"
                               '.$this->checked_kommentar.'> 
                 <span class="slider round"></span>
                 </label>
                 </td>
                 <td>
                 <label class="switch">
                 <input type="checkbox"id="log-aktiv'.$daten->freigabe_id.'"value="'.$this->valueLog.'" onclick="checkedHtaccess(\'log_'.$this->optionen['td1'].'\');"
                               '.$this->checked_log.'> 
                 <span class="slider round"></span>
                 </label>
                 </td>
                 <td>
                 <div id="'.$daten->freigabe_id.'_galerietyp-aktiv" class="form-inline">
                 '.$gTyp.'   
                </div>
                </td>
                </tr>
                </table>
                </div>
                <hr class="hr-light">
                <h5 class="prem"><span class="fa fa-calendar-o"></span> last update<small> ('.$this->last_update.') </small></h5>'.$txt.'
                <br>
                <p><span class="prem fa fa-info-circle"></span><b class="grey"> Info:</b> Um die GPS-Daten zu sehen, geben Sie bitte ihren Google-Maps Api-KEY ein. Die Eingabe finden Sie unter <span class="warn fa fa-arrow-right"></span><b class="grey"> Settings</b> <span class="warn fa fa-arrow-right"></span><b class="grey"> GoogleMaps API-Key.</b><br><a href="https://developers.google.com/maps/documentation/javascript/get-api-key?hl=de#key"role="button" target="_blank"><b class="prem">Hier </b></a> finden Sie eine Anleitung wie Sie einen <b class="grey">Standard</b> GoogleMaps api-KEY anlegen.   </p>
                <br>';
                return $template;
   }
  private function get_template() {
    $header     = $this->optionen['header'];
    $template = '<div class="displaystyle displaystyle-fullborder displaystyle-warning displaystyle-sm">
                 <div class="panel-heading panel-primary">';
                 if(!empty($this->optionen['datum1'])){
                    $datum1 ='<small style="color:#777 !important; ">erstellt am: '.$this->optionen['datum1'].'</small>';
                 }
    $template .='<h3 class="panel-title prem">'.$this->optionen['icon'].' '.$this->optionen['name'].' '.$datum1.'</h3>
                 '.$this->optionen['temp-head'].'
                 </div>
                 <div class="panel-body">
                 <div class="table-responsive">
                 <table class=" details table">
                 <thead>
                 <tr>
                 <th>'.$this->optionen['th1'].'</th>
                 <th>'.$this->optionen['th2'].'</th>
                 <th>'.$this->optionen['th3'].'</th>
                 <th>'.$this->optionen['th4'].'</th>
                 <th>'.$this->optionen['th5'].'</th>
                 <th>'.$this->optionen['th6'].'</th>
                 <th>'.$this->optionen['th7'].'</th>
                 <th>'.$this->optionen['th8'].'</th>
                 <th>'.$this->optionen['th9'].'</th>
                 <th>'.$this->optionen['th10'].'</th>
                 <th>'.$this->optionen['th11'].'</th>
                 <th>'.$this->optionen['th12'].'</th>
                 </tr>
                 </thead>
                 <tbody>
                 <tr>
                 <td>'.$this->optionen['td1'].'</td>
                 <td>'.$this->optionen['td2'].'</td>
                 <td>'.$this->optionen['td3'].'</td>
                 <td>'.$this->optionen['td4'].'</td>
                 <td>'.$this->optionen['td5'].'</td>
                 <td>'.$this->optionen['td6'].'</td>
                 <td>'.$this->optionen['td7'].'</td>
                 <td>'.$this->optionen['td8'].'</td>
                 <td>'.$this->optionen['td9'].'</td>
                 <td>'.$this->optionen['td10'].'</td>
                 <td>'.$this->optionen['td11'].'</td> 
                 <td>'.$this->optionen['td12'].'</td> 
                 </tr>
                 </tr>
                 </tbody>
                 </table>
                 </div>
                 '.$this->optionen['freigabe-details'].'
                 </div><!--body-->';
              //PRO-VERSON    
                 if(!empty($this->optionen['datum2'])){
                 $template .= '<h5 class="prem panel-footer panel-primary"><span class="fa fa-calendar" ></span> letztes Update <small>'.$this->optionen['datum2'].'
                 '.$this->optionen['footer2'].' </small> </h5>'; 
                 }
                 $template .= '</div>';
                                
                return $template;
   }
     public function __destruct(){
    $this->return;
    $this->settings;
    $this->optionen;
   } 
}
?>

