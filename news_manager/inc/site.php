<?php if (!defined('IN_GS')) {die('you cannot load this page directly.');}

/**
 * News Manager front-end functions.
 */


/*******************************************************
 * @function nm_show_page
 * @param $index - page index (pagination)
 * @action show posts on news page
 */
function nm_show_page($index=0) {
  global $NMPOSTSPERPAGE, $nmoption;
  $index = intval($index);
  $posts = nm_get_posts();
  $pages = array_chunk($posts, intval($NMPOSTSPERPAGE), true);
  if ($index >= 0 && $index < sizeof($pages))
    $posts = $pages[$index];
  else
    $posts = array();
  if (!empty($posts)) {
    $showexcerpt = nm_get_option('excerpt');
    foreach ($posts as $post)
      nm_show_post($post->slug, $showexcerpt);
    if (sizeof($pages) > 1)
      nm_show_navigation($index, sizeof($pages));
  } else {
    echo '<p>' . i18n_r('news_manager/NO_POSTS') . '</p>';
  }
}


/*******************************************************
 * @function nm_show_archive
 * @param $id - unique archive id
 * @action show posts by archive
 * @return true if posts shown
 */
function nm_show_archive($archive) {
  global $NMSETTING;
  $archives = nm_get_archives($NMSETTING['archivesby']);
  if (array_key_exists($archive, $archives)) {
    $showexcerpt = nm_get_option('excerpt');
    $posts = $archives[$archive];
    foreach ($posts as $slug)
      nm_show_post($slug, $showexcerpt);
    return true;
  } else {
    return false;
  }
}


/*******************************************************
 * @function nm_show_tag
 * @param $id - unique tag id
 * @action show posts by tag
 * @return true if posts shown
 */
function nm_show_tag($tag) {
  $tag = nm_lowercase_tags($tag);
  $tags = nm_get_tags();
  if (array_key_exists($tag, $tags)) {
    $showexcerpt = nm_get_option('excerpt');
    $posts = $tags[$tag];
    foreach ($posts as $slug)
      nm_show_post($slug, $showexcerpt);
    return true;
  } else {
    return false;
  }
}

/*******************************************************
 * @function nm_show_tag_page
 * @param $id - unique tag id
 * @param $index - page index (pagination)
 * @action show posts by tag with pagination
 * @return true if posts shown
 * @since 2.5
 */
function nm_show_tag_page($tag, $index=0) {
  global $NMPOSTSPERPAGE;
  $tag = nm_lowercase_tags($tag);
  $tags = nm_get_tags();
  if (array_key_exists($tag, $tags)) {
    $showexcerpt = nm_get_option('excerpt');
    $posts = $tags[$tag];
    $pages = array_chunk($posts, intval($NMPOSTSPERPAGE), true);
    if ($index >= 0 && $index < sizeof($pages)) {
      $posts = $pages[$index];
      foreach ($posts as $slug)
        nm_show_post($slug, $showexcerpt);
      if (sizeof($pages) > 1)
        nm_show_tag_navigation($index, sizeof($pages), $tag);
      return true;
    }
  }
  return false;
}


/*******************************************************
 * @function nm_show_search_results()
 * @action search posts by keyword(s)
 */
function nm_show_search_results() {
  $keywords = @explode(' ', $_POST['keywords']);
  $posts = nm_get_posts();
  foreach ($keywords as $keyword) {
    $match = array();
    foreach ($posts as $post) {
      $data = getXML(NMPOSTPATH.$post->slug.'.xml');
      $content = $data->title . $data->content;
      if (stripos($content, $keyword) !== false)
        $match[] = $post;
    }
    $posts = $match;
  }
  if (!empty($posts)) {
    $showexcerpt = nm_get_option('excerpt');
    echo '<p>' . i18n_r('news_manager/FOUND') . '</p>',PHP_EOL;
    foreach ($posts as $post)
      nm_show_post($post->slug, $showexcerpt);
  } else {
    echo '<p>' . i18n_r('news_manager/NOT_FOUND') . '</p>',PHP_EOL;
  }
}

/*******************************************************
 * @function nm_show_single
 * @param $slug post slug
 * @action show single post on news page
 * @return true if post exists
 * @since 2.5
 */
function nm_show_single($slug) {
  return nm_show_post($slug, false, true);
}


/*******************************************************
 * @function nm_reset_options
 * @param $pagetype news page type, can be 'single', 'main', 'archive', 'tag', 'search' or empty
 * @action set default or specific layout values
 * @since 2.5
 */
function nm_reset_options($pagetype='') {
  global $nmoption, $NMSETTING, $NMSHOWEXCERPT;
  $nmoption = array();

  # full/excerpt, readmore
  if ($NMSHOWEXCERPT == 'Y' || in_array($pagetype, array('archive','search','tag'))) {
    $nmoption['excerpt'] = true;
    if ($NMSETTING['readmore'] == 'R')
      $nmoption['readmore'] = true;
    elseif ($NMSETTING['readmore'] == 'F')
      $nmoption['readmore'] = 'a';
    else
      $nmoption['readmore'] = false;
  } else {
    $nmoption['excerpt'] = false; // full post
  }

  # title link
  $nmoption['titlelink'] = ($NMSETTING['titlelink']=='Y' || ($NMSETTING['titlelink']=='P' && $pagetype != 'single'));

  # go back link
  if ($pagetype == 'single') {
    if ($NMSETTING['gobacklink'] == 'N')
      $nmoption['gobacklink'] = false;
    elseif ($NMSETTING['gobacklink'] == 'M')
      $nmoption['gobacklink'] = 'main';
    else
      $nmoption['gobacklink'] = true;
  }

  # tag separator
  $nmoption['tagseparator'] = ' ';

  # author
  $nmoption['showauthor'] = false;
  $nmoption['defaultauthor'] = '';

  # images
  if ( $NMSETTING['images'] == 'N'
    || ($pagetype == 'single' && $NMSETTING['images'] == 'P')
    || ($pagetype != 'main' && $NMSETTING['images'] == 'M') ) {
    $nmoption['showimages'] = false;
  } else {
    $nmoption['showimages'] = true;
  }
  $nmoption['imagewidth'] = intval($NMSETTING['imagewidth']);
  $nmoption['imageheight'] = intval($NMSETTING['imageheight']);
  $nmoption['imagecrop'] = ($NMSETTING['imagecrop'] == '1');
  $nmoption['imagealt'] = ($NMSETTING['imagealt'] == '1');
  $nmoption['imagelink'] = ($pagetype != 'single' && $NMSETTING['imagelink'] == '1');
  $nmoption['imagetitle'] = false;
  $nmoption['imageexternal'] = false;
  $nmoption['imagedefault'] = '';
  $nmoption['imagesizeattr'] = false;

  # custom settings
  if ($NMSETTING['enablecustomsettings'] == '1') {
    # extract settings
    foreach(preg_split('~\R~', $NMSETTING['customsettings']) as $line) {
      $line = trim($line);
      if ($line && strpos($line,'#') !== 0 && strpos($line,'//') !== 0) { // exclude empty and commented lines
        $arr = explode(' ',preg_replace("/[[:blank:]]+/"," ",$line));
        if (count($arr) > 1) {
          if (in_array($arr[0], array('main','single','archive','tag','search')))
            $customsettings[$arr[0]][$arr[1]] = implode(' ',array_slice($arr,2));
          else
            $customsettings['default'][$arr[0]] = implode(' ',array_slice($arr,1));
        }
      }
    }
    # process settings and strings
    foreach(array('default', $pagetype) as $type) {
      if (isset($customsettings[$type])) {
        foreach($customsettings[$type] as $key=>$value) {
          if (substr($value,0,1) == '"' || substr($value,0,1) == "'") $value = substr($value,1,strlen($value)-2);
          if (strtoupper($key) == $key) {
            # language string
            nm_set_text($key, $value);
          } else {
            # setting
            $nmoption[strtolower($key)] = $value;
          }
        }
      }
    }
  }

  # html tags
  $nmoption['markuppost'] = isset($nmoption['markuppost']) ? str_replace(array('<','>'),'',$nmoption['markuppost']) : 'div';
  $nmoption['markuptitle'] = isset($nmoption['markuptitle']) ? str_replace(array('<','>'),'',$nmoption['markuptitle']) : 'h3';

  # fields
  if (isset($nmoption['showfields'])) {
    $nmoption['fields'] = explode(' ',preg_replace('/  +/', ' ',trim(str_replace(',',' ',$nmoption['showfields']))));
  } else {
    $nmoption['fields'] = array('title','date','author','image','content','tags');
  }

  # imagesize shorthand
  if (isset($nmoption['imagesize'])) {
    if ($nmoption['imagesize'] == 0 || $nmoption['imagesize'] == 'full') {
      $nmoption['imagewidth'] = 0;
      $nmoption['imageheight'] = 0;
      $nmoption['imagecrop'] = 0;
    } else {
      $imageparams = explode(' ',preg_replace('/  +/', ' ',trim(str_replace(',',' ',$nmoption['imagesize']))));
      $nmoption['imagewidth'] = isset($imageparams[0]) ? $imageparams[0] : 0;
      $nmoption['imageheight'] = isset($imageparams[1]) ? $imageparams[1] : 0;
      $nmoption['imagecrop'] = isset($imageparams[2]) ? $imageparams[2] : 0;
    }
  }

  # custom excerpt length
  if (isset($nmoption['excerptlength'])) {
    global $NMEXCERPTLENGTH;
    $NMEXCERPTLENGTH = $nmoption['excerptlength']; // workaround(*)
  }

  # more
  if (!isset($nmoption['more'])) $nmoption['more'] = false;

  # readmore
  if (!isset($nmoption['readmore']))
    $nmoption['readmore'] = false;
  else // custom setting - anything beginning with 'a' (all, Always, ...)
    if (strtolower($nmoption['readmore'][0]) == 'a')
      $nmoption['readmore'] = 'a';

  # tag pagination
  if (!isset($nmoption['tagpagination'])) {
    $nmoption['tagpagination'] = false;
  } else { // anything beginning with 'd' (Default, Dynamic...) or 'f' (Fancy, Folder...)
    $nmoption['tagpagination'] = strtolower($nmoption['tagpagination'][0]);
    if (!in_array($nmoption['tagpagination'], array('d','f')))
      $nmoption['tagpagination'] = false;
  }
}


/*******************************************************
 * @function nm_show_post
 * @param $slug post slug
 * @param $showexcerpt - if TRUE, print only a short summary
 * @param $single post page?
 * @action show the requested post on front-end news page, as defined by $nmoption values
 * @return true if post exists
 */
function nm_show_post($slug, $showexcerpt=false, $single=false) {
  global $nmoption, $nmdata;
  $file = NMPOSTPATH.$slug.'.xml';
  if (dirname(realpath($file)) == realpath(NMPOSTPATH)) // no path traversal
    $post = @getXML($file);
  if (!empty($post) && $post->private != 'Y') {
    $url     = nm_get_url('post') . $slug;
    $title   = stripslashes($post->title);
    $date    = nm_get_date(i18n_r('news_manager/DATE_FORMAT'), strtotime($post->date));
    $content = strip_decode($post->content);
    $image   = stripslashes($post->image);
    $tags = !empty($post->tags) ? explode(',', nm_lowercase_tags(strip_decode($post->tags))) : array();

    # save post data?
    $nmdata = ($single) ? compact('slug', 'url', 'title', 'content', 'image', 'tags') : array();

    echo '  <',$nmoption['markuppost'],' class="nm_post';
    if ($single) echo ' nm_post_single';
    echo '">',PHP_EOL;

    foreach ($nmoption['fields'] as $field) {
      switch($field) {

        case 'title':
          echo '    <',$nmoption['markuptitle'],' class="nm_post_title">';
          if ($nmoption['titlelink'])
            echo '<a href="',$url,'">',$title,'</a>';
          else
            echo $title;
          echo '</',$nmoption['markuptitle'],'>',PHP_EOL;
          break;

        case 'date':
          echo '    <p class="nm_post_date">',i18n_r('news_manager/PUBLISHED'),' ',$date,'</p>',PHP_EOL;
          break;

        case 'content':
          echo '    <div class="nm_post_content">';
          if ($single) {
            echo $content;
          } else {
            $slice = '';
            $readmore = $nmoption['readmore'];
            if ($nmoption['more']) {
              $morepos = strpos($content, '<hr');
              if ($morepos !== false) {
                $slice = substr($content, 0, $morepos);
                if ($readmore)
                  $slice .= '      <p class="nm_readmore"><a href="'.$url.'">'.i18n_r('news_manager/READ_MORE').'</a></p>'.PHP_EOL;
              }
            }
            if ($slice) {
              echo $slice;
            } else {
              if ($showexcerpt) {
                if (!$readmore)
                  echo nm_create_excerpt($content);
                elseif ($readmore === 'a')
                  echo nm_create_excerpt($content, $url, true);
                else
                  echo nm_create_excerpt($content, $url);
              } else {
                echo $content;
                if ($readmore === 'a')
                  echo '      <p class="nm_readmore"><a href="',$url,'">',i18n_r('news_manager/READ_MORE'),'</a></p>',PHP_EOL;
              }
            }
          }
          echo '    </div>',PHP_EOL;
          break;

        case 'tags':
          if ($tags) {
            echo '    <p class="nm_post_meta"><b>' . i18n_r('news_manager/TAGS') . ':</b> ';
            $sep = '';
            foreach ($tags as $tag)
              if (substr($tag, 0, 1) != '_') {
                echo $sep,'<a href="',nm_get_url('tag').rawurlencode($tag),'">',$tag,'</a>';
                if ($sep == '') $sep = $nmoption['tagseparator'];
              }
            echo '</p>',PHP_EOL;
          }
          break;

        case 'image':
          $imageurl = $nmoption['showimages'] ? nm_get_image_url($image) : false;
          if ($imageurl) {
            $str = '';
            if (isset($nmoption['imageclass']))
              $str .= ' class="'.$nmoption['imageclass'].'"';
            if ($nmoption['imagesizeattr'] && $nmoption['imagewidth'] && $nmoption['imageheight'])
              $str .= ' width="'.$nmoption['imagewidth'].'" height="'.$nmoption['imageheight'].'"';
            $str .= $nmoption['imagealt']   ? ' alt="'.htmlspecialchars($title, ENT_COMPAT).'"' : ' alt=""';
            $str .= $nmoption['imagetitle'] ? ' title="'.htmlspecialchars($title, ENT_COMPAT).'"' : '';
            $str = '<img src="'.htmlspecialchars($imageurl).'"'.$str.' />';
            if ($nmoption['imagelink'])
              $str = '<a href="'.$url.'">'.$str.'</a>';
            echo '    <div class="nm_post_image">',$str,'</div>',PHP_EOL;
          }
          break;

        case 'author':
          if ($nmoption['showauthor']) {
            $author = stripslashes($post->author);
            if (empty($author) && $nmoption['defaultauthor'])
              $author = $nmoption['defaultauthor'];
            if (!empty($author))
                echo '    <p class="nm_post_author">'.i18n_r('news_manager/AUTHOR').' <em>'.$author.'</em></p>'.PHP_EOL;
          }
          break;
      }
    }

    if (isset($nmoption['componentbottompost'])) {
      get_component($nmoption['componentbottompost']);
      echo PHP_EOL;
    }
    if ($single) {
      # show "go back" link?
      if ($nmoption['gobacklink']) {
        $goback = ($nmoption['gobacklink'] === 'main') ? nm_get_url() : 'javascript:history.back()';
        echo '    <p class="nm_post_back"><a href="'.$goback.'">';
        i18n('news_manager/GO_BACK');
        echo '</a></p>',PHP_EOL;
      }
    }

    echo '  </',$nmoption['markuppost'],'>',PHP_EOL;

    if (isset($nmoption['componentafterpost'])) {
      get_component($nmoption['componentafterpost']);
      echo PHP_EOL;
    }
    return true;
  } else {
    echo '<p>' . i18n_r('news_manager/NOT_EXIST') . '</p>',PHP_EOL;
    return false;
  }
}


/*******************************************************
 * @function nm_show_navigation
 * @param $index - current page index
 * @param $total - total number of subpages
 * @action provides links to navigate between subpages
 */
function nm_show_navigation($index, $total) {
  $url = nm_get_url('page');
  echo '<div class="nm_page_nav">';
  if ($index < $total - 1) {
    ?>
    <div class="left">
      <a href="<?php echo $url.($index+1); ?>">
        <?php i18n('news_manager/OLDER_POSTS'); ?>
      </a>
    </div>
    <?php
  }
  if ($index > 0) {
    ?>
    <div class="right">
      <a href="<?php echo ($index > 1) ? $url.($index-1) : nm_get_url(); ?>">
        <?php i18n('news_manager/NEWER_POSTS'); ?>
      </a>
    </div>
    <?php
  }
  echo '</div>';
}

/*******************************************************
 * @function nm_show_tag_navigation
 * @param $index - current page index
 * @param $total - total number of subpages
 * @param $tag - tag to filter by
 * @action like nm_show_navigation but filtered by tag
 */
function nm_show_tag_navigation($index, $total, $tag) {
  $url = nm_get_url('tag').rawurlencode($tag);
  if (nm_get_option('tagpagination') == 'f')
    $page = '/'.NMPARAMPAGE.'/';
  else
    $page = '&amp;'.NMPARAMPAGE.'=';
  echo '<div class="nm_page_nav">';
  if ($index < $total - 1) {
    ?>
    <div class="left">
      <a href="<?php echo $url.$page.($index+1); ?>">
        <?php i18n('news_manager/OLDER_POSTS'); ?>
      </a>
    </div>
    <?php
  }
  if ($index > 0) {
    ?>
    <div class="right">
      <a href="<?php echo ($index > 1) ? $url.$page.($index-1) : $url; ?>">
        <?php i18n('news_manager/NEWER_POSTS'); ?>
      </a>
    </div>
    <?php
  }
  echo '</div>';
}

/*******************************************************
 * @function nm_post_title
 * @param $before Text to place before the title. Defaults to ''
 * @param $after Text to place after the title. Defaults to ''
 * @param $echo Display (true) or return (false)
 * @action Display or return the post title. Returns false if not on single post page
 * @since 2.3
 */
function nm_post_title($before='', $after='', $echo=true) {
  global $nmdata;
  if (isset($nmdata['title']) && $nmdata['title']) {
    $title = $before.$nmdata['title'].$after;
    if ($echo) echo $title;
    return $title;
  } else {
    return false;
  }
}


/*** frontend functions, since 2.5 ***/

// conditionals

function nm_is_site() {
  global $nmpagetype;
  return in_array('site', $nmpagetype);
}

function nm_is_single() {
  global $nmpagetype;
  return in_array('single', $nmpagetype);
}

function nm_is_main() {
  global $nmpagetype;
  return in_array('main', $nmpagetype);
}

function nm_is_tag() {
  global $nmpagetype;
  return in_array('tag', $nmpagetype);
}

function nm_is_archive() {
  global $nmpagetype;
  return in_array('archive', $nmpagetype);
}

function nm_is_search() {
  global $nmpagetype;
  return in_array('search', $nmpagetype);
}

function nm_is_home() {
  global $nmpagetype;
  return in_array('home', $nmpagetype);
}

function nm_post_has_image() {
  global $nmdata;
  return (isset($nmdata['image']) && $nmdata['image']);
}

// check if single post has any tag or a certain tag
function nm_post_has_tag($tag=null) {
  global $nmdata;
  if ($nmdata) {
    if (!isset($tag) && $nmdata['tags'])
      return true;
    elseif (in_array($tag, $nmdata['tags']))
      return true;
  }
  return false;
}

// set general option
function nm_set_option($option, $value=true) {
  global $nmoption;
  if ($option) $nmoption[strtolower($option)] = $value;
}

// get option value, return $default if not defined
function nm_get_option($option, $default=false) {
  global $nmoption;
  if ($option) {
    $option = strtolower($option);
    if (isset($nmoption[$option]))
      return $nmoption[$option];
    else
      return $default;
  }
}

// template tags (single post view)

function nm_post_slug($echo=true) {
  global $nmdata;
  if (isset($nmdata['slug']) && $nmdata['slug']) {
    $slug = $nmdata['slug'];
    if ($echo) echo $slug;
    return $slug;
  } else {
    return false;
  }
}

function nm_post_url($echo=true) {
  global $nmdata;
  if (isset($nmdata['url']) && $nmdata['url']) {
    $url = $nmdata['url'];
    if ($echo) echo $url;
    return $url;
  } else {
    return false;
  }
}

function nm_post_excerpt($len=null, $ellipsis=null, $echo=true) {
  global $nmdata, $NMEXCERPTLENGTH, $nmoption;
  if (isset($nmdata['content']) && $nmdata['content']) {
    if (!$len) $len = isset($nmoption['excerptlength']) ? $nmoption['excerptlength'] : $NMEXCERPTLENGTH; // workaround(*)
    if (!$ellipsis && $ellipsis !== '') $ellipsis = i18n_r('news_manager/ELLIPSIS');
    $excerpt = nm_make_excerpt($nmdata['content'], $len, $ellipsis);
    if ($echo) echo $excerpt;
    return $excerpt;
  } else {
    return '';
  }
}

function nm_post_image_url($width=null, $height=null, $crop=null, $default=null, $echo=true) {
  global $nmdata;
  if (isset($nmdata['image']) && $nmdata['image']) {
    $url = htmlspecialchars(nm_get_image_url($nmdata['image'], $width, $height, $crop, $default));
    if ($echo) echo $url;
    return $url;
  } else {
    return '';
  }
}

// images

function nm_enable_images() {
  global $nmoption;
  $nmoption['showimages'] = true;
}

function nm_disable_images() {
  global $nmoption;
  $nmoption['showimages'] = false;
}

function nm_set_image_option($option, $value=true) {
  global $nmoption;
  if ($option)
    $nmoption['image'.$option] = $value;
}

function nm_set_image_size($width=null, $height=null, $crop=false) {
  global $nmoption;
  $nmoption['imagewidth'] = $width;
  $nmoption['imageheight'] = $height;
  $nmoption['imagecrop'] = $crop;
}

// custom text/language strings

function nm_set_text($i18nkey=null, $i18nvalue=null) {
  global $i18n;
  if ($i18nkey && $i18nvalue)
    $i18n['news_manager/'.$i18nkey] = $i18nvalue;
}


?>