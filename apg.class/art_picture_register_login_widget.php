<?php
/**
 * ArtPicture Plugin PHP Class
 * http://art-pictureDesign.de/WP-ArtTheme-Galerie
 * Copyright 2017, Jens Wiecker
 * https://art-picturedesign.de
 *
 */
if ( ! defined( 'ABSPATH' ) ) exit;
class ArtPictureLoginWidget extends WP_Widget {
	function __construct() {
		// Instantiate the parent object
		parent::__construct( false, 'Art-Picture Gallery Login' );
	}
	function widget( $args, $instance ) {
	extract($args, EXTR_SKIP);
    $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
    $header = empty($instance['header']) ? ' ' : $instance['header'];
    echo (isset($before_widget)?$before_widget:'');
  
      $bef =  $before_title . '<b style="color:#999;"><span class="fa fa-lock"></span> Gallery Login</b>' . $after_title;
        if (!empty($header))
      $head = '<b style="color:#666;">'.$header.'</b>';
      $eingabe = '<div class="bootstrap-wrapper">
      '.$bef.'
      '.$head.'
     <form class="form-inline"method="post" action="?apg-user-gallery-template=12067103">
     <p>
     <div class="form-group">
     <label for="eingabefeldbn" class="sr-only">Benutzername</label>
     <input type="text" class="form-control" name="name" placeholder="Benutzername"autocomplete="new-password"required>
     </div>
     </p>
     <p>  
     <div class="form-group">
     <label for="eingabefeldPasswort2" class="sr-only">Passwort</label>
     <input type="password" class="form-control" name="passwort"autocomplete="new-password" placeholder="Passwort"required>
     </div>
     </p>
     <p>
     <button type="submit" name="gesendet" class="btn btn-primary btn-outline"><span class="fa  fa-lock"></span> Login</button>
     </p>
     </form>
     </div>';
     echo $eingabe; 
     echo (isset($after_widget)?$after_widget:''); 
	}

	function update( $new_instance, $old_instance ) {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
    $instance['header'] = $new_instance['header'];
    return $instance;
	}

	function form( $instance ) {
			 global $wpdb;
                // Defaults
                $instance = wp_parse_args( 
                	(array) $instance, array(
                    	'title' => 'Login',
                    	'header' => 'Galerie Login'
                  ) 
                );
                // Values
                $title  = ( isset( $instance['title'] )    && is_string( $instance['title'] ) )  ? esc_attr($instance['title']) : '';
                $header = ( isset( $instance['header'] )   && is_string( $instance['header'] ) )  ? esc_attr($instance['header']) : 'Gallery Login';
              ?>
                <p>
       <label for="<?php echo $this->get_field_id('header'); ?>"><b> Login Heading:</b><br />
       <input class="widefat" id="<?php echo $this->get_field_id('header'); ?>" 
              name="<?php echo $this->get_field_name('header'); ?>" type="text" 
              value="<?php echo attribute_escape($header); ?>" />
      </label>
      </p>

                
<?php
	}
}

function art_picture_register_login_widgets() {
	register_widget( 'ArtPictureLoginWidget' );
}

add_action( 'widgets_init', 'art_picture_register_login_widgets' );

?>