<?php
/**
 * ArtPicture Plugin PHP Class
 * http://art-pictureDesign.de/WP-ArtTheme-Galerie
 * Copyright 2017, Jens Wiecker
 * https://art-picturedesign.de
 *
 */
@session_start();
if ( ! defined( 'ABSPATH' ) ) exit;
$sessionID = strtoupper(md5(@session_id()));
if(isset($_SESSION['login']) && $_SESSION["login"] == "12067101" && $_SESSION['SID'] == $sessionID ){
include('header-sites.php');
wp_logout();    
$img_url= plugins_url('../../../assets/images/help_images/help-user/',__FILE__);
$template='
<div class="container">
<ul class="media-list">
<li class="media">
<div class="media-body">
<h3 class="grey"><span class="warn fa fa-angle-double-right"></span><b class="warn"> Startseite</b> Freigaben.</h3>
   <div class="col-md-11 col-md-offset-1">
   <hr class="hr-footer">
   <br />
  <div class="media ">
  <div class="media-left ">
  <a data-gallery="" title="Freigaben Startseite" href="'.$img_url.'user-freigaben-start-xl.jpg"> <img class="media-object" src="'.$img_url.'user-freigaben-start.jpg"height="90"width="90" alt="auswahl-start"style="border: 1px solid orange;"></a>
    </a>
  </div>
    <div class="media-body media-middle">
    <span class="grey"> Auf dieser Seite finden Sie eine &Uuml;bersicht aller Galerien die f&uuml;r Sie freigegeben sind.<br />
    Es wird der Galerie-Name und die Anzahl der Bilder f&uuml;r jede Galerie angezeigt. Falls der Galeriename mehr als 20 Zeichen hat, wird dieser mit 3 Punkten abgek&uuml;rzt.</span>
    </div>
  </div>
  <br />
 <hr class="hr-footer">
 </div>
  <br />
  <hr class="hr-light">
  <br />
  </div>
  </li>
  </ul>
  <br />
  <hr class="hr-light">
  <br />  
<ul class="media-list">
<li class="media">
<div class="media-body">
 <h3 class="grey"><span class="warn fa fa-angle-double-right"></span><b class="warn"> Galerie</b> Typ.</h3>
 <span class="grey"> Es gibt insgesamt 3 verschiedene Galerie-Typen. Welche Galerie Sie sehen k&ouml;nnen,<br />
  h&auml;ngt vom <a href="mailto:'.get_option('admin_email').'"><b class="warn"> Administrator</b></a> der Galerie ab. Unterschiede einzelner Typen, finden Sie unter<a href="#galerietyp"><b class="prem"> Galerie Optionen.</b></a> </span>
   <div id="galerietyp" class="col-md-11 col-md-offset-1">
   <br />
   <hr class="hr-footer">
  <div class="media ">
  <div class="media-left ">
  <a data-gallery="" title="Galerie Typ 1" href="'.$img_url.'user-freigaben-typ1-xl.jpg"> <img class="media-object" src="'.$img_url.'user-freigaben-typ1.jpg"height="90"width="90" alt="auswahl-start"style="border: 1px solid orange;"></a>
    </a>
  </div>
    <div class="media-body media-middle">
    <h4 class="warn"><span class="warn fa fa-angle-double-right"></span> Galerie <small>TYP 1</small></h4>
   <span class="grey"> Der Galerietyp 1 ist eine &uuml;bersichtliche Auflistung und <a href="#optionen"><b class="prem"> Optionen</b></a> jedes einzelnen Bildes. </span>
    </div>
  </div><!--1-->
    <div class="media ">
  <div class="media-left ">
  <a data-gallery="" title="Galerie Typ 2" href="'.$img_url.'user-freigaben-typ2-xl.jpg"> <img class="media-object" src="'.$img_url.'user-freigaben-typ2.jpg"height="90"width="90" alt="auswahl-start"style="border: 1px solid orange;"></a>
    </a>
  </div>
<div class="media-body media-middle">
<h4 class="warn"><span class="warn fa fa-angle-double-right"></span> Galerie <small>TYP 2</small></h4>
   <span class="grey"> Der Galerietyp 2 ist eine Auflistung mit Fokus auf dem Bild und Kommentar des <a href="mailto:'.get_option('admin_email').'"><b class="warn"> Administrator</b></a>. </span>
    </div>
  </div><!--2-->
  <div class="media ">
  <div class="media-left ">
  <a data-gallery="" title="Galerie Typ 3" href="'.$img_url.'user-freigaben-typ3-xl.jpg"> <img class="media-object" src="'.$img_url.'user-freigaben-typ3.jpg"height="90"width="90" alt="auswahl-start"style="border: 1px solid orange;"></a>
    </a>
  </div>
    <div class="media-body media-middle">
    <h4 class="warn"><span class="warn fa fa-angle-double-right"></span> Galerie <small>TYP 3</small></h4>
   <span class="grey"> Der Galerietyp 3 ist ein Grid aller Bilder. Die vesrchiedenen  <a href="#optionen"><b class="prem"> Optionen</b></a> sind zu sehen, wenn Sie mit der Maus &uuml;ber das Bild fahren. </span>
    </div>
  </div><!--3-->
  <br /><br />
  <hr class="hr-footer">
 </div> 
</li>
</ul>
<br />
  <hr class="hr-light">
  <br />
<ul id="optionen" class="media-list">
<li class="media">
 <h3 class="grey"><span class="warn fa fa-angle-double-right"></span><b class="warn"> Galerie</b> Optionen.</h3>
 <span class="grey"> Es gibt verschiedene Optionen, die vom <a href="mailto:'.get_option('admin_email').'"><b class="warn"> Administrator</b></a> aktiviert oder deaktiviert werden k&ouml;nnen.
   <div class="col-md-11 col-md-offset-1">
   <br />
   <hr class="hr-footer">
  <div class="media ">
  <div class="media-left" style="padding-top: 25px;">
  <a data-gallery=""  title="Button nicht aktiv " href="'.$img_url.'freigaben-no-xl.jpg"> <img class="media-object" src="'.$img_url.'freigaben-no.jpg"height="30"width="90" alt="auswahl-start"style="border: 1px solid orange;"></a>
    </a>
  </div>
<div class="media-body media-middle">
    <h4 class="warn"><span class="warn fa fa-angle-double-right"></span> Button <small> deaktiviert</small></h4>
   <span class="grey"> Wenn Optionen deaktiviert sind, wird der Text "NO" auf den Button angezeigt. Eine Ausnahme ist der Button f&uuml;r die Beschreibung. Der Button-Text "NO" bedeutet hier, dass keine Bildbeschreibung vorhanden ist.  </span>
    </div>
  </div><!--1-->
    <div class="media ">
  <div class="media-left"  style="padding-top: 35px;">
  <a data-gallery="" title="Button aktiv" href="'.$img_url.'freigaben-yes-xl.jpg"> <img class="media-object" src="'.$img_url.'freigaben-yes.jpg"height="90"width="90" alt="auswahl-start"style="border: 1px solid orange;"></a>
    </a>
  </div>
    <div class="media-body media-middle">
    <h4 class="warn"><span class="warn fa fa-angle-double-right"></span> Button <small> aktiviert</small></h4>
    </div>
  </div><!--2-->
  <div class="media ">
  <div class="media-left "style="padding-top: 35px;">
  <a data-gallery="" title="Button bsp." href="'.$img_url.'btn-bsp-xl.jpg"> <img class="media-object" src="'.$img_url.'btn-bsp.jpg"height="90"width="90" alt="auswahl-start"style="border: 1px solid orange;"></a>
    </a>
  </div>
    <div class="media-body media-middle">
    <h4 class="warn"><span class="warn fa fa-angle-double-right"></span> Button <small> Farben</small></h4>
   <span class="grey">Es gibt verschiedene Zust&auml;nde einzelner Button die folgende Bedeutung haben:<br /><br /> 
  <ul class="list-group">
  <b class="prem">&nbsp;&nbsp;GPS/ EXIF:</b> <span class="grey">&nbsp;im Bild vorhanden.</span><div class="col-md-1" style="background-color: #5cb85c;height: 15px; display: block;"></div></li>
  <li><b class="prem">&nbsp;&nbsp;EXIF:</b> <span class="grey">&nbsp;wenige DATEN im Bild.</span> <div class="col-md-1" style="background-color: orange;height: 15px; display: block;"></div></li>
  <b class="prem">&nbsp;&nbsp;GPS/ EXIF:</b> <span class="grey">&nbsp;keine Daten vorhanden.</span> <div class="col-md-1" style="background-color: #d9534f;height: 15px; display: block;"></div></li>
  </ul>
  </span>
  </div>
  </div><!--3-->
 <br /><br />
  <hr class="hr-footer">
 </div>
</li>
</ul>
 <br /><br />
<hr class="hr-light">
<br /> 
<ul class="media-list">
<li class="media">
 <h3 class="grey"><span class="warn fa fa-angle-double-right"></span><b class="warn"> Galerie</b> Fenster.</h3>
 <span class="grey"> Hier sehen Sie Beispiele f&uuml;r die EXIF und GPS Fenster.
 <div class="col-md-11 col-md-offset-1">
  <br />
  <hr class="hr-footer">
  <div class="media ">
  <div class="media-left" style="padding-top: 25px;">
  <a data-gallery=""  title="Exif Daten aus dem Bild" href="'.$img_url.'exif-xl.jpg"> <img class="media-object" src="'.$img_url.'exif.jpg"height="90"width="90" alt="auswahl-start"style="border: 1px solid orange;"></a>
    </a>
  </div>
    <div class="media-body media-middle">
    <h4 class="warn"><span class="warn fa fa-angle-double-right"></span> Galerie <small> EXIF</small></h4>
   <span class="grey"> Hier sehen Sie ein Beispiel mit Daten aus dem Bild.    </span>
    </div>
  </div><!--1-->
    <div class="media ">
  <div class="media-left"  style="padding-top: 35px;">
  <a data-gallery="" title="GPS Daten aus dem Bild" href="'.$img_url.'gps-xl.jpg"> <img class="media-object" src="'.$img_url.'gps.jpg"height="90"width="90" alt="auswahl-start"style="border: 1px solid orange;"></a>
    </a>
  </div>
    <div class="media-body media-middle">
  <h4 class="warn"><span class="warn fa fa-angle-double-right"></span> Galerie <small> GPS</small></h4>
   <span class="grey"> Hier sehen Sie ein Beispiel mit GPS Daten aus dem Bild.    </span>  
  </div>
  </div><!--3-->
  <br /><br />
  <hr class="hr-footer">
</div> 
</li>
</ul>
<br /><br />
<hr class="hr-light">
<br /> 
<ul class="media-list">
<li class="media">
 <h3 class="grey"><span class="warn fa fa-angle-double-right"></span><b class="warn"> Galerie</b> Fehlermeldungen.</h3>
 <span class="grey"> M&ouml;gliche Meldungen.
 <div class="col-md-11 col-md-offset-1">
 <br />
 <hr class="hr-footer">
 <div class="media ">
 <div class="media-left" style="padding-top: 25px;">
  <a data-gallery=""  title="Meldung keine Freigabe" href="'.$img_url.'keine-freigabe-xl.jpg"> <img class="media-object" src="'.$img_url.'keine-freigabe.jpg"height="90"width="90" alt="auswahl-start"style="border: 1px solid orange;"></a>
    </a>
  </div>
<div class="media-body media-middle">
  <h4 class="warn"><span class="warn fa fa-angle-double-right"></span> keine <small> Freigaben</small></h4>
    <span class="grey">Sie sehen folgende Meldung, wenn f&uuml;r Sie keine Galerie freigegeben ist. Wenden Sie sich an den <a href="mailto:'.get_option('admin_email').'"><b class="warn"> Administrator</b></a><br /> 
   um Bilder freizugeben.    </span>  
    </div>
  </div><!--1-->
    <div class="media ">
  <div class="media-left"  style="padding-top: 35px;">
  <a data-gallery="" title="Nachricht deaktiviert" href="'.$img_url.'nachricht-deaktiviert-xl.jpg"> <img class="media-object" src="'.$img_url.'nachricht-deaktiviert.jpg"height="90"width="90" alt="auswahl-start"style="border: 1px solid orange;"></a>
    </a>
  </div>
    <div class="media-body media-middle">
    <h4 class="warn"><span class="warn fa fa-angle-double-right"></span> Nachricht <small> deaktiviert</small></h4>
       <span class="grey"> Diese Meldung ist aktiv, wenn das Senden von Nachrichten deaktiviert ist.    </span>  
      </div>
  </div><!--3-->
  <br /><br />
  <hr class="hr-footer">
</div> 
</li>
</ul>
 <br /><br />
<hr class="hr-light">
<br /> 
<ul class="media-list">
<li class="media">
 <h3 class="grey"><span class="warn fa fa-angle-double-right"></span><b class="warn"> Bilder</b> Auswahl.</h3>
 <div class="col-md-11 col-md-offset-1">
  <br />
  <hr class="hr-footer">
  <div class="media ">
  <div class="media-left" style="padding-top: 25px;">
 <a data-gallery=""  title="Bilder Auswahl Startseite" href="'.$img_url.'auswahl-start-xl.jpg"> <img class="media-object" src="'.$img_url.'auswahl-start.jpg"height="90"width="90" alt="auswahl-start"style="border: 1px solid orange;"></a>
</a>
 </div>
    <div class="media-body media-middle">
    <h4 class="warn"><span class="warn fa fa-angle-double-right"></span> Auswahl <small> Startseite</small></h4>
   <span class="grey"> Hier sehen Sie eine &Uuml;bersicht aller Bilder, die Sie aus einer Galerie ausgew&auml;hlt haben.    </span>
    </div>
  </div><!--1-->
<div class="media ">
  <div class="media-left"  style="padding-top: 35px;">
  <a data-gallery="" title="Bilder Auswahl detail" href="'.$img_url.'select-xl.jpg"> <img class="media-object" src="'.$img_url.'select.jpg"height="90"width="90" alt="auswahl-start"style="border: 1px solid orange;"></a>
</a>
  </div>
    <div class="media-body media-middle">
    <h4 class="warn"><span class="warn fa fa-angle-double-right"></span> Auswahl <small> Ansicht</small></h4>
     <span class="grey"> Die gew&auml;hlten Bilder werden als Grid angezeigt.</span>
      </div>
  </div><!--2-->
  <br /><br />
  <hr class="hr-footer">
 </div> 
</li>
</ul>
 <br /><br />
<br /></div><div class="container"style="padding-top: 25px;"> 
    <hr class="hr-light">
    <p><a class="grey" role="button" href="'.ART_PICTURE_URL.'" target="_blank"> <i class="grey glyphicon glyphicon-copyright-mark"></i><b class="warn">Art</b><b class="grey">Picture Design '. date('Y').'</b></a> </p>    
    </div>';
$template = preg_replace(array('/<!--(.*)-->/Uis',"/[[:blank:]]+/"),array('',' '),str_replace(array("\n","\r","\t"),'',$template));
echo $template; 
apg_bluemGallery_select();
include('footer.php');
}else{
$extra = site_url().'?apg-user-gallery-template=12067102';
@header("Location: $extra");    
}
?>



