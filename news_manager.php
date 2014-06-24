<?php

/*
Plugin Name: News Manager
Description: A blog/news plugin for GetSimple
Version: 3.0
Original author: Rogier Koppejan
Updated by: Carlos Navarro

*/

# plugin version
define('NMVERSION', '3.0');

# get correct id for plugin
$thisfile = basename(__FILE__, '.php');

# register plugin
register_plugin(
  $thisfile,
  'News Manager',
  NMVERSION,
  'Rogier Koppejan, Carlos Navarro',
  'http://newsmanager.c1b.org/',
  'A blog/news plugin for GetSimple',
  'pages',
  'nm_admin'
);

# includes
require_once(GSPLUGINPATH.'news_manager/inc/common.php');

# language
i18n_merge('news_manager') || i18n_merge('news_manager', 'en_US');

# hooks
add_action('pages-sidebar', 'createSideMenu', array($thisfile, i18n_r('news_manager/PLUGIN_NAME')));
add_action('header', 'nm_header_include');
add_action('index-pretemplate', 'nm_frontend_init');
add_action('theme-header','nm_restore_page_title');
//add_filter('content', 'nm_site'); // deprecated
if (!function_exists('generate_sitemap')) {
  add_action('sitemap-additem', 'nm_sitemap_include'); // GetSimple 3.0
} else {
  add_filter('sitemap','nm_update_sitemap_xml'); // for GetSimple 3.3+
}
if (!defined('NMNOAPIUPDATE') || !NMNOAPIUPDATE) {
  add_action('common', 'nm_update_extend_cache');
}

# scripts (GetSimple 3.1+)
if (function_exists('register_script')) {
  if (isset($_GET['id']) && $_GET['id'] == 'news_manager' && (isset($_GET['edit']) || isset($_GET['settings']))) {
    if (!defined('GSNOCDN') || !GSNOCDN) {
      register_script('jquery-validate','//ajax.aspnetcdn.com/ajax/jquery.validate/1.10.0/jquery.validate.min.js', '1.10.0', false);
    } else {
      register_script('jquery-validate',$SITEURL.'plugins/news_manager/js/jquery.validate.min.js', '1.10.0', false);
    }
    queue_script('jquery-validate', GSBACK);
  }
}

/*******************************************************
 * @function nm_admin
 * @action back-end main function
 */
function nm_admin() {
  if (nm_env_check()) {
    # post management
    if (isset($_GET['edit'])) {
        nm_edit_post($_GET['edit']);
    } elseif (isset($_POST['post'])) {
        nm_save_post();
        nm_admin_panel();
    } elseif (isset($_GET['delete'])) {
        nm_delete_post($_GET['delete']);
        nm_admin_panel();
    } elseif (isset($_GET['restore'])) {
        nm_restore_post($_GET['restore']);
        nm_admin_panel();
    # settings management
    } elseif (isset($_GET['settings'])) {
        nm_edit_settings();
    } elseif (isset($_POST['settings'])) {
        nm_save_settings();
        nm_admin_panel();
    } elseif (isset($_GET['htaccess'])) {
        nm_generate_htaccess();
    } else {
        nm_admin_panel();
    }
  }
}

/*******************************************************
 * @function nm_frontend_init
 * @action front-end main function
 * @since 2.4
 */
function nm_frontend_init() {
  global $NMPAGEURL, $nmpagetype;
  $nmpagetype = array();
  nm_i18n_merge();
  $url = strval(get_page_slug(false));
  if ($url == $NMPAGEURL) {
    global $content, $metad;
    $metad_orig = ($metad == '' ? ' ' : $metad);
    $metad = ' ';
    $nmpagetype[] = 'site';
    ob_start();
    echo PHP_EOL;
    if (isset($_POST['search'])) {
        nm_reset_options('search');
        nm_show_search_results();
        $nmpagetype[] = 'search';

    } elseif (isset($_GET[NMPARAMARCHIVE])) {
        nm_reset_options('archive');
        if (nm_show_archive($_GET[NMPARAMARCHIVE], false))
          $nmpagetype[] = 'archive';

    } elseif (isset($_GET[NMPARAMTAG])) {
        nm_reset_options('tag');
        if (nm_get_option('tagpagination')) {
          $index = isset($_GET[NMPARAMPAGE]) ? intval($_GET[NMPARAMPAGE]) : NMFIRSTPAGE;
          if (nm_show_tag_page(rawurldecode($_GET[NMPARAMTAG]), $index, false))
            $nmpagetype[] = 'tag';
        } else {
          if (nm_show_tag(rawurldecode($_GET[NMPARAMTAG]), false))
            $nmpagetype[] = 'tag';
        }

    } elseif (isset($_GET[NMPARAMPOST])) {
        nm_reset_options('single');
        if (nm_show_post($_GET[NMPARAMPOST], false, false, true))
          $nmpagetype[] = 'single';

    } elseif (isset($_GET[NMPARAMPAGE]) && intval($_GET[NMPARAMPAGE]) > NMFIRSTPAGE) {
        nm_reset_options('main');
        nm_show_page($_GET[NMPARAMPAGE], false);
        $nmpagetype[] = 'main';

    } else {
        $metad = $metad_orig;
        nm_reset_options('main');
        nm_show_page(NMFIRSTPAGE, false);
        array_push($nmpagetype, 'main', 'home');
    }
    $content = nm_ob_get_content(false);
    $content = addslashes(htmlspecialchars($content, ENT_QUOTES, 'UTF-8'));
  }
  if (nm_get_option('templatefile'))
    nm_switch_template_file(nm_get_option('templatefile'));
  nm_reset_options();
  nm_update_page_title();
}

/*******************************************************
 * @deprecated as of 2.4+
 */
function nm_site($content) {
  return '[deprecated]';
}
