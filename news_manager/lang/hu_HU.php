<?php

/**
 * News Manager Hungarian language file by Rudi Szabó
 */


$i18n = array(

# general
"PLUGIN_NAME"         =>  "News Manager",

# error messages
"ERROR_ENV"           =>  "Hiba történt a data mappa elérésekor. <em>CHMOD 777</em> a /data, /backups könyvtárakat &amp; alkönyvtárakat és próbáld újra.",
"ERROR_SAVE"          =>  "<b>Hiba:</b> Nem sikerült menteni a módosításokat. <em>CHMOD 777</em> a /data, /backups könyvtárakat &amp; alkönyvtárakat és próbáld újra.",
"ERROR_DELETE"        =>  "<b>Hiba:</b> Nem sikerült törölni a bejegyzést.  <em>CHMOD 777</em> a /data, /backups könyvtárakat &amp; alkönyvtárakat és próbáld újra.",
"ERROR_RESTORE"       =>  "<b>Hiba:</b> Nem sikerült visszaállítani a bejegyzést.  <em>CHMOD 777</em> a /data, /backups könyvtárakat &amp; alkönyvtárakat és próbáld újra.",

# success messages
"SUCCESS_SAVE"        =>  "A módosítások sikeresen elmentve.",
"SUCCESS_DELETE"      =>  "A bejegyzés sikeresen törölve.",
"SUCCESS_RESTORE"     =>  "A bejegyzés sikeresen visszaállítva.",

# other messages
"UPDATE_HTACCESS"     =>  "<b>Megjegyzés:</b> Valószínűleg módosítanod kell a <a href=\"load.php?id=news_manager&amp;htaccess\">.htaccess</a> fájlt!",

# admin button (top-right)
"SETTINGS"            =>  "Beállítások",
"NEW_POST"            =>  "Új bejegyzés",

# admin panel
"POST_TITLE"          =>  "Bejegyzés címe",
"DATE"                =>  "Dátum",
"EDIT_POST"           =>  "Bejegyzés szerkesztés",
"VIEW_POST"           =>  "Bejegyzés megtekintése",
"DELETE_POST"         =>  "Bejegyzés törlése",
"POSTS"               =>  "bejegzés",

# edit settings
"NM_SETTINGS"         =>  "News Manager Beállítások",
"DOCUMENTATION"       =>  "További beállításokkal kapcsolatos információkért látogasd meg a <a href=\"http://get-simple.info/forums/showthread.php?tid=1056\" target=\"_blank\">dokumentációs oldalt</a>.",
"PAGE_URL"            =>  "Hír oldal helye",
"LANGUAGE"            =>  "Hír oldalon használt nyelv",
"SHOW_POSTS_AS"       =>  "Bejegyzések megjelenítési módja a Hír oldalon",
"FULL_TEXT"           =>  "Teljse szöveg",
"EXCERPT"             =>  "Kivonat",
"PRETTY_URLS"         =>  "Keresőbarát URLek használata a bejegyzésekhez, archívumhoz, stb.",
"PRETTY_URLS_NOTE"    =>  "Ha aktiválod a Kersőbarát URLeket, lehet hogy módosítanod kell a .htaccess fájlt a beállítások mentése után.",
"EXCERPT_LENGTH"      =>  "Kivonat hossza (karakter)",
"POSTS_PER_PAGE"      =>  "Bejegyzések száma a Hír oldalon",
"RECENT_POSTS"        =>  "Legutóbbi bejegyzések száma (az oldalsávban)",

# edit post
"POST_OPTIONS"        =>  "Bejegyzés beállítások",
"POST_SLUG"           =>  "Optimalizált URL (Slug)",
"POST_TAGS"           =>  "Cimkék (vesszővel elválasztva)",
"POST_DATE"           =>  "Bejegyzés dátuma (<i>mm/dd/yyyy</i>)",
"POST_TIME"           =>  "Bejegyzés időpontja (<i>hh:mm</i>)",
"POST_PRIVATE"        =>  "Privát bejegyzés",
"LAST_SAVED"          =>  "Utoljára elmentve",

# htaccess
"HTACCESS_HELP"       =>  "To enable Fancy URLs for posts, archives, etc., replace the contents of your <code>.htaccess</code> file with the lines below.",
"GO_BACK_WHEN_DONE"   =>  "When you are done with this page, click the button below to go back to the main panel.",

# save/cancel/delete
"SAVE_SETTINGS"       =>  "Beállítások mentése",
"SAVE_POST"           =>  "Bejegyzés mentése",
"FINISHED"            =>  "Befejezve",
"CANCEL"              =>  "Mégsem",
"DELETE"              =>  "Törlés",
"OR"                  =>  "vagy",

# front-end/site
"FOUND"               =>  "A következő bejegyzéseket találtam:",
"NOT_FOUND"           =>  "Nincs a keresésnek megfelelő találat.",
"NOT_EXIST"           =>  "A kért bejegyzés nem létezik.",
"NO_POSTS"            =>  "Nincsenek bejegyzések.",
"PUBLISHED"           =>  "Közzétéve ekkor",
"TAGS"                =>  "Cimkék",
"OLDER_POSTS"         =>  "Régebbi bejegyzések",
"NEWER_POSTS"         =>  "Újabb bejegyzések",
"SEARCH"              =>  "Keresés",
"GO_BACK"             =>  "Vissza az előző oldalra",

# date settings
"DATE_FORMAT"         =>  "%Y %b %e"

);

?>
