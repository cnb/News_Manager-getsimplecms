<?php if (!defined('IN_GS')) {die('you cannot load this page directly.');}

/**
 * News Manager general functions.
 */


/*******************************************************
 * @function nm_get_posts
 * @param $all if true, include private and future posts
 * @return array with posts
 */
function nm_get_posts($all=false) {
  $now = time();
  $posts = array();
  $data = @getXML(NMPOSTCACHE);
  foreach ($data->item as $item) {
    if ($all || $item->private != 'Y' && strtotime($item->date) < $now)
      $posts[] = $item;
  }
  return $posts;
}


/*******************************************************
 * @function nm_get_archives
 * @return array with monthly archives (keys) and posts (values)
 */
function nm_get_archives() {
  $archives = array();
  $posts = nm_get_posts();
  foreach ($posts as $post) {
    $archive = date('Ym', strtotime($post->date));
    $archives[$archive][] = $post->slug;
  }
  return $archives;
}


/*******************************************************
 * @function nm_get_tags
 * @return array with unique tags (keys) and posts (values)
 */
function nm_get_tags() {
  $tags = array();
  $posts = nm_get_posts();
  foreach ($posts as $post) {
    if (!empty($post->tags)) {
      foreach (explode(',', $post->tags) as $tag)
        $tags[$tag][] = $post->slug;
    }
  }
  ksort($tags);
  return $tags;
}


/*******************************************************
 * @function nm_get_languages
 * @return array with language files in NMLANGPATH
 */
function nm_get_languages() {
  $languages = array();
  $files = getFiles(NMLANGPATH);
  foreach ($files as $file) {
    if (isFile($file, NMLANGPATH, 'php')) {
      $lang = basename($file, '.php');
      $languages[$lang] = NMLANGPATH . $file;
    }
  }
  ksort($languages);
  return $languages;
}


/*******************************************************
 * @function nm_get_date
 * @param $format date format
 * @param $timestamp UNIX timestamp
 * @return date formatted according to $NNLANG
 */
function nm_get_date($format, $timestamp) {
  global $NMLANG;
  $locale = setlocale(LC_TIME, null);
  setlocale(LC_TIME, $NMLANG);
  $date = strftime($format, $timestamp);
  setlocale(LC_TIME, $locale);
  return $date;
}


/*******************************************************
 * @function nm_get_url
 * @return url of front-end newspage, with optional query
 */
function nm_get_url($query=false) {
  global $SITEURL, $PRETTYURLS, $NMPAGEURL, $NMPRETTYURLS;
  $data = getXML(GSDATAPAGESPATH . $NMPAGEURL . '.xml');
  $url = find_url($NMPAGEURL, $data->parent);
  if ($query) {
    if ($PRETTYURLS == 1 && $NMPRETTYURLS == 'Y')
      $url .= $query . '/';
    elseif ($NMPAGEURL == 'index')
      $url = $SITEURL . "index.php?$query=";
    else
      $url = $SITEURL . "index.php?id=$NMPAGEURL&$query=";
  }
  return $url;
}


/*******************************************************
 * @function nm_create_dir
 * @param $path full path of the directory
 * @action create the directory $path
 */
function nm_create_dir($path) {
  if (mkdir($path, 0777)) {
    $fh = fopen($path . '.htaccess', 'w');
    fwrite($fh, 'Deny from all');
    fclose($fh);
    return true;
  }
  return false;
}


/*******************************************************
 * @function nm_create_slug
 * @param $str string
 * @return a url friendly version of $str
 */
function nm_create_slug($str) {
  $str = to7bit($str, 'UTF-8');
  $str = clean_url($str);
  return $str;
}


/*******************************************************
 * @function nm_create_excerpt
 * @param $content the post content
 * @return a truncated version of the post content
 */
function nm_create_excerpt($content) {
  global $NMEXCERPTLENGTH;
  $len = intval($NMEXCERPTLENGTH);
  $content = strip_tags($content);
  if (strlen($content) > $len) {
    if (function_exists('mb_substr'))
      $content = trim(mb_substr($content, 0, $len, 'UTF-8')) . ' [...]';
    else
      $content = trim(substr($content, 0, $len)) . ' [...]';
  }
  return "<p>$content</p>";
}


/*******************************************************
 * @function nm_i18n_merge
 * @action update the $i18n language array
 */
function nm_i18n_merge() {
  global $NMLANG;
  if (isset($NMLANG) && $NMLANG != '') {
    include(NMLANGPATH . "$NMLANG.php");
    $nm_i18n = $i18n;
    global $i18n;
    foreach ($nm_i18n as $code=>$text)
      $i18n['news_manager/' . $code] = $text;
  }
}


/*******************************************************
 * @function nm_sitemap_include
 * @action add posts to sitemap.xml
 */
function nm_sitemap_include() {
  global $NMPAGEURL, $page, $xml;
  if (strval($page['url']) == $NMPAGEURL) {
    $posts = nm_get_posts();
    foreach ($posts as $post) {
      $url = nm_get_url('post') . $post->slug;
      $file = NMPOSTPATH . "$post->slug.xml";
      $date = makeIso8601TimeStamp(date("Y-m-d H:i:s", filemtime($file)));
      $item = $xml->addChild('url');
      $item->addChild('loc', $url);
      $item->addChild('lastmod', $date);
      $item->addChild('changefreq', 'monthly');
      $item->addChild('priority', '0.5');
    }
  }
}


/*******************************************************
 * @function nm_header_include
 * @action insert necessary script/style sections into site header
 */
function nm_header_include() {
  ?>
  <script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.8/jquery.validate.min.js"></script>
  <style>
    .invalid {
      color: #D94136;
      font-size: 11px;
      font-weight: normal;
    }
  </style>
  <?php
}


/*******************************************************
 * @function nm_display_message
 * @param $msg a string containing the message
 * @param $error if true, show as $msg as error, else as update
 * @param $backup when set, include undo link
 * @action display status messages on back-end pages
 */
function nm_display_message($msg, $error=false, $backup=null) {
  if (isset($msg)) {
    if (isset($backup))
      $msg .= " <a href=\"load.php?id=news_manager&restore=$backup\">" . i18n_r('UNDO') . '</a>';
    ?>
    <script type="text/javascript">
      $(function() {
        $('div.bodycontent').before('<div class="<?php echo $error ? 'error' : 'updated'; ?>" style="display:block;">'+
          <?php echo json_encode($msg); ?>+'</div>');
        $(".updated, .error").fadeOut(500).fadeIn(500);
      });
    </script>
    <?php
  }
}


?>
