<?php
/**
 * ArtPicture Plugin PHP Class
 * http://art-pictureDesign.de/WP-ArtTheme-Galerie
 * Copyright 2017, Jens Wiecker
 * https://art-picturedesign.de
 *
 */
if ( ! defined( 'ABSPATH' ) ) exit;
require_once('db/class_db_handle.php');
require_once('ApgSettings.php');
use  APG\ArtPictureGallery\DbHandle as DbHandle;
use  APG\ArtPictureGallery\ApgSettings as ApgSettings;
class ArtPictureZufallWidget extends WP_Widget {
	function __construct() {
		// Instantiate the parent object
		parent::__construct( false, 'Art-Picture Random Image' );
}
	function widget( $args, $instance ) {
	 extract($args, EXTR_SKIP);
    $header      = empty($instance['header'])      ? ' ' : apply_filters('widget_title', $instance['header']);
    $galerie     = empty($instance['galerie'])     ? ''  : $instance['galerie'];
    $imgname     = empty($instance['imgname'])     ? ''  : $instance['imgname'];
    $format      = empty($instance['format'])      ? ''  : $instance['format'];
    $galerieName = empty($instance['galerieName']) ? ''  : $instance['galerieName'];
    $galerieAlle = empty($instance['galerieAlle']) ? ''  : $instance['galerieAlle'];    
        
    $settings = ApgSettings::load_settings('user_settings');    
    echo (isset($before_widget)?$before_widget:'');
    if (!empty($header)){
        $head =  $header;
    }else{
        $head = '';
    }
      echo $before_title . $head . $after_title;
    if (!empty($galerie) && empty($galerieAlle) ){
        global $wpdb;
        $table_name = $wpdb->prefix .'art_images';
        $row = $wpdb->get_results( $wpdb->prepare(
        "SELECT *
        FROM  ".$table_name." 
        where galerie_name = %s  ORDER BY rand() LIMIT %d ", 
        $galerie, 1 ));
         if($format == '1'){
           $image = $row[0]->thumbnailUrl;
           $offset = '2'; 
         }
         if($format == '2'){
            $image = $row[0]->mediumUrl;
            $offset = '1';
         }
         if(!empty($galerieName)){
            $galName = '<h4 class="grey"> '. $row[0]->galerie_name.'</h4>';
         }else{
            $galName = '';
         }
        if(!empty($imgname)){
        $bildname = '<i class="grey"><small>'. $row[0]->name.'</small></i>';
       }else{
        $bildname ='';
        }
        if(empty($settings['wp_settings_img_details'])){
        $out = '<div class="bootstrap-wrapper">
              <br><div class="row">
              <div class="col-xs-10 col-xs-offset-'.$offset.' col-md-10 col-md-offset-'.$offset.'">
              '.$galName.'
              <a data-gallery="" href="'.$row[0]->url.'" titel="'.$row[0]->name.'" target="_blank" >  <img src="'.$image.'" alt="'.$row[0]->name.'"></a>
              <br>'.$bildname.'</div><br>
              </div>';   
        }else{
       $out ='<div class="bootstrap-wrapper">
              <br><div class="row">
              <div class="col-xs-10 col-xs-offset-'.$offset.' col-md-10 col-md-offset-'.$offset.'">
              '.$galName.'
              <a href="?apg-user-gallery-template=12067114&id='.$row[0]->id.'"titel="'.$row[0]->name.'" >  <img src="'.$image.'" alt="'.$row[0]->name.'"></a>
              <br>'.$bildname.'</div><br>
              </div>';
        }
        echo $out;                    
   }else{
        global $wpdb;
        $table_name = $wpdb->prefix .'art_images';
        $row = $wpdb->get_results( $wpdb->prepare(
        "SELECT *
        FROM  ".$table_name." 
        ORDER BY rand() LIMIT %d ", 
         1 ));
         if($format == '1'){
           $image = $row[0]->thumbnailUrl;
           $offset = '2'; 
         }
         if($format == '2'){
            $image = $row[0]->mediumUrl;
            $offset = '1';
         }
         if(!empty($galerieName)){
            $galName = '<h4 class="grey"> '. $row[0]->galerie_name.'</h4>';
         }else{
            $galName = '';
         }
        if(!empty($imgname)){
        $bildname = '<i class="grey"><small>'. $row[0]->name.'</small></i>';
       }else{
        $bildname ='';
        }
        if(empty($settings['wp_settings_img_details'])){
        $out = '<div class="bootstrap-wrapper">
              <br><div class="row">
              <div class="col-xs-10 col-xs-offset-'.$offset.' col-md-10 col-md-offset-'.$offset.'">
              '.$galName.'
              <a data-gallery href="'.$row[0]->url.'" titel="'.$row[0]->name.'" target="_blank" >  <img src="'.$image.'" alt="'.$row[0]->name.'"></a>
              <br>'.$bildname.'</div><br>
              </div>';   
        }else{
       $out ='<div class="bootstrap-wrapper">
              <br><div class="row">
              <div class="col-xs-10 col-xs-offset-'.$offset.' col-md-10 col-md-offset-'.$offset.'">
              '.$galName.'
              <a href="?apg-user-gallery-template=12067114&id='.$row[0]->id.'"titel="'.$row[0]->name.'" >  <img src="'.$image.'" alt="'.$row[0]->name.'"></a>
              <br>'.$bildname.'</div><br>
              </div>';
        }
        echo $out; 
    }
    // After widget code, if any  
    echo '<br></div>';
    echo (isset($after_widget)?$after_widget:'');
	}
	function update( $new_instance, $old_instance ) {
	 $instance = $old_instance;
     $instance['galerieName'] = $new_instance['galerieName'];
     $instance['galerieAlle'] = $new_instance['galerieAlle'];    
     $instance['galerie']     = $new_instance['galerie'];
     $instance['format']      = $new_instance['format'];
     $instance['header']      = $new_instance['header'];
     $instance['imgname']     = $new_instance['imgname'];
      
    return $instance;
	}
function form( $instance ) {
     $instance = wp_parse_args( (array) $instance, array(
      'title' => 'Random Image',
       ) );
     $galerieName = ( isset( $instance['galerieName'] )&& is_numeric( $instance['galerieName'] ) ) ? (int)$instance['galerieName']  : '';
     $galerieAlle = ( isset( $instance['galerieAlle'] )&& is_numeric( $instance['galerieAlle'] ) ) ? (int)$instance['galerieAlle']  : '';
     $galerie     = ( isset( $instance['galerie'] )    && is_string( $instance['galerie'] ) )  ? esc_attr($instance['galerie']) : '';
     $header      = ( isset( $instance['header'] )     && is_string( $instance['header'] ) )   ? esc_attr($instance['header'])  : 'Random Image';
     $imgname     = ( isset( $instance['imgname'] )    && is_numeric( $instance['imgname'] ) ) ? (int) $instance['imgname']     : ''; 
     $format      = ( isset( $instance['format'] )     && is_numeric( $instance['format'] ) )  ? (int) $instance['format']      : 1; 

     ?>
      <p>
      <label for="<?php echo $this->get_field_id('header'); ?>"><b>Heading:</b> 
       <input class="widefat" id="<?php echo $this->get_field_id('header'); ?>" 
              name="<?php echo $this->get_field_name('header'); ?>" type="text" 
              value="<?php echo attribute_escape($header); ?>" />
      </label>
      </p>
     <p>
      <label for="<?php echo $this->get_field_id('galerie'); ?>"><b>Select Gallery:</b><br />
      <select class='widefat' id="<?php echo $this->get_field_id('galerie'); ?>"
              name="<?php echo $this->get_field_name('galerie'); ?>" type="text">
          <?php
            $a1 = array("method"   =>"read_wp_db",
                        "table"    =>"art_galerie",
                        "select"   =>" *" );
                             
            $dat1 = new DbHandle($a1);
            $gal=$dat1->return;
            foreach($gal['data'] as $tmp)
            {
          if($galerie == $tmp->galerie_name){
            $sel =  " selected='selected' ";
          }else{
            $sel = "";
          }
          $select .='<option value="'.$tmp->galerie_name.'" '.$sel.'> '.$tmp->galerie_name.'</option>';
          }
          echo $select;
          ?>      
        </select>                
      </label>
     </p>
      <p>
     <input id="<?php echo esc_attr( $this->get_field_id( 'galerieAlle' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'galerieAlle' ) ); ?>" type="checkbox" value="1" <?php checked( '1', $galerieAlle ); ?> />
     <label for="<?php echo esc_attr( $this->get_field_id( 'galeriAlle' ) ); ?>"><b>Alle Galerien</b></label>
     </p> 
     <hr />
          <p>
            <legend><b>Image Size:</b></legend>
                <input type="radio" id="<?php echo ($this->get_field_id( 'format' ) . '-1') ?>" name="<?php echo ($this->get_field_name( 'format' )) ?>" value="1" <?php checked( $format == 1, true) ?>>
                <label for="<?php echo ($this->get_field_id( 'format' ) . '-1' ) ?>"><b><?php _e('Thumbnail Image') ?></b></label> <br />
                <input type="radio" id="<?php echo ($this->get_field_id( 'format' ) . '-2') ?>" name="<?php echo ($this->get_field_name( 'format' )) ?>" value="2" <?php checked( $format == 2, true) ?>>
                <label for="<?php echo ($this->get_field_id( 'format' ) . '-2' ) ?>"><b><?php _e('Medium Image') ?></b></label> <br />
            </p>
            <hr />
          <p>
     <input id="<?php echo esc_attr( $this->get_field_id( 'galerieName' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'galerieName' ) ); ?>" type="checkbox" value="1" <?php checked( '1', $galerieName ); ?> />
     <label for="<?php echo esc_attr( $this->get_field_id( 'galerieName' ) ); ?>"><b>Show Gallery Name</b></label>
     </p>       
     <p>
     <input id="<?php echo esc_attr( $this->get_field_id( 'imgname' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'imgname' ) ); ?>" type="checkbox" value="1" <?php checked( '1', $imgname ); ?> />
     <label for="<?php echo esc_attr( $this->get_field_id( 'imgname' ) ); ?>"><b>Show Picture Name</b></label>
    </p>
     <hr />
     <?php 
  }
}
function art_picture_register_zufall_widgets() {
	register_widget( 'ArtPictureZufallWidget' );
}
add_action( 'widgets_init', 'art_picture_register_zufall_widgets' );
?>