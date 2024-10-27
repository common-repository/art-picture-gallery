<?php
global $jal_db_version;
$jal_db_version = '1.0.7';
function jal_install(){
  global $wpdb;
  global $jal_db_version;
  $installed_ver = get_option("jal_db_version");
  if ($installed_ver != $jal_db_version){
    $table_name = $wpdb->prefix . 'art_images';
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        name VARCHAR( 160 ) NOT NULL,
        post_id TEXT NULL, 
        size VARCHAR( 25 ) NOT NULL,
        type VARCHAR( 60 ) NOT NULL,
        galerie_name VARCHAR( 60 ) NOT NULL,
        beschreibung TEXT NULL,
        url TEXT NULL,
        thumbnailUrl TEXT NULL,
        mediumUrl TEXT NULL,
        deleteUrl TEXT NULL,
        error text NULL,
        tags text NULL,
        exif text NULL,
        last_update DATETIME NULL,
        created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY  (id)
    	) $charset_collate;";
    require_once (ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);

       $table_name = $wpdb->prefix . 'art_galerie';
       $charset_collate = $wpdb->get_charset_collate();
       $sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
        galerie_name varchar(128) DEFAULT '' NOT NULL UNIQUE,
        beschreibung text NULL,
        tags text NULL,
        last_update DATETIME NULL,
  	    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY  (id)
    	) $charset_collate;";
    require_once (ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);

    $table_name = $wpdb->prefix . 'art_user';
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
        htaccess_user varchar(128) DEFAULT '' NOT NULL,
        htaccess_passwort varchar(160) DEFAULT ''NOT NULL,
        htaccess_vorname varchar(160) DEFAULT ''NOT NULL,
        htaccess_nachname varchar(160) DEFAULT ''NOT NULL,
        htaccess_email varchar(160) DEFAULT ''NOT NULL,
        user_message text NULL,
        email_aktiv INT( 1 ) NOT NULL,
        htaccess_aktiv INT( 1 ) NOT NULL,
        notiz text NULL,
        last_update DATETIME NULL,
	    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY  (id)
    	) $charset_collate;";
    require_once (ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);

      $table_name = $wpdb->prefix . 'art_freigaben';
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
        htaccess_id INT(9) NOT NULL,
        galerie_id INT(9) NOT NULL,
        htaccess_aktiv INT( 1 ) NOT NULL,
        galerie_typ INT( 1 ) NOT NULL,
        select_image text NULL,
        message text NULL,
        settings text NULL,
        last_update DATETIME NULL,
        created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,      
        PRIMARY KEY  (id)
    	) $charset_collate;";
    require_once (ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);

    $table_name = $wpdb->prefix . 'art_config';
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE $table_name (
    	id mediumint(9) NOT NULL AUTO_INCREMENT,
        galerie_settings text NULL,
        user_settings text NOT NULL,
        tooltip text NOT NULL,
        created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,      
        PRIMARY KEY  (id)
    	) $charset_collate;";
    require_once (ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
    $table = $wpdb->prefix . 'art_config';
    require_once ('default_settings.php');
       $wpdb->replace( 
	   $table, 
	   array( 
        'id' => 1,
		'galerie_settings' => $count, 
		'user_settings' =>  $DB_def_conf,
        'tooltip'   => $tooltip_serial   
    	), 
	   array( 
        '%d',
		'%s', 
		'%s',
        '%s'   
	    ) 
      );
    update_option("jal_db_version", $jal_db_version);
  }
}
function Art_Picture_update_db_check(){
  global $jal_db_version;
  if (get_site_option('jal_db_version') != $jal_db_version){
    jal_install();
  }
}
?>