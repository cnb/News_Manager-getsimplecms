<?php if (!defined('IN_GS')) {die('you cannot load this page directly.');}

/**
 * Optional sidebar functions for the GetSimple News Manager Plugin.
 */


/*******************************************************
 * @function nm_list_recent
 * @action print a list with the latest posts (titles only)
 */
function nm_list_recent() {
  global $NMRECENTPOSTS;
  $posts = nm_get_posts();
  if (!empty($posts)) {
    echo '<ul class="nm_recent">',PHP_EOL;
    $posts = array_slice($posts, 0, $NMRECENTPOSTS, true);
    foreach ($posts as $post) {
      $url = nm_get_url('post') . $post->slug;
      $title = stripslashes($post->title);
      echo "<li><a href=\"$url\">$title</a></li>",PHP_EOL;
    }
    echo '</ul>',PHP_EOL;
  }
}


/*******************************************************
 * @function nm_list_archives
 * @action print a list of archives ordered by month or year
 */
function nm_list_archives() {
  global $NMARCHIVESBY;
  $archives = array_keys(nm_get_archives($NMARCHIVESBY));
  if (!empty($archives)) {
    echo '<ul class="nm_archives">',PHP_EOL;
    if ($NMARCHIVESBY == 'y') {
      # annual
      foreach ($archives as $archive) {
        $y = $archive;
        $title = nm_get_date('%Y', mktime(0, 0, 0, 1, 1, $y));
        $url = nm_get_url('archive') . $archive;
        echo "<li><a href=\"$url\">$title</a></li>",PHP_EOL;
      }
    } else {
      # monthly
      foreach ($archives as $archive) {
        list($y, $m) = str_split($archive, 4);
        $title = nm_get_date('%B %Y', mktime(0, 0, 0, $m, 1, $y));
        $url = nm_get_url('archive') . $archive;
        echo "<li><a href=\"$url\">$title</a></li>",PHP_EOL;
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
  $tags = array();
  foreach (nm_get_tags() as $tag=>$posts)
    if (substr($tag, 0, 1) != '_')
      $tags[$tag] = count($posts);
  if (!empty($tags)) {
    $min = min($tags);
    $max = max($tags);
    foreach ($tags as $tag=>$count) {
      $url = nm_get_url('tag') . $tag;
      if ($min < $max && $count/$max > 0.5)
        echo "<a class=\"large\" href=\"$url\">$tag</a> ";
      else
        echo "<a href=\"$url\">$tag</a> ";
    }
  }
}


/*******************************************************
 * @function nm_search
 * @action provide form to search posts by keyword(s)
 */
function nm_search() {
  $url = nm_get_url();
  ?>
  <form id="search" action="<?php echo $url; ?>" method="post">
    <input type="text" class="text" name="keywords" />
    <!--[if IE]><input type="text" style="display: none;" disabled="disabled"
    size="20" value="Ignore field. IE bug fix" /><![endif]-->
    <input type="submit" class="submit" name="search" value="<?php i18n('news_manager/SEARCH'); ?>" />
  </form>
  <?php
}


?>
