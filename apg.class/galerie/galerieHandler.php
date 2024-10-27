<?php
/**
 * ArtPicture Plugin PHP Class
 * http://art-pictureDesign.de/WP-ArtTheme-Galerie
 * @Copyright 2017, Jens Wiecker
 * https://art-picturedesign.de
 *
 */
namespace APG\ArtPictureGallery;
if ( ! defined( 'ABSPATH' ) ) exit;
require_once (dirname(__DIR__ ) . '/ApgCore.php');
require_once (dirname(__DIR__ ) . '/db/class_db_handle.php');
require_once (dirname(__DIR__ ) . '/ApgSettings.php');
require_once (dirname(__DIR__ ) . '/db/settings-remote.php');
use  APG\ArtPictureGallery\Settings as Settings;
use  APG\ArtPictureGallery\ApgSettings as ApgSettings;
use  APG\ArtPictureGallery\DbHandle as DbHandle;
use  APG\ArtPictureGallery\Core as Core;
class GalerieHandler extends Core
{
    protected $options;
    protected $_limit;
    protected $_page;
    protected $_total;
    protected $_links;
    protected $TableName;
    protected $where;
    protected $type;
    protected $_search;
    protected $messages;
    protected $seite;
    public function __construct($options = null){ 
            $this->settings = ApgSettings::load_settings('user_settings');
            $this->tt = ApgSettings::load_settings('tooltip');    
            $this->options = array(
            "_limit"    =>$this->settings['start-select'],
            "_page"     => 1,
            "_total"    => null,
            "_links"    => 4,
            "select_limit" => $settings['start_limit']
            );
        $search = '?'; 
        $details = get_permalink(get_page_by_title('apgalerie-image-details')); 
        $pos = strpos($details,$search);
        if($pos === false){
         $this->pos = '?';   
        }else{
         $this->pos = '&';   
        }
        $this->detailsID =  get_permalink(get_page_by_title('apgalerie-image-details'));
        $this->searchID =   get_permalink(get_page_by_title('apgalerie-image-search'));
                       $a1 = array("method"   =>"user_wp_freigabe_start");
        $usr = new DbHandle($a1);
        $this->dataFreigaben=$usr->return;
        
    }
    protected function get_galerie()
  {
        if($this->type == 'wp_galerie_grid' || $this->type == 'wp_galerie_details' || $this->type == 'wp_galerie_liste'){
          $this->pagination = $this->createWordPressLinks($this->options['_links']); 
        }else{
        $this->pagination = $this->createLinks($this->options['_links']);
        }
        global $wpdb;
        $table_name = $wpdb->prefix . $this->TableName;
      
        $row = $wpdb->get_results( $wpdb->prepare(
        "SELECT *
        FROM  ".$table_name." 
        where ".$this->where." = %s LIMIT %d , %d ", 
        $this->_search,
       ($this->_page - 1) * $this->_limit,
        $this->_limit  ));
        return $this->create_galerie($row);
  }
    protected function getCount(){
        global $wpdb;
        $table_name = $wpdb->prefix . $this->TableName;
        
        $galCount = $wpdb->get_results( $wpdb->prepare( 
	   "SELECT * 
		FROM  $table_name 
		WHERE $this->where = %s", 
	   $this->_search
       ) );
        $count = count($galCount);

        //PRO-USER
        if( $this->type == 'user_galerie_typ2'  && empty($this->settings['license_aktiv'])){
            $all=10;
           $this->options['_limit'] =10; 
        }elseif($this->type == 'user_galerie_typ1'  && empty($this->settings['license_aktiv'])){
           $all=10;
           $this->options['_limit'] =10;     
        }elseif($this->type == 'user_galerie_typ3'  && empty($this->settings['license_aktiv'])){
           $all=10;
           $this->options['_limit'] =10;     
        }else{
            $all=$count;
        }
          //PRO-USER
        return $all;
    } //END getCount
    
    protected function createLinks(){
        if($this->settings['pag_aktiv'] != '1'){
            return $html='';
        }
        if($this->type ==  'galerieLoad'){
           $this->_limit =  $this->options['_limit'];   
      }
       if($this->type == 'galerieLoadDetails'){
           $this->_limit =  $this->options['_limit'];   
      }
        $last = ceil($this->_total / $this->_limit);
        $start = (($this->_page - $this->_links) > 0) ? $this->_page - $this->_links : 1;
        $end = (($this->_page + $this->_links) < $last) ? $this->_page + $this->_links : $last;
       // $html = '<ul class="pagination ' . $this->settings['pag-class-select'] . '">';
        $html = '<ul class="pagination pagination-sm">';
        $class = ($this->_page == 1) ? "disabled" : "";
        $y = $this->_page - 1;
        //load_user_galerie_typ
        if($class == 'disabled'){
                $html .= '<li class="' . $class . '"><a  role="button">&larr;<strong> back</strong> </a></li>'; //LINK
        }else{
                 $html .= '<li class="' . $class . '"><a  role="button" onclick="load_galerie_pag(\'' . $y . '\',\''.$this->type.'\',\''.$this->_search.'\');">&larr;<strong> ack</strong> </a></li>'; //LINK   
        }
        if ($start > 1){
            $html .= '<li><a role="button" href="'.$send.'">1</a></li>';
            $html .= '<li class="disabled"><span>...</span></li>';
        }
        for ($i = $start; $i <= $end; $i++){
            $class = ($this->_page == $i) ? "active" : "";
            $html .= '<li class="' . $class . '"><a role="button" onclick="load_galerie_pag(\'' . $i . '\',\''.$this->type.'\',\''.$this->_search.'\');">' . $i . '</a></li>';
        }
        if ($end < $last){
            $html .= '<li class="disabled"><span>...</span></li>';
            $html .= '<li><a role="button" disabled="disabled">' . $last . '</a></li>';
        }
        $class = ($this->_page == $last) ? "disabled" : "";
        $x = $this->_page + 1;
        if($class == 'disabled'){
                $html .= '<li class="' . $class . '"><a role="button" ><strong>next &rarr;</strong></a></li>';     
        }else{
               $html .= '<li class="' . $class . '"><a role="button" onclick="load_galerie_pag(\'' . $x . '\',\''.$this->type.'\',\''.$this->_search.'\');"><strong>next &rarr;</strong></a></li>';     
        }
       $html .= '</ul>';
       $html .= "<input id=\"last\" type='hidden'value=' $last 'name='last'>";
       $html = preg_replace(array('/<!--(.*)-->/Uis', "/[[:blank:]]+/"), array('', ' '), str_replace(array("\n","\r","\t"), '', $html));
     return $html;
    } //END createLinks
protected function createWordPressLinks(){
        if($this->settings['pag_aktiv'] != '1'){
        return $html='';
        }
        $last = ceil($this->_total / $this->_limit);
        $start = (($this->_page - $this->_links) > 0) ? $this->_page - $this->_links : 1;
        $end = (($this->_page + $this->_links) < $last) ? $this->_page + $this->_links : $last;
        $html = '<ul class="pagination ' . $this->settings['pag-class-select'] . '">';
        $class = ($this->_page == 1) ? "disabled" : "";
        $y = $this->_page - 1;
        if($class == 'disabled'){
        //load_user_galerie_typ
        $html .= '<li class="' . $class . '"><a  role="button"href="">&larr;<strong> back</strong> </a></li>'; //LINK           //load_user_galerie_typ
        }else{
        //load_user_galerie_typ
        $html .= '<li class="' . $class . '"><a  role="button"href="#spring_galerie" onclick="load_user_galerie_typ(\'' . $y . '\',\''.$this->type.'\',\''.$this->_search.'\');">&larr;<strong> back</strong> </a></li>'; //LINK    
        }
        if ($start > 1){
            $html .= '<li><a role="button" href="#spring_galerie" onclick="load_user_galerie_typ(\'1\',\''.$this->type.'\',\''.$this->_search.'\');">1</a></li>';
            $html .= '<li class="disabled"><span>...</span></li>';
        }
        for ($i = $start; $i <= $end; $i++){
            $class = ($this->_page == $i) ? "active" : "";
            $html .= '<li class="' . $class . '"><a role="button" href="#spring_galerie" onclick="load_user_galerie_typ(\'' . $i . '\',\''.$this->type.'\',\''.$this->_search.'\');">' . $i . '</a></li>';
        }
        if ($end < $last){
            $html .= '<li class="disabled"><span>...</span></li>';
            $html .= '<li><a role="button"href="#spring_galerie" disabled="disabled">' . $last . '</a></li>';
        }
        $class = ($this->_page == $last) ? "disabled" : "";
        $x = $this->_page + 1;
        if($class == 'disabled'){
                  $html .= '<li class="' . $class . '"><a role="button" href="#"><strong>next &rarr;</strong></a></li>';  
        }else{
                 $html .= '<li class="' . $class . '"><a role="button" href="#spring_galerie" onclick="load_user_galerie_typ(\'' . $x . '\',\''.$this->type.'\',\''.$this->_search.'\');"><strong>next &rarr;</strong></a></li>';   
        }
        $this->last = $last;
        $html .= "<input id=\"last\" type='hidden'value=' $last 'name='last'>";
        $html = preg_replace(array('/<!--(.*)-->/Uis', "/[[:blank:]]+/"), array('', ' '), str_replace(array("\n","\r","\t"), '', $html));
        return $html;
} //END createLinks
protected function create_galerie($data){
     $files=array(); 
     $x = 0;
    foreach ($data as $row){
        if(strlen($row->galerie_name) > $this->settings['_galerie_name_kurz'] ? $gn = '...' : $gn = '');
        if(strlen($row->name)         > $this->settings['_img_name_kurz']     ? $n  = '...' : $n = '');
        $date                       = new \DateTime($row->created_at); 
        $this->datum                = $date->format('d.m.Y').'<br/>'.$date->format('h:i:s'); 
        $this->name                 = substr($this->basename($row->name), 0, $this->settings['_img_name_kurz']).$n;
        $this->name_size            = $this->name .'<br/><b class="prem">'.$this->FileSizeConvert($row->size).'</b>';
        $this->img_basename         = htmlspecialchars(trim($this->basename($row->name)));
        $this->galerie_name_kurz    = substr(trim( $row->galerie_name),0,$this->settings["_galerie_name_kurz"]).$gn; 
        $this->beschr_kurz          = htmlspecialchars(trim(substr($row->beschreibung, 0, $this->settings['_galerie_start_beschreibung_kurz'])));    
        if($this->type == 'galerieLoad'){
        $temp_body .= $this->set_galerie_grid($row,"body");
        }elseif($this->type == 'galerieLoadDetails'){
        $temp_body .= $this->set_galerie_details($row,"body");
        }elseif($this->type == 'user_galerie_typ1'){
        $temp_body .= $this->user_galerie_typ1($row,"body");
        }elseif($this->type == 'user_galerie_typ2'){
        $temp_body .= $this->user_galerie_typ2($row,"body");
        }elseif($this->type == 'user_galerie_typ3'){
        $temp_body .= $this->user_galerie_typ3($row,"body");
       }elseif($this->type == 'wp_galerie_grid'){
        $temp_body .= $this->wp_galerie_grid($row,"body");
       }elseif($this->type == 'wp_galerie_details'){
        $temp_body .= $this->wp_galerie_details($row,"body");
       }elseif($this->type == 'wp_galerie_liste'){
        $temp_body .= $this->wp_galerie_liste($row,"body");
       }else{
        return false;    
        }
        $x++;
    }
       if($this->type == 'galerieLoad'){
        $template = $this->set_galerie_grid("","header") . $temp_body . $this->set_galerie_grid("","footer")  ;
       }elseif($this->type == 'galerieLoadDetails'){
        $template = $this->set_galerie_details("","header") . $temp_body . $this->set_galerie_details("","footer")  ;
       }elseif($this->type == 'user_galerie_typ1'){
        $template = $this->user_galerie_typ1("","header") . $temp_body . $this->user_galerie_typ1("","footer")  ;
       }elseif($this->type == 'user_galerie_typ2'){
        $template = $this->user_galerie_typ2("","header") . $temp_body . $this->user_galerie_typ2("","footer");
       }elseif($this->type == 'user_galerie_typ3'){
        $template = $this->user_galerie_typ3("","header") . $temp_body . $this->user_galerie_typ3("","footer")  ;
       }elseif($this->type == 'wp_galerie_grid'){
        $template = $this->wp_galerie_grid("","header") . $temp_body . $this->wp_galerie_grid("","footer")  ;
       }elseif($this->type == 'wp_galerie_details'){
        $template = $this->wp_galerie_details("","header") . $temp_body . $this->wp_galerie_details("","footer")  ;
       }elseif($this->type == 'wp_galerie_liste'){
        $template = $this->wp_galerie_liste("","header") . $temp_body . $this->wp_galerie_liste("","footer")  ;
       }else{
        return false;
      }
    $files["total"]                     = trim($this->_total);
    $files["page"]                      = trim($this->_page);
    $files["last"]                      = trim($this->last);
    $files["limit"]                     = trim($this->_limit);
    $files["pagination"]                = trim($this->pagination);
    $files['template']                  = $template;
    return $files;
 }
protected function create_galerie_2(){
    if($this->type == 'galerieLoad'){
    $template = $this->type;
     }
    $files=array(); 
    $files["total"]                     = trim($this->_total);
    $files["page"]                      = trim($this->_page);
    $files["last"]                      = trim($this->last);
    $files["limit"]                     = trim($this->_limit);
    $files["pagination"]                = trim($this->pagination);
    $files['template']                  = $template;
    return $files;
        
}
protected function set_galerie_grid($row,$template_type){
         switch ($template_type)
        {
         case 'header':
               $return ='<div class="grid"><div class="grid-sizer"></div>';
               break;
         case 'body':
                 $date = new \DateTime($row->created_at);
                 if(strlen($row->name) > $this->settings['_img_name_kurz'] ? $n  = '...' : $n = ''); 
                 $datum  = $date->format('d.m.Y');
                 if(empty($row->tags) ? $ta='nein' : $ta = 'ja');
                 if(empty($row->beschreibung) ? $ba='nein' : $ba = 'ja');
                 $size = $this->FileSizeConvert($row->size);
               $return ='<div class=" col-md-3 col-sm-3 col-xs-3 grid-item portfolio-item ">
                        <input type = "hidden" name="limit'.$row->id.'"value ="'.$this->_limit.'" >
                        <input type = "hidden" name="page'.$row->id.'"value ="'.$this->_page.'" >
                        <div class="view efffect">
                        <div class="portfolio-image">
                        <img src="'.htmlspecialchars(trim($row->thumbnailUrl)).'"class="img-responsive" id="thumb'.$row->id.'" alt="'.$row->name.'">
                        </div>
                        <div class="mask hidden-xs text-left">
                        <b class="prem">'.substr($this->basename($row->name), 0, $this->settings['_img_name_kurz']).$n.'<b/><br/>
                      <b class="prem"><span class="fa fa-file-image-o"></span></b>&nbsp;<strong class="warn">'.$row->id.'</strong><br/>
                      <b class="prem"><span class="fa fa-expand"></span></b>&nbsp;<strong class="warn">'.$size.'</strong><br/>
                      <b class="prem"><span class="fa fa-calendar-o"></span></b>&nbsp;<strong class="warn">'.$datum.'</strong><br/>
                      <b class="prem"><span class="fa fa-tags"></span></b>&nbsp;<strong class="warn">'.$ta.'</strong><br/>
                      <b class="prem"><span class="fa fa-edit"></span></b>&nbsp;<strong class="warn">'.$ba.'</strong><br/>
                      
                        <div style="margin-top:5px;margin-left:10px;">
                        <a  role="button" data-toggle="modal"data-target="#GalerieModal"data-whatever="'.$row->id.'_load_edit_img_modal+galerie">
                        <i class="warn fa fa-edit"></i></a>
                        
                        <a  role="button" data-toggle="modal"data-target="#GalerieModal"data-whatever="'.$row->id.'_load_delete_img_modal+galerie">
                        <i class="warn fa fa-trash"></i></a>
                        <a data-gallery="" "title="'.$this->name.'" href="'.htmlspecialchars(trim($row->url)).'" ><i class="warn fa fa-search-plus"></i></a>
                        </div></div><!--hidden-xs-->
                        <div class="mask btn-group visible-xs-block"style="padding-top: 85px;padding-left:25px;">
                        <button type="button" id="edit_btn" class="btn btn-warning btn-outline btn-circle btn-sm"
                        data-toggle="modal"data-target="#GalerieModal"data-whatever="'.$row->id.'_load_edit_img_modal+galerie" >
                        <p style="margin-top:3px; "class="fa fa-edit"></p></button>
                        <button type="button" id="edit_btn" class="btn btn-danger btn-outline btn-circle btn-sm"
                        data-toggle="modal"data-target="#GalerieModal"data-whatever="'.$row->id.'_load_delete_img_modal+galerie">
                        <p style="margin-top:3px; "class="fa fa-trash"></p></button>
                        <a class="btn btn-primary btn-outline btn-circle btn-sm" role="button" href="'.htmlspecialchars(trim($row->url)).'"
                        data-gallery="details1" "title="'.htmlspecialchars(trim($this->basename($row->name))).'">
                        <p style="margin-top:3px; " class=" fa fa-eye"></p></a>
                        </div><div class="clearfix visible-xs-block"></div>
                        </div></div>';
                      $return = preg_replace(array('/<!--(.*)-->/Uis', "/[[:blank:]]+/"), array('', ' '), str_replace(array("\n","\r","\t"), '', $return));     
               break;
         case 'footer':
                $return = '</div>';
               break;
     }
              return $return;
}
 protected function set_galerie_details($row,$template_type){
            switch ($template_type)
            {
             case 'header':
                    $return ='<div class="table-responsive">
                   <table class="table-details table table-striped">
	        	   <thead> <tr>
                   <th width=1><h4>File</h4></th>
                   <th ><h4 style="padding-left:4px;">Edit</h4></th>
                   <th width=130><h4>image</h4></th>
                   <th width=90><h4>Gallery Name</h4></th>
                   <th><h4>GPS</h4></th>
                   <th><h4>Exif Details</h4></th>
                   <th><h4>release</h4></th>
                   <th><h4>Message</h4></th>  
                   <th><h4>Date</h4></th>
                   <th><h4>delete</h4></th>
                   </tr> </thead><tbody>';
                   $return = preg_replace(array('/<!--(.*)-->/Uis', "/[[:blank:]]+/"), array('', ' '), str_replace(array("\n","\r","\t"), '', $return));
                   break;
             case 'body': 
                    $return  =
                    '<tr class = "strip'.$row->id.'"><td>
                    <input type = "hidden" name="limit'.$row->id.'"value ="'.$this->_limit.'" > 
                    <input type = "hidden" name="page'.$row->id.'"value ="'.$this->_page.'" >
                   <a data-gallery="details" href="'.htmlspecialchars(trim($row->url)).'"title="'.htmlspecialchars(trim($this->basename($row->name))).'">
                   <img src="'.htmlspecialchars(trim($row->thumbnailUrl)).'" id="thumb'.$row->id.'" alt="'.$row->name.'"width="45" height="45"/></a>
                   </td><td>
                   <div class="btn-group"style="padding-top: 3px;">
                   <button type="button" id="edit_btn" class="btn btn-warning btn-outline btn-circle btn-sm"
                   data-toggle="modal"data-target="#GalerieModal"data-whatever="'.$row->id.'_load_edit_img_modal+galerie" >
                   <p style="margin-top:3px; "class="fa fa-edit"></p></button>
                   <a class="btn btn-primary btn-outline btn-circle btn-sm" role="button" href="'.htmlspecialchars(trim($row->url)).'"
                   data-gallery="details1" "title="'.htmlspecialchars(trim($this->basename($row->name))).'">
                   <p style="margin-top:3px; " class=" fa fa-eye"></p></a>
                   </div></td>
                   <td><strong>'.trim($this->name_size).'</strong><br />
                   </td>
                   <td><strong>'.$this->galerie_name_kurz.'</strong>
                   </td>
                   <td>
                   '.self::set_details_button(array("method"=>"gps","data"=>$row)).'
                   </td>
                   <td>
                   '.self::set_details_button(array("method"=>"exif","data"=>$row)).'
                   </td>
                   <td>
                   '.self::set_details_button(array("method"=>"freigaben","data"=>$row)).'
                   </td>
                   <td>
                   '.self::set_details_button(array("method"=>"posts","data"=>$row)).'
                   </td>
                   <td>
                   <strong>'.$this->datum.'
                   </td>
                   <td class="text-center">
                   <a  role="button" class="btn btn-danger btn-outline btn-circle btn-sm"
                   data-toggle="modal"data-target="#GalerieModal"data-whatever="'.$row->id.'_load_delete_img_modal+galerieLoadDetails">
                   <p style="margin-top:3px; " class="fa fa-trash-o"></p></a></td></tr>';
                   $return = preg_replace(array('/<!--(.*)-->/Uis', "/[[:blank:]]+/"), array('', ' '), str_replace(array("\n","\r","\t"), '', $return));
                   break;
             case 'footer':     
                   $return = '</tbody></table></div><br/>';
                  break;
            }
                  return $return;           
  }
protected function user_galerie_typ2($row,$template_type){
       $tt = $this->tt;
        switch ($template_type)
        {
            case 'header':
                        $return ='<div class="grid"><div class="grid-sizer"></div>';
                        break;
            case'body':
                        $date = new \DateTime($row->created_at); 
                        $datum = $date->format('d.m.Y'); 
                        if(empty($row->last_update)){
                        $datum2 = 'unbekannt';    
                        }else{
                        $date2 = new \DateTime($row->last_update); 
                        $datum2 = $date2->format('d.m.Y');    
                        }
                        if(empty($row->beschreibung) ? $beschreibung = 'No description available...' : $beschreibung = $row->beschreibung );
                        if(!empty($beschreibung)){
                            $beschreibung = substr($beschreibung,0,110);
                        }
                        if(strlen($beschreibung) > 100 ? $bn = '...' : $bn = '' );
                        if(strlen($row->galerie_name) > 18 ? $gn = '...' : $gn = '');
                        if(strlen($row->name) > 18 ? $n = '...' : $n = '');
                        $name = substr($row->name,0,18).$n;
                        $galerie_name = substr($row->galerie_name,0,18).$gn;
                        $return .= '
                       <input type = "hidden" name="limit'.$row->id.'"value ="'.$this->_limit.'" >
                       <input type = "hidden" name="page'.$row->id.'"value ="'.$this->_page.'" >
                       <div class="col-lg-3 col-md-4 col-sm-4">
                       <div class="thumbnail type2">
                         <hr class="hr-light">
                         <strong class="warn type2-header"> Gallery: <span class="grey">'.$galerie_name.'</span></strong><br>
                         <strong class="warn type2-header"> Name : <span class="grey">'.$name.'</span></strong><br>
                         <strong class="warn type2-header"> ID : <span class="grey">'.$row->id.'</span></strong>
                         <hr class="hr-light">
                        <br />                
                        <a data-gallery="details" href="'.htmlspecialchars(trim($row->url)).'"title="'.htmlspecialchars(trim($this->basename($row->name))).'">
                        <img src="'.htmlspecialchars(trim($row->thumbnailUrl)).'" id="thumb'.$row->id.'" alt="'.$row->name.'"width="180" height="180"/></a>
                        <div class="caption">
                        <b class="type2-header" style="color:grey">Description:</b>
                        <hr class="hr-light">
                        <div class="user-response">
                        '.$beschreibung.$bn.'
                        </div>
                        <hr class="hr-light">
                        <b class="prem type2-header">Select</b><b class="grey"> picture:</b>
                        <br>
                        <span class="type2-header">
                        '.self::set_details_button(array("method"=>"auswahl","data"=>$row)).'
                        </span><br>
                        <hr class="hr-light">
                         <br>
                       <div class="text-center">
                         <div class="btn-group ">
                         '.self::set_details_button(array("method"=>"gps-user","data"=>$row)).'
                         '.self::set_details_button(array("method"=>"exif-user","data"=>$row)).'
                         '.self::set_details_button(array("method"=>"kommentar","data"=>$row)).'
                         </div>
                         </div>
                        </div>
                        </div>
                        </div>';
                       break;
            case'footer':
                       $return .='</div>';
                       break;
            }
    $template = preg_replace(array('/<!--(.*)-->/Uis', "/[[:blank:]]+/"), array('', ' '), str_replace(array("\n","\r","\t"), '', $template));  
     return $return;               
    }
 protected function user_galerie_typ1($row,$template_type){
            switch ($template_type)
            {
             case 'header':
                  $return ='<div class="table-responsive">
                   <table class="table-details table table-striped">
	        	   <thead> <tr>
                   <th>
                   <div class="usr-details"><span class="prem fa fa-photo"></span> Image</div>
                   </th>
                   <th >
                   <div class="usr-details">Beschr.
                   <a class="wptool" data-toggle="tooltip" title="'.$this->tt['tt_user_beschreibung'].'">
                   <span class="prem fa fa-question-circle"></span></a></div>
                   </th>
                   <th width=130>
                   <div class="usr-details">Name</div>
                   </th>
                   <th width=90>
                   <div class="usr-details">Gallery</div>
                   </th>
                   <th>
                   <div class="usr-details">GPS
                   <a class="wptool" data-toggle="tooltip" title="'.$this->tt['tt_user_gps'].'">
                   <span class="prem fa fa-question-circle"></span></a></div>
                   </th>
                   <th>
                   <div class="usr-details">Exif
                   <a class="wptool" data-toggle="tooltip" title="'.$this->tt['tt_user_exif'].'">
                   <span class="prem fa fa-question-circle"></span></a></div>
                   </th>
                   <th><div class="usr-details">Comment
                   <a class="wptool" data-toggle="tooltip" title="'.$this->tt['tt_user_kommentar'].'">
                   <span class="prem fa fa-question-circle"></span></a></div>
                   </th>  
                   <th>
                   <div class="usr-details">wählen
                   <a class="wptool" data-toggle="tooltip" title="'.$this->tt['tt_user_waehlen'].'">
                   <span class="prem fa fa-question-circle"></span></a></div>
                   </th>
                   <th>
                   <div class="usr-details">Date
                   <a class="wptool" data-toggle="tooltip" title="'.$this->tt['tt_user_datum'].'">
                   <span class="prem fa fa-question-circle"></span></a></div>
                   </th>
                   </tr> </thead><tbody>';
                   $return = preg_replace(array('/<!--(.*)-->/Uis', "/[[:blank:]]+/"), array('', ' '), str_replace(array("\n","\r","\t"), '', $return));
                   break;
             case 'body':
                  $exif = self::set_details_button(array("method"=>"exif","data"=>$row));
                  $gps  = self::set_details_button(array("method"=>"gps","data"=>$row));
                  $freigaben  = self::set_details_button(array("method"=>"freigaben","data"=>$row));
                  $post = self::set_details_button(array("method"=>"posts","data"=>$row));           
                  $return  =
                   '<tr class = "strip'.$row->id.'"><td>
                   <input type = "hidden" name="limit'.$row->id.'"value ="'.$this->_limit.'" > 
                   <input type = "hidden" name="page'.$row->id.'"value ="'.$this->_page.'" >
                   <a data-gallery="details" href="'.htmlspecialchars(trim($row->url)).'"title="'.htmlspecialchars(trim($this->basename($row->name))).'">
                   <img src="'.htmlspecialchars(trim($row->thumbnailUrl)).'" id="thumb'.$row->id.'" alt="'.$row->name.'"width="85" height="85"/></a>
                   </td>
                   <td style="padding-top:35px;">
                   '.$post = self::set_details_button(array("method"=>"image_beschreibung","data"=>$row)).'
                   </div></td>
                   <td style="padding-top:35px;"><strong>'.trim($this->name_size).'</strong><br />
                   </td>
                   <td style="padding-top:35px;"><strong>'.$this->galerie_name_kurz.'</strong>
                   </td>
                   <td style="padding-top:35px;">
                   '.self::set_details_button(array("method"=>"gps-user","data"=>$row)).'
                   </td>
                   <td style="padding-top:35px;">
                   '.self::set_details_button(array("method"=>"exif-user","data"=>$row)).'
                   </td>
                   <td style="padding-top:35px;">
                    '.self::set_details_button(array("method"=>"kommentar","data"=>$row)).'
                   </td>
                   <td style="padding-top:35px;">
                  '.self::set_details_button(array("method"=>"auswahl","data"=>$row)).'
                   </td>
                   <td style="padding-top:35px;">
                   <strong>'.$this->datum.'
                   </td>
                   </tr>';
                   $return = preg_replace(array('/<!--(.*)-->/Uis', "/[[:blank:]]+/"), array('', ' '), str_replace(array("\n","\r","\t"), '', $return));
                   break;
             case 'footer':     
                   $return = '</tbody></table></div><br/>';
                   break;
            }
                  return $return;           
  }

protected function user_galerie_typ3($row,$template_type){
         switch ($template_type)
        {
         case 'header':
               $return ='<div class="grid">';
               break;
         case 'body':
                 if(empty($row->beschreibung)){
                    $beschreibung = '<b class="dan"><u>no description</u> <span class="fa fa-thumbs-o-down"></span></b>';
                 }else{
                    $beschreibung = '<a role="button"data-toggle="modal"data-target="#GalerieModal"data-whatever=" '.$row->id.'_load_image_beschreibung+modal">
                                     <b class="suss"><u>description</u> <span class="fa fa-thumbs-o-up"></span></b></a>';
                 }   

             $return = '<div class=" col-md-2 col-sm-3 col-xs-6 grid-item portfolio-item ">
                        <input type = "hidden" name="limit'.$row->id.'"value ="'.$this->_limit.'" >
                        <input type = "hidden" name="page'.$row->id.'"value ="'.$this->_page.'" >
                        <div class="view efffect">
                        <div class="portfolio-image">
                        <img src="'.htmlspecialchars(trim($row->thumbnailUrl)).'"class="img-responsive" id="thumb'.$row->id.'" alt="'.$row->name.'">
                        </div>
                        <div class="mask">
                        <div class="text-center">
                        <b class="prem">wählen</b>  <br>                     
                        '.self::set_details_button(array("method"=>"auswahl","data"=>$row)).'
                        <br>
                        '.$beschreibung.'
                        <div class="btn-group">
                        '.self::set_details_button(array("method"=>"image_show","data"=>$row)).'
                        '.self::set_details_button(array("method"=>"kommentar","data"=>$row)).'
                        </div>
                        <div class="btn-group">
                        '.self::set_details_button(array("method"=>"exif-user","data"=>$row)).'
                        '.self::set_details_button(array("method"=>"gps-user","data"=>$row)).'
                        </div>
                        </div></div>
                        </div></div>';
                       $return = preg_replace(array('/<!--(.*)-->/Uis', "/[[:blank:]]+/"), array('', ' '), str_replace(array("\n","\r","\t"), '', $return));     
               break;
         case 'footer':
                $return = '</div>';
               break;
     }
              return $return;
  }
    protected function user_Wordpress_grid($row,$template_type){
         switch ($template_type)
            {
         case 'header':
               $return ='<div class="grid"><div class="grid-sizer"></div>';
               break;
         case 'body':
                 if(empty($row->beschreibung)){
                    $beschreibung = '<b class="dan"><u>no description</u> <span class="fa fa-thumbs-o-down"></span></b>';
                 }else{
                    $beschreibung = '<a role="button"data-toggle="modal"data-target="#GalerieModal"data-whatever=" '.$row->id.'_load_image_beschreibung+modal">
                                     <b class="suss"><u>description</u> <span class="fa fa-thumbs-o-up"></span></b></a>';
                 }   
             $return = '<div class=" col-md-6 col-sm-6 col-xs-6 grid-item portfolio-item ">
                        <input type = "hidden" name="limit'.$row->id.'"value ="'.$this->_limit.'" >
                        <input type = "hidden" name="page'.$row->id.'"value ="'.$this->_page.'" >
                        <div class="view efffect">
                        <div class="portfolio-image">
                        <img src="'.htmlspecialchars(trim($row->thumbnailUrl)).'"class="img-responsive" id="thumb'.$row->id.'" alt="'.$row->name.'">
                        </div>
                        <div class="mask">
                        <div class="text-center">
                        <b class="prem">wählen</b>  <br>                     
                        '.self::set_details_button(array("method"=>"auswahl","data"=>$row)).'
                        <br>
                        '.$beschreibung.'
                        <div class="btn-group">
                        '.self::set_details_button(array("method"=>"image_show","data"=>$row)).'
                        '.self::set_details_button(array("method"=>"kommentar","data"=>$row)).'
                        </div>
                        <div class="btn-group">
                        '.self::set_details_button(array("method"=>"exif-user","data"=>$row)).'
                        '.self::set_details_button(array("method"=>"gps-user","data"=>$row)).'
                        </div>
                        </div></div>
                        </div></div>';
                      //  $return = preg_replace(array('/<!--(.*)-->/Uis', "/[[:blank:]]+/"), array('', ' '), str_replace(array("\n","\r","\t"), '', $return));     
               break;
         case 'footer':
                $return = '</div>';
               break;
     }
              return $return;
  }
  protected function wp_galerie_details($row,$template_type){
        $tt = Settings::load_settings('tooltip', false); 
        switch ($template_type)
        {
            case 'header':
                        $return ='<div class="grid"><div class="grid-sizer"></div>';
                        break;
            case'body':
                        $date = new \DateTime($row->created_at); 
                        $datum = $date->format('d.m.Y'); 
                        if(empty($row->last_update)){
                        $datum2 = 'unknown';    
                        }else{
                        $date2 = new \DateTime($row->last_update); 
                        $datum2 = $date2->format('d.m.Y');    
                        }
                        if(empty($row->beschreibung) ? $beschreibung = 'No description available...' : $beschreibung = $row->beschreibung );
                        if(!empty($beschreibung)){
                            $beschreibung = substr($beschreibung,0,110);
                        }
                        if(strlen($beschreibung) > 100 ? $bn = '...' : $bn = '' );
                        if(strlen($row->galerie_name) > 15 ? $gn = '...' : $gn = '');
                        if(strlen($row->name) > 15 ? $n = '...' : $n = '');
                        $name = substr($row->name,0,15).$n;
                        $galerie_name = substr($row->galerie_name,0,15).$gn;
                        $detailsUrl = substr(admin_url(),0,strpos(admin_url(),'wp-admin'));
                        $btn = '<p class="text-center"><a class="btn btn-primary btn-outline btn-sm " role="button" href="'.$this->detailsID.$this->pos.'id='.$row->id.'">
                                <span class="fa fa-search"></span> details</a></p>';
                        $return .= '
                       <input type = "hidden" name="limit'.$row->id.'"value ="'.$this->_limit.'" >
                       <input type = "hidden" name="page'.$row->id.'"value ="'.$this->_page.'" >
                       <div class="col-sm-6 col-md-4">
                       <div class="thumbnail type2">
                       <hr class="hr-light">
                         <strong class="prem type2-header"> Gallery: <span class="grey">'.$galerie_name.'</span></strong><br>
                         <strong class="prem type2-header"> Name : <span class="grey">'.$name.'</span></strong><br>
                         <hr class="hr-light">
                        <br />                
                        <a data-gallery="details" href="'.htmlspecialchars(trim($row->url)).'"title="'.htmlspecialchars(trim($this->basename($row->name))).'">
                        <img src="'.htmlspecialchars(trim($row->thumbnailUrl)).'" id="thumb'.$row->id.'" alt="'.$row->name.'"width="180" height="180"/></a>
                        <div class="caption">
                        <b class="type2-header" style="color:grey">Description:</b>
                        <hr class="hr-light">
                        <div class="user-response">
                        <span class="grey">'.$beschreibung.$bn.'</span>
                        </div>
                        '.$btn.'
                        <hr class="hr-light">
                        </div>
                        </div>
                        </div>';
                       break;
            case'footer':
                       $return .='</div>';
                       break;
            }
          $return = preg_replace(array('/<!--(.*)-->/Uis', "/[[:blank:]]+/"), array('', ' '), str_replace(array("\n","\r","\t"), '', $return));  
     return $return;               
    }
protected function wp_galerie_liste($row,$template_type){
              switch ($template_type)
            {
             case 'header':
                    $return ='<div class="table-responsive">
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
                   $return = preg_replace(array('/<!--(.*)-->/Uis', "/[[:blank:]]+/"), array('', ' '), str_replace(array("\n","\r","\t"), '', $return));
                   break;
             case 'body': 
                    $galerie_name = substr($row['galerie_name'],0,20).$gn;
                    $detailsUrl = substr(admin_url(),0,strpos(admin_url(),'wp-admin'));
                    if(empty($row['beschreibung'])){
                     $beschreibung = '<b class="dan"><span class="fa fa-times"></span> no</b>';   
                    }else{
                        $beschreibung = '<b class="suss"><span class="fa fa-check"></span> yes</b>'; 
                    }
                    if(empty($row->tags)){
                        $tags = '<b class="dan"><span class="fa fa-times"></span> no</b>';
                    }else{
                        $tags = '<b class="suss"><span class="fa fa-check"></span> yes</b>';;
                    }
                    $return  =
                    '<tr class = "strip'.$row->id.'"><td>
                    <input type = "hidden" name="limit'.$row->id.'"value ="'.$this->_limit.'" > 
                    <input type = "hidden" name="page'.$row->id.'"value ="'.$this->_page.'" >
                   
                   <a data-gallery="" href="'.htmlspecialchars(trim($row->url)).'"title="'.htmlspecialchars(trim($this->basename($row->name))).'">
                   <img src="'.htmlspecialchars(trim($row->thumbnailUrl)).'" id="thumb'.$row->id.'" alt="'.$row->name.'"width="90" height="90"/></a>
                   </td><td>
                   <div class="btn-group"style="padding-top: 3px;">
                   
                   <a class="btn btn-primary btn-outline btn-circle btn-sm" role="button" href="'.$this->detailsID.$this->pos.'id='.$row->id.'">
                   <p style="margin-top:3px; " class=" fa fa-eye"></p></a>
                   </div></td>
                   <td><strong>'.trim($this->name_size).'</strong><br />
                   </td>
                   <td><strong>'.$this->galerie_name_kurz.'</strong>
                   </td>
                   <td>
                    '.$beschreibung.'
                   </td>
                   <td>
                   '.$tags.'
                   </td>
                    <td>
                   <strong>'.$this->datum.'
                   </td>
                   </tr>';
                   $return = preg_replace(array('/<!--(.*)-->/Uis', "/[[:blank:]]+/"), array('', ' '), str_replace(array("\n","\r","\t"), '', $return));
                   break;
             case 'footer':     
                   $return = '</tbody></table></div><br/>';
                  break;
            }
                  return $return;           
  }
protected function wp_galerie_grid($row,$template_type){
         switch ($template_type)
            {
         case 'header':
               $return ='<div class="grid"><div class="grid-sizer"></div>';
               break;
         case 'body':
         $imgName = $this->basename($row->name);
         if(strlen($imgName)  > 20 ? $gn = '...' : $gn = '');
            $name = substr($imgName,0,20).$gn;
             $return = '       <style>
                               .galerie-item img {
                                display: block;
                                border: 3px solid #ddd;
                                width: 100%;
                                }
                                </style>
                        <div class=" col-md-'.$this->seite.' col-sm-'.$this->seite.' col-xs-'.$this->seite.  ' galerie-item portfolio-item ">
                        <input type = "hidden" name="limit'.$row->id.'"value ="'.$this->_limit.'" >
                        <input type = "hidden" name="page'.$row->id.'"value ="'.$this->_page.'" >
                        <div class="view efffect">
                        <div class="portfolio-image">
                        <img src="'.htmlspecialchars(trim($row->thumbnailUrl)).'"class="img-responsive" id="thumb'.$row->id.'" alt="'.$row->name.'">
                        </div>
                        <div class="mask">
                        <b class="grey">'.$name.'</b>
                        <p class="grey hidden-xs hidden-sm "style="margin-bottom:5px;"></p>
                        <b class="grey"hidden-xs hidden-sm>Show</b>
                        <div class="text-center"style="border: 1px solid #ddd;">
                        <span class="hidden-xs hidden-sm"><br></span>
                        <p>'.self::set_details_button(array("method"=>"image_show_wp_grid","data"=>$row)).
                          self::set_details_button(array("method"=>"image_show_wp_grid_details","data"=>$row)).'
                        </p>
                        </div></div>
                        </div></div>';
                      $return = preg_replace(array('/<!--(.*)-->/Uis', "/[[:blank:]]+/"), array('', ' '), str_replace(array("\n","\r","\t"), '', $return));     
               break;
         case 'footer':
                $return = '</div>';
               break;
     }
              return $return;
 }  
protected function set_details_button($data){
        $userSettings = self::user_galerie_settings($data['data']->galerie_name);
        $badge_user_status = ' badge-suss';
        $btn_user_status   = ' btn-success';
        $badge_status      = ' badge-suss';
        $btn_status        = ' btn-success';
        $disabled          = '';
        $typ               = '';
   
        switch ($data['method'])
        {
        case 'gps':
               $exifData = unserialize($data['data']->exif);
               $grad = parent::gps_map_extract($exifData);
               $GPSLatGrad  = $grad['GPSLatGrad'];
               $GPSLongGrad = $grad['GPSLongGrad'];
               $typ             = 'GPS'; 
               $icon             = 'glyphicon glyphicon-map-marker'; 
               $modal            = '#exifDetailsModal"data-whatever=" '.$data['data']->id.'_load_gps_modal+loadGps"'; 
                if ($exifData['GPSLatitudeRef'] == '0'){
                $badge_status   = ' badge-dan';
                $btn_status     = 'btn-danger';
                $disabled       = ' disabled="disabled"';
                $modal          = '#exifDetailsModal"data-whatever=""';
                }
                break;
        case 'exif':
             $exifData = unserialize($data['data']->exif);
             $typ             = 'EXIF'; 
             $icon            = 'fa fa-camera'; 
             $modal           = '#exifDetailsModal"data-whatever=" '.$data['data']->id.'_load_exif_modal+galerie"';
                if ($exifData['count'] == 0){
                $badge_status = ' badge-dan';
                $btn_status   = 'btn-danger';
                $disabled     = ' disabled="disabled"';
                $modal        = '#exifDetailsModal"data-whatever=""';
             }
             if($exifData['count'] > 1 && $exifData['count'] < 10) {
                $badge_status = ' badge-warn';
                $btn_status   = 'btn-warning'; 
             }
             
            break;    
        case 'freigaben':
             $icon            = 'icon-fa icon-fa-cu-user';
             $modal           = '#GalerieModal"data-whatever=" start_FreigabenModal+galerie "';
            $frei =  $this->dataFreigaben;
       
            foreach($frei['data'] as $tmp)
            {
            $f[] = $tmp->galerie_name;
            }
            if(!empty($f))
            {
            $freigaben = array_filter(array_unique(array_values($f)));   
            if(in_array($data['data']->galerie_name,$freigaben))
            {
             $badge_status = ' badge-suss';
             $btn_status   = ' btn-success';
             $disabled     = '';
             $href        =  'admin.php?page=art-Picture-reponse';   
            }else{
             $badge_status = ' badge-dan';
             $btn_status   = ' btn-danger';
             $disabled     = ' disabled="disabled"';
             $href        =   ''; 
            }
            }else{
             $badge_status = ' badge-dan';
             $btn_status   = ' btn-danger';
             $disabled     = ' disabled="disabled"';
             $href        =   '';     
            }
            $button = '<a role="button" type="button" class="btn '.$btn_status.' btn-outline badge-details "' .$badge_status.' ' .$disabled.'
                       href="'.$href.'">
                       <span style="margin-top:3px; " class=" ' .$icon.'" ></span><b>'.$typ.'</b></a>';
            return $button;           
            break;
        case 'posts':
             $icon = 'icon-fa icon-fa-cu-posts';
                    
                if(empty ($data['data']->post_id)){
                $badge_status = ' badge-dan';
                $btn_status   = 'btn-danger';
                $disabled     = ' disabled="disabled"';
              }
              $btn='<button type="button" class="btn '.$btn_status.' btn-outline badge-details "onclick="load_post_msg_modal(\''.$data['data']->id.'\');"' .$badge_status.' ' .$disabled.' >
                    <span style="margin-top:3px; " class=" ' .$icon.'" ></span><b>'.$typ.'</b></button>'; 
            return $btn; 
            break;
        case 'auswahl':
               if(empty($userSettings['auswahl'])){
               $typ             = 'NO'; 
               $icon            = 'fa fa-comments-o'; 
               $modal           = '';
               $badge_status    = 'badge-disabled';
               $btn_status      = 'btn-default';
               $disabled        = ' disabled="disabled"';
               $modal           = '';      
               }else{
               $checked = self::checked($data['data']->id,$_SESSION['id']);                 
               $auswahl = '<label class="switch">                                                                
                        <input type="checkbox" onclick="checkedAuswahl(\''.$data['data']->id.'_'.$_SESSION['id'].'+check\');"
                        '.$checked.'> 
                        <span class="slider round"></span>
                        </label>'; 
              return $auswahl;
             }
            break;
         case 'kommentar':
               @session_start();   
              if(empty($_SESSION['id'])){
                return false;
              }
             if(empty($userSettings['kommentar'])){
               $typ             = 'NO'; 
               $icon            = 'fa fa-comments-o'; 
               $modal           = '';
               $badge_status    = 'badge-disabled';
               $btn_status      = 'btn-default';
               $disabled        = ' disabled="disabled"';
               $modal           = '';      
                }else{
               session_start(); 
               $a2 = array("method" =>  "user_wp_freigabe_auswahl",
                                "data"   =>  array("htaccess_id"=>$_SESSION['id'],
                                                   "galerie_name"=>$data['data']->galerie_name));

            $dat2 = new DbHandle($a2);
            $data2=$dat2->return;
            $db_message = unserialize($data2['data'][0]->message);
           
            for ($x = 0; $x <= count($db_message); $x++) {  
             $id  = substr($db_message[$x],0,strpos($db_message[$x],'_'));
             $msg = substr($db_message[$x],strpos($db_message[$x],'_')+1);
             if($id == $data['data']->id){
            $iconColor = 'warn';
            }
           }    
               $icon            =  $iconColor. ' fa fa-comments-o';
               $modal           = '#GalerieModal"data-whatever=" '.$data['data']->id.'_LoadUserKommentar+kommentar "';
            }
            break;
         case 'image_show':
             $btn          =   '<a class="btn btn-outline btn-primary badge-details" role="button" href="'.htmlspecialchars(trim($data['data']->url)).'"
                                data-gallery="details1" "title="'.htmlspecialchars(trim($data['data']->name)).'"><span class="fa fa-eye"></span></a>';
             return $btn;                
             break;
        case 'image_show_wp_grid':
                 $btn ='<a class="btn btn-primary btn-outline btn-circle btn-sm" role="button" href="'.htmlspecialchars(trim($data['data']->url)).'"data-gallery="" "title="'.htmlspecialchars(trim($data['data']->name)).'">
                        <span style="margin-top:3px; " class="fa fa-eye"></span></a>';
             return $btn;                
             break;
        case 'image_show_wp_grid_details':
             $btn ='<a class="btn btn-warning btn-outline btn-circle btn-sm" role="button"
                    href="'.$this->detailsID.$this->pos.'id='.$data['data']->id.'">
                    <span style="margin-top:3px; " class="fa fa-search"></span>'.$test.'</a>';
             return $btn;                
             break;
         case 'image_beschreibung':
               @session_start();   
              if(empty($_SESSION['id'])){
                return false;
              }
                if (!empty($data['data']->beschreibung)){
                $icon             = 'suss fa fa-flag-o';
                $typ             = ' YES';
                $badge_status     = 'badge-warning';
                $btn_status       = 'btn-warning'; 
                $modal            = '#GalerieModal"data-whatever=" '.$data['data']->id.'_load_image_beschreibung+modal"';     
                }else{
                $badge_status     = 'badge-disabled';
                $typ              = '<span class="fa fa-flag-o"> NO';
                $icon             = 'fa fa-flag-o';
                $btn_status       = 'btn-danger';
                $disabled         = ' disabled="disabled"';
                $modal           = '#GalerieModal"data-whatever=" ';
                }
              break;     
         case 'gps-user':
               @session_start();   
              if(empty($_SESSION['id'])){
                return false;
              }
               if(empty($userSettings['gps'])|| empty($this->settings['license_aktiv'])){
               $typ             = 'GPS'; 
               $icon            = 'glyphicon glyphicon-map-marker'; 
               $badge_status    = 'badge-disabled';
               $btn_status      = 'btn-default';
               $disabled        = ' disabled="disabled"';
               $modal           = '';      
                }else{
               $exifData = unserialize($data['data']->exif);
               $grad = parent::gps_map_extract($exifData);
               $GPSLatGrad  = $grad['GPSLatGrad'];
               $GPSLongGrad = $grad['GPSLongGrad'];
               $typ             = 'GPS'; 
               $icon             = 'glyphicon glyphicon-map-marker'; 
               $modal            = '#exifDetailsModal"data-whatever=" '.$data['data']->id.'_load_gps_modal+loadGps"';
    
                if ($exifData['GPSLatitudeRef'] == '0'){
                $badge_status   = ' badge-dan';
                $btn_status     = 'btn-danger';
                $disabled       = ' disabled="disabled"';
                $modal          = '#exifDetailsModal"data-whatever=" ';
                }
                }
                break;
       case 'exif-user':
               @session_start();   
              if(empty($_SESSION['id'])){
                return false;
              }
                if(empty($this->settings['license_aktiv'])) {

             }
              if(empty($userSettings['exif']) || empty($this->settings['license_aktiv'])){
               $typ             = 'Exif'; 
               $icon            = 'fa fa-camera'; 
               $modal           = '';
               $badge_status    = 'badge-disabled';
               $btn_status      = 'btn-default';
               $disabled        = ' disabled="disabled"';
               $modal           = '';      
                }else{  
             $exifData = unserialize($data['data']->exif);
             $typ             = 'EXIF'; 
             $icon            = 'fa fa-camera'; 
             $modal           = '#exifDetailsModal"data-whatever=" '.$data['data']->id.'_load_exif_modal+galerie"';
                if ($exifData['count'] == 0){
                $badge_status = ' badge-dan';
                $btn_status   = 'btn-danger';
                $disabled     = ' disabled="disabled"';
                $modal        = '#exifDetailsModal"data-whatever=""';
             }
             if($exifData['count'] > 1 && $exifData['count'] < 10) {
                $badge_status = ' badge-warn';
                $btn_status   = 'btn-warning'; 
             }
             }
            break; 
        }
       $btn    = '<button type="button" class="btn '.$btn_status.' btn-outline badge-details "' .$badge_status.' ' .$disabled.'
                  data-toggle="modal"data-target="'.$modal.'>
                 <span style="margin-top:3px; " class=" ' .$icon.'" ></span><b>'.$typ.'</b></button>';
                 $btn = preg_replace(array('/<!--(.*)-->/Uis', "/[[:blank:]]+/"), array('', ' '), str_replace(array("\n","\r","\t"), '', $btn));
       return $btn;
 }
 private static function checked($image_id,$htaccess_id){
               @session_start();   
              if(empty($_SESSION['id'])){
                return false;
              }              
    $a1 = array("method"   =>"read_wp_db",
                "table"    =>"art_images",
                "select"   =>"galerie_name",
                "where"    => " where id = %d",
                "search"   => $image_id);
    $dat1 = new DbHandle($a1);
    $data1=$dat1->return;
    $a2 = array("method"    =>"read_wp_db",
                "table"    =>"art_galerie",
                "select"   =>"id",
                "where"    =>" where galerie_name = %s",
                "search"   =>$data1['data'][0]->galerie_name);
    $dat2= new DbHandle($a2);
    $data2=$dat2->return;
    $a3 = array("method"    =>"freigabe_wp_id",
                "table"    =>"art_freigaben",
                "select"   =>"*",
                "data"     => array("htaccess_id"=>$htaccess_id,"galerie_id"=>$data2['data'][0]->id),
                "session"  =>false);
    $dat3 = new DbHandle($a3);
    $data3=$dat3->return;
    if(empty($data3['count'])){
    return;
    }
    $dbImg = unserialize($data3['data'][0]->select_image);
    if(empty($dbImg)){
    return;
    }
    if(in_array($image_id,$dbImg)){
    $checked = 'checked';
    }else{
    $checked = '';
    }
    return  $checked;
 }
private static function user_galerie_settings($galerie) {
        session_start();
       $abfrage = array("method"=>"user_wp_freigabe_auswahl",
                        "data"  =>array("htaccess_id"=>$_SESSION['id'],"galerie_name"=>$galerie)
                );
        $a = new DbHandle($abfrage);
        $b = $a->return;
        $settings = unserialize($b['data'][0]->settings);
        if(empty($settings['gps'])){
        $gps = false;
        }else{
        $gps = true; 
        }
        if(empty($settings['exif'])){
         $exif = false;   
        }else{
          $exif = true;  
        }
        if(empty($settings['kommentar'])){
         $kommentar = false;   
        }else{
          $kommentar = true;  
        }
        if(empty($settings['auswahl'])){
        $auswahl = false;   
        }else{
          $auswahl = true;  
        }
        $return = array("gps" =>$gps,
                        "exif"=>$exif,
                        "kommentar"=>$kommentar,
                        "auswahl"=>$auswahl);
        return $return; 
 }
} //END class
?>