<?php

/**
 * News Manager htaccess page
 */

?>

<h3>.htaccess</h3>
<p>
  <?php i18n('news_manager/HTACCESS_HELP'); ?>
  <pre style="padding: 5px; background: #f7f7f7; border: 1px solid #eee;"><?php echo $htaccess; ?></pre>
</p>
<form class="largeform" action="load.php?id=news_manager" method="post" accept-charset="utf-8">
  <p class="hint">
    <?php i18n("news_manager/GO_BACK_WHEN_DONE"); ?>
  </p>
  <p id="submit_line">
    <span>
      <input class="submit" type="submit" value="<?php i18n("news_manager/FINISHED"); ?>" />
    </span>
  </p>
</form>
