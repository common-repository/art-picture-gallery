<?php
/**
 * ArtPicture Plugin PHP Class
 * http://art-pictureDesign.de/WP-ArtTheme-Galerie
 * Copyright 2017, Jens Wiecker
 * https://art-picturedesign.de
 *
 */
require_once('db/class_db_handle.php');
use  APG\ArtPictureGallery\DbHandle as DbHandle;
add_action('add_meta_boxes','galerie_addmetaboxes');
add_Action('save_post','galerie_savedata');

function galerie_addmetaboxes(){
	add_meta_box(
		'galerie_metabox',
		'Art Picture Galerie',
		'galerie_picturebox',
		'gallery',
		'side',
		'high'
	);

}
function galerie_picturebox(){

	wp_nonce_field('galerie_action','galerie_name');
    $a1 = array("method"   =>"read_wp_db",
                "table"    =>"art_galerie",
                "select"   =>" *" );
                             
            $dat1 = new DbHandle($a1);
            $gal=$dat1->return;
    
  $wert_select=get_post_meta(get_the_ID(), '_select',true);      
         foreach($gal['data'] as $tmp){
          if($wert_select == $tmp->galerie_name){
            $sel =  " selected='selected' ";
          }else{
            $sel = "";
          }
           $select .='<option  value="'.$tmp->galerie_name.'" '.$sel.'> '.$tmp->galerie_name.'</option>';
         }
  echo '<div class="bootstrap-wrapper"><h4 class="warn"><span class="warn fa fa-camera"></span>&nbsp;Create a gallery:</h4><hr class="hr-light"></div><label for="galerie_select"><b>Select Gallery:</b><br />
         <select  class="widefat" id="galerie_select"  name="galerie_select"style="width:12em" >';
  echo $select.'</select>'; 
  $selTyp=get_post_meta(get_the_ID(), '_typ',true);
  if($selTyp == '1' ? $typSelect1 =" selected='selected' " : $typSelect1 =''); 
  if($selTyp == '2' ? $typSelect2 =" selected='selected' " : $typSelect2 ='');
  if($selTyp == '3' ? $typSelect3 =" selected='selected' " : $typSelect3 ='');
  echo '<br><label for="galerie_typ"><b>Gallery Typ:</b><br />
         <select  class="widefat" id="galerie_typ"  name="galerie_typ"style="width:12em" >';
  echo   '<option  value="1" '.$typSelect1.'> Grid</option>
          <option  value="2" '.$typSelect2.'> Details</option>
          <option  value="3" '.$typSelect3.'> List</option>
         </select>
         <div class="bootstrap-wrapper"><h4 class="warn"><span class="warn fa fa-picture-o "></span>&nbsp;Gallery select:</h4><hr class="hr-light"></div>'; 
         

  $selRow = get_post_meta(get_the_ID(), '_row',true);
  if($selRow == '2' ? $selectRow2 =" selected='selected' " : $selectRow2 ='');
  if($selRow == '3' ? $selectRow3 =" selected='selected' " : $selectRow3 ='');
  if($selRow == '4' ? $selectRow4 =" selected='selected' " : $selectRow4 ='');
 
  echo '<label for="galerie_row"><b>Pictures per row(Grid):</b><br />
         <select  class="widefat" id="galerie_row"  name="galerie_row"style="width:4em" >';
  echo   '<option  value="2" '.$selectRow2.'> 4</option>
          <option  value="3" '.$selectRow3.'> 5</option>
          <option  value="4" '.$selectRow4.'> 6</option>
 
         </select>'; 
       
   $selPage = get_post_meta(get_the_ID(), '_page',true);
  if($selPage == '1' ? $selectPage1 =" selected='selected' " : $selectPage1 =''); 
  if($selPage == '2' ? $selectPage2 =" selected='selected' " : $selectPage2 ='');
  if($selPage == '3' ? $selectPage3 =" selected='selected' " : $selectPage3 ='');
  if($selPage == '4' ? $selectPage4 =" selected='selected' " : $selectPage4 ='');
  if($selPage == '5' ? $selectPage5 =" selected='selected' " : $selectPage5 ='');
  
   $selContent = get_post_meta(get_the_ID(), '_content',true);
   $selContent1 = 'checked'; 
   if($selContent == '1' ? $selContent1 =" checked" : $selContent1 =''); 
   if($selContent == '2' ? $selContent2 =" checked" : $selContent2 ='');
   
  echo '<br><label for="galerie_page"><b>Images per page:</b><br />
         <select  class="widefat" id="galerie_page"  name="galerie_page"style="width:4em" >';
  echo   '<option  value="2" '.$selectPage2.'> 25</option>
          <option  value="1" '.$selectPage1.'> 10</option>
          <option  value="3" '.$selectPage3.'> 35</option>
          <option  value="4" '.$selectPage4.'> 50</option>
          <option  value="5" '.$selectPage5.'> all</option>
         </select>
         <div class="bootstrap-wrapper">
         
         <br><label for="galerie_page"><span class="grey">Content position:</span><br />
         <label class="radio-inline">
         <input type="radio" name="galerie_content" id="galerie_content1" value="1" '.$selContent1.'> over gallery
         </label>
         <label class="radio-inline">
         <input type="radio" name="galerie_content" id="galerie_content2" value="2" '.$selContent2.'> under gallery
        </label><br><br>
         <h4 class="warn"><span class="warn fa fa-gears"></span>&nbsp;Gallery details:</h4><hr class="hr-light"></div>';  
 $selDescription = get_post_meta(get_the_ID(), '_description',true);
 $selHead        = get_post_meta(get_the_ID(), '_header',true);
 $selTags        = get_post_meta(get_the_ID(), '_tags',true);
        if( $selHead == '1' ?  $checked1 = "checked" :  $checked1 ='' || $selHead = 0);
        if( $selTags == '1' ?  $checked2 = "checked" :  $checked2 ='' || $selTags = 0);
        if( $selDescription == '1' ?  $checked3 = "checked" :  $checked3 ='' || $selDescription = 0);
 echo ' <div class="bootstrap-wrapper">
        <h5 class="grey">Show details:</h5>
        <label class="checkbox-inline">
        <input type="checkbox" id="galerie_header"name="galerie_header"  value="1" '.$checked1.'> Header
        </label>
        <label class="checkbox-inline">
        <input type="checkbox" id="galerie_tags"name="galerie_tags"  value="1" '.$checked2.'> Tags
        </label>
        <label class="checkbox-inline">
        <input type="checkbox" id="galerie_description"name="galerie_description" value="1" '.$checked3.'> Description
        </label>
        </div>';   
  
  $selFormat = get_post_meta(get_the_ID(), '_format',true);
  if($selFormat == '1' ? $selFormat1 =" selected='selected' " : $selFormat1 =''); 
  if($selFormat == '2' ? $selFormat2 =" selected='selected' " : $selFormat2 ='');
  if($selFormat == '3' ? $selFormat3 =" selected='selected' " : $selFormat3 ='');
 
  if( $selMapsAktiv == '1' ?  $checkedMaps = "checked" :  $checkedMaps ='' || $selMapsAktiv = 0);
   

  echo '<label for="galerie_page"><b>Pagination Format:</b><br />
         <select  class="widefat" id="galerie_format"  name="galerie_format"style="width:12em" >';
  echo   '<option  value="1" '.$selFormat1.'> Small</option>
          <option  value="2" '.$selFormat2.'> Normal</option>
          <option  value="3" '.$selFormat3.'> Big</option>
         </select> ';
  $gm='  <div class="bootstrap-wrapper"> <h4 class="warn"><span class="warn fa fa-map-marker "></span>&nbsp;Google-Maps:</h4><hr class="hr-light"></div>
  
         <label for="galerie_maps"><b>Address for Google-Maps:</b></label>
         <input class="widefat" type="text" class="form-control"name="galerie_maps" id="galerie_maps" placeholder="Address for Google-Maps"value='.$selMaps.'>
         <label for="galerie_adresse"><b>Displayed address:</b></label>
         <input class="widefat" type="text" class="form-control"name="galerie_adresse" id="galerie_adresse" placeholder="Displayed address"value="'.$selAdresse.'">
         <label class="widefat" for="galerie_maps_aktiv"><b>Google Maps active:</b><br />
        <input type="checkbox" id="galerie_maps_aktiv"name="galerie_maps_aktiv"  value="1" '.$checkedMaps.'> Maps-active <br>';                                
}

function galerie_savedata($post_id){
	
	if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return false;
	if( !current_user_can('edit_post',(int)$post_id)) return false;
	if ( !wp_verify_nonce($_POST['galerie_name'],'galerie_action')) return false;
    update_post_meta($_POST['post_ID'], '_select',(string) sanitize_text_field($_POST['galerie_select']), false); 
    update_post_meta($_POST['post_ID'], '_typ', (int)sanitize_text_field($_POST['galerie_typ']), false); 
    update_post_meta($_POST['post_ID'], '_row', (int)sanitize_text_field($_POST['galerie_row']), false); 
    update_post_meta($_POST['post_ID'], '_page', (int)sanitize_text_field($_POST['galerie_page']), false);
    update_post_meta($_POST['post_ID'], '_description',(int) sanitize_text_field($_POST['galerie_description']), false);
    update_post_meta($_POST['post_ID'], '_tags',(int) sanitize_text_field($_POST['galerie_tags']), false);
    update_post_meta($_POST['post_ID'], '_header',(int) sanitize_text_field($_POST['galerie_header']), false);
    update_post_meta($_POST['post_ID'], '_format',(int) sanitize_text_field($_POST['galerie_format']), false);
    update_post_meta($_POST['post_ID'], '_content',(int) sanitize_text_field($_POST['galerie_content']), false);
}
?>