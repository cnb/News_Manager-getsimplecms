<?php if (!defined('IN_GS')) {die('you cannot load this page directly.');}

/**
 * News Manager front-end functions.
 */


/*******************************************************
 * @function nm_show_page
 * @param $index - page index (pagination)
 * @param $filter - if true, apply content filter
 * @action show posts on news page
 */
function nm_show_page($index=NMFIRSTPAGE, $filter=true) {
  global $NMPOSTSPERPAGE, $nmoption;
  $p1 = intval(NMFIRSTPAGE);
  $index = intval($index);
  $posts = nm_get_posts();
  $pages = array_chunk($posts, intval($NMPOSTSPERPAGE), true);
  if ($index >= $p1 && $index-$p1 < sizeof($pages))
    $posts = $pages[$index-$p1];
  else
    $posts = array();
  if (!empty($posts)) {
    $showexcerpt = nm_get_option('excerpt');
    if ($filter) ob_start();
    foreach ($posts as $post)
      nm_show_post($post->slug, $showexcerpt, false);
    if (sizeof($pages) > 1 && nm_get_option('shownav',true))
      nm_show_navigation($index, sizeof($pages));
    if ($filter) echo nm_ob_get_content(true);
  } else {
    echo '<p>' . i18n_r('news_manager/NO_POSTS') . '</p>';
  }
}


/*******************************************************
 * @function nm_show_archive
 * @param $id - unique archive id
 * @param $filter - if true, apply content filter
 * @action show posts by archive
 * @return true if posts shown
 */
function nm_show_archive($archive, $filter=true) {
  global $NMSETTING;
  $archives = nm_get_archives($NMSETTING['archivesby']);
  if (array_key_exists($archive, $archives)) {
    $showexcerpt = nm_get_option('excerpt');
    $posts = $archives[$archive];
    if ($filter) ob_start();
    foreach ($posts as $slug)
      nm_show_post($slug, $showexcerpt, false);
    if ($filter) echo nm_ob_get_content(true);
    return true;
  } else {
    return false;
  }
}


/*******************************************************
 * @function nm_show_tag
 * @param $tag - unique tag id
 * @param $filter - if true, apply content filter
 * @action show posts by tag
 * @return true if posts shown
 */
function nm_show_tag($tag, $filter=true) {
  $tag = nm_lowercase_tags($tag);
  $tags = nm_get_tags();
  if (array_key_exists($tag, $tags)) {
    $showexcerpt = nm_get_option('excerpt');
    $posts = $tags[$tag];
    if ($filter) ob_start();
    foreach ($posts as $slug)
      nm_show_post($slug, $showexcerpt, false);
    if ($filter) echo nm_ob_get_content(true);
    return true;
  } else {
    return false;
  }
}

/*******************************************************
 * @function nm_show_tag_page
 * @param $tag - unique tag id
 * @param $index - page index (pagination)
 * @param $filter - if true, apply content filter
 * @action show posts by tag with pagination
 * @return true if posts shown
 * @since 3.0
 */
function nm_show_tag_page($tag, $index=NMFIRSTPAGE, $filter=true) {
  global $NMPOSTSPERPAGE;
  $tag = nm_lowercase_tags($tag);
  $tags = nm_get_tags();
  if (array_key_exists($tag, $tags)) {
    $showexcerpt = nm_get_option('excerpt');
    $posts = $tags[$tag];
    $p1 = intval(NMFIRSTPAGE);
    $index = intval($index);
    $pages = array_chunk($posts, intval($NMPOSTSPERPAGE), true);
    if ($index >= $p1 && $index-$p1 < sizeof($pages)) {
      $posts = $pages[$index-$p1];
      if ($filter) ob_start();
      foreach ($posts as $slug)
        nm_show_post($slug, $showexcerpt, false);
      if (sizeof($pages) > 1 && nm_get_option('shownav',true))
        nm_show_navigation($index, sizeof($pages), $tag);
      if ($filter) echo nm_ob_get_content(true);
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
      nm_show_post($post->slug, $showexcerpt, false);
  } else {
    echo '<p>' . i18n_r('news_manager/NOT_FOUND') . '</p>',PHP_EOL;
  }
}

/*******************************************************
 * @function nm_reset_options
 * @param $pagetype news page type, can be 'single', 'main', 'archive', 'tag', 'search' or empty
 * @action set default or specific layout values
 * @since 3.0
 */
function nm_reset_options($pagetype='') {
  global $nmoption, $NMSETTING, $NMSHOWEXCERPT;
  $nmoption = array();
  
  # pre 3.0 default settings (plus readmore in common.php)
  if (defined('NM2COMPAT') && NM2COMPAT) {
    $nmoption['breakwords'] = true;
    $nmoption['titletag'] = false;
    $nmoption['navoldnew'] = true;
    if (!defined('NMFIRSTPAGE')) define('NMFIRSTPAGE',0);
  }

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
 * @param $filter - if true, apply content filter
 * @param $single post page?
 * @action show the requested post on front-end news page, as defined by $nmoption values
 * @return true if post exists
 */
function nm_show_post($slug, $showexcerpt=false, $filter=true, $single=false) {
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

    if ($filter) ob_start();

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
    
    if ($filter) echo nm_ob_get_content(true);
    
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
 * @param $tag - tag to filter by (optional)
 * @action provides links to navigate between subpages in main news or tag page
 */
function nm_show_navigation($index, $total, $tag=null) {
  $p1 = intval(NMFIRSTPAGE);
  if (!$tag) {
    $first = nm_get_url();
    $page = nm_get_url('page');
  } else {
    $first = nm_get_url('tag').rawurlencode($tag);
    if (nm_get_option('tagpagination') == 'f')
      $page = $first.'/'.NMPARAMPAGE.'/';
    else
      $page = $first.'&amp;'.NMPARAMPAGE.'=';
  }
  echo '<div class="nm_page_nav">';
  if (!nm_get_option('navoldnew',false)) {
  
    $prevnext = nm_get_option('navprevnext', '1');
    if (strtolower($prevnext[0]) == 'a') { // navPrevNext a[lways]
      $noPrev = '<span class="previous disabled">'.i18n_r('news_manager/PREV_TEXT').'</span>';
      $noNext = ' <span class="next disabled">'.i18n_r('news_manager/NEXT_TEXT').'</span>';
    } else {
      $noPrev = '';
      $noNext = '';
    }
      
    if ($prevnext && $index > $p1) {
      echo '<span class="previous"><a href="';
      echo $index > $p1+1 ? $page.($index-1) : $first;
      echo '" title="',i18n_r('news_manager/PREV_TITLE'),'">',i18n_r('news_manager/PREV_TEXT'),'</a></span>';
    } else {
      echo $noPrev;
    }
    
    if (nm_get_option('navnumber',true)) {
      for ($i = 0; $i < $total; $i++) {
        if ($i+$p1 == $index) {
          echo ' <span class="current">',$i+1,'</span>';
        } else {
          echo ' <span><a href="';
          echo $i == 0 ? $first : $page.($i+$p1);
          echo '">',$i+1,'</a></span>';
        }
      }
    }
    
    if ($prevnext && $index < $total-1+$p1) {
      echo ' <span class="next"><a href="',$page.($index+1);
      echo '" title="',i18n_r('news_manager/NEXT_TITLE'),'">',i18n_r('news_manager/NEXT_TEXT'),'</a></span>';
    } else {
      echo $noNext;
    }
      
  } else {
  
  # Older/Newer navigation
    if ($index < $total-1+$p1) {
    ?>
    <div class="left">
      <a href="<?php echo $page.($index+1); ?>">
        <?php i18n('news_manager/OLDER_POSTS'); ?>
      </a>
    </div>
    <?php
    }
    if ($index > $p1) {
    ?>
    <div class="right">
      <a href="<?php echo ($index > $p1+1) ? $page.($index-1) : $first ?>">
        <?php i18n('news_manager/NEWER_POSTS'); ?>
      </a>
    </div>
    <?php
    }
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

/*******************************************************
 * @function nm_post_slug
 * @param $echo Display (true) or return (false)
 * @action Display or return the post id (slug)
 * @return slug or false if not on single post page
 * @since 3.0
 */
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

/*******************************************************
 * @function nm_post_url
 * @param $echo Display (true) or return (false)
 * @action Display or return the post URL
 * @return URL or false if not on single post page
 * @since 3.0
 */
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

/*******************************************************
 * @function nm_post_excerpt
 * @param $len Length or null for default length (settings)
 * @param $ellipsis Custom string for the ellipsis or null for default
 * @param $echo Display (true) or return (false)
 * @action Display or return a post excerpt
 * @return excerpt or empty string
 * @since 3.0
 */
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

/*******************************************************
 * @function nm_post_image_url
 * @param $width or null for default width (settings)
 * @param $height or null for default height (settings)
 * @param $crop 0, 1, false or true, or null for default crop option (settings)
 * @param $default URL or filename of image if post has no image
 * @param $echo Display (true) or return (false)
 * @action Display or return post image URL
 * @return image URL or empty string
 * @since 3.0
 */
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

/***
frontend functions, since 3.0
@todo: descriptions
 ***/

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

function nm_is_tag($tag=null) {
  global $nmpagetype;
  if (in_array('tag', $nmpagetype)) {
    if (!$tag)
      return true;
    else
      return (isset($_GET[NMPARAMTAG]) && $tag == rawurldecode($_GET[NMPARAMTAG]));
  }
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

// images

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


// patch for <title> tag
function nm_update_page_title() {
  if (!nm_is_single() || !nm_get_option('titletag',true) || function_exists('nmt_set_gstitle')) {
    return;
  } else {
    global $title, $nmpagetitle;
    $nmpagetitle = $title;
    $title = nm_post_title('',' - '.$title,false);
  }
}

// restore original title - <title> tag patch
function nm_restore_page_title() {
  if (!nm_is_single() || !nm_get_option('titletag',true) || function_exists('nmt_set_gstitle')) {
    return;
  } else {
    global $title, $nmpagetitle;
    $title = $nmpagetitle;
  }
}

// get output buffer, optionally apply content filter
function nm_ob_get_content($filter=true) {
	$output = ob_get_contents();
	ob_end_clean();
	if ($filter) {
		return exec_filter('content', $output);
	} else {
		return $output;
	}
}

?>