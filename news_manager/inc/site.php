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
  global $NMPOSTSPERPAGE;
  $posts = nm_get_posts();
  $pages = array_chunk($posts, intval($NMPOSTSPERPAGE), true);
  if (is_numeric($index) && $index >= 0 && $index < sizeof($pages))
    $posts = $pages[$index];
  else
    $posts = array();
  nm_set_pagetype_options('main');
  nm_get_layout_block('nm-init');
  nm_get_layout_block('nm-top-main') || nm_get_layout_block('nm-top');
  if (!empty($posts)) {
    $showexcerpt = nm_get_option('excerpt');
    foreach ($posts as $post)
      nm_show_post($post->slug, $showexcerpt);
    if (sizeof($pages) > 1)
      nm_show_navigation($index, sizeof($pages));
  } else {
    echo '<p>' . i18n_r('news_manager/NO_POSTS') . '</p>';
  }
  nm_get_layout_block('nm-bottom-main') || nm_get_layout_block('nm-bottom');
  nm_get_layout_block('nm-end');
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
    nm_get_layout_block('nm-init');
    nm_get_layout_block('nm-top-archive') || nm_get_layout_block('nm-top');
    $showexcerpt = nm_get_option('excerpt');
    $posts = $archives[$archive];
    foreach ($posts as $slug)
      nm_show_post($slug, $showexcerpt);
   }
  nm_get_layout_block('nm-bottom-archive') || nm_get_layout_block('nm-bottom');
  nm_get_layout_block('nm-end');
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
    nm_get_layout_block('nm-init');
    nm_get_layout_block('nm-top-tag') || nm_get_layout_block('nm-top');
    $showexcerpt = nm_get_option('excerpt');
    $posts = $tags[$tag];
    foreach ($posts as $slug)
      nm_show_post($slug, $showexcerpt);
    nm_get_layout_block('nm-bottom-tag') || nm_get_layout_block('nm-bottom');
    nm_get_layout_block('nm-end');
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
  nm_get_layout_block('nm-init');
  nm_get_layout_block('nm-top-search') || nm_get_layout_block('nm-top');
  if (!empty($posts)) {
    $showexcerpt = nm_get_option('excerpt');
    echo '<p>' . i18n_r('news_manager/FOUND') . '</p>';
    foreach ($posts as $post)
      nm_show_post($post->slug, $showexcerpt);
  } else {
    echo '<p>' . i18n_r('news_manager/NOT_FOUND') . '</p>';
  }
  nm_get_layout_block('nm-bottom-search') || nm_get_layout_block('nm-bottom');
  nm_get_layout_block('nm-end');
}

/*******************************************************
 * @function nm_show_single
 * @param $slug post slug
 * @action show single post on news page
 */
function nm_show_single($slug) {
  nm_set_pagetype_options('single');
  nm_get_layout_block('nm-init');
  nm_get_layout_block('nm-top-single') || nm_get_layout_block('nm-top');
  nm_show_post($slug);
  nm_get_layout_block('nm-bottom-single') || nm_get_layout_block('nm-bottom');
  nm_get_layout_block('nm-end');
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
  # general options
  
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
  
  $nmoption['titlelink'] = ($NMSETTING['titlelink']=='Y' || ($NMSETTING['titlelink']=='P' && $pagetype != 'single'));

  if ($pagetype == 'single') {
    if ($NMSETTING['gobacklink'] == 'N') 
      $nmoption['gobacklink'] = false;
    elseif ($NMSETTING['gobacklink'] == 'M') 
      $nmoption['gobacklink'] = 'main';
    else
      $nmoption['gobacklink'] = true;
  }
  
  $nmoption['showauthor'] = false;
  $nmoption['defaultauthor'] = '';
  
  # images:
  if ( $NMSETTING['images'] == 'N' 
    || ($pagetype == 'single' && $NMSETTING['images'] == 'P')
    || ($pagetype != 'main' && $NMSETTING['images'] == 'M') ) {
    $nmoption['showimages'] = false;
  } else {
    $nmoption['showimages'] = true;
  }
  $nmoption['images']['width'] = $NMSETTING['imagewidth'];
  $nmoption['images']['height'] = $NMSETTING['imageheight'];
  $nmoption['images']['crop'] = ($NMSETTING['imagecrop'] == '1');
  $nmoption['images']['alt'] = ($NMSETTING['imagealt'] == '1');
  $nmoption['images']['link'] = ($pagetype != 'single' && $NMSETTING['imagelink'] == '1');
  $nmoption['images']['title'] = false;
  $nmoption['images']['external'] = false;
  $nmoption['images']['default'] = '';
  
  # news page type
  $nmoption['pagetype'] = $pagetype;
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
      $imghtml .= $nmoption['images']['alt']   ? ' alt="'.htmlspecialchars($title, ENT_COMPAT).'"' : ' alt=""';
      $imghtml .= $nmoption['images']['title'] ? ' title="'.htmlspecialchars($title, ENT_COMPAT).'"' : '';
      $imghtml = '<img src="'.htmlspecialchars($image).'"'.$imghtml.' />';
      if ($nmoption['images']['link'])
        $imghtml = '<a href="'.$url.'">'.$imghtml.'</a>';
      $imghtml = '<div class="nm_post_image">'.$imghtml.'</div>'.PHP_EOL;
    } else {
      $imghtml = '';
    }
    if ($nmoption['showauthor']) {
      $author = stripslashes($post->author);
      if (empty($author) && $nmoption['defaultauthor'])
        $author = $nmoption['defaultauthor'];
      $authorhtml = !empty($author) ? '<p class="nm_post_author">'.i18n_r('news_manager/AUTHOR').' '.$author.'</p>'.PHP_EOL : '';
    } else {
      $authorhtml = '';
    }
    # print post data ?>
    <div class="nm_post<?php if ($nmoption['pagetype'] == 'single') echo ' nm_post_single'; ?>">
      <h3 class="nm_post_title">
        <?php 
        if ($nmoption['titlelink'])
          echo '<a href="',$url,'">',$title,'</a>';
        else
          echo $title;
        ?>
      </h3>
      <p class="nm_post_date"><?php echo i18n_r('news_manager/PUBLISHED'),' ',$date; ?></p>
      <?php
        echo $authorhtml;
        echo $imghtml;
      ?>
      <div class="nm_post_content"><?php echo $content; ?></div>
      <?php
      # print tags, if any
      if (!empty($post->tags)) {
        $tags = explode(',', nm_lowercase_tags($post->tags));
        echo '<p class="nm_post_meta"><b>' . i18n_r('news_manager/TAGS') . ':</b>';
        foreach ($tags as $tag) 
          if (substr($tag, 0, 1) != '_') {
            $url = nm_get_url('tag') . $tag;
            echo ' <a href="',$url,'">',$tag,'</a>';
          }
        echo '</p>';
      }
      
      # single post page?
      if ($nmoption['pagetype'] == 'single') {
        # store post title
        global $NMPOSTTITLE;
        $NMPOSTTITLE = $title;
        if ($nmoption['gobacklink']) {
          # show "go back" link
          $goback = ($nmoption['gobacklink'] === 'main') ? nm_get_url() : 'javascript:history.back()';
          echo '<p class="nm_post_back"><a href="'.$goback.'">';
          i18n('news_manager/GO_BACK');
          echo '</a></p>';
        }
      }
      ?>
    </div>
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
  global $NMPAGEURL;
  $title = false;
  if (isset($_GET['post']) && strval(get_page_slug(false)) == $NMPAGEURL) {
    global $NMPOSTTITLE;
    if ($NMPOSTTITLE) {
      # use previously read post title
      $title = $before.$NMPOSTTITLE.$after;
      if ($echo) echo $title;
    }
  }
  return $title;
}

/*** frontend functions, since 2.5 ***/

// conditionals

function nm_is_single() {
  global $nmoption;
  return ($nmoption['pagetype'] == 'single');
}

function nm_is_main() {
  global $nmoption;
  return ($nmoption['pagetype'] == 'main');
}

function nm_is_tag() {
  global $nmoption;
  return ($nmoption['pagetype'] == 'tag');
}

function nm_is_archive() {
  global $nmoption;
  return ($nmoption['pagetype'] == 'archive');
}

function nm_is_search() {
  global $nmoption;
  return ($nmoption['pagetype'] == 'search');
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
    if (isset ($nmoption[$option]))
      return $nmoption[$option];
    else
      return $default;
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
    $nmoption['images'][$option] = $value;
}

function nm_set_image_size($width=null, $height=null, $crop=false) {
  global $nmoption;
  $nmoption['images']['width'] = $width;
  $nmoption['images']['height'] = $height;
  $nmoption['images']['crop'] = $crop;
}

// custom text/language strings

function nm_set_text($i18nkey=null, $i18nvalue=null) {
  global $i18n;
  if ($i18nkey && $i18nvalue)
    $i18n['news_manager/'.$i18nkey] = $i18nvalue;
}

// used by nm_get_layout_block
if (!function_exists('component_exists')) {
  function component_exists($id) {
    global $components;
    if (!$components) {
       if (file_exists(GSDATAOTHERPATH.'components.xml')) {
        $data = getXML(GSDATAOTHERPATH.'components.xml');
        $components = $data->item;
      } else {
        $components = array();
      }
    }
    $exists = FALSE;
    if (count($components) > 0) {
      foreach ($components as $component) {
        if ($id == $component->slug) {
          $exists = TRUE;
          break;
        }
      }
    }
    return $exists;
  }
}

// get template component, return false if not exists
function nm_get_layout_block($templ) {
  if (component_exists($templ)) {
    get_component($templ);
    return true;
  } else {
    return false;
  }
}

?>