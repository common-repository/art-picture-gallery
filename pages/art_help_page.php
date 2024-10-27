<?php 
/**
 * ArtPicture Plugin PHP Class
 * http://art-pictureDesign.de/WP-ArtTheme-Galerie
 * Copyright 2017, Jens Wiecker
 * https://art-picturedesign.de
 *
 */
$img_url =plugins_url('../assets/images/help_images/help-wp/',__FILE__) ;
$template = '<div class="bootstrap-wrapper">
<div id="page-wrap">
<div id="top"</div>    

    <div class="container well">
    <h3 class="warn text-center">Art<b class="grey">Picture Galerie <small>Hilfe</small></b></h3>
        <hr class="hr-light">
      <p class="text-center grey">Hier finden Sie eine ausführliche Hilfe zu den verschieden Funktionen des Plugins.  </p>
        <br><br>
        <h1 class="warn"><span class="fa fa fa-lightbulb-o"></span> Hilfe <small>Übersicht</small></h1>
        <br>
        <hr class="hr-light">
        <br>
                             <span class="prem fa fa-info-circle fa-2x"></span>   <b class="prem">Die Login Url des User-Templates ist:</b><br>
                       <a class="grey" role="button" href="'.site_url().'?apg-user-gallery-template=12067102" target="_blank">'.site_url().'?apg-user-gallery-template=12067102</a>
        <br><br><br>
        
         <div class="row">
         <div class="col-md-4">
         <h4 class="warn"><span class="grey fa fa-camera"></span> Galerie <small>Startseite & Symbole</small></h4> 
         <div class="table-responsive">
         <table class="table">
        <tr>
        <td colspan="1">
            <div align="right"> <b class="warn fa fa-arrow-right fa-2x "></b></div>  
        </td >
        <td>
            <b class="galerie_help_font"><a class="prem"  role="button" href="#galerie_erstellen"> Galerie erstellen</a></b>    
        </td>    
        </tr>  
       <tr>
        <td colspan="1">
            <div align="right"> <b class="warn fa fa-arrow-right fa-2x "></b></div>  
        </td >
        <td>
            <b class="galerie_help_font"><a class="prem"  role="button" href="#galerie-auswahl"> Galerie Auswahl</a></b>    
        </td>    
        </tr>     
        <tr>
        <td colspan="1">
            <div align="right"> <b class="warn fa fa-arrow-right fa-2x "></b></div>  
        </td >
        <td>
            <b class="galerie_help_font"><a class="prem"  role="button" href="#galerie-loeschen"> Galerie löschen</a></b>    
        </td>    
        </tr>
         <tr>
        <td colspan="1">
            <div align="right"> <b class="warn fa fa-arrow-right fa-2x "></b></div>  
        </td >
        <td>
            <b class="galerie_help_font"><a class="prem"  role="button" href="#galerie_bearbeiten"> Galerie bearbeiten</a></b>    
        </td>    
        </tr>
        <tr>
        <td colspan="1">
            <div align="right"> <b class="warn fa fa-arrow-right fa-2x "></b></div>  
        </td >
        <td>
            <b class="galerie_help_font"><a class="prem"  role="button" href="#galerie_symbole"> Galerie Symbole</a></b>    
        </td>    
        </tr>
        <tr>
        <td colspan="1">
            <div align="right"> <b class="warn fa fa-arrow-right fa-2x "></b></div>  
        </td >
        <td>
            <b class="galerie_help_font"><a class="prem"  role="button" href="#exif_gps"> Exif /GPS</a></b>    
        </td>    
        </tr>     
        </table>
        </div>    
        </div>
        <div class="col-md-4">
                 <h4 class="warn"><span class="grey fa fa-camera"></span> Galerie <small>Benutzer & Response</small></h4> 
        <div class="table-responsive">
            <table class="table">
        <tr>
        <td colspan="1">
            <div align="right"> <b class="warn fa fa-arrow-right fa-2x "></b></div>  
        </td >
        <td>
            <b class="galerie_help_font"><a class="prem"  role="button" href="#neuer_benutzer"> neuer Benutzer</a></b>    
        </td>    
        </tr>  
       <tr>

        <td colspan="1">
            <div align="right"> <b class="warn fa fa-arrow-right fa-2x "></b></div>  
        </td >
        <td>
            <b class="galerie_help_font"><a class="prem"  role="button" href="#benutzer_settings"> Benutzer Settings</a></b>    
        </td>    
        </tr>     
        <tr>
        <td colspan="1">
            <div align="right"> <b class="warn fa fa-arrow-right fa-2x "></b></div>  
        </td >
        <td>
            <b class="galerie_help_font"><a class="prem"  role="button" href="#benutzer_message"> Benutzer Message</a></b>    
        </td>    
        </tr>
         <tr>
        <td colspan="1">
            <div align="right"> <b class="warn fa fa-arrow-right fa-2x "></b></div>  
        </td >
        <td>
            <b class="galerie_help_font"><a class="prem"  role="button" href="#new_freigabe"> neue Freigabe</a></b>    
        </td>    
        </tr>
        <tr>
        <td colspan="1">
            <div align="right"> <b class="warn fa fa-arrow-right fa-2x "></b></div>  
        </td >
        <td>
            <b class="galerie_help_font"><a class="prem"  role="button" href="#freigabe_settings"> Freigabe Settings</a></b>    
        </td>    
        </tr>
        <tr>
        <td colspan="1">
            <div align="right"> <b class="warn fa fa-arrow-right fa-2x "></b></div>  
        </td >
        <td>
            <b class="galerie_help_font"><a class="prem"  role="button" href="#galerie_typ"> Galerie Typ</a></b>    
        </td>    
        </tr>
         <tr>
        <td colspan="1">
            <div align="right"> <b class="warn fa fa-arrow-right fa-2x "></b></div>  
        </td >
        <td>
            <b class="galerie_help_font"><a class="prem"  role="button" href="#galerie_response"> Galerie Response</a></b>    
        </td>    
        </tr>    
        </table> 
        </div>  
        </div>
        <div class="col-md-4">
        <h4 class="warn"><span class="grey fa fa-camera"></span> Wordpress <small>Galerie, Widgets & Settings</small></h4> 
        <div class="table-responsive">
                        <table class="table">
        <tr>
        <td colspan="1">
            <div align="right"> <b class="warn fa fa-arrow-right fa-2x "></b></div>  
        </td >
        <td>
            <b class="galerie_help_font"><a class="prem"  role="button" href="#site_erstellen"> Art-Picture Seiten</a></b>    
        </td>    
        </tr>  
       <tr>
        <td colspan="1">
            <div align="right"> <b class="warn fa fa-arrow-right fa-2x "></b></div>  
        </td >
        <td>
            <b class="galerie_help_font"><a class="prem"  role="button" href="#galerie_widgets"> Art-Picture Galerie Widgets</a></b>    
        </td>    
        </tr>     
        <tr>
        <td colspan="1">
            <div align="right"> <b class="warn fa fa-arrow-right fa-2x "></b></div>  
        </td >
        <td>
            <b class="galerie_help_font"><a class="prem"  role="button" href="#email_settings"> E-Mail Settings</a></b>    
        </td>    
        </tr>
         <tr>
        <td colspan="1">
            <div align="right"> <b class="warn fa fa-arrow-right fa-2x "></b></div>  
        </td >
        <td>
            <b class="galerie_help_font"><a class="prem"  role="button" href="#google_maps"> Google Maps Api-KEY</a></b>    
        </td>    
        </tr>
       <!-- <tr>
        <td colspan="1">
            <div align="right"> <b class="warn fa fa-arrow-right fa-2x "></b></div>  
        </td >
        <td>
            <b class="galerie_help_font"><a class="prem"  role="button" href="#system_settings"> System Settings</a></b>    
        </td>    
        </tr>-->
        <tr>
        <td colspan="1">
            <div align="right"> <b class="warn fa fa-arrow-right fa-2x "></b></div>  
        </td >
        <td>
            <b class="galerie_help_font"><a class="prem"  role="button" href="#license_key"> Art-Picture License KEY</a></b>    
        </td>    
        </tr>     
        </table> 
        </div>   
        </div>
        
        </div>
        <br>
        <hr class="hr-light">
        
        <br><br>
        <hr class="hr-footer">
        <h2 class="warn"><span class="grey fa fa-camera"></span> Galerie <small>Startseite</small></h2>
        <br>
        
       <!---Galerie erstellen---> 
        
      <hr class="hr-footer">
      <div id="galerie_erstellen" class="panel-body">
       
        <h3 class="warn panel-titel">
           <span class="grey fa fa-arrow-right "></span> Galerie <small>erstellen</small>
          </h3> 
             <p class="grey list-group-item-text"><b><span class="prem fa fa-question-circle "></span> So erstellen Sie eine Galerie und laden Bilder hoch.</b></p><br>
        <div class="row">  
        <div class="col-md-3">    
       <h4 class="prem">1. Galerie erstellen</h4></li> <a data-gallery="details" href="'.$img_url.'/create_new_gallery.jpg" title="Galerie erstellen">
        <img src=" '.$img_url.'/create_new_gallery_small.jpg"  class="img-responsive img-thumbnail" alt="galerie erstellen"></a>
          <br><b class="grey"> Geben Sie einen Galerienamen und optional eine Beschreibung ein.</b>
          </div>
          <div class="col-md-3">
            <h4 class="prem">2. Bilder upload</h4></li> <a data-gallery="details" href="'. $img_url.'/create_new_gallery_upload.jpg" title="Bilder Upload">
        <img src="'.$img_url.'/create_new_gallery_upload_small.jpg"  class="img-responsive img-thumbnail" alt="galerie erstellen"></a>
          <br><b class="grey"> Es wird die Seite zum Bildupload geöffnet und Sie können ihre erstellte Galerie auswählen oder eine neue Galerie erstellen.</b>
        </div>
       <div class="col-md-3">
            <h4 class="prem">3. Bilder upload</h4></li> <a data-gallery="details" href="'. $img_url.'/create_new_gallery_upload_drei.jpg" title="Bilder Upload">
        <img src="'.$img_url.'/create_new_gallery_upload_drei_small.jpg"  class="img-responsive img-thumbnail" alt="galerie erstellen"></a>
          <br><b class="grey"> Sie können nun ihre Bilder per DRAG & DROP in das Fenster ziehen, oder mit dem Button Bilder auswählen und hochladen.</b>
        </div> 
        <div class="col-md-3">
        <h4 class="prem">4. Bilder upload</h4></li> <a data-gallery="details" href="'. $img_url.'/create_new_gallery_upload_vier.jpg" title="Bilder Upload">
        <img src="'. $img_url.'/create_new_gallery_upload_vier_small.jpg"  class="img-responsive img-thumbnail" alt="galerie erstellen"></a>
         <br><b class="grey"> Bei erfolgreichen Upload sehen Sie die Bilder in einer Übersicht. Ein fehlgeschlagener Upload wird mit einer Fehlermeldung angezeigt.</b>
        </div> 
    </div> 
    <br>
     <hr class="hr-light">
    <br> 
    </div>

  <!---Galerie erstellen---> 
  <!---Galerie auswahl---> 
      <div id="galerie-auswahl" class="panel-body">
           <h3 class="warn panel-titel">
           <span class="grey fa fa-arrow-right "></span> Galerie <small>auswahl</small>
          </h3>    
         <p class="grey list-group-item-text"><b><span class="prem fa fa-question-circle "></span> So wählen Sie eine Galerie aus und sehen alle Details.</b></p><br> 
        <div class="row">  
        <div class="col-md-4">    
       <h4 class="prem">1. Galerie wählen</h4></li> <a data-gallery="details" href="'.$img_url.'/galerie_waehlen.jpg" title="Galerie wählen">
            
        <img src="'. $img_url.'/galerie_waehlen_small.jpg"  class="img-responsive img-thumbnail" alt="galerie erstellen"></a>
          <br><b class="grey"> Wählen Sie ihre Galerie über die Selectauswahl aus.</b>
       
          </div>
          <div class="col-md-4">
            <h4 class="prem">2. Galerie Grid</h4></li> <a data-gallery="details" href="'. $img_url.'/galerie_waehlen_zwei.jpg" title="Galerie Grid">
        <img src="'. $img_url.'/galerie_waehlen_zwei_small.jpg"  class="img-responsive img-thumbnail" alt="galerie erstellen"></a>
          <br><b class="grey"> Nachdem Sie ihre Galerie ausgewählt haben, werden die Bilder in einer Grid Ansicht geladen. Wenn Sie mit der Maus über die einzelnen Bilder fahren, sehen Sie einige Bildinformationen und Optionen.</b>
        </div>
       <div class="col-md-4">
            <h4 class="prem">3. Galerie Liste</h4></li> <a data-gallery="details" href="'. $img_url.'/galerie_waehlen_liste.jpg" title="Galerie Liste">
        <img src="'. $img_url.'/galerie_waehlen_liste_small.jpg"  class="img-responsive img-thumbnail" alt="galerie erstellen"></a>
          <br><b class="grey"> In der Ansicht Liste sehen Sie viele weitere Informationen. Die einzelnen Button und Funktionen werden unter "Symbole Galerie Liste" näher erklärt.</b>
        </div> 
    </div>
    <br> <hr class="hr-light"><div class="pull-right"><h4><a  class="prem" href="#top">Top</a></h4></div> 
</div>
  <!---Galerieauswahl---> 
  <!---Galerie-löschen--->

   <div id="galerie-loeschen" class="panel-body">
          <h3 class="warn panel-titel">
           <span class="grey fa fa-arrow-right "></span> Galerie <small> oder einzelne Bilder löschen</small>
          </h3>    
         <p class="grey list-group-item-text"><b><span class="prem fa fa-question-circle "></span> So löschen Sie eine Galerie oder einzelne Bilder aus einer Galerie.</b></p><br>   
       <div class="row">
              <div class="col-md-4">
            <h4 class="prem">Galerie löschen</h4></li> <a data-gallery="details" href="'. $img_url.'/galerie_delete.jpg" title="Galerie Liste">
        <img src="'. $img_url.'/galerie_delete_small.jpg"  class="img-responsive img-thumbnail" alt="galerie erstellen"></a>
          <br><b class="grey"> Wählen Sie die zu löschende Galerie aus. Bedenken Sie das alle Freigaben, Benachrichtigungen und ausgewählte Bilder gelöscht werden.</b>
        </div> 
       
              <div class="col-md-4">
            <h4 class="prem">einzelne Bilder löschen (list Ansicht)</h4></li> <a data-gallery="details" href="'. $img_url.'/bild_loeschen_list.jpg" title="Galerie Liste">
        <img src="'. $img_url.'/bild_loeschen_list_small.jpg"  class="img-responsive img-thumbnail" alt="galerie erstellen"></a>
          <br><b class="grey"> Wählen Sie das zu löschende Bild aus. </b>
        </div>
              <div class="col-md-4">
            <h4 class="prem">einzelne Bilder löschen (Grid Ansicht)</h4></li> <a data-gallery="details" href="'. $img_url.'/bild_loeschen.jpg" title="Galerie Liste">
        <img src="'. $img_url.'/bild_loeschen_small.jpg"  class="img-responsive img-thumbnail" alt="galerie erstellen"></a>
          <br><b class="grey"> Wählen Sie das zu löschende Bild aus.</b>
        </div>

</div><!--row-->
  
</div>
<br> <hr class="hr-light"><br><div class="pull-right"><h4><a  class="prem" href="#top">Top</a></h4></div> <br>   
<!---Galerie-löschen--->  
<!---Galerie-bearbeiten---> 
      <div id="galerie_bearbeiten" class="panel-body">
          <h3 class="warn panel-titel">
           <span class="grey fa fa-arrow-right "></span> Galerie <small>bearbeiten</small>
          </h3> 
            <p class="grey list-group-item-text"><b><span class="prem fa fa-question-circle "></span> So fügen Sie Tags und eine Beschreibung zu der erstellten Galerie hinzu.</b></p><br> 
          
        <div class="row">  
        <div class="col-md-4">    
       <h4 class="prem">1. Galerie Details</h4> <a data-gallery="details" href="'. $img_url.'/galerie_bearbeiten.jpg" title="Galerie wählen">
            
        <img src="'.$img_url.'/galerie_bearbeiten_small.jpg"  class="img-responsive img-thumbnail" alt="galerie erstellen"></a>
          <br><b class="grey"> Sie sehen eine Übersicht und einige Details der erstellten Galerien.</b>
       
          </div>
          <div class="col-md-4">
            <h4 class="prem">2. Galerie bearbeiten</h4> <a data-gallery="details" href="'. $img_url.'/galerie_details_bearbeiten.jpg" title="Galerie Grid">
        <img src="'. $img_url.'/galerie_details_bearbeiten_small.jpg"  class="img-responsive img-thumbnail" alt="galerie erstellen"></a>
          <br><b class="grey">Klicken Sie auf bearbeiten und vergeben Sie Schlagwörter und eine Beschreibung ihrer erstellten Galerie.</b>
        </div>
       <div class="col-md-4">
            <h4 class="prem">3. Galerie löschen</h4> <a data-gallery="details" href="'. $img_url.'/galerie_details_delete.jpg" title="Galerie Liste">
        <img src="'. $img_url.'/galerie_details_delete_small.jpg"  class="img-responsive img-thumbnail" alt="galerie erstellen"></a>
          <br><b class="grey"> Auch hier können Sie die einzelnen Galerien löschen.</b>
        </div> 
    </div>
<br>
      <hr class="hr-light"><div class="pull-right"><h4><a  class="prem" href="#top">Top</a></h4></div>
      </div>
<!---Galerie-bearbeiten--->         
<!---Galerie-Symbole---> 

      <div id="galerie_symbole" class="panel-body">
        <h3 class="warn panel-titel">
           <span class="grey fa fa-arrow-right "></span> Galerie <small> Symbole</small>
          </h3> 
            <p class="grey list-group-item-text"><b><span class="prem fa fa-question-circle "></span> Bedeutung einzelner Button in der Galerie-Detail-Ansicht.</b></p><br> 
      <div class="row">
        <div class="col-md-3">    
       <h4 class="prem">Button Details</h4><a data-gallery="details" href="'. $img_url.'button_details.jpg" title="Galerie wählen">
         <img src="'. $img_url.'/button_details_small.jpg"  class="img-responsive img-thumbnail" alt="galerie erstellen"></a>
         </div>
        <div class="col-md-3">
             <h4 class="prem">Button Farben</h4>
            <span class="grey">Es gibt veschiedene Zustände einzelner Button die folgende Bedeutung haben:<br><br></span>
         <ul class="list-group"> <b class="prem">&nbsp;&nbsp;GPS/ EXIF:</b> <span class="grey">&nbsp;im Bild vorhanden.</span><div class="col-md-1" style="background-color: #5cb85c;height: 15px; display: block;"></div> <li><b class="prem">&nbsp;&nbsp;EXIF:</b> <span class="grey">&nbsp;wenige DATEN im Bild.</span> <div class="col-md-1" style="background-color: orange;height: 15px; display: block;"></div></li> <b class="prem">&nbsp;&nbsp;GPS/ EXIF:</b> <span class="grey">&nbsp;keine Daten vorhanden.</span> <div class="col-md-1" style="background-color: #d9534f;height: 15px; display: block;"></div> </ul>    
           </div>
           </div>
          
         <br>
 <hr class="hr-light"><br><div class="pull-right"><h4><a  class="prem" href="#top">Top</a></h4></div> 
 
      </div>
 <!---Galerie-Symbole--->       
<!---Galerie-EXIF/GPS---> 

      <div id="exif_gps" class="panel-body">
     <h3 class="warn panel-titel">
           <span class="grey fa fa-arrow-right "></span> Galerie <small>EXIF /GPS</small>
          </h3> 
           
        <div class="row">  
        <div class="col-md-4">    
       <h4 class="prem">1. Galerie Details</h4> <a data-gallery="details" href="'. $img_url.'/exif.jpg" title="Galerie wählen">
            
        <img src="'. $img_url.'/exif_small.jpg"  class="img-responsive img-thumbnail" alt="galerie erstellen"></a>
          <br><b class="grey"> Sie sehen zahlreiche Daten aus dem Bild.</b>
       
          </div>
          <div class="col-md-4">
            <h4 class="prem">2. Galerie GPS</h4> <a data-gallery="details" href="'. $img_url.'/gps.jpg" title="Galerie Grid">
        <img src="'. $img_url.'/gps_small.jpg"  class="img-responsive img-thumbnail" alt="galerie erstellen"></a>
          <br><b class="grey">GPS-Daten des Bildes.</b>
        </div>
       <div class="col-md-4">
            <h4 class="prem">3. GPS details</h4> 
          <br><b class="grey"> GPS-Daten sind nur in der <a role="button" href="'. ART_PICTURE_SALE.'" target="_blank"> <b class="dan">Pro</b><b class="grey">Version</a> verfügbar.</b><br> Die Angabe der Höhe (Drohne)
            bezieht sich aus dem GPS-Daten einer DJI Phantom Drohne. Die Höhe ist aus dem Daten der Drohne und den Daten von Google-Maps berechnet und zeigt in einigen Fällen nicht die korrekte Höhe an.
            </b>
        </div> 
    </div>
    <br>

   <br>
     <hr class="hr-light"><br><div class="pull-right"><h4><a  class="prem" href="#top">Top</a></h4></div>       
       </div>

<!---Galerie-EXIF/GPS---> 
<hr class="hr-footer"><br>
<h2 class="warn"><span class="grey fa fa-cogs "></span> Galerie <small>Benutzer</small></h2>
<br>
<hr class="hr-footer">
<!---Galerie-neuer-benutzer---> 
      <div  id="neuer_benutzer"class="panel-body">
       
         <h3 class="warn panel-titel">
       <span class="grey fa fa-arrow-right "></span> Galerie <small>neuer Benutzer</small>
          </h3>  
        <div class="row">  
        <div class="col-md-4">  <br>  
       <h4 class="prem">1. Benutzer erstellen</h4> <a data-gallery="details" href="'. $img_url.'/new_user.jpg" title="Galerie Hilfe">
            
        <img src="'. $img_url.'/new_user_small.jpg"  class="img-responsive img-thumbnail" alt="galerie erstellen"></a>
            <br><b class="grey"> Hier könen Sie <u>einen</u> neuen Benutzer anlegen. In der  <a role="button" href="'. ART_PICTURE_SALE.'" target="_blank"> <b class="dan">Pro</b><b class="grey">Version</a></b> können Sie unbegrenzt viele Benutzer anlegen.  </b>
       
          </div>
          <div class="col-md-4">
            <h4 class="prem">2. Zugangsdaten schicken</h4> 
          <b class="grey"> Diese Funktion ist nur in der <a role="button" href="'. ART_PICTURE_SALE.'" target="_blank"> <b class="dan">Pro</b><b class="grey">Version</a> aktiv.</b><br>
         Wenn diese Option aktiviert ist, werden die Zugangsdaten sofort per eMail an den Benutzer geschickt. Diese eMail enthält die Login-Adresse, Benutzername und Passwort. </b>
        </div>
       <div class="col-md-4">
            <h4 class="prem">3. Benutzer aktiv</h4> 
          <b class="grey"> Wählen Sie hier, ob der Benutzer sofort nach dem Erstellen aktiv ist. Diese Einstellung können Sie später in den Benutzer-Settings wieder ändern.</b>
        </div> 
    </div>
    <br>
 <hr class="hr-light"><br><div class="pull-right"><h4><a  class="prem" href="#top">Top</a></h4></div> 
      </div>
<!---Galerie-neuer-benutzer--->
<!---Galerie-benutzer-settings-->
      <div id="benutzer_settings" class="panel-body">
       <h3 class="warn panel-titel">
       <span class="grey fa fa-arrow-right "></span> Galerie <small> Benutzer Settings</small>
          </h3> 
      <div class="row">
        <div class="col-md-3">    
       <h4 class="prem">Benutzer Settings</h4><a data-gallery="details" href="'. $img_url.'/benutzer_settings.jpg" title="Galerie Benutzer Settings">
         <img src="'. $img_url.'/benutzer_settings_small.jpg"  class="img-responsive img-thumbnail" alt="Galerie Benutzer Settings"></a>
        <br><b class="grey"> Hier haben Sie eine Übersicht aller erstellten Benutzer.  </b>
          </div>
        <div class="col-md-3">
             <h4 class="prem">Benutzr Settings (details)</h4>
         
        <table class="table table-condensed">
        <tr>
            <td><h5 class="grey">User Aktiv</h5>
        </td> 
        <td>
        <h5 class="grey">Message</h5>
        </td>    
        </tr>
        <tr>
            <td> <b class="grey">Mit dieser Option wählen Sie, ob der Benutzer aktiviert ist.</b>
        </td>
            <td> <b class="grey">Ist diese Option aktiv, kann der Benutzer ihnen Nachrichten senden.</b> </td>    
        </tr>
        </table>
        <table class="table table-condensed">
        <tr>
            <td><h5 class="grey">eMail</h5>
        </td> 
        <td>
           <h5 class="grey">User Login</h5>
        </td>    
        </tr>
        <tr>
            <td><b class="grey">Ändern Sie hier die Email-Adresse des Galerie-Benutzers.</b>
        </td>
            <td><b class="grey">Hier sehen Sie den Loginname des Benutzers.</b> </td>    
        </tr>
        </table>    
                <table class="table table-condensed">
        <tr>
            <td><h5 class="grey">Notiz</h5>
        </td> 
        <td>
         <h5 class="grey">Email Senden</h5>
        </td>
 
        </tr>
        <tr>
            <td><b class="grey">Ändern Sie hier die Email-Adresse des Galerie-Benutzers.</b>
        </td>
            <td><b class="grey">Hier können Sie den Benutzer eine Email senden.</b> </td>  
       
        </tr>
        </table>             
           </div>
         <div class="col-md-3">
             <h4 class="prem">Benutzer Settings (details)</h4>
        <table class="table table-condensed">
        <tr>
            <td><h5 class="grey">neues Passwort</h5>
        </td> 
        <td>
        <h5 class="grey">Passwort senden</h5>
        </td>    
        </tr>
        <tr>
        <td><b class="grey">Ändern Sie das Passwort des Users. Beachten Sie, dass das eingebene<br>
            Passwort verschlüsselt gespeichert wird und nicht mehr<br> 
            als Klartext-Passwort angezeigt werden kann.</b> 
        </td>
        <td><b class="grey"> Diese Funktion ist nur in der <a role="button" href="'. ART_PICTURE_SALE.'" target="_blank"><b class="dan">Pro</b><b class="grey">Version</a> aktiv.</b><br>
            Ist diese Option aktiv, werden die neuen Zugangsdaten automatisch per eMail versendet.</b> </td>    
        </tr>
        </table>
  
           </div>
         <div class="col-md-3">
             <h4 class="prem">Email senden</h4>
         <b class="grey"> Diese Funktion ist nur in der <a role="button" href="'. ART_PICTURE_SALE.'" target="_blank"> <b class="dan">Pro</b><b class="grey">Version</a> aktiv.</b><br>
            Senden Sie eine Email an den Benutzer. Sie haben die Möglichkeit in den Settings, Email-Vorlagen zu erstellen. Wählen Sie hier eine Vorlage oder schreiben Sie ihre Nachricht in das Textfeld. </b>
            <a data-gallery="details" href="'. $img_url.'/mail_senden.jpg" title="Galerie Benutzer Settings"><br><br>
         <img src="'. $img_url.'/mail_senden_small.jpg"  class="img-responsive img-thumbnail" alt="Galerie Benutzer Settings"></a> 
           </div>
           </div><!--row-->
          <hr class="hr-light"><br><div class="pull-right"><h4><a  class="prem" href="#top">Top</a></h4></div> 
      </div>
<!---Galerie-benutzer-settings-->

<!---Galerie-benutzer-Message-->

      <div id="benutzer_message" class="panel-body">
              <h3 class="warn panel-titel">
       <span class="grey fa fa-arrow-right "></span> Galerie <small>Benutzer Message</small>
          </h3> 
        <div class="row">  
        <div class="col-md-4">    
       <h4 class="prem">1. Message Übersicht</h4> <a data-gallery="details" href="'. $img_url.'/message.jpg" title="Galerie wählen">
            
        <img src="'. $img_url.'/message_small.jpg"  class="img-responsive img-thumbnail" alt="galerie Hilfe"></a>
          <br><b class="grey"> Übersicht von allen erhaltenen Nachrichten nach Datum und Uhrzeit sortiert.</b>
       
          </div>
          <div class="col-md-4">
            <h4 class="prem">2. Message lesen</h4> <a data-gallery="details" href="'. $img_url.'/message_zwei.jpg" title="Galerie Grid">
        <img src="'. $img_url.'/message_zwei_small.jpg"  class="img-responsive img-thumbnail" alt="galerie erstellen"></a>
          <br><b class="grey">Klicken Sie auf die Nachricht um Sie zu lesen. Der Eintrag wird vergrößert und Sie können die komplette Nachricht lesen.</b>
        </div>
       <div class="col-md-4">
            <h4 class="prem">3. keine Message vorhanden</h4> 
           <a data-gallery="details" href="'. $img_url.'/message_drei.jpg" title="Galerie Grid">
        <img src="'. $img_url.'/message_drei_small.jpg"  class="img-responsive img-thumbnail" alt="galerie hilfe"></a>
                <br><b class="grey"> Diese Meldung wird angezeigt, wenn keine Nachrichten vorhanden sind.
            </b>
        </div>
    </div>
  <hr class="hr-light"><br><div class="pull-right"><h4><a  class="prem" href="#top">Top</a></h4></div>
       </div>
<!---Galerie-benutzer-Message-->
<!---Galerie-new-freiagbe-->
      <div id="new_freigabe" class="panel-body">
           <h3 class="warn panel-titel">
       <span class="grey fa fa-arrow-right "></span> Galerie <small>Freigabe erstellen</small>
          </h3> 
     <div class="row">        
        <div class="col-md-3 col-md-offset-2 text-right"> 
        <h4 class="prem">Freigabe erstellen</h4> <a data-gallery="details" href="'. $img_url.'/neue_freigabe.jpg" title="Galerie Hilfe">
            
        <img src="'.$img_url.'/neue_freigabe_small.jpg"  class="img-responsive img-thumbnail" alt="galerie erstellen"></a>
         </div>
            <div class="col-md-4"style="padding-top: 25px;">
                <b class="grey"> Hier könen Sie <b class="grey"><u class="dan">eine</u></b> neue Freigabe erstellen. Wählen Sie den Benutzer und die Galerie aus, die Sie freigeben wollen. Eine Galerie kann für verschiedene Benutzer freigegeben werden. In der Standard Version können Sie maximal <b class="grey"><u class="dan">10</u></b> Bilder und <b class="grey"><u class="dan">eine</u></b> Freigabe erstellen. Diese soll als Demo-Version dienen.  In der <a role="button" href="'. ART_PICTURE_SALE.'" target="_blank"> <b class="dan">Pro</b><b class="grey">Version</a></b> können Sie unbegrenzt viele Freigaben und Bilder erstellen. </b>
           </div>
      </div><!--row-->
      <hr class="hr-light"><br><div class="pull-right"><h4><a  class="prem" href="#top">Top</a></h4></div> 
      </div>
<!---Galerie-new-freiagbe-->
<!---Galerie-freiagbe-settings-->
      <div id="freigabe_settings" class="panel-body">
            <h3 class="warn panel-titel">
       <span class="grey fa fa-arrow-right "></span> Galerie <small>Benutzer-Settings</small>
          </h3>  
      <div class="row">
        <div class="col-md-4 text-center">    
       <h4 class="prem">Benutzer Settings</h4><a data-gallery="details" href="'. $img_url.'/freigabe_settings.jpg" title="Galerie Benutzer Settings">
         <img src="'. $img_url.'/freigabe_settings_small.jpg"  class="img-responsive img-thumbnail" alt="Galerie Benutzer Settings"></a><br>
        <br><b class="grey"> Hier haben Sie eine Übersicht aller Freigaben. Es stehen für jede Freigabe verschiedene Optionen zur Verfügung.</b>
          </div>
        <div class="col-md-4">
             <h4 class="prem">Freigabe Settings(1)</h4>
         <div style="min-height: 160px;">
        <table class="table table-condensed">
        <tr>
            <td><h5 class="grey">Freigabe Aktiv</h5>
        </td> 
        <td>
        <h5 class="grey">Benutzer</h5>
        </td>    
        </tr>
        <tr>
            <td> <b class="grey">Mit dieser Option können einzelne Freigaben für einen Benutzer ein-<br> oder ausgeschalten werden.<br> Diese Option ist wirkungslos,<br> wenn der Benutzer in den Benutzer-Settings deaktiviert ist.</b>
        </td>
            <td> <b class="grey">Loginname des Benutzers.</b> </td>    
        </tr>
        </table>
            </div>
        <table class="table table-condensed">
        <tr>
            <td><h5 class="grey">Message</h5>
        </td> 
        <td>
           <h5 class="grey">Check</h5>
        </td>    
        </tr>
        <tr>
             
            <td><b class="grey"> <b class="grey">Hier sehen Sie<br> eine Info, ob es Kommentare in dieser Freigabe gibt.</b> </td>  
                <td><b class="grey">Hier sehen Sie eine Info, ob Bilder in dieser Galerie ausgewählt sind.</b> </td>
        </tr>
        </table>    
                <table class="table table-condensed">
        <tr>
            <td><h5 class="grey">Freigabe</h5>
        </td> 
        <td>
         <h5 class="grey">Freigabe löschen</h5>
        </td>
 
        </tr>
        <tr>
            <td><b class="grey">Galeriename der Freigabe.</b>
        </td>
            <td><b class="grey">Hier können Sie einzelne <br>Freigaben löschen. Der Benutzer bleibt<br> auch ohne Freigaben aktiv.</b> </td>  
       
        </tr>
        </table>             
           </div>
         <div class="col-md-4">
             <h4 class="prem">Freigabe Settings(2)</h4>
        <table class="table table-condensed">
        <tr>
         <td><h5 class="grey">GPS</h5>
        </td> 
        <td>
        <h5 class="grey">Exif</h5>
        </td>    
        </tr>
            
        <tr>
        <td><b class="grey">Ist diese Option aktiv, kann der Benutzer die GPS-Daten des Bildes (soweit vorh.) sehen. </b> <br>
            <b class="grey"> Diese Funktion ist nur in der <a role="button" href="'. ART_PICTURE_SALE.'" target="_blank"> <b class="dan">Pro</b><b class="grey">Version</a> aktiv.</b><br>
        </td>
        <td><b class="grey"> 
            Ist diese Option aktiv, kann der Benutzer die "Exif-Daten" (soweit vorh.) des Bildes sehen.</b> </td>    
        </tr>
        </table>
    <table class="table table-condensed">
        <tr>
         <td><h5 class="grey">Auswahl</h5>
        </td> 
        <td>
        <h5 class="grey">Kommentar</h5>
        </td>    
        </tr>
          <tr>
             <td><b class="grey">Ist diese Option aktiv, kann der Galerie-Benutzer Kommentare zu jedem freig. Bild schreiben. Alle ausgew. Bilder und Kommentare können Sie unter "Galerie-Response" finden.</b>
        </td>
       <td><b class="grey">Ist diese Option aktiv, kann der Galerie-Benutzer Bilder auswählen. Alle ausgew. Bilder und Kommentare können Sie unter "Galerie-Response" finden.</b> </td>   
        </tr>
        </table>     
           </div>
           </div><!--row-->
           <hr class="hr-light"><br><div class="pull-right"><h4><a  class="prem" href="#top">Top</a></h4></div> 
      </div>
<!---Galerie-freiagbe-settings-->
<!---Galerie-typ-->
      <div id="galerie_typ" class="panel-body">
 <h3 class="warn panel-titel">
       <span class="grey fa fa-arrow-right "></span> Galerie <small>Varianten</small>
          </h3> 
        <div class="row">  
        <div class="col-md-4">    
       <h4 class="prem">Galerie Typ 1</h4> 
        <a data-gallery="details" href="'. $img_url.'/Galerie_typ1.jpg" title="Galerie Benutzer Settings">
         <img src="'. $img_url.'/Galerie_typ1_small.jpg"  class="img-responsive img-thumbnail" alt="Galerie Benutzer Settings"></a><br>
        <b class="grey"> Galerie Typ einer Darstellung der Bilder als Liste .</b>
        </div>
          <div class="col-md-4">
        <h4 class="prem">Galerie Typ 2</h4>
          <a data-gallery="details" href="'. $img_url.'/Galerie_typ2.jpg" title="Galerie Benutzer Settings">
         <img src="'. $img_url.'/Galerie_typ2_small.jpg"  class="img-responsive img-thumbnail" alt="Galerie Benutzer Settings"></a><br>
        <b class="grey"> Galerie Typ 2 ist eine übersichtliche Detailansicht.</b>
        </div>
       <div class="col-md-4">
            <h4 class="prem">Galerie Typ 3</h4> 
         <a data-gallery="details" href="'. $img_url.'/Galerie_typ3.jpg" title="Galerie Benutzer Settings">
         <img src="'. $img_url.'/Galerie_typ3_small.jpg"  class="img-responsive img-thumbnail" alt="Galerie Benutzer Settings"></a><br>
        <b class="grey"> Galerie Typ 3 ist eine Gridansicht.</b>
        </div> 
    </div>
    <hr class="hr-light"><br><div class="pull-right"><h4><a  class="prem" href="#top">Top</a></h4></div> 

       </div>
<!---Galerie-typ-->

<hr class="hr-footer"><br>
<h2 class="warn"><span class="grey fa fa-cogs "></span> Wordpress <small>Galerie und Widget</small></h2><br>
<hr class="hr-footer"><br>
<!---Galerie-seite_erstellen-->
      <div id="site_erstellen" class="panel-body">

         <h3 class="warn panel-titel">
       <span class="grey fa fa-arrow-right "></span> Galerie <small>in Wordpress erstellen</small>
          </h3>  
        <div class="row">  
        <div class="col-md-3">    
       <h4 class="prem">1. Galerie Button</h4></li> <a data-gallery="details" href="'. $img_url.'/button_new_site.jpg" title="Galerie erstellen">
        <img src="'. $img_url.'/button_new_site_small.jpg"  class="img-responsive img-thumbnail" alt="galerie erstellen"></a>
          <br><b class="grey"> Drücken Sie auf  Art-Picture Galerie Seiten und dann Erstellen.</b>
          </div>
          <div class="col-md-3">
            <h4 class="prem">2. Optionen</h4></li> <a data-gallery="details" href="'. $img_url.'/galerie_site_settings.jpg" title="Bilder Upload">
        <img src="'. $img_url.'/galerie_site_settings_small.jpg"  class="img-responsive img-thumbnail" alt="galerie erstellen"></a>
          <br><b class="grey"> Wählen Sie ihre Galerie aus und legen Sie den Galerie Typ fest. Die Option Bilder pro Reihe,  hat nur Auswirkungen auf den Galerie Typ "Grid und Details". Wenn Sie die Option Bilder pro Reihe auf all gestellt haben, wird keine Pagination eingeblendet. Mit der Einstellung "Content Position" bestimmen Sie ob ihr Text über oder unter der Galerie erscheint. Sie haben die 
          Möglichkeit Titel, Galeriebeschreibung und Tags ein- oder auszublenden.</b>
        </div>
       <div class="col-md-3">
            <h4 class="prem">3. Shortcode</h4></li> <a data-gallery="details" href="'. $img_url.'/menu_galerie_site.jpg" title="Bilder Upload">
        <img src="'. $img_url.'/menu_galerie_site_small.jpg"  class="img-responsive img-thumbnail" alt="galerie erstellen"></a>
          <br><b class="grey"> Nach dem Bestätigen ihrer Eingaben finden Sie unter Design -> Menüs einen neuen Eintrag "Art-Picture Seiten". Fügen Sie ihre neue Galerie dem Menü hinzu. Ist der Eintrag nicht vorhanden, klicken Sie bitte auf Ansicht anpassen und aktivieren Sie die Box Art-Picture Seiten.  </b>
        </div> 
        <div class="col-md-3">
        <h4 class="prem">4. Seite aufrufen</h4></li> <a data-gallery="details" href="'. $img_url.'/galerie_show_2.jpg" title="Bilder Upload">
        <img src="'. $img_url.'/galerie_show_2_small.jpg"  class="img-responsive img-thumbnail" alt="galerie erstellen"></a>
         <br><b class="grey"> Nach dem Speichen rufen Sie ihre erstellte Seite auf. Ihre Galerie ist nun mit ihren Einstellungen zu bestaunen.</b>
        </div> 
    </div> 
    <br>
    <hr class="hr-light"><br><div class="pull-right"><h4><a  class="prem" href="#top">Top</a></h4></div> 


    </div>
<!---Galerie-widget-->
      <div id="galerie_widgets" class="panel-body">

             <h3 class="warn panel-titel">
       <span class="grey fa fa-arrow-right "></span> Galerie <small>Widgets</small>
          </h3>   
          
        <div class="row">  
          <div class="col-md-3">
            <h4 class="prem">Galerie Widget</h4></li> <a data-gallery="details" href="'. $img_url.'/galerie_widget2.jpg" title="Galerie Grid">
        <img src="'. $img_url.'/galerie_widget2_small.jpg"  class="img-responsive img-thumbnail" alt="galerie erstellen"></a>
          <br><b class="grey"> Sie können eine Überschrift und einen Titel eingeben. Wählen Sie die gewünschte Galerie und die Anzahl der anzuzeigenden Bilder. Ist die Option "Zufall" aktiv,
         verändert sich die Reihenfolge der Bilder bei jedem Neuladen der Seite.   </b>
        </div>
          <div class="col-md-3">
            <h4 class="prem">Zufallsbild</h4></li> <a data-gallery="details" href="'. $img_url.'/galerie_widget3.jpg" title="Galerie Grid">
        <img src="'. $img_url.'/galerie_widget3_small.jpg"  class="img-responsive img-thumbnail" alt="galerie erstellen"></a>
          <br><b class="grey">  Wählen Sie die gewünschte Galerie und die Größe des anzuzeigenden Bildes aus.   </b>
        </div>
       <div class="col-md-3">
            <h4 class="prem">Galerie Login</h4></li> <a data-gallery="details" href="'. $img_url.'/galerie_widget4.jpg" title="Galerie Liste">
        <img src="'. $img_url.'/galerie_widget4_small.jpg"  class="img-responsive img-thumbnail" alt="galerie erstellen"></a>
          <br><b class="grey"></b>
        </div> 
       <div class="col-md-3">
            <h4 class="prem">alle Widgets </h4></li> <a data-gallery="details" href="'. $img_url.'/galerie_widget5.jpg" title="Galerie Liste">
        <img src="'. $img_url.'/galerie_widget5_small.jpg"  class="img-responsive img-thumbnail" alt="galerie erstellen"></a>
          <br>
       <a data-gallery="details" href="'. $img_url.'/galerie_widget6.jpg" title="Galerie Liste">
        <img src="'. $img_url.'/galerie_widget6_small.jpg"  class="img-responsive img-thumbnail" alt="galerie erstellen"></a>
       <br>
        <a data-gallery="details" href="'. $img_url.'/galerie_widget7.jpg" title="Galerie Liste">
        <img src="'. $img_url.'/galerie_widget7_small.jpg"  class="img-responsive img-thumbnail" alt="galerie erstellen"></a>
       </div> 
    </div>
    <br>
   <hr class="hr-light"><br><div class="pull-right"><h4><a  class="prem" href="#top">Top</a></h4></div> 
    
</div>
<!---Galerie-widget-->

 <hr class="hr-footer"><br>
<h2 class="warn"><span class="grey fa fa-cogs "></span> Galerie <small> Resposne</small></h2><br>
<hr class="hr-footer"><br>     

<!---Galerie-response-->
      <div id="galerie_response" class="panel-body">

             <h3 class="warn panel-titel">
       <span class="grey fa fa-arrow-right "></span> Galerie <small>Response Übersicht</small>
          </h3>  
        <div class="row">  
        <div class="col-md-3">    
       <h4 class="prem">Übersicht</h4> <a data-gallery="details" href="'. $img_url.'/galerie_response1.jpg" title="Galerie erstellen">
        <img src="'. $img_url.'/galerie_response1_small.jpg"  class="img-responsive img-thumbnail" alt="galerie erstellen"></a>
          <br><b class="grey">Die Response Startseite, zeigt alle Aktivitäten der User.</b>
          </div>
          <div class="col-md-3">
            <h4 class="prem">Response</h4> <a data-gallery="details" href="'. $img_url.'/galerie_response2.jpg" title="Bilder Upload">
        <img src="'. $img_url.'/galerie_response2_small.jpg"  class="img-responsive img-thumbnail" alt="galerie erstellen"></a>
          <br><b class="grey"> Hier können Sie alle Bilder sehen, die der Benutzer ausgewählt hat oder ein Kommentar zu einem Bild geschrieben hat.</b>
        </div>
       <div class="col-md-3">
            <h4 class="prem">Auswahl Optionen</h4></li> <a data-gallery="details" href="'. $img_url.'/galerie_response3.jpg" title="Bilder Upload">
        <img src="'. $img_url.'/galerie_response3_small.jpg"  class="img-responsive img-thumbnail" alt="galerie erstellen"></a>
          <br><b class="grey"> Sie können wählen ob nur ausgewählte Bilder, Bilder mit Kommentar oder alle Bilder angezeigt werden.</b>
        </div> 

    </div> 
    <br>
    <hr class="hr-light"><br><div class="pull-right"><h4><a  class="prem" href="#top">Top</a></h4></div>
  

    </div>
<!---Galerie-response-->

 <hr class="hr-footer"><br>
<h2 class="warn"><span class="grey fa fa-cogs "></span> Galerie <small> Settings</small></h2><br>
<hr class="hr-footer"><br>
<!---Galerie-email-settings-->
      <div id="email_settings" class="panel-body">
       <h3 class="warn panel-titel">
       <span class="grey fa fa-arrow-right "></span> Galerie <small>Email Settings</small>
          </h3> 
        <div class="row">  
        <div class="col-md-3">    
       <h4 class="prem">SMTP Settings</h4> <a data-gallery="details" href="'. $img_url.'/galerie_email1.jpg" title="Galerie erstellen">
        <img src="'. $img_url.'/galerie_email1_small.jpg"  class="img-responsive img-thumbnail" alt="galerie erstellen"></a>
          <br><b class="grey"> Tragen Sie hier die Benutzerdaten von ihrem Email-Provider ein. Als Vorlage ist ein Beispiel von Google Mail eingetragen.
            Drücken Sie anschließend Einstellungen Testen oder Test-Email senden.<br> <br><b class="grey"> Diese Funktion ist nur in der <a href=""> <b class="dan">Pro</b><b class="grey">Version</a> aktiv.</b><br> </b>
          </div>
          <div class="col-md-3">
            <h4 class="prem">Email Settings</h4> <a data-gallery="details" href="'. $img_url.'/galerie_email2.jpg" title="Bilder Upload">
        <img src="'. $img_url.'galerie_email2_small.jpg"  class="img-responsive img-thumbnail" alt="galerie erstellen"></a>
          <br><b class="grey">Sie können verschiedene Email-Vorlagen erstellen. Es stehen verschiedene Platzhalter zur Verfügung. Ausnahmen sind die Platzhalter [passwort], ###ABSEMAIL### und ###ABSURL### diese stehen  nur in den "Zugangsdaten eMail" Template zur Verfügung. Bei den Platzhaltern ###ABSEMAIL### und ###ABSURL### werden die Email-Adresse und die URL von ihrer Wordpress Registrierung eingetragen. </b><br><br><b class="grey"> Diese Funktion ist nur in der <a href=""> <b class="dan">Pro</b><b class="grey">Version</a> aktiv.</b><br>
        </div>
       <div class="col-md-3">
            <h4 class="prem">neues Template erstellen</h4><a data-gallery="details" href="'. $img_url.'/galerie_email3.jpg" title="Bilder Upload">
        <img src="'. $img_url.'/galerie_email3_small.jpg"  class="img-responsive img-thumbnail" alt="galerie erstellen"></a>
          <br><b class="grey"> Geben Sie einen Namen für die Emailvorlage ein. Erstellen Sie eine neue Vorlage und Speichern Sie anschließend.</b>
        </div> 

    </div> 
    <br>
     <hr class="hr-light"><br><div class="pull-right"><h4><a  class="prem" href="#top">Top</a></h4></div>
 
    </div>
    <!---Galerie-email-settings-->
     <!---Google-Maps-->        
      <div id="google_maps" class="panel-body">

       <h3 class="warn panel-titel">
       <span class="grey fa fa-arrow-right "></span> Google <small>Maps Api-KEY</small>
          </h3> 
        <div class="row">  
        <div class="col-md-3">    
       <h4 class="prem">Key Eingeben</h4> <a data-gallery="details" href="'. $img_url.'/galerie_googel_maps_api.jpg" title="Galerie erstellen">
        <img src="'. $img_url.'/galerie_googel_maps_api_small.jpg"  class="img-responsive img-thumbnail" alt="galerie erstellen"></a>
          <br>
         <b class="grey">Hier (</span><a href="https://developers.google.com/maps/documentation/javascript/get-api-key?hl=de#key" target="_blank"><b class="prem">Schlüssel für die Standard-API</a></b>) finden Sie eine Anleitung wie Sie einen Standard GoogleMaps apiKey anlegen.</b>    
          </div>

    </div> 
    <br>
    <hr class="hr-light"><br><div class="pull-right"><h4><a  class="prem" href="#top">Top</a></h4></div>
 

    </div> 
   <!---Google-Maps--> 
   <!---Sytem-settings-->       
          
      <!--    <div id="system_settings" class="panel-body">

               <h3 class="warn panel-titel">
       <span class="grey fa fa-arrow-right "></span> Image <small>& System Settings</small>
          </h3>       
        <div class="row">  
        <div class="col-md-3">    
       <h4 class="prem">Upload Settings</h4> <a data-gallery="details" href="'.$img_url.'/galerie_settings_image.jpg" title="Galerie erstellen">
        <img src="'. $img_url.'/galerie_settings_image_small.jpg"  class="img-responsive img-thumbnail" alt="galerie erstellen"></a>
          <br><b class="grey"> Hier können Sie die Abmessungen und Bildgröße ihrer Uploads einstellen.</b>
          </div>
      <div class="col-md-3">    
       <h4 class="prem">System Settings</h4> <a data-gallery="details" href="'. $img_url.'/galerie_settings_system.jpg" title="Galerie erstellen">
        <img src="'. $img_url.'/galerie_settings_system_small.jpg"  class="img-responsive img-thumbnail" alt="galerie erstellen"></a>
          <br><b class="grey"> Übersicht System-Settings.</b>
          </div>
          <div class="col-md-3">    
       <h4 class="prem">System Settings</h4>
          <b class="grey"> 
              <ul class="list-group">
              <li><h5>Image library:</h5></li>
             Supported Image Libraries sind GD-library und ImageMagick.
             Wenn Sie nicht sicher sind ob ImageMagick bei ihrem Provider installiert ist,
             wird Empfohlen diese Einstellung auf "Auto" zu stellen.
             Es wird automatisch zu ImageMagick gewechselt wenn die Library installiert ist.
             Beim Fehlen von ImageMagick wird die GD-Bibliothek verwendet.    
                    
                  
              </ul> 
              </b>      
      </div>
         <div class="col-md-3">    
       <h4 class="prem">System Settings</h4>
          <b class="grey"> 
              <ul class="list-group">
                  <li><h5><u>Pagination aktiv:</u></h5>
            Diese Einstellung bestimmt, ob die Pagination für ihre Galerie aktiv ist.
                 <br><br> <hr class="hr-light">
                      </li>
                  <li><h5><u>Pagination größe:</u></h5>
            Stellen Sie hier die größe der Pagination ein.       
            <br><br><hr class="hr-light">
             </li>  
          <li><h5><u>Anzahl:</u></h5>
            Die Anzahl der Bilder die beim Aufruf der Galerie auf einer Seite angezeigt werden.       
            <br><br><hr class="hr-light">
             </li>        
                  
          </ul> 
              </b>      
      </div>

    </div> 
    <br>
     <hr class="hr-light"><br><div class="pull-right"><h4><a  class="prem" href="#top">Top</a></h4></div>
  

    </div>      
    <!---Sytem-settings-->  
  
  -->
  
  <!---license_key-->       
          
          <div id="license_key" class="panel-body">

               <h3 class="warn panel-titel">
       <span class="grey fa fa-arrow-right "></span> Galerie <small> Pro License-Key</small>
          </h3>       
        <div class="row">  
        <div class="col-md-4">    
       <h4 class="prem">License Key</h4> <a data-gallery="details" href="'. $img_url.'/settings_license_key.jpg" title="Galerie erstellen">
        <img src="'. $img_url.'/settings_license_key_small.jpg"  class="img-responsive img-thumbnail" alt="galerie erstellen"></a>
          <br><b class="grey">Geben Sie hier bitte Ihre Bestell ID und Ihren License Key ein. Diese Daten haben Sie von Digistore24.com per E-Mail bekommen.</b>
          </div>

        <div class="col-md-4">    
       <h4 class="prem">License Key aktiv</h4> <a data-gallery="details" href="'. $img_url.'/settings_license_aktiv.jpg" title="Galerie erstellen">
        <img src="'. $img_url.'/settings_license_aktiv_small.jpg"  class="img-responsive img-thumbnail" alt="galerie erstellen"></a>
          <br><b class="grey"> Wenn ihre Eingaben korrekt sind, stehen Ihnen jetzt alle Optionen der Art-Picture Galerie Pro zur Verfügung.  </b>
          </div>
         <div class="col-md-4">    
       <h4 class="prem">License-Key</h4>
          <b class="grey"> 
              <ul class="list-group">
                  <li><h5><u>License Key abgelaufen:</u></h5>
            Falls Sie mehr als einen Benutzer haben und Ihr License Key abgelaufen ist, werden alle Benutzer bis auf den Ersten deaktiviert. Nach erneuter Eingabe eines gültigen License-Keys, können Sie diesen Benutzer wieder aktivieren und alle Freigaben stehen wieder zur Verfügung. 
                 <br><br> <hr class="hr-light">
                      </li>
          </ul> 
      </b>      
      </div>

    </div> 
    <br>
     <hr class="hr-light"><br><div class="pull-right"><h4><a  class="prem" href="#top">Top</a></h4></div>
  

    </div>      
     <!---license_key-->      
</div><!--container-->

<div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-filter="">
<div class="slides"></div>
<h3 class="title"></h3>
<a class="prev">‹</a>
<a class="next">›</a>
<a class="close">×</a>
<a class="play-pause"></a>
<ol class="indicator"></ol>
</div>
</div>';

$template = preg_replace(array('/<!--(.*)-->/Uis',"/[[:blank:]]+/"),array('',' '),str_replace(array("\n","\r","\t"),'',$template));
echo $template;
?>
