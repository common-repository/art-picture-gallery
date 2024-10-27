<?php
namespace APG\ArtPictureGallery;
if ( ! defined( 'ABSPATH' ) ) exit; 
/**
 * ArtPicture Plugin PHP Class
 * @http://art-pictureDesign.de/WP-ArtTheme-Galerie
 * Copyright 2017, Jens Wiecker
 * https://art-picturedesign.de
 *
 */
require_once ('galerieHandler.php');
use  APG\ArtPictureGallery\GalerieHandler as GalerieHandler;
class ArtGalerieHandler extends GalerieHandler
{
    public function execute(){
        // Aufgerufene Methode
        $method = '';
        $ref = '';
        $row = '';
        $files = '';
        $result = '';
        $search = '';
        $limit = '';
        $page = '';
        $files = '';
        $seite = '';
        $responseJson = '';
        isset($_POST["method"]) && is_string($_POST["method"]) ? esc_attr($method = $_POST["method"]) : $method = "";
        switch ($method)
        {
            case "artgalerie":
                isset($_POST["search"]) && is_string($_POST["search"]) ? esc_attr($search = $_POST["search"]) : $search = "";
                isset($_POST["limit"]) && is_numeric($_POST["limit"]) ? esc_attr($limit = $_POST["limit"]) : $limit = "";
                isset($_POST["page"]) && is_numeric($_POST["page"]) ? esc_attr($page = $_POST["page"]) : $page = "";
                isset($_POST["links"]) && is_numeric($_POST["links"]) ? esc_attr($links = $_POST["links"]) : $links = "";
                isset($_POST["type"]) && is_string($_POST["type"]) ? esc_attr($type = $_POST["type"]) : $type = "";
                isset($_POST["seite"]) && is_numeric($_POST["seite"]) ? esc_attr($seite = $_POST["seite"]) : $seite = "";
              if($type == 'user_galerie_typ1' || $type == 'user_galerie_typ2' || $type == 'user_galerie_typ3'){
              $a2 = array("method"=>"read_wp_db",
              "table"    =>"art_galerie",
              "select"   =>   '*',
              "where"    =>  " where galerie_name = %s",
              "search"   =>  $search);
              $dat1 = new DbHandle($a2);
              $dataGalerie=$dat1->return;
                if(empty($dataGalerie['data'][0]->beschreibung) ? $beschreibung = 'keine Beschreibung vorhanden!' : $beschreibung = $dataGalerie['data'][0]->beschreibung);
              $this->beschreibung = $beschreibung;       
                }else{
              $this->beschreibung = '';      
                }
                $this->TableName = 'art_images';
                $this->where     = 'galerie_name';
                $this->_search   = $search;
                $this->_page     = $page;
                $this->_links    = $links;
                $this->_limit    = $limit;
                $this->type      = $type;
                $this->messages  = $messages;
                $this->_total    = $this->getCount();
                $this->seite      =$seite;
               if ($sett['galerie_count'] == "0"){
                    $galerie_start = ' <div class="col-md-6 col-md-offset-4 col-sm-6 col-sm-offset-4"> <br><br> <h3 class="warn"style="padding-bottom: 155px;"><i class="fa fa-info"></i> Sie    <small> haben  <strong class="warn"> ' .
                      $name . ' </strong> noch keine Galerie angelegt. </small></h3> </div>';
                }
                if (empty($links) ? $this->_links = $this->options['_links'] : $this->_links = $links) ;
                if ($this->_search === "" || $this->_search == "..." || empty($this->_total)){
                    $res = ' <div class="col-md-6 col-md-offset-2 col-sm-6 col-sm-offset-2"> <br><br> <h3 class="warn"style="padding-bottom: 155px;"><i class="fa fa-info"></i> In <small> dieser Galerie <strong class="warn"> ' .
                    $name . ' </strong> gibt es noch keine Bilder. </small></h3> </div>';
                    $responseJson = new \stdClass();
                    $responseJson->message = $res;
                    $responseJson->status = false;
                    return $result = $responseJson;
                }
                if (!in_array($this->_limit, $this->options['select_limit'])){
                    $this->_limit = $this->options['_limit'];
                }
                $return = $this->get_galerie();
                $responseJson = new \stdClass();
                $responseJson->total = $return['total'];
                $responseJson->limit = $return['limit'];
                $responseJson->last = $return['last'];
                $responseJson->beschreibung = $this->beschreibung;
                $responseJson->pagination = $return['pagination'];
                $responseJson->template = $return['template'];
                $result = $responseJson;
                break;
            default:
                $result = '';
                break;
        }
        return $result;
    }
}
?>