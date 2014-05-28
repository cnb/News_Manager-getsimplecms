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
 * @return array with monthly or yearly archives (keys) and post slugs (values)
 * @param $by month ('m') or year ('y'), default 'm' for monthly archives
 */
function nm_get_archives($by='m') {
  $archives = array();
  $posts = nm_get_posts();
  $datefmt = ($by == 'y') ? 'Y' : 'Ym';
  foreach ($posts as $post) {
    $archive = date($datefmt, strtotime($post->date));
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
      foreach (explode(',', nm_lowercase_tags(strip_decode($post->tags))) as $tag)
        $tags[trim($tag)][] = $post->slug;
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
    # fixes for Windows
    $format = preg_replace('#(?<!%)((?:%%)*)%e#', '\1%#d', $format); // strftime %e parameter not supported
    $date = utf8_encode(strftime($format, $timestamp)); // strftime returns ISO-8859-1 encoded string
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
  global $PRETTYURLS, $NMPAGEURL, $NMPRETTYURLS;
  $str = '';
  $url = find_url($NMPAGEURL, nm_get_parent());
  if (basename($_SERVER['PHP_SELF']) != 'index.php') // back end only
    if (function_exists('find_i18n_url')) // I18N?
      $url = find_i18n_url($NMPAGEURL, nm_get_parent(), return_i18n_default_language());
  if ($query) {
    switch($query) {
      case 'post':
        $query = NMPARAMPOST;
        break;
      case 'page':
        $query = NMPARAMPAGE;
        break;
      case 'tag':
        $query = NMPARAMTAG;
        break;
      case 'archive':
        $query = NMPARAMARCHIVE;
        break;
    }
    if ($PRETTYURLS == 1 && $NMPRETTYURLS == 'Y') {
      if ($query == NMPARAMPOST && defined('NMNOPARAMPOST') && NMNOPARAMPOST)
        $str = '';
      else
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
 * @function nm_get_parent
 * @return front-end newspage's parent slug
 * @since 2.4.0
 */
function nm_get_parent() {
  global $NMPARENTURL, $NMPAGEURL;
  if ($NMPAGEURL == '') {
    $NMPARENTURL = '';
  } else {
    if ($NMPARENTURL == '?') {
      global $pagesArray;
      if ($pagesArray) {
        $NMPARENTURL = returnPageField($NMPAGEURL, 'parent');
      } else {
        $gsdata = getXML(GSDATAPAGESPATH.$NMPAGEURL.'.xml');
        $NMPARENTURL = isset($gsdata->parent) ? $gsdata->parent : '';
      }
    }
  }
  return $NMPARENTURL;
}

/*******************************************************
 * @function nm_get_image_url
 * @param $pic image URL, full or relative to data/uploads/
 * @return absolute URL of thumbnail/image as defined by $nmoption settings
 * @since 3.0
 */
function nm_get_image_url($pic, $width=null, $height=null, $crop=null, $default=null) {
  global $SITEURL, $nmoption;
  $url = '';
  if (empty($pic)) {
    if ($default)
      $pic = $default;
    else
      if ($default !== '' && $nmoption['imagedefault'])
        $pic = $nmoption['imagedefault'];
  }
  if (!empty($pic)) {
    if (!isset($width)) $width = $nmoption['imagewidth'];
    if (!isset($height)) $height = $nmoption['imageheight'];
    if (!isset($crop)) $crop = $nmoption['imagecrop'];
    $pos = strpos($pic, 'data/uploads/');
    if ($pos !== false || strpos($pic, '/data/thumbs/') !== false || !strpos($pic, '://')) {
      if ($pos !== false) $pic = substr($pic, $pos+13);
      $w = $width ? '&w='.$width : '';
      $h = $height ? '&h='.$height : '';
      $c = $crop ? '&c=1' : '';
      $url = $SITEURL.'plugins/news_manager/browser/pic.php?p='.$pic.$w.$h.$c;
    } else {
      if ($nmoption['imageexternal'])
        $url = $pic;
    }
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
 * @param $url if not FALSE, URL to add "read more" link
 * @param $forcereadmore always add "read more" link, even if not truncated
 * @return a truncated version of the post content
 */
function nm_create_excerpt($content, $url=false, $forcereadmore=false) {
  global $NMEXCERPTLENGTH;
  $len = intval($NMEXCERPTLENGTH);
  if ($len == 0) {
    return '';
  } else {
    $ellipsis = i18n_r('news_manager/ELLIPSIS');
    $break = nm_get_option('breakwords');
    if ($url) {
      $readmorehtml = '<span class="nm_readmore"><a href="'.$url.'">'.i18n_r('news_manager/READ_MORE').'</a></span>';
      if ($forcereadmore)
        $content = nm_make_excerpt($content, $len, $ellipsis, $break).' '.$readmorehtml;
      else
        $content = nm_make_excerpt($content, $len, $ellipsis.$readmorehtml, $break);
    } else {
      $content = nm_make_excerpt($content, $len, $ellipsis, $break);
    }
    return '<p>'.$content.'</p>';
  }
}


/*******************************************************
 * @function nm_make_excerpt
 * @param $content source string (html/text)
 * @param $len maximum excerpt length
 * @param $ellipsis optional string to be appended at the end (e.g. '...')
 * @param $break allow cutting off last word
 * @return excerpt without html tags and usual GS placeholders
 * @since 3.0
 */
function nm_make_excerpt($content, $len=200, $ellipsis='', $break=false) {
  $content = preg_replace('/\(%.*?%\)/', '', $content); // remove (% ... %)
  $content = preg_replace('/\{%.*?%\}/', '', $content); // remove {% ... %}
  $content = strip_tags($content);
  $content = preg_replace('/\s+/u', ' ', str_replace('&nbsp;', ' ', $content)); // remove whitespace
  if (function_exists('mb_strlen')) {
    if (mb_strlen($content, 'UTF-8') > $len) {
      if ($break)
        $content = mb_substr($content, 0, $len, 'UTF-8');
      else
        $content = mb_substr($content, 0, mb_strrpos(mb_substr($content, 0, $len+1, 'UTF-8'), ' ', 'UTF-8'), 'UTF-8');
      $content .= $ellipsis;
    }
  } else {
    if (strlen($content) > $len) {
      if ($break)
        $content = substr($content, 0, $len);
      else
        $content = substr($content, 0, strrpos(substr($content, 0, $len+1), ' '));
      $content .= $ellipsis;
    }
  }
  return $content;
}

/*******************************************************
 * @function nm_i18n_merge
 * @action update the $i18n language array (frontend)
 */
function nm_i18n_merge() {
  global $NMLANG;
  if (isset($NMLANG) && $NMLANG != '') {
    if (dirname(realpath(NMLANGPATH.$NMLANG.'.php')) != realpath(NMLANGPATH)) die(''); // path traversal
    include(NMLANGPATH.$NMLANG.'.php');
    global $nm_i18n;
    if ($nm_i18n) {
      $nm_i18n = array_merge($i18n, $nm_i18n); // merge custom array
    } else {
      $nm_i18n = $i18n;
    }
    global $i18n;
    foreach ($nm_i18n as $code=>$text)
      $i18n['news_manager/' . $code] = $text;
  }
}


/*******************************************************
 * @function nm_sitemap_include
 * @action add posts to sitemap.xml, for GetSimple 3.0 only
 */
function nm_sitemap_include() {
  global $NMPAGEURL, $page, $xml;
  if (strval($page['url']) == $NMPAGEURL) {
    $posts = nm_get_posts();
    foreach ($posts as $post) {
      $url = nm_get_url('post').$post->slug;
      $file = NMPOSTPATH.$post->slug.'.xml';
      $date = makeIso8601TimeStamp(date('Y-m-d H:i:s', filemtime($file)));
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
  if (isset($_GET['id']) && $_GET['id'] == 'news_manager' && (isset($_GET['edit']) || isset($_GET['settings']))) {
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
      $msg .= ' <a href="load.php?id=news_manager&amp;restore='.$backup.'">'.i18n_r('UNDO').'</a>';
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


/*******************************************************
 * @function nm_lowercase_tags
 * @param $str a string containing post tags
 * @action convert string to lowercase if "lowercasetags" enabled
 * @since 3.0
 */
function nm_lowercase_tags($str) {
  if (defined('NMLOWERCASETAGS') && NMLOWERCASETAGS)
    return lowercase($str);
  else
    return $str;
}

/*******************************************************
 * @function nm_generate_sitemap
 * @action trigger Sitemap update only if GetSimple 3.3+
 * @since 2.5
 */
function nm_generate_sitemap() {
  if (GSVERSION >= '3.3' && (!defined('NMNOSITEMAP') || !NMNOSITEMAP))
    generate_sitemap();
}

/*******************************************************
 * @function nm_update_sitemap_xml
 * @action add posts to sitemap.xml, GetSimple 3.3+
 * @param xmlobj
 * @since 2.5
 */
function nm_update_sitemap_xml($xml) {
  if (!defined('NMNOSITEMAP') || !NMNOSITEMAP) {
    $posts = nm_get_posts();
    foreach ($posts as $post) {
      $url = nm_get_url('post').$post->slug;
      $file = NMPOSTPATH.$post->slug.'.xml';
      $date = makeIso8601TimeStamp(date('Y-m-d H:i:s', strtotime($post->date)));
      $item = $xml->addChild('url');
      $item->addChild('loc', $url);
      $item->addChild('lastmod', $date);
      $item->addChild('changefreq', 'monthly');
      $item->addChild('priority', '0.5');
    }
  }
  return $xml;
}

/*******************************************************
 * @function nm_update_extend_cache
 * @action hack to replace Extend API cache file
 * @uses $site_link_back_url (GetSimple's configuration.php)
 * @since 3.0
 */
function nm_update_extend_cache() {
  if (!is_frontend() && get_filename_id() == 'plugins') {
    include(GSADMININCPATH.'configuration.php');
    $url = $site_link_back_url.'api/extend/?id=541';
    $tempfile = GSCACHEPATH.md5($url).'.txt';
    $cachefile = GSCACHEPATH.md5($site_link_back_url.'api/extend/?file=news_manager.php').'.txt';
    get_api_details('custom', $url);
    if (file_exists($cachefile)) unlink($cachefile);
    @copy($tempfile, $cachefile);
  }
}

# since 3.0
# for templateFile custom setting (may be renamed later)
function nm_switch_template_file($tempfile) {
  global $template_file, $TEMPLATE;
  $tempfile = nm_get_option('templatefile');
  # no path traversal and template exists
  if (strpos(realpath(GSTHEMESPATH.$TEMPLATE."/".$tempfile), realpath(GSTHEMESPATH.$TEMPLATE."/")) === 0 && file_exists(GSTHEMESPATH.$TEMPLATE."/".$tempfile))
    $template_file = $tempfile;
}

?>