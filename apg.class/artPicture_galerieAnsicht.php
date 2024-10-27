<?php
/**
 * ArtPicture Plugin PHP Class
 * http://art-pictureDesign.de/WP-ArtTheme-Galerie
 * Copyright 2017, Jens Wiecker
 * https://art-picturedesign.de
 *
 */
if ( ! defined( 'ABSPATH' ) ) exit;
require_once(dirname(__DIR__).'/apg.class/db/class_db_handle.php');
require_once(dirname(__DIR__).'/apg.class/ApgSettings.php');
require_once 'Paginator.class.php';
use  APG\ArtPictureGallery\Paginator as Paginator;
use  APG\ArtPictureGallery\DbHandle as DbHandle;
use  APG\ArtPictureGallery\ApgSettings as ApgSettings;
add_action('the_content','galerie_ansicht');
function galerie_ansicht( $content ){
	if( get_post_type() != 'gallery') return $content;
    //INIT
	$custom = get_post_custom (get_the_ID());
    $galerieName  = ( isset( $custom['_select'])      && is_string( $custom['_select'][0]))      ?(string)htmlspecialchars(trim($custom['_select'][0]))  : '';
    $galerieTyp   = ( isset( $custom['_typ'] )        && is_numeric( $custom['_typ'][0]))        ?(int)htmlspecialchars(trim($custom['_typ'][0]))        : '';
    $galerieRow   = ( isset( $custom['_row'] )        && is_numeric( $custom['_row'][0]))        ?(int)htmlspecialchars(trim($custom['_row'][0]))        : '';
    $galeriePage  = ( isset( $custom['_page'])        && is_numeric( $custom['_page'][0]))       ?(int)htmlspecialchars(trim($custom['_page'][0]))       : '';
    $Description  = ( isset( $custom['_description']) && is_numeric( $custom['_description'][0]))?(int)htmlspecialchars(trim($custom['_description'][0])): '';
    $Tags         = ( isset( $custom['_tags'])        && is_numeric( $custom['_tags'][0]))       ?(int)htmlspecialchars(trim($custom['_tags'][0]))       : '';
    $Header       = ( isset( $custom['_header'])      && is_numeric( $custom['_header'][0]))     ?(int)htmlspecialchars(trim($custom['_header'][0]))     : '';
    $Format       = ( isset( $custom['_format'])      && is_numeric( $custom['_format'][0]))     ?(int)htmlspecialchars(trim($custom['_format'][0]))     : '';
    $Content      = ( isset( $custom['_content'])     && is_numeric( $custom['_content'][0]))    ?(int)htmlspecialchars(trim($custom['_content'][0]))    : '';
    $Maps         = ( isset( $custom['_maps'])        && is_string( $custom['_maps'][0]))        ?(string)htmlspecialchars(trim($custom['_maps'][0]))    : '';
    $Adresse      = ( isset( $custom['_adresse'])     && is_string( $custom['_adresse'][0]))     ?(string)htmlspecialchars(trim($custom['_adresse'][0])) : '';
    $MapsAktiv    = ( isset( $custom['_mapsAktiv'])   && is_numeric( $custom['_mapsAktiv'][0]))  ?(int)htmlspecialchars(trim($custom['_mapsAktiv'][0]))  : ''; 
     $a1 = array("method" =>"read_wp_db",
                "table"  =>"art_galerie",
                "select" =>"*",
                "where"  =>" where galerie_name = %s",
                "search" =>$galerieName );
    $usr = new DbHandle($a1);
    $data=$usr->return;
    $abfrageImg = array("method" =>"read_wp_db",
                        "table"  =>"art_images",
                        "select" =>"*",
                        "where"  =>" where galerie_name = %s ORDER BY DESC",
                        "search" =>$galerieName);
    $dat = new DbHandle($abfrageImg);
    $image = $dat->return;
  $template_footer ='<body onload=" var $grid = $(\'#grids\').masonry({
                        itemSelector: \'#grid-items\',
                        percentPosition: true,
                        columnWidth: \'#grid-sizers\'
                        });
                        $grid.imagesLoaded().progress( function() {
                        $grid.masonry();
                        })" ';

    $search = '?'; 
    $GalerieTag = get_permalink(get_page_by_title('gallery')); 
    $pos = strpos($GalerieTag,$search);
    if($pos === false){
    $posGalerie = '?';   
    }else{
    $posGalerie = '&';   
    }
    $galerieID =  get_permalink(get_page_by_title('gallery'));
    $settings = ApgSettings::load_settings('user_settings');
     function wp_galerie_assets($typ)
    {
        switch($typ)
        {
            case'footer_scripts':
           $temp = '';
            break;
            case'header_scripts':
           $temp ='';
            break;
        }
        return $temp;
   }
   function FileSizeConvert($bytes)
    {

       $bytes = floatval($bytes);
        $arBytes = array(
            0 => array("UNIT" => "TB", "VALUE" => pow(1024, 4)),
            1 => array("UNIT" => "GB", "VALUE" => pow(1024, 3)),
            2 => array("UNIT" => "MB", "VALUE" => pow(1024, 2)),
            3 => array("UNIT" => "KB", "VALUE" => 1024),
            4 => array("UNIT" => "B", "VALUE" => 1),
            );
            foreach ($arBytes as $arItem) {
            if ($bytes >= $arItem["VALUE"]){
                $result = $bytes / $arItem["VALUE"];
                $result = str_replace(".", ",", strval(round($result, 2))) . " " . $arItem["UNIT"];
                break;
            }
          }
        return $result;
    }
    function galerie_basename($name)
    {
        $datei = $name;
        $dateiarray = explode(".", $datei);
        $endung = "." . $dateiarray[count($dateiarray) - 1];
        return basename($datei, $endung);
    } //END basename                                     
    //ENDE INIT
       switch($galerieRow)
       {
        case'1':
        $reihe = 33.333;
        break;
        case'2':
        $reihe = 25 ;
        break;
        case'3':
        $reihe = 20;
        break;
        case'4':
        $reihe = 16.666 ;
        break;
        default:  //
        $reihe = 33.333;
        break;
       }
       switch($galeriePage)
       {
        case'1':
        $seite = 10;
        break;
        case'2':
        $seite = 25;
        break;
        case'3':
        $seite = 35;
        break;
        case'4':
        $seite = 50;
        break;
        case'5':
        $seite = 'all';
        break;
        default:  //
        $seite = 25;
        break;
       }
       switch($Format)
       {
        case'1':
        $pagClass = 'pagination pagination-sm';
        break;
        case'2':
        $pagClass = 'pagination';
        break;
        case'3':
        $pagClass = 'pagination pagination-lg';
        break;
        default:
        $pagClass = 'pagination pagination-sm';
        break;
       }
       if(!empty($Header)){
        global $user_info;
        $user_info = get_userdata(get_current_user_id());   
        $date = new DateTime($ata['data'][0]['created_at']); 
        $datum = $date->format('d.m.Y');                     
        $title = '<hr class="hr-light"><b style="font-size:14px;color:#777;>&nbsp;&nbsp;><hr class="hr-light">
                                      <h4 class="prem"><span class="fa fa-camera"></span>&nbsp;Gallery :<b class="grey">&nbsp;'.$galerieName.'</b></h4>      
                                     <b class="prem"><b>&nbsp;&nbsp;Created on:</b> <b class="grey">'
                                     .$datum.'</b><br><b class="prem">&nbsp;&nbsp;from:</b><b class="grey"> '. $user_info->user_nicename . $tags. '</b></span><hr class="hr-light">' ;
       }
      if(!empty($data['data'][0]->tags)&& !empty($Tags)){
      $a = explode(",",$data['data'][0]->tags);
      $tags_head = '<b class="prem">&nbsp;&nbsp;Tags: </b>';
      foreach($a as $b){
       $tags_body .= '<a class="warn" role="button" href="'.$searchID.$posSearch.'search='.$b.'">'. $b.'</a>, ';
      }
      $galerieTags = $tags_head . $tags_body.'<br>'; 
      }  
        if(!empty($data['data'][0]->beschreibung) && !empty($Description)){
        $galerie_beschreibung = '<div style="color:#666; width: 100%;"><b class="prem">&nbsp;&nbsp;Gallery Description:</b><br>
                                &nbsp;&nbsp;'.$data['data'][0]->beschreibung.'</div><hr class="hr-light">';
        }
       $limit = $seite;
       $page       = ( isset( $_GET['pagpage'] ) && is_numeric($_GET['pagpage']) ) ? (int)htmlspecialchars(trim($_GET['pagpage'])) : (int) 1;
       $links      = ( isset( $_GET['links'] ) && is_numeric($_GET['links']) ) ? (int)htmlspecialchars(trim($_GET['links'])) : (int) 4;
       $Paginator  = new Paginator( $galerieName,$limit,$galerieTyp,$page,$galerieID,$posGalerie);
       if($seite == 'all'){
        $results    = $Paginator->getAll();
       }else{
        $results    = $Paginator->getData();
       }
       switch($galerieTyp)
       {
        case'1':
           if($seite =='all'){
            $pagination = '<br>';
           }else{ 
           $pagination = '<br>'.$Paginator->createLinks( $links, $pagClass);
           }     
            $template ='<div id="grids"><div id="grid-sizers"style="width:'.$reihe.'%;" ></div> ';
            for( $i = 0; $i < count( $results->data ); $i++ ) {
            if(empty($settings['wp_settings_img_details'])){
                $btn = '<a data-gallery="" title="'.$results->data[$i]->name.'" href = "'.$results->data[$i]->url.'" target="_blank">
                           <div id="grid-items" style="width:'.$reihe.'%;"><img src="'.$results->data[$i]->thumbnailUrl.'" /></div></a>';
            }else{
                $btn ='<a href = "?apg-user-gallery-template=12067114&id='.$results->data[$i]->id.'">
                           <div id="grid-items" style="width:'.$reihe.'%;"><img src="'.$results->data[$i]->thumbnailUrl.'" /></div></a>';
            }    
            $template .= $btn;
            }
            $template .='</div>'.$template_footer;
            $template = preg_replace(array('/<!--(.*)-->/Uis',"/[[:blank:]]+/"),array('',' '),str_replace(array("\n","\r","\t"),'',$template));
            break;
      case'2':
           if($seite =='all'){
           $pagination = '<br>';
           }else{ 
           $pagination = '<br>'.$Paginator->createLinks( $links, $pagClass);
           }  
            //INIT
            $template =' <div id="grids"><div id="grids-sizer"></div> ';
            for( $i = 0; $i < count( $results->data ); $i++ ) {
           $date = new DateTime($results->data[$i]->created_at); 
                        $datum = $date->format('d.m.Y'); 
                        if(empty($results->data[$i]->last_update)){
                        $datum2 = 'unknown';    
                        }else{
                        $date2 = new DateTime($results->data[$i]->last_update); 
                        $datum2 = $date2->format('d.m.Y');    
                        }
                        if(empty($results->data[$i]->beschreibung) ? $beschreibung = 'No description available...' : $beschreibung = $results->data[$i]->beschreibung );
                        if(!empty($beschreibung)){
                            $beschreibung = substr($beschreibung,0,110);
                        }
                        if(strlen($beschreibung) > 100 ? $bn = '...' : $bn = '' );
                        if(strlen($results->data[$i]->galerie_name) > 12 ? $gn = '...' : $gn = '');
                        if(strlen($results->data[$i]->name) > 12 ? $n = '...' : $n = '');
                        $name = substr($results->data[$i]->name,0,12).$n;
                        $galerie_name = substr($results->data[$i]->galerie_name,0,12).$gn;
                        
                        if(empty($settings['wp_settings_img_details'])){
                         $btn ='';    
                        }else{
                        $btn = '<p class="text-center"><a class="btn btn-primary btn-outline btn-sm " role="button" href="?apg-user-gallery-template=12067114&id='.$results->data[$i]->id.'">
                               <span class="fa fa-search"></span> details</a></p>';
                        }
             $template .= '
                         <div id="grids-item">
                         <div class="thumbnail type2">
                         <hr class="hr-light">
                         <strong class="prem type2-header"style="font-size:12px;"> Gallery: <span class="grey">'.$galerie_name.'</span></strong><br>
                         <strong class="prem type2-header"style="font-size:12px;"> Name : <span class="grey">'.$name.'</span></strong><br>
                         <hr class="hr-light">
                        <br />                
                        <a data-gallery=""  href="'.htmlspecialchars(trim($results->data[$i]->url)).'"title="'.htmlspecialchars(trim($results->data[$i]->name)).'" target="_blank">
                        <img src="'.htmlspecialchars(trim($results->data[$i]->thumbnailUrl)).'" id="thumb'.$results->data[$i]->id.'" alt="'.$results->data[$i]->name.'"width="180" height="180"/></a>
                        <div class="caption">
                        <b class="type2-header" style="color:grey;font-size:12px;">Description:</b>
                        <hr class="hr-light">
                        <div class="user-response">
                        <span class="grey"style="font-size:12px;">'.$beschreibung.$bn.'</span>
                        </div>
                        '.$btn.'
                        <hr class="hr-light">
                        </div>
                        </div></div>';                    
             }//for  
             $template .='<br><br><br>';   
             $template .=apg_bluemGallery_select();             
             $template .=wp_galerie_assets('header_scripts'). '</div>'.$template_footer.wp_galerie_assets('footer_scripts');
             $template = preg_replace(array('/<!--(.*)-->/Uis',"/[[:blank:]]+/"),array('',' '),str_replace(array("\n","\r","\t"),'',$template));                 
        break;
        case'3':
             if($seite =='all'){
             $pagination = '<br>';
             }else{ 
             $pagination = '<br>'.$Paginator->createLinks( $links, $pagClass);
             }
            $template =wp_galerie_assets('header_scripts').
                   '<div class="table-responsive">
                   <table class="table-details table table-striped">
	        	   <thead> <tr>
                   <th width=1><h4>Show</h4></th>
                   <th ><h4 style="padding-left:4px;">Details</h4></th>
                   <th width=130><h4>image</h4></th>
                   <th width=90><h4>Gallery</h4></th>
                   <th><h4>Description</h4></th>
                   <th><h4>Tags</h4></th>
                   <th><h4>Date</h4></th>
                   </tr> </thead><tbody>';
                    for( $i = 0; $i < count( $results->data ); $i++ ) {
                    $name = substr(galerie_basename($results->data[$i]->name), 0, 15).$n;    
                    $name_size = $name .'<br/><b class="prem">'.FileSizeConvert($results->data[$i]->size).'</b>';
                    $date  = new DateTime($results->data[$i]->created_at); 
                    $datum = $date->format('d.m.Y').'<br/>'.$date->format('h:i:s');     
                    $galerie_name = substr($results->data[$i]->galerie_name,0,20).$gn;
                     if(empty($results->data[$i]->beschreibung)){
                     $beschreibung = '<b class="dan"><span class="fa fa-times"></span> no</b>';   
                    }else{
                     $beschreibung = '<b class="suss"><span class="fa fa-check"></span> yes</b>'; 
                    }
                    if(empty($results->data[$i]->tags)){
                      $tags = '<b class="dan"><span class="fa fa-times"></span> no</b>';
                    }else{
                      $tags = '<b class="suss"><span class="fa fa-check"></span> yes</b>';;
                    }
                    $template  .=
                    '<tr class = "strip'.$results->data[$i]->id.'"><td>
                   <a data-gallery="" href="'.htmlspecialchars(trim($results->data[$i]->url)).'"title="'.htmlspecialchars(trim($results->data[$i]->name)).' target="_blank">
                   <img src="'.htmlspecialchars(trim($results->data[$i]->thumbnailUrl)).'" id="thumb'.$results->data[$i]->id.'" alt="'.$results->data[$i]->name.'"width="90" height="90"/></a>
                   </td><td>
                   <div class="btn-group"style="padding-top: 3px;">
                   <a class="btn btn-primary btn-outline btn-circle btn-sm" role="button" href="?apg-user-gallery-template=12067114&id='.$results->data[$i]->id.'">
                   <p style="margin-top:3px; " class=" fa fa-eye"></p></a>
                   </div></td>
                   <td><strong>'.trim($name_size).'</strong><br />
                   </td>
                   <td><strong>'.$galerie_name.'</strong>
                   </td>
                   <td>
                    '.$beschreibung.'
                   </td>
                   <td>
                   '.$tags.'
                   </td>
                    <td>
                   <strong>'.$datum.'
                   </td>
                   </tr>';
            }//for
            $template .=apg_bluemGallery_select();        
            $template .= '</tbody></table></div><br/>'.wp_galerie_assets('footer_scripts');
            $template = preg_replace(array('/<!--(.*)-->/Uis',"/[[:blank:]]+/"),array('',' '),str_replace(array("\n","\r","\t"),'',$template));        
        break;
        default:  //
        $typ = 'wp_galerie_grid';
        break;
       }
    if($Content == '1'){
     return  $content .'<div class="bootstrap-wrapper">'. $title.stripslashes($galerie_beschreibung) . $galerieTags .$pagination . stripcslashes($template).$pagination.'</div>';  
    }
	if($Content = '2'){
	 return  '<div class="bootstrap-wrapper">'. $title.stripslashes($galerie_beschreibung) . $galerieTags .$pagination . stripcslashes($template).$pagination.'</div><br>'.$content ;    
	}
}
?>