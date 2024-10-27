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
class Core
{
    protected $_conf;
     public static function encode_session($array) {
        isset($array) ? $encode = $array : $encode = false;
        $encode = serialize($encode);
        $encode = @gzcompress($encode);
        $encode = base64_encode($encode);
        return $encode;
    }
    public function decode_session($string){
        isset($string) ? $decode = $string : $decode = false;
        $decode = base64_decode($decode);
        $decode = @gzuncompress($decode);
        $decode = unserialize($decode);
        return $decode;
    }
    protected function crypt_password($cleartext_password){
        $salt = "$1$";
        $base64_alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/';
        for ($n = 0; $n < 8; $n++)
        {
            $salt .= $base64_alphabet[mt_rand(0, 63)];
        }
        $salt .= "$";
        return crypt($cleartext_password, $salt);
    }
    
        public static function crypt_password2($cleartext_password){
        $salt = "$1$";
        $base64_alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/';
        for ($n = 0; $n < 8; $n++)
        {
            $salt .= $base64_alphabet[mt_rand(0, 63)];
        }
        $salt .= "$";
        return crypt($cleartext_password, $salt);
    }
    protected function sanitize($str, $quotes = ENT_NOQUOTES){
        $str = htmlspecialchars(trim($str), $quotes);
        return $str;
    }
    public function theme_admin() {
        if (!current_user_can('manage_options'))
        {
            wp_die(__('<h2 class="text-center text-danger"> Sie haben keine Berechtigung .</h2>'));
        }
    }
    public static function set_new_count($count, $time, $type)  {
        $badge = '';
        $dat = new DbHandle($na);
        $res = $dat->return;
        $data = unserialize($res['data'][0]['galerie_settings']);

        function zeitdifferenz($t1, $t2, $einheit)
        {
            $differenz = abs($t1 - $t2);
            $anzSek = array(
                "Sekunden" => 1,
                "Minuten" => 60,
                "Stunden" => 3600,
                "Tage" => 86400,
                "Wochen" => 604800);
            if (isset($anzSek[$einheit]))
            {
                return floor($differenz / $anzSek[$einheit]);
            } else
            {
                return "Ungültige Eingabe";
            }
        }

        $t2 = strtotime($type . '_time');
        $t1 = $data[$daten];
        $diff = zeitdifferenz($t1, $t2, "Minuten");
    }
protected function FileSizeConvert($bytes) {
        $bytes = floatval($bytes);
        $arBytes = array(
            0 => array("UNIT" => "TB", "VALUE" => pow(1024, 4)),
            1 => array("UNIT" => "GB", "VALUE" => pow(1024, 3)),
            2 => array("UNIT" => "MB", "VALUE" => pow(1024, 2)),
            3 => array("UNIT" => "KB", "VALUE" => 1024),
            4 => array("UNIT" => "B", "VALUE" => 1),
            );
        foreach ($arBytes as $arItem)
        {
            if ($bytes >= $arItem["VALUE"])
            {
                $result = $bytes / $arItem["VALUE"];
                $result = str_replace(".", ",", strval(round($result, 2))) . " " . $arItem["UNIT"];
                break;
            }
        }
        return $result;
    }
protected function basename($name){
        $datei = $name;
        $dateiarray = explode(".", $datei);
        $endung = "." . $dateiarray[count($dateiarray) - 1];
        return basename($datei, $endung);
    } //END basename
protected function getext($file){
        if (strstr($file, '/')){
            $file = explode('/', $file);
            $file = end($file);
        }
        if (strstr($file, '.')){
            $file = explode('.', $file);
            $return = '.' . end($file);
        } else
        {
            $return = false;
        }
        return $return;
    } //END getext
protected static function read_exif_data($id){
        $abfrage = array(
            "method" => "read_wp_db",
            "table" => "art_images",
            "select" => "exif",
            "where" => " where id = %d",
            "search" => $id);
        $res = new DbHandle($abfrage);
        $response = $res->return;
        $ex = $response['data'][0]->exif;
        if (empty($ex)){
            return false;
        }
        $exif = self::decode_session($ex);
        return $exif;
    }
protected static function extract_method($file){
        $x = stripos($file, '_') + 1;
        $meth1 = substr($file, $x);
        $id = substr($file, 0, $x - 1);
        $y = strpos($meth1, '+') + 1;
        $typ = substr($meth1, $y);
        $methode = substr($meth1, 0, $y - 1);
        $return = array(
            "method" => $methode,
            "id" => $id,
            "typ" => $typ);
        return $return;
    }
protected static function gps_map_extract($row){
        if ($row['GPSLatitudeRef'] == "N"){
            $GPSLatitudeRef = "Nord";
            $GPSLatfaktor = 1;
        } else
        {
            $GPSLatitudeRef = "Süd";
            $GPSLatfaktor = -1;
        }
        $GPSLatGrad = $GPSLatfaktor * ($row['GPSLatitude1'] + ($row['GPSLatitude2'] + ($row['GPSLatitude3'] / 60)) / 60);
        if ($row['GPSLongitudeRef'] == "E"){
            $GPSLongitudeRef = "Ost";
            $GPSLongfaktor = 1;
        } else
        {
        $GPSLongitudeRef = "West";
        $GPSLongfaktor = -1;
        }
        $GPSLongGrad = $GPSLatfaktor * ($row['GPSLongitude1'] + ($row['GPSLongitude2'] + ($row['GPSLongitude3'] / 60)) / 60);
        $gps = array("GPSLongGrad" => $GPSLongGrad, "GPSLatGrad" => $GPSLatGrad);
        return $gps;
    }
protected function base64_images($data){
        switch ($data['method'])
        {
            case 'header_small':
                $image = (dirname(__dir__ )) . '/assets/images/header_logo-small.png';
                $imageData = base64_encode(file_get_contents($image, FILE_USE_INCLUDE_PATH));
                $src = 'data: ' . mime_content_type($image) . ';base64,' . $imageData;
                break;
            case 'image':
                $path = (__dir__ ) . '/file-upload/files/' . $data['image_typ'] . '/';
                $image = $path . $data['name'];
                $imageData = base64_encode(file_get_contents($image, FILE_USE_INCLUDE_PATH));
                self::send_image_header($image);
                $src = 'data: ' . mime_content_type($image) . ';base64,' . $imageData;
                break;
        }
        return $src;
    }
protected static function generate_callback_pw($passwordlength = 8, $numNonAlpha = 1, $numNumberChars = 3, $useCapitalLetter = true) {
        $numberChars = '123456789';
        $specialChars = '!$&?*-:.,+@_';
        //$specialChars = '!$%&=?*-:;.,+~@_';
        $secureChars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghjkmnpqrstuvwxyz';
        $stack = '';
        $stack = $secureChars;
        if ($useCapitalLetter == true)
            $stack .= strtoupper($secureChars);
        $count = $passwordlength - $numNonAlpha - $numNumberChars;
        $temp = str_shuffle($stack);
        $stack = substr($temp, 0, $count);
        if ($numNonAlpha > 0){
            $temp = str_shuffle($specialChars);
            $stack .= substr($temp, 0, $numNonAlpha);
        }
        if ($numNumberChars > 0){
            $temp = str_shuffle($numberChars);
            $stack .= substr($temp, 0, $numNumberChars);
        }
        $stack = str_shuffle($stack);
        return $stack;
}
    /**
     @##1 menu erstellt
     @##2 menu gelöscht
     @##3 menu überschrieben
     @##4 menu laden
     @##5 insert Datenbankfehler
     @##6 leere eingabe add_galerie
     @##7 fehler beim erstellen der Galerie
     @##8 Galerie erfolgreich erstellt und geladen
     @##9 kein Ordner ausgewählt
     @#10 bildbeschreibung erfolg
     @#11 bildbeschreibung kein erfolg
     @#12 keine Galerie erstellt
     @#13 keine Bilder in Galerie vorhanden
     @#14 fehler beim löschen des bildes
     @#15 fehler Galerie schon vorhanden
     @#16 fehler Galerie select, leere eingabe
     @#17 Galerie-Startseite
     @#18 ungültiger Name 
     @#19 zuviele zeich < 150
     @#20 Benutzername vergeben
     @#21 kein user vorhanden
     @#22 kein freigabe vorhanden
     @#23 ein fehler ist aufgetreten
     @#24 email schon vorhanden
     @#25 keine mitteilungen vorhanden
     */
public function response($type = "", $name = "", $error_msg = ""){
    switch ($type)
    {
            case "1":
                $res = "<h3><span class='suss fa fa-thumbs-up'>  INFO </span> <i class='suss fa fa-angle-double-right'</i>  Galerie <small><strong>\" " .
                $name . " \"</strong> erfolgreich erstellt. Sie können die Galerie jetzt auswählen</small></h3>";
                $this->array = array(
                    "response_msg" => $res,
                    "status" => "true",
                    "error_msg" => "");
                break;
            case "2":
                $res = "<h3><span class='suss fa fa-trash-o'>  INFO </span> <i class='suss fa fa-angle-double-right'</i>  Galerie <small> <strong>\" " .
                    $name . " \"</strong> erfolgreich gelöscht.</small></h3>";
                $this->array = array(
                    "response_msg" => $res,
                    "status" => "true",
                    "error_msg" => "");
                break;
            case "3":
                $res = "<h3><span class='suss fa fa-thumbs-up'>  INFO </span><small> Galeriename und Beschreibung aktualisiert.</small></h3>";
                $this->array = array(
                    "response_msg" => $res,
                    "status" => "true",
                    "error_msg" => "");
                break;
            case "4":
                $log = 'new freigabe -> UserHandler : new_freigabe';
               // new ArtLog($log);
                 $res = '<h4 class="dan"style="padding-bottom: 80px;"><i class="fa fa-info"></i> FEHLER! <br/></br><small> Die freigabe ist schon <strong> vorhanden.</strong></small></h4>';
                $this->array = array(
                    "response_msg" => $res,
                    "status" => false,
                    "error_msg" => $error_msg);
                break;
            case "5":
                $res = "<h3><span class='dan fa fa-thumbs-down'>  WordPress database error </span> <i class='dan fa fa-angle-double-right'</i> <small>Bitte überprüfrn Sie ihre eingabe. Eventuell ist die Galerie <strong class='dan'>\"" .
                    $name . "\"</strong> schon vorhanden..</small> </h3>";
                $this->array = array(
                    "response_msg" => $res,
                    "status" => "false",
                    "error_msg" => $error_msg);
                break;
            case "6":
                $res = "<h4><span class='dan fa fa-thumbs-down'>FEHLER</span> <span class='dan fa fa-angle-double-right'</span> <small class='prem'>  Es wurde keine Bezeichnung eingegeben!</small> </h4>";
                $this->array = array(
                    "response_msg" => $res,
                    "status" => false,
                    "error_msg" => $error_msg);
                break;
            case "7":
                $res = '<h4 class="dan text-center"><i class="fa fa-info fa-2x"></i> <span class="fa fa-angle-double-right"></span> FEHLER! <small> Bitte überprüfen Sie ihre <strong class="dan">eingaben!</strong> </small></h4>';
                $this->array = array(
                    "response_msg" => $res,
                    "status" => "false",
                    "error_msg" => $error_msg);
                break;
            case "8":
                $res = "<h3><span class='suss fa fa-thumbs-up'>Galerie</span> <i class='suss fa fa-angle-double-right'</i> <small>\" $name \"<strong class='suss'>erfolgreich </strong> erstellt!</small> </h3>";
                $this->array = array(
                    "response_msg" => $res,
                    "status" => "true",
                    "error_msg" => $error_msg);
                break;
            case "9":
                $res = "<h3><span class='dan fa fa-thumbs-down'>Fehler</span> <i class='dan fa fa-angle-double-right'</i> <small>\" $name \"<strong class='dan'>kein Ordner zum LÖSCHEN</strong> gewählt!</small> </h3>";
                $this->array = array(
                    "response_msg" => $res,
                    "status" => "false",
                    "error_msg" => $error_msg);
                break;
            case "10":
                $res = "<h4><span class='suss fa fa-thumbs-up'>  INFO </span><small> änderungen gespeichert.</small></h3>";
                $this->array = array(
                    "response_msg" => $res,
                    "status" => "true",
                    "error_msg" => "");
                break;
            case "11":
                $log = 'fehlgeschlagen -> case 11';
                //new ArtLog($log);
                $res = "<h4><span class='dan fa fa-thumbs-down'>  INFO </span><small> fehlgeschlagen...</small></h3>";
                $this->array = array(
                    "response_msg" => $res,
                    "status" => "false",
                    "error_msg" => $error_msg);
                break;
            case "12":
                $log = 'es wurde noch keine Galerie erstellt';
                //new ArtLog($log);
                $res = '<br><h3 id="no_img_head" class="text-center dan"><span class="fa fa-camera-retro"></span>  Noch  <small>keine Galerie erstellt !</small></h3>';
                $this->array = array(
                    "response_msg" => $res,
                    "status" => "false",
                    "error_msg" => $error_msg);
                break;
            case "13":
                $log = 'keine Bilder in der Galerie';
                //new ArtLog($log);
                $res = ' <div class="col-md-6 col-md-offset-1 col-sm-6 col-sm-offset-1"> <br><br> <h3 class="warn"style="padding-bottom: 155px;"><i class="fa fa-info"></i> In <small> dieser Galerie <strong class="warn"> ' .
                    $name . ' </strong> gibt es noch keine Bilder. </small></h3> </div>';
                $this->array = array(
                    "response_msg" => $res,
                    "status" => "false",
                    "error_msg" => $error_msg);
                break;
            case "14":
                $log = 'ImageInfo konnte nicht gefunden werden! Fehler GalerieCore -> load_image_info';
                //new ArtLog($log);
                $res = "<h4><span class='dan fa fa-thumbs-down'>  INFO </span><small> ImageInfo konnte nicht gefunden werden!</small></h3>";
                $this->array = array(
                    "response_msg" => $res,
                    "status" => false,
                    "error_msg" => $error_msg);
                break;
            case "15":
                $log = 'Galerie ist schon vorhanden -> modalHandler : new_galerie';
                //new ArtLog($log);
                $res = "<h4><span class='dan fa fa-thumbs-down'>  INFO </span><small class='prem' > Galeriename ist schon vorhanden!</small></h4>";
                $this->array = array(
                    "response_msg" => $res,
                    "status" => false,
                    "error_msg" => $error_msg);
                break;
            case "16":
                $log = 'Galerie select eingabe -> UserHandler : new_freigabe';
                //new ArtLog($log);
                 $res = '<h4 class="dan"style="padding-bottom: 80px;"><i class="fa fa-info"></i> FEHLER! <br/></br><small> Es wurde keine Galerie oder Benutzer <strong> ausgewählt.</strong></small></h4>';
                $this->array = array(
                    "response_msg" => $res,
                    "status" => false,
                    "error_msg" => $error_msg);
                break;
            case "17":
                $res = '<div class="col-md-6 col-md-offset-2 col-sm-6 col-sm-offset-2"> <br><br> <h3 class="warn"style="padding-bottom: 155px;"><i class="fa fa-info"></i> Willkommen <small> in Ihrer <strong class="warn"> </strong> Galerie </small></h3> </div>';
                $this->array = array(
                    "response_msg" => $res,
                    "status" => false,
                    "error_msg" => $error_msg);
                break;
            case "18":
                $res = '<h4 class="dan"style="padding-bottom: 80px;"><i class="fa fa-info"></i> FEHLER! <br/></br><small> Erlaubte Zeichen sind <strong> (A-Z | a-z | 0-9 | _ -)</strong></small></h4>';
                $this->array = array(
                    "response_msg" => $res,
                    "status" => false,
                    "error_msg" => $error_msg);
                break;
            case '19':
                $res = '<h4 class="dan"style="padding-bottom: 80px;"><i class="fa fa-info"></i> FEHLER! <br/><br/><small>Eingabe nicht mehr als <strong class="dan"> 150 </strong> Zeichen. </small></h4>';
                $this->array = array(
                    "response_msg" => $res,
                    "status" => false,
                    "error_msg" => $error_msg);
                break;
            case '20':
                $res = '<h4 class="dan text-center"><i class="fa fa-info fa-2x"></i> <span class="fa fa-angle-double-right"></span> Benutzer <small>ist schon <span class="dan">vorhanden.</span> </small></h4>';
                $this->array = array(
                    "response_msg" => $res,
                    "status" => false,
                    "error_msg" => $error_msg);
                break;
            case '21':
                $res = '<h3 class="text-center"style="padding-top: 15px;"><small><i class="dan fa fa-info fa-2x"></i> <span class="dan fa fa-angle-double-right"></span> Es sind noch <span class="dan">keine Benutzer </span>vorhanden.</small></h3>';
                $this->array = array(
                    "response_msg" => $res,
                    "status" => false,
                    "error_msg" => $error_msg);
                break;
           case '22':
                $res = '<h3 class="text-center"style="padding-top: 15px;"><small><i class="dan fa fa-info fa-2x"></i> <span class="dan fa fa-angle-double-right"></span> Es sind noch <span class="dan"> keine Freigabe</span>  vorhanden! </small></h3>';
                $this->array = array(
                    "response_msg" => $res,
                    "status" => false,
                    "error_msg" => $error_msg);
                break;
           case '23':
                $res = '<h3 class="text-center"style="padding-top: 80px;"><small><i class="warn fa fa-info fa-2x"></i> <span class="dan fa fa-angle-double-right"></span> Ein Fehler ist <span class="dan"> aufgetreten.</span> ';
                $this->array = array(
                    "response_msg" => $res,
                    "status" => false,
                    "error_msg" => $error_msg);
                break;
           case '24':
                $res = '<h3 class="text-center"style="padding-top: 80px;"><small><i class="dan fa fa-info fa-2x"></i> <span class="dan fa fa-angle-double-right"></span> Email ist schon <span class="dan"> vorhanden.</span> ';
                $this->array = array(
                    "response_msg" => $res,
                    "status" => false,
                    "error_msg" => $error_msg);
                break;
           case '25':
                $res = '<h3 class="text-center"style="padding-top: 15px;padding-bottom:170px;"><small><i class="dan fa fa-info fa-2x"></i> <span class="dan fa fa-angle-double-right"></span> Es sind noch <span class="dan"> keine Mitteilungen</span>  vorhanden! </small></h3>';
                $this->array = array(
                    "response_msg" => $res,
                    "status" => false,
                    "error_msg" => $error_msg);
                break;
            //
            default:
                "keine auswahl";
        }
        return $this->array;
    }
    public static function send_header() {
        @header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
        @header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        @header('Cache-Control: no-store, no-cache, must-revalidate');
        @header('Cache-Control: post-check=0, pre-check=0', false);
        @header('Pragma: no-cache');
    }
    protected static function date_deutsche($dateDB){
        date_default_timezone_set("Europe/Berlin");
        $date = new \DateTime($dateDB);
        $tage = array(
            "Mon" => "Montag",
            "Tue" => "Dienstag",
            "Wed" => "Mittwoch",
            "Thu" => "Donnerstag",
            "Fri" => "Freitag",
            "Sat" => "Samstag",
            "Sun" => "Sonntag");
        $monate = array(
            "Jan" => "Januar",
            "Feb" => "Februar",
            "Mar" => "März",
            "Apr" => "April",
            "Mai" => "Mai",
            "Jun" => "Juni",
            "Jul" => "Juli",
            "Aug" => "August",
            "Sep" => "September",
            "Oct" => "Oktober",
            "Nov" => "November",
            "Dec" => "Dezember");
        $datumDB = array();
        $datumDB['monat_lang'] = $monate[$date->format('M')];
        $datumDB['monat_kurz'] = $date->format('M');
        $datumDB['tag_lang'] = $tage[$date->format('D')];
        $datumDB['tag_kurz'] = $date->format('d');
        $datumDB['jahr'] = $date->format('Y');
        return $datumDB;
    }
}
?>