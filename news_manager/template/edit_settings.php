<?php if (!defined('IN_GS')) {die('you cannot load this page directly.');}

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
      if ($NMPAGEURL == '') $NMPAGEURL = 'index'; // if not yet selected
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
      <label for="posts-per-page"><?php i18n('news_manager/POSTS_PER_PAGE'); ?>:</label>
      <input class="text required" type="text" name="posts-per-page" value="<?php echo $NMPOSTSPERPAGE; ?>" />
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
      <label for="recent-posts"><?php i18n('news_manager/RECENT_POSTS'); ?>:</label>
      <input class="text required" type="text" name="recent-posts" value="<?php echo $NMRECENTPOSTS; ?>" />
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
      <label for="archivesby"><?php i18n('news_manager/ENABLE_ARCHIVES'); ?>:</label>
      <select class="text" name="archivesby">
        <option value="m"<?php if ($NMSETTING['archivesby']=='m') echo ' selected="selected"'; ?>><?php i18n('news_manager/BY_MONTH'); ?></option>
        <option value="y"<?php if ($NMSETTING['archivesby']=='y') echo ' selected="selected"'; ?>><?php i18n('news_manager/BY_YEAR'); ?></option>
      </select>
    </p>
  </div>
  <div class="clear"></div>
  <div class="leftsec">
    <p>
      <label for="excerpt-length"><?php i18n('news_manager/EXCERPT_LENGTH'); ?>:</label>
      <input class="text required" type="text" name="excerpt-length" value="<?php echo $NMEXCERPTLENGTH; ?>" />
    </p>
  </div>
  <div class="rightsec">
    <p>
      <label for="readmore"><?php i18n('news_manager/READ_MORE_LINK'); ?>:</label>
      <select class="text" name="readmore">
        <option value="N"<?php if ($NMSETTING['readmore']=='N') echo ' selected="selected"'; ?>><?php i18n('NO'); ?></option>
        <option value="R"<?php if ($NMSETTING['readmore']=='R') echo ' selected="selected"'; ?>><?php i18n('YES'); ?></option>
        <option value="F"<?php if ($NMSETTING['readmore']=='F') echo ' selected="selected"'; ?>><?php i18n('news_manager/ALWAYS'); ?></option>
      </select>
    </p>
  </div>
  <div class="clear"></div>
  <div class="leftsec">
    <p>
      <label for="titlelink"><?php i18n('news_manager/TITLE_LINK'); ?>:</label>
      <select class="text" name="titlelink">
        <option value="Y"<?php if ($NMSETTING['titlelink']=='Y') echo ' selected="selected"'; ?>><?php i18n('YES'); ?></option>
        <option value="N"<?php if ($NMSETTING['titlelink']=='N') echo ' selected="selected"'; ?>><?php i18n('NO'); ?></option>
        <option value="P"<?php if ($NMSETTING['titlelink']=='P') echo ' selected="selected"'; ?>><?php i18n('news_manager/NOT_SINGLE'); ?></option>
      </select>
    </p>
  </div>
  <div class="rightsec">
    <p>
      <label for="gobacklink"><?php i18n('news_manager/GO_BACK_LINK'); ?>:</label>
      <select class="text" name="gobacklink">
        <option value="B"<?php if ($NMSETTING['gobacklink']=='B') echo ' selected="selected"'; ?>><?php i18n('news_manager/BROWSER_BACK'); ?></option>
        <option value="M"<?php if ($NMSETTING['gobacklink']=='M') echo ' selected="selected"'; ?>><?php i18n('news_manager/MAIN_NEWS_PAGE'); ?></option>
        <option value="N"<?php if ($NMSETTING['gobacklink']=='N') echo ' selected="selected"'; ?>><?php i18n('NO'); ?></option>
      </select>
    </p>
  </div>
  <div class="clear"></div>
  <div class="leftsec">
    <p>
      <label for="images"><?php i18n('news_manager/ENABLE_IMAGES'); ?>:</label>
      <select class="text" name="images" id="images">
        <option value="N"<?php if ($NMSETTING['images']=='N') echo ' selected="selected"'; ?>><?php i18n('NO'); ?></option>
        <option value="Y"<?php if ($NMSETTING['images']=='Y') echo ' selected="selected"'; ?>><?php i18n('YES'); ?></option>
        <option value="P"<?php if ($NMSETTING['images']=='P') echo ' selected="selected"'; ?>><?php i18n('news_manager/NOT_SINGLE'); ?></option>
        <option value="M"<?php if ($NMSETTING['images']=='M') echo ' selected="selected"'; ?>><?php i18n('news_manager/MAIN_NEWS_PAGE'); ?></option>
      </select>
    </p>
  </div>
  <div class="rightsec" id="imagelink">
    <p class="inline">
      <br />
      <input name="imagelink" type="checkbox" <?php if ($NMSETTING['imagelink'] == '1') echo 'checked'; ?> />&nbsp;
      <label for="imagelink"><?php i18n('news_manager/IMAGE_LINKS'); ?></label>
    </p>
  </div>
  <div class="clear"></div>
  <div id="imageoptions">
    <div class="leftsec">
      <p>
        <label for="imagewidth"><?php i18n('news_manager/IMAGE_WIDTH'); ?>:</label>
        <input class="text" type="text" name="imagewidth" value="<?php echo $NMSETTING['imagewidth']; ?>" placeholder="0 = <?php i18n('news_manager/FULL'); ?>" />
      </p>
    </div>
    <div class="rightsec">
      <p>
        <label for="imageheight"><?php i18n('news_manager/IMAGE_HEIGHT'); ?>:</label>
        <input class="text" type="text" name="imageheight" value="<?php echo $NMSETTING['imageheight']; ?>" placeholder="0 = <?php i18n('news_manager/FULL'); ?>" />
      </p>
    </div>
    <div class="clear"></div>
    <div class="leftsec">
      <p class="inline">
        <input name="imagecrop" type="checkbox" <?php if ($NMSETTING['imagecrop'] == '1') echo 'checked'; ?> />&nbsp;
        <label for="imagecrop"><?php i18n('news_manager/IMAGE_CROP'); ?></label>
      </p>
    </div>
    <div class="rightsec">
      <p class="inline">
        <input name="imagealt" type="checkbox" <?php if ($NMSETTING['imagealt'] == '1') echo 'checked'; ?> />&nbsp;
        <label for="imagealt"><?php i18n('news_manager/IMAGE_ALT'); ?></label>
      </p>
    </div>
    <div class="clear"></div>
  </div><!-- imageoptions -->
  <p class="inline">
    <input name="enablecustomsettings" id="enablecustomsettings" type="checkbox" <?php if ($NMSETTING['enablecustomsettings'] == '1') echo 'checked'; ?> />&nbsp;
    <label for="customsettings"><?php i18n('news_manager/CUSTOM_SETTINGS'); ?></label>
    <textarea style="height:150px" name="customsettings" id="customsettings"><?php echo $NMSETTING['customsettings']; ?></textarea>
  </p>
  
  <?php if ( $PRETTYURLS == 1 && (!$PERMALINK || strpos($PERMALINK,'?') === false) )  { ?>
  <p class="inline">
    <input name="pretty-urls" type="checkbox" <?php if ($NMPRETTYURLS == 'Y') echo 'checked'; ?> />&nbsp;
    <label for="pretty-urls"><?php i18n('news_manager/PRETTY_URLS'); ?></label> -
    <span class="hint"><?php i18n('news_manager/PRETTY_URLS_NOTE'); ?> <a href="load.php?id=news_manager&amp;htaccess"><?php i18n('MORE'); ?></a></span>
  </p>
  <?php } ?>
  <p>
    <span>
      <input class="submit" type="submit" name="settings" value="<?php i18n('news_manager/SAVE_SETTINGS'); ?>" />
    </span>
    &nbsp;&nbsp;<?php i18n('news_manager/OR'); ?>&nbsp;&nbsp;
    <a href="load.php?id=news_manager&amp;cancel" class="cancel"><?php i18n('news_manager/CANCEL'); ?></a>
  </p>
</form>

<script>
  jQuery.extend(jQuery.validator.messages, {
    required: "<?php i18n('news_manager/FIELD_IS_REQUIRED'); ?>"
  });
  
  $(document).ready(function(){
    $("#settings").validate({
      errorClass: "invalid",
      rules: {
        "excerpt-length": { min: 0 },
        "posts-per-page": { min: 1 },
        "recent-posts": { min: 1 }
      }
    })
    
    $('.submit').clone().appendTo('#sidebar');
    $('#sidebar .submit').css({'margin-left': '14px'}).click(function() { $('form#settings.largeform input.submit').trigger('click'); });
    
    if ($('#images option:selected').val() == "N"){
      $('#imagelink').hide();
      $('#imageoptions').hide();
    }

    if ($('#enablecustomsettings').is(':checked')) {
      $('#customsettings').show();
    } else {
      $('#customsettings').hide();
    }
  });
  
  $('#images').change(function(){
    if ($('#images option:selected').val() == "N"){
      $('#imagelink').hide();
      $('#imageoptions').hide();
    } else {
      $('#imagelink').show();
      $('#imageoptions').show();
    }
  });
  
  $('#enablecustomsettings').change(function(){
    if ($('#enablecustomsettings').is(':checked')) {
      $('#customsettings').show();
    } else {
      $('#customsettings').hide();
    }
  });
</script>
