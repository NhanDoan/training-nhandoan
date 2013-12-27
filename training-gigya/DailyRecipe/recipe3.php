<?php
require_once("config.php");
$current_page = "recipe3";
$title = "Carbonara Gnocchi";
$image = "images/recipe3.png";
$description = "Daily Recipe is a Gigya demo site that uses Gigya's plugins and APIs. The site is intended for developers who want to understand how to implement Gigya.";
$shortDesc = "Gnocchi with bacon and spinach carbonara style.";
$cooking_time = '50m';
$imageUrl = $websiteUrl . '/' . $image;
include_once("header.php");
require_once("plugins.php");

?>
<div class="recipecontent">
  <div class="caption recipe-caption">
    <div class="recipe-title"><h1><?php echo strtoupper($title) ?></h1><span class="recipe-date">JUNE 18, 2013</span></div>
  </div>

  <div class="reaction-wrap">
    <div id=reactionsDiv></div>
  </div>
  <!-- Add user action to be used in reactions plugin and share bar -->
  <?php add_user_action($title, $pageURL, $description, $imageUrl); ?>
  <!-- Render reactions plugin -->
  <?php render_reactions('reactionsDiv', $current_page);?>
  <!-- Content  -->
  <div class="recipe ui-helper-clearfix">
    <div class="recipe-image">
      <img src="<?php echo $image ?>" align="right"/>
      <?php if(!empty($_SESSION['login'])):?>
          <input type="button" id="cooked" class="cooked sprite-fbAction-button_prepared" value="Prepared it"/>
          <?php require_once('user_dialogs/fb_action.php'); ?>
      <?php endif; ?>
      <div class="author-details">
        <img class="userimage" src="images/avatar.jpg" align="left" /><span class="recipe-by">Recipe by Chef Laura Fu</span>
      </div>
    </div>
    <div class="recipe-text">
      <p>
        Gnocchi with bacon and spinach carbonara style.<br/>
        Here's the recipe:<br/><br/>
        <strong>Serves 2</strong><br/>
        4 oz Bacon, diced<br/>
        3 cups Spinach (anything except baby)<br/>
        4 cloves Garlic, minced<br/>
        1/2 cup White Wine or vermouth<br/>
        1/2 cup Heavy Cream<br/>
        2 ea Egg Yolks<br/>
        Salt & pepper to taste<br/>
      </p>

      <p>
        Heat a heavy saute pan and add the bacon<br/>
        Cook till browned and cripsy<br/>
        Add the minced garlic and spinach, and saute till spinach wilts<br/>
        Add the White wine and reduce by half<br/>
        Add the heavy cream, and cook on high until sauce coats the back of a spoon, about 10 minutes<br/>
        Season to taste<br/>
        Temper the egg yolks with the hot sauce, and then gradually combine the yolk mixture and bacon spinach cream
        sauce<br/>
        Toss with freshly cooked gnocchi <br/>
      </p>
  </div>
  <!-- Share Bar Plugin DIV Container -->
  <div class="share-wrap ui-helper-clearfix">
    <p class="shareText">Share this recipe with your friends</p>

    <div id="shareButtons"></div>
  </div>
    <!-- Add the Share Bar script -->
    <?php render_sharebar('shareButtons');?>
  <div class="comments">
    <h2 class="comments-title">Comments</h2>
    <div id="commentsDiv" class="comments-div"></div>
    <!-- Render comments plugin -->
    <?php render_comments('commentsDiv', $commentsCategoryID, $current_page);?>
  </div>
</div>
</div>
<div class="sidebar">
  <?php include_once("sidebar.php"); ?>
</div>


<?php include_once("footer.php"); ?>


