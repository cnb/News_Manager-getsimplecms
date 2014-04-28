<?php if (!defined('IN_GS')) {die('you cannot load this page directly.');}

/**
 * Optional sidebar functions for the GetSimple News Manager Plugin.
 */


/*******************************************************
 * @function nm_list_recent
 * @action print a list with the latest posts (titles only)
 */
function nm_list_recent() {
  global $NMPAGEURL, $NMRECENTPOSTS;
  if ($NMPAGEURL == '') return;
  $posts = nm_get_posts();
  if (!empty($posts)) {
    echo '<ul class="nm_recent">',PHP_EOL;
    $posts = array_slice($posts, 0, $NMRECENTPOSTS, true);
    foreach ($posts as $post) {
      $url = nm_get_url('post') . $post->slug;
      $title = stripslashes($post->title);
      echo '  <li><a href="',$url,'">',$title,'</a></li>',PHP_EOL;
    }
    echo '</ul>',PHP_EOL;
  }
}


/*******************************************************
 * @function nm_list_archives
 * @action print a list of archives ordered by month or year
 * @param $fmt optional custom format (strftime), default "%B %Y" or "%Y" or as defined in language file
 */
function nm_list_archives($fmt='') {
  global $NMPAGEURL, $NMSETTING;
  if ($NMPAGEURL == '') return;
  $archives = array_keys(nm_get_archives($NMSETTING['archivesby']));
  if (!empty($archives)) {
    echo '<ul class="nm_archives">',PHP_EOL;
    if ($NMSETTING['archivesby'] == 'y') {
      # annual
      if (!$fmt) $fmt = isset($i18n['news_manager/YEARLY_FORMAT']) ? $i18n['news_manager/YEARLY_FORMAT'] : '%Y';
      foreach ($archives as $archive) {
        $y = $archive;
        $title = nm_get_date($fmt, mktime(0, 0, 0, 1, 1, $y));
        $url = nm_get_url('archive') . $archive;
        echo '  <li><a href="',$url,'">',$title,'</a></li>',PHP_EOL;
      }
    } else {
      # monthly
      if (!$fmt) $fmt = isset($i18n['news_manager/MONTHLY_FORMAT']) ? $i18n['news_manager/MONTHLY_FORMAT'] : '%B %Y';
      foreach ($archives as $archive) {
        list($y, $m) = str_split($archive, 4);
        $title = nm_get_date($fmt, mktime(0, 0, 0, $m, 1, $y));
        $url = nm_get_url('archive') . $archive;
        echo '  <li><a href="',$url,'">',$title,'</a></li>',PHP_EOL;
      }
    }
    echo '</ul>',PHP_EOL;
  }
}


/*******************************************************
 * @function nm_list_tags
 * @action print unique tags, popular tags are bigger.
 */
function nm_list_tags() {
  global $NMPAGEURL;
  if ($NMPAGEURL == '') return;
  $tags = array();
  foreach (nm_get_tags() as $tag=>$posts)
    if (substr($tag, 0, 1) != '_')
      $tags[$tag] = count($posts);
  if (!empty($tags)) {
    $min = min($tags);
    $max = max($tags);
    foreach ($tags as $tag=>$count) {
      $url = nm_get_url('tag').rawurlencode($tag);
      if ($min < $max && $count/$max > 0.5)
        echo '<a class="large" href="',$url,'">',$tag,'</a>',PHP_EOL;
      else
        echo '<a href="',$url,'">',$tag,'</a>',PHP_EOL;
    }
    echo PHP_EOL;
  }
}

/*******************************************************
 * @function nm_tag_list
 * @action display list of unique tags
 * @since 3.0
 */
function nm_tag_list() {
  global $NMPAGEURL;
  if ($NMPAGEURL == '') return;
  $tags = array();
  foreach (nm_get_tags() as $tag=>$posts)
    if (substr($tag, 0, 1) != '_')
      $tags[$tag] = count($posts);
  if (!empty($tags)) {
    echo '<ul class="nm_tag_list">',PHP_EOL;
    foreach ($tags as $tag=>$count) {
      $url = nm_get_url('tag').rawurlencode($tag);
      echo '  <li><a href="',$url,'">',$tag,'</a></li>',PHP_EOL;
    }
    echo '</ul>',PHP_EOL;
  }
}


/*******************************************************
 * @function nm_search
 * @action provide form to search posts by keyword(s)
 */
function nm_search() {
  global $NMPAGEURL, $i18n;
  if ($NMPAGEURL == '') return;
  $placeholder = (isset($i18n['news_manager/SEARCH_PLACEHOLDER'])) ? $i18n['news_manager/SEARCH_PLACEHOLDER'] : '';
  $url = nm_get_url();
  ?>
  <form id="search" action="<?php echo $url; ?>" method="post">
    <input type="text" class="text" name="keywords" value="" <?php
    if ($placeholder) echo 'placeholder="',htmlspecialchars($placeholder),'"';
    ?> /><!--[if IE]><input type="text" style="display: none;" disabled="disabled" size="20" value="Ignore field. IE bug fix"
    /><![endif]--><input type="submit" class="submit" name="search" value="<?php i18n('news_manager/SEARCH'); ?>" />
  </form>
  <?php
}


?>