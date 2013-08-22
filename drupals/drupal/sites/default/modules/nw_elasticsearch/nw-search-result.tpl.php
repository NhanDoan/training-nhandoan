  <a href="<?= $link ?>"><h3 class="title"><?= $title ?></h3></a>
  <div class="search-metadata">
      <p>Author: <?= $writer_fullname ?><br />
      Status: <?= $status ?>,
      <?php if ($duedate !== NULL) { ?>
        Due: <?= $duedate ?>
      <?php } else { ?>
        Requested On: <?= $submitted ?>
      <?php } ?>
  </div>
  <div class="search-snippet-info">
      <p class="search-snippet"><?= $body ?></p>
  </div>
