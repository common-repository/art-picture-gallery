=== Art-Picture-Gallery ===
Contributors: jwiecker
Tags: Wordpress Custom Gallery, Gallery user shares, Gallery User Response, 3 Gallery Layouts, Gallery User Checked, Gallery User Message, Gallery User Template, Image GPS, Image Exif, Gallery User Email 
Requires at least: 4.8
Tested up to: 4.9.4
Stable tag: trunk
License: GPL3
License URI: http://www.gnu.org/licenses/gpl-3.0.html
Erstellen Sie eine Galerie, wählen Sie verschiedene Layouts. 
== Description ==

**Art-Picture Gallery** plugin ist eine Custom Gallery für Wordpress mit verschiedenen Layouts und Benutzer Freigabe Funktion. Freigegebene Benutzer können einzelne Bilder auswählen oder ein Kommentar schreiben. Alle gewählten Bilder oder Kommentare sehen Sie in einer Übersicht. Art-Picture-Gallery besitzt ein Benutzer Template mit Login Funktion. 

Dieses Plugin ist einfach zu bedienen und besitzt eine ausführliche Hilfe Seite.
## Features
* Grundlegende Funktion von Art-Picture Gallery
  * Custom Galerie erstellen. 
  * Galerie Benutzer anlegen und eine oder mehrere Galerien für diesen Benutzer freigeben.
  * Verschiedene Einstellmöglichkeiten für jede einzelne Freigabe.
  * Extra Benutzer Template mit Login Funktion.
  * Benutzer Auswahl Funktion einzelner Bilder der Freigabe.
  * Benutzer Kommentar Funktion einzelner Bilder der Freigabe.
  * Übersicht der gewählten Bilder und Kommentare für jede Freigabe im Admin Front-End.
  * Bild GPS Funktion. GPS-Daten aus dem Bild werden mit Google-Maps angezeigt.
  * Bild Exif Funktion. Exif-Daten aus dem Bild werden übersichtlich angezeigt.
  * Benutzer Message Funktion.
  * Benutzer LOG Funktion.
  * Language `Is RTL`.
  * *Zusätzliche Funktionen werden bei jeden Update hinzugefügt.*

* 3rd Party
  * Es werden Informationen zur Registrierung der Art-Picture Gallery PRO an https://art-picturedesign.de übertragen. Es werden keine Persönlichen Daten gesendet oder gespeichert.     

Beispiele für Art-Picture Gallery werden im FAQ-Abschnitt beschrieben.
== Installation ==

Befolgen Sie die folgenden Schritte, um das Plugin zu installieren

1. Laden Sie `Art-Picture-Gallery` in das Verzeichnis `/wp-content/plugins/` hoch
2. Aktivieren Sie das Plugin über das Menü 'Plugins' in WordPress
== Frequently Asked Questions ==

= 1. neue Galerie erstellen =

Gehen Sie auf die Startseite von Art-Picture-Gallery und klicken Sie `Galerie erstellen`.
Geben Sie einen Galerienamen und optional eine Beschreibung ein.
Es wird die Seite zum Bildupload geöffnet und Sie können ihre erstellte Galerie auswählen oder eine neue Galerie erstellen.
Sie können nun ihre Bilder per `DRAG & DROP` in das Fenster ziehen, oder mit dem Button `Bilder auswählen` und hochladen.
Bei erfolgreichen Upload sehen Sie die Bilder in einer Übersicht. Ein fehlgeschlagener Upload wird mit einer Fehlermeldung angezeigt.

= 2. Galerie auswählen =

 * Auf der Startseite von Art-Picture-Gallery wählen Sie ihre Galerie über die Selectauswahl aus.
 *  Nachdem Sie ihre Galerie ausgewählt haben, werden die Bilder in einer Grid Ansicht geladen. Wenn Sie mit der Maus über die einzelnen Bilder fahren, sehen Sie einige Bildinformationen und     Optionen.
 * In der Ansicht Liste sehen Sie viele weitere Informationen. Die einzelnen Button und Funktionen werden unter "Symbole Galerie Liste" näher erklärt.

= 3. Galerie und Bilder löschen =

 * Wählen Sie die zu löschende Galerie aus und bestätigen Sie mit dem Button löschen. Bedenken Sie das alle Freigaben, Benachrichtigungen und ausgewählte Bilder gelöscht werden.
= einzelne Bilder löschen (list Ansicht) =
 * In der List-Ansicht können Sie einzelne Bilder über den Button löschen. Das Bild wird sofort ohne Bestätigung gelöscht.
= einzelne Bilder löschen (Grid Ansicht) =
 *Fahren Sie mit der Maus über das Bild. Drücken Sie den `Delete Button` um das Bild zu löschen.
= 3. Galerie bearbeiten =
 * Klicken Sie auf bearbeiten und vergeben Sie Schlagwörter und eine Beschreibung ihrer erstellten Galerie.
Auch hier können Sie die einzelnen Galerien löschen.
= 3. Button Farben =

 * Es gibt veschiedene Zustände einzelner Button.
  * GPS->rot : keine GPS-Daten im Bild vorhanden.
  * GPS->grün : GPS-Daten im Bild vorhanden.
  * Exif->grün : GPS-Daten im Bild vorhanden.
  * Exif->orange : wenige Exif-Daten im Bild vorhanden.
  * Exif->rot : keine Exif-Daten im Bild vorhanden.

= GPS details =

* Die Angabe der Höhe (Drohne) bezieht sich aus dem GPS-Daten einer DJI Phantom Drohne. Die Höhe ist aus dem Daten der Drohne und den Daten von Google-Maps berechnet und zeigt in einigen Fällen nicht die korrekte Höhe an.

= 4. neuen Benutzer anlegen =

  * In der Standart-Version ist das E-Mail senden deaktiviert.
  * Die Option `Benutzer aktiv` bedeutet das der Benutzer sofort nach dem Erstellen aktiv ist. Diese Einstellung können Sie später in den Benutzer-Settings wieder ändern.
  * Ist die Option `Benutzer aktiv` deaktiviert, ist der Benutzer gesperrt und alle `Freigaben` für diesen Benutzer sind deaktiviert.

= 5. Benutzer Settings =

  * Ist die Option `Message` aktiv,  kann der Benutzer Ihnen Nachrichten senden.
  * Mit dem Button `Benutzer Notiz` können Sie eine Notiz für diesen Benutzer erstellen.
  * Der Button `eMail senden` ist nur in der Pro Version aktiv.
  * Ändern Sie das Passwort des Users. Beachten Sie, dass das eingebene Passwort verschlüsselt gespeichert wird und nicht mehr als Klartext-Passwort angezeigt werden kann.

= 6. Galerie Freigabe erstellen =

   * Wählen Sie den Benutzer und die Galerie aus, die Sie freigeben wollen. Eine Galerie kann für verschiedene Benutzer freigegeben werden. In der Standard Version können Sie maximal 10 Bilder und eine Freigabe erstellen. Diese soll als Demo-Version dienen. In der ProVersion können Sie unbegrenzt viele Freigaben und Bilder erstellen.  

= 7. Galerie Settings =

  * Option Freigabe aktiv: Mit dieser Option können einzelne Freigaben für einen Benutzer ein- oder ausgeschalten werden. Diese Option ist wirkungslos, wenn der Benutzer in den Benutzer-Settings   deaktiviert ist.
  * Info Message: Hier sehen Sie eine Info, ob es Kommentare in dieser Freigabe gibt.
  * Info Check: Hier sehen Sie eine Info, ob Bilder in dieser Galerie ausgewählt sind.
  * Button freigabe löschen: Hier können Sie einzelne Freigaben löschen. Der Benutzer bleibt auch ohne Freigaben aktiv.
  * Check Gps: Diese Option steht nur in der Pro Version zur Verfügung.
  * Check Exif: Diese Option steht nur in der Pro Version zur Verfügung.
  * Check auswahl: Ist diese Option aktiv, kann der Galerie-Benutzer Bilder auswählen. Alle ausgew. Bilder und Kommentare können Sie unter "Galerie-Response" finden.
  * Check Kommentar: Ist diese Option aktiv, kann der Galerie-Benutzer Kommentare zu jedem freig. Bild schreiben. Alle ausgew. Bilder und Kommentare können Sie unter "Galerie-Response" finden.
  * Select Galerie Typ: Diese Option steht nur in der Pro Version zur Verfügung. In der Standard-Version ist Typ-2 ausgewählt und kann nicht geändert werden.

= 8. Galerie in Wordpress erstellen =

  * Drücken Sie auf Art-Picture Galerie Seiten und dann Erstellen.
  * Wählen Sie ihre Galerie aus und legen Sie den Galerie Typ fest. Die Option Bilder pro Reihe, hat nur Auswirkungen auf den Galerie Typ "Grid und Details". Wenn Sie die Option Bilder pro Reihe auf all gestellt haben, wird keine Pagination eingeblendet. Mit der Einstellung "Content Position" bestimmen Sie ob ihr Text über oder unter der Galerie erscheint. Sie haben die Möglichkeit Titel, Galeriebeschreibung und Tags ein- oder auszublenden.
  * Nach dem Bestätigen ihrer Eingaben finden Sie unter Design -> Menüs einen neuen Eintrag "Art-Picture Seiten". Fügen Sie ihre neue Galerie dem Menü hinzu. Ist der Eintrag nicht vorhanden, klicken Sie bitte auf Ansicht anpassen und aktivieren Sie die Box Art-Picture Seiten.
  * Nach dem Speichen rufen Sie ihre erstellte Seite auf. Ihre Galerie ist nun mit ihren Einstellungen zu bestaunen.

= 9. Art-Picture Gallery Widget = 

  * Sie können eine Überschrift und einen Titel eingeben. Wählen Sie die gewünschte Galerie und die Anzahl der anzuzeigenden Bilder. Ist die Option "Zufall" aktiv, verändert sich die Reihenfolge der Bilder bei jedem Neuladen der Seite.

= 10. Art-Picture Random Image =

  * Wählen Sie die gewünschte Galerie und die Größe des anzuzeigenden Bildes aus.

= 11. Art-Picture Gallery Login =  

* Generiert eine Eingabe von Benutzername und Passwort. Der Benutzer wird anschließend zum Benutzer-Template weiter geleitet.

= 12. Galerie Resposne =

  * Hier können Sie alle Bilder sehen, die der Benutzer ausgewählt hat oder ein Kommentar zu einem Bild geschrieben hat.

= 13. Galerie Settings =

  = SMTP Settings = 
   * Tragen Sie hier die Benutzerdaten von ihrem Email-Provider ein. Als Vorlage ist ein Beispiel von Google Mail eingetragen. Drücken Sie anschließend Einstellungen Testen oder Test-Email senden.

  = Email Settings =
   * Sie können verschiedene Email-Vorlagen erstellen. Es stehen verschiedene Platzhalter zur Verfügung. Ausnahmen sind die Platzhalter [passwort], ###ABSEMAIL### und ###ABSURL### diese stehen nur in den "Zugangsdaten eMail" Template zur Verfügung. Bei den Platzhaltern ###ABSEMAIL### und ###ABSURL### werden die Email-Adresse und die URL von ihrer Wordpress Registrierung eingetragen. 
   * Diese Funktion ist nur in der ProVersion aktiv.

  = neues Template erstellen =
   * Geben Sie einen Namen für die Email-Vorlage ein. Erstellen Sie eine neue Vorlage und speichern Sie anschließend.
   * Diese Funktion ist nur in der ProVersion aktiv.

= 14. Galerie Settings Google Maps Api-KEY =

   * Geben Sie ihren Google-Maps Api-KEY ein.
   * Unter `https://developers.google.com/maps/documentation/javascript/get-api-key?hl=de#key` finden Sie eine Anleitung wie Sie einen Standard Google-Maps Api-KEY anlegen.

= 15. Upload Settings =

   * Hier können Sie die Abmessungen und Bildgröße ihrer Uploads einstellen.

= 16. System Settings = 

   * Supported Image Libraries sind GD-library und ImageMagick. Wenn Sie nicht sicher sind ob ImageMagick bei ihrem Provider installiert ist, wird empfohlen diese Einstellung auf "Auto" zu stellen. Es wird automatisch zu ImageMagick gewechselt wenn die Library installiert ist. Beim Fehlen von ImageMagick wird die GD-Bibliothek verwendet.

= 17. Pagination aktiv: =  

   * Diese Einstellung bestimmt, ob die Pagination für ihre Galerie aktiv ist. 

= 18. Pagination größe: =

   * Stellen Sie hier die Größe der Pagination ein. 

= 19. Anzahl: = 

  * Die Anzahl der Bilder die beim Aufruf der Galerie auf einer Seite angezeigt werden. 

= 20. Galerie Pro License-Key: = 

  * Geben Sie hier bitte Ihre Bestell ID und Ihren License Key ein. Diese Daten haben Sie von Digistore24.com per E-Mail bekommen.
  * Wenn ihre Eingaben korrekt sind, stehen Ihnen jetzt alle Optionen der Art-Picture Galerie Pro zur Verfügung.

  = License Key abgelaufen: =

    * Falls Sie mehr als einen Benutzer haben und Ihr License Key abgelaufen ist, werden alle Benutzer bis auf den Ersten deaktiviert. Nach erneuter Eingabe eines gültigen License-Keys, können Sie diesen Benutzer wieder aktivieren und alle Freigaben stehen wieder zur Verfügung. 

== Screenshots ==

1. Gallery Grid
2. Gallery List
3. User Settings
4. Share Settings
5. User Template

== Changelog ==

= 1.2.9 =
* fixed Galerie-Settings

= 1.2.8 =
* fixed Galerie-Settings

== Changelog ==
= 1.2.7 =
* fixed upload

= 1.2.6 =
* fixed upload

= 1.2.5 =
* fixed Installations Fehler (1und1)

= 1.2.4 =
* neue Settings zum Deaktivieren von Bootstrap-CSS und Bootstrap-JS hinzugefügt.
* die JQUERY Galerie kann in den Settings deaktiviert werden.

= 1.2.3 =
* Settings für Bild-Details hinzugefügt

= 1.2.2 =
* fixed PHP 7 Upload Fehler
* Change Upload Dir

= 1.2.1 =
* fixed GPS und Exif Anzeige
* fixed Image Details

= 1.2 =
* fixed anzeige Freigaben löschen
* Change Upload Dir (Wordpress Upload Ordner)
* fixed Fehler User-Intefaces
* fixed Art-Picture Gallery Startseite
* fixed Bilderanzahl Galerie löschen

= 1.1 = 
* fixed bootstrap load js
* CSS Thumbnail anzeige (User Details-Template)
* URL für User Template eingefügt
* fixed Image Beschreibung (Umlaute)

= 1.0 =
* Plugin release. Included basic plugin features.

