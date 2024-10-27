<?php
namespace APG\ArtPictureGallery;
if ( ! defined( 'ABSPATH' ) ) exit;
require_once(dirname(__DIR__).'/MailHandler.php');
use APG\ArtPictureGallery\MailHandler as MailHandler;
class remote 
{
public function __construct($method=null){
$this->method = $method;    
}
public function execute()
{
// Aufgerufene Methode
$response     ="";
$error        = "";
$result       = false;
$success      = false;
$error_msg    = '';
$status       = false;
$responseJson = false;
$valid        = true;
$err_message1 ="bitte eingabe überprüfen.";
$err_message2 ="keine passenden Daten gefunden.";
$err_message3 ="bitte mindestens 6 Zeichen eingeben.";
$err_message4 ="Benutzer schon vorhanden.";
$err_message5 ="Es gibt nichts zum löschen..";
$err_message6 ="bitte eMail Adresse überprüfen.";
//gmail_SMTPAuth;
$method = $this->method;
switch ($method)
{
case'sed_design_settings':
 isset($_POST['wp_settings_img_details']) && is_numeric($_POST['wp_settings_img_details']) ? $wp_settings_img_details = sanitize_text_field(trim($_POST['wp_settings_img_details'])) : $wp_settings_img_details = ""; 
 isset($_POST['header_box']) && is_string($_POST['header_box']) ? $header_box = htmlspecialchars(trim($_POST['header_box'])) : $header_box = "";        
 isset($_POST['padding_top']) && is_string($_POST['padding_top']) ? $padding_top = sanitize_text_field(trim($_POST['padding_top'])) : $padding_top = "";   
 isset($_POST['padding_bottom']) && is_string($_POST['padding_bottom']) ? $padding_bottom = sanitize_text_field(trim($_POST['padding_bottom'])) : $padding_bottom = "";         
 isset($_POST['site_background_color']) && is_string($_POST['site_background_color']) ? $site_background_color = sanitize_text_field(trim($_POST['site_background_color'])) : $site_background_color = "";
 isset($_POST['box_background_color']) && is_string($_POST['box_background_color']) ? $box_background_color = sanitize_text_field(trim($_POST['box_background_color'])) : $box_background_color = ""; 
isset($_POST['wp_settings_bootstrap_css']) && is_string($_POST['wp_settings_bootstrap_css']) ? $wp_settings_bootstrap_css = sanitize_text_field(trim($_POST['wp_settings_bootstrap_css'])) : $wp_settings_bootstrap_css = ""; 
isset($_POST['wp_settings_bootstrap_js']) && is_string($_POST['wp_settings_bootstrap_js']) ? $wp_settings_bootstrap_js = sanitize_text_field(trim($_POST['wp_settings_bootstrap_js'])) : $wp_settings_bootstrap_js = "";  
isset($_POST['wp_galerie_js']) && is_string($_POST['wp_galerie_js']) ? $wp_galerie_js = sanitize_text_field(trim($_POST['wp_galerie_js'])) : $wp_galerie_js = "";           

      
if(empty($padding_top) ? $padding = '0px' : $padding = $padding_top);         
if(empty($padding_bottom) ? $paddingBottom = '0px' : $paddingBottom = $padding_bottom);  
if(empty($site_background_color) ? $site_color = 'transparent' : $site_color = $site_background_color);
if(empty($box_background_color) ? $box_color = '#ffffff' : $box_color = $box_background_color);        
 
$this->set_db_settings("wp_settings_img_details",$wp_settings_img_details,'user_settings');
$this->set_db_settings("header_box",$header_box,'user_settings');        
$this->set_db_settings("padding_top",$padding,'user_settings');
$this->set_db_settings("padding_bottom",$paddingBottom,'user_settings');        
$this->set_db_settings("site_background_color",$site_color,'user_settings'); 
$this->set_db_settings("box_background_color",$box_color,'user_settings');
$this->set_db_settings("wp_settings_bootstrap_js",$wp_settings_bootstrap_js,'user_settings');
$this->set_db_settings("wp_settings_bootstrap_css",$wp_settings_bootstrap_css,'user_settings');
$this->set_db_settings("wp_galerie_js",$wp_galerie_js,'user_settings');        
 
$responseJson = new \stdClass(); 
$responseJson->status = true; 
$responseJson->message = 'Wordpress Galerie Settings gespeichert.';        
$result = $responseJson;            
break;        
        
case'save_email_settings':
isset($_POST['gmail_host']) && is_string($_POST['gmail_host']) ? $gmail_host = sanitize_text_field(trim($_POST['gmail_host'])) : $gmail_host = "";
isset($_POST['gmail_smtp']) && is_string($_POST['gmail_smtp']) ? $gmail_smtp = sanitize_text_field(trim($_POST['gmail_smtp'])) : $gmail_smtp = "";         
isset($_POST['gmail_SMTPSecure']) && is_string($_POST['gmail_SMTPSecure']) ? $gmail_SMTPSecure = sanitize_text_field(trim($_POST['gmail_SMTPSecure'])) : $gmail_SMTPSecure = "";
isset($_POST['gmail_Username']) && is_string($_POST['gmail_Username']) ? $gmail_Username = sanitize_text_field(trim($_POST['gmail_Username'])) : $gmail_Username = ""; 
isset($_POST['gmail_Password']) && is_string($_POST['gmail_Password']) ? $gmail_Password = sanitize_text_field(trim($_POST['gmail_Password'])) : $gmail_Password = "";
isset($_POST['gmail_SMTPAuth']) && is_string($_POST['gmail_SMTPAuth']) ? $gmail_SMTPAuth = sanitize_text_field(trim($_POST['gmail_SMTPAuth'])) : $gmail_SMTPAuth  = "";        
if(empty($gmail_host)) {
  $status_host = $status;
  $fehler = 'false';    
}else{
$status_host = true;
$fehler='';    
 } 
if(empty($gmail_smtp)) {
 $fehler = 'false';    
  $status_smtp = $status;
}else{
$status_smtp = true;
$fehler='';    
 } 
if(empty($gmail_SMTPSecure)) {
$fehler = 'false'; 
$status_SMTPSecure = $status;
}else{
$status_SMTPSecure = true;
$fehler='';    
 }
if(empty($gmail_Username)) {
$fehler = 'false';    
 $status_Username = $status;
}else{
$status_Username = true;
$fehler='';    
 }
if(empty($gmail_Password)) {
$fehler = 'false';
$status_Password = $status;
}else{
$fehler = 'false';
$status_Password = true;
$fehler='';    
 }          
 if($status_host){       
$this->set_db_settings("gmail_host",$gmail_host,'user_settings');
 }
if($status_smtp){        
$this->set_db_settings("gmail_smtp",(int)$gmail_smtp,'user_settings'); 
}
if($status_SMTPSecure){        
$this->set_db_settings("gmail_SMTPSecure",$gmail_SMTPSecure,'user_settings');
}
if($status_Username){        
$this->set_db_settings("gmail_Username",$gmail_Username,'user_settings'); 
}
if($status_Password){        
$this->set_db_settings("gmail_Password",$gmail_Password,'user_settings'); 
}
$this->set_db_settings("gmail_SMTPAuth", $gmail_SMTPAuth,'user_settings');
$responseJson = new \stdClass();
$responseJson->status_host = $status_host;
$responseJson->status_smtp = $status_smtp; 
$responseJson->status_SMTPAuth = $status_SMTPSecure;
$responseJson->status_Username = $status_Username;
$responseJson->status_Password = $status_Password; 
$responseJson->status = $fehler;         
return $responseJson;        
break;
case'galerie_pro_license':
isset($_POST['order_id']) && is_string($_POST['order_id']) ? $order_id = esc_attr(trim($_POST['order_id'])) : $order_id = "";
isset($_POST['license_key']) && is_string($_POST['license_key']) ? $license_key = esc_attr(trim($_POST['license_key'])) : $license_key = ""; 
$responseJson = new \stdClass();        
if(empty($order_id) || empty($license_key)) {
$message='<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-label="Schließen"><span aria-hidden="true">&times;</span></button>
                <strong>Fehler!</strong> Bitte Füllen SIe alle Felder aus!
                </div>'; 
$responseJson->message = $message;
$responseJson->status = $status;    
return $responseJson;    
}else{
$message='<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-label="Schließen"><span aria-hidden="true">&times;</span></button>
                <strong>Success!</strong> License Key gespeichert.
                </div>'; 
} 
$result = $this->set_db_settings("order_id", $order_id,'user_settings'); 
$result = $this->set_db_settings("license_key", $license_key,'user_settings'); 
$responseJson->message = $message;
$responseJson->status = true;
$result = $responseJson;     
break;
case "reset_settings":
$status=$this->reset_settings();
$responseJson = new \stdClass();
$responseJson->status = true;
$result = ($responseJson);
break;
case 'load_reset_modal':
isset($_POST['typ']) && is_string($_POST['typ']) ?$typ = esc_attr(trim($_POST['typ'])) : $typ = "";
$responseJson = new \stdClass();
if(empty($typ)){
$responseJson->status = $status;
return ($responseJson);    
}
$modal = self::load_modal(array("typ"=>$typ,
                                "data"=>$data));   
$responseJson->status = true;
$responseJson->host = $html_text;
$responseJson->modal = $modal;
$result = ($responseJson);
break;
case 'google_maps_api_key':
isset($_POST['value']) && is_string($_POST['value']) ? $value = esc_attr(trim($_POST['value'])) : $value = "";
$responseJson = new \stdClass();
if(empty($value)){
$responseJson->message = '<h5 class="dan"><span class="dan fa fa-exclamation-circle "></span> FEHLER! <span class="grey"> Bitte Eingabe Überprüfen!</span></h5>';    
$responseJson->status  = $status;
return $responseJson;    
}
$msg = 'Google-Maps Api-KEY erfolgreich gespeichert.';
$res = $this->set_db_settings("google_maps_api_key",$value,'user_settings');
$responseJson->message = $msg;    
$responseJson->status  = true;
$result = $responseJson;
break;
case 'load_smtp_check':
require_once(dirname(__DIR__).'/MailHandler.php');
$settings = $this->get_db_settings('1');
$host       = $settings['gmail_host'];
$port       = $settings['gmail_smtp'];
$name       = $settings['gmail_Username']; 
$pw         = $settings['gmail_Password'];
$abruf = array("method"=>'smtp_check',
               "data"  => array("host"    => $host,
                                "port"    => $port,
                                "bn"      => $name,
                                "pw"      => $pw));
$dat = new MailHandler($abruf);
$data = $dat->return;
$modal = self::load_modal(array("typ"=>'load_smtp_check',
                                "data"=>$data));
$responseJson = new \stdClass();
$responseJson->status = $data['status'];
$responseJson->message = $modal;
$result = $responseJson;
break;
case 'send_testmail':
isset($_POST['value']) && is_string($_POST['value']) ? $value = esc_attr(trim($_POST['value'])) : $value = "";
if(empty($value)){
$responseJson = new \stdClass();    
$responseJson->status = $status;
$responseJson->message = 'leere Eingabe!';
return $responseJson;    
}
if(filter_var($value, FILTER_VALIDATE_EMAIL)  === false){
$responseJson = new \stdClass();    
$responseJson->status = $status;
$responseJson->message = 'falsches eMail Format!';
return $responseJson;    
}
$settings = $this->get_db_settings('1');
$secure  = $settings['gmail_SMTPSecure'];
if($settings['gmail_SMTPAuth'] == '1'){
  $SMTPAuth = true;
}else{
 $SMTPAuth = false;   
}
$host         = $settings['gmail_host'];
$port         = $settings['gmail_smtp'];
$name         = $settings['gmail_Username']; 
$pw           = $settings['gmail_Password'];
$absMail      = $settings['gmail_Username'];
//$absName      = $settings[$mailtyp.'setFrom2'];
$absName     = 'ArtPicture-Galerie (Wordpress-Plugin)';
//$subject      = $settings[$mailtyp.'Subject'];

$subject      = 'Testemail von ArtPicture-Galerie (Wordpress-Plugin)';  
$smtpSecure   = $secure;
$text         = 'Dies ist eine Test Email von ArtPicture-Galerie';
$logo = plugins_url('../mail/images/Logo-Art-Picture-galerie-B.png "height="227" width="249"  alt="artPictureGalerie',__FILE__);
ob_start();
$html_text    = file_get_contents(dirname(__DIR__).'/mail/test.html',FILE_USE_INCLUDE_PATH);
$html_text = str_replace("###IMAGE_LOGO###", $logo, $html_text);
$html_text = preg_replace(array('/<!--(.*)-->/Uis',"/[[:blank:]]+/"),array('',' '),str_replace(array("\n","\r","\t"),'',$html_text)); 
while (@ob_end_flush());
$attachment = '';
$empfang_name = $value;
$to = $value;
$subject = $subject;
$body = $html_text;
wp_mail( $to, $subject, $body );
remove_filter( ‘wp_mail_content_type’, ‘set_html_content_type’ );
$modal = self::load_modal(array("typ"=>'load_smtp_check',
                                "data"=>$data));
$responseJson = new \stdClass();        
$responseJson->status  = $data['status'];
$responseJson->message = $data['message'];
$responseJson->res_modal   = $modal;
$result = $responseJson;
break;
case'load_mail_check':
$responseJson = new \stdClass();
$modal = self::load_modal(array("typ"=>"load_mail_check"));
$responseJson->status = true;
$responseJson->message = $modal;
$result = $responseJson;
break;
case "fieldset":
isset($_POST['feld'])     && is_string($_POST['feld'])    ? $this->sanitize($feld     = ($_POST['feld']))     : $feld = "";
isset($_POST['typ'])      && is_string($_POST['typ'])     ? $this->sanitize($typ      = ($_POST['typ']))      : $typ = "";
if ($varFielset == "...") {
$error = true;
}
if($feld == 'ImageMagick' || $feld == '1' ? $status = true : $status = false);
$responseJson = new \stdClass();
$responseJson->status = $status;
$responseJson->fieldset  = $fieldset;
$responseJson->error = $error;
$responseJson->typ = $typ;
$result = ($responseJson);
break;
/**
*@Email SMTP settings ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
case "email_aktiv":
isset($_POST['email_aktiv']) && is_numeric($_POST['email_aktiv']) ? $this->sanitize($email_aktiv = ($_POST['email_aktiv'])) : $email_aktiv = "";
if(empty($email_aktiv))
{
$valid =false;
return (array('valid' => $valid,'message'=>$err_message1,
));
}else{
$result = $this->set_db_settings("email_aktiv", $email_aktiv,'user_settings');
if(!$result){
$valid = false; }
return (
$valid ? array('valid' => $valid) : array('valid' => $valid, 'message' => $err_message2 ) );
}
break;
case 'gmail_save_mail':
isset($_POST['value']) && is_numeric($_POST['value']) ? $this->sanitize($value = ($_POST['value'])) : $value = "";
$responseJson = new \stdClass();
if(empty($value)){
$value = 1;
}else{
$value = 0;   
}
$result = $this->set_db_settings("gmail_save_mail",$value,'user_settings');
$responseJson->typ = $value;
$result = ($responseJson);
break;
case "gmail_setFrom1":
isset($_POST['gmail_setFrom1']) && is_string($_POST['gmail_setFrom1']) ? $this->sanitize($gmail_setFrom1 = ($_POST['gmail_setFrom1'])) : $gmail_setFrom1 = "";
if(empty($gmail_setFrom1)) {
$valid =false;
return (array('valid' => $valid,'message'=>$err_message1 ));
}elseif(filter_var($gmail_setFrom1, FILTER_VALIDATE_EMAIL)  === false){
return (array('valid' => false,'message'=>$err_message6 ));
}else{
$result = $this->set_db_settings("gmail_setFrom1",$gmail_setFrom1,'user_settings');
if(!$result){
$valid = false;
}
return (
$valid ? array('valid' => $valid) : array('valid' => $valid, 'message' => $err_message2 ) );
}
break;
case "gmail_setFrom2":
isset($_POST['gmail_setFrom2']) && is_string($_POST['gmail_setFrom2']) ? $this->sanitize($gmail_setFrom2 = ($_POST['gmail_setFrom2'])) : $gmail_setFrom2 = "";
if(empty($gmail_setFrom2)) {
$valid =false;
return (array('valid' => $valid,'message'=>$err_message1 ));
}else{
$result = $this->set_db_settings("gmail_setFrom2",$gmail_setFrom2,'user_settings');
if(!$result){
$valid = false;
}
return (
$valid ? array('valid' => $valid) : array('valid' => $valid, 'message' => $err_message2 ) );
}
break;
case "gmail_Subject":
isset($_POST['gmail_Subject']) && is_string($_POST['gmail_Subject']) ? $this->sanitize($gmail_Subject = ($_POST['gmail_Subject'])) : $gmail_Subject = "";
if(empty($gmail_Subject)) {
$valid =false;
return (array('valid' => $valid,'message'=>$err_message1 ));
}else{
$result = $this->set_db_settings("gmail_Subject",$gmail_Subject,'user_settings');
if(!$result){
$valid = false;
}
return (
$valid ? array('valid' => $valid) : array('valid' => $valid, 'message' => $err_message2 ) );
}
break;
/**
*@Email SMTP settings ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
case "max_file_size":
isset($_POST['max_file_size']) && is_numeric($_POST['max_file_size']) ? $this->sanitize($max_file_size = ($_POST['max_file_size'])) : $max_file_size = "";
if(empty($max_file_size)) {
$valid =false;
return (array('valid' => $valid,'message'=>$err_message1 ));
}else{
$result = $this->set_db_settings("max_file_size",$max_file_size,'user_settings');
if(!$result){
$valid = false;
}
return (
$valid ? array('valid' => $valid) : array('valid' => $valid, 'message' => $err_message2 ) );
}
break;
case "min_file_size":
isset($_POST['min_file_size']) && is_numeric($_POST['min_file_size']) ? $this->sanitize($min_file_size = ($_POST['min_file_size'])) : $min_file_size = "";
if(empty($min_file_size)) {
$valid =false;
return (array('valid' => $valid,'message'=>$err_message1 ));
}else{
$result = $this->set_db_settings("min_file_size",$min_file_size,'user_settings');
if(!$result){
$valid = false;
}
return (
$valid ? array('valid' => $valid) : array('valid' => $valid, 'message' => $err_message2 ) );
}
break;
case "medium_max_height":
isset($_POST['medium_max_height']) && is_numeric($_POST['medium_max_height']) ? $this->sanitize($medium_max_height = ($_POST['medium_max_height'])) : $medium_max_height = "";
if(empty($medium_max_height))
{
$valid = false;
return (array('valid' => $valid,'message'=>$err_message1,
));
}else{
$result = $this->set_db_settings("medium_max_height",$medium_max_height,'user_settings');
if(!$result){
$valid = false; }
return (
$valid ? array('valid' => $valid) : array('valid' => $valid, 'message' => $err_message2 ) );
}
break;
case "medium_max_width":
isset($_POST['medium_max_width']) && is_numeric($_POST['medium_max_width']) ? $this->sanitize($medium_max_width = ($_POST['medium_max_width'])) : $medium_max_width = "";
if(empty($medium_max_width))
{
$valid = false;
return (array('valid' => $valid,'message'=>$err_message1,
));
}else{
$result = $this->set_db_settings("medium_max_width",$medium_max_width,'user_settings');
if(!$result){
$valid = false; }
return (
$valid ? array('valid' => $valid) : array('valid' => $valid, 'message' => $err_message2 ) );
}
break;
case "thumb_max_widht":
isset($_POST['thumb_max_widht']) && is_numeric($_POST['thumb_max_widht']) ? $this->sanitize($thumb_max_widht = ($_POST['thumb_max_widht'])) : $thumb_max_widht = "";
if(empty($thumb_max_widht))
{
$valid = false;
return (array('valid' => $valid,'message'=>$err_message1,
));
}else{
$result = $this->set_db_settings("thumb_max_width",$thumb_max_widht,'user_settings');
if(!$result){
$valid = false; }
return (
$valid ? array('valid' => $valid) : array('valid' => $valid, 'message' => $err_message2 ) );
}
break;
case "thumb_max_height":
isset($_POST['thumb_max_height']) && is_numeric($_POST['thumb_max_height']) ? $this->sanitize($thumb_max_height = ($_POST['thumb_max_height'])) : $thumb_max_height = "";
if(empty($thumb_max_height))
{
$valid = false;
return (array('valid' => $valid,'message'=>$err_message1,
));
}else{
$result = $this->set_db_settings("thumb_max_height",$thumb_max_height,'user_settings');
if(!$result){
$valid = false; }
return (
$valid ? array('valid' => $valid) : array('valid' => $valid, 'message' => $err_message2 ) );
}
break;
case "max_size":
isset($_POST['max_size']) && is_string($_POST['max_size']) ? $this->sanitize($max_size = ($_POST['max_size'])) : $max_size = "";
if(empty($max_size))
{
$valid = false;
return (array('valid' => $valid,'message'=>$err_message1,
));
}else{
$result = $this->set_db_settings("max_size",$max_size,'user_settings');
if(!$result){
$valid = false; }
return (
$valid ? array('valid' => $valid) : array('valid' => $valid, 'message' => $err_message2 ) );
}
break;
case "post_max_size":
isset($_POST['post_max_size']) && is_string($_POST['post_max_size']) ? $this->sanitize($post_max_size = ($_POST['post_max_size'])) : $post_max_size = "";
 ini_set('post_max_size', $post_max_size);       
if(empty($post_max_size))
{
$valid = false;
return (array('valid' => $valid,'message'=>$err_message1,
));
}else{
$result = $this->set_db_settings("post_max_size",$post_max_size,'user_settings');
if(!$result){
$valid = false; }
return (
$valid ? array('valid' => $valid) : array('valid' => $valid, 'message' => $err_message2 ) );
}
break;        
case "post_memory_limit":
isset($_POST['post_memory_limit']) && is_string($_POST['post_memory_limit']) ? $this->sanitize($post_memory_limit = ($_POST['post_memory_limit'])) : $post_memory_limit = "";
if(empty($post_memory_limit))
{
$valid = false;
return (array('valid' => $valid,'message'=>$err_message1,
));
}else{
$result = $this->set_db_settings("post_memory_limit",$post_memory_limit,'user_settings');
if(!$result){
$valid = false; }
return (
$valid ? array('valid' => $valid) : array('valid' => $valid, 'message' => $err_message2 ) );
}
break; 
case "img_crop":
isset($_POST['img_crop']) && is_numeric($_POST['img_crop']) ? $this->sanitize($img_crop = ($_POST['img_crop'])) : $img_crop = "";
if(empty($img_crop))
{
$valid = false;
return (array('valid' => $valid,'message'=>$err_message1,
));
}else{
$result = $this->set_db_settings("crop",$img_crop,'user_settings');
if(!$result){
$valid = false; }
return (
$valid ? array('valid' => $valid) : array('valid' => $valid, 'message' => $err_message2 ) );
}
break;
case "image_extensions":
isset($_POST['image_extensions']) && is_numeric($_POST['image_extensions']) ? $this->sanitize($image_extensions = ($_POST['image_extensions'])) : $image_extensions = "";
if(empty($image_extensions))
{
$valid = false;
return (array('valid' => $valid,'message'=>$err_message1,
));
}else{
$result = $this->set_db_settings("correct_image_extensions",$image_extensions,'user_settings');
if(!$result){
$valid = false; }
return (
$valid ? array('valid' => $valid) : array('valid' => $valid, 'message' => $err_message2 ) );
}
break;
case "extens_max_height":
isset($_POST['extens_max_height']) && is_numeric($_POST['extens_max_height']) ? $this->sanitize($extens_max_height = ($_POST['extens_max_height'])) : $extens_max_height = "";
if(empty($extens_max_height))
{
$valid = false;
return (array('valid' => $valid,'message'=>$err_message1,
));
}else{
$result = $this->set_db_settings("max_height",$extens_max_height,'user_settings');
if(!$result){
$valid = false; }
return (
$valid ? array('valid' => $valid) : array('valid' => $valid, 'message' => $err_message2 ) );
}
break;
case "extens_max_width":
isset($_POST['extens_max_width']) && is_numeric($_POST['extens_max_width']) ? $this->sanitize($extens_max_width = ($_POST['extens_max_width'])) : $extens_max_width = "";
if(empty($extens_max_width))
{
$valid = false;
return (array('valid' => $valid,'message'=>$err_message1,
));
}else{
$result = $this->set_db_settings("max_width",$extens_max_width,'user_settings');
if(!$result){
$valid = false; }
return (
$valid ? array('valid' => $valid) : array('valid' => $valid, 'message' => $err_message2 ) );
}
break;
case "extens_min_height":
isset($_POST['extens_min_height']) && is_numeric($_POST['extens_min_height']) ? $this->sanitize($extens_min_height = ($_POST['extens_min_height'])) : $extens_min_height = "";
if(empty($extens_min_height))
{
$valid = false;
return (array('valid' => $valid,'message'=>$err_message1,
));
}else{
$result = $this->set_db_settings("min_height",$extens_min_height,'user_settings');
if(!$result){
$valid = false; }
return (
$valid ? array('valid' => $valid) : array('valid' => $valid, 'message' => $err_message2 ) );
}
break;
case "extens_min_width":
isset($_POST['extens_min_width']) && is_numeric($_POST['extens_min_width']) ? $this->sanitize($extens_min_width = ($_POST['extens_min_width'])) : $extens_min_width = "";
if(empty( $extens_min_width))
{
$valid = false;
return (array('valid' => $valid,'message'=>$err_message1,
));
}else{
$result = $this->set_db_settings("min_width", $extens_min_width,'user_settings');
if(!$result){
$valid = false; }
return (
$valid ? array('valid' => $valid) : array('valid' => $valid, 'message' => $err_message2 ) );
}
break;
/**
*@system settings ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
case "image_library":
isset($_POST['image_library']) && is_string($_POST['image_library']) ? $this->sanitize($image_library = ($_POST['image_library'])) : $image_library = "";
$a=$this->get_db_settings('1');
if ($image_library == "...") {
$valid=false;
return (array('valid' => $valid,'message'=>$err_message1));
}
if(!in_array($image_library,$a) ){
$valid =false;
return (array('valid' => $valid,'message'=>$err_message1));
}
$result = $this->set_db_settings("image_library-select", $image_library,'user_settings');
if($result == false){
$valid = false;
}
return (
$valid ? array('valid' => $valid) : array('valid' => $valid, 'message' => $err_message2 ) );
break;
case "resourcetype_map":
isset($_POST['resourcetype_map']) && is_numeric($_POST['resourcetype_map']) ? $this->sanitize($resourcetype_map = ($_POST['resourcetype_map'])) : $resourcetype_map = "";
if(empty($resourcetype_map))
{
$valid =false;
return (array('valid' => $valid,'message'=>$err_message1,
));
}else{
$result = $this->set_db_settings("RESOURCETYPE_MAP", $resourcetype_map,'user_settings');
if(!$result){
$valid = false; }
return (
$valid ? array('valid' => $valid) : array('valid' => $valid, 'message' => $err_message2 ) );
}
break;
case "resourcetype_memory":
isset($_POST['resourcetype_memory']) && is_numeric($_POST['resourcetype_memory']) ? $this->sanitize($resourcetype_memory = ($_POST['resourcetype_memory'])) : $resourcetype_memory = "";
if(empty($resourcetype_memory))
{
$valid =false;
return (array('valid' => $valid,'message'=>$err_message1,
));
}else{
$result = $this->set_db_settings("RESOURCETYPE_MEMORY", $resourcetype_memory,'user_settings');
if(!$result){
$valid = false; }
return (
$valid ? array('valid' => $valid) : array('valid' => $valid, 'message' => $err_message2 ) );
}
break;
case "convert_bin":
isset($_POST['convert_bin']) && is_string($_POST['convert_bin']) ? $this->sanitize($convert_bin = ($_POST['convert_bin'])) : $convert_bin = "";
if(empty($convert_bin))
{
$valid =false;
return (array('valid' => $valid,'message'=>$err_message1,
));
}else{
$result = $this->set_db_settings("convert_bin", $convert_bin,'user_settings');
if(!$result){
$valid = false; }
return (
$valid ? array('valid' => $valid) : array('valid' => $valid, 'message' => $err_message2 ) );
}
break;
case "identify_bin":
isset($_POST['identify_bin']) && is_string($_POST['identify_bin']) ? $this->sanitize($identify_bin = ($_POST['identify_bin'])) : $identify_bin = "";
if(empty($identify_bin))
{
$valid =false;
return (array('valid' => $valid,'message'=>$err_message1,
));
}else{
$result = $this->set_db_settings("identify_bin", $identify_bin,'user_settings');
if(!$result){
$valid = false; }
return (
$valid ? array('valid' => $valid) : array('valid' => $valid, 'message' => $err_message2 ) );
}
break;
case "limit_memory":
isset($_POST['limit_memory']) && is_string($_POST['limit_memory']) ? $this->sanitize($limit_memory = ($_POST['limit_memory'])) : $limit_memory = "";
if(empty($limit_memory))
{
$valid =false;
return (array('valid' => $valid,'message'=>$err_message1,
));
}else{
$result = $this->set_db_settings("limit_memory", $limit_memory,'user_settings');
if(!$result){
$valid = false; }
return (
$valid ? array('valid' => $valid) : array('valid' => $valid, 'message' => $err_message2 ) );
}
break;
case "limit_map":
isset($_POST['limit_map']) && is_string($_POST['limit_map']) ? $this->sanitize($limit_map = ($_POST['limit_map'])) : $limit_map = "";
if(empty($limit_map))
{
$valid =false;
return (array('valid' => $valid,'message'=>$err_message1,
));
}else{
$result = $this->set_db_settings("limit_map", $limit_map,'user_settings');
if(!$result){
$valid = false; }
return (
$valid ? array('valid' => $valid) : array('valid' => $valid, 'message' => $err_message2 ) );
}
break;
/**
*@PAGINATION settings ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
case "pagination_aktiv":
isset($_POST['pagination_aktiv']) && is_numeric($_POST['pagination_aktiv']) ? $this->sanitize($pagination_aktiv = ($_POST['pagination_aktiv'])) : $pagination_aktiv = "";
if(empty($pagination_aktiv))
{
$valid =false;
return (array('valid' => $valid,'message'=>$err_message1,
));
}else{
$result = $this->set_db_settings("pag_aktiv", $pagination_aktiv,'user_settings');
if(!$result){
$valid = false; }
return (
$valid ? array('valid' => $valid) : array('valid' => $valid, 'message' => $err_message2 ) );
}
break;
case "pag_size":
isset($_POST['pag_size']) && is_string($_POST['pag_size']) ? $this->sanitize($pag_size = ($_POST['pag_size'])) : $pag_size = "";
if(empty($pag_size))
{
$valid =false;
return (array('valid' => $valid,'message'=>$err_message1,
));
}else{
$a=$this->get_db_settings('1');
if (!in_array($pag_size, $a) || $pag_size == "...") {
$valid = false;
return (array('valid' => $valid,'message'=>$err_message1));
}
$result = $this->set_db_settings('pag-class-select',$pag_size,'user_settings');
if(!$result){
$valid = false; }
return (
$valid ? array('valid' => $valid) : array('valid' => $valid, 'message' => $err_message2 ) );
}
break;
case "pag_location":
isset($_POST['pag_location']) && is_string($_POST['pag_location']) ? $this->sanitize($pag_location = ($_POST['pag_location'])) : $pag_location = "";
if(empty($pag_location)){
$valid =false;
return (array('valid' => $valid,'message'=>$err_message1, ));
}else{
$a=$this->get_db_settings('1');
if (!in_array($pag_location, $a) || $pag_location == "...") {
$valid = false;
return (array('valid' => $valid,'message'=>$err_message1));
}
$result = $this->set_db_settings('pag-anzahl-select',$pag_location,'user_settings');
if(!$result){
$valid = false; }
return (
$valid ? array('valid' => $valid) : array('valid' => $valid, 'message' => $err_message2 ) );
}
break;
case "anzahl_pag_start":
isset($_POST['anzahl_pag_start']) && is_numeric($_POST['anzahl_pag_start']) ? $this->sanitize($anzahl_pag_start = ($_POST['anzahl_pag_start'])) : $anzahl_pag_start = "";
if(empty($anzahl_pag_start)){
$valid =false;
return (array('valid' => $valid,'message'=>$err_message1, ));
}else{
$a=$this->get_db_settings('1');
if (!in_array($anzahl_pag_start, $a) || $anzahl_pag_start == "...") {
$valid = false;
return (array('valid' => $valid,'message'=>$err_message1));
}
$result = $this->set_db_settings('start-select',$anzahl_pag_start,'user_settings');
if(!$result){
$valid = false; }
return (
$valid ? array('valid' => $valid) : array('valid' => $valid, 'message' => $err_message2 ) );
}
break;
case 'bn_image_ordner':
isset($_POST['bn_image_ordner']) && is_string($_POST['bn_image_ordner']) ? $this->sanitize($bn_image_ordner = ($_POST['bn_image_ordner'])) : $bn_image_ordner = "";
if(empty($bn_image_ordner) ||  strlen($bn_image_ordner) < 6 )
{
$valid =false;
return (array('valid' => $valid,'message'=>$err_message3, ));
}
break;
case 'bn_medium_ordner':
isset($_POST['bn_medium_ordner']) && is_string($_POST['bn_medium_ordner']) ? $this->sanitize($bn_medium_ordner = ($_POST['bn_medium_ordner'])) : $bn_medium_ordner = "";
if(empty($bn_medium_ordner) ||  strlen($bn_medium_ordner) < 6)
{
$valid =false;
return (array('valid' => $valid,'message'=>$err_message3, ));
}
break;
case 'pw_image_ordner':
isset($_POST['pw_image_ordner']) && is_string($_POST['pw_image_ordner']) ? $this->sanitize($pw_image_ordner = ($_POST['pw_image_ordner'])) : $pw_image_ordner = "";
if(empty($pw_image_ordner) ||  strlen($pw_image_ordner) < 6 || $pw_image_ordner == '')
{
$valid =false;
return (array('valid' => $valid,'message'=>$err_message3, ));
}
break;
case 'pw_medium_ordner':
isset($_POST['pw_medium_ordner']) && is_string($_POST['pw_medium_ordner']) ? $this->sanitize($pw_medium_ordner = ($_POST['pw_medium_ordner'])) : $pw_medium_ordner = "";
if(empty($pw_medium_ordner) ||  strlen($pw_medium_ordner) < 6 || $pw_medium_ordner == '')
{
$valid =false;
return (array('valid' => $valid,'message'=>$err_message3, ));
}
break;
case 'htaccess_image_aktiv':
isset($_POST['htaccess_image_aktiv']) && is_string($_POST['htaccess_image_aktiv']) ? $this->sanitize($htaccess_image_aktiv = ($_POST['htaccess_image_aktiv'])) : $htaccess_image_aktiv = "";
if(empty($htaccess_image_aktiv))
{
$valid =false;
return (array('valid' => $valid,'message'=>$err_message1,));
}
$res = $this->get_db_settings('4');
if(!empty($res['cb_htaccess_image_checked']))
{
$aktiv = '';
}
break;
case 'htaccess_medium_aktiv':
isset($_POST['htaccess_medium_aktiv']) && is_string($_POST['htaccess_medium_aktiv']) ? $this->sanitize($htaccess_medium_aktiv = ($_POST['htaccess_medium_aktiv'])) : $htaccess_medium_aktiv = "";
if(empty($htaccess_medium_aktiv))
{
$valid =false;
return (array('valid' => $valid,'message'=>$err_message1,));
}
$res = $this->get_db_settings('4');
if(!empty($res['cb_htaccess_medium_checked']))
{
$aktiv = '';
}
break;
case "removeHtaccessImage":
isset($_POST['Imagemuser']) && is_string($_POST['Imagemuser']) ? $this->sanitize($Imagemuser = ($_POST['Imagemuser'])) : $Imagemuser = "";
if(empty($Imagemuser))
{
$valid =false;
return (array('valid' => $valid,'message'=>$err_message5,));
}
break;
case "removeHtaccessMedium":
isset($_POST['Mediumuser']) && is_string($_POST['Mediumuser']) ? $this->sanitize($Mediumuser = ($_POST['Mediumuser'])) : $Mediumuser = "";
if(empty($Mediumuser))
{
$valid =false;
return (array('valid' => $valid,'message'=>$err_message1,));
}
break;
default:
$result = '';
break;
}//switch ENDE
return $result;
} //execute() ENDE
public function get_db_settings($result_typ)
{
/**  *
* @result 1 return settings + htaccess
* @result 2 return settings + tooltip
* @result 3 return tooltip
*/
global $wpdb;    
$table_name = $wpdb->prefix . 'art_config';
$result = $wpdb->get_results( 
	"SELECT * FROM $table_name ");    
$settings = unserialize($result[0]->user_settings);
$tooltip  = unserialize($result[0]->tooltip);
switch ($result_typ)
{
case '1':
$this->return    = $settings;
break;
case '2':
$this->return   = array_merge($settings,$tooltip);
break;
case '3':
$this->return   = $tooltip;
break;
}
return $this->return;
}
public function set_db_settings($key, $value,$table)
{
switch ($table)
{
case 'user_settings':
$selectTable = '1';
break;
case 'tooltip':
$selectTable = '3';
break;
}
$data = $this->get_db_settings($selectTable);
$arrayKey = array_keys( $data);
if (in_array($key,$arrayKey))
{
$newVal=array();
$newVal[$key] = $value;
$res = array_replace($data,$newVal);
$result = serialize($res);
$this->update_settings($result,$table);
return true;
}else{
return false;
}
}
private function update_settings($serial_val,$table){
global $wpdb;    
$table_name = $wpdb->prefix . 'art_config';
$wpdb->update( 
	$table_name, 
	array( 
	$table => $serial_val
	), 
	array( 'id' => 1 ), 
	array( 
		'%s'
	), 
	array( '%d' ) 
);    
}
public function settings_select()
{
$this->return=array();
$data = $this->get_db_settings('2');
////SELECT///
foreach($data['image_library'] as $tmp){
if($data['image_library-select'] == $tmp){
$sel = " selected='selected' ";
}else{$sel=""; }
$this->return['sel_library'] .= "<option value='$tmp'  $sel>$tmp</option>\n";
}
foreach($data['pag_class'] as $tmp){
if($data['pag-class-select'] == $tmp){
$sel = " selected='selected' ";
}else{$sel = ""; }
$this->return['sel_pag_class'] .="<option value='$tmp'  $sel>$tmp</option>\n";
}
foreach($data["pag_anzahl"] as $tmp){
if($data['pag-anzahl-select'] == $tmp){
$sel =  " selected='selected' ";
}else{$sel = ""; }
$this->return['sel_pag_anzahl'] .="<option value='$tmp' $sel>$tmp</option>\n";
}
foreach($data["start_limit"] as $tmp){
if($data['start-select'] == $tmp){
$sel =  " selected='selected' ";
}else{$sel = ""; }
$this->return['sel_start_limit'] .="<option value='$tmp' $sel>$tmp</option>\n";
}
foreach($data["links_anzeige"] as $tmp){
if($data['links-select'] == $tmp){
$sel =  " selected='selected' ";
}else{$sel = ""; }
$this->return['sel_links_anzeige'] .="<option value='$tmp' $sel>$tmp</option>\n";
}
if($data['pag_aktiv'] == '1'){
$this->return['pag_check1']                     .= ' checked';
$this->return['pag_check2']                     .= '';
$this->return['disabled_pagination']            .= '';
}else{
$this->return['pag_check1']                     .= '';
$this->return['pag_check2']                     .= ' checked';
$this->return['disabled_pagination']            .= ' disabled';
}
if($data['email_aktiv'] == '1'){
$this->return['email_aktiv_check1']                     .= ' checked';
$this->return['email_aktiv_check2']                     .= '';
$this->return['fieldset_smtp']                          .= '';
$this->return['fieldset_gmail']                         .= ' disabled';
}else{
$this->return['email_aktiv_check1']                     .= '';
$this->return['email_aktiv_check2']                     .= ' checked';
$this->return['fieldset_smtp']                          .= ' disabled';
$this->return['fieldset_gmail']                         .= '';
}
if($data['crop'] == '1'){
$this->return['crop_check1']                    .= ' checked';
$this->return['crop_check2']                    .= '';
}else{
$this->return['crop_check1']                    .= '';
$this->return['crop_check2']                    .= ' checked';
}
if($data['correct_image_extensions'] == '1'){
$this->return['image_extensions_check1']        .= ' checked';
$this->return['image_extensions_check2']        .= '';
$this->return['disabled_extensions']            .= '';
}else{
$this->return['image_extensions_check1']        .= '';
$this->return['image_extensions_check2']        .= ' checked';
$this->return['disabled_extensions']            .= ' disabled';
}
if($data['image_library-select'] == 'ImageMagick'){
$this->return['disabled_imagick']               .= ' ';
}else{
$this->return['disabled_imagick']               .= ' disabled';
}
//htaccess
return $this->return;
}
private function reset_settings(){
require_once ('default_settings.php');
global $wpdb;    
$table_name = $wpdb->prefix . 'art_config';
$wpdb->update( 
	$table_name, 
	array( 
		'user_settings' => $DB_def_conf
	), 
	array( 'id' => 1 ), 
	array( 
		'%s'
	), 
	array( '%d' ) 
);    
}
private static function load_modal($data)
{
    $date = new \DateTime(); 
    $datum = $date->format('Y');
    switch($data['typ'])
    {
        case'load_reset_modal':
            $header = '<h4 class="modal-title" id="meinModalLabel"><strong class="dan">default </strong> Settings laden</h4>';
            $body   = '<div class="text-center"><strong class="dan">alle </strong> Settings werden zurückgesetzt</div>';
            $btn    ='<button type="button" class="btn btn-danger"onclick="resetSettings()">ja Settings laden</button>
                      <button type="button" class="btn btn-default" data-dismiss="modal">Schließen</button>';
            break;
    case'load_smtp_check':
            if($data['data']['status'] === true)
            {
             $color = 'suss';
             $icon = 'fa fa-thumbs-o-up';   
            }else{
             $color = 'dan';
             $icon = 'fa fa-thumbs-o-down';   
            }
           $header = '<h4 class="modal-title" id="meinModalLabel"><strong class="warn"><span class="fa fa-gears"></span> SMTP </strong> <span class="grey"> Check</span></h4>
                    <div class ="row"> <div class="col-md-3"> <hr class="hr-footer"></div></div>  
                      <small class="text-left warn">Art<span class="grey">Picture-Galerie </span><span class="warn">'.$datum.'</span></small>';
            $body   = '<div class="text-center"><strong class="'.$color.'"><span class="'.$icon.'"></span> Status </strong> '.$data['data']['message'].'</div>';
            $btn    ='<button type="button" class="btn btn-default" data-dismiss="modal"><span class="dan fa fa-times"></span> schließen</button><br />'; 
    break;
    case'load_mail_check':
            if($data['data']['status'] === true)
            {
             $color = 'suss';
             $icon = 'fa fa-thumbs-o-up';   
            }else{
             $color = 'dan';
             $icon = 'fa fa-thumbs-o-down';   
            }
           $header = '<h4 class="modal-title" id="meinModalLabel"><strong class="warn"><span class="fa fa-gears"></span> EMAIL </strong> <span class="grey"> Check</span></h4>
                    <div class ="row"> <div class="col-md-3"> <hr class="hr-footer"></div></div>  
                      <small class="text-left warn">Art<span class="grey">Picture-Galerie </span><span class="warn">'.$datum.'</span></small>';
            $body   = '<div class="form-group">
                      <div class="col-md-8 col-md-offset-2"> 
                      <b class="warn"><span class="fa fa-envelope-o"></span> Empfänger</b><b class="grey"> eMail Adresse:</b>
                      <br /> 
                      <input type="email"name="testmail"id="testmail" value="" class="form-control"autocomplete="new-password" placeholder="eMail Adresse" required>
                      </div><br /> <br />
                      </div>';
            $btn    ='<button type="button" class="btn btn-warning btn-outline"onclick="send_testmail()"><span class="fa fa-gears"></span> Testmail senden</button>
                      <button type="button" class="btn btn-default btn-outline" data-dismiss="modal"><span class="dan fa fa-times"></span> schließen</button>
                      <br />'; 
    break;
    case'load_smtp_entry':
            if($data['data']['status'] === true)
            {
             $color = 'suss';
             $icon = 'fa fa-thumbs-o-up';   
            }else{
             $color = 'dan';
             $icon = 'fa fa-thumbs-o-down';   
            }
           $header = '<h4 class="modal-title" id="meinModalLabel"><strong class="warn"><span class="fa fa-gears"></span> EMAIL </strong> <span class="grey"> Check</span></h4>
                    <div class ="row"> <div class="col-md-3"> <hr class="hr-footer"></div></div>  
                      <small class="text-left warn">Art<span class="grey">Picture-Galerie </span><span class="warn">'.$datum.'</span></small>';
            $body   = '<div class="text-center"><strong class="'.$color.'"><span class="'.$icon.'"></span> Status </strong> '.$data['data']['message'].'</div>';
            $btn    ='<button type="button" class="btn btn-default" data-dismiss="modal"><span class="dan fa fa-times"></span> schließen</button><br />'; 
    break; 
     }
  $modal = '<div class="modal fade" id="warningModal" tabindex="-1" data-backdrop="" role="dialog" aria-labelledby="meinModalLabel"style="padding-top: 60px;">
                <div class="modal-dialog" role="document" style="overflow-y: initial !important;">
                <div class="modal-content">
                <div  class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Schließen"><span aria-hidden="true">&times;</span></button>
                '.$header.'
                </div>
                <div class="modal-body" style="max-height: calc(100vh - 200px);overflow-y: auto;">
                '.$body.'
                </div>
                <div class="modal-footer">
                '.$btn.'
                </div>
                </div>
                </div>
                </div>';
  $modal = preg_replace(array('/<!--(.*)-->/Uis', "/[[:blank:]]+/"), array('', ' '), str_replace(array("\n","\r","\t"), '', $modal));                            
  return $modal; 
}
function apg_phpmailer_wp_mail( $mail ) {
    $status = false;
    $mail->isSMTP(); 
    add_action( 'phpmailer_init', 'apg_mailer_phpmailer_init' );
    $mail->Host = ART_PICTURE_MAIL_HOST;
    add_action( 'phpmailer_init', 'apg_mailer_phpmailer_init' );
    $mail->SMTPAuth = ART_PICTURE_MAIL_SMTP_AUTH; 
    add_action( 'phpmailer_init', 'apg_mailer_phpmailer_init' );
    $mail->Port = ART_PICTURE_MAIL_PORT;
    add_action( 'phpmailer_init', 'apg_mailer_phpmailer_init' );
    $mail->Username = ART_PICTURE_MAIL_BN;
    add_action( 'phpmailer_init', 'apg_mailer_phpmailer_init' );
    $mail->Password = ART_PICTURE_MAIL_PW;
    add_action( 'phpmailer_init', 'apg_mailer_phpmailer_init' );
    $mail->SMTPSecure = ART_PICTURE_MAIL_SECURE;
    add_action( 'phpmailer_init', 'apg_mailer_phpmailer_init' );
    $mail->setFrom(ART_PICTURE_MAIL_ABS_MAIL, ART_PICTURE_MAIL_ABS_NAME);
    add_action( 'phpmailer_init', 'apg_mailer_phpmailer_init' );
    $mail->addAddress(ART_PICTURE_MAIL_EMPFANG, ART_PICTURE_MAIL_EMPFANG_NAME);
    add_action( 'phpmailer_init', 'apg_mailer_phpmailer_init' );
    $mail->Subject = ART_PICTURE_MAIL_SUBJECT;
    add_action( 'phpmailer_init', 'apg_mailer_phpmailer_init' );
    $mail->msgHTML(ART_PICTURE_MAIL_HTML_TEXT);
    add_action( 'phpmailer_init', 'apg_mailer_phpmailer_init' );
    $mail->AltBody = ART_PICTURE_MAIL_TEXT;
    add_action( 'phpmailer_init', 'apg_mailer_phpmailer_init' );
    $mail->addAttachment(ART_PICTURE_MAIL_ATTACHMENT);
    add_action( 'phpmailer_init', 'apg_mailer_phpmailer_init' );
    return $mail;
}

}