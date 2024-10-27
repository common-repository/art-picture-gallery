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
use  APG\ArtPictureGallery\Core as Core;
use  APG\ArtPictureGallery\ApgSettings as ApgSettings;
use  APG\ArtPictureGallery\DbHandle as DbHandle;
use  APG\ArtPictureGallery\SiteTemplates as SiteTemplates;

class ModalHandler extends Core
{
    public function __construct($method){
          $this->method = $method;   
    }
    public function execute(){
        
        $status = false;
        $result = false;
        $error_msg = null;
        $rturn = false;
        $method = $this->method;
        $res = parent::extract_method($method);
                     
    switch ($res['method'])
    
    {
        case 'load_responsives_template':
            $no_imag ='';
            $body = $this->galerie_startseite(array("typ"=>"body"));
            $co = array("method"   =>  "count");
            $rga = new DbHandle($co);
            $count = $rga->return;
            $select = $this->load_galerie_select($select);
            $responseJson    = new \stdClass();
            if($count['galerie'] == 0){
                $no_image = parent::response('12');
                $message = $no_image['response_msg'];
            }
            if($res['typ'] == 'start'){
                $no_image = parent::response('17');
                $message = $no_image['response_msg'];
            }
            if($res['id'] <= 768){
            $header = self::responsive_header(array("methode"=>'header_sm',
                                                     "count_img"=>$count['images'],
                                                     "count_gal"=>$count['galerie'],
                                                     "galerie_freigaben"=>$count['galerie_freigaben'],
                                                     "count_posts"=>$count['post_id'],
                                                     "count_message"=>$count['count_message'],
                                                      ));
            $responseJson->header       = $header;
            $responseJson->btn          = $btn;
            $responseJson->body         = $body;
            $responseJson->canvas       = false;
            $responseJson->select       = $select['select'];
            $responseJson->no_image     = $message;
            return  $responseJson;
           }else{
            if($load_btn="btn" ? $btn = $this->create_galerie_button(array("methode"=>'startGalerie_lg',"count_img"=>$count['images'],"count_gal"=>$count['galerie'])) : $btn = "");
            $header = self::responsive_header(array("methode"=>'header_lg',
                                                     "count_img"=>$count['images'],
                                                     "count_gal"=>$count['galerie'],
                                                     "galerie_freigaben"=>$count['galerie_freigaben'],
                                                     "count_posts"=>$count['post_id'],
                                                     "count_message"=>$count['count_message'],
                                                     ));
            $responseJson->header       = $header;
            $responseJson->btn          = $btn;
            $responseJson->header_img   = $btn;
            $responseJson->body         = $body;
            $responseJson->canvas       = false;
            $responseJson->select       = $select['select'];
            $responseJson->no_image     = $message;
            $result = $responseJson ;
           }        
            break;
           case 'count':
            $co = array("method"   =>  "count");
            $rga = new DbHandle($co);
            $count = $rga->return;
           
            $responseJson                    = new \stdClass();
            $responseJson->galerie           = $count['galerie'];
            $responseJson->image             = $count['images'];
            $responseJson->img_htaccess      = $count['img_htaccess_id'];
            $responseJson->img_post_id       = $count['post_id'];
            $responseJson->img_beschreibung  = $count['img_beschreibung'];
            $responseJson->img_tags          = $count['img_tags'];
            $responseJson->gal_beschreibung  = $count['galerie_beschreibung'];
            $responseJson->galerie_tags      = $count['galerie_tags'];
            $responseJson->galerie_htaccess  = $count['galerie_htaccess'];
            $responseJson->htaccess_user     = $count['htaccess_user'];
            $responseJson->htaccess_aktiv    = $count['htaccess_aktiv'];
            $responseJson->htaccess_freigabe = $count['htaccess_freigabe'];
            $responseJson->image_message     = $count['image_message'];
                        
            $result = $responseJson;   
           break;
     case'load_post_msg_modal':
          isset($_POST['id']) && is_numeric($_POST['id']) ? $id = esc_attr($_POST['id']) : $id = "";
            $responseJson = new \stdClass();
            if(empty($id)){
            $responseJson->status = $status;
            return $responseJson; 
            }
            $a2 = array("method"   =>"read_wp_db",
                        "table"    =>"art_images",
                        "select"   =>" *",
                        "where"    =>" where id = %d",
                        "search"   =>$id);
            $dat2 = new DbHandle($a2);
            $img=$dat2->return;
            $message = unserialize($img['data'][0]->post_id);
            foreach($message as $tmp)
            {
             $date1 = new \DateTime($tmp['time']); 
             $datum1 = $date1->format('H:i:s');   
             $d = $this->date_deutsche($tmp['time']);  
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
                                 <th class="table_msg_benutzer">Image ID</th>
                                 <th class="table_msg_name">Galerie</th>
                                 <th class="table_msg">Message</th>
                                 </tr>
                                 </thead>
                                 <tbody>
                                 <tr>
                                 <td><span class="prem fa fa-clock-o"></span> '.$datum1.'</td>
                                 <td>'.$tmp['imageID'].'</td>
                                 <td>'.$tmp['galerieName'].'</td>
                                 <td>'.$tmp['message'].'</td>
                                 </tr>
                                 <tbody>
                                 </tbody>
                                 </div><hr class="hr-light">';   
            }
            $template = preg_replace(array('/<!--(.*)-->/Uis',"/[[:blank:]]+/"),array('',' '),str_replace(array("\n","\r","\t"),'',$template));
            $responseJson->body     = $template;
            $responseJson->status   = true;
            $result = $responseJson ;
            break; 
     case'load_startseite':
       $a =self::galerie_startseite(array("typ"=>"body"));
            $responseJson = new \stdClass();
            $responseJson->template  = $a;
            $responseJson->status    = true;
            $result = $responseJson;
            break;

   case'change_select_delete':
            isset($_POST['value']) && is_string($_POST['value'])  ? $value = esc_attr($_POST['value']) : $value = "";
            $responseJson = new \stdClass();
            if(empty($value)){
            $responseJson->status   = $status;
            return $responseJson;    
            }
            $abfrage = array("method"   =>"user_wp_freigabe_select",
                             "data"     =>array("galerie_name"=>$value,
                                                "where"=>"galerie_name"));
                             
            $dat = new DbHandle($abfrage);
            $data=$dat->return;
            if(empty($data['count'])){
             $freigaben = ''; 
             $stat = false;  
            }else{
             $stat = true;   
             $freigaben = '<h4 class="grey">Freigaben : <span class=" dan fa fa-angle-double-right"></span> <b class="grey"> '.$data['count'].'</b></h4>';   
            } 

            $a2 = array("method"   =>"read_wp_db",
                        "table"    =>"art_images",
                        "select"   =>"galerie_name",
                        "where"    =>" where galerie_name = %s",
                        "search"   =>$value);
                             
            $dat2 = new DbHandle($a2);
            $img=$dat2->return;
            if(empty($img['count'])){
                $image = '';
                $stat = false;
            }else{
                $stat = true;
                $image = '<br /><h4 class="grey">Bilder : <span class="dan fa fa-angle-double-right"style="padding-left:30px;"></span><b class="grey"> '.$img['count'].'</b> </h4>';
            }
            if(empty($stat)){
              $message = '<p class="text-center"><b class="dan">alle</b> Bilder aus dieser Galerie werden gel&ouml;scht!</p>';  
            }else{
                $message = $image . $freigaben;
            }
            $responseJson->status        = true;
            $responseJson->message       = $message;
            $result =  $responseJson;
            break;
     case 'load_delete_img_modal':

            $abfrage = array("method"   =>"read_wp_db",
                             "table"    =>"art_images",
                             "select"   =>"*",
                             "where"    =>" where id = %d",
                             "search"   =>$res['id']);
            $dat = new DbHandle($abfrage);
            $data=$dat->return;
           
            $settings = ApgSettings::load_settings('user_settings');
           
            $daten = array("auswahl"        =>'delete_image',
                          'galerie_name'    =>substr(trim($data['data'][0]->galerie_name),0,$settings['_galerie_name_kurz']).'... ',
                           "name"           =>substr(trim($this->basename($data['data'][0]->name)),0,$settings['_img_name_kurz']).'...',
                           "id"             =>$res['id'],
                           "deleteUrl"      =>$data['data'][0]->deleteUrl);
           
            $deleteModal = self::modal_ids($daten);
            
            $responseJson                   = new \stdClass();
            $responseJson->header           = $deleteModal['img_header'];
            $responseJson->id               = $data['data'][0]->id;
            $responseJson->body             = $deleteModal['img_body'];
            $responseJson->btn              = $deleteModal['btn'];

            $responseJson->modalTyp         = "delete_image";
            $responseJson->bild_base        = substr(trim($this->basename($data['data'][0]->name)),0,$settings['_img_name_kurz']).'...';
            $responseJson->galerie_name     = substr($data['data'][0]->galerie_name,0,$settings['_btn_name_kurz']);
            $result = $responseJson ;
            break;
     case 'delete_image':
            isset($_POST['id']) && is_numeric($_POST['id']) ? $id = esc_attr($_POST['id']) : $id = "";
            isset($_POST['page']) && is_numeric($_POST['page']) ? $page = esc_attr($_POST['page']) : $page = ""; 
            isset($_POST['limit']) && is_numeric($_POST['limit']) ? $limit = esc_attr($_POST['limit']) : $limit = "";
            isset($_POST['galerie']) && is_string($_POST['galerie']) ? $galerie = esc_attr($_POST['galerie']) : $galerie = "";   
            
           $aufruf = array("method"=>"delete_wp_image",
                           "id"=>$id);
            $resDB = new DbHandle($aufruf);
            $response = $resDB->return;

            $abfrage = array("method"   =>  "read_wp_db",
                             "table"    =>  "art_images",
                             "select"   =>  "galerie_name",
                             "where"    =>  "  WHERE galerie_name = %s",
                             "search"   =>  $galerie );
            $dat = new DbHandle($abfrage);
            $data=$dat->return;
            $last = ceil( $data['count'] / $limit );
            if ($page > $last ){
                $page -=1;
            }

            if($data['count']===0)
            {
                $res_msg=parent::response('13');
            }
  
            $responseJson                = new \stdClass();
            $responseJson->del_response  = $response['response'];
            $responseJson->id            = $id;
            $responseJson->page          = $page;
            $responseJson->type          = $res['typ'];
            $responseJson->status        = true;
            $responseJson->limit         = $limit;
            $responseJson->error_msg     = $res_msg['response_msg'];

            $result = $responseJson;
            break;
     case 'load_edit_img_modal':

            $abfrage = array("method"   =>  "read_wp_db",
                             "table"    =>  "art_images",
                             "select"   =>  "*",
                             "where"    =>  " where id = %d",
                             "search"   =>  $res['id']);
            $dat = new DbHandle($abfrage);
            $data=$dat->return;
            $settings = ApgSettings::load_settings('user_settings');
            $daten = array("auswahl"        =>  'edit_image',
                            'galerie_name'  =>  substr(trim($data['data'][0]->galerie_name),0,$settings['_galerie_name_kurz']).'... ',
                            "name"          =>  htmlspecialchars(trim( $data['data'][0]->name)),
                            "id"            =>  $res['id']);
                            
            $editModal = self::modal_ids($daten);
            $responseJson                   = new \stdClass();
            $responseJson->header           = $editModal['img_header'];
            $responseJson->body             = $editModal['img_body'];
            $responseJson->id               = $data['data'][0]->id;
            $responseJson->tags             = trim($data['data'][0]->tags);
            $responseJson->btn              = $editModal['btn'];
            $responseJson->name             = $data['data'][0]->name;
            $responseJson->beschreibung     = substr($data['data'][0]->beschreibung,0,$settings['_galerie_start_beschreibung_kurz']);
            $responseJson->bild_base        = trim($this->basename($data['data'][0]->name));
            $responseJson->galerie_name     = trim($data['data'][0]->galerie_name);
            $result =  $responseJson ;
            break;
     case 'new_img_beschreibung':
            isset($_POST['tags']) && is_string($_POST['tags'])  ? $tags = esc_attr($_POST['tags']) : $tags = "";
            isset($_POST['beschreibung']) && is_string($_POST['beschreibung'])  ? $beschreibung = esc_attr($_POST['beschreibung']) : $beschreibung = "";
            isset($_POST['image']) && is_string($_POST['image'])  ? $image = esc_attr($_POST['image']) : $image = "";
          global $wpdb;
          $responseJson             = new \stdClass();
          $na = array("method"   =>  "read_wp_db",
                      "table"    =>  "art_images",
                      "select"   =>  "*",
                      "where"    =>  " where id = %d",
                      "search"   =>  $res['id']);
            $dat = new DbHandle($na);
            $search = $dat->return;
            if($search['data'][0]->name !== $image){
            $responseJson->status  =  false;
            return $responseJson;
            exit;  
            }
            
            $table = $wpdb->prefix . 'art_images';
            $abfrage = array("method"       =>  "update_wp_galerie_beschreibung",
                             "table"        =>  $table,
                             "id"           =>  $res['id'],
                             "beschreibung" =>  $beschreibung,
                             "tags"         =>  $tags);
            new DbHandle($abfrage);
       
            $responseJson->status  = true;
            $responseJson->id  = $res['id'];
            $result =  $responseJson;
            break;
     case 'loadNewGalerieModal':
            $editModal = self::modal_ids(array("auswahl"=>'new_galerie'));
            
            $responseJson                   = new \stdClass();
            $responseJson->header           = $editModal['img_header'];
            $responseJson->body             = $editModal['img_body'];
            $responseJson->btn              = $editModal['btn'];
            $responseJson->canvas           = false;
            $result =  $responseJson;
            break;
     case 'create_new_galerie':
            isset($_POST['name']) && is_string($_POST['name'])  ? $name = esc_attr($_POST['name']) : $name = "";
            isset($_POST['beschreibung']) && is_string($_POST['beschreibung'])  ? $beschreibung = esc_attr($_POST['beschreibung']) : $beschreibung = ""; 
            
            $responseJson = new \stdClass();
            if(empty($name)){
            $response = $this->response('6');    
            $responseJson->status     = $response['status'];
            $responseJson->error_msg  = $response['response_msg'];
            return $responseJson;
            }
            if (!preg_match('/^[a-z A-Z0-9]\_?[a-z A-Z0-9]*$/D', $name)){
            $response = $this->response('18');
            $responseJson->name       = false;    
            $responseJson->error_msg  = $response['response_msg'];
            return  $responseJson ;
            }
            if(strlen($name || strlen($beschreibung)) > 150) {
            $response = $this->response('19');
            $responseJson->name       = false;    
            $responseJson->error_msg  = $response['response_msg'];
            return $responseJson ;
            }

            $ifGalerie = array("method"   =>  "read_wp_db",
                               "table"    =>  "art_galerie",
                               "select"   =>  "*",
                               "where"    =>  " where galerie_name = %s",
                               "search"   =>  $name);
            $dat = new DbHandle($ifGalerie);
            $ifData=$dat->return;
            
            if($ifData['count'] != 0)
            {
            $response   = $this->response('15');    
            $responseJson->status     = $response['status'];
            $responseJson->error_msg  = $response['response_msg']; 
            return $responseJson ;    
            }
            $aufruf = array(
                        "method"=>"new_wp_galerie",
                        "session"=>false,
                        "name"=>$name,
                        "beschreibung"=>$beschreibung
                        );
            $res = new DbHandle($aufruf);          
            $last_id = $res->return; 
            if (empty($last_id))
            {
               $status = false;
            }else{
                $status = true;
            }

            $abfrage = array("method"   =>  "read_wp_db",
                             "table"    =>  "art_galerie",
                             "select"   =>  "*");
            $res = new DbHandle($abfrage);
            $response = $res->return;
            
            $responseJson->galerie_count  = $response['count'];
            $responseJson->last_id        = $last_id;
            $responseJson->status         = $status;
            parent::send_header();
            $result =  $responseJson ;
            break;
     case'delete_galerie_select_modal':
             $responseJson    = new \stdClass();
             $editModal = self::modal_ids(array("auswahl"=>'delete_galerie_select'));
             $responseJson->header  = $editModal['img_header'];
             $responseJson->body    = $editModal['img_body'];
             $responseJson->btn     = $editModal['btn'];
             $responseJson->canvas  = false;
             $result = $responseJson ;
           // 
            break;
      case 'DeleteGalerieModal':
                   
            isset($_POST['galeriename']) && is_string($_POST['galeriename'])  ? $galeriename = esc_attr($_POST['galeriename']) : $galeriename = "";
           $responseJson    = new \stdClass();
            if($res['typ'] !== 'galerie')
            {
            $galeriename = $res['typ'];  
            }else{       
            if(empty($galeriename)){
            $def_modal = self::default_modal();
            $responseJson->header  = $def_modal['img_header'];
            $responseJson->body    = $def_modal['img_body'];
            $responseJson->btn     = $def_modal['btn'];
            $responseJson->canvas  = false;
            return $responseJson; 
            }
            }
            $abfrage = array("method"   =>  "read_wp_db",
                             "table"    =>  "art_images",
                             "select"   =>  "*",
                             "where"    =>  " where galerie_name = %s",
                             "search"   =>  $galeriename);
           $a = new DbHandle($abfrage);  
           $data = $a->return;
           $settings = ApgSettings::load_settings('user_settings');
          if ($data['count'] == 0 ? $galerie_count = '' : $galerie_count = '<small class="dan"> ('.$data['count'].' Bilder) </small> ');
           $datum = parent::date_deutsche($data['data'][0]->created_at);
           $date= 'erstellt am '.$datum['tag_kurz'] .'. '.$datum['monat_lang'].' '.$datum['jahr'] ;
            $editModal = self::modal_ids(array("auswahl"    =>'delete_galerie',
                                               "count"      => $galerie_count,
                                               "datum"      => $date,
                                               "galerie"    => $galeriename)
                                                );
            

            $responseJson->header  = $editModal['img_header'];
            $responseJson->body    = $editModal['img_body'];
            $responseJson->btn     = $editModal['btn'];
            $responseJson->canvas  = false;
            $result = $responseJson;
            
            break;
     case 'delete_galerie':
            isset($_POST['name']) && is_string($_POST['name'])  ? $name =  esc_attr($_POST['name']) : $name = "";
            
            $responseJson    = new \stdClass();
            if(empty($name)){
            $responseJson->status = false; 
            return $responseJson;
            }   
            
            $aufruf = array(
            "method"=>'delete_wp_galerie',
            "name"=>$name
            );
            new DbHandle($aufruf);
            $co = array("method"   =>  "count",
                         "session"  =>  false );
            $rga = new DbHandle($co);
            $count = $rga->return;
      
            $responseJson->galerie_count     = $count['galerie'];
            $responseJson->image_count       = $count['images'];
            $responseJson->image_freigaben   = $count['galerie_htaccess'];
            $responseJson->image_message     = $count['image_message'];

            $result = $responseJson ;
            break;
     case 'load_edit_galerie_modal':
           
            isset($_POST['galeriename']) && is_string($_POST['galeriename'])  ? $galeriename =  esc_attr($_POST['galeriename']) : $galeriename = ""; 
            if($res['typ'] !== 'galerie'){
            $galeriename = $res['typ'];
            $details = true;
             }
             $responseJson = new \stdClass();
            if(empty($galeriename)){
            $def_modal = self::default_modal();
            $responseJson->header  = $def_modal['img_header'];
            $responseJson->body    = $def_modal['img_body'];
            $responseJson->btn     = $def_modal['btn'];
            $responseJson->canvas  = false;
            return $responseJson; 
                }
            
            $abfrage = array("method"   =>  "read_wp_db",
                             "table"    =>  "art_galerie",
                             "select"   =>  "*",
                             "where"    =>  " where galerie_name = %s",
                             "search"   =>  $galeriename);
       
            $dat = new DbHandle($abfrage);
            $data=$dat->return;
            $settings = ApgSettings::load_settings('user_settings');
            $galerie=$data['data'][0]->galerie_name;
            if(strlen($galerie) > $settings['_galerie_name_kurz']  ? $n  = '...' : $n = '');
                 
            $daten = array("auswahl"        =>  'edit_galerie',
                            'galerie_name'  =>  substr(trim( $galerie),0,$settings["_galerie_name_kurz"]).$n ,
                            "id"            =>  $data['data'][0]->id);
               
                     
            $editModal = self::modal_ids($daten);
            
            $responseJson->header           = $editModal['img_header'];
            $responseJson->body             = $editModal['img_body'];
            $responseJson->canvas           = false;
            $responseJson->details           = $details;
            $responseJson->id               = $data['data'][0]->id;
            $responseJson->tags             = trim($data['data'][0]->tags);
            $responseJson->btn              = $editModal['btn'];
            $responseJson->beschreibung     = $data['data'][0]->beschreibung;
            $responseJson->galerie_name     = substr(trim( $galerie),0,$settings["_galerie_name_kurz"]).$n ;
            $result = $responseJson;
            break;
     case 'new_galerie_beschreibung':
             isset($_POST['beschreibung']) && is_string($_POST['beschreibung'])  ? $beschreibung = esc_attr($_POST['beschreibung']) : $beschreibung = "";
             isset($_POST['tags']) && is_string($_POST['tags'])  ? $tags = esc_attr($_POST['tags']) : $tags = "";
             $details ='';
             global $wpdb;
             $responseJson    = new \stdClass();  

             $abfrage = array("method"   =>  "read_wp_db",
                             "table"    =>  "art_galerie",
                             "select"   =>  "*",
                             "where"    =>  " where id = %d",
                             "search"   =>  (int)$res['id']);
            $a = new DbHandle($abfrage);  
            $data = $a->return;
            $table = $wpdb->prefix . 'art_galerie';
            $abfrage = array("method"       =>  "update_wp_galerie_beschreibung",
                             "table"        =>  $table,
                             "id"           =>  $res['id'],
                             "beschreibung" =>  $beschreibung,
                             "tags"         =>  $tags );
            $resDB = new DbHandle($abfrage);
            $response = $resDB->return;

            $a2 = array("method"   =>  "read_wp_db",
                             "table"    =>  "art_images",
                             "select"   =>  "*",
                             "where"    =>  " where galerie_name = %s",
                             "search"   =>  $data['data'][0]->galerie_name
                             );
            $ab = new DbHandle($a2);  
            $img = $ab->return;
            foreach($img['data'] as $tmp)
            {
            $table = $wpdb->prefix . 'art_images';
            $i_upd = array("method"       =>  "update_wp_galerie_beschreibung",
                             "table"        =>  $table,
                             "id"           =>  $tmp->id,
                             "beschreibung" =>  $beschreibung,
                             "tags"         =>  $tags
                             );
            new DbHandle($i_upd);    
             }   
            if($res['typ'] === 'galerie'){
                $details = 'galerie';
            }       
           $responseJson->details = $details;
            $responseJson->id  = $res['id'];
            $result = $responseJson ;
            
            break;
     case 'load_exif_modal':
            
            isset($_POST['galerieTyp']) && is_string($_POST['galerieTyp'])  ? $galerieTyp = esc_attr($_POST['galerieTyp']) : $galerieTyp = "";
            //
            $responseJson    = new \stdClass();
          
            $abfrage = array("method"   =>  "read_wp_db",
                             "table"    =>  "art_images",
                             "select"   =>  "*",
                             "where"    =>  " where id = %d",
                             "search"   =>  $res['id']);
           $a = new DbHandle($abfrage);  
           $data = $a->return;
           if($data['count'] == '0')
           {
            $responseJson->status  = false;
            return  $responseJson;
           }
    
            $exifModal = self::modal_ids(array("auswahl"=>"exif_modal",
                                               "data"=>unserialize($data['data'][0]->exif),"db_data"=>$data['data'][0],"galerieTyp"=>$galerieTyp)) ;


            $responseJson->modal_body    = $exifModal['img_body'];
            $responseJson->id            = $data['data'][0]->id;

           $result =  $responseJson;  
            break;
     case 'load_gps_modal':
                        $responseJson    = new \stdClass();

            $abfrage = array("method"   =>  "read_wp_db",
                             "table"    =>  "art_images",
                             "select"   =>  "*",
                             "where"    =>  " where id = %d",
                             "search"   =>  $res['id']);
           $a = new DbHandle($abfrage);  
           $data = $a->return;
           $exif = unserialize($data['data'][0]->exif);
           if($exif['GPSLatitudeRef'] == '0')
           {
            $def_modal = self::default_modal();

            $responseJson->status     = false;
            $responseJson->canvas     = false;
            return  $responseJson ; 
           }
           $exifModal = self::modal_ids(array("auswahl"=>"gps_modal",
                                               "data"=>unserialize($data['data'][0]->exif),"db_data"=>$data['data'][0])) ;
           //gps_modal
            $grad = parent::gps_map_extract($exif);
            $responseJson->modal_body    = $exifModal['img_body'];
            $responseJson->id          = $data['data'][0]->id;
            $responseJson->GPSLatGrad  = $grad['GPSLatGrad'];
            $responseJson->GPSLongGrad = $grad['GPSLongGrad'];
            $responseJson->GPSAltitude = $exif['GPSAltitude'];
            $result =  $responseJson;  
            break;


     case 'create_galerie_btn':
       
           $co = array("method"   =>  "count");
            $rga = new DbHandle($co);
            $count = $rga->return;
           if($res['id'] <= 768)
           {
            return $this->create_galerie_button(array("methode"=>'startGalerie_sm',"count_img"=>$count['images'],"count_gal"=>$count['galerie']));
           }else{
            return $this->create_galerie_button(array("methode"=>'startGalerie_lg',"count_img"=>$count['images'],"count_gal"=>$count['galerie'])); 
           }
            break;
 
     case 'load_galerie_select':
           isset($_POST['select']) && is_string($_POST['select'])  ? $select = esc_attr($_POST['select']) : $select = "";
           $responseJson = new \stdClass();
        
            $af = array("method"   =>  "read_wp_db",
                       "table"    =>  "art_images",
                       "select"   =>  ' galerie_name ',
                       "where"    =>  " WHERE galerie_name = %s",
                       "search"   =>  $select,);           

           $resSelectDB = new DbHandle($af);
           $row = $resSelectDB->return;
           $response = parent::response('12');
        
           $select = $this->load_galerie_select($select,$res['typ']);
        if($select['status']== false)
          {
           $responseJson->status       = $select['status'];
           $responseJson->message      = $response['response_msg'];
           $responseJson->err_message  = "no_galerie";
           return $responseJson ;
          }    
           if($select['galerie_count'] == 0 ? $message=self::create_galerie_button(array("methode"=>'new_galerie_button_start')) : $message = '' );  
           if($select['galerie_count'] >= 0 && $row['count'] == 0 ? $message=self::create_galerie_button(array("methode"=>'new_upload_button_start')) : $message = '' );   
           if($select['status'] === true ? $message = '' : $message = $message);   
           $responseJson->img_count    = $row['count'];
           $responseJson->loaded       = $select['loaded'];
           $responseJson->type         = $res['typ'];
           $responseJson->newname      = $newname;
           $responseJson->name        = $row['data'][0]->galerie_name;
           $responseJson->status       = $select['status'];
           $responseJson->message      = $message;
           $responseJson->gal_count    = $select['galerie_count'];
           $responseJson->select       = $select['select'];
           $result = $responseJson;
           break;
  case 'load_user_galerie_select':
           isset($_POST['select']) && is_string($_POST['select'])  ? $select = esc_attr($_POST['select']) : $select = "";
            $responseJson = new \stdClass();
            if(empty($select)){
           $responseJson->status       = $status;
           $responseJson->message      = 'ein fehler ist aufgetreten!'; 
           return $responseJson;        
            }
            
           $af = array("method"   =>  "read_wp_db",
                       "table"    =>  "art_images",
                       "select"   =>  ' galerie_name ',
                       "where"    =>  " where galerie_name = %s",
                       "search"   =>  $select);     
           $resSelectDB = new DbHandle($af);
           $row = $resSelectDB->return;
           $response = parent::response('12');
           $a1 = array("method" =>"user_wp_freigabe_auswahl",
                       "data"   =>array("galerie_name"=>$select,"htaccess_id"=>$res['id']));
           $dat = new DbHandle($a1);
           $data = $dat->return; 
       
      switch ($data['data'][0]->galerie_typ)
        {
            case '1':
            $galerietyp = 'user_galerie_typ1';
            break;
            case '2':
            $galerietyp = 'user_galerie_typ2';
            break;
            
            case '3':
            $galerietyp = 'user_galerie_typ3';
            break;
        }   
           $select = $this->load_galerie_select($select,$galerietyp);
        if($select['status']== false)
          {
           $responseJson->status       = $select['status'];
           $responseJson->message      = $response['response_msg'];
           $responseJson->err_message  = "no_galerie";
           return $responseJson ;
          }    
           $responseJson->loaded       = $select['loaded'];
           $responseJson->type         = $galerietyp;
           $responseJson->name         = $row['data'][0]->galerie_name;
           $responseJson->status       = $select['status'];
           $responseJson->message      = $message;
           $result =  $responseJson ;   
       break;
     case 'load_galerie_details':
            $optionen = array("template"=>"".$res['id']."_details");
           $a = new SiteTemplates($optionen);
           $template = $a->return;
           $responseJson = new \stdClass();
           $responseJson->template= $template;
           $result = $responseJson;
           break;
     case 'load_delete_freigabe_modal':
          $responseJson = new \stdClass();

            $abfrage = array("method"   =>  "read_wp_db",
                             "table"    =>  "art_freigaben",
                             "select"   =>  "*",
                             "where"    =>  " where id = %d",
                             "search"   =>  $res['id']);
           $a = new DbHandle($abfrage);  
           $data = $a->return;
           if(empty($data['count']))
           {
           $response = parent::response('23'); 
           $responseJson->message= $response['response_msg'];
           return $responseJson ;
           }
       
           $freigabeModal = self::modal_ids(array("auswahl"=>"delete_freigabe_modal",
                                               "id"=>$res['id']));
           
            $responseJson->modal_body    = $freigabeModal['img_body'];
            $responseJson->btn           = $freigabeModal['btn'];
            $responseJson->header        = $freigabeModal['img_header'];
            $result = $responseJson;
           
           break;
     case 'load_delete_user_modal':
            
            $id = $res['id'];
            $responseJson = new \stdClass();
            if(empty($id)){
            $def_modal = self::default_modal();
            $responseJson->header  = $def_modal['img_header'];
            $responseJson->body    = $def_modal['img_body'];
            $responseJson->btn     = $def_modal['btn'];
            return $responseJson;
            }

          $abfrage = array("method"   =>  "read_wp_db",
                           "table"    =>  "art_user",
                           "select"   =>  "*",
                           "where"    =>  " where id = %d",
                           "search"   =>  $res['id']);
           $a = new DbHandle($abfrage);  
           $data = $a->return;
           if(empty($data['count']))
           {
           $response = parent::response('23'); 
           $responseJson->message= $response['response_msg'];
           return $responseJson;
           }
       
           $deleteModal = self::modal_ids(array("auswahl"=>"delete_user_modal","data"=>$data['data'][0]));
           
           $responseJson->modal_body     = $deleteModal['img_body'];
            $responseJson->btn           = $deleteModal['btn'];
            $responseJson->header        = $deleteModal['img_header'];
            $result = $responseJson;
     
     break;
     case 'LoadUserKommentar':

            $abfrage = array("method"   =>  "read_wp_db",
                             "table"    =>  "art_images",
                             "select"   =>  "*",
                             "where"    =>  " where id = %d",
                             "search"   =>  $res['id']);
            $dat = new DbHandle($abfrage);
            $data=$dat->return;
            $settings = ApgSettings::load_settings('user_settings');
            $daten = array("auswahl"        =>  'user_kommentar_modal',
                            'galerie_name'  =>  htmlspecialchars(trim($data['data'][0]->galerie_name)),
                            "name"          =>  htmlspecialchars(trim( $data['data'][0]->name)),
                            "id"            =>  $res['id']);
                            
            $editModal = self::modal_ids($daten);
            $responseJson                   = new \stdClass();
            $responseJson->header           = $editModal['img_header'];
            $responseJson->body             = $editModal['img_body'];
            $responseJson->id               = $data['data'][0]->id;
            $responseJson->tags             = trim($data['data'][0]->tags);
            $responseJson->btn              = $editModal['btn'];
            $responseJson->name             = $data['data'][0]->name;
            $responseJson->beschreibung     = substr($data['data'][0]->beschreibung,0,$settings['_galerie_start_beschreibung_kurz']);
            $responseJson->bild_base        = trim($this->basename($data['data'][0]->name));
            $responseJson->galerie_name     = trim($data['data'][0]->galerie_name);
            $result = $responseJson;
            break;
     case 'load_notiz_modal':
            
            $htaccess_id = $res['id'];

            $abfrage = array("method"   =>  "read_wp_db",
                             "table"    =>  "art_user",
                             "select"   =>  "*",
                             "where"    =>  " where id = %d",
                             "search"   =>  $res['id']);
            $dat = new DbHandle($abfrage);
            $data=$dat->return;
            
            
            $editModal = self::modal_ids(array("auswahl"=>'user_notiz',"data"=>$data['data'][0]));
            
            $responseJson                   = new \stdClass();
            $responseJson->header           = $editModal['img_header'];
            $responseJson->modal_body       = $editModal['img_body'];
            $responseJson->btn              = $editModal['btn'];
            $responseJson->canvas           = false;
           $result = $responseJson;
            break;
      case 'load_image_beschreibung':
            $htaccess_id = $res['id'];

            $abfrage = array("method"   =>  "read_wp_db",
                             "table"    =>  "art_images",
                             "select"   =>  "*",
                             "where"    =>  " where id = %d",
                             "search"   =>  $res['id']);
            $dat = new DbHandle($abfrage);
            $data=$dat->return;
            
            
            $editModal = self::modal_ids(array("auswahl"=>'image_beschreibung',"data"=>$data['data'][0]));
            
            $responseJson                   = new \stdClass();
            $responseJson->header           = $editModal['img_header'];
            $responseJson->body             = $editModal['img_body'];
            $responseJson->btn              = $editModal['btn'];
            $responseJson->canvas           = false;
            $result = $responseJson ;
            break;
       case 'load_send_email_modal':
            $settings = ApgSettings::load_settings('user_settings');
            $responseJson = new \stdClass();
            if(empty($settings['license_aktiv'])){
            $header='<h3 class="dan"><span class="fa fa-exclamation-circle"></span>&nbsp;eMail <small> Senden ist nur mit <a class="prem" role="button" href="'.ART_PICTURE_SALE.'" target="_blank"> Art-Picture Galerie <span class="dan">Pro</span></a> Version m&ouml;glich!</small></h3>';
            $editModal = self::modal_pro_user(array("header"=>$header));
            $responseJson->header      = $editModal['img_header'];
            $responseJson->modal_body  = $editModal['img_body'];
            $responseJson->btn         = $editModal['btn'];
            $responseJson->canvas      = false; 
            return $responseJson ;    
            }

            $abfrage = array("method"   =>  "read_wp_db",
                             "table"    =>  "art_user",
                             "select"   =>  "*",
                             "where"    =>  " where id = %d",
                             "search"   =>  $res['id']);
       
            $dat = new DbHandle($abfrage);
            $data=$dat->return;
            $editModal = self::modal_ids(array("auswahl"=>'send_mail',"data"=>$data['data'][0]));
            
            
            $responseJson->header           = $editModal['img_header'];
            $responseJson->modal_body       = $editModal['img_body'];
            $responseJson->btn              = $editModal['btn'];
            $responseJson->canvas           = false;
            
            $result = $responseJson ;
            break;
        default:
            $return ='';
        break;    
    }
        return($result);
    }
  private function galerie_startseite($daten) {
        
      switch($daten['typ'])
      {
                    case 'body':
                    $settings = ApgSettings::load_settings('user_settings');
                    if(empty($settings['license_aktiv'])){
                        $pro_txt='</div></div><br /><br />
                       <div id="pro_version" class="col-md-12 text-center">
                       <div id="div2" class="divTimes">
                       <b class="grey">In der <b class="prem"><a class="prem" role="button" href="'.ART_PICTURE_SALE.'" target="_blank" <u> pro</b><b class="dan">Version</a></b></u> unbegrenzt Benutzer und Freigaben erstellen.
                       </div>
                       <p><a role="button" href="'.ART_PICTURE_SALE.'"target="_blank"><strong class="dan"> CLICK </strong></a>f&uumlr die Vollversion der <a class="grey" role="button" href="'.ART_PICTURE_URL.'"target="_blank"><b class="warn">Art</b>Picture Galerie</a></b></p>
                       </div><br />
                       </div>';
                     }else{
                       $pro_txt='<p><span class="grey glyphicon glyphicon-copyright-mark"></span><a role="button" href="'.ART_PICTURE_URL.'"target="_blank"> <b class="warn">Art</b><b class="grey">Picture Design </a></b><b class="warn"> '.date('Y').'</b></p>';   
                       }
                        $pro_version_txt = self::UmlautINS($pro_txt); 
             $body = ' <div class="aktion_menue">
                       <div class="col-md-8 col-md-offset-2">
                       <div class="table-responsive">
                       <table class="table text-center">
                       <tbody>
                       <tr>
                       <td>
                       <h4 class="warn"><span class="fa fa-angle-double-right"></span> Art<b class="grey">Picture</b><small> Galerie</small> <span class="fa fa-angle-double-left"></span></h4>
                       <hr class="hr-gray"><br>
                       <button class="chip btn-user"role="button"data-toggle="modal" data-target="#GalerieModal" data-whatever="start_loadNewGalerieModal+galerie">
                       <span class="menue"><b class="warn fa fa-photo fa-2x"></b></span>
                       <b class="warn"><b style="color: #868686;">&nbsp; Galerie</b> erstellen</b>
                       </button><br /><br />
                       <button class="chip btn-user "role="button"onclick="load_galerie_details(\'galerie\');">
                       <span class="menue"><b class="warn fa fa-cogs fa-2x"></b></span>
                       <b class="warn"><b style="color: #868686;">&nbsp; Galerie</b> Bearbeiten</b>
                       </button>
                       <br><br>
                       <button class="chip btn-user "role="button"data-toggle="modal" data-target="#GalerieModal" data-whatever="start_delete_galerie_select_modal+galerie">
                       <span class="menue"><b class="dan fa fa-trash fa-2x"></b></span>
                       <b class="dan"><b style="color: #868686;">&nbsp; Galerie</b> l&ouml;schen</b>
                       </button>
                        <br><br><br>
                        <hr class="hr-light">
                        <br>
                       <a href="admin.php?page=art-Picture-help"> <button class="chip btn-user "role="button">
                       <span class="menue"><b class="warn fa fa-lightbulb-o fa-2x"></b></span>
                       <b class="warn"><b style="color: #868686;"> ArtPicture</b> Hilfe</b>
                       </button></a>
                       <br /><br />
                       </td>
                       <td>
                        <h4 class="warn"><span class="fa fa-angle-double-right"></span> Art<b class="grey">Picture</b><small> Freigaben</small> <span class="fa fa-angle-double-left"></span></h4>
                       <hr class="hr-gray"><br>
                       <button class="chip btn-user "role="button"onclick="load_user_freigaben();">
                       <span class="menue"><b class="warn fa fa-folder-open-o fa-2x"></b></span>
                       <b class="warn"><b style="color: #868686;">&nbsp; neue</b> Freigabe</b>
                       </button>
                       <br /><br />
                      <a href="admin.php?page=art-Picture-user">  <button class="chip btn-user "role="button">
                       <span class="menue"><b class="warn fa fa-inbox fa-2x"></b></span>
                       <b class="warn"><b style="color: #868686;">&nbsp; User</b> Freigaben</b>

                       </button></a>
                        <br /><br />
                       <button class="chip btn-user "role="button"onclick="template_read_messages();">
                       <span class="menue"><b class="warn fa fa-envelope-o fa-2x"></b></span>
                       <b class="warn"><b style="color: #868686;">&nbsp; User</b> Message</b>
                       </button>
                       <br><br><br>
                       <hr class="hr-light">
                       </td>
                       </tr>
                       <tr>
                       </tbody>
                       </table>
                       '.$pro_version_txt.'
                       <hr class="hr-gray">  
                       <br /> ';
                      $return = self::UmlautINS($body); 
                      
            
            break;
    }
    $return = preg_replace(array('/<!--(.*)-->/Uis', "/[[:blank:]]+/"), array('', ' '), str_replace(array("\n","\r","\t"), '', $return));
    return $return;
}
private static function responsive_header($daten)
    {
        $huge = "huge";
        //huge-no
        if($daten['count_img'] == '0' ){
        $huge1 = "huge-no" ;
        $disab1ed1 = '';
        }else{
         $huge1 = "huge"; 
         $disab1ed1 = 'onclick="load_galerie_details(\'image\');"';
        }
        if($daten['count_gal'] == '0' ){
        $huge2 = "huge-no";
        $disab1ed2 = '';
        }else{
        $huge2 = "huge";
        $disab1ed2 = 'onclick="load_galerie_details(\'galerie\');"' ;
        }
        if($daten['galerie_freigaben'] == '0'){
        $huge3 = "huge-no";
        $disab1ed3 = ' class="disabled"';
        }else{
        $huge3 = "huge";
        $disab1ed3 = '';
        }
        if($daten['count_message']== '0'){
        $huge4 = "huge-no";
        $disab1ed4 = ' class="disabled"';
        }else{
        $huge4 = "huge";
        $disab1ed4 = '' ;
        }
     
        switch ($daten['methode'])
        {
            case 'header_lg':
            $header_lg = '<div class="col-lg-3 col-md-5 col-sm-5">
				       <div class="panel panel-edit ">
					   <div class="panel-heading">
					   <div class="row">
					   <div class="col-xs-3">
					   <i class="fa fa-camera-retro fa-5x"></i>
					   </div>
							<div class="col-xs-9 text-right">
								<div class="'.$huge1.'" id="image_total">'.$daten['count_img'].'</div>
								<div class="galerie-head">Bilder insgesamt</div>
							</div>
						</div>
					</div>
					<a  role="button"'.$disab1ed1.'>
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
								<i class="fa fa-folder-open-o fa-5x"></i>
							</div>
							<div class="col-xs-9 text-right">
								<div class="'.$huge2.'" id="galerie_count">'.$daten['count_gal'].'</div>
								<div class="galerie-head">Galerien insgesamt</div>
							</div>
						</div>
					</div>
					<a role="button" '.$disab1ed2.'>
						<div class="panel-footer">
							<span class="pull-left"><b class="warn">CLICK</b> für Details</span>
							<span class="pull-right"><i class=" fa fa-arrow-circle-right"></i></span>
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
								<i class="fa fa-unlock fa-5x"></i>
							</div>
							<div class="col-xs-9 text-right">
								<div class="'.$huge3.'"id="htaccess_total" >'.$daten['galerie_freigaben'].'</div>
								<div class="galerie-head">Galerie freigaben</div>
							</div>
						</div>
					</div>
					<a href="admin.php?page=art-Picture-user">
						<div class="panel-footer">
							<span class="pull-left"><b class="warn">CLICK</b> für Details</span>
							<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
							<div class="clearfix"></div>
						</div>
					</a>
				</div>
			</div>
			<div class="col-lg-3 col-md-5 col-sm-5">
				<div class="panel panel-edit">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-3">
								<i class="fa fa-envelope-o fa-5x"></i>
							</div>
							<div class="col-xs-9 text-right">
								<div class="'.$huge4.'"id="nachrichten_total">'.$daten['count_message'].'</div>
								<div class="galerie-head">Benachrichtigungen </div>
							</div>
						</div>
					</div>
					<a role="button"onclick="template_read_messages();">
						<div class="panel-footer">
							<span class="pull-left"><b class="warn">CLICK</b> für Details</span>
							<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
							<div class="clearfix"></div>
						</div>
					</a>
				</div>
			</div>';
            
          $header_lg = preg_replace(array('/<!--(.*)-->/Uis', "/[[:blank:]]+/"), array('', ' '), str_replace(array("\n","\r","\t"), '', $header_lg));
          
          $header = $header_lg;
            break;
        case 'header_sm':
           
            $root_url  = substr(admin_url(),0,strpos(admin_url(),'wp-admin'));    
            $url_ref = htmlspecialchars($root_url.'wp-admin/admin.php?page=art-Picture-user');
            $header = '<a role"button" onclick="load_galerie_details(\'image\');"><div class="text-center col-xs-3">
		    		   <i class="warn fa fa-camera-retro fa-4x"></i><br />
                       <h5 class="prem text-center">Insgesamt</h5>
                       <h5 class="huge prem"id="image_total">  '.$daten['count_img'].'      </h5>
					   </div></a>
                       <a role="button"onclick="load_galerie_details(\'galerie\');"><div class="text-center col-xs-3">
					   <i class="warn fa fa-folder-open-o fa-4x"></i><br />
                       <h5 class="prem text-center">Galerien</h5>
                       <h5 class="huge prem"id="galerie_count"> '.$daten['count_gal'].' </h5>
					   </div></a>
                       <a href="'.$url_ref.'"> <div class="text-center col-xs-3">
					   <i class="warn fa fa-unlock fa-4x"></i><br />
                       <h5 class="prem text-center">Freigaben</h5>
                       <h5 class="huge prem"id="htaccess_total">'.$daten['galerie_freigaben'].'</h5>
					   </div></a>
                       <a role="button"onclick="template_read_messages();"<div class="text-center col-xs-3">
					   <i class="warn fa fa-envelope-o fa-4x"></i><br />
                       <h5 class="prem text-center">Nachrichten</h5>
                        <h5 class="huge prem"id="nachrichten_total">'.$daten['count_message'].'</h5>
					   </div> </a>';
             $header = self::UmlautINS($header);                
             $header = preg_replace(array('/<!--(.*)-->/Uis', "/[[:blank:]]+/"), array('', ' '), str_replace(array("\n","\r","\t"), '', $header));
          
            break;
          default:  
            $header = '';
            break;
            
        }
        return $header;
     }
 private function load_galerie_select($sel = "",$typ = "") {
        
        $img_select_name            = '<div class="pref"> <select id="art_galerie_select" name="art_galerie_select" onchange="art_galerie_select(this.value)">'; 
        $message                    = '';
        $af = array("method"   =>  "read_wp_db",
                    "table"    =>  "art_galerie",
                    "select"   =>  "galerie_name"); 
        $input_name = 'galerie_loaded';                      
        if($typ == 'upload'){
        $input_name = 'galerie_name[]';
        }
        $resSelectDB = new DbHandle($af);
        $row = $resSelectDB->return;
        $count = $row['count'];
        if($sel != "" && $row['count'] == 0) {
            $status = false;
        }else{
            $status = true;
        }

        if($typ == "image_upload") {
         $img_select_name = '<select id="art_galerie_select" name="galerieLoaded"onchange="galerie_name_loaded(this.value)">';
        }
        $select  = $img_select_name;
        $select .='<option value="">Galerie w&auml;hlen</option>'; 
       foreach ($row['data'] as $tmp)
       {
         if($tmp->galerie_name == $sel) {
          $gew = ' selected="selected" ';
          $loaded_galerie .='<input type="hidden"name="'.$input_name.'"value="'.$tmp->galerie_name.'">'; 
         }else{
          $gew = '';
         }
         $select .= '<option value="'.$tmp->galerie_name.'" '.$gew.'>'.$tmp->galerie_name.'</option>';
       }
       $select .= '</select></div>';
        if($typ !='upload'){
           $select .= $loaded_galerie; 
        }        
       
       $select = preg_replace(array('/<!--(.*)-->/Uis', "/[[:blank:]]+/"), array('', ' '), str_replace(array("\n","\r","\t"), '', $select)); 
       $return = array("select"=>$select,"galerie_count"=>$count,"status"=>$status,"loaded"=>$loaded_galerie);
       return $return;  
    }
        private function create_galerie_button($daten) {
         $btn_aktiv ='';
        if($daten['count_gal'] == 0)
        {
            $btn_aktiv =' disabled="disabled" ';
        }
        switch ($daten['methode'])
        {
        case 'startGalerie_lg':
        
            $btn_new    = '<span class="btn-group"style="margin-top:20px ;">
                           <button type="button" class="btn btn-success btn-outline btn-sm"data-toggle="modal"data-target="#GalerieModal"data-whatever="start_loadNewGalerieModal+galerie" >
                           <i class="fa fa-paint-brush"></i> <b> &nbsp;neue Galerie </b></button> ';
              
            $btn_image = '<a type="button" class="btn btn-primary btn-outline btn-sm "href="admin.php?page=art-Picture-new">
                           <i class="fa fa-plus"></i> <b>&nbsp;Bilder hinzuf&uuml;gen</b></a>  
                           </span> ';
            $btn_new_image = self::UmlautINS($btn_image);               
            $btn =  $btn_new . $btn_new_image;
            $btn = preg_replace(array('/<!--(.*)-->/Uis', "/[[:blank:]]+/"), array('', ' '), str_replace(array("\n","\r","\t"), '', $btn));                                  
            break;
        case 'startGalerie_sm':
            $btn_new  = '<div class="btn-group"style="padding-left:55px;">
                         <button type="button" class="btn btn-success btn-outline btn-circle btn-xl" data-toggle="modal"data-target="#GalerieModal"data-whatever="start_loadNewGalerieModal+galerie" ><p style="margin-top:10px; "class="fa fa-plus"></p></button>&nbsp;';
            $btn_image = '<a type="button" class="btn btn-warning btn-outline btn-circle btn-xl"href="admin.php?page=art-Picture-new"><p style="margin-top:10px; " class=" fa fa-plus"></p></a>&nbsp;
                         </div>  ';
            $btn_new_image = self::UmlautINS($btn_image);             
            $btn =  $btn_new .  $btn_new_image;
            $btn = preg_replace(array('/<!--(.*)-->/Uis', "/[[:blank:]]+/"), array('', ' '), str_replace(array("\n","\r","\t"), '', $btn));
            
            break;
        case 'new_galerie_button_start':
                
              
            $btn = '<div class="col-md-5 col-md-offset-3">
                    <hr class="hr-footer">
                    <br><br />
                    <h3 class="text-center warn"><span class="warn fa fa-frown-o"></span>  Sie <small> haben noch keine Galerie erstellt!</small></h3>
                    <p class="text-center">
                    <button class="btn btn-warning btn-outline btn-lg text-center"data-toggle="modal"data-target="#GalerieModal"data-whatever="start_loadNewGalerieModal+galerie" >
                    <span class="fa fa-paint-brush"></span><b> &nbsp; jetzt&nbsp; </b>Galerie erstellen</button>
                    </p><br /><br />
                    <hr class="hr-footer"><br />
                    </div>'; 
             $btn = self::UmlautINS($btn);   
            $btn = preg_replace(array('/<!--(.*)-->/Uis', "/[[:blank:]]+/"), array('', ' '), str_replace(array("\n","\r","\t"), '', $btn));          
            break;

       }
       
       return $btn;
        
    }
    private static function UmlautINS($umlautINS){ 

   $sucheuml = array('Ã„','Ã¤','Ã–','Ã¶','Ãœ','Ã¼','ÃŸ',"&Auml;","&auml;","&Ouml;","&ouml;","&Uuml;","&uuml;","&szlig;");    
   $ersetzel = array('Ä','ä','Ö','ö','Ü','ü','ß','Ä','ä','Ö','ö','Ü','ü','ß'); 
   $guteuml  = str_replace($ersetzel,$sucheuml,$umlautINS); 

   //return $guteuml; 
        return $umlautINS;
   }
    
     protected static function default_modal($text="",$txtHeader="")
  {
       
        $text = 'kein <small>&nbsp; Nichts ist ausgewählt...';
        $txtHeader = 'kein <small> NICHTS GEWÃ„HLT  
                      <b class="warn">ausgewählt</b></small>';
                  
        $btn    = '<button type="button" id="default_modal" class="btn btn-success btn-outline" data-dismiss="modal"><i class="fa fa-thumbs-up"></i> na klar..</button>';  
        $Header = '<h4 class="warn"><span class="warn fa fa-smile-o"></span>&nbsp;'.$txtHeader.' </h4>';
        $Body   = '<div class ="row">
                  <div class="col-md-3" style=padding-top:20px;padding-left:25px;">
                  <img  class="center-block" width="150" height="150"style="border:1px solid #d3d3d3;"src="'. htmlspecialchars(plugins_url('../assets/images/background/ArtPictureBack150x150.jpg',__FILE__)) .'" >
                  </div>
                  <div class="col-md-7 col-md-offset-1"style="padding-top:20px;">
                  <h4 class="warn text-center"><span class="fa fa-child fa-5x"></span>&nbsp; '.$text.'</small></h4>
                  
                  </div>
                  </div>';//row  
       $return = array("img_header"=>$Header,"img_body"=>$Body,"btn"=>$btn);  
       return $return;           
    
  }
    
    protected static function modal_pro_user($daten)
    {
     $Header = $daten['header'];
     $Body   ='    <div class="form-group">
                   <a href="'.ART_PICTURE_SALE.'" target="_blank"><img  class="center-block" width="178" height="256"src="'. htmlspecialchars(plugins_url('../assets/images/galerie-pro/verpackung-frei-small.png',__FILE__)) .'" ></a><br>
                 <p class="text-center">
                 <a role="button" href="'.ART_PICTURE_SALE.'" target="_blank"><em><b class="grey">Art-Picture Galerie <b class="dan">Pro</b></b> </em></a>
                 </p> <div class="form-group">
                  <div class="col-md-7 col-md-offset-1 "style="padding-bottom:35px;">
                  <br>
                  </div>
                 </div>';
        $btn    = '';
        $Body = preg_replace(array('/<!--(.*)-->/Uis', "/[[:blank:]]+/"), array('', ' '), str_replace(array("\n","\r","\t"), '', $Body)); 
        $return = array("img_header"=>$Header,"img_body"=>$Body,"btn"=>$btn);  
       return $return;
        
    }
 protected static function modal_ids($daten) {
     $image = parent::base64_images(array("method"=>'header_small'));    
    switch ($daten['auswahl'])
       {
    case 'send_mail':
        $template = self::read_usermail_folder();
        if(count($template) == 1){
            $auswahl = 'no eMail Vorlagen';
        }else{
            $auswahl = 'auswahl Vorlagen';
        }
        $select_header = '<select class="form-control"id="art_email_select" onchange="email_select_change(this.value)">
                          <option value="">'.$auswahl.'</option>';
        $select_footer = ' </select>';
        
        foreach($template as $tmp)
        {
         if($tmp != 'zugangsdaten eMail.txt'){
         $sel = substr($tmp,0,strpos($tmp,'.txt'));
         $select_body .= '<option value="'.$tmp.'">'.$sel.'</option>';   
        }
        }
        $select = $select_header . $select_body . $select_footer;
        $data = $daten['data'];
        $Header ='<h3 class="warn"><span class="warn fa fa-envelope-o"></span>&nbsp;eMail <small> Senden ( '.$data->htaccess_email.' )</small></h3>';
        $Body   ='<div class ="row">
                  <div class="form-group">
                  <div class="col-md-3" style=padding-top:20px;padding-left:25px;">
                  <img  class="center-block" width="150" height="150"style="border:1px solid #d3d3d3;"src="'. htmlspecialchars(plugins_url('../assets/images/Logo-Art-Picture-galerie-B.png',__FILE__)) .'" >
                  </div>
                  </div>
                  <div class="form-group">
                  <div class="col-md-7 col-md-offset-1 "style="padding-bottom:35px;">
                  <label class="warn"><span class="warn fa fa-envelope-o"></span>&nbsp; eMail <span style="color:grey;">Vorlagen:</span></label>
                  '.$select.'
                <br>
                <label class="warn"><span class="warn fa fa-envelope-o"></span>&nbsp; Text <span style="color:grey;">schreiben:</span></label>
                 <textarea class="form-control" rows="4"id="new_email_txt" placeholder="eMail Text" ></textarea>
                
                </div></div>
                 </div>';//row
        $btn    = '<button type="button" class="btn btn-success btn-outline"onclick="send_user_email(\''.$data->id.'\');" data-toggle="modal"><i class="fa fa-save"></i> senden</button>';               
     
         break;
    case 'delete_image':
        $btn    = '<button type="button" id="delete_img" class="btn btn-danger"onclick="delete_img(\''.$daten['id'].'\')" data-toggle="modal"><i class="fa fa-trash-o"></i> löschen</button>';  
        $Header = '<h4 class="prem"><span class="prem fa fa-trash"></span>&nbsp; Bild ID: '. $daten['id'] .' <small> aus der Galerie \''.$daten['galerie_name'].'\' 
                 <b class="dan">löschen?</b></small></h4>';
        $Body   = '<div class ="row">
                 <div class="col-md-3" style=padding-top:20px;padding-left:25px;">
                 <canvas class="center-block" id="editCanvas"width="150" height="150"style="border:1px solid #d3d3d3;" >
                 </div>
                 <div class="col-md-7 col-md-offset-1"style="padding-top:60px;">
                 <h4 class="dan text-center"><span class="fa fa-trash"></span>&nbsp;'.$daten['name'].'<small>&nbsp;löschen?</small></h4>
                 </div>
                 </div>';//row  
            break;
    case 'edit_image':
        $Body   = '<div class ="row">
                 <input type = "hidden" name="loaded_image'.$daten['id'].'"value ="'.$daten['name'].'" >
                 <div class="form-group">
                 <div class="col-md-3" style=padding-top:20px;padding-left:25px;">
                 <canvas class="center-block" id="editCanvas"width="150" height="150"style="border:1px solid #d3d3d3;" >
                 </div>
                 <div class="col-md-7 col-md-offset-1">
                 <span class="warn fa fa-tags">
                 <label for="empfaenger-name" class="control-label"><h4 class="warn">Tags<small> hinzufügen: <span class="prem">(mit Komma trennen)</span></small></h4> </label></span>
                 <input type="text" class="form-control"name="new_tags" id="new_tags">
                 </div></div>
                 <div class="form-group">
                 <div class="col-md-7 col-md-offset-1 "style="padding-bottom:35px;">
                 <span class="warn  fa fa-pencil">
                 <label for="nachricht-text" class="control-label"><h4 class="warn"> Bild<small> beschreibung:</small> <small class="prem">(max. 100 zeichen.)</small> </h4></label></span>
                 <textarea class="form-control" rows="4"id="new_beschreibung" name="new_beschreibung"></textarea>
                 </div></div>
                 </div>';//row
        $Header = '<h3 class="warn"><span class="warn fa fa-edit"></span>&nbsp; Bild ID: '. $daten['id'] .' <small> beschreibung hinzufügen</small></h3>';
        $btn    = '<button type="button" id="new_image_beschreibung" class="btn btn-warning btn-outline"onclick="new_img_beschreibung(\''.$daten['id'].'\')" data-toggle="modal"><i class="fa fa-save"></i> speichern</button>';         
        break;

    case 'new_galerie':
        $Header = '<h3 class="prem"><span class="prem fa fa-folder-o"></span>&nbsp; Neue <small> Galerie erstellen.</small></h3>';
        $Body   = '<div class ="row">
                 <div class="form-group">
                 <div class="col-md-3" style=padding-top:20px;padding-left:25px;">
                 <img  class="center-block" width="150" height="150"style="border:1px solid #d3d3d3;"src="'. htmlspecialchars(plugins_url('../assets/images/background/ArtPictureBack150x150.jpg',__FILE__)) .'" >
                 </div>
                 <div class="col-md-7 col-md-offset-1">
                 <span class="prem fa fa-camera-retro">
                 <label for="empfaenger-name" class="control-label"><h4 class="prem">&nbsp; B<small>ezeichnung:</small></h4> </label></span>
                 <input type="text" class="form-control"name="new_name" id="new_galerie">
                 </div></div>
                 <div class="form-group">
                 <div class="col-md-7 col-md-offset-1 "style="padding-bottom:35px;">
                 <span class="prem  fa fa-pencil">
                 <label for="nachricht-text" class="control-label"><h4 class="prem">&nbsp; B<small>eschreibung:</small> <small class="prem"> (max. 100 zeichen.)</small></h4></label></span>
                 <textarea class="form-control" rows="4"id="new_gal_beschreibung" name="new_beschreibung"></textarea>
                 </div></div>
                 </div>';//row
        $btn    = '<button type="button" id="create_new_galerie" class="btn btn-success btn-outline"onclick="create_new_galerie();" data-toggle="modal"><i class="fa fa-save"></i> speichern</button>';               
    
         break;
    case 'delete_galerie':
        $btn    = '<button type="button" id="delete_galerie" class="btn btn-danger"onclick="delete_galerie(\''.$daten['galerie'].'\');" data-toggle="modal"><i class="fa fa-trash-o"></i> löschen</button>';  
        $Header = '<h4 class="prem"><span class="prem fa fa-trash"></span>&nbsp; Galerie: '. $daten['galerie'] .' '.$daten['count']. ' <small> ' .$daten['datum']. ' 
                 <b class="dan">löschen?</b></small></h4>';
        $Body   = '<div class ="row">
                 <div class="col-md-3" style=padding-top:20px;padding-left:25px;">
                  <img  class="center-block" width="150" height="150"style="border:1px solid #d3d3d3;"src="'. htmlspecialchars(plugins_url('../assets/images/background/ArtPictureBack150x150.jpg',__FILE__)) .'" >
                
                 </div>
                 <div class="col-md-7 col-md-offset-1"style="padding-top:60px;">
                 <h4 class="dan text-center"><span class="fa fa-trash"></span>&nbsp;'.$daten['galerie'].'<small>&nbsp;löschen?</small></h4>
                 <p class="text-center"><b class="dan">alle</b> Bilder aus dieser Galerie werden gelöscht!</p>
                 </div>
                 </div>';//row  
        break;
   case 'delete_galerie_select':

            $abfrage = array("method"   =>  "read_wp_db",
                             "table"    =>  "art_galerie",
                             "select"   =>  "*");
           $a = new DbHandle($abfrage);  
           $data = $a->return;
          
            $settings = ApgSettings::load_settings('user_settings');
           foreach ($data['data'] as $tmp)
           {
           $select_details .= '<option value="'.$tmp->galerie_name.'">'.$tmp->galerie_name.'</option>';
           }
           $select = '<input type="hidden"id="select_loaded_delete_galerie"value=""><select class="form-control"onchange="change_delete_galerie(this.value);">
                            <option value="">Galerie wählen</option>
                            '. $select_details.'
                             </select>';
                           
        $btn    = '<button type="button" id="delete_galerie_select" class="btn btn-danger"onclick="delete_galerie_select();" data-toggle="modal"disabled><i class="fa fa-trash-o"></i> löschen</button>';  
        $Header = '<h4 class="prem"><span class="prem fa fa-trash"></span>&nbsp; Galerie: <b class="dan">löschen?</b></small></h4>';
        $body_return = '<div class ="row">
                 <input type="hidden"id="loaded_select_delete_galerie"value="">
                 <div class="col-md-3" style=padding-top:20px;padding-left:25px;">
                  <img  class="center-block" width="150" height="150"style="border:1px solid #d3d3d3;"src="'. htmlspecialchars(plugins_url('../assets/images/background/ArtPictureBack150x150.jpg',__FILE__)) .'" >
                  </div>
                  <div class="col-md-7 col-md-offset-1"style="padding-top:60px;">
                 '.$select.' 
                          
                 <h4 class="dan text-center"><span class="fa fa-trash"></span>&nbsp;Galerie<small>&nbsp;löschen?</small></h4>
                 <span id="delete_galerie_details"> 
                 <p class="text-center"><b class="dan">alle</b> Bilder aus dieser Galerie werden gelöscht!</p>
                 </span> 
                 </div>
                 </div>';//row 
        $Body = self::UmlautINS($body_return);          
        break;
    case 'edit_galerie':
        $Body   = '<div class ="row">
                <input id="galerie_beschreibung_loaded" type="hidden"value="">
                 <div class="form-group">
                 <div class="col-md-3" style=padding-top:80px;padding-left:25px;">
                 <img  class="center-block" width="150" height="150"style="border:1px solid #d3d3d3;"src="'. htmlspecialchars(plugins_url('../assets/images/background/ArtPictureBack150x150.jpg',__FILE__)) .'" >
                 </div>

                
                 <div class="col-md-3" style=padding-top:20px;padding-left:25px;"></div>
                 <div class="col-md-7 col-md-offset-1">
                 <span class="grey fa fa-cloud">
                 <label for="empfaenger-name" class="control-label"> <h4 class="warn">Schlagw&ouml;rter<small> hinzuf&uuml;gen:</small></h4> </label></span>
                 <input type="text" class="form-control"name="new_tags" id="new_tags">
                 </div></div>
                 <div class="form-group">
                 <div class="col-md-3" style=padding-top:20px;padding-left:25px;"></div>
                 <div class="col-md-7 col-md-offset-1 "style="padding-bottom:35px;">
                 <span class="grey  fa fa-pencil">
                 <label for="nachricht-text" class="control-label"> <h4 class="warn"> Galerie<small> beschreibung:</small> <small class="prem"> (max. 100 zeichen.)</small> </h4></label></span>
                 <textarea class="form-control" rows="4"id="new_beschreibung" name="new_beschreibung"></textarea>
                 </div></div>
                 </div>';//row
                 $Body = self::UmlautINS($Body);
        $Header = '<h4 class="prem"><span class="prem fa fa-edit"></span>&nbsp; Galerie: '. $daten['galerie_name'] .' <small> beschreibung hinzufügen</small></h4>
                   <h5 class="prem text-left"style="padding-left:40px;"><span class="fa fa-info-circle">&nbsp; </span><b>ID:</b> '.$daten['id'].'</h5>';
        $btn    = '<button type="button" id="new_galerie_beschreibung" class="btn btn-warning btn-outline"onclick="new_gal_beschreibung('.$daten['id'].')" data-toggle="modal"><i class="fa fa-save"></i> speichern</button>';         
        break;

    case 'exif_modal':
        
                 $data = $daten['data'];
              if($data['DateOrginal'] != '0000-00-00 00:00:00'){
                $date1 = new \DateTime($data['DateOrginal']); 
                $datum1 = 'am '.$date1->format('d.m.Y').'<br/>um '.$date1->format('H:i:s'); 
              }else{
                $datum1 = 'unbekannt';
                }
              if($data['DateDigitized'] != '0000-00-00 00:00:00'){
                $date2 = new \DateTime($data['DateDigitized']);
                $datum2 = 'am '.$date2->format('d.m.Y').'<br/>um '.$date2->format('H:i:s');
             }else{
                $datum2 = 'unbekannt';
             }
             if($data['DateSoftware'] != '0000-00-00 00:00:00'){
                $date3 = new \DateTime($data['DateSoftware']);
                $datum3 = 'am '.$date3->format('d.m.Y').'<br/>um '.$date3->format('H:i:s');
             }else{
                $datum3 = 'unbekannt';
             }
             if($data['FocalLength'] !='unbekannt' ? $mm = ' mm' : $mm = '');
             if($data['FocalLengthIn35mmFilm'] !='unbekannt'  ? $mm35 = ' mm' : $mm35 = '');
             if($data['Width'] !='unbekannt' ? $px = 'px' : $px = '');
      
                $tags = trim($data['Tags']);
     
             if($tags !='unbekannt'){
                $i=0;
                $list = explode(",",$tags);
            foreach($list as $tmp)
            {
             if($i == 2){
                $br = '<br/>';
                $i = 0;
             }else{
                $br = '';
             }
                $i++;
                $exif_tags .= $tmp.','.$br;
            }
             }else{
                $exif_tags = 'keine';
              }
         if(strlen($daten['db_data']->name) > 29 ? $nk = '...' : $nk = '');
         if(strlen($daten['db_data']->galerie_name) > 29 ? $gk = '...' : $gk = '');                     
        $name = substr($daten['db_data']->name,0,29).$nk;
        $galerie_name = substr($daten['db_data']->galerie_name,0,29).$gk;
        $Body = '<div class=" displaystyle displaystyle-fullborder displaystyle-warning displaystyle-sm"style="background-color: #eee;">
               <div class="row">
               <div class="col-md-4">
               <h2 > <small><span class="fa fa-camera fa-2x"></span> <b class="warn">Image</b> Exif Daten</small></h2>
               <br>
               <span class="gps_details">
               <b class ="warn fa  fa-file-o"> </b> ID: '.$daten['db_data']->id.'
               <br>
               <b class ="warn fa  fa-file-photo-o"></b> '.$name.'
               <br>
               <b class ="warn fa  fa-folder-open-o"></b> '.$galerie_name.'
               <br>
               <b class ="warn fa  fa-expand"></b> '.parent::FileSizeConvert($daten['db_data']->size).'
               <br>
               </span>
               </div>
               <div class="col-md-4">
               <p class="text-center">
               <canvas class="center-block" id="GpsCanvas"width="180" height="180"style="border:1px solid #d3d3d3;" > 
               </p>
               </div>
               <div class="col-md-4">
               <br><br>
               <p class="text-center"style="padding-top:45px;">
               <img src="'.$image.'"><br/>
               </p>
               </div>
               </div>
               <div class="exif-details-wrapper">
               <div class="table-responsive">
               <table class="table">
                         
               <tbody>
                 <tr>
                 <td  style="width:20%"><i class="glyphicon glyphicon-copyright-mark"></i>&nbsp;<b >Copyright:</b></td> 
                 <td  style="width:18%">'.$data['Copyright'].'</td>
                 <td  style="width:4%"></td>
                 <td  style="width:16%"><i class="fa fa-tachometer"></i>&nbsp;<b>Messmodus:</b></td>  
                 <td  style="width:15%">'.$data['MeteringMode'].'</td>
                 <td  style="width:23%"><i class="fa fa-map-marker"></i>&nbsp;<b>GPSLatitudeRef:</b></td> 
                 <td   style="width:8%">'.$data['GPSLatitudeRef'].'</td>
                 </tr>
                 <tr>
                 <td><i class="fa fa-camera"></i>&nbsp;<b>Kamera:</b></td> 
                 <td>'.$data['Make'].'</td>
                 <td></td> 
                 <td><i class="fa fa-camera-retro"></i>&nbsp;<b>Model:</b></td>                           
                 <td>'.$data['Model'].'</td>
                 <td><i class="fa fa-map-marker"></i>&nbsp;<b>GPS Latitude1:</b></td> 
                 <td>'.$data['GPSLatitude1'].'</td>
                 </tr>
                 <tr>
                 <td><i class="fa fa-calendar"></i>&nbsp;<b>Aufgen.:</b></td>                          
                 <td>'.$datum1.'</td>
                 <td></td>          
                 <td><i class="fa fa-bullseye"></i>&nbsp;<b>Objektiv:</b></td>                          
                 <td>'.$data['Objektiv'].'</td>
                 <td><i class="fa fa-map-marker"></i>&nbsp;<b>GPS Latitude2:</b></td> 
                 <td>'.$data['GPSLatitude2'].'</td>
                 </tr>
                 <tr>
                 <td><i class="fa fa-calendar"></i>&nbsp;<b>letzte Bearb.:</b></td>                     
                 <td>'.$datum3.'</td>
                 <td></td>     
                 <td><i class="fa fa-info"></i>&nbsp;&nbsp;<b>ISO: </b></td>                          
                 <td>'.$data['ISOSpeedRatings'].'</td>
                 <td><i class="fa fa-map-marker"></i>&nbsp;<b>GPS Latitude3:</b></td> 
                 <td>'.$data['GPSLatitude3'].'</td>
                 </tr>
                 <tr>
                 <td><i class="fa fa-calendar"></i>&nbsp;<b>Digitalisiert:</b></td>                      
                 <td>'.$datum3.'</td>
                 <td></td>      
                 <td><i class="fa fa-eye"></i>&nbsp;<b>Blende: </b></td>                                 
                 <td>'.$data['ApertureFNumber'].'</td>  
                 <td><i class="fa fa-map-marker"></i>&nbsp;<b>GPSLongitudeRef:</b></td>
                 <td>'.$data['GPSLongitudeRef'].'</td>
                 <td></td>     
                 </tr>
                 <tr>
                 <td><i class="fa fa-file-o"></i>&nbsp;<b>Image Typ:</b></td>                          
                 <td>'.$data['type'].'</td>
                 <td></td> 
                 <td><i class="fa fa-clock-o"></i>&nbsp;<b>Belichtung: </b></td>                       
                 <td>'.$data['ExposureTime'].'</td>
                 <td><i class="fa fa-map-marker"></i>&nbsp;<b>GPSLongitude1:</b></td> 
                 <td>'.$data['GPSLongitude1'].'</td>
                 </tr>
                 <tr>
                 <td><i class="fa fa-laptop"></i>&nbsp;<b>Software:</b></td>                           
                 <td class="td-small">'.$data['Software'].'</td>  
                 <td></td> 
                 <td><i class="fa fa-circle-o"></i>&nbsp;<b>Brennweite: </b></td>                        
                 <td>'.$data['FocalLength'].$mm.'</td>
                 <td><i class="fa fa-map-marker"></i>&nbsp;<b>GPSLongitude2:</b></td>  
                 <td>'.$data['GPSLongitude2'].'</td>
                 </tr>
                 <tr>
                 <td><i class="fa fa-arrows-h"></i>&nbsp;<b>Bild Breite:</b></td>                      
                 <td>'.$data['Width'].' '.$px.'</td>
                 <td></td> 
                 <td><i class="fa fa-circle-o"></i>&nbsp;<b>in 35mm: </b></td>                            
                 <td>'.$data['FocalLengthIn35mmFilm'].$mm35.'</td>
                 <td><i class="fa fa-map-marker"></i>&nbsp;<b>GPSLongitude3:</b></td> 
                 <td>'.$data['GPSLongitude3'].'</td>
                 </tr>
                 <tr>
                 <td><i class="fa fa-arrows-v"></i>&nbsp;<b>Bild Höhe:</b></td>                       
                 <td>'.$data['Height'].' '.$px.'</td>   
                 <td></td>   
                 <td><i class="fa fa-gear"></i>&nbsp;<b>Weißableich:</b></td>         
                 <td>'.$data['WhiteBalance'].'</td>
                 <td><i class="fa fa-map-marker"></i>&nbsp;<b>GPSAltitude:</b></td> 
                 <td>'.$data['GPSAltitude'].'</td> 
                 </tr>
                 <tr> 
                 <tr>
                 <td><i class="fa fa-tags"></i>&nbsp;<b>Tags:</b></td>                                  
                 <td>'.$exif_tags.'</td> 
                 <td></td> 
                 <td><i class="fa fa-adjust"></i>&nbsp;<b>Belicht.Mod: </b></td>                
                 <td>'.$data['ExposureMode'].'</td>
                 <td></td><td></td>  
                 </tr>
               </tbody>
                 </table>
                 </div>
                 </div>
                 <small><i class="warn fa fa-thumb-tack"></i><b class="grey">&nbsp;erstellt</b> mit <b class="warn">Art</b><b class="grey">Picture-Galerie&nbsp;</b>
                 <span class="warn glyphicon glyphicon-copyright-mark"></span><b class="grey">Jens Wiecker</b><a class="grey" href="'.ART_PICTURE_URL.'" target="_blank"> (<b class="warn">art</b>PictureDesign) </a><strong class="grey">'.date('Y').'&nbsp;</strong>  </small> 
                 </div>
                 </div><br/><!--modal-body-->';
                 $Body = preg_replace(array('/<!--(.*)-->/Uis', "/[[:blank:]]+/"), array('', ' '), str_replace(array("\n","\r","\t"), '', $Body));
        $footer = '<div class="modal-footer">
                 <p class="text-left">
                 <img src="'.$image.'">
                 </p>  
                 <span id="modal_btn"></span>
                 <button type="button" class="btn btn-warning btn-outline" data-dismiss="modal"><i class="fa fa-times"></i> schließen</button>
                 </div>
                 </div>
                 </div>
                 </div>';
        $Header = ' <p class="text-left"><img src="'.$image.'"></p>';  
            $btn = '<button type="button" id="default_modal" class="btn btn-success btn-outline"data-dismiss="modal" ><i class="fa fa-thumbs-up"></i> OK</button>';       
            break; 
       case 'gps_modal':
          
          $data = $daten['data'];
          $altitude = 'unbekannt';
          if($data['GPSAltitude'] != '0')
            {
            $alt = substr($data['GPSAltitude'],0,strpos($data['GPSAltitude'],'.')+3);    
            $altitude = $data['GPSAltitude'];
            }
              if($data['DateOrginal'] != '0000-00-00 00:00:00'){
                $date1 = new \DateTime($data['DateOrginal']); 
                $datum1 = 'aufgenommen am '.$date1->format('d.m.Y'); 
              }else{
                $datum1='unbekannt';
              }
         $Header = ' <h2> <small><span class="fa fa-camera fa-2x"></span> <b class="warn">Image</b> GPS Standort</small></h2> ';
         $Body   = '<div class=" displaystyle displaystyle-fullborder displaystyle-warning displaystyle-sm"style="background-color: #eee;"> 
                    <div class="row">
                    <div class="col-md-4">
                    <h2> <small><span class="fa fa-camera fa-2x"></span> <b class="warn">Image</b> GPS Standort</small></h2>
                    <br>
                    <span class="gps_details">
                    <b class ="warn fa  fa-file-o"> </b> ID: '.$daten['db_data']->id.'
                    <br>
                    <b class ="warn fa  fa-file-photo-o"></b> '.$daten['db_data']->name.'
                    <br>
                    <b class ="warn fa fa-camera-retro"></b> '.$datum1.'
                    <br>
                    <b class ="warn fa fa-arrows-v"></b>&nbsp;&nbsp; Höhe: '.$alt.' m über NN
                    <br>
                    <span id="gpsheight">
                    <b class ="warn fa fa-arrows-v"></b>&nbsp;&nbsp; Höhe: <span id="gpsAltitude"></span><br>&nbsp;&nbsp;&nbsp; der Kamera(Drohne)
                    </span>
                    </div>
                    </span>
                   <div class="col-md-4">
                   <canvas class="center-block" id="GpsCanvas"width="180" height="180"style="border:1px solid #d3d3d3;" >
                   
                   </div>
                   <div class="col-md-4">
                   <br><br>
                   <p class="text-center"style="padding-top:45px;">
                   <img src="'.$image.'"><br/>
                   </p>
                   </div>
                   </div>
                   <br />
                   <div id="map" ></div>
                   </div><!--Displaystyle-->';
                  
            break;
     case 'delete_freigabe_modal':
        $btn    = '<button type="button" id="delete_freigabe" class="btn btn-danger"onclick="delete_freigabe(\''.$daten['id'].'\');" data-toggle="modal"><i class="fa fa-trash-o"></i> löschen</button>';  
        $Header = '<h4 class="prem"><span class="prem fa fa-trash"></span>&nbsp; Freigabe: '. $daten['galerie_name'] .' <small> <b class="dan">löschen?</b></small></h4>';
        $Body   = '<div class ="row">
                 <div class="col-md-3" style=padding-top:20px;padding-left:25px;">
                 <img  class="center-block" width="150" height="150"style="border:1px solid #d3d3d3;"src="'. htmlspecialchars(plugins_url('../assets/images/background/ArtPictureBack150x150.jpg',__FILE__)) .'" >
                 </div>
                 <div class="col-md-7 col-md-offset-1"style="padding-top:60px;">
                 <h4 class="dan text-center"><span class="fa fa-trash"></span>&nbsp;Freigabe '.$daten['galerie_name'].'<small>&nbsp;löschen?</small></h4>
                 <p class="text-center"><b class="dan">alle</b> Bilder werden aus dieser Freigabe entfernt!</p>
                 </div>
                 </div>';//row 
                 $Body = preg_replace(array('/<!--(.*)-->/Uis', "/[[:blank:]]+/"), array('', ' '), str_replace(array("\n","\r","\t"), '', $Body)); 
            
            break;
    case 'delete_user_modal':
         $data = $daten['data'];
         $date = new \DateTime($data->created_at); 
                $datum = $date->format('d.m.Y'); 
        $btn    = '<button type="button" id="delete_user" class="btn btn-danger"onclick="delete_user(\''.$data->id.'\');" data-toggle="modal"><i class="fa fa-trash-o"></i> löschen</button>';  
        $Header = '<h4 class="dan"><span class="dan fa fa-trash"></span>&nbsp; Benutzer: <small>'. $data->htaccess_vorname .' '.$data->htaccess_nachname .' <b class="dan">löschen?</b></small></h4>';
        $Body   = '<div class ="row">
                 <div class="col-md-3" style=padding-top:20px;padding-left:25px;">
                 <img  class="center-block" width="150" height="150"style="border:1px solid #d3d3d3;"src="'. htmlspecialchars(plugins_url('../assets/images/Logo-Art-Picture-galerie-B.png',__FILE__)) .'" >
                 </div>
                 <div class="col-md-7 col-md-offset-1"style="padding-top:40px;">
                 <h4 class="dan text-center"><span class="fa fa-trash"></span>&nbsp;Benutzer <br> <small>&nbsp;<small>('.$data->htaccess_user.' | ID:'.$data->id.' | erstellt am: '.$datum.')</small> löschen?</small></h4>
                 <p class="text-center"><b class="dan">alle</b> erstellten Freigaben werden entfernt!</p>
                 </div>
                 </div>';//row 
                 $Body = preg_replace(array('/<!--(.*)-->/Uis', "/[[:blank:]]+/"), array('', ' '), str_replace(array("\n","\r","\t"), '', $Body)); 
            
            break;
    case 'user_kommentar_modal':
               $eintrag = ''; 
               session_start(); 
               $abfrage = array("method" =>  "user_wp_freigabe_auswahl",
                                "data"   =>  array("htaccess_id"=>$_SESSION['id'],"galerie_name"=>$daten['galerie_name']));
       
            $dat = new DbHandle($abfrage);
            $data=$dat->return;
            
            $db_message = unserialize($data['data'][0]->message);
            for ($x = 0; $x <= count($db_message); $x++) {  
             $id  = substr($db_message[$x],0,strpos($db_message[$x],'_'));
             $msg = substr($db_message[$x],strpos($db_message[$x],'_')+1);
             if($id == $daten['id']){
              $eintrag = $msg;
            }
           }
          
        $Body   = '<div class ="row">
                 <input type = "hidden" name="loaded_image'.$daten['id'].'"value ="'.$daten['name'].'" >
                 <div class="form-group">
                 <div class="col-md-3" style=padding-top:20px;padding-left:25px;">
                 <canvas class="center-block" id="editCanvas"width="150" height="150"style="border:1px solid #d3d3d3;" >
                 </div>
                 </div>
                 <div class="form-group">
                 <div class="col-md-7 col-md-offset-1 "style="padding-bottom:35px;">
                 <span class="warn  fa fa-pencil">
                 <label for="nachricht-text" class="control-label"><h4 class="warn"> Bild<small> Kommentar: <small class="prem"> (max.: 100 zeichen)</small></small> </h4></label></span>
                 <textarea class="form-control" rows="4"id="new_user_kommentar">'.$eintrag.'</textarea>
                 </div></div>
                 </div>';//row
      
           
        $Header = '<h3 class="warn"><span class="warn fa fa-edit"></span>&nbsp; Bild ID: '. $daten['id'] .' <small> Kommentar hinzufügen</small></h3>';
        $btn    = '<button type="button" id="new_user_kommentar" class="btn btn-warning btn-outline"onclick="new_user_kommentar(\''.$daten['id'].'\')" data-toggle="modal"><i class="fa fa-save"></i> speichern</button>';         
       break;
    case 'user_notiz':
        $data = $daten['data'];
        $ph ='';
        if(empty($data->notiz)){
            $ph ='kein Eintrag vorhanden...';
        }
        $Header = '<h3 class="warn"><span class="warn fa fa-user"></span>&nbsp;Benutzer <small> Notiz ('.$data->htaccess_vorname.' '.$data->htaccess_nachname.')</small></h3>';
        $Body   = '<div class ="row">
                 <div class="form-group">
                 <div class="col-md-3" style=padding-top:20px;padding-left:25px;">
                 <img  class="center-block" width="150" height="150"style="border:1px solid #d3d3d3;"src="'. htmlspecialchars(plugins_url('../assets/images/Logo-Art-Picture-galerie-B.png',__FILE__)) .'" >
                 </div>
                 </div>
                 <div class="form-group">
                 <div class="col-md-7 col-md-offset-1 "style="padding-bottom:35px;">
                 <span class="warn  fa fa-pencil">
                 <label for="nachricht-text" class="control-label"><h4 class="warn"> U<small>ser Notiz <small>('.$data->htaccess_vorname.
                 ' ' .$data->htaccess_nachname.' <b class="dan"> | </b>  '.$data->htaccess_user.' <b class="dan"> |</b> ID: '.$data->id.')</small></small> </h4></label></span>
                 <textarea class="form-control" rows="5"id="new_user_notiz'.$data->id.'"placeholder="'.$ph.'">'.$data->notiz.'</textarea>
                 </div></div>
                 </div>';//row
        $btn    = '<button type="button" class="btn btn-success btn-outline"onclick="new_user_notiz(\''.$data->id.'\');" data-toggle="modal"><i class="fa fa-save"></i> speichern</button>';               
     
       break; 
   case 'image_beschreibung':
       $data = $daten['data'];
        $ph ='';
        if(empty($data->beschreibung)){
            $ph ='kein Eintrag vorhanden...';
        }
        $Header = '<h4 class="warn"><span class="warn fa fa-photo"></span>&nbsp;Bild <small> Beschreibung <span class="prem">
                  (<b class="prem">Name:</b><b class="grey"> '.$data->name.'</b> |  <b class="prem">ID:</b><b class="grey"> '.$data->id.'</b>) </span></small></h4>';
        $Body   = '<div class ="row">
                 <div class="form-group">
                 <div class="col-md-3" style=padding-top:20px;padding-left:25px;">
                 <img  class="center-block" width="150" height="150"style="border:1px solid #d3d3d3;"src="'. htmlspecialchars(plugins_url('../assets/images/Logo-Art-Picture-galerie-B.png',__FILE__)) .'" >
                 </div>
                 </div>
                 <div class="col-md-7 col-md-offset-1 "style="padding-bottom:35px;">
                 <span class="warn fa  fa-pencil-square-o">
                 <b class="warn"> Bilde</b> <b class="grey"> Beschreibung:</b>
                 <div class="user-response grey">
                 '.$data->beschreibung.'
                  </div>
                 </div>
                 </div>';//row
        $btn    = '  <button type="button" class="btn btn-success btn-outline" data-dismiss="modal"><span class="fa fa-thumbs-o-up"></span> 
                      <span class="fa fa-angle-double-right"></span> ok</button>';        
       break;
     
     }
     $return = array("img_header"=>$Header,"img_body"=>$Body,"btn"=>$btn);  
     return $return;
    }
    private static function read_usermail_folder(){
    $dir = __dir__ . '/templates/user-mail';
    $alledateien = scandir($dir);
   if(empty($alledateien)){
     return false;
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
     $return = $file;
   }
   return $return;
}
}   

?>