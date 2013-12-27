<?php
require_once("config.php");
$current_page = "recipe2";
$title = "Mushroom Mystique";
$image = "images/recipe2.png";
$description = "Daily Recipe is a Gigya demo site that uses Gigya's plugins and APIs. The site is intended for developers who want to understand how to implement Gigya.";
$shortDesc = "I absolutely love mushrooms, and think that one of the simplest, most luxurious food that you can have is creamy mushroom soup!";
$cooking_time = '1h';
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
      I absolutely love mushrooms, and think that one of the simplest, most luxurious food that you can have is creamy
      mushroom soup!<br/>
      Traditionally, as with most other foods, cooking a great mushroom soup requires time, patience, and multiple
      steps.<br/>
      However, there are times when the luxury of time or patience cannot be afforded, as with a small dinner party on a
      workday evening.<br/>
      At times like those, it is necessary to take shortcuts, <br/>while still producing the best possible result that I
      would not <br/>be ashamed to serve on the table. <br/>Although I had to work quickly, it paid off, and we had
      mushroom soup on the table in 30 minutes!<br/><br/>
      Here's the recipe:<br/><br/>
      <span class="makes">Creamy Mushroom Soup</span><br/>
      1 lb Fresh Mushrooms, I like to use Crimini & Shitake for best flavor<br/>
      2 ea Garlic Cloves, Smashed<br/>
      2 sprigs Thyme<br/>
      1/4 cup White Wine<br/>
      2 cups Chicken Stock, or Veggie<br/>
      2 cups Half & Half<br/>
      3 Tbs Butter<br/>
      Salt & pepper to taste<br/>
      </p>
      <p>
        In a heavy saucepan, melt one tbs of butter<br/>
        Add 1/3 of the mushrooms, one garlic clove, and 1 sprig thyme<br/>
        Saute mushrooms until a deep brown, and cooked through<br/>
        Repeat with the remaining 2 batches of mushrooms<br/>
        Deglaze the pan with the white wine - that means adding the liquid and scraping up the brown bits over heat<br/>
        Bring the pan juices, stock and mushrooms to a boil<br/>
        Simmer for about 10 minutes<br/>
        Puree the mushroom soup and add the half & half<br/>
        Thin with water to desired consistency, then season with salt & pepper <br/>
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


