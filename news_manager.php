<?php


/*
Plugin Name: News Manager
Description: A blog/news plugin for GetSimple
Version: 2.2.4
Author: Rogier Koppejan
Author URI: http://rxgr.nl/newsmanager/
*/


# get correct id for plugin
$thisfile = basename(__FILE__, '.php');

# register plugin
register_plugin(
  $thisfile,
  'News Manager',
  '2.2.4',
  'Rogier Koppejan',
  'http://rxgr.nl/newsmanager/',
  'A blog/news plugin for GetSimple',
  'pages',
  'nm_admin'
);


# hooks
add_action('pages-sidebar', 'createSideMenu', array($thisfile, 'News Manager'));
add_action('sitemap-additem', 'nm_sitemap_include');
add_action('header', 'nm_header_include');
add_filter('content', 'nm_site');

# includes
require_once('news_manager/inc/common.php');

# language
i18n_merge('news_manager') || i18n_merge('news_manager', 'en_US');


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
 * @function nm_site
 * @action front-end main function
 */
function nm_site($content)
{
  nm_i18n_merge();
  global $NMPAGEURL;
  $url = strval(get_page_slug(false));
  if ($url == $NMPAGEURL) {
    $content = '';
    if (isset($_POST['search'])) {
      nm_show_search_results();
    } elseif (isset($_GET['archive'])) {
      $archive = $_GET['archive'];
      nm_show_archive($archive);
    } elseif (isset($_GET['tag'])) {
      $tag = $_GET['tag'];
      nm_show_tag($tag);
    } elseif (isset($_GET['post'])) {
      $slug = $_GET['post'];
      nm_show_post($slug);
    } elseif (isset($_GET['page'])) {
      $index = $_GET['page'];
      nm_show_page($index);
    } else {
      nm_show_page();
    }
  }
  return $content;
}


?>
