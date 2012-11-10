<?php

/**
 * Common variables used by the GetSimple News Manager Plugin.
 */


# path definitions
define('NMPOSTPATH', GSDATAPATH  . 'posts/');
define('NMBACKUPPATH', GSBACKUPSPATH  . 'posts/');
define('NMDATAPATH', GSDATAOTHERPATH  . 'news_manager/');
define('NMINCPATH', GSPLUGINPATH . 'news_manager/inc/');
define('NMLANGPATH', GSPLUGINPATH . 'news_manager/lang/');
define('NMTEMPLATEPATH', GSPLUGINPATH . 'news_manager/template/');


# file definitions
define('NMSETTINGS', NMDATAPATH . 'settings.xml');
define('NMPOSTCACHE', NMDATAPATH . 'posts.xml');


# includes
require_once(NMINCPATH . 'functions.php');
require_once(NMINCPATH . 'settings.php');
require_once(NMINCPATH . 'cache.php');
require_once(NMINCPATH . 'admin.php');
require_once(NMINCPATH . 'posts.php');
require_once(NMINCPATH . 'site.php');
require_once(NMINCPATH . 'sidebar.php');


# load settings
$data = @getXML(NMSETTINGS);
$NMPAGEURL       = isset($data->page_url) ? $data->page_url : 'index';
$NMPRETTYURLS    = isset($data->pretty_urls) ? $data->pretty_urls : '';
$NMLANG          = isset($data->language) ? $data->language : 'en_US';
$NMSHOWEXCERPT   = isset($data->show_excerpt) ? $data->show_excerpt : '';
$NMEXCERPTLENGTH = isset($data->excerpt_length) ? $data->excerpt_length : '350';
$NMPOSTSPERPAGE  = isset($data->posts_per_page) ? $data->posts_per_page : '8';
$NMRECENTPOSTS   = isset($data->recent_posts) ? $data->recent_posts : '5';


?>
