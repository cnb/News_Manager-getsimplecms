<?php if (!defined('IN_GS')) {die('you cannot load this page directly.');}

/**
 * News Manager main admin panel.
 */


/*******************************************************
 * @function nm_admin_main
 * @action back-end main panel (post overview)
 */
function nm_admin_panel() {
  global $PRETTYURLS, $NMPRETTYURLS;
  $posts = nm_get_posts(true);
  ?>
  <h3 class="floated"><?php i18n('news_manager/PLUGIN_NAME'); ?></h3>
  <div class="edit-nav clearfix">
    <a href="#" id="filter-button" ><?php i18n('FILTER'); ?></a>
    <a href="load.php?id=news_manager&edit"><?php i18n('news_manager/NEW_POST'); ?></a>
    <a href="load.php?id=news_manager&settings"><?php i18n('news_manager/SETTINGS'); ?></a>
  </div>
  <?php
  if (!empty($posts)) {
    ?>
    <div id="filter-search">
      <form>
        <input type="text" class="text" id="tokens" placeholder="<?php echo lowercase(i18n_r('FILTER')); ?>..." />
        &nbsp;
        <a href="load.php?id=news_manager" class="cancel"><?php i18n('news_manager/CANCEL'); ?></a>
      </form>
    </div>
    <table id="posts" class="highlight">
    <tr>
      <th><?php i18n('news_manager/POST_TITLE'); ?></th>
      <th style="text-align: right;"><?php i18n('news_manager/DATE'); ?></th>
      <th></th>
      <th></th>
      <th></th>
    </tr>
    <?php
    foreach ($posts as $post) {
      $title = cl($post->title);
      $date = shtDate($post->date);
      $url = nm_get_url('post') . $post->slug;
      ?>
      <tr>
        <td class="posttitle">
          <a href="load.php?id=news_manager&edit=<?php echo $post->slug; ?>" title="<?php i18n('news_manager/EDIT_POST'); ?>: <?php echo $title; ?>">
            <?php echo $title; ?>
          </a>
        </td>
        <td style="text-align: right;">
          <span><?php echo $date; ?></span>
        </td>
        <td style="width: 20px;text-align: center;">
          <?php
            if ($post->private == 'Y')
              echo '<span style="color: #aaa;">P</span>';
          ?>
        </td>
        <td class="secondarylink">
          <a href="<?php echo $url; ?>" target="_blank" title="<?php i18n('news_manager/VIEW_POST'); ?>: <?php echo $title; ?>">
            #
          </a>
        </td>
        <td class="delete">
          <a href="load.php?id=news_manager&delete=<?php echo $post->slug; ?>" class="delconfirm" title="<?php i18n('news_manager/DELETE_POST'); ?>: <?php echo $title; ?>?">
            X
          </a>
        </td>
      </tr>
      <?php
    }
    ?>
    </table>
    <p>
      <b><?php echo count($posts); ?></b>
      <?php i18n('news_manager/POSTS'); ?>
    </p>

    <script>
    $(document).ready(function() {
      // filter button opens up filter dialog
      $("#filter-button").live("click", function($e) {
        $e.preventDefault();
        $("#filter-search").slideToggle();
        $(this).toggleClass("current");
        $("#filter-search #tokens").focus();
      });
      // ignore enter key in filter form
      $("#filter-search #tokens").keydown(function($e) {
        if($e.keyCode == 13) {
          $e.preventDefault();
        }
      });
      // close filter dialog on cancel
      $("#filter-search .cancel").live("click", function($e) {
        $e.preventDefault();
        $("#posts tr").show();
        $('#filter-button').toggleClass("current");
        $("#filter-search #tokens").val("");
        $("#filter-search").slideUp();
      });
      // filter table, see:
      // http://kobikobi.wordpress.com/2008/09/15/using-jquery-to-filter-table-rows/
      $("#posts tr:has(td.posttitle)").each(function() {
        var t = $(this).find('td.posttitle').text().toLowerCase();
        $("<td class='indexColumn'></td>")
        .hide().text(t).appendTo(this);
      });
      $("#tokens").keyup(function() {
        var s = $(this).val().toLowerCase().split(" ");
      $("#posts tr:hidden").show();
      $.each(s, function(){
           $("#posts tr:visible .indexColumn:not(:contains('"
              + this + "'))").parent().hide();
        });
      });
    });
    </script>

    <?php
  }
}


?>
