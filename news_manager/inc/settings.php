<?php if (!defined('IN_GS')) {die('you cannot load this page directly.');}

/**
 * News Manager configuration functions.
 */


/*******************************************************
 * @function nm_env_check
 * @action check plugin environment
 */
function nm_env_check() {
  $env_ok = file_exists(NMPOSTPATH) || nm_create_dir(NMPOSTPATH);
  if ($env_ok && !file_exists(NMBACKUPPATH))
    $env_ok = nm_create_dir(NMBACKUPPATH);
  if ($env_ok && !file_exists(NMDATAPATH)) {
    if ($env_ok = nm_create_dir(NMDATAPATH))
      nm_update_cache();
  }
  if (!$env_ok)
    echo '<h3>News Manager</h3><p>' . i18n_r('news_manager/ERROR_ENV') . '</p>';
  return $env_ok;
}


/*******************************************************
 * @function nm_edit_settings
 * @action edit plugin configuration settings
 */
function nm_edit_settings() {
  global $PRETTYURLS, $NMPAGEURL, $NMPRETTYURLS, $NMLANG, $NMSHOWEXCERPT,
         $NMEXCERPTLENGTH, $NMPOSTSPERPAGE, $NMRECENTPOSTS;
  include(NMTEMPLATEPATH . 'edit_settings.php');
}


/*******************************************************
 * @function nm_save_settings
 * @action parse POST data and save to config file
 */
function nm_save_settings() {
  global $NMPAGEURL, $NMPRETTYURLS, $NMLANG, $NMSHOWEXCERPT, $NMEXCERPTLENGTH,
         $NMPOSTSPERPAGE, $NMRECENTPOSTS;
  $backup = array('page_url' => $NMPAGEURL, 'pretty_urls' => $NMPRETTYURLS);
  # parse $_POST
  $NMPAGEURL       = $_POST['page-url'];
  $NMPRETTYURLS    = isset($_POST['pretty-urls']) ? 'Y' : '';
  $NMLANG          = $_POST['language'];
  $NMSHOWEXCERPT   = $_POST['show-excerpt'] ? 'Y' : '';
  $NMEXCERPTLENGTH = intval($_POST['excerpt-length']);
  $NMPOSTSPERPAGE  = intval($_POST['posts-per-page']);
  $NMRECENTPOSTS   = intval($_POST['recent-posts']);
  # write settings to file
  if (nm_settings_to_xml())
    nm_display_message(i18n_r('news_manager/SUCCESS_SAVE'));
  else
    nm_display_message(i18n_r('news_manager/ERROR_SAVE'), true);
  # should we update .htaccess?
  if ($NMPRETTYURLS == 'Y') {
    if ($backup['pretty_urls'] != 'Y' || $backup['page_url'] != $NMPAGEURL)
      nm_display_message(i18n_r('news_manager/UPDATE_HTACCESS'), true);
  }
}


/*******************************************************
 * @function nm_settings_to_xml
 * @action write plugin settings to config file
 */
function nm_settings_to_xml() {
  global $NMPAGEURL, $NMPRETTYURLS, $NMLANG, $NMSHOWEXCERPT, $NMEXCERPTLENGTH,
         $NMPOSTSPERPAGE, $NMRECENTPOSTS;
  $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><item></item>');
  $obj = $xml->addChild('page_url', $NMPAGEURL);
  $obj = $xml->addChild('pretty_urls', $NMPRETTYURLS);
  $obj = $xml->addChild('language', $NMLANG);
  $obj = $xml->addChild('show_excerpt', $NMSHOWEXCERPT);
  $obj = $xml->addChild('excerpt_length', $NMEXCERPTLENGTH);
  $obj = $xml->addChild('posts_per_page', $NMPOSTSPERPAGE);
  $obj = $xml->addChild('recent_posts', $NMRECENTPOSTS);
  return @XMLsave($xml, NMSETTINGS);
}


/*******************************************************
 * @function nm_generate_htaccess
 * @action generate a .htaccess sample config based on current settings
 */
function nm_generate_htaccess() {
  global $NMPAGEURL;
  $path = tsl(suggest_site_path(true));
  $prefix = '';
  $page =  '';
  # format prefix and page directions
  if ($NMPAGEURL != 'index') {
    $data = getXML(GSDATAPAGESPATH . $NMPAGEURL . '.xml');
    $parent = $data->parent;
    $prefix = $parent != '' ? "$parent/$NMPAGEURL/" : "$NMPAGEURL/";
    $page = "id=$NMPAGEURL&";
  }
  # generate .htaccess contents
  $htaccess = file_get_contents(GSPLUGINPATH . 'news_manager/temp.htaccess');
  $htaccess = str_replace('**PATH**', $path, $htaccess);
  $htaccess = str_replace('**PREFIX**', $prefix, $htaccess);
  $htaccess = str_replace('**PAGE**', $page, $htaccess);
  $htaccess = htmlentities($htaccess, ENT_QUOTES, 'UTF-8');
  # show .htaccess
  include(NMTEMPLATEPATH . 'htaccess.php');
}


?>
