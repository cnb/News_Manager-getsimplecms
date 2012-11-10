<?php

/**
 * News Manager Dutch language file by Rogier Koppejan
 */


$i18n = array(

# general
"PLUGIN_NAME"         =>  "News Manager",

# error messages
"ERROR_ENV"           =>  "Er zijn fouten opgetreden bij de toegang tot de data mappen. <em>CHMOD 777</em> de mappen /data, /backups en de onderliggende bestanden en probeer opnieuw.",
"ERROR_SAVE"          =>  "<b>Fout:</b> Kan de wijzigingen niet opslaan. <em>CHMOD 777</em> de mappen /data, /backups en de onderliggende bestanden en probeer opnieuw.",
"ERROR_DELETE"        =>  "<b>Fout:</b> Kan het bericht niet verwijderen. <em>CHMOD 777</em> de mappen /data, /backups en de onderliggende bestanden en probeer opnieuw.",
"ERROR_RESTORE"       =>  "<b>Fout:</b> Kan het bericht niet herstellen. <em>CHMOD 777</em> de mappen /data, /backups en de onderliggende bestanden en probeer opnieuw.",

# success messages
"SUCCESS_SAVE"        =>  "De wijzigingen zijn opgeslagen.",
"SUCCESS_DELETE_POST" =>  "Het bericht is verwijderd.",
"SUCCESS_RESTORE"     =>  "Het bericht is hersteld.",

# other messages
"UPDATE_HTACCESS"     =>  "<b>Let op:</b> Waarschijnlijk moet het <a href=\"load.php?id=news_manager&htaccess\">.htaccess</a> bestand aangepast worden!",

# admin button (top-right)
"SETTINGS"            =>  "Instellingen",
"NEW_POST"            =>  "Nieuw Bericht",

# admin panel
"POST_TITLE"          =>  "Titel",
"DATE"                =>  "Datum",
"EDIT_POST"           =>  "Bewerk Bericht",
"VIEW_POST"           =>  "Bekijk Bericht",
"DELETE_POST"         =>  "Verwijder Bericht",
"POSTS"               =>  "bericht(en)",

# edit settings
"NM_SETTINGS"         =>  "News Manager Instellingen",
"DOCUMENTATION"       =>  "Voor meer informatie over deze instellingen, bezoek de <a href=\"http://rxgr.nl/newsmanager/\" target=\"_blank\">documentatie pagina</a>.",
"PAGE_URL"            =>  "Berichtenpagina",
"LANGUAGE"            =>  "Taal die gebruikt wordt op de Nieuwspagina",
"SHOW_POSTS_AS"       =>  "Berichten Weergeven Als",
"FULL_TEXT"           =>  "Volledige Tekst",
"EXCERPT"             =>  "Samenvatting",
"PRETTY_URLS"         =>  "Activeer Fancy URLs voor berichten, archieven, etc.",
"PRETTY_URLS_NOTE"    =>  "Wanneer Fancy URLs geactiveerd zijn, zal je mogelijk het .htaccess bestand moeten bijwerken na het opslaan van deze instellingen.",
"EXCERPT_LENGTH"      =>  "Lengte Van Een Samenvatting (Karakters)",
"POSTS_PER_PAGE"      =>  "Aantal Berichten Op De Nieuwspagina",
"RECENT_POSTS"        =>  "Aantal Recente Berichten (Sidebar)",

# edit post
"POST_OPTIONS"        =>  "Bericht Opties",
"POST_SLUG"           =>  "Slug/URL",
"POST_TAGS"           =>  "Tags (meerdere tags scheiden met komma's)",
"POST_DATE"           =>  "Publicatiedatum (<i>mm/dd/yyyy</i>)",
"POST_TIME"           =>  "Publicatietijd (<i>hh:mm</i>)",
"POST_PRIVATE"        =>  "Bericht Is Priv&#233;",
"LAST_SAVED"          =>  "Laatst Bijgewerkt",

# htaccess
"HTACCESS_HELP"       =>  "Vervang voor het gebruik van Fancy URLs voor berichten, archieven, etc. de inhoud van het <code>.htaccess</code> bestand met onderstaande regels.",
"GO_BACK_WHEN_DONE"   =>  "Klik op onderstaande knop om terug te gaan naar het berichten paneel.",

# save/cancel/delete
"SAVE_SETTINGS"       =>  "Instellingen Opslaan",
"SAVE_POST"           =>  "Wijzigingen Opslaan",
"FINISHED"            =>  "Gereed",
"CANCEL"              =>  "Annuleren",
"DELETE"              =>  "Verwijderen",
"OR"                  =>  "of",

# front-end/site
"FOUND"               =>  "De volgende berichten zijn gevonden:",
"NOT_FOUND"           =>  "Helaas, er zijn geen berichten gevonden.",
"NOT_EXIST"           =>  "Het opgevraagde bericht bestaat niet.",
"NO_POSTS"            =>  "Er zijn geen berichten gevonden.",
"PUBLISHED"           =>  "Gepubliceerd op",
"TAGS"                =>  "Tags",
"OLDER_POSTS"         =>  "Oudere Berichten",
"NEWER_POSTS"         =>  "Nieuwere Berichten",
"SEARCH"              =>  "Zoek",
"GO_BACK"             =>  "Ga terug naar de vorige pagina",

# date settings
"DATE_FORMAT"         =>  "%e %b %Y"

);

?>
