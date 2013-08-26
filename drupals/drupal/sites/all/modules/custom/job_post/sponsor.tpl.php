<?php
/**
 * @files
 *
 * Available variable
 * - $sponsor_id: the node ID asociated with the job posting
 * - $sponsor : the name of the job post sponsor
 *
 */

?>
<div id = "sponsor_<?php print $sponsor_id?>" class = "sponsor">
  <div class= "sponsor-title">
    <h2> Sponsored by </h2>
  </div>
  <div class= "sponsored-by-message">
    This job postting was sponsored by : <?php print $sponsor?>
  </div>
</div>
