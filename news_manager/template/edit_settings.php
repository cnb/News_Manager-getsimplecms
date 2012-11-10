<?php

/**
 * News Manager edit settings template
 */

?>
<h3><?php i18n('news_manager/NM_SETTINGS'); ?></h3>
<p class="hint">
  <?php i18n('news_manager/DOCUMENTATION'); ?>
</p>
<form class="largeform" id="settings" action="load.php?id=news_manager" method="post" accept-charset="utf-8">
  <div class="leftsec">
    <p>
      <label for="page-url"><?php i18n('news_manager/PAGE_URL'); ?>:</label>
      <select class="text" name="page-url">
      <?php
      $pages = get_available_pages();
      foreach ($pages as $page) {
        $slug = $page['slug'];
        if ($slug == $NMPAGEURL)
          echo "<option value=\"$slug\" selected=\"selected\">$slug</option>\n";
        else
          echo "<option value=\"$slug\">$slug</option>\n";
      }
      ?>
      </select>
    </p>
  </div>
  <div class="rightsec">
    <p>
      <label for="excerpt-length"><?php i18n('news_manager/EXCERPT_LENGTH'); ?>:</label>
      <input class="text required" type="text" name="excerpt-length" value="<?php echo $NMEXCERPTLENGTH; ?>" />
    </p>
  </div>
  <div class="clear"></div>
  <div class="leftsec">
    <p>
      <label for="language"><?php i18n('news_manager/LANGUAGE'); ?></label>
      <select class="text" name="language">
      <?php
      $languages = nm_get_languages();
      foreach ($languages as $lang=>$file) {
        if ($lang == $NMLANG)
          echo "<option value=\"$lang\" selected=\"selected\">$lang</option>\n";
        else
          echo "<option value=\"$lang\">$lang</option>\n";
      }
      ?>
      </select>
    </p>
  </div>
  <div class="rightsec">
    <p>
      <label for="posts-per-page"><?php i18n('news_manager/POSTS_PER_PAGE'); ?>:</label>
      <input class="text required" type="text" name="posts-per-page" value="<?php echo $NMPOSTSPERPAGE; ?>" />
    </p>
  </div>
  <div class="clear"></div>
  <div class="leftsec">
    <p>
      <label for="show-excerpt"><?php i18n('news_manager/SHOW_POSTS_AS'); ?>:</label>
      <input name="show-excerpt" type="radio" value="0" <?php if ($NMSHOWEXCERPT != 'Y') echo "checked=\"checked\""; ?> style="vertical-align: middle;" />
      &nbsp;<?php i18n('news_manager/FULL_TEXT'); ?>
      <span style="margin-left: 30px;">&nbsp;</span>
      <input name="show-excerpt" type="radio" value="1" <?php if ($NMSHOWEXCERPT == 'Y') echo "checked=\"checked\""; ?> style="vertical-align: middle;" />
      &nbsp;<?php i18n('news_manager/EXCERPT'); ?>
    </p>
  </div>
  <div class="rightsec">
    <p>
      <label for="recent-posts"><?php i18n('news_manager/RECENT_POSTS'); ?>:</label>
      <input class="text required" type="text" name="recent-posts" value="<?php echo $NMRECENTPOSTS; ?>" />
    </p>
  </div>
  <div class="clear"></div>
  <?php if ($PRETTYURLS == 1) { ?>
  <p class="inline">
    <input name="pretty-urls" type="checkbox" <?php if ($NMPRETTYURLS == 'Y') echo 'checked'; ?> />&nbsp;
    <label for="pretty-urls"><?php i18n('news_manager/PRETTY_URLS'); ?></label> -
    <span class="hint"><?php i18n('news_manager/PRETTY_URLS_NOTE'); ?></span>
  </p>
  <?php } ?>
  <p>
    <span>
      <input class="submit" type="submit" name="settings" value="<?php i18n('news_manager/SAVE_SETTINGS'); ?>" />
    </span>
    &nbsp;&nbsp;<?php i18n('news_manager/OR'); ?>&nbsp;&nbsp;
    <a href="load.php?id=news_manager&cancel" class="cancel"><?php i18n('news_manager/CANCEL'); ?></a>
  </p>
</form>

<script>
  $(document).ready(function(){
    $("#settings").validate({
      errorClass: "invalid",
      rules: {
        "excerpt-length": { min: 50 },
        "posts-per-page": { min: 1 },
        "recent-posts": { min: 1 }
      }
    })
  });
</script>
