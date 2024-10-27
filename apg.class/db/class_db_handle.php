<?php
/**
 * ArtPicture Plugin PHP Class
 * http://art-pictureDesign.de/WP-ArtTheme-Galerie
 * Copyright 2017, Jens Wiecker
 * https://art-picturedesign.de
 *
 */
namespace APG\ArtPictureGallery;
class DbHandle
{
    protected $option;
    public function __construct($option=null,$db_handle=true) {
        $this->option = array(
        "method"            =>null,
        "table"             =>null,
        "select"            =>null,
        "update"            =>null,
        "where"             =>null,
        "checked"           =>null,
        "search"            =>null,
        "session"           =>false,
        "id"                =>null,
        "set"               =>null,
        "newID"             =>null,
        "log"               =>true,
        "beschreibung"      =>null,
        "statement"         =>null,
        "data"              =>null,
        "tags"              =>null,
        "name"              =>null,
        "prepare_typ"       =>null    
        );
        $this->log = $this->option['log'];
        if ($option ) {
            $this->option  = $option  + $this->option ;
        }
         global $wpdb;
         $this->table = $wpdb->prefix . $this->option['table'];
         $this->return = $this->db_handle();        
    }
 private function db_handle(){
    switch ($this->option['method'])
     {
    case 'read_wp_db':
         $res = $this->read_wp_db();
         $this->return = $res;
        return $this->return;       
    break;        
    case 'update_wp_db':
         $res = $this->update_db();
        $this->return = $res;
    break;        
    case'update_wp_user_nachricht':
          self::update_wp_user_nachricht($this->option['data']['id'], $this->option['data']['message']);
    break;    
    case 'get_wp_user_settings':
        $this->return = $this->get_wp_user_settings();
        return $this->return; 
     break;         
    case 'delete_wp_image':
         $return = self::delete_wp_file_galerie($this->option['id']);
         $this->return = $return;
         return $this->return;
         break;        
    case 'update_wp_galerie_beschreibung':
          self::update_wp_image($this->option['id'],$this->option['beschreibung'],$this->option['tags'],$this->option['table']);
         break;        
    case 'new_wp_galerie':
          $this->return = $this->insert_wp_data_new_galerie();
          return $this->return;
         break;        
    case 'delete_wp_galerie':
          global $wpdb;    
          $table_name = $wpdb->prefix . 'art_images';
          $result = $wpdb->get_results( 
          "SELECT *
          FROM  ".$table_name." " );    
          foreach($result as $val) {
           if($val->galerie_name == $this->option['name']) {
           $return = self::delete_wp_file_galerie($val->id);
           }
         }
          self::delete_galerie_menue_user($this->option['name']); 
          break;        
    case 'count':
            global $wpdb;
            $table_galerie = $wpdb->prefix .'art_galerie';
            $table_images = $wpdb->prefix .'art_images';
            $table_freigaben = $wpdb->prefix .'art_freigaben';
            $table_user = $wpdb->prefix .'art_user';
                $x = 0;
                $c1 = $wpdb->get_results( "SELECT * FROM $table_user " );
                if(!empty($c1)){
                for($i = 0; $i <= $c1['count']; $i++) {
                $msg = unserialize($c1[$i]->user_message);
                $count[] = $msg;
                 }
                $count = array_filter(array_values($count));
                 foreach($count as $tmp){
                  $x += count($tmp);
                 }   
                }
        $img_beschr =  $wpdb->get_results( "SELECT beschreibung FROM $table_images " );
        $image_beschreibung=0;
        foreach($img_beschr as $tmp ){
        if(empty($tmp->beschreibung)){
        continue;
        }
            $image_beschreibung++;
        }    
        $tags =  $wpdb->get_results( "SELECT tags FROM $table_images " );
        $image_tags=0;
        foreach($tags as $tmp ){
        if(empty($tmp->tags)){
        continue;
        }
            $image_tags++;
        }
        $gal_beschreibung =  $wpdb->get_results( "SELECT beschreibung FROM $table_galerie " );
        $beschreibung_gal=0;
        foreach($gal_beschreibung as $tmp ){
        if(empty($tmp->beschreibung)){
        continue;
        }
            $beschreibung_gal++;
        } 
        $gal_tags =  $wpdb->get_results( "SELECT tags FROM $table_galerie " );
        $galerie_tags=0;
        foreach($gal_tags as $tmp ){
        if(empty($tmp->tags)){
        continue;
        }
            $galerie_tags++;
        }    
        $ag =  $wpdb->get_var( "SELECT COUNT(*) FROM $table_galerie " );
        $img =  $wpdb->get_var( "SELECT COUNT(*) FROM $table_images " );   
        $ga_freigaben =  $wpdb->get_var( "SELECT COUNT(*) FROM $table_freigaben " );  
        $return = array("galerie"              =>(int)$ag,
                        "images"               =>(int)$img,
                        "post_id"              =>(int)$post_id,
                        "img_beschreibung"     =>(int)$image_beschreibung,
                        "img_tags"             =>(int)$image_tags,
                        "galerie_beschreibung" =>(int)$beschreibung_gal,
                        "galerie_tags"         =>(int)$galerie_tags,
                        "galerie_freigaben"    =>(int)$ga_freigaben,
                        "count_message"        => (int)$x 
                         );
     $this->return = $return;
     return $this->return;                 
     break;
case 'new_wp_user':
     $user = $this->new_wp_user($this->option['data']);
     $this->return=$user;
     return $this->return;
     break;            
 case 'new_wp_freigabe':
     return  $this->return = $this->new_wp_freigabe();
     break;            
 case 'user_wp_freigabe_start':
      return  $this->return = $this->user_wp_freigabe_start();
      break;            
 case 'delete_wp_freigabe':
     $this->delete_wp_db();
     break;            
 case 'update_wp_user_details':
     $this->update_wp_user_details();
     break;
 case 'freigabe_wp_id':
     $this->galerie_id = $this->option['data']['galerie_id'];
     $this->htaccess_id = $this->option['data']['htaccess_id'];
     return $this->return =  $this->freigabe_wp_id();
     break;             
 case 'user_wp_auswahl':
     self::update_wp_user_auswahl($this->option['id'],$this->option['checked'],$this->table);
    break;
 case 'new_wp_user_message':
    self::update_wp_user_message($this->option['data']['id'],$this->option['data']['message'],$this->table);
    break;             
 case 'user_wp_freigabe_auswahl':
      $this->return = $this->user_wp_freigabe_auswahl();
      return $this->return;
      break;            
 case 'user_wp_response':
      $this->return = $this->user_wp_response();
      return $this->return;
    break;           
 case 'update_wp_user_aktiv':
     $this->update_wp_user_aktiv(); 
    break;            
  case'update_wp_posts_wpSeite':
    $this->update_wp_posts_wpSeite(); 
   break;            
 case 'update_wp_user_new_passwort':
      $this->update_wp_user_new_passwort();
    break;            
case 'update_wp_user_kommentar':
     $this->update_wp_user_kommentar();
    break;            
case'user_wp_freigabe_select':
      $this->return = $this->user_wp_freigabe_select();
      return $this->return;
     break;      
    default:
    $this->return = '';
     break;   
        }
    } //end db_handle
private function read_wp_db(){
    global $wpdb;
    $row = $wpdb->get_results( $wpdb->prepare(
   "SELECT ".$this->option['select']. "
   FROM  ".$this->table." 
     ".$this->option['where']." ", 
            $this->option['search'] ));
   $return = array("data" => $row, "count" => count($row));
   return $return;
}    
private function freigabe_wp_id(){  
       global $wpdb;
       $row = $wpdb->get_results( $wpdb->prepare( 
	   " SELECT ".$this->option['select']."
       FROM $this->table
       where galerie_id = %d and htaccess_id = %d ", 
	   $this->galerie_id, $this->htaccess_id
       ) );
       $return = array("data" => $row, "count" => count($row));
       return $return;
    }    
private function get_wp_user_settings(){
         global $wpdb;
         $row = $wpdb->get_results( $wpdb->prepare(
          "SELECT ".$this->option['select']. "
          FROM  ".$this->table." 
          ".$this->option['where']." ", 
          $this->option['search'] ));
          $return = unserialize($row[0]->user_settings);
          return $return;
}    
private static function delete_wp_file_galerie($id){

         // $path = dirname(__DIR__).'/file-upload/files';
           $path = ABSPATH.'APG-FILES';
           global $wpdb;    
          $table_name = $wpdb->prefix . 'art_images';
          $fehler = "";
          $error_msg = "";
          $res = $wpdb->get_results( $wpdb->prepare(
          "SELECT id,galerie_name,name
          FROM  ".$table_name." 
          where id = %d", 
          $id ));
          foreach($res as $tmp){
            $file   = $path . '/img/'    . htmlspecialchars_decode($tmp->name);
            $medium = $path . '/medium/' . htmlspecialchars_decode($tmp->name);
            $thumb  = $path . '/thumb/'  . htmlspecialchars_decode($tmp->name);
            if (file_exists($file)   ? unlink($file) && $response = "<strong class='suss'>erfolgreich gelöscht</strong>" : $fehler = "file") ;
            if (file_exists($medium) ? unlink($medium)  : $fehler .= 'medium url error') ;
            if (file_exists($thumb)  ? unlink($thumb)   : $fehler .= 'thumb url error') ;
            self::delete_user_freigabe($tmp->galerie_name);
            self::delete_image_db($tmp->id,$table_name);  
          }
            $total = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name" ); 
            if (strlen($fehler) > 0) {
            $error_msg = "<strong class='dan'>ein fehler beim löschen der Datei ist aufgetreten.</strong>";
            $status = false;
            }
            $return = array("response" => $response, "error_msg" => $fehler,"status"=>$status,"total"=>$total);
            return $return;
    } // ENDE delete_file_galerie
private static function delete_user_freigabe($galerie_name){
   global $wpdb;    
   $table_galerie = $wpdb->prefix . 'art_galerie';
   $table_freigaben = $wpdb->prefix . 'art_freigaben';    
       $result = $wpdb->get_results( 
          "SELECT *
           FROM  ".$table_galerie." " );
     foreach($result as $tmp) {
       if($tmp->galerie_name == $galerie_name){
          $id = $wpdb->get_results( 
         "SELECT *
         FROM  ".$table_freigaben." " );
         for ($i = 0; $i <= count($id); $i++) {
          if($id[$i]->galerie_id == $tmp->id){
          $wpdb->delete( $table_freigaben, array( 'id' => $id[$i]->id ), array( '%d' ) );  
        }
       }
      }
     }
}
private static function delete_image_db($id,$table){
     global $wpdb; 
      $wpdb->delete( $table, array( 'id' => $id ), array( '%d' ) );
    }
private function delete_wp_db(){
      global $wpdb; 
      $wpdb->delete( $this->table, array( 'id' => $this->option['id'] ), array( '%d' ) );
    }    
private static function update_wp_image($id, $beschreibung,$tags,$table){
        global $wpdb; 
        $wpdb->update( 
	    $table, 
	   array( 
		'beschreibung' => $beschreibung,
        'tags' => $tags 
	   ), 
	   array( 'id' => $id ), 
	   array( 
		'%s',
		'%s'
	   ), 
	   array( '%d' ) 
        );
       return true;
       }
private static function update_wp_user_nachricht($id,$message){
      global $wpdb; 
      $table = $wpdb->prefix . 'art_user'; 
      $wpdb->update( 
	 $table, 
	 array( 
		'user_message' => $message,	// string
		'last_update' => current_time('mysql')	
	), 
	array( 'id' => $id ), 
	array( 
		'%s',
		'%s'
	), 
	array( '%d' ) 
    );
    }    
private static function update_wp_user_auswahl($id,$auswahl,$table){
        global $wpdb; 
        $wpdb->update( 
	   $table, 
	   array( 
		  'select_image' => $auswahl,
          'last_update' => current_time('mysql')
	   ), 
	   array( 'id' => $id ), 
	   array( 
		  '%s',
		  '%s'	
	   ), 
	   array( '%d' ) 
      );
        return true;
    }    
private static function update_wp_user_message($id,$message,$table){        
      global $wpdb; 
      $wpdb->update( 
	  $table, 
	  array( 
	    	'user_message' => $message,
		    'last_update' => current_time('mysql') 
	        ), 
      array( 'id' =>$id ), 
	  array( 
	    	'%s',
		    '%s'), 
	array( '%d' ) 
);
   }
private function update_wp_user_details(){
    global $wpdb;
    $wpdb->update( 
	$this->table, 
	array( 
		'settings' => $this->option['data'],
		'last_update' => current_time('mysql') 
	), 
	array( 'id' => $this->option['id'] ), 
	array( 
		'%s',
		'%s'
	), 
	array( '%d' ) 
);
    return true;
    }
 private function update_wp_posts_wpSeite()
    {
        global $wpdb;
        $wpdb->update( 
	    $this->table, 
	   array( 
		      'post_id' => $this->option['data'],
		      'last_update' => current_time('mysql') 
	        ), 
	           array( 'id' => $this->option['id'] ), 
	               array( 
		                  '%s',
		                  '%s'
	                   ), 
	                       array( '%d' ) 
        );
        return true;
}
private function update_wp_user_aktiv(){
        global $wpdb;
        $typ = $this->option['data']['typ'];   
        $wpdb->update( 
	    $this->table, 
	       array( 
		   $typ => $this->option['data']['htaccess_aktiv'],
		  'last_update' => current_time('mysql') 
	       ), 
	   array( 'id' => $this->option['data']['id'] ), 
	   array( 
		  '%s',
		  '%s'
	   ), 
	   array( '%d' ) 
        );
        return true;
    }    
  private function update_wp_user_new_passwort(){
        global $wpdb;
        $typ = $this->option['data']['typ'];  
        $wpdb->update( 
	    $this->table, 
	       array( 
		   $typ => $this->option['data']['htaccess_data'],
		  'last_update' => current_time('mysql') 
	       ), 
	   array( 'id' => $this->option['data']['id'] ), 
	   array( 
		  '%s',
		  '%s'
	   ), 
	   array( '%d' ) 
        );
        return true;
    }
   private function update_wp_user_kommentar(){
        global $wpdb;
        $wpdb->update( 
	    $this->table, 
	       array( 
		   'message' => $this->option['data']['message'],
		  'last_update' => current_time('mysql') 
	       ), 
	   array( 'id' => $this->option['data']['id'] ), 
	   array( 
		  '%s',
		  '%s'
	   ), 
	   array( '%d' ) 
        );
        return true;
    }
    private function new_wp_freigabe() {
       global $wpdb;   
       $wpdb->insert( 
	   $this->table, 
	   array( 
		'htaccess_id'     => $this->option['data']['htaccess_id'], 
		'galerie_id'      => $this->option['data']['galerie_id'],
        'htaccess_aktiv'  => $this->option['data']['htaccess_aktiv'],
        'galerie_typ'     => $this->option['data']['galerie_typ'],
        'settings'        => $this->option['data']['settings'],
        'last_update'     => current_time('mysql')   
	), 
	array( 
		'%d','%d','%d','%d','%s','%s' ));
       return $wpdb->insert_id;
  } 
     private function insert_wp_data_new_galerie(){
        global $wpdb;    
        $table = $wpdb->prefix . 'art_galerie';
        $wpdb->insert( 
    	$table, 
	    array( 
		'galerie_name' => $this->option['name'], 
		'beschreibung' => $this->option['beschreibung']
	    ), 
	     array( 
		'%s', 
		'%s' 
	    ) 
       );
        return $wpdb->insert_id;
    }
    private function new_wp_user($data){
        global $wpdb;    
        $table_name = $wpdb->prefix . 'art_user';
        $wpdb->insert( 
	   $table_name, 
	   array( 
        'htaccess_user'     => $data['username'],
		'htaccess_passwort' => $data['passwort'],
        'htaccess_vorname'  => $data['vorname'],
        'htaccess_nachname' => $data['nachname'],
        'htaccess_email'    => $data['email'],
        'email_aktiv'       => $data['email_aktiv'],
        'htaccess_aktiv'    => $data['user_aktiv'],
        'notiz'             => $data['notiz']   
	   ), 
	   array('%s','%s','%s','%s','%s','%d','%d','%s'));
        $neue_id = $wpdb->insert_id;
        if (!isset($neue_id)){
            $return = false;
        }else{
            $return = 'Benutzer: ' . $data['name'] . ' mit der ID:' . $neue_id . ' angelegt!';
        }
        return $return;
    }
   private static function delete_galerie_menue_user($galerie_name) {
        global $wpdb;
        $table_galerie = $wpdb->prefix .'art_galerie';
        $wpdb->delete( $table_galerie, array( 'galerie_name' => $galerie_name ), array( '%s' ) );
  }
 protected function user_wp_freigabe_start(){
    global $wpdb;
    $user        = $wpdb->prefix . 'art_user';
    $galerie     = $wpdb->prefix . 'art_galerie';
    $frei        = $wpdb->prefix . 'art_freigaben';
    $row = $wpdb->get_results( "SELECT $user.*,
                                     $frei.htaccess_aktiv as freigabe_aktiv,$frei.message,$frei.htaccess_id,$frei.last_update as freigabe_update,
                                     $frei.settings,$frei.id as freigabe_id,$frei.galerie_typ,$frei.select_image,
                                     $galerie.id as galerie_id,$galerie.galerie_name,$galerie.beschreibung,$galerie.created_at as galerie_date
                                   FROM $user
                                   LEFT JOIN $frei ON $user.id = $frei.htaccess_id
                                   LEFT JOIN $galerie ON $frei.galerie_id = $galerie.id
                                   WHERE $galerie.id = $frei.galerie_id
                                   ORDER BY $user.htaccess_user ASC
                                   " );
    $count = count($row);
    return array("data"=>$row,"count"=>$count);
 }
  protected function user_wp_freigabe_select(){
    global $wpdb;
    $user        = $wpdb->prefix . 'art_user';
    $galerie     = $wpdb->prefix . 'art_galerie';
    $frei        = $wpdb->prefix . 'art_freigaben';
    $where = $this->option['data']['where'];
    $typ = $this->option['data']['typ'];
    $row = $wpdb->get_results( $wpdb->prepare( 
	    "SELECT $user.*, 
	    $frei.htaccess_aktiv as freigabe_aktiv,
        $frei.settings,$frei.id as freigabe_id,$frei.galerie_typ,$frei.select_image,
        $galerie.id as galerie_id,$galerie.galerie_name
        FROM $user 
        LEFT JOIN $frei ON $user.id = $frei.htaccess_id
        LEFT JOIN $galerie ON $frei.galerie_id = $galerie.id
        WHERE $galerie.id = $frei.galerie_id and $where = %s", 
	    $typ
       ));  
    return array("data"=>$row,"count"=>count($row));
  }
 public function user_wp_freigabe_auswahl(){
    global $wpdb;
    $user        = $wpdb->prefix . 'art_user';
    $galerie     = $wpdb->prefix . 'art_galerie';
    $frei        = $wpdb->prefix . 'art_freigaben';
    $row = $wpdb->get_results( $wpdb->prepare( 
	    "SELECT $user.*, 
	     $frei.htaccess_aktiv as freigabe_aktiv,$frei.message,$frei.htaccess_id,$frei.last_update as freigabe_update,
         $frei.settings,$frei.id as freigabe_id,$frei.galerie_typ,$frei.select_image,
         $galerie.id as galerie_id,$galerie.galerie_name,$galerie.beschreibung
        FROM $user 
        LEFT JOIN $frei ON $user.id = $frei.htaccess_id
        LEFT JOIN $galerie ON $frei.galerie_id = $galerie.id
        WHERE $galerie.galerie_name = %s AND $frei.htaccess_id = %d", 
	    $this->option['data']['galerie_name'],$this->option['data']['htaccess_id']
       ));  
   return array("data"=>$row,"count"=>count($row));
 }
 public function user_wp_response(){
    global $wpdb;
    $user        = $wpdb->prefix . 'art_user';
    $galerie     = $wpdb->prefix . 'art_galerie';
    $frei        = $wpdb->prefix . 'art_freigaben';
    $image       = $wpdb->prefix . 'art_images';
         $row = $wpdb->get_results( $wpdb->prepare( 
	    "SELECT $user.*, 
	            $frei.htaccess_aktiv as freigabe_aktiv,$frei.message,$frei.htaccess_id,$frei.last_update as freigabe_update,
                $frei.settings,$frei.id as freigabe_id,$frei.galerie_typ,$frei.select_image,
                $galerie.id as galerie_id,$galerie.galerie_name,$galerie.beschreibung
         FROM $user 
         LEFT JOIN $frei ON $user.id = $frei.htaccess_id
         LEFT JOIN $galerie ON $frei.galerie_id = $galerie.id
         WHERE $frei.id = %d", 
	    $this->option['data']['freigabe_id']
       ));  
    return array("data"=>$row,"count"=>count($row));
 }
   private static function microtime_float(){
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
    }
   private static function clean_session(){
    $time_start = self::microtime_float();
    usleep(1);
    $time_end = self::microtime_float();
    $time = $time_end - $time_start;
    return $time;
    }
   private function is_session_started(){
    if (php_sapi_name() !== 'cli'){
    if (version_compare(phpversion(), '5.4.0', '>=')) {
    return session_status() === PHP_SESSION_ACTIVE ? true : false;
     }else{
     return session_id() === '' ? false : true;
     }
     }
     return false;
    }
 public function __destruct(){
        $this->return;
        $this->option;
    }
  private function exception($err){
   // Catch Expcetions from the above code for our Exception Handling
    $trace = '<table border="0">';
    foreach ($err->getTrace() as $a => $b) {
        foreach ($b as $c => $d) {
            if ($c == 'args') {
                foreach ($d as $e => $f) {
                    $trace .= '<tr><td><b>' . strval($a) . '#</b></td><td align="right"><u>args:</u></td> <td><u>' . $e . '</u>:</td><td><i>' . $f . '</i></td></tr>';
                }
            } else {
                $trace .= '<tr><td><b>' . strval($a) . '#</b></td><td align="right"><u>' . $c . '</u>:</td><td></td><td><i>' . $d . '</i></td>';
            }
        }
    }
    $trace .= '</table>';
        $log .=   '<br /><br /><br /><font face="Verdana"><center><fieldset style="width: 66%; border: 4px solid gray; background: white;"><legend><b>[</b>
                PHP PDO Error ' . strval($err->getCode()) . '<b>]</b></legend> <table border="0"><tr><td align="right"><b><u>Message:</u></b></td><td><i>' . $err->getMessage() . 
         '</i></td></tr><tr><td align="right"><b><u>Code:</u></b></td><td><i>' . strval($err->getCode()) .
          '</i></td></tr><tr><td align="right"><b><u>File:</u></b></td><td><i>' . $err->getFile() .
           '</i></td></tr><tr><td align="right"><b><u>Line:</u></b></td><td><i>' . strval($err->getLine()) .
            '</i></td></tr><tr><td align="right"><b><u>Trace:</u></b></td><td><br /><br />' . $trace .
             '</td></tr></table></fieldset></center></font>';
  new ArtLog($log);
  }
 }//endClassDbHandle     