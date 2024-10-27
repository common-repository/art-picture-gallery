<?php
namespace APG\ArtPictureGallery;
if ( ! defined( 'ABSPATH' ) ) exit; 
class Exif
{
private static function read_exif ($file_name) {
      $GpsRef=0;
      $unbekannt='unbekannt';
      $freigabe ='true';
      $a  = 0;
      $ver = $file_name;

       $exif_ifd0 = @read_exif_data($ver, 'IFD0', 0);

       $exif_exif = @read_exif_data($ver, 'EXIF', 0);
      
       if (isset($exif_exif['COMPUTED']['Copyright']))
        {
            $newExif['Copyright'] = $exif_exif['COMPUTED']['Copyright']; 
            $a ++;
        }else{$newExif['Copyright'] = $unbekannt;}
      
       if (isset($exif_exif['COMPUTED']['Width'])){
        $newExif['Width'] = $exif_exif['COMPUTED']['Width'];
        $a ++;
        }else{$newExif['Width'] = $unbekannt;}
        
       if (isset($exif_exif['COMPUTED']['Height'])){
        $newExif['Height'] = $exif_exif['COMPUTED']['Height'];
        $a ++;
        }else{$newExif['Height'] = $unbekannt;} 
       
       if (isset($exif_exif['Make']))
        {$newExif['Make'] = $exif_exif['Make'];
        $a ++;
        }else{$newExif['Make'] = $unbekannt;}
        
        if (isset($exif_exif['Model']))
        {$newExif['Model'] = $exif_exif['Model'];
        $a ++;
        }else{$newExif['Model'] = $unbekannt;}
        
        if (isset($exif_exif['UndefinedTag:0xA434']))
         {$newExif['Objektiv'] = $exif_exif['UndefinedTag:0xA434'];
         $a ++;
         }else{$newExif['Objektiv'] = $unbekannt;}
         
        if (isset($exif_exif['ISOSpeedRatings']))
         {$newExif['ISOSpeedRatings'] = $exif_exif['ISOSpeedRatings'];
         $a ++;
         }else{$newExif['ISOSpeedRatings']=0;}
         //Blende F/Number
        if (isset($exif_exif['COMPUTED']['ApertureFNumber']))
         {$newExif['ApertureFNumber'] = $exif_exif['COMPUTED']['ApertureFNumber'];
         $a ++;
         }else{$newExif['ApertureFNumber'] = $unbekannt;}
       //Verschlusszeit
        if (isset($exif_exif['ExposureTime']))
        {$newExif['ExposureTime'] = $exif_exif['ExposureTime'];
        $a ++;
        }else{$newExif['ExposureTime'] = $unbekannt;}
        //Brennweite
        if (isset($exif_exif['FocalLength']))
         {list($num, $den) = explode("/", $exif_exif["FocalLength"]);
         $newExif['FocalLength'] = ($num / $den);
         $a ++;
         }else{$newExif['FocalLength'] = $unbekannt;}
        //in 35MM crop faktor
        if (isset($exif_exif['FocalLengthIn35mmFilm']))
         {$newExif['FocalLengthIn35mmFilm'] = $exif_exif['FocalLengthIn35mmFilm'];
         $a ++;
         }else{$newExif['FocalLengthIn35mmFilm'] = $unbekannt;}
         //Aufnahme MODUS
        if (isset($exif_exif["ExposureMode"]))
        {
            switch ($exif_exif["ExposureMode"])
            {
                case 0:
                    $exif_ExposureMode = "unbekannt";
                    break;
                case 1:
                    $exif_ExposureMode = "M (Manual)";
                    break;
                case 2:
                    $exif_ExposureMode = "	P, Program";
                    break;
                case 3:
                    $exif_ExposureMode = "Aperture Priority";
                    break;
                case 4:
                    $exif_ExposureMode = "Shutter Priority";
                    break;
                case 5:
                    $$exif_ExposureMode = "unbekannt";
                    break;
                case 6:
                    $exif_ExposureMode = "Sports";
                    break;
                case 7:
                    $exif_ExposureMode = "Portrait";
                    break;
                case 8:
                    $$exif_ExposureMode = "Landscape";
                    break;
                default:
                    $exif_ExposureMode = '';
                    break;
            }
      $newExif['ExposureMode'] = $exif_ExposureMode;
      $a ++;
      }else{$newExif['ExposureMode'] = $unbekannt;}
      //Messung
      if (!empty($exif_exif["MeteringMode"]))
        {
          switch ($exif_exif["MeteringMode"])
          {

                case 0:
                    
                    $exif_MeteringMode = "Breit";
                    break;
                case 1:
                    $exif_MeteringMode = "Breit";
                    break;
                case 2:
                    $exif_MeteringMode = "Feld";
                    break;
                case 3:
                    $exif_EMeteringMode = "mitte";
                    break;
                case 4:
                    $exif_MeteringMode = "Flexible Spot";
                    break;
                case 5:
                    $exif_MeteringMode = "Erweit. Flexible Spot";
                    break;
                case 6:
                    $exif_MeteringMode = "AF-Verriegel.:Erw. Flexible Spot";
                    break;

                case 255:
                    $exif_MeteringMode = "other";
                    break;

                default:
                    $exif_MeteringMode = 'unbekannt';
                    break;
          }
        $newExif['MeteringMode'] = $exif_MeteringMode;
        $a ++;
        }else{$newExif['MeteringMode'] = $unbekannt;}
        //WEIßABGLEICH
        if (isset($exif_exif["WhiteBalance"]))
        {
            switch ($exif_exif["WhiteBalance"])
            {
                case 0:
                    $exif_WhiteBalance = "Auto";
                    break;
                case 1:
                    $exif_WhiteBalance = "Tageslicht";
                    break;
                case 2:
                    $exif_WhiteBalance = "Schatten";
                    break;
                case 3:
                    $exif_WhiteBalance = "Bewölkt";
                    break;
                case 4:
                    $$exif_WhiteBalance = "Glühlampe";
                    break;
                case 5:
                    $exif_WhiteBalance = "Leuchtst.:warmweiß";
                    break;
                case 6:
                    $exif_WhiteBalance = "Leuchtst.:kaltweiß";
                    break;
                case 7:
                    $exif_WhiteBalance = "Leuchtst.:Tag-weiß";
                    break;
                case 8:
                    $exif_WhiteBalance = "Leuchtst.:Tageslicht";
                    break;
                case 9:
                    $exif_WhiteBalance = "Blitz";
                    break;
                case 10:
                    $exif_WhiteBalance = "Farbtmp./Filter";
                    break;
                default:
                    $exif_WhiteBalance = 'unbekannt';
                    break;
            }
         $newExif['WhiteBalance'] = $exif_WhiteBalance;
         $a ++;
        }else{$newExif['WhiteBalance'] = $unbekannt;}
        if (isset($exif_exif["DateTimeOriginal"]))
        {$exif_DateOrginal = str_replace(":", "-", substr($exif_exif["DateTimeOriginal"],0, 10));
         $exif_TimeOrginal = substr($exif_exif["DateTimeOriginal"], 10);
         $newExif['DateOrginal'] = $exif_DateOrginal."".$exif_TimeOrginal;
         $a ++;
        }else{$newExif['DateOrginal'] ='0000-00-00 00:00:00';}
        //Digitalisiert DATUM
        if (isset($exif_exif["DateTimeDigitized"]))
        {$exif_DateDigitized = str_replace(":", "-", substr($exif_exif["DateTimeDigitized"],0, 10));
         $exif_TimeDigitized = substr($exif_exif["DateTimeDigitized"], 10);
         $newExif['DateDigitized'] = $exif_DateDigitized."".$exif_TimeDigitized;
         $a ++;
        }else{$newExif['DateDigitized'] ='0000-00-00 00:00:00';}
        //SOFTWARE
        if (isset($exif_exif['Software']))
        {$newExif['Software'] = $exif_exif['Software'];
         $a ++;
        }else{$newExif['Software'] = $unbekannt;}
        //Letzte Bearbeitung
        if (isset($exif_exif["DateTime"]))
        {$exif_DateSoftware = str_replace(":", "-", substr($exif_exif["DateTime"], 0, 10));
         $exif_TimeSoftware = substr($exif_exif["DateTime"], 10);
         $newExif['DateSoftware'] = $exif_DateSoftware."".$exif_TimeSoftware;
         $a ++;
        }else{$newExif['DateSoftware'] ='0000-00-00 00:00:00';}
        
        $size = getimagesize($ver, $info);
         if(isset($info['APP13']))
         {
          $iptc = iptcparse($info['APP13']);
         }else{$newExif['Tags']=$unbekannt;}
         if(isset($iptc['2#025']))
         {
        $str_app13 = implode(",",$iptc['2#025']);
        $newExif['Tags'] =$str_app13; 
        $a ++;
         }else{$newExif['Tags']=$unbekannt;}
    
         //GPSLatitudeRef
        if (isset($exif_exif['GPSLatitudeRef']))
        {$newExif['GPSLatitudeRef'] = $exif_exif['GPSLatitudeRef'];
        }else{$newExif['GPSLatitudeRef'] = $GpsRef;}
        //GPSLatitude@0
        if (isset($exif_exif['GPSLatitude'][0]))
        {list($num, $den) = explode("/", $exif_exif['GPSLatitude'][0]);
         $newExif['GPSLatitude1'] = ($num / $den);
        }else{$newExif['GPSLatitude1'] = $GpsRef;}
        //GPSLatitude@1
        if (isset($exif_exif['GPSLatitude'][1]))
        {list($num, $den) = explode("/", $exif_exif['GPSLatitude'][1]);
         $newExif['GPSLatitude2'] = ($num / $den);
        }else{$newExif['GPSLatitude2'] = $GpsRef;}
        //GPSLatitude@2
        if (isset($exif_exif['GPSLatitude'][2]))
        {list($num, $den) = explode("/", $exif_exif['GPSLatitude'][2]);
         $newExif['GPSLatitude3'] = ($num / $den);
        }else{$newExif['GPSLatitude3'] = $GpsRef;}
        //GPSLongitudeRef
         if (isset($exif_exif['GPSLongitudeRef']))
        {$newExif['GPSLongitudeRef'] = $exif_exif['GPSLongitudeRef'];
        }else{$newExif['GPSLongitudeRef'] = $GpsRef;}
        //GPSLongitude@0
         if (isset($exif_exif['GPSLongitude'][0]))
        {list($num, $den) = explode("/", $exif_exif['GPSLongitude'][0]);
         $newExif['GPSLongitude1'] = ($num / $den);
        }else{$newExif['GPSLongitude1'] = $GpsRef;}
        //GPSLongitude@1
        if (isset($exif_exif['GPSLongitude'][1]))
        {list($num, $den) = explode("/", $exif_exif['GPSLongitude'][1]);
         $newExif['GPSLongitude2'] = ($num / $den);
        }else{$newExif['GPSLongitude2'] = $GpsRef;}
        //GPSLongitude@2
        if (isset($exif_exif['GPSLongitude'][2]))
        {list($num, $den) = explode("/", $exif_exif['GPSLongitude'][2]);
         $newExif['GPSLongitude3'] = ($num / $den);
        }else{$newExif['GPSLongitude3'] = $GpsRef;}
        //GPSAltitude
        if (isset($exif_exif['GPSAltitude']))
        {list($num, $den) = explode("/", $exif_exif['GPSAltitude']);
         $newExif['GPSAltitude'] = ($num / $den);
        }else{$newExif['GPSAltitude'] = $GpsRef;}
         $newExif['type']='image/jpeg';
         $newExif['count'] = $a;
 return $newExif;   
}
   public static function exif_files($file){
           // $path = dirname(__DIR__).'/file-upload/files/img/';
           $path = ABSPATH.'APG-FILES/img/';
           $image = $path . $file;
           $res = self::read_exif($image);
           $ser = serialize($res);
           return $ser;
  }
}

?>