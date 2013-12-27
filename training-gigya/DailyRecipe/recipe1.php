<?php
require_once("config.php");
$current_page = "recipe1";
$title = "Gateau a la Royale";
$image = "images/recipe1.png";
$description = "Daily Recipe is a Gigya demo site that uses Gigya's plugins and APIs. The site is intended for developers who want to understand how to implement Gigya.";
$shortDesc = "Jumping on the royal wedding bandwagon, I was tasked with making the royal wedding fridge cake for a tea party.";
$cooking_time = '3h';
$imageUrl = $websiteUrl . '/' . $image;
include_once("header.php");
require_once("plugins.php");

?>
<div class="recipecontent">
  <div class="caption recipe-caption">
    <div class="recipe-title"><h1><?php echo strtoupper($title) ?></h1><span class="recipe-date">JUNE 18, 2013</span></div>
  </div>

  <!-- The following method creates a global User Action object that is used by the Reactions and Share-bar plugins -->
  <?php add_user_action($title, $pageURL, $description, $imageUrl); ?>

  <!-- Reactions Bar -->
  <div class="reaction-wrap">
    <div id=reactionsDiv></div> <!-- Reactions DIV Container --> 
  </div> 
  <!-- Render reactions plugin -->
  <?php render_reactions('reactionsDiv', $current_page);?>
  
  <!-- Content  -->
  <div class="recipe">
    <div class="recipe-image">
      <img src="<?php echo $image ?>" align="right" />
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

      <?php echo $shortDesc ?><br/>
      Having lived in England for a brief period of time, I am ashamed to say that I had no idea what the cake was
      supposed to be like; texture, taste etc. Online research also did not indicate whether it was supposed to be extra
      sweet, crunchy, etc.<br/><br/>
      So, I winged it, envisioning a chewy fudge with a slightly crunchy inside, the sweet more coming from raisins.
      Some of the recipes called for nuts, but I omitted it since I'm not particularly a fan. <br/><br/>

      Enjoy!
      <br/><br/>
      <span class="makes">Makes 1 Cake</span><br/>
      Line an 8" square pan with cling wrap.<br/>
      Soak the raisins in hot water for about 20 minutes, then drain the liquid off. <br/>
      Place the biscuits in a large gallon zip lock bag, seal it, and bash it with a rolling pin, leaving some quarter
      sized pieces (do this step manually, and don't use a food processor). <br/><br/>
      Combine the condensed milk, cream and corn syrup in a saucepan and bring to a boil.<br/>
      Chop the butter up into smaller pieces and place it in a bowl with the chocolate chips.<br/>
      Pour the hot cream mixture over the chocolate, and stir until well combined.<br/>
      Leave the chocolate mixture to cool until room temperature.<br/>
      Combine the crushed biscuits, raisins and chocolate mixture until everything is well coated with
      chocolate.<br/><br/>

      Pour in the pan, level the top and freeze for about 2-3 hours, or until firm.<br/>
      Slice with a sharp knife to serve.<br/>
      </p>
    </div>

	<!-- Share Bar -->
    <div class="share-wrap ui-helper-clearfix">
      <p class="shareText">Share this recipe with your friends</p>	  
      <div id="shareButtons"></div>  <!-- Share Bar Plugin DIV Container -->
	  <?php render_sharebar('shareButtons');?> <!-- This method presents the Share Bar plugin -->
    </div>   

    <!-- Comments -->
    <div class="comments">
    <h2 class="comments-title">Comments</h2>
    <div id="commentsDiv" class="comments-div"></div> <!-- Comments Plugin DIV Container -->      
    <?php render_comments('commentsDiv', $commentsCategoryID, $current_page);?>  <!-- This method presents the Comments plugin -->
    </div>
  </div>
</div>
<div class="sidebar">
  <?php include_once("sidebar.php"); ?>
</div>


<?php include_once("footer.php"); ?>


