<?php

/**
 * News Manager edit post template
 */

?>

<h3 class="floated">
  <?php
  if (empty($data))
    i18n('news_manager/NEW_POST');
  else
    i18n('news_manager/EDIT_POST');
  ?>
</h3>
<div class="edit-nav" >
  <?php
  if (file_exists($file) && $private == '') {
    $url = nm_get_url('post') . $slug;
    ?>
    <a href="<?php echo $url; ?>" target="_blank">
      <?php i18n('news_manager/VIEW_POST'); ?>
    </a>
    <?php
  }
  ?>
  <a href="#" id="metadata_toggle">
    <?php i18n('news_manager/POST_OPTIONS'); ?>
  </a>
  <div class="clear"></div>
</div>
<form class="largeform" id="edit" action="load.php?id=news_manager" method="post" accept-charset="utf-8">
  <?php
  if (!empty($slug))
    echo "<p><input name=\"current-slug\" type=\"hidden\" value=\"$slug\" /></p>";
  ?>
  <p>
    <input class="text title required" name="post-title" id="post-title" type="text" value="<?php echo $title; ?>" placeholder="<?php i18n('news_manager/POST_TITLE'); ?>" />
  </p>
  <div style="display:none;" id="metadata_window">
    <div class="leftopt">
      <p>
        <label for="post-slug"><?php i18n('news_manager/POST_SLUG'); ?>:</label>
        <input class="text short" id="post-slug" name="post-slug" type="text" value="<?php echo $slug; ?>" />
      </p>
      <p>
        <label for="post-date"><?php i18n('news_manager/POST_DATE'); ?>:</label>
        <input class="text short" id="post-date" name="post-date" type="text" value="<?php echo $date; ?>" />
      </p>
      <p class="inline" id="post-private-wrap">
        <label for="post-private"><?php i18n('news_manager/POST_PRIVATE'); ?></label>
        &nbsp;&nbsp;
        <input type="checkbox" id="post-private" name="post-private" <?php echo $private; ?> />
      </p>
    </div>
    <div class="rightopt">
      <p>
        <label for="post-tags"><?php i18n('news_manager/POST_TAGS'); ?>:</label>
        <input class="text short" id="post-tags" name="post-tags" type="text" value="<?php echo $tags; ?>" />
      </p>
      <p>
        <label for="post-time"><?php i18n('news_manager/POST_TIME'); ?>:</label>
        <input class="text short" id="post-time" name="post-time" type="text" value="<?php echo $time; ?>" />
      </p>
    </div>
    <div class="clear"></div>
  </div>
  <p>
    <textarea name="post-content"><?php echo $content; ?></textarea>
  </p>
  <p>
    <input name="post" type="submit" class="submit" value="<?php i18n('news_manager/SAVE_POST'); ?>" />
    &nbsp;&nbsp;<?php i18n('news_manager/OR'); ?>&nbsp;&nbsp;
    <a href="load.php?id=news_manager&cancel" class="cancel"><?php i18n('news_manager/CANCEL'); ?></a>
    <?php
    if (file_exists($file)) {
      ?>
      /
      <a href="load.php?id=news_manager&delete=<?php echo $slug; ?>" class="cancel">
        <?php i18n('news_manager/DELETE'); ?>
      </a>
      <?php
    }
    ?>
  </p>
</form>

<script>
  $(document).ready(function(){
    $.validator.addMethod("time", function(value, element) {
        return this.optional(element) || /^([01]?[0-9]|2[0-3]):[0-5][0-9]/.test(value);
    },
    "Please enter a valid time.")

    $("#edit").validate({
      errorClass: "invalid",
      rules: {
        "post-date": { date: true },
        "post-time": { time: true }
      }
    })

    $("#post-title").focus();
  });
</script>
