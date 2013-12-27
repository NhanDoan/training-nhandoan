<?php
function getPages() {
  for ($i = 1; $i <= 3; $i++) {
    ob_start();
    include_once('recipe' . $i . '.php');
    ob_end_clean();
    $pages[$i]['shortDesc'] = $shortDesc;
    $pages[$i]['title'] = strtoupper($title);
    $pages[$i]['cooking_time'] = $cooking_time;
    $pages[$i]['classes'][] = ($i % 2) ? 'odd' : 'even';
    $pages[$i]['link'] = 'recipe' . $i . '.php';
  }
  $pages[1]['classes'][] = 'first';
  $pages[3]['classes'][] = 'last';
  return $pages;
}

$current_page = "home";
$title = "Daily Recipe";
$image = "images/dailyrecipe_75x75.gif";
$description = "Daily Recipe is a Gigya demo site that uses Gigya's plugins and APIs. The site is intended for developers who want to understand how to implement Gigya.";
include("header.php");
?>
<div class="recipecontent">

  <div class="recipe-list">
    <ul class="pages">
      <?php $pages = getPages(); ?>
      <?php foreach ($pages as $key => $page): ?>
        <li class="<?php echo implode(' ', $page['classes']) ?>">
          <div class="page-summery">
            <a href="<?php echo $page['link'] ?>"><img class="image" src="images/hp/img<?php echo $key ?>.png"/></a>
            <div class="summery">
             <a href="<?php echo $page['link'] ?>"><h3 class="summery-title"><?php echo $page['title'] ?></h3></a>
              <div class="summery-desc"><?php echo $page['shortDesc'] ?></div>
              <a class="recipe-link" href="<?php echo $page['link']?>">Get the recipe</a>
              <div class="cooking-time Icon-Clock"><?php echo $page['cooking_time'] ?></div>
            </div>
          </div>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
  
  <!-- Ratings and Reviews -->
  <div class="rating-reviews">
    <div class="inner">
  	<h2 class="comments-title">Ratings and Reviews</h2>
    
    <!-- Render ratings -->
    <div id="ratings" class="ratings"></div>
    <?php render_ratings('ratings', $ratingsCategoryID, $current_page, 'reviews'); ?>
    <!-- Render reviews -->
    <div id="reviews" class="reviews"></div>
    <?php render_comments('reviews', $ratingsCategoryID, $current_page); ?>
    </div>
  </div>
</div>

<div class="sidebar">
  <?php include("sidebar.php"); ?>
</div>


<?php include("footer.php"); ?>


