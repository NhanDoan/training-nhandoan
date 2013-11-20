<?php
if ( !empty($breadcrumb)): ?>
<span class = "breadcrumb">
  <?php print implode(''.$breadcrumb_delimiter.'', $breadcrumb);?>
</span>

<?php endif;?>
