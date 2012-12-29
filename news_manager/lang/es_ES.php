<?php

/**
 * News Manager Spanish-Spain language file by Carlos Navarro
 */


$i18n = array(

# general
"PLUGIN_NAME"         =>  "News Manager",

# error messages
"ERROR_ENV"           =>  "Se ha producido un error al acceder a las carpetas de datos. Aplicar permisos <em>CHMOD 777</em> a las carpetas /data, /backups y sus subcarpetas, y reintentar.",
"ERROR_SAVE"          =>  "<b>Error:</b> No se ha podido guardar los cambios. Aplicar permisos <em>CHMOD 777</em> a las carpetas /data, /backups y sus subcarpetas, y reintentar.",
"ERROR_DELETE"        =>  "<b>Error:</b> No se ha podido eliminar la entrada. Aplicar permisos <em>CHMOD 777</em> a las carpetas /data, /backups y sus subcarpetas, y reintentar.",
"ERROR_RESTORE"       =>  "<b>Error:</b> No se ha podido restablecer la entrada. Aplicar permisos <em>CHMOD 777</em> a las carpetas /data, /backups y sus subcarpetas, y reintentar.",

# success messages
"SUCCESS_SAVE"        =>  "Se han guardado los cambios.",
"SUCCESS_DELETE"      =>  "La entrada ha sido eliminada.",
"SUCCESS_RESTORE"     =>  "La entrada ha sido restablecida.",

# other messages
"UPDATE_HTACCESS"     =>  "<b>Nota:</b> Probablemente se ha de modificar el archivo <a href=\"load.php?id=news_manager&amp;htaccess\">.htaccess</a> del sitio.",

# admin button (top-right)
"SETTINGS"            =>  "Configuración",
"NEW_POST"            =>  "Entrada nueva",

# admin panel
"POST_TITLE"          =>  "Título de la entrada",
"DATE"                =>  "Fecha",
"EDIT_POST"           =>  "Editar entrada",
"VIEW_POST"           =>  "Ver entrada",
"DELETE_POST"         =>  "Eliminar entrada",
"POSTS"               =>  "entrada(s)",

# edit settings
"NM_SETTINGS"         =>  "Configuración de News Manager",
"DOCUMENTATION"       =>  "Para mayor información sobre la configuración, visitar la <a href=\"http://get-simple.info/forums/showthread.php?tid=1056\" target=\"_blank\">página de documentación</a>.",
"PAGE_URL"            =>  "Página para mostrar entradas",
"LANGUAGE"            =>  "Idioma utilizado en la página de noticias",
"SHOW_POSTS_AS"       =>  "Mostrar las entradas como",
"FULL_TEXT"           =>  "Entrada completa",
"EXCERPT"             =>  "Extracto",
"PRETTY_URLS"         =>  "Usar URLs amigables para entradas, archivos, etc.",
"PRETTY_URLS_NOTE"    =>  "Si se activan las URLs amigables, además será necesario actualizar el archivo .htaccess ...",
"EXCERPT_LENGTH"      =>  "Longitud del extracto (en caracteres)",
"POSTS_PER_PAGE"      =>  "Número de entradas en la página de noticias",
"RECENT_POSTS"        =>  "Número de entradas recientes (en barra lateral)",

# edit post
"POST_OPTIONS"        =>  "Opciones de la entrada",
"POST_SLUG"           =>  "Identificador/slug/URL",
"POST_TAGS"           =>  "Etiquetas (separadas por comas)",
"POST_DATE"           =>  "Fecha de publicación (<i>mm/dd/yyyy</i>)",
"POST_TIME"           =>  "Hora de publicación (<i>hh:mm</i>)",
"POST_PRIVATE"        =>  "Entrada privada",
"LAST_SAVED"          =>  "Guardada por última vez",

# htaccess
"HTACCESS_HELP"       =>  "Para activar las URLs amigables para entradas, archivos, etc., reemplazar el contenido del archivo <code>.htaccess</code> por las líneas siguientes:",
"GO_BACK_WHEN_DONE"   =>  "Hacer clic en el botón de abajo para volver al panel principal.",

# save/cancel/delete
"SAVE_SETTINGS"       =>  "Guardar cambios",
"SAVE_POST"           =>  "Guardar entrada",
"FINISHED"            =>  "Finalizado",
"CANCEL"              =>  "Cancelar",
"DELETE"              =>  "Eliminar",
"OR"                  =>  "ó",

# front-end/site
"FOUND"               =>  "Se han encontrado las siguientes entradas:",
"NOT_FOUND"           =>  "La búsqueda no ha devuelto resultados.",
"NOT_EXIST"           =>  "La entrada solicitada no existe.",
"NO_POSTS"            =>  "No se han encontrado entradas.",
"PUBLISHED"           =>  "Publicada el",
"TAGS"                =>  "Etiquetas",
"OLDER_POSTS"         =>  "Entradas más antiguas",
"NEWER_POSTS"         =>  "Entradas más recientes",
"SEARCH"              =>  "Buscar",
"GO_BACK"             =>  "Volver a la página anterior",

# date settings
"DATE_FORMAT"         =>  "%d.%m.%Y"

);

?>