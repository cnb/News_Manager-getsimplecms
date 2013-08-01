<?php

/**
 * News Manager Slovak language file by Pavol Bokor (www.4enzo.sk)
 */


$i18n = array(

# general
"PLUGIN_NAME"         =>  "News Manager",

# error messages
"ERROR_ENV"           =>  "Chyba prístupu do priečinka DATA. Nastavte <em>CHMOD 777</em> pre priečinky /data, /backups a ich podpriečinky a ackiu zopakujte.",
"ERROR_SAVE"          =>  "<b>Error:</b> Nie je možné uložiť zmeny. Nastavte <em>CHMOD 777</em> pre priečinky /data, /backups a ich podpriečinky a ackiu zopakujte.",
"ERROR_DELETE"        =>  "<b>Error:</b> Nie je možné zmazať príspevok. Nastavte <em>CHMOD 777</em> the folders /data, /backups a ich podpriečinky a ackiu zopakujte.",
"ERROR_RESTORE"       =>  "<b>Error:</b> Nie je možné obnoviť príspevok. Nastavte <em>CHMOD 777</em> the folders /data, /backups a ich podpriečinky a ackiu zopakujte.",

# success messages
"SUCCESS_SAVE"        =>  "Vaše zmeny boli uložené.",
"SUCCESS_DELETE"      =>  "Príspevok bol zmazaný.",
"SUCCESS_RESTORE"     =>  "Príspevok bol obnovený.",

# other messages
"UPDATE_HTACCESS"     =>  "<b>Upozornenie:</b> Pravdepodobne budete musieť aktualizovať svoj <a href=\"load.php?id=news_manager&amp;htaccess\">.htaccess</a> súbor!",

# admin button (top-right)
"SETTINGS"            =>  "Nastavenia",
"NEW_POST"            =>  "Vytvoriť príspevok",

# admin panel
"POST_TITLE"          =>  "Názov príspevku",
"DATE"                =>  "Dátum",
"EDIT_POST"           =>  "Upraviť príspevok",
"VIEW_POST"           =>  "Zobraziť príspevok",
"DELETE_POST"         =>  "Zmazať príspevok",
"POSTS"               =>  "príspevky / príspevkov",

# edit settings
"NM_SETTINGS"         =>  "News Manager - Nastavenia",
"DOCUMENTATION"       =>  "Viac informácií o nastavení nájdete (v angličtine) na <a href=\"http://www.cyberiada.org/cnb/news-manager/\" target=\"_blank\">stránkach s dokumentáciou</a>.",
"PAGE_URL"            =>  "Stránka na ktorej sa zobrazia príspevky",
"LANGUAGE"            =>  "Jazyk použitý na stránke Novinky",
"SHOW_POSTS_AS"       =>  "Príspevky sú zobrazené ako",
"FULL_TEXT"           =>  "Celý text",
"EXCERPT"             =>  "Výňatok",
"PRETTY_URLS"         =>  "Použiť Fancy URLs pre príspevky, archívy, a pod.",
"PRETTY_URLS_NOTE"    =>  "Ak máte povolené Fancy URLs, budete musieť aktualizovať svoj .htaccess súbor po uložení týchto nastavení.",
"EXCERPT_LENGTH"      =>  "Dĺžka výňatku (počet znakov)",
"POSTS_PER_PAGE"      =>  "Počet príspevkov na stránke Novinky",
"RECENT_POSTS"        =>  "Počet nedávnych príspevkov(na postrannej lište)",

# edit post
"POST_OPTIONS"        =>  "Nastavenie príspevku ",
"POST_SLUG"           =>  "Slug/URL",
"POST_TAGS"           =>  "Menovky (jednotlivé menovky oddeľte čiarkami)",
"POST_DATE"           =>  "Dátum uverejnenia (<i>rrrr-mm-dd</i>)",
"POST_TIME"           =>  "Čas uverejnenia (<i>hh:mm</i>)",
"POST_PRIVATE"        =>  "Príspevok je súkromný",
"POST_IMAGE"          =>  "Obrázok",
"LAST_SAVED"          =>  "Posledné zmeny uložené",

# validation
"FIELD_IS_REQUIRED"   => "Toto pole je potrebné vyplniť",
"ENTER_VALID_DATE"    => "Vložte požadovaný dátum / Ponechajte prázdne pre aktuálny dátum",
"ENTER_VALID_TIME"    => "Vložte požadovaný čas / Ponechajte prázdne pre aktuálny čas",

# htaccess
"HTACCESS_HELP"       =>  "Ak chcete povoliť Fancy URL adresy príspevkov, archívov, atď., nahraďte obsah vášho <code>.htaccess</code> súboru riadkami uvedenými nižšie.",
"GO_BACK_WHEN_DONE"   =>  "Ak budete s touto stránkou hotový, kliknite na tlačítko nižšie a vrátite sa do hlavného panelu.",

# save/cancel/delete
"SAVE_SETTINGS"       =>  "Uložiť nastavenia",
"SAVE_POST"           =>  "Uložiť príspevok",
"FINISHED"            =>  "Hotovo",
"CANCEL"              =>  "Zrušiť",
"DELETE"              =>  "Zmazať",
"OR"                  =>  "alebo",

# front-end/site
"FOUND"               =>  "Našli sa tieto príspevky:",
"NOT_FOUND"           =>  "Prepáčte, vaše hľadanie neprinieslo žiadne výsledky.",
"NOT_EXIST"           =>  "Požadovaný príspevok neexistuje.",
"NO_POSTS"            =>  "Žiadne príspevky neboli nájdené.",
"PUBLISHED"           =>  "Publikované",
"TAGS"                =>  "Menovky",
"OLDER_POSTS"         =>  "&larr; Staršie príspevky",
"NEWER_POSTS"         =>  "Novšie príspevky &rarr;",
"SEARCH"              =>  "Hľadať",
"GO_BACK"             =>  "&lt;&lt; Späť na predošlú stránku",
"ELLIPSIS"            =>  " [...]",
"READ_MORE"           =>  "Prečítať si viac",

# language localization
"LOCALE"              =>  "sk_SK.utf8,sk.utf8,sk_SK.UTF-8,sk.UTF-8,sk_SK,sk",

# date settings
"DATE_FORMAT"         =>  "%d.%m.%Y - %H:%M"

);

?>