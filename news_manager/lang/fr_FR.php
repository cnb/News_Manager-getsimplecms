<?php

/**
 * News Manager French language file by Sebastien Colmant
 */


$i18n = array(

# general
"PLUGIN_NAME"         =>  "News Manager",

# error messages
"ERROR_ENV"           =>  "Il y a eu une erreur en acc&eacute;dant au dossier des billets et/ou au fichier de configuration. <em>CHMOD 777</em> le dossiers /data, /backups et ses sous-dossiers et r&eacute;essayez.",
"ERROR_SAVE"          =>  "<b>Erreur:</b> Impossible d'enregistrer vos modifications. <em>CHMOD 777</em> le dossiers /data, /backups et ses sous-dossiers et r&eacute;essayez.",
"ERROR_DELETE"        =>  "<b>Erreur:</b> Impossible d'effacer le billet. <em>CHMOD 777</em> le dossiers /data, /backups et ses sous-dossiers et r&eacute;essayez.",
"ERROR_RESTORE"       =>  "<b>Error:</b> Unable to restore the post. <em>CHMOD 777</em> the folders /data, /backups and their sub-folders and retry.",

# success messages
"SUCCESS_SAVE"        =>  "Vos modifications ont été enregistrées.",
"SUCCESS_DELETE"      =>  "Le billet a été supprimé.",
"SUCCESS_RESTORE"     =>  "The post has been restored.",

# other messages
"UPDATE_HTACCESS"     =>  "<b>Note:</b> Vous devez probablement mettre à jour votre fichier <a href=\"load.php?id=news_manager&amp;htaccess\">.htaccess</a>!",

# admin button (top-right)
"SETTINGS"            =>  "Param&egrave;tres",
"NEW_POST"            =>  "Cr&eacute;er un Nouveau Billet",

# admin panel
"POST_TITLE"          =>  "Titre du Billet",
"DATE"                =>  "Date",
"EDIT_POST"           =>  "Modifier le Billet",
"VIEW_POST"           =>  "Voir le Billet",
"DELETE_POST"         =>  "Supprimer le Billet",
"POSTS"               =>  "Billets",

# edit settings
"NM_SETTINGS"         =>  "Param&eacute;tres de News Manager",
"DOCUMENTATION"       =>  "Pour plus d'informations sur ces param&egrave;tres, visitez la <a href=\"http://www.cyberiada.org/cnb/news-manager/\" target=\"_blank\">page de documentation</a>.",
"PAGE_URL"            =>  "Page o&ugrave; afficher les Billets",
"LANGUAGE"            =>  "Language used on News Page",
"SHOW_POSTS_AS"       =>  "Les billets sur la page News sont pr&eacute;sent&eacute;s comme",
"FULL_TEXT"           =>  "Texte Complet",
"EXCERPT"             =>  "Extrait",
"PRETTY_URLS"         =>  "Use Fancy URLs for posts, archives, etc.",
"PRETTY_URLS_NOTE"    =>  "If you have Fancy URLs enabled, you might have to update your .htaccess file after saving these settings.",
"EXCERPT_LENGTH"      =>  "Longueur de l'Extrait (caract&egrave;res)",
"POSTS_PER_PAGE"      =>  "Nombre de Billets sur la page News",
"RECENT_POSTS"        =>  "Nombre de Billets r&eacute;cents (dans la barre lat&eacute;rale)",
"ENABLE_ARCHIVES"     =>  "Enable archives",
"BY_MONTH"            =>  "By month",
"BY_YEAR"             =>  "By year",
"READ_MORE_LINK"      =>  "Add \"read more\" link to excerpts",
"ALWAYS"              =>  "Always",
"NOT_SINGLE"          =>  "Except in single post view",
"GO_BACK_LINK"        =>  "\"Go back\" link in single post view",
"TITLE_LINK"          =>  "Link to post in title",
"BROWSER_BACK"        =>  "Previously visited page",
"MAIN_NEWS_PAGE"      =>  "Main News Page",
"ENABLE_IMAGES"       =>  "Enable post images",
"IMAGE_LINKS"         =>  "Link images to posts",
"IMAGE_WIDTH"         =>  "Post image width (pixels)",
"IMAGE_HEIGHT"        =>  "Post image height (pixels)",
"FULL"                =>  "full",
"IMAGE_CROP"          =>  "Crop post images to fit width/height ratio",
"IMAGE_ALT"           =>  "Insert post title in post image <em>alt</em> attribute",
"CUSTOM_SETTINGS"     =>  "Custom settings",

# edit post
"POST_OPTIONS"        =>  "Options du Billet",
"POST_SLUG"           =>  "Slug/URL",
"POST_TAGS"           =>  "Tags (S&eacute;parez les tags avec des virgules)",
"POST_DATE"           =>  "Publish date (<i>yyyy-mm-dd</i>)",
"POST_TIME"           =>  "Publish time (<i>hh:mm</i>)",
"POST_PRIVATE"        =>  "Billet Priv&eacute;",
"POST_IMAGE"          =>  "Image",
"LAST_SAVED"          =>  "Derni&egrave;re sauvegarde",

# validation
"FIELD_IS_REQUIRED"   => "This field is required",
"ENTER_VALID_DATE"    => "Please enter a valid date / Leave blank for current date",
"ENTER_VALID_TIME"    => "Please enter a valid time / Leave blank for current time",

# htaccess
"HTACCESS_HELP"       =>  "Pour activer la redirection d'URLs pour les billets, archives, etc, remplacez le contenu de votre fichier <code>.htaccess</code> avec les lignes ci-dessous.",
"GO_BACK_WHEN_DONE"   =>  "Lorsque vous avez termin&eacute; avec cette page, cliquez sur le bouton ci-dessous pour retourner au panneau principal.",

# save/cancel/delete
"SAVE_SETTINGS"       =>  "Enregistrer les param&egrave;tres",
"SAVE_POST"           =>  "Enregistrer le Billet",
"FINISHED"            =>  "Fini",
"CANCEL"              =>  "Annuler",
"DELETE"              =>  "Supprimer",
"OR"                  =>  "ou",

# front-end/site
"FOUND"               =>  "Les billets suivants ont &eacute;t&eacute; trouv&eacute;s:",
"NOT_FOUND"           =>  "D&eacute;sol&eacute;, votre recherche n'a retourn&eacute; aucun r&eacute;sultat.",
"NOT_EXIST"           =>  "Le billet demand&eacute; n'existe pas.",
"NO_POSTS"            =>  "Aucun billet n'a encore &eacute;t&eacute; publi&eacute;.",
"PUBLISHED"           =>  "Publi&eacute; le",
"TAGS"                =>  "Tags",
"OLDER_POSTS"         =>  "&larr; Billets moins r&eacute;cents",
"NEWER_POSTS"         =>  "Billets plus r&eacute;cents &rarr;",
"SEARCH"              =>  "Recherche",
"GO_BACK"             =>  "&lt;&lt; Retourner &agrave; la page pr&eacute;c&eacute;dente",
"ELLIPSIS"            =>  " [...] ",
"READ_MORE"           =>  "Read more",
"AUTHOR"              =>  "Author:",

# language localization
"LOCALE"              =>  "fr_FR.utf8,fr.utf8,fr_FR.UTF-8,fr.UTF-8,fr_FR,fr",

# date settings
"DATE_FORMAT"         =>  "%e %b %Y"

);

?>
