<?php
/**
 * ArtPicture Plugin PHP Class
 * http://art-pictureDesign.de/WP-ArtTheme-Galerie
 * Copyright 2017, Jens Wiecker
 * https://art-picturedesign.de
 *
 */
if ( ! defined( 'ABSPATH' ) ) exit;
require_once (dirname(__DIR__).'/apg.class/db/class_db_handle.php');
require_once (dirname(__DIR__).'/apg.class/ApgSettings.php');
use  APG\ArtPictureGallery\DbHandle as DbHandle;
use  APG\ArtPictureGallery\ApgSettings as ApgSettings;
get_header();



function apg_image_details_temp(){
    isset($_GET['id']) && is_string($_GET['id'])  ? $id = esc_attr($_GET['id']) : $id = "";
    $settings = ApgSettings::load_settings('user_settings');
    $abfrageImg = array("method" =>"read_wp_db",
                        "table"  =>"art_images",
                        "select" =>"*",
                        "where"  =>" where id = %d",
                        "search" =>$id );
        $dat = new DbHandle($abfrageImg);
        $image = $dat->return; 
        $img = $image['data'][0];
    if(!empty($img->beschreibung)){
            $beschreibung = '<b> Bildbeschreibung:</b><br>
                             <div class="grey" style="min-height:80px;padding:15px; border: 1px solid #eee;"> 
                              '.$img->beschreibung.'  
                             </div>';
        }else{
            $beschreibung = '<small class="grey">no description!</small>';
        }
       if(!empty($img->tags)){
            $detailsUrl = substr(admin_url(),0,strpos(admin_url(),'wp-admin'));
            $t = @explode(",",$img->tags);
            $tags_head = '<b>Tags:</b> <b class="grey">';
            $tags_foot = '</b><br><br>';
            foreach($t as $tmp)
            {
             $tags_body .= '<a href="?apg-user-gallery-template=12067115&search='.$tmp.'">'. $tmp.'</a>, ';   
            }
            $tags = $tags_head . $tags_body . $tags_foot;
        }else{
            $tags = '<small class="grey"> no Tags</small><br><br>';
        }
        $date = new DateTime($img->created_at); 
       if(empty($settings['header_box'])){
           $header = '<h3 class="grey text-center"><span class="fa fa-camera"></span> <span style="color:#444;">Image</span>-Details</h3>';
       }else{
           $header = '<p class="text-center"><img src="'.$settings['header_box'].'"><p><br><hr class="hr-light"><br>';
       }
        $datum = $date->format('d.m.Y');    
        $template = '<div class="bootstrap-wrapper">
                    <div class="container main" style="padding-bottom:50px;padding-top:'.$settings['padding_top'].'; background-color:'.$settings['site_background_color'].';">
                    <div class="row main-content" >
                    <div class="col-lg-8 col-lg-offset-2 col-md-12 col-md-offset-2 col-sm-12 col-sm-offset-2" >   
                    '.$header.'
                    <a href="'.$_SERVER['REDIRECT_URL'].'"><span class="fa fa-angle-double-left"></span> zurück </a> 
                    <br><br>
                    <div class="thumbnail"style="margin-bottom:0px;padding-top:25px; background-color:'.$settings['box_background_color'].';">
                    <a data-gallery="" titel="'.$img->name.'" href = "'.$img->url.'"><img src="'.$img->mediumUrl.'" alt="'.$img->name.'"><small><div class="grey text-center">
                    <i>'.$img->name.'</i></div></small></a><br>
                    <div class="caption">
                    <h3 class="grey "><span class="fa fa-camera"></span> <span style="color:#444;">Image</span>-Details</h3>
                    <b>created on:</b> <b class="grey">'.$datum.'</b><br>
                    '.$tags.'
                    '.$beschreibung.'
                    </div>
                    </div>
         			</div><!--col-md-10-->
                    </div>
                    </div>             
                    </div><!--wrapper-->  ';
         $template = preg_replace(array('/<!--(.*)-->/Uis', "/[[:blank:]]+/"), array('', ' '), str_replace(array("\n","\r","\t"), '', $template));
        return $template;
    }

echo apg_image_details_temp();
apg_bluemGallery_select();
get_footer();
?>