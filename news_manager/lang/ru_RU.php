<?php

/**
 * News Manager Russian language file by reff http://reff.pp.ua/
 */


$i18n = array(

# general
"PLUGIN_NAME"         =>  "Редактор новостей",

# error messages
"ERROR_ENV"           =>  "Произошла ошибка доступа к папке записей и/или к конфигурационному файлу. Установите права <em>CHMOD 777</em> по отношению к папке /data, /backups и вложенным в нее подпапкам и повторите попытку.",
"ERROR_SAVE"          =>  "<b>Ошибка:</b> Невозможно сохранить запись. Установите права <em>CHMOD 777</em> по отношению к папке /data, /backups и вложенным в нее подпапкам и повторите попытку.",
"ERROR_DELETE"        =>  "<b>Ошибка:</b> Невозможно удалить запись. Установите права <em>CHMOD 777</em> по отношению к папке /data, /backups и вложенным в нее подпапкам и повторите попытку.",
"ERROR_RESTORE"       =>  "<b>Error:</b> Unable to restore the post. <em>CHMOD 777</em> the folders /data, /backups and their sub-folders and retry.",

# success messages
"SUCCESS_SAVE"        =>  "Запись была успешно сохранена.",
"SUCCESS_DELETE"      =>  "Запись была успешно удалена.",
"SUCCESS_RESTORE"     =>  "The post has been restored.",

# other messages
"UPDATE_HTACCESS"     =>  "<b>Внимание:</b> Вам возможно потребуется обновить файл <a href=\"load.php?id=news_manager&htaccess\">.htaccess</a> вручную!",

# admin button (top-right)
"SETTINGS"            =>  "Установки",
"NEW_POST"            =>  "Создать новую запись",

# admin panel
"POST_TITLE"          =>  "Заголовок записи",
"DATE"                =>  "Дата",
"EDIT_POST"           =>  "Редактировать запись",
"VIEW_POST"           =>  "Просмотреть запись",
"DELETE_POST"         =>  "Удалить запись",
"POSTS"               =>  "всего записей",

# edit settings
"NM_SETTINGS"         =>  "Настройки редактора новостей",
"DOCUMENTATION"       =>  "В случае вопросов по настройке свяжитесь с администратором",
"PAGE_URL"            =>  "Адрес страницы новостной ленты",
"LANGUAGE"            =>  "Предпочитаемый язык",
"SHOW_POSTS_AS"       =>  "Режим отображения новостей",
"FULL_TEXT"           =>  "Полный текст",
"EXCERPT"             =>  "Отрывок",
"PRETTY_URLS"         =>  "Использовать ЧПУ (<a href='http://ru.wikipedia.org/wiki/%D0%A7%D0%9F%D0%A3_(%D0%98%D0%BD%D1%82%D0%B5%D1%80%D0%BD%D0%B5%D1%82)'>человеко-понятный</a> URL)",
"PRETTY_URLS_NOTE"    =>  "Если используется ЧПУ, возможно потребуется изменить вручную файл .htaccess",
"EXCERPT_LENGTH"      =>  "Длина отрывка новости (количество символов)",
"POSTS_PER_PAGE"      =>  "Количество новостей на странице новостной ленты",
"RECENT_POSTS"        =>  "Количество последних новостных записей в виджете боковой панели",

# edit post
"POST_OPTIONS"        =>  "Настройки записи",
"POST_SLUG"           =>  "Slug/URL",
"POST_TAGS"           =>  "Тэг(и) - через запятую",
"POST_DATE"           =>  "Дата публикации (<i>мм/дд/гггг</i>)",
"POST_TIME"           =>  "время публикации (<i>чч:мм</i>)",
"POST_PRIVATE"        =>  "Скрытая запись (черновик)",
"LAST_SAVED"          =>  "Дата последнего сохранения",

# htaccess
"HTACCESS_HELP"       =>  "Для включения ЧПУ (<a href='http://ru.wikipedia.org/wiki/%D0%A7%D0%9F%D0%A3_(%D0%98%D0%BD%D1%82%D0%B5%D1%80%D0%BD%D0%B5%D1%82)'>человеко-понятный</a> URL) замените содержимое файла <code>.htaccess</code> следующим текстом.",
"GO_BACK_WHEN_DONE"   =>  "Сохранить и вернуться.",

# save/cancel/delete
"SAVE_SETTINGS"       =>  "Сохранить настройки",
"SAVE_POST"           =>  "Сохранить новость",
"FINISHED"            =>  "Готово",
"CANCEL"              =>  "Отмена",
"DELETE"              =>  "Удалить",
"OR"                  =>  "или",

# front-end/site
"FOUND"               =>  "Были найдены следующие записи:",
"NOT_FOUND"           =>  "Ничего не найдено.",
"NOT_EXIST"           =>  "Запрошенная запись не найдена.",
"NO_POSTS"            =>  "Нет опубликованных записей.",
"PUBLISHED"           =>  "Опубликовано:",
"TAGS"                =>  "Теги",
"OLDER_POSTS"         =>  "Назад",
"NEWER_POSTS"         =>  "Вперед",
"SEARCH"              =>  "Найти",
"GO_BACK"             =>  "Вернуться на предыдущую страницу",

# date settings
"DATE_FORMAT"         =>  "%b %e, %Y"

);

?>
