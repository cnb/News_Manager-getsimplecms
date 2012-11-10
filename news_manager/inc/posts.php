<?php if (!defined('IN_GS')) {die('you cannot load this page directly.');}

/**
 * News Manager post management functions.
 */


/*******************************************************
 * @function nm_edit_post
 * @param $slug - post slug
 * @action edit or create posts
 */
function nm_edit_post($slug) {
  $file = NMPOSTPATH . "$slug.xml";
  # get post data, if it exists
  $data    = @getXML($file);
  $title   = @stripslashes($data->title);
  $date    = !empty($data) ? date('m/d/Y', strtotime($data->date)) : '';
  $time    = !empty($data) ? date('H:i', strtotime($data->date)) : '';
  $tags    = @str_replace(',', ', ', ($data->tags));
  $private = @$data->private != '' ? 'checked' : '';
  $content = @stripslashes($data->content);
  # show edit post form
  include(NMTEMPLATEPATH . 'edit_post.php');
  if (file_exists($file)) {
    $mtime = date(i18n_r('DATE_AND_TIME_FORMAT'), filemtime($file));
    echo '<small>' . i18n_r('news_manager/LAST_SAVED') . ": $mtime</small>";
  }
  include(NMTEMPLATEPATH . 'ckeditor.php');
}


/*******************************************************
 * @function nm_save_post
 * @action write $_POST data to xml file
 */
function nm_save_post() {
  # create a backup if necessary
  if (isset($_POST['current-slug'])) {
    $file = $_POST['current-slug'] . '.xml';
    @rename(NMPOSTPATH . $file, NMBACKUPPATH . $file);
  }
  # empty titles are not allowed
  if (empty($_POST['post-title']))
    $_POST['post-title'] = '[No Title]';
  # set initial slug and filename
  if (!empty($_POST['post-slug']))
    $slug = nm_create_slug($_POST['post-slug']);
  else
    $slug = nm_create_slug($_POST['post-title']);
  $file = NMPOSTPATH . "$slug.xml";
  # do not overwrite other posts
  if (file_exists($file)) {
    $count = 1;
    $file = NMPOSTPATH . "$slug-$count.xml";
    while (file_exists($file))
      $file = NMPOSTPATH . "$slug-" . ++$count . '.xml';
    $slug = basename($file, '.xml');
  }
  # create undo target if there's a backup available
  if (isset($_POST['current-slug']))
    $backup = $slug . ':' . $_POST['current-slug'];
  # collect $_POST data
  $title     = safe_slash_html($_POST['post-title']);
  $timestamp = strtotime($_POST['post-date'] . ' ' . $_POST['post-time']);
  $date      = $timestamp ? date('r', $timestamp) : date('r');
  $tags      = str_replace(array(' ', ',,'), array('', ','), safe_slash_html($_POST['post-tags']));
  $private   = isset($_POST['post-private']) ? 'Y' : '';
  $content   = safe_slash_html($_POST['post-content']);
  # create xml object
  $xml = new SimpleXMLExtended('<?xml version="1.0" encoding="UTF-8"?><item></item>');
  $obj = $xml->addChild('title');
  $obj->addCData($title);
  $obj = $xml->addChild('date');
  $obj->addCData($date);
  $obj = $xml->addChild('tags');
  $obj->addCData($tags);
  $obj = $xml->addChild('private');
  $obj->addCData($private);
  $obj = $xml->addChild('content');
  $obj->addCData($content);
  # write data to file
  if (@XMLsave($xml, $file) && nm_update_cache())
    nm_display_message(i18n_r('news_manager/SUCCESS_SAVE'), false, @$backup);
  else
    nm_display_message(i18n_r('news_manager/ERROR_SAVE'), true);
}


/*******************************************************
 * @function nm_delete_post
 * @param $slug - post slug
 * @action deletes the requested post
 */
function nm_delete_post($slug) {
  $file = "$slug.xml";
  if (file_exists(NMPOSTPATH . $file)) {
    if (rename(NMPOSTPATH . $file, NMBACKUPPATH . $file) && nm_update_cache())
      nm_display_message(i18n_r('news_manager/SUCCESS_DELETE'), false, $slug);
    else
      nm_display_message(i18n_r('news_manager/ERROR_DELETE'), true);
  }
}


/*******************************************************
 * @function nm_restore_post
 * @param $target - string containing target(s)
 * @action restores a backup of the requested post
 */
function nm_restore_post($backup) {
  if (strpos($backup, ':')) {
    # revert to the previous version of a post
    list($current, $backup) = explode(':', $backup);
    $current .= '.xml';
    $backup .= '.xml';
    if (file_exists(NMPOSTPATH . $current) && file_exists(NMBACKUPPATH . $backup))
      $status = unlink(NMPOSTPATH . $current) &&
                rename(NMBACKUPPATH . $backup, NMPOSTPATH . $backup) &&
                nm_update_cache();
  } else {
    # restore the deleted post
    $backup .= '.xml';
    if (file_exists(NMBACKUPPATH . $backup))
      $status = rename(NMBACKUPPATH . $backup, NMPOSTPATH . $backup) &&
                nm_update_cache();
  }
  if (@$status)
    nm_display_message(i18n_r('news_manager/SUCCESS_RESTORE'));
  else
    nm_display_message(i18n_r('news_manager/ERROR_RESTORE'), true);
}


?>
