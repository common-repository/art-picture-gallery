<?php 
/*
Plugin Name: Art-Picture-Gallery
Plugin URI: https://wordpress.org/plugins/art-picture-gallery/
Description: <strong> Art-Picture-Gallery </strong> ist ein Custom Gallery Plugin für Wordpress mit verschiedenen Layouts und Benutzer Freigabe Funktion. Freigegebene Benutzer können einzelne Bilder auswählen oder ein Kommentar schreiben. Alle gewählten Bilder oder Kommentare sehen Sie in einer Übersicht. <strong> Art-Picture-Gallery </strong> besitzt ein Benutzer Template mit <strong> Login </strong> Funktion. 
Version: 1.2.9
Text Domain: Art-Picture-Gallery
Author: Jens Wiecker
Author URI: https://art-picturedesign.de
License: GPL3
*/
/*  Copyright 2018 Jens Wiecker (email: info@art-picturedesign.de)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 3, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
class Art_Pictue_Galeries {

//ACTIVATE-EXECUTE    
public function execute(){
        register_activation_hook( __FILE__, array($this,'activate'));
        add_action( 'admin_menu',  array($this, 'register_admin_menu' ) );
        add_action( 'wp_ajax_add_apgHandle',  array($this, 'prefix_ajax_add_apgHandle' ) );
        add_action( 'wp_ajax_nopriv_add_apgGalleryTemplate',  array($this, 'prefix_ajax_add_apgGalleryTemplate' ) );   
        add_action( 'admin_enqueue_scripts',  array($this, 'register_art_picture_styles' ) );
        add_action( 'wp_enqueue_scripts',  array($this, 'register_art_picture_templates_styles' ) );
        add_action( 'phpmailer_init',  array($this, 'apg_mailer_phpmailer_configure' ) );
        add_action( 'plugins_loaded',  array($this, 'art_picture_constanten' ) );
        add_action( 'plugins_loaded',  array($this, 'art_picture_gallery_hooks' ) );
        add_filter( 'wp_mail_content_type',  array($this, 'set_apg_html_content_type' ) );
        add_action( 'plugins_loaded', array($this, 'apg_template_ArtPictureFilters' ) );
        add_action( 'plugins_loaded', array($this, 'art_picture_widget' ) );
        add_action( 'plugins_loaded', array($this, 'art_picture_register_login_widget' ) );
        add_action( 'plugins_loaded', array($this, 'art_picture_register_zufall_widget' ) );
        add_action( 'plugins_loaded', array($this, 'artPictureGalerie_update_db' ) );
        add_action( 'plugins_loaded', array($this, 'maybe_self_deactivate' ) );
        add_action( 'admin_init', array($this, 'redirect_about_page' ), 1 );
        add_action( 'init', array($this, 'register_post_types' ) );
        add_action( 'init', array($this, 'artPicture_metbox' ) );
        add_action( 'init', array($this, 'artPicture_ansicht' ) );
}//execute ENDE
    
//ACTIVATE-HOOK
public function activate() {
        $this->artPictureGalerie_create_db();
        $this->check_dependencies();
        $this->init_options();
        $this->register_post_types();
        flush_rewrite_rules();
        $this->activate_about_page();
}//activate ENDE

//REGISTER MENU
public function register_admin_menu() {
               add_plugins_page( 'About Art Picture Galerie', 'About A.P.G',
                      'manage_options', 
                      'about-art-picture-galerie', 
                      array( $this, 'display_about_page' ) );
$hook_suffix = add_menu_page( __('artPictures','artPicture-starts'),
                   __('Art Picture Gallery', 'artPicture-starts'),
                      'manage_options',
                      'wp-artPictures',
                      array($this, 'art_pictures_startseite'),
                      plugins_url('assets/images/dashicon/art-picture-btn64_sm.png', __FILE__,'2.1'  ));
                      add_action( 'load-' . $hook_suffix, array($this, 'apg_load_ajax_start_script' ) );
$hook_suffix = add_submenu_page( 'wp-artPictures', 
                   __('art-Picture-new',
                      'art-Picture-new'),
                   __('Image Upload', 'artPicture-new'),
                      'manage_options',
                      'art-Picture-new',
                      array ($this,'art_galerie_erstellen' ));
                      add_action( 'load-' . $hook_suffix, array($this, 'apg_load_ajax_upload_script' ) );
$hook_suffix = add_submenu_page( 'wp-artPictures',
                   __('art-Picture-user',
                      'art-Picture-user'),
                   __('Galerie Benutzer', 'artPicture-user'),
                      'manage_options',
                      'art-Picture-user'
                      ,array ($this,'art_benutzer_page' ));
                      add_action( 'load-' . $hook_suffix, array($this, 'apg_load_ajax_benutzer_script' ) );
$hook_suffix =  add_submenu_page( 'wp-artPictures',
                   __('art-Picture-response',
                      'art-Picture-response'),
                   __('Galerie Response', 'artPicture-response'),
                      'manage_options',
                      'art-Picture-reponse',
                      array ($this,'art_response_page' ));
                      add_action( 'load-' . $hook_suffix, array($this, 'apg_load_ajax_response_script' ) );
$hook_suffix = add_submenu_page( 'wp-artPictures',
                   __('art-Picture-settings',
                      'art-Picture-settings'),
                   __('Settings', 'artPicture-settings'),
                      'manage_options',
                      'art-Picture-settings',
                       array ($this,'art_galerie_settings' )); 
                       add_action( 'load-' . $hook_suffix, array($this, 'apg_load_ajax_settings_script' ) );
$hook_suffix = add_submenu_page( 'wp-artPictures',
                   __('art-Picture-hilfe',
                      'art-Picture-hilfe'),
                   __('Help', 'artPicture-hilfe'),
                      'manage_options',
                      'art-Picture-help',
                       array ($this,'art_galerie_help' )); 
                       add_action( 'load-' . $hook_suffix, array($this, 'load_help_script' ) );
add_submenu_page( 'wp-artPictures',
                   __('art-Picture-pro',
                      'art-Picture-pro'),
                   __('Galerie <b class="art_submenue"> Upgrade ➤</b>', 'artPicture-pro'),
                      'manage_options',
                      'art-Picture-pro',
                       array ($this,'art_galerie_pro' )); 
}
//PHPMailer
public function apg_mailer_phpmailer_configure( PHPMailer $phpmailer ){
        require_once('apg.class/ApgSettings.php');
        $settings = APG\ArtPictureGallery\ApgSettings::load_settings('user_settings');
        global $apg_user_info;
        $apg_user_info = get_userdata(get_current_user_id());
        if($settings['gmail_SMTPAuth'] == '1'){
        $SMTPAuth = true;
        }else{
        $SMTPAuth = false;   
        }
        if(empty($apg_user_info->first_name) && empty($apg_user_info->last_name)){
        $apg_from_name = 'Art-Picture Gallery';    
        }else{
        $apg_from_name = $apg_user_info->first_name .  ' ' . $apg_user_info->last_name . ' (Art-Picture Gallery)';   
        }
        $phpmailer->isSMTP(); 
        $phpmailer->Host       = $settings['gmail_host'];
        $phpmailer->SMTPAuth   = $SMTPAuth;
        $phpmailer->Port       = $settings['gmail_smtp'];
        $phpmailer->Username   = $settings['gmail_Username'];
        $phpmailer->Password   = $settings['gmail_Password'];
        $phpmailer->SMTPSecure = $settings['gmail_SMTPSecure'];
        $phpmailer->From       = $apg_user_info->user_email;
        $phpmailer->FromName   = $apg_from_name;
        $phpmailer->CharSet    = "utf-8";
}
public function set_apg_html_content_type() {
return 'text/html';
}
//LOAD AJAX
public function apg_load_ajax_start_script(){
       wp_enqueue_script( 'ajax-script',
       plugins_url( '/js/art-picture-app.js', __FILE__ ),
       array( 'jquery' )
       );
       $title_nonce = wp_create_nonce( 'title_apg_handle' );
       wp_localize_script( 'ajax-script', 'apg_ajax_obj', array(
       'ajax_url' => admin_url( 'admin-ajax.php' ),
       'nonce'    => $title_nonce,
    ) );
}
public function apg_load_ajax_upload_script(){
       wp_enqueue_script( 'ajax-script',
       plugins_url( '/js/art_picture_upload.js', __FILE__ ),
       array( 'jquery' )
       );
       $title_nonce = wp_create_nonce( 'title_apg_handle' );
       wp_localize_script( 'ajax-script', 'apg_ajax_obj', array(
       'ajax_url' => admin_url( 'admin-ajax.php' ),
       'nonce'    => $title_nonce,
    ) );
}
public function apg_load_ajax_benutzer_script(){
       wp_enqueue_script( 'ajax-script',
       plugins_url( '/js/art_picture_user_site.js', __FILE__ ),
       array( 'jquery' )
       );
       $title_nonce = wp_create_nonce( 'title_apg_handle' );
       wp_localize_script( 'ajax-script', 'apg_ajax_obj', array(
       'ajax_url' => admin_url( 'admin-ajax.php' ),
       'nonce'    => $title_nonce,
    ) );
}
public function apg_load_ajax_response_script(){
       wp_enqueue_script( 'ajax-script',
       plugins_url( '/js/art_picture_response_script.js', __FILE__ ),
       array( 'jquery' )
       );
       $title_nonce = wp_create_nonce( 'title_apg_handle' );
       wp_localize_script( 'ajax-script', 'apg_ajax_obj', array(
       'ajax_url' => admin_url( 'admin-ajax.php' ),
       'nonce'    => $title_nonce,
       ));
}
public function apg_load_ajax_settings_script(){
       wp_enqueue_script( 'ajax-script',
       plugins_url( '/js/art_picture_settings_script.js', __FILE__ ),
       array( 'jquery' )
       );
       $title_nonce = wp_create_nonce( 'title_apg_handle' );
       wp_localize_script( 'ajax-script', 'apg_ajax_obj', array(
       'ajax_url' => admin_url( 'admin-ajax.php' ),
       'nonce'    => $title_nonce,
    ) );
}
//AJAX HANDLE    
public function prefix_ajax_add_apgHandle() {
	   check_ajax_referer( 'title_apg_handle' );
       require_once('ajax/ajax-handler.php');
       wp_send_json( apgArtPictureAjaxHandel()); 
}
//AJAX NOPRIV HANDLE     
public function prefix_ajax_add_apgGalleryTemplate(){
  	   check_ajax_referer( 'title_apg_handle' );
       require_once('ajax/ajax-handler.php');
       wp_send_json( apgArtPictureAjaxHandel()); 
} 
//ACTIVATE
//CREATE-DB 
 public function artPictureGalerie_create_db() {
       require_once( 'apg.class/db/pdo-database.php' ); 
       jal_install();
 } 
//UPDATE-DB    
public function artPictureGalerie_update_db() {
       require_once( 'apg.class/db/pdo-database.php' ); 
       Art_Picture_update_db_check();
 }    
//GALLERY TEMPLATE TRIGGER
public function apg_template_ArtPictureFilters(){
       add_filter('init', 'apg_user_template_startseite_trigger');
       function apg_user_template_startseite_trigger() {
       global $wp;
       $wp->add_query_var('apg-user-gallery-template');
    }
       add_action('template_redirect', 'apg_user_template_startseite_trigger_check');
        function apg_user_template_startseite_trigger_check() {
        if(intval(get_query_var('apg-user-gallery-template')) == 12067101){
       //AJAX HANDLE 
        wp_enqueue_script( 'ajax-script',
        plugins_url( '/js/art_picture_template_startseite.js', __FILE__ ),
        array( 'jquery' )
        );
        $title_nonce = wp_create_nonce( 'title_apg_handle' );
        wp_localize_script( 'ajax-script', 'apg_ajax_obj', array(
       'ajax_url' => admin_url( 'admin-ajax.php' ),
       'nonce'    => $title_nonce,
    ));     
        require_once 'apg.class/templates/user-template/template-startseite.php';
    exit;   
   }   
  }
        add_action('template_redirect', 'apg_user_template_login_trigger_check');
        function apg_user_template_login_trigger_check() {
        if(intval(get_query_var('apg-user-gallery-template')) == 12067102){
        //CSS   
        require_once 'apg.class/templates/user-template/template-login.php';
        exit;   
   }   
  }
        add_action('template_redirect', 'apg_user_template_login_script_trigger_check');
        function apg_user_template_login_script_trigger_check() {
        if(intval(get_query_var('apg-user-gallery-template')) == 12067103){
        require_once 'apg.class/templates/user-template/login-script.php';
        exit;   
   }   
  }
        add_action('template_redirect', 'apg_user_template_logout_script_trigger_check');
        function apg_user_template_logout_script_trigger_check() {
        if(intval(get_query_var('apg-user-gallery-template')) == 12067104){
        require_once 'apg.class/templates/user-template/logout-script.php';
        exit;   
   }   
  }
        add_action('template_redirect', 'apg_user_template_help_script_trigger_check');
        function apg_user_template_help_script_trigger_check() {
        if(intval(get_query_var('apg-user-gallery-template')) == 12067105){
        //AJAX HANDLE 
        wp_enqueue_script( 'ajax-script',
        plugins_url( '/js/art_picture_template_help.js', __FILE__ ),
        array( 'jquery' )
        );
        $title_nonce = wp_create_nonce( 'title_apg_handle' );
        wp_localize_script( 'ajax-script', 'apg_ajax_obj', array(
        'ajax_url' => admin_url( 'admin-ajax.php' ),
        'nonce'    => $title_nonce,
        ));    
        require_once 'apg.class/templates/user-template/template-help.php';
        exit;   
   }   
  }
        add_action('template_redirect', 'apg_user_template_freigaben_script_trigger_check');
        function apg_user_template_freigaben_script_trigger_check() {
        if(intval(get_query_var('apg-user-gallery-template')) == 12067106){
        //AJAX HANDLE 
        wp_enqueue_script( 'ajax-script',
        plugins_url( '/js/art_picture_template_freigaben.js', __FILE__ ),
        array( 'jquery' )
        );
         wp_enqueue_script('bootstrap-temp-js', plugins_url('/assets/dist/js/bootstrap.js',__FILE__), array('jquery'), '1.0', true);    
        $title_nonce = wp_create_nonce( 'title_apg_handle' );
        wp_localize_script( 'ajax-script', 'apg_ajax_obj', array(
       'ajax_url' => admin_url( 'admin-ajax.php' ),
       'nonce'    => $title_nonce,
        ));   
        require_once 'apg.class/templates/user-template/template-freigaben.php';
        exit;   
    }   
  }
        add_action('template_redirect', 'apg_user_template_select_script_trigger_check');
        function apg_user_template_select_script_trigger_check() {
        if(intval(get_query_var('apg-user-gallery-template')) == 12067107){
        //AJAX HANDLE    
        wp_enqueue_script( 'ajax-script',
        plugins_url( '/js/art_picture_template_select.js', __FILE__ ),
        array( 'jquery' )
        );
        $title_nonce = wp_create_nonce( 'title_apg_handle' );
        wp_localize_script( 'ajax-script', 'apg_ajax_obj', array(
       'ajax_url' => admin_url( 'admin-ajax.php' ),
       'nonce'    => $title_nonce,
    ));       
        require_once 'apg.class/templates/user-template/template-select.php';
        exit;   
   }   
  }
        add_action('template_redirect', 'apg_user_template_message_script_trigger_check');
        function apg_user_template_message_script_trigger_check() {
        if(intval(get_query_var('apg-user-gallery-template')) == 12067108){
        //AJAX HANDLE 
        wp_enqueue_script( 'ajax-script',
        plugins_url( '/js/art_picture_template_message.js', __FILE__ ),
        array( 'jquery' )
        );
        $title_nonce = wp_create_nonce( 'title_apg_handle' );
        wp_localize_script( 'ajax-script', 'apg_ajax_obj', array(
       'ajax_url' => admin_url( 'admin-ajax.php' ),
       'nonce'    => $title_nonce,
    ));     
        require_once 'apg.class/templates/user-template/template-message.php';
        exit;   
   }   
  }
        //Image-Details
        add_action('template_redirect', 'apg_user_template_img_details_script_trigger_check');
        function apg_user_template_img_details_script_trigger_check() {
        if(intval(get_query_var('apg-user-gallery-template')) == 12067114){
        require_once 'pages/template_img_details.php';
        exit;   
   }   
  }
        //Image-Search
        add_action('template_redirect', 'apg_user_template_img_search_script_trigger_check');
        function apg_user_template_img_search_script_trigger_check() {
        if(intval(get_query_var('apg-user-gallery-template')) == 12067115){
        require_once 'pages/template_img_search.php';
        exit;   
   }   
  }
}
//CUSTOM POST
public function register_post_types() {
        register_post_type(
                        'gallery',
                         array(
                        'labels' => array(
                        'name'=> 'Art Picture Seiten',
                        'singular_name'=>'Galerien',
                        'edit_item'=>'Edit Galerie',
                        'items_list_navigation' =>'Galerie list navigation',
                        'add_new_item'=>'Neue Galerie erstellen',
                        'archives'=>'Item Archives',
                        ),
                        'public'              =>true,
                        'show_ui'             =>true,
                        'show_in_menu'        => true,
                        'has_archive'         => true,
                        'show_in_nav_menus'   => true,
                        'exclude_from_search' => false,
                        'menu_icon' => plugins_url('assets/images/dashicon/art-picture-btn64_sm_PRO.png', __FILE__),
                        'supports'=>array(
                        'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'custom-fields'
                        ),
                        'taxonomies'  => array( 'category', 'post_tag' ),
                        )
                       );
    }
//WIDGETS 
public function art_picture_widget() {
        $this->apgenqueuegallery();
   wp_enqueue_script('artwidgets', plugins_url('/js/art_widgets.js',__FILE__), array('jquery'), '1.0', true);
        $this->apgenqueuegallery();
        wp_add_inline_script( 'artwidgets', '
        var $gridss = $(\'#grid\').masonry({
        itemSelector: \'#grid-item\',
        percentPosition: true,
        columnWidth: \'#grid-sizer\'
        });
        $gridss.imagesLoaded().progress( function() {
        $gridss.masonry();
        });' );
        require_once( 'apg.class/art_picture_register_widget.php' );    
      
}
//WIDGET 
public function art_picture_register_login_widget() {
        require_once( 'apg.class/art_picture_register_login_widget.php' );    
}
//WIDGET 
public function art_picture_register_zufall_widget() {
        require_once( 'apg.class/art_picture_register_zufall_widget.php' );    
}    
//PAGES
public function art_pictures_startseite() {
        require_once('apg.class/ApgSettings.php');
        $settings = APG\ArtPictureGallery\ApgSettings::load_settings('user_settings');
        $googleUrl = 'https://maps.googleapis.com/maps/api/js?key='.$settings["google_maps_api_key"].'&callback=initMap.';
        wp_enqueue_script( 'apg_google_maps', $googleUrl, null, true );
        require_once('pages/art_galerie_startseite.php');
 }
public function art_galerie_erstellen() {
        require_once( 'pages/art_galerie_erstellen.php' );
        $this->load_upload_script();    
} 
public function art_benutzer_page(){
        apg_benutzer_page();
}    
public function art_response_page(){
        apg_response_page();    
}
function art_galerie_settings(){
        require_once( 'pages/art_galerie_settings.php' ); 
        wp_enqueue_script('apg_tiny_mce_js', plugins_url('/apg.class/tinymce/jscripts/tiny_mce/tiny_mce.js',__FILE__), array('jquery'),true, '1.0', true);
}
public function art_galerie_help(){
        require_once( 'pages/art_help_page.php' );
}
public function art_galerie_pro(){
        require_once( 'pages/art_picture_gallery_pro.php' );    
}
public function display_about_page() {
        require_once( 'pages/display_about_page.php' );
}
//METABOX
public function artPicture_metbox(){
        require_once ('apg.class/artPicture_metbox.php');
}
public function artPicture_ansicht(){
        require_once ('apg.class/artPicture_galerieAnsicht.php');    
}    
//HOOKS
public function art_picture_gallery_hooks(){
        require_once('hooks/art_picture_gallery_hooks.php');
}    
//FILE-UPLOAD    
public function apg_file_upload(){
        require_once('/apg.class/upload/apg_upload.php');
}
//CONSTANTEN 
 public function art_picture_constanten(){
        define('ART_PICTURE_SALE', 'https://art-picturedesign.de/galerie-sale/');
        define('ART_PICTURE_URL', 'https://art-picturedesign.de/');
        define('APG_ART_PICTURE_GALLERY_PLUGIN_URL', plugins_url('/',__FILE__));      
 }    
//GALLERY-Enqueue    
public function apgenqueuegallery(){
        require_once('apg.class/ApgSettings.php');
        $settings = APG\ArtPictureGallery\ApgSettings::load_settings('user_settings');
        if(!empty($settings['wp_galerie_js'])){
        //GALERIE-CSS
        wp_enqueue_style( 'blueimp-gallery', plugins_url('/apg.class/file-upload/css/blueimp-gallery.min.css', __FILE__), true ,true);
        //GALERIE-JS
        wp_enqueue_script('blueimp-gallery-min', plugins_url('/apg.class/file-upload/js/blueimp-gallery.min.js',__FILE__), array('jquery'), '1.0', true);
        wp_enqueue_script('gallery-fullscreen-js', plugins_url('/apg.class/file-upload/js/blueimp-gallery-fullscreen.js',__FILE__), array('jquery'), '1.0', true);
        wp_enqueue_script('gallery-indicator-js', plugins_url('/apg.class/file-upload/js/blueimp-gallery-indicator.js',__FILE__), array('jquery'), '1.0', true);
        wp_enqueue_script('gallery-file-js', plugins_url('/apg.class/file-upload/js/jquery.blueimp-gallery.js',__FILE__), array('jquery'), '1.0', true); 
         
        }

  }    
//Enqueue
public function apg_art_picture_grid(){
        wp_enqueue_script('masonry.pkgd.min.js', plugins_url('/assets/js/masonry.pkgd.min.js',__FILE__), array('jquery'), '1.0', false);
        wp_enqueue_script('imagesloaded.pkgd', plugins_url('/assets/js/imagesloaded.pkgd.min.js',__FILE__), array('jquery'), '1.0', false);
} 
public function register_art_picture_styles(){
//Bootstrap JS    
        wp_enqueue_script('Bootstrap-JS', plugins_url('/assets/dist/js/bootstrap.js',__FILE__), array('jquery'), '1.0', true);
        $this->apgenqueuegallery();
        //CSS   
        wp_enqueue_style( 'ArtPicture-Bootstrap_CSS', plugins_url('/assets/dist/css/bootstrap.css', __FILE__), true ,true);
        wp_enqueue_style( 'ArtPicture-Custom-CSS', plugins_url('/assets/css/galerie.css', __FILE__), true ,true);
        wp_enqueue_style( 'ArtPicture-STORE-CSS', plugins_url('/assets/css/galerie_store.css', __FILE__), true ,true);     
}
public function load_upload_script() {
        wp_enqueue_script('ui-upload', plugins_url('/apg.class/file-upload/js/vendor/wdg.js',__FILE__), array('jquery'), '1.0', true);
        wp_enqueue_script('tmpl-min', plugins_url('/apg.class/file-upload/js/tmpl.min.js',__FILE__), array('jquery'), '1.0', true);
        wp_enqueue_script('load-image-all', plugins_url('/apg.class/file-upload/js/load-image.all.min.js',__FILE__), array('jquery'), '1.0', true);
        wp_enqueue_script('canvas-to-blob', plugins_url('/apg.class/file-upload/js/canvas-to-blob.min.js',__FILE__), array('jquery'), '1.0', true);
        wp_enqueue_script('fileupload-js', plugins_url('/apg.class/file-upload/js/jquery.fileupload.js',__FILE__), array('jquery'), '1.0', true);
        wp_enqueue_script('fileupload-process', plugins_url('/apg.class/file-upload/js/jquery.fileupload-process.js',__FILE__), array('jquery'), '1.0', true);
        wp_enqueue_script('fileupload-image', plugins_url('/apg.class/file-upload/js/jquery.fileupload-image.js',__FILE__), array('jquery'), '1.0', true);
        wp_enqueue_script('fileupload-validat', plugins_url('/apg.class/file-upload/js/jquery.fileupload-validate.js',__FILE__), array('jquery'), '1.0', true);
        wp_enqueue_script('fileupload-ui', plugins_url('/apg.class/file-upload/js/fileupload.js',__FILE__), array('jquery'), '1.0', true);
}
public function load_google_maps_script() {
        require_once('apg.class/ApgSettings.php');
        $settings = APG\ArtPictureGallery\ApgSettings::load_settings('user_settings');
       wp_register_script( 'apg_google_maps', 'https://maps.googleapis.com/maps/api/js?key='.$settings["google_maps_api_key"].'&callback=initMap.', false, '1.1', false );
}
public function register_art_picture_templates_styles(){
        require_once('apg.class/ApgSettings.php');
        $settings = APG\ArtPictureGallery\ApgSettings::load_settings('user_settings');
        if(!empty($settings['wp_settings_bootstrap_css'])){
        wp_enqueue_style( 'ArtPicture-Bootstrap_CSS', plugins_url('/assets/dist/css/bootstrap.css', __FILE__), true ,true);   
        }
        wp_enqueue_style( 'ArtPicture-Custom-CSS', plugins_url('/assets/css/galerie.css', __FILE__), true ,true);
        wp_enqueue_style( 'ArtPicture-STORE-CSS', plugins_url('/assets/css/galerie_store.css', __FILE__), true ,true); 
         if(!empty($settings['wp_settings_bootstrap_js'])){
         wp_enqueue_script('bootstrap-temp-js', plugins_url('/assets/dist/js/bootstrap.js',__FILE__), array('jquery'), '1.0', true);   
         }
        $this->apgenqueuegallery();
        wp_enqueue_script('masonry.pkgd.min.js', plugins_url('/assets/js/masonry.pkgd.min.js',__FILE__), array('jquery'), '1.0', false);
        wp_enqueue_script('imagesloaded.pkgd', plugins_url('/assets/js/imagesloaded.pkgd.min.js',__FILE__), array('jquery'), '1.0', false);
        wp_add_inline_script( 'imagesloaded.pkgd', '
        (function (jQuery) {
         window.$ = jQuery.noConflict();
         })(jQuery);
         var $grid = $(".grid").masonry({
         itemSelector: ".grid-item",
         percentPosition: true,
         columnWidth: ".grid-sizer"
         });' );
}
public function load_help_script() {
        $this->apgenqueuegallery();
        wp_enqueue_script('art_picture_help', plugins_url('/js/art_picture_help.js',__FILE__), array('jquery'), '1.0', true);    
}     
//INIT
public function init_options() {
        add_option( 'solis_posts_per_page', 10 );
}
//ACTIVATE
public function activate_about_page() {
        set_transient( 'solis_about_page_activated', 1, 30 );
}
//REDIRECT-ABOUT
public function redirect_about_page() {
        if ( ! current_user_can( 'manage_options' ) )
        return;
        if ( ! get_transient( 'solis_about_page_activated' ) )
        return;
        delete_transient( 'solis_about_page_activated' );
        wp_safe_redirect( admin_url( 'plugins.php?page=about-art-picture-galerie') );
        exit;
}
//VERSIONS-CHECK
public function check_dependencies() {
        global $wp_version;
        $php = '5.4';
        $wp  = '4.8';
        if ( version_compare( PHP_VERSION, $php, '<' ) ) {
        trigger_error( 'Dieses Plugin kann nicht aktiviert werden, da es eine PHP-Version größer als %1$s benötigt. Ihre PHP-Version kann von Ihrem Hosting-Anbieter aktualisiert werden.', E_USER_ERROR );
    }
}
//SELF-DIACTIVATE
public function maybe_self_deactivate() {
        if ( version_compare( PHP_VERSION, $php, '<' ) ){
        require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
        deactivate_plugins( plugin_basename( __FILE__ ) );
        add_action( 'admin_notices', array( $this, 'self_deactivate_notice' ) );
    }
}
//ADMIN-NOTIZ
public function admin_notices() {
        echo '<div class="error"><p>Dieses Plugin wurde deaktiviert, da es eine PHP-Version größer als %1$s benötigt. Ihre PHP-Version kann von Ihrem Hosting-Anbieter aktualisiert werden.</p></div>';
}

}//CLASS ENDE
global $art_picture_galerie;
$art_picture_galerie = new Art_Pictue_Galeries();
$art_picture_galerie->execute();
?>