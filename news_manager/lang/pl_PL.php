<?php

/**
 * News Manager Polish language file by Blazej Strazak
 */


$i18n = array(

# general
"PLUGIN_NAME"         =>  "News Manager",

# error messages
"ERROR_ENV"           =>  "Wystąpił błąd z dostępem do posta i/lub pliku konfiguracyjnego. <em>CHMOD 777</em> katalog /data, /backups oraz jego podkatalogi i spróbuj ponownie.",
"ERROR_SAVE"          =>  "<b>Error:</b> Nie można zapisać zmiany. <em>CHMOD 777</em> katalog /data, /backups oraz jego podkatalogi i spróbuj ponownie.",
"ERROR_DELETE"        =>  "<b>Error:</b> Nie można skasować posta. <em>CHMOD 777</em> katalog /data, /backups oraz jego podkatalogi i spróbuj ponownie.",
"ERROR_RESTORE"       =>  "<b>Error:</b> Unable to restore the post. <em>CHMOD 777</em> the folders /data, /backups and their sub-folders and retry.",

# success messages
"SUCCESS_SAVE"        =>  "Twoje zmiany zostały zapisane.",
"SUCCESS_DELETE"      =>  "Post został skasowany.",
"SUCCESS_RESTORE"     =>  "The post has been restored.",

# other messages
"UPDATE_HTACCESS"     =>  "<b>Uwaga:</b> Prawdopodobnie musisz zaktualizować plik <a href=\"load.php?id=news_manager&htaccess\">.htaccess</a>!",

# admin button (top-right)
"SETTINGS"            =>  "Ustawienia",
"NEW_POST"            =>  "Utwórz nowego posta",

# admin panel
"POST_TITLE"          =>  "Tytuł posta",
"DATE"                =>  "Data",
"EDIT_POST"           =>  "Edytuj posta",
"VIEW_POST"           =>  "Zobacz posta",
"DELETE_POST"         =>  "Skasuj posta",
"POSTS"               =>  "post(y)",

# edit settings
"NM_SETTINGS"         =>  "Ustawienia News Manager'a",
"DOCUMENTATION"       =>  "Więcej informacji na temat ustawień znajdziesz na stronie z <a href=\"http://rxgr.nl/newsmanager/\" target=\"_blank\">dokumentacją</a>.",
"PAGE_URL"            =>  "Strona do wyświetlania postów",
"LANGUAGE"            =>  "Language used on News Page",
"SHOW_POSTS_AS"       =>  "Posty na stronie z aktualnościami są wyświetlane jako",
"FULL_TEXT"           =>  "Pełna treść",
"EXCERPT"             =>  "Zajawka",
"PRETTY_URLS"         =>  "Używaj przyjaznych zdresów do postów, archiwów, itp.",
"PRETTY_URLS_NOTE"    =>  "Jeśli używanie przyjaznych adresów jest aktywne, konieczne może być zaktualizowanie pliku .htaccess po zapisaniu tych ustawień.",
"EXCERPT_LENGTH"      =>  "Długość zajawki (w znakach)",
"POSTS_PER_PAGE"      =>  "Ilość postów na stronie z aktualnościami",
"RECENT_POSTS"        =>  "Ilość ostatnich postów (w sidebarze)",

# edit post
"POST_OPTIONS"        =>  "Opcje posta",
"POST_SLUG"           =>  "Slug/URL",
"POST_TAGS"           =>  "Tagi (oddzielone przecinkami)",
"POST_DATE"           =>  "Publish date (<i>mm/dd/yyyy</i>)",
"POST_TIME"           =>  "Publish time (<i>hh:mm</i>)",
"POST_PRIVATE"        =>  "Post zaznaczony jako prywatny",
"LAST_SAVED"          =>  "Ostatnio zapisane",

# htaccess
"HTACCESS_HELP"       =>  "Aby włączyć używanie przyjaznych adresów dla postów, archiwum itp. zmień zawartość pliku <code>.htaccess</code> zna poniższe linie.",
"GO_BACK_WHEN_DONE"   =>  "Gdy skończysz kliknij przycisk poniżej aby wrócić do głównego panelu.",

# save/cancel/delete
"SAVE_SETTINGS"       =>  "Zapisz ustawienia",
"SAVE_POST"           =>  "Zapisz posta",
"FINISHED"            =>  "Gotowe",
"CANCEL"              =>  "Anuluj",
"DELETE"              =>  "Skasuj",
"OR"                  =>  "lub",

# front-end/site
"FOUND"               =>  "Następujące posty zostały odnalezione:",
"NOT_FOUND"           =>  "Niestety, wyszukiwanie nie zwróciło wyników.",
"NOT_EXIST"           =>  "Szukany post nie istnieje.",
"NO_POSTS"            =>  "Nie opublikowano jeszcze żadnych postów.",
"PUBLISHED"           =>  "Opublikowano",
"TAGS"                =>  "Tagi",
"OLDER_POSTS"         =>  "Starsze posty",
"NEWER_POSTS"         =>  "Nowsze posty",
"SEARCH"              =>  "Szukaj",
"GO_BACK"             =>  "Wróć do poprzedniej strony",

# date settings
"DATE_FORMAT"         =>  "%e %b %Y"

);

?>
