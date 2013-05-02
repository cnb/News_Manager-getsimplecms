<?php

/**
 * News Manager Czech language file by Tomáš Janeček / TeeJay 
 */


$i18n = array(

# general
"PLUGIN_NAME"         =>  "News Manager",

# error messages
"ERROR_ENV"           =>  "Chyba v přístupu do adresářů dat. Nastavte <em>CHMOD 777</em> na složky /data, /backups a jejich podsložky a akci opakujte.",
"ERROR_SAVE"          =>  "<b>Error:</b> Nelze uložit vaše změny. Nastavte <em>CHMOD 777</em> na složky /data, /backups a jejich podsložky a akci opakujte.",
"ERROR_DELETE"        =>  "<b>Error:</b> Nelze smazat příspěvek. Nastavte <em>CHMOD 777</em> na složky /data, /backups a jejich podsložky a akci opakujte.",
"ERROR_RESTORE"       =>  "<b>Error:</b> Nelze obnovit příspěvek. Nastavte <em>CHMOD 777</em> na složky /data, /backups a jejich podsložky a akci opakujte.",

# success messages
"SUCCESS_SAVE"        =>  "Vaše změny byly uloženy.",
"SUCCESS_DELETE"      =>  "Příspěvek byl smazán.",
"SUCCESS_RESTORE"     =>  "Příspěvek byl obnoven.",

# other messages
"UPDATE_HTACCESS"     =>  "<b>Poznámka:</b> Pravděpodobně musíte zaktualizovat soubor <a href=\"load.php?id=news_manager&amp;htaccess\">.htaccess</a>!",

# admin button (top-right)
"SETTINGS"            =>  "Nastavení",
"NEW_POST"            =>  "Vytvořit nový příspěvek",

# admin panel
"POST_TITLE"          =>  "Titulek příspěvku",
"DATE"                =>  "Datum",
"EDIT_POST"           =>  "Upravit příspěvek",
"VIEW_POST"           =>  "Podívat se na příspěvek",
"DELETE_POST"         =>  "Smazat příspěvek",
"POSTS"               =>  "příspěvek/ky",

# edit settings
"NM_SETTINGS"         =>  "Nastavení News Manageru",
"DOCUMENTATION"       =>  "Pro více informaci o těchto nastaveních navštivte <a href=\"http://www.cyberiada.org/cnb/news-manager/\" target=\"_blank\">documentation page</a>.",
"PAGE_URL"            =>  "Webová stránka k zobrazování příspěvků/novinek",
"LANGUAGE"            =>  "Jazyk použitý na stránkách příspěvků/novinek",
"SHOW_POSTS_AS"       =>  "Příspěvky na stránce s novinkami jsou zobrazeny jako",
"FULL_TEXT"           =>  "Celý text",
"EXCERPT"             =>  "Výňatek",
"PRETTY_URLS"         =>  "Použít Fancy URLs na příspěvky, archivy, atd.",
"PRETTY_URLS_NOTE"    =>  "Máte-li Fancy URLs povolené, možna budete muset zaktualizovat váš .htaccess soubor po uložení těchto nastavení.",
"EXCERPT_LENGTH"      =>  "Délka výňatku (počet znaků)",
"POSTS_PER_PAGE"      =>  "Počet novinek/příspěvků na stránce s novinkami/příspěvky",
"RECENT_POSTS"        =>  "Počet nedávných příspěvků (v postranní liště)",

# edit post
"POST_OPTIONS"        =>  "Nastavení příspěvku",
"POST_SLUG"           =>  "Slug/URL",
"POST_TAGS"           =>  "Tagy (jednotlivé tagy oddělujte čárkou)",
"POST_DATE"           =>  "Datum publikování (<i>yyyy-mm-dd</i>)",
"POST_TIME"           =>  "Čas publikování (<i>hh:mm</i>)",
"POST_PRIVATE"        =>  "Příspěvek je soukromý",
"LAST_SAVED"          =>  "Naposledy uloženo",

# validation
"FIELD_IS_REQUIRED"   => "Toto pole je nutné vyplnit",
"ENTER_VALID_DATE"    => "Prosím zadejte správné datum / Nechte prázdné pro dnešní datum",
"ENTER_VALID_TIME"    => "Prosím zadejte správný čas / Nechte prázdné pro aktuální čas",

# htaccess
"HTACCESS_HELP"       =>  "Abyste povolili Fancy URLs pro příspěvky, archivy, atd., nahraďte obsah vašeho <code>.htaccess</code> souboru řádky níže.",
"GO_BACK_WHEN_DONE"   =>  "Až budete s touto stránkou hotovi, klikněte na tlačítko níže, abyste se vrátili na hlavní panel.",

# save/cancel/delete
"SAVE_SETTINGS"       =>  "Uložit nastavení",
"SAVE_POST"           =>  "Uložit příspěvek",
"FINISHED"            =>  "Hotovo",
"CANCEL"              =>  "Zrušit",
"DELETE"              =>  "Smazat",
"OR"                  =>  "nebo",

# front-end/site
"FOUND"               =>  "Byly nalezeny následující příspěvky:",
"NOT_FOUND"           =>  "Omlouváme se, ale vaše vyhledávání nevede k žádným výsledkům.",
"NOT_EXIST"           =>  "Požadovaný příspěvek neexistuje.",
"NO_POSTS"            =>  "Nenalezeny žádné příspěvky.",
"PUBLISHED"           =>  "Publikováno",
"TAGS"                =>  "Tagy",
"OLDER_POSTS"         =>  "Starší příspěvky",
"NEWER_POSTS"         =>  "Novější příspěvky",
"SEARCH"              =>  "Hledat",
"GO_BACK"             =>  "Zpět na předchozí stránku",

# language localization
"LOCALE"              =>  "cs_CZ.utf8,cs.utf8,cs_CZ.UTF-8,cs.UTF-8,cs_CZ,cs",

# date settings
"DATE_FORMAT"         =>  "%d.%m.%Y - %H:%M"

);

?>