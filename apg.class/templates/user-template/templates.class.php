<?php
/**
 * ArtPicture Plugin PHP Class
 * http://art-pictureDesign.de/WP-ArtTheme-Galerie
 * Copyright 2017, Jens Wiecker
 * https://art-picturedesign.de
 *
 */
if ( ! defined( 'ABSPATH' ) ) exit;
require_once(dirname(dirname(__DIR__)).'/db/class_db_handle.php');
require_once(dirname(dirname(__DIR__)).'/ApgSettings.php');
require_once(dirname(dirname(__DIR__)).'/ApgCore.php');
use APG\ArtPictureGallery\DbHandle as DbHandle;
use APG\ArtPictureGallery\ApgSettings as ApgSettings;
use APG\ArtPictureGallery\Core as Core;
 function apg_art_piture_gallery_freigaben(){
     $img_url= plugins_url('../../../assets/images/',__FILE__);
     $settings = ApgSettings::load_settings('user_settings');
     $i = 1;
     $fehler = true;
     $bilder_total = 0;
     $gal_name_length = 19;
     $template_footer =  '</div> </div>';
     $freigaben_footer = '</div>';
     $noFreigabe = '      <h3 class="dan text-center"style="padding-top:65px;min-height:380px;">
                          <span class="dan fa fa-angle-double-right"></span><span class="dan fa fa-angle-double-right"></span>&nbsp;Es <span class="grey"> sind noch keine Galerie
                          <b class="dan"> Freigaben</b> vorhanden!
                          </span><b class="dn fa fa-angle-double-left"></b><b class="dan fa fa-angle-double-left"></b></h3>';
     //falls keine freigaben return
     $a1 = array("method"   =>"user_wp_freigabe_start");
     $usr = new DbHandle($a1);
     $userDB=$usr->return;
     
     if( $userDB['count'] == '0')
     {
     $template = '<br /><h3 class="dan text-center"style="padding-top:50px;padding-bottom:320px;"><span class="fa  fa-info"></span> Es <span class="grey"> sind noch <b class="dan"> keine</b> Freigaben für Sie vorhanden!</span></h3>';  
     return array("freigabenHeader"=>"","freigaben_footer"=>"","freigaben"=>$template,"details"=>$loaded_details);      
     }
    foreach($userDB['data'] as $tmp)
    {
     $gnl = strlen($tmp->galerie_name);
     if($gnl > 19) {
     $cg = '...'; 
     $c = 16 ; 
     }else{
     $cg = ''; 
     $c = 19;
     }
     $galeriename = substr($tmp->galerie_name,0,$c).$cg;   
    if(empty($tmp->beschreibung) ? $beschreibung = 'keine Beschreibung vorhanden.' : $beschreibung = $tmp->beschreibung);
    //abruf Image DB für count
      global $wpdb;
      $table_name = $wpdb->prefix . 'art_images';
      $row = $wpdb->get_results( $wpdb->prepare(
     "SELECT *
      FROM  ".$table_name." 
      where galerie_name = %s ", 
      $tmp->galerie_name ));
      $bilder_total +=count($row);
      //Überprüfen ob Galerie für Benutzer bestimmt ist   
      if($tmp->id == $_SESSION['id'] && !empty($tmp->freigabe_aktiv) && !empty($tmp->htaccess_aktiv)){
      //header Galerie Ergebniss
      $loaded_details = '<br />
                         <div id="gallery_details" class="col-md-12">
                         <span >
                         <table class="table ">
                         <tr class="apg_style">
                         <td class="apg_style" width="35%">
                         <span class="warn fa fa-folder-open-o"></span> <b class="grey">Aktuell Galerie:</b>
                         </td>
                         <td class="apg_style">
                         <b class="grey"><span id="galerie_aktuell"></span></b>
                         </td></tr>
                         <tr class="apg_style"><td class="apg_style" width="40%">
                         <span class="warn fa fa-camera"></span> 
                         <b class="grey">Bilder Galerie:</b> 
                         </td>
                         <td class="apg_style">
                         <b class="grey"><span id="galerie_total"></span></b>
                         </td></tr>
                         <tr class="apg_style"><td class="apg_style" width="30%">
                         <span class="warn fa fa-pencil-square-o"></span>
                         <b class="grey">Beschreibung:</b>
                         </td>
                         <td class="apg_style">
                         <b class="grey"><span id="galerie_beschreibung"></span></b>
                         </td>
                         </tr>
                         </span>
                         </table>
                         <br />                     
                        <a  role="button" href="?apg-user-gallery-template=12067106">
                        <h4 class="prem"><u><span class="fa fa-angle-double-left"></span><span class="fa fa-angle-double-left"></span> zurück zur Übersicht</u></h4></a></div>';
     $freigaben_header ='<br />
                         <div class="row">
                         <div class="col-md-8 col-md-offset-2">
                         <hr class="hr-footer">
                         <b class ="warn fa fa-angle-double-right"></b> <span class="warn fa fa-folder-open-o"></span> <b class="grey">Galerie Freigaben: <b class="prem">'.$i.'</b></b> <b class="warn">|</b> 
                         <span class="warn fa fa-camera"></span> <b class="grey">Bilder Gesamt: <b class="prem"> '.$bilder_total.'</b></b>
                         <b class ="warn fa fa-angle-double-left"></b>
                         <hr class ="hr-footer">
                         <br />                     
                         </div></div>
                         <div class="row"><div class="col-md-8 col-md-offset-2">';
       //einzelne Galerien für User              
       $template .=     '<a role="button"onclick="art_galerie_select(\''.$tmp->galerie_name.'\',\''.$_SESSION['id'].'\');">
                        <div class="col-md-3 galerie-start">
                        <br />
                        <img src="'.$img_url.'header_logo-small.png"><br />
                        <h4 class="grey">Galerie: <br /></h4>
                        <small><b>Bilder: <b></b><b class="prem">'.count($row).'</b></small>
                        <br />
                        <small><b>Name: </b><b class="prem">'.$galeriename.'</b></small>
                        <br />
                        </div>
                        </a>';
                        //$i count für Galerien insgesamt
                        $i++;
                      }
                        //Abbruch wen kein Pro    
                        if(empty($settings['license_aktiv']) && $i > 1){
                        break;   
                        }   
                       }
    $footer = $template_footer;
    if(empty($template)){
        $template = $noFreigabe;
        $footer = '';
    }
    $freigabenHeader = $navigation . $freigaben_header;                
    $template =  $template . $footer;
    return array("freigabenHeader"=>$freigabenHeader,"freigaben_footer"=>$freigaben_footer,"freigaben"=>$template,"details"=>$loaded_details);
    }
?>