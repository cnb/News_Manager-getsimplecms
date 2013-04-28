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
  if (!file_exists(NMPOSTCACHE))
    nm_update_cache();
  $data = @getXML(NMPOSTCACHE);
  $now = time();
  $posts = array();
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
 * @return date formatted according to $NMLANG
 */
function nm_get_date($format, $timestamp) {
  global $NMLANG, $i18n;
  $locale = setlocale(LC_TIME, 0);
  // setlocale(LC_TIME, $NMLANG);
  if (array_key_exists('news_manager/LOCALE', $i18n)) {
    setlocale(LC_TIME, preg_split('/s*,s*/', $i18n['news_manager/LOCALE']));
  } else {
    # no locale in language file
    $lg = substr($NMLANG,0,2);
    setlocale(LC_TIME, $NMLANG.'.utf8', $lg.'.utf8', $NMLANG.'.UTF-8', $lg.'.UTF-8', $NMLANG, $lg);
  }
  if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN') {
    // workaround for Windows, as strftime returns ISO-8859-1 encoded string
    $date = utf8_encode(strftime($format, $timestamp));
  } else {
    $date = strftime($format, $timestamp);
  }
  setlocale(LC_TIME, $locale);
  return $date;
}


/*******************************************************
 * @function nm_get_url
 * @return url of front-end newspage, with optional query
 */
function nm_get_url($query=false) {
  global $PRETTYURLS, $NMPAGEURL, $NMPRETTYURLS, $NMPARENTURL;
  $str = '';
  $url = find_url($NMPAGEURL, $NMPARENTURL);
  if (basename($_SERVER['PHP_SELF']) != 'index.php') // back end only
    if (function_exists('find_i18n_url')) // I18N?
      $url = find_i18n_url($NMPAGEURL, $NMPARENTURL, return_i18n_default_language());
  if ($query) {
    if ($PRETTYURLS == 1 && $NMPRETTYURLS == 'Y') {
      $str = $query . '/';
      if (substr($url, -1) != '/')
        $str = '/' . $str;
    } else {
      $str = (strpos($url,'?') === false)? '?' : '&amp;';
      $str .= $query.'='; 
    }
  }
  return $url . $str;
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
 * @function nm_rename_file
 * @since 2.3.2
 * @param $oldfile origin file
 * @param $newfile destination file
 * @action rename or move a file - like rename() but safer (Windows)
 * @link http://www.php.net/manual/en/function.rename.php#56576
 */
function nm_rename_file($oldfile,$newfile) {
  if (!rename($oldfile,$newfile)) {
   if (copy ($oldfile,$newfile)) {
	   unlink($oldfile);
	   return TRUE;
    }
    return FALSE;
  }
  return TRUE;
}

/*******************************************************
 * @function nm_create_slug
 * @param $str string
 * @return a url friendly version of $str
 */
function nm_create_slug($str) {
  global $i18n;
  $str = trim($str);
  if (isset($i18n['TRANSLITERATION']) && is_array($translit=$i18n['TRANSLITERATION']) && count($translit>0)) {
    $str = str_replace(array_keys($translit),array_values($translit),$str);
  }
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
    if (dirname(realpath(NMLANGPATH.$NMLANG.'.php')) != realpath(NMLANGPATH)) die(''); // path traversal
    include(NMLANGPATH.$NMLANG.'.php');
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
  if (isset($_GET['id']) && $_GET['id'] == 'news_manager' && isset($_GET['edit'])) {
    if (!function_exists('register_script')) {
	  // for GetSimple 3.0
      echo '<script type="text/javascript" src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.10.0/jquery.validate.min.js"></script>';
    }
  ?>
  <style>
    .invalid {
      color: #D94136;
      font-size: 11px;
      font-weight: normal;
    }
  </style>
  <?php
  }
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
      $msg .= " <a href=\"load.php?id=news_manager&amp;restore=$backup\">" . i18n_r('UNDO') . '</a>';
    ?>
    <script type="text/javascript">
      $(function() {
        $('div.bodycontent').before('<div class="<?php echo $error ? 'error' : 'updated'; ?>" style="display:block;">'+
          <?php echo json_encode($msg); ?>+'</div>');
        $(".updated, .error").fadeOut(500).fadeIn(500);
      });
    </script>
	<noscript>
	  <div class="<?php echo $error ? 'error' : 'updated'; ?>" style="display:block;"><?php echo $msg; ?></div>
	</noscript>
    <?php
  }
}


?>
