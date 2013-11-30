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
  $posts = nm_get_posts();
  $pages = array_chunk($posts, intval($NMPOSTSPERPAGE), true);
  if (is_numeric($index) && $index >= 0 && $index < sizeof($pages))
    $posts = $pages[$index];
  else
    $posts = array();
  nm_set_pagetype_options('main');
  $nmoption['ishome'] = ($index == 0);
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
 */
function nm_show_archive($archive) {
  global $NMSETTING;
  $archives = nm_get_archives($NMSETTING['archivesby']);
  if (array_key_exists($archive, $archives)) {
    nm_set_pagetype_options('archive');
    $showexcerpt = nm_get_option('excerpt');
    $posts = $archives[$archive];
    foreach ($posts as $slug)
      nm_show_post($slug, $showexcerpt);
   }
}


/*******************************************************
 * @function nm_show_tag
 * @param $id - unique tag id
 * @action show posts by tag
 */
function nm_show_tag($tag) {
  $tag = nm_lowercase_tags($tag);
  $tags = nm_get_tags();
  if (array_key_exists($tag, $tags)) {
    nm_set_pagetype_options('tag');
    $showexcerpt = nm_get_option('excerpt');
    $posts = $tags[$tag];
    foreach ($posts as $slug)
      nm_show_post($slug, $showexcerpt);
  }
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
  nm_set_pagetype_options('search');
  if (!empty($posts)) {
    $showexcerpt = nm_get_option('excerpt');
    echo '<p>' . i18n_r('news_manager/FOUND') . '</p>';
    foreach ($posts as $post)
      nm_show_post($post->slug, $showexcerpt);
  } else {
    echo '<p>' . i18n_r('news_manager/NOT_FOUND') . '</p>';
  }
}

/*******************************************************
 * @function nm_show_single
 * @param $slug post slug
 * @action show single post on news page
 */
function nm_show_single($slug) {
  nm_set_pagetype_options('single');
  nm_show_post($slug);
}


/*******************************************************
 * @function nm_set_pagetype_options
 * @param $pagetype news page type, can be 'single', 'main', 'archive', 'tag' or 'search'
 * @action set page type and default post layout values
 * @since 2.5
 */
function nm_set_pagetype_options($pagetype) {
  global $nmoption, $NMSETTING, $NMSHOWEXCERPT;
  $nmoption = array();
  
  # full/excerpt, readmore
  if ($NMSHOWEXCERPT == 'Y' || in_array($pagetype, array('archive','search','tag'))) {
    if ($NMSETTING['readmore'] == 'R')
      $nmoption['excerpt'] = 'readmore';
    elseif ($NMSETTING['readmore'] == 'F')
      $nmoption['excerpt'] = 'forcereadmore';
    else
      $nmoption['excerpt'] = true;
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
  
  # news page type
  $nmoption['pagetype'] = $pagetype;
  
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
            $customsettings['site'][$arr[0]] = implode(' ',array_slice($arr,1));
        }
      }
    }
    # process settings and strings
    foreach(array('site', $nmoption['pagetype']) as $type) {
      if (isset($customsettings[$type])) {
        foreach($customsettings[$type] as $key=>$value) {
          if (substr($value,0,1) == '"' || substr($value,0,1) == "'") $value = substr($value,1,strlen($value)-2);
          if (strtoupper($key) == $key) {
            # language string
            nm_set_text($key, $value);
          } else {
            # setting
            $nmoption[$key] = $value;
          }
        }
      }
    }
  }

  # html tags
  $nmoption['markuppost'] = isset($nmoption['markuppost']) ? str_replace(array('<','>'),'',$nmoption['markuppost']) : 'div';
  $nmoption['markuptitle'] = isset($nmoption['markuptitle']) ? str_replace(array('<','>'),'',$nmoption['markuptitle']) : 'h3';
  
}


/*******************************************************
 * @function nm_show_post
 * @param $slug post slug
 * @param $showexcerpt - if TRUE, print only a short summary (other options: 'readmore', 'forcereadmore')
 * @action show the requested post on front-end news page, as defined by $nmoption values
 */
function nm_show_post($slug, $showexcerpt=false) {
  global $nmoption;
  $file = NMPOSTPATH.$slug.'.xml';
  if (dirname(realpath($file)) == realpath(NMPOSTPATH)) // no path traversal
    $post = @getXML($file);
  if (!empty($post) && $post->private != 'Y') {
    $url     = nm_get_url('post') . $slug;
    $title   = stripslashes($post->title);
    $date    = nm_get_date(i18n_r('news_manager/DATE_FORMAT'), strtotime($post->date));
    $content = strip_decode($post->content);
    if ($showexcerpt) {
      if ($showexcerpt === 'readmore')
        $content = nm_create_excerpt($content, $url);
      elseif ($showexcerpt === 'forcereadmore')
        $content = nm_create_excerpt($content, $url, true);
      else
        $content = nm_create_excerpt($content);
    }
    $image = $nmoption['showimages'] ? nm_get_image_url(stripslashes($post->image)) : false;
    if ($image) {
      $imghtml = '';
      if ($nmoption['imagesizeattr'] && $nmoption['imagewidth'] && $nmoption['imageheight'])
        $imghtml .= ' width="'.$nmoption['imagewidth'].'" height="'.$nmoption['imageheight'].'"';
      $imghtml .= $nmoption['imagealt']   ? ' alt="'.htmlspecialchars($title, ENT_COMPAT).'"' : ' alt=""';
      $imghtml .= $nmoption['imagetitle'] ? ' title="'.htmlspecialchars($title, ENT_COMPAT).'"' : '';
      $imghtml = '<img src="'.htmlspecialchars($image).'"'.$imghtml.' />';
      if ($nmoption['imagelink'])
        $imghtml = '<a href="'.$url.'">'.$imghtml.'</a>';
      $imghtml = '<div class="nm_post_image">'.$imghtml.'</div>'.PHP_EOL;
    } else {
      $imghtml = '';
    }
    if ($nmoption['showauthor']) {
      $author = stripslashes($post->author);
      if (empty($author) && $nmoption['defaultauthor'])
        $author = $nmoption['defaultauthor'];
      $authorhtml = !empty($author) ? '<p class="nm_post_author">'.i18n_r('news_manager/AUTHOR').' <em>'.$author.'</em></p>'.PHP_EOL : '';
    } else {
      $authorhtml = '';
    }
    # print post data ?>
    <<?php echo $nmoption['markuppost']; ?> class="nm_post<?php if ($nmoption['pagetype'] == 'single') echo ' nm_post_single'; ?>">
      <<?php echo $nmoption['markuptitle']; ?> class="nm_post_title"><?php 
        if ($nmoption['titlelink'])
          echo '<a href="',$url,'">',$title,'</a>';
        else
          echo $title;
        ?></<?php echo $nmoption['markuptitle']; ?>>
      <p class="nm_post_date"><?php echo i18n_r('news_manager/PUBLISHED'),' ',$date; ?></p>
      <?php
        echo $authorhtml;
        echo $imghtml;
      ?>
      <div class="nm_post_content"><?php echo $content; ?></div>
      <?php
      # print tags, if any
      if (!empty($post->tags)) {
        $tags = explode(',', nm_lowercase_tags(strip_decode($post->tags)));
        echo '<p class="nm_post_meta"><b>' . i18n_r('news_manager/TAGS') . ':</b> ';
        $sep = '';
        foreach ($tags as $tag) 
          if (substr($tag, 0, 1) != '_') {
            echo $sep,'<a href="',nm_get_url('tag').rawurlencode($tag),'">',$tag,'</a>';
            if ($sep == '') $sep = $nmoption['tagseparator'];
          }
        echo '</p>';
      }
      
      # single post page?
      if ($nmoption['pagetype'] == 'single') {
        # store post data
        global $nmvar;
        $nmvar['slug'] = $slug;
        $nmvar['url'] = $url;
        $nmvar['title'] = $title;
        $nmvar['content'] = $content;
        # show "go back" link?
        if ($nmoption['gobacklink']) {
          $goback = ($nmoption['gobacklink'] === 'main') ? nm_get_url() : 'javascript:history.back()';
          echo '<p class="nm_post_back"><a href="'.$goback.'">';
          i18n('news_manager/GO_BACK');
          echo '</a></p>';
        }
      }
      ?>
    </<?php echo $nmoption['markuppost']; ?>>
    <?php
  } else {
    echo '<p>' . i18n_r('news_manager/NOT_EXIST') . '</p>';
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
      <a href="<?php echo $url . ($index+1); ?>">
        <?php i18n('news_manager/OLDER_POSTS'); ?>
      </a>
    </div>
    <?php
  }
  if ($index > 0) {
    ?>
    <div class="right">
      <a href="<?php echo ($index > 1) ? $url.($index-1) : substr($url, 0, -6); ?>">
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
  global $nmvar;
  if (isset($nmvar['title']) && $nmvar['title']) {
    $title = $before.$nmvar['title'].$after;
    if ($echo) echo $title;
    return $title;
  } else {
    return false;
  }
}


/*** frontend functions, since 2.5 ***/

// conditionals

function nm_is_site() {
  global $nmoption;
  return (isset($nmoption['pagetype']) && $nmoption['pagetype']);
}

function nm_is_single() {
  global $nmoption;
  return (isset($nmoption['pagetype']) && $nmoption['pagetype'] == 'single');
}

function nm_is_main() {
  global $nmoption;
  return (isset($nmoption['pagetype']) && $nmoption['pagetype'] == 'main');
}

function nm_is_tag() {
  global $nmoption;
  return (isset($nmoption['pagetype']) && $nmoption['pagetype'] == 'tag');
}

function nm_is_archive() {
  global $nmoption;
  return (isset($nmoption['pagetype']) && $nmoption['pagetype'] == 'archive');
}

function nm_is_search() {
  global $nmoption;
  return (isset($nmoption['pagetype']) && $nmoption['pagetype'] == 'search');
}

function nm_is_home() {
  global $nmoption;
  return (isset($nmoption['ishome']) && $nmoption['ishome']);
}

// set general option
function nm_set_option($option, $value=true) {
  global $nmoption;
  if ($option) $nmoption[$option] = $value;
}

// get option value, return $default if not defined
function nm_get_option($option, $default=false) {
  global $nmoption;
  if ($option) {
    if (isset($nmoption[$option]))
      return $nmoption[$option];
    else
      return $default;
  }
}

// template tags (single post view)

function nm_post_slug($echo=true) {
  global $nmvar;
  if (isset($nmvar['slug']) && $nmvar['slug']) {
    $slug = $nmvar['slug'];
    if ($echo) echo $slug;
    return $slug;
  } else {
    return false;
  }
}

function nm_post_url($echo=true) {
  global $nmvar;
  if (isset($nmvar['url']) && $nmvar['url']) {
    $url = $nmvar['url'];
    if ($echo) echo $url;
    return $url;
  } else {
    return false;
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