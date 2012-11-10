<?php

/**
 * News Manager English language file by Rogier Koppejan
 */


$i18n = array(

# general
"PLUGIN_NAME"         =>  "News Manager",

# error messages
"ERROR_ENV"           =>  "There was an error accessing the data folders. <em>CHMOD 777</em> the folders /data, /backups and their sub-folders and retry.",
"ERROR_SAVE"          =>  "<b>Error:</b> Unable to save your changes. <em>CHMOD 777</em> the folders /data, /backups and their sub-folders and retry.",
"ERROR_DELETE"        =>  "<b>Error:</b> Unable to delete the post. <em>CHMOD 777</em> the folders /data, /backups and their sub-folders and retry.",
"ERROR_RESTORE"       =>  "<b>Error:</b> Unable to restore the post. <em>CHMOD 777</em> the folders /data, /backups and their sub-folders and retry.",

# success messages
"SUCCESS_SAVE"        =>  "Your changes have been saved.",
"SUCCESS_DELETE"      =>  "The post has been deleted.",
"SUCCESS_RESTORE"     =>  "The post has been restored.",

# other messages
"UPDATE_HTACCESS"     =>  "<b>Note:</b> You probably have to update your <a href=\"load.php?id=news_manager&htaccess\">.htaccess</a> file!",

# admin button (top-right)
"SETTINGS"            =>  "Settings",
"NEW_POST"            =>  "Create New Post",

# admin panel
"POST_TITLE"          =>  "Post Title",
"DATE"                =>  "Date",
"EDIT_POST"           =>  "Edit Post",
"VIEW_POST"           =>  "View Post",
"DELETE_POST"         =>  "Delete Post",
"POSTS"               =>  "post(s)",

# edit settings
"NM_SETTINGS"         =>  "News Manager Settings",
"DOCUMENTATION"       =>  "For more information on these settings, visit the <a href=\"http://rxgr.nl/newsmanager/\" target=\"_blank\">documentation page</a>.",
"PAGE_URL"            =>  "Page to display posts",
"LANGUAGE"            =>  "Language used on News Page",
"SHOW_POSTS_AS"       =>  "Posts on News Page are shown as",
"FULL_TEXT"           =>  "Full Text",
"EXCERPT"             =>  "Excerpt",
"PRETTY_URLS"         =>  "Use Fancy URLs for posts, archives, etc.",
"PRETTY_URLS_NOTE"    =>  "If you have Fancy URLs enabled, you might have to update your .htaccess file after saving these settings.",
"EXCERPT_LENGTH"      =>  "Excerpt length (characters)",
"POSTS_PER_PAGE"      =>  "Number of posts on News Page",
"RECENT_POSTS"        =>  "Number of recent posts (in sidebar)",

# edit post
"POST_OPTIONS"        =>  "Post Options",
"POST_SLUG"           =>  "Slug/URL",
"POST_TAGS"           =>  "Tags (separate tags with commas)",
"POST_DATE"           =>  "Publish date (<i>mm/dd/yyyy</i>)",
"POST_TIME"           =>  "Publish time (<i>hh:mm</i>)",
"POST_PRIVATE"        =>  "Post is private",
"LAST_SAVED"          =>  "Last Saved",

# htaccess
"HTACCESS_HELP"       =>  "To enable Fancy URLs for posts, archives, etc., replace the contents of your <code>.htaccess</code> file with the lines below.",
"GO_BACK_WHEN_DONE"   =>  "When you are done with this page, click the button below to go back to the main panel.",

# save/cancel/delete
"SAVE_SETTINGS"       =>  "Save Settings",
"SAVE_POST"           =>  "Save Post",
"FINISHED"            =>  "Finished",
"CANCEL"              =>  "Cancel",
"DELETE"              =>  "Delete",
"OR"                  =>  "or",

# front-end/site
"FOUND"               =>  "The following posts have been found:",
"NOT_FOUND"           =>  "Sorry, your search returned no hits.",
"NOT_EXIST"           =>  "The requested post does not exist.",
"NO_POSTS"            =>  "No posts have been found.",
"PUBLISHED"           =>  "Published on",
"TAGS"                =>  "Tags",
"OLDER_POSTS"         =>  "Older Posts",
"NEWER_POSTS"         =>  "Newer Posts",
"SEARCH"              =>  "Search",
"GO_BACK"             =>  "Go back to the previous page",

# date settings
"DATE_FORMAT"         =>  "%b %e, %Y"

);

?>
