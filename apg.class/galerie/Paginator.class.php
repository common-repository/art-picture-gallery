<?php
namespace APG\ArtPictureGallery;

class AdminPaginator {
 
     private $_conn;
        private $_limit;
        private $_pagpage;
        private $_total;
        private $_galerie;
        private $_typ;
        private $_galerieUrl;
        private $_pos;
        
        
 public function __construct($galerie,$limit,$typ,$page,$url,$pos ) {

    $this->_galerie    = (string)$galerie;
    $this->_total      = (int)$this->getCount();
    $this->_typ        = (int)$typ;
    $this->_limit      = (int)$limit;
    $this->_pagpage    = (int)$page;
    $this->_galerieUrl = (string)$url;
    $this->_pos        = $pos;

} 

public function createLinks( $links, $list_class ) {
  
    $last       = ceil( $this->_total / $this->_limit );
 
    $start      = ( ( $this->_pagpage - $links ) > 0 ) ? $this->_pagpage - $links : 1;
    $end        = ( ( $this->_pagpage + $links ) < $last ) ? $this->_pagpage + $links : $last;
 
    $html       = '<ul class="' . $list_class . '">';
 
    $class      = ( $this->_pagpage == 1 ) ? "disabled" : "";
    if($class == 'disabled'){
    $html       .= '<li class="' . $class . '"><a>&laquo;</a></li>';    
    }else{
    $html       .= '<li class="' . $class . '"><a href="'.$this->_galerieUrl.$this->_pos.'limit=' . $this->_limit . '&pagpage=' . ( $this->_pagpage - 1 ) . '">&laquo;</a></li>';    
    }
    if ( $start > 1 ) {
        $html   .= '<li><a href="'.$this->_galerieUrl.$this->_pos.'limit=' . $this->_limit . '&pagpage=1">1</a></li>';
        $html   .= '<li class="disabled"><span>...</span></li>';
    }
    for ( $i = $start ; $i <= $end; $i++ ) {
      
        $class  = ( $this->_pagpage == $i ) ? "active" : "";
        $html   .= '<li class="' . $class . '"><a href="'.$this->_galerieUrl.$this->_pos.'limit=' . $this->_limit . '&pagpage=' . $i . '">' . $i . '</a></li>';
    }
    if ( $end < $last ) {
        $html   .= '<li class="disabled"><span>...</span></li>';
        $html   .= '<li><a href="'.$this->_galerieUrl.$this->_pos.'limit=' . $this->_limit . '&pagpage=' . $last . '">' . $last . '</a></li>';
    }
 
    $class      = ( $this->_pagpage == $last ) ? "disabled" : "";
    if($class == 'disabled'){
    $html       .= '<li class="' . $class . '"><a>&raquo;</a></li>';    
    }else{
    $html       .= '<li class="' . $class . '"><a href="'.$this->_galerieUrl.$this->_pos.'limit=' . $this->_limit . '&pagpage=' . ( $this->_pagpage + 1 ) . '">&raquo;</a></li>';    
    }
   
 
    $html       .= '</ul>';
 
    return $html;
}
    
public function getData(){

     global $wpdb;
    $table_name = $wpdb->prefix .'art_images';
    $row = $wpdb->get_results( $wpdb->prepare(
    "SELECT *
    FROM  ".$table_name." 
    where galerie_name = %s LIMIT %d , %d ", 
    $this->_galerie,
    ($this->_pagpage - 1) * $this->_limit,
    $this->_limit  ));
    
    $result         = new \stdClass();
    $result->page   = $this->_page;
    $result->limit  = $this->_limit;
    $result->total  = $this->_total;
    $result->data   = $row;
    return $result;
}    
    
public function getAll() {
   global $wpdb;    
   $table_name = $wpdb->prefix . 'art_images';
    $row = $wpdb->get_results( $wpdb->prepare( 
	"	SELECT * 
		FROM $table_name
		WHERE galerie_name = %s
	", 
	$this->_galerie
   ));
   $result         = new \stdClass();
   $result->data   = $row;
   return $result ;   
 } 

public function getCount(){
        global $wpdb;
        $table_name = $wpdb->prefix . 'art_images';
        $galCount = $wpdb->get_results( $wpdb->prepare( 
	   "SELECT * 
		FROM  $table_name 
		WHERE galerie_name = %s", 
	    $this->_galerie
       ) );
        $count = count($galCount);
        return $count;
    } //END getCount      
 
}

