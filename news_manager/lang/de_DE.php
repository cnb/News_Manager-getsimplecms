<?php

/**
 * News Manager German language file by Connie Müller-Gödecke
 */


$i18n = array(

# general
"PLUGIN_NAME"         =>  "News Manager",

# Fehler messages
"ERROR_ENV"           =>  "Der Ordner mit den Beiträgen und/oder die Konfigurationsdatei konnte nicht aufgerufen werden. Passen Sie bitte die Dateirechte an: <em>CHMOD 777</em> für den Order /data, /backups sowie die Unterordner und versuchen Sie es noch einmal.",
"ERROR_SAVE"          =>  "<b>Fehler:</b> Die Änderungen konnten nicht geschrieben werden. <em>CHMOD 777</em> Sie bitte die Rechte für den Ordner /data, /backups und seine Unterordner und versuchen Sie es noch einmal.",
"ERROR_DELETE"        =>  "<b>Fehler:</b> Der Beitrag kann nicht gelöscht werden. <em>CHMOD 777</em> Sie bitte die Rechte für den Ordner /data, /backups und seine Unterordner und versuchen Sie es noch einmal.",
"ERROR_RESTORE"       =>  "<b>Error:</b> Unable to restore the post. <em>CHMOD 777</em> the folders /data, /backups and their sub-folders and retry.",

# success messages
"SUCCESS_SAVE"        =>  "Die Änderungen wurden gespeichert.",
"SUCCESS_DELETE"      =>  "Der Beitrag wurde gelöscht.",
"SUCCESS_RESTORE"     =>  "The post has been restored.",

# other messages
"UPDATE_HTACCESS"     =>  "<b>Achtung:</b> Sie sollten die Datei <a href=\"load.php?id=news_manager&htaccess\">.htaccess</a> aktualisieren!",

# admin button (top-right)
"SETTINGS"            =>  "Einstellung",
"NEW_POST"            =>  "Neuen Beitrag erstellen",

# admin panel
"POST_TITLE"          =>  "Titel",
"DATE"                =>  "Datum",
"EDIT_POST"           =>  "Beitrag bearbeiten",
"VIEW_POST"           =>  "Beitrag ansehen",
"DELETE_POST"         =>  "Beitrag löschen",
"POSTS"               =>  "Beiträge",

# edit settings
"NM_SETTINGS"         =>  "News Manager Einstellungen",
"DOCUMENTATION"       =>  "Mehr Informationen zu den Einstellungen finden Sie in der <a href=\"http://rxgr.nl/newsmanager/\" target=\"_blank\">Dokumentation</a>.",
"PAGE_URL"            =>  "Seite, auf der die Beiträge angezeigt werden sollen",
"LANGUAGE"            =>  "Sprache auf der News-Seite",
"SHOW_POSTS_AS"       =>  "Beiträge in NEWS-Übersichten anzeigen als ",
"FULL_TEXT"           =>  "Voll-Text",
"EXCERPT"             =>  "Auszug",
"PRETTY_URLS"         =>  "Nutzen Sie Fancy URLs für Beiträge, Archive etc.",
"PRETTY_URLS_NOTE"    =>  "Wenn Fancy URLs aktiviert sind, sollten Sie die .htaccess - Datei nach dem Speichern dieser Einstellungen aktualisieren.",
"EXCERPT_LENGTH"      =>  "Länge des Auszuges (in Buchstaben)",
"POSTS_PER_PAGE"      =>  "Anzahl der Beiträge auf der News-Seite",
"RECENT_POSTS"        =>  "Anzahl der aktuellsten Beiträge (in der Sidebar)",

# edit post
"POST_OPTIONS"        =>  "Beitrags-Optionen",
"POST_SLUG"           =>  "Slug/URL",
"POST_TAGS"           =>  "Tags (kommagetrennt eingeben)",
"POST_DATE"           =>  "Datum der Veröffentlichung: (<i>mm/dd/yyyy</i>)",
"POST_TIME"           =>  "Zeit der Veröffentlichung: (<i>hh:mm</i>)",
"POST_PRIVATE"        =>  "Beitrag ist privat",
"LAST_SAVED"          =>  "Zuletzt gesichert",

# htaccess
"HTACCESS_HELP"       =>  "Um Fancy URLs für Beiträge, Archive etc. zu aktivieren, ersetzen Sie den Inhalt der aktiven <code>.htaccess</code> -Datei mit dem unten angezeigten Inhalt.",
"GO_BACK_WHEN_DONE"   =>  "Klicken Sie dann auf den untenstehenden Button um zur vorigen Seite zurückzukehren.",

# save/cancel/delete
"SAVE_SETTINGS"       =>  "Einstellungen speichern",
"SAVE_POST"           =>  "Beitrag speichern",
"FINISHED"            =>  "Fertig",
"CANCEL"              =>  "Abbrechen",
"DELETE"              =>  "Löschen",
"OR"                  =>  "oder",

# front-end/site
"FOUND"               =>  "Diese Beiträge wurden gefunden:",
"NOT_FOUND"           =>  "Sorry, zu Ihrer Suche wurde nichts gefunden.",
"NOT_EXIST"           =>  "Es gibt den gewünschten Beitrag nicht.",
"NO_POSTS"            =>  "Es wurden noch keine Beiträge veröffentlicht.",
"PUBLISHED"           =>  "Veröffentlicht am",
"TAGS"                =>  "Tags",
"OLDER_POSTS"         =>  "Ältere Beiträge",
"NEWER_POSTS"         =>  "Neuere Beiträge",
"SEARCH"              =>  "Suche",
"GO_BACK"             =>  "Zurück zur vorherigen Seite",

# date settings
"DATE_FORMAT"         =>  "%e.%b %Y"

);

?>
