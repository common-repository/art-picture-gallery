<?php
/**
 * ArtPicture Plugin PHP Class
 * http://art-pictureDesign.de/WP-ArtTheme-Galerie
 * Copyright 2017, Jens Wiecker
 * https://art-picturedesign.de
 *
 */

require_once(dirname(__DIR__).'/apg.class/ApgSettings.php');
use  APG\ArtPictureGallery\DbHandle as DbHandle;
use  APG\ArtPictureGallery\ApgSettings as ApgSettings;
if ( ! defined( 'ABSPATH' ) ) exit;
class art_picture_widget extends WP_Widget {
	function art_picture_widget() {
	parent::__construct( false, 'Art-Picture Gallery' );
	}
	function widget( $args, $instance ) {
        extract($args, EXTR_SKIP);
        $header = empty($instance['header']) ? ' ' : apply_filters('widget_title', $instance['header']);
        $head = empty($instance['head']) ? ' ' : $instance['head'];
        $galerie = empty($instance['galerie']) ? '' : $instance['galerie'];
        $anzahl = empty($instance['anzahl']) ? '' : $instance['anzahl'];
        $random = empty($instance['random']) ? '' : $instance['random'];
        $alle = empty($instance['alle']) ? '' : $instance['alle'];
        if(!empty($random)){
        $rand = 'ORDER BY rand()';   
        }else{
        $rand = '';
       }
        $settings = ApgSettings::load_settings('user_settings');
        echo (isset($before_widget)?$before_widget:'');
    if (!empty($header))
      echo $before_title . $header . $after_title;
    if (!empty($galerie) && empty($alle)){
         global $wpdb;
        $table_name = $wpdb->prefix .'art_images';
        $row = $wpdb->get_results( $wpdb->prepare(
        "SELECT *
        FROM  ".$table_name." 
        where galerie_name = %s $rand LIMIT %d ", 
        $galerie, $anzahl ));
    $out_head ='<div class="bootstrap-wrapper">
                <div id="grid"><div id="grid-sizer" style="width: 20%;"></div>';        
    $out_foot ='</div>'.$template_footer.apg_bluemGallery_select();
    if(!empty($head)){
        echo ' <b style="color:#666;">'.$head.' <b><br>';
    }
   $galerie_name = substr($row[0]->galerie_name,0,15).$gn;
    echo '<br>';
    foreach($row as $tmp) {
    if(empty($settings['wp_settings_img_details'])){
    $out_body .= ' <a data-gallery="" href = "'.$tmp->url.'" title="'.$tmp->name.'" target="_blank">
                   <div id="grid-item" style="width: 20%;">
                   <img src="'.$tmp->thumbnailUrl.'" />
                   </div></a>';   
    }else{
    $out_body .= ' <a href = "?apg-user-gallery-template=12067114&id='.$tmp->id.'">
                   <div id="grid-item" style="width: 20%;">
                   <img src="'.$tmp->thumbnailUrl.'" />
                   </div></a>';
    }
    }
    $out = $out_head . $out_body . $out_foot;
    $out = preg_replace(array('/<!--(.*)-->/Uis',"/[[:blank:]]+/"),array('',' '),str_replace(array("\n","\r","\t"),'',$out));
    echo $out;
   }else{
        global $wpdb;
        $table_name = $wpdb->prefix .'art_images';
        $row = $wpdb->get_results( $wpdb->prepare(
        "SELECT *
        FROM  ".$table_name." 
        ORDER BY rand() LIMIT %d ", 
        $anzahl ));
    $out_head ='<div class="bootstrap-wrapper">
                <div id="grid"><div id="grid-sizer" style="width: 20%;"></div>';        
    $out_foot ='</div>'.$template_footer.apg_bluemGallery_select();
    if(!empty($head)){
        echo ' <b style="color:#666;">'.$head.' <b><br>';
    }
   $galerie_name = substr($row[0]->galerie_name,0,15).$gn;
    echo '<br>';
    foreach($row as $tmp) {
    if(empty($settings['wp_settings_img_details'])){
    $out_body .= ' <a data-gallery="" href = "'.$tmp->url.'" title="'.$tmp->name.'" target="_blank">
                   <div id="grid-item" style="width: 20%;">
                   <img src="'.$tmp->thumbnailUrl.'" />
                   </div></a>';   
    }else{
    $out_body .= ' <a href = "?apg-user-gallery-template=12067114&id='.$tmp->id.'">
                   <div id="grid-item" style="width: 20%;">
                   <img src="'.$tmp->thumbnailUrl.'" />
                   </div></a>';
    }
    }
    $out = $out_head . $out_body . $out_foot;
    $out = preg_replace(array('/<!--(.*)-->/Uis',"/[[:blank:]]+/"),array('',' '),str_replace(array("\n","\r","\t"),'',$out));
    echo $out;    
        
    }
    ///////////////////////////////////////////////////////////////////
    echo '</div>';
    // After widget code, if any  
    echo (isset($after_widget)?$after_widget:'');
	}
public function update( $new_instance, $old_instance ) {
    $instance = $old_instance;
    $instance['title']   = $new_instance['title'];
    $instance['header']  = $new_instance['header'];
    $instance['head']    = $new_instance['head'];
    $instance['galerie'] = $new_instance['galerie'];
    $instance['anzahl']  = $new_instance['anzahl'];
    $instance['random']  = $new_instance['random'];
    $instance['alle']    = $new_instance['alle'];
    return $instance;
	}
public function form( $instance ) {
     $instance = wp_parse_args( (array) $instance, array(
      'title' => 'Art-Picture Galerie',
      'header'=>'Übeschrift',
      'head' => 'Titel' ) );
     $title    = ( isset( $instance['title'] )   && is_string( $instance['title'] ) )  ? esc_attr($instance['title'])   : '';
     $header   = ( isset( $instance['header'] )  && is_string( $instance['header'] ) ) ? esc_attr($instance['header'])  : 'Art-Picture Galerie';
     $head     = ( isset( $instance['head'] )    && is_string( $instance['head'] ) )   ? esc_attr($instance['head'])    : 'Example Gallery';
     $galerie  = ( isset( $instance['galerie'] ) && is_string( $instance['galerie'] ) )? esc_attr($instance['galerie']) : '';
     $anzahl   = ( isset( $instance['anzahl'] )  && is_numeric( $instance['anzahl'] ) )? (int) $instance['anzahl']      : '';
     $random   = ( isset( $instance['random'] )  && is_numeric( $instance['random'] ) )? (int) $instance['random']      : '';
     $alle   = ( isset( $instance['alle'] )  && is_numeric( $instance['alle'] ) )? (int) $instance['alle']      : '';
     ?>
     <p>
      <label for="<?php echo $this->get_field_id('header'); ?>"><b>Heading:</b> 
       <input class="widefat" id="<?php echo $this->get_field_id('header'); ?>" 
              name="<?php echo $this->get_field_name('header'); ?>" type="text" 
              value="<?php echo attribute_escape($header); ?>" />
      </label>
      </p>
      <p>
     <label for="<?php echo $this->get_field_id('head'); ?>"><b>Title:</b> 
       <input class="widefat"  id="<?php echo $this->get_field_id('head'); ?>" 
              name="<?php echo $this->get_field_name('head'); ?>" type="text" 
              value="<?php echo attribute_escape($head); ?>" />
      </label>
      </p>

     <p>
      <label for="<?php echo $this->get_field_id('galerie'); ?>"><b>Select Gallery:</b> 
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
      <label for="<?php echo $this->get_field_id('anzahl'); ?>"><b>Number of Pictures:</b> 
      <select class='widefat' id="<?php echo $this->get_field_id('anzahl'); ?>"
        name="<?php echo $this->get_field_name('anzahl'); ?>" type="text">
        <option value='10' <?php echo  ($anzahl=='10')?'selected':''; ?>> 10 </option>  
        <option value='25' <?php echo  ($anzahl=='25')?'selected':''; ?>> 25 </option> 
        <option value='35' <?php echo  ($anzahl=='35')?'selected':''; ?>> 35 </option> 
        <option value='50' <?php echo  ($anzahl=='50')?'selected':''; ?>> 50 </option> 
        <option value='100'<?php echo ($anzahl=='100')?'selected':''; ?>> 100 </option>    
      </select>                
      </label>
     </p>
     <p>
     <input id="<?php echo esc_attr( $this->get_field_id( 'random' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'random' ) ); ?>" type="checkbox" value="1" <?php checked( '1', $random ); ?> />
     <label for="<?php echo esc_attr( $this->get_field_id( 'random' ) ); ?>"><b>Zufall</b></label>
    </p>

     <p>
     <input id="<?php echo esc_attr( $this->get_field_id( 'alle' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'alle' ) ); ?>" type="checkbox" value="1" <?php checked( '1', $alle ); ?> />
     <label for="<?php echo esc_attr( $this->get_field_id( 'alle' ) ); ?>"><b>Alle Galerien</b></label>
    </p>
     <?php 
  }
}
function art_picture_widgets() {
	register_widget( 'art_picture_widget' );
}
add_action( 'widgets_init', 'art_picture_widgets' );

?>