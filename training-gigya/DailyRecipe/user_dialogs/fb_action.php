<?php
/**
 * Post "cook" action to Facebook dialog
 * This popup is triggered when the user presses the "Prepared It" button
 * User: yaniv
 * Date: 8/4/13
 * Time: 4:19 PM
 */


require_once('config.php');
global $title, $websiteName, $image;
$userdetails = fetchUserDetails('',$_SESSION['login']);
?>
<div class="fb-popup">
  <div class="fb-header">
    <img class="photo" src="<?php echo $image ?>" width="83px" height="63px">
    <div class="close"><a class="cls" href="#">close</a></div>
    <div class="fb-head-info">
      <span class="name"><?php echo $userdetails["First_Name"] ?> has prepared <?php echo $title ?></span>
      <div class="fb-site-name"><?php echo $websiteName ?></div>
      <div class="fb-page-url"><?php echo $_SERVER['SCRIPT_URI'] ?></div>
    </div>
  </div>
  <div class="fb-info">
    <textarea class="fb-info-text"  placeholder="What's on your mind?"></textarea>
    <div class="fb-tags">
      <div class="friends">
        <img class="friends-select" src="user_dialogs/images/fbdemo/Friends-tag-icon.png"/><div class="friends-list"><span class="fname"></span><span class="and"></span><span class="friends-num"></span></div>
      </div>
      <div class="locations">
        <img class="loc" src="user_dialogs/images/fbdemo/Location-Icon.png"/>
        <span class="location-select">
          <select>
            <option value="">Location</option>
            <option value="108424279189115">New York</option>
            <option value="114952118516947">San Francisco</option>
            <option value="110941395597405">Toronto</option>
            <option value="357568924326571">Tel Aviv</option>
          </select>
          </span>
      </div>
    </div>
    </div>
    <div class="post-to-fb">
      <div class="post sprite-fbAction-button_post_fb"><a href="#">Post to Facebook</a></div>
    </div>
  </div>
