<?php 
$current_page = "about";
$title = "About this Site - Developer's page";
$image = "images/dailyrecipe_75x75.gif";
$description = "Daily Recipe is a Gigya demo site that uses Gigya's plugins and APIs. The site is intended for developers who want to understand how to implement Gigya.";
include("header.php");
require_once("plugins.php");

?>
<div class="recipecontentAbout">
	<div class="caption">
		<h1><?php echo $title ?></h1>
	</div>
	<br/>
	<div class="reaction-wrap">
		<p class="shareText">What do you think of this demo site?</p>
		<div id=reactionsDiv></div>
	</div>
  <!-- Add user action to be used in reactions plugin and share bar -->
  <?php add_user_action($title, $pageURL, $description, $imageUrl); ?>
  <script>
  (function(){
  // Adding Reactions Plugin
  // Define reactions array
  var textReactions=[
  {text: 'Must read',ID: 'mustread', iconImgUp:'http://cdn.gigya.com/gs/i/reactions/icons/MustRead_Icon_Up.png',iconImgOver:'http://cdn.gigya.com/gs/i/reactions/icons/MustRead_Icon_Down.png',tooltip:'Must read this page',feedMessage: 'Must read this!', headerText:'You think this page must be read,' }
  ,{text: 'Inspiring', ID: 'inspiring', iconImgUp:'http://cdn.gigya.com/gs/i/reactions/icons/Inspiring_Icon_Up.png', iconImgOver:'http://cdn.gigya.com/gs/i/reactions/icons/Inspiring_Icon_Down.png', tooltip:'This demo is inspiring', feedMessage: 'Inspiring!', headerText:'You think this demo is inspiring,'}
  ,{text: 'Dislike', ID: 'dislike', iconImgUp:'http://cdn.gigya.com/gs/i/reactions/icons/Dislike_Icon_Up.png', iconImgOver:'http://cdn.gigya.com/gs/i/reactions/icons/Dislike_Icon_Down.png', tooltip:'I dislike this demo', feedMessage: 'I dislike this demo!', headerText:'You dislike this demo,'}
  ,{text: 'Aged',ID: 'aged', iconImgUp:'http://cdn.gigya.com/gs/i/reactions/icons/Aged_Icon_Up.png',iconImgOver:'http://cdn.gigya.com/gs/i/reactions/icons/Aged_Icon_Down.png', tooltip:'This demo is aged',feedMessage: 'Aged',headerText:'You think this demo is aged,'}
  ];

  // Define the Reactions Plugin's params object
  var reactionParams ={
  barID: 'about', //  Identifier of the content to which this reaction refers
  containerID: 'reactionsDiv',  // Reactions Plugin DIV Container
  reactions: textReactions,  // The reaction array defiened above
  userAction: defaultUserAction,  // The UserAction object defiened above
  bodyText: 'Share it with your friends:', // optional - text that appears in the Share popup
  showCounts: 'right', // optional - displays the counters on the right side of the buttons
  scope:'both',
  privacy:'public',
  cid:'',
  showAlwaysShare: 'unchecked'
  };

  // Load the Reactions Plugin:
  gigya.services.socialize.showReactionsBarUI(reactionParams);
  }());
</script>
	<br/>
	<div class="about ui-helper-clearfix">
		<h2>Overview</h2>
		The Daily Recipe site is <a href="http://www.gigya.com" target="_blank">Gigya's</a> demo site written in <a href="http://PHP.net/" target="_blank">PHP</a> and Javascript. This demo outlines how to make a web site social using Gigya's platform. <br/>
		The demo site's code is available for you to <a href="http://wikifiles.gigya.com/DemoSite/DailyRecipe.zip" target="_blank">download</a>, <a href="http://developers.gigya.com/010_Developer_Guide/95_Demo_Site#Installing_the_Site_on_Your_Own_Host" target="_blank">install</a> and learn about the <a href="http://developers.gigya.com/010 Developer Guide/95 Demo Site/Site Implementation" target="_blank">site implementation</a>. <br/>
		Gigya provides a large array of features for sites and this sample site makes use of only a few of those capabilities. Some of the features that are used in this site:
			<ul>
		        <li><strong>Social Login:</strong>
		           	<br/>Social login and registration; Manages account linking between user's existing site account and social identities; 		           	
		          	<img src="images/login-overview.jpg" align="right"/>
		           	<br/>Connect to more than 20 social and identity providers like Facebook, Twitter, LinkedIn, Google, Yahoo, Paypal and Messenger; Enables access to rich profile data including email addresses; Provides standardized data field structure and nomenclature across identity providers.
		           	<br/><br/>
		        </li>
		        <li><strong>Social Plugins:</strong><br/>
					<table cellspacing="8" cellpadding="0" border="0" >
					    <tbody>
						    <tr style="vertical-align:top">
								<td><img src="images/reactions-overview.jpg"/> </td>
								<td><strong>Reactions:</strong><br/>A set of customizable buttons to capture user reactions and drive sharing to social networks with a single click.</td>
								<td colspan="3">&nbsp;</td>
								<td><img src="images/comments-overview.jpg"/> </td>
								<td><strong>Comments:</strong><br/>Enables site commenting integrated with social publishing and authentication, plus administrative tools and controls.</td>
							</tr>
					        <tr>
					            <td colspan="7">&nbsp;</td>
					        </tr>
			        		<tr style="vertical-align:top">
								<td><img src="images/sharebar-overview.jpg" /></td>
								<td><strong>Share Bar:</strong><br/>A set of Share buttons with counters for sharing and bookmarking to social networks.</td>
								<td colspan="3">&nbsp;</td>
								<td><img src="images/activityfeed-overview.jpg" /> </td>
								<td><strong>Activity feed:</strong><br/>Displays a real-time stream of user activity on site.</td>
							</tr>
					        <tr>
					          	<td colspan="7">&nbsp;</td>
					        </tr>
			        		<tr style="vertical-align:top">
								<td><img src="images/gm-overview.gif" /></td>
								<td><strong>Game Mechanics:</strong><br/>Social loyalty and rewards platform, increasing site engagement and making users' experience more enjoyable.</td>
								<td colspan="3">&nbsp;</td>
								<td><img src="images/followbar-overview.jpg" /> </td>
								<td><strong>Follow Bar:</strong><br/>Displays a bar of "follow" buttons.</td>
							</tr>
					        <tr>
					            <td colspan="7">&nbsp;</td>
					        </tr>
			        		<tr style="vertical-align:top">
								<td><img src="images/r&r-overview.gif" /></td>
								<td><strong>Rating & Reviews:</strong><br/>Easy way to provide feedback on products, fully customizable design and SEO friendly.</td>
								<td colspan="5">&nbsp;</td>
							</tr>
					    </tbody>
					</table>
		        </li> 
		    </ul>		
		
		<h2>Download Sources</h2>
		Please find the sources of the Daily Recipe Site <a href="http://wikifiles.gigya.com/DemoSite/DailyRecipe.zip">here</a>.
		<br/><br/>
		<h2>Learn More</h2>
		To learn about the site implementation, how to install the site and more please refer to <a href="http://developers.gigya.com/010_Developer_Guide/95_Demo_Site" target="_blank">Gigya's Demo Site Guide</a>.
		<br/><br/>
	</div>


	<!-- Share Bar Plugin DIV Container -->
	<div class="share-wrap ui-helper-clearfix" >
		<p class="shareText">Share this page with your friends</p>
		<div id="shareButtons" ></div>
	</div>
  <!-- Add the Share Bar script -->
  <?php render_sharebar('shareButtons');?>
  
  <!-- Ratings and Reviews div -->
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
	
<?php include("footer.php"); ?>