<div class="box">

  <!-- Follow Bar -->
  <div class="box-content follow-bar">
    <div style="text-align: right;" id="FollowBar"></div>
  </div>
  <br>
  <script>
    (function () {
      // Define the Follow Bar plugin's params object
      var followBarParams = {
        containerID: 'FollowBar',
        iconSize: 42,
        buttons: [
          {    provider: 'facebook',
            actionURL: 'https://www.facebook.com/gigya',
            action: 'dialog',
            iconURL: 'images/follow_bar/Facebook_on_follow.png'
          },
          {    provider: 'twitter',
            followUsers: 'gigya, gigyaDev',
            action: 'dialog',
            iconURL: 'images/follow_bar/Twitter_on_follow.png'
          },
          {    provider: 'googleplus',
            action: 'dialog',
            iconURL: 'images/follow_bar/Google+_on_follow.png'
          },
          {    provider: 'rss',
            actionURL: 'http://blog.gigya.com/',
            action: 'window',
            title: 'Subscribe via RSS',
            iconURL: 'images/follow_bar/Rss_hover_follow.png'
          },
          {    provider: 'linkedin',
            actionURL: 'http://www.linkedin.com/company/gigya',
            action: 'window',
            title: 'Gigya on Linkedin',
            iconURL: 'images/follow_bar/Linkedin_hover_follow.png'
          }
        ]
      };
      // Load the Follow Bar plugin:
      gigya.services.socialize.showFollowBarUI(followBarParams);
    }());
  </script>

  <!-- Game Mechanics box start -->
  <div class="game-mechanics gigya-plugin">
    <div class="gigya-plugin-head">
      <span class="head-text">User Community</span>
    </div>
    <div class="gm-plugins">
      <div class="gm-plugin" id="divUserStatus"></div>
      <div class="gm-plugin" id="divAchiements"></div>
      <div class="gm-plugin" id="divLeaderboard"></div>
    </div>
    <script>

      var userStatusUA = new gigya.services.socialize.UserAction();

      userStatusUA.setTitle('$levelTitle');
      userStatusUA.setDescription('Challenge title: $challengeTitle  level title: $levelTitle | challange description: $challengeDescription  level Description: $levelDescription');
      userStatusUA.addImage('$badgeURL');
      var userStatusParams = {
        containerID: 'divUserStatus',
        userAction: userStatusUA,
        shareParams: {
          showEmailButton: true
        },
        width: 293
      }
      var achievmentsParams = {
        containerID: 'divAchiements',
        width: 293
      }
      var leaderboardParams = {
        containerID: 'divLeaderboard',
        period: 'all',
        width: 293
      }

      gigya.services.gm.showNotifications({debugMode: false});
      gigya.services.gm.showUserStatusUI(userStatusParams);
      gigya.services.gm.showAchievementsUI(achievmentsParams);
      gigya.services.gm.showLeaderboardUI(leaderboardParams);

    </script>
  </div>
  <!--  Game Mechanics end -->

  <!-- Activity Feed plugin -->
  <div class="activity-feed gigya-plugin">
    <div class="gigya-plugin-head">
      <span class="head-text">Recent Activities</span>
    </div>
    <div class="box-content">
      <div id="ActivityFeed"></div>
    </div>
    <script>
        gigya.services.socialize.showFeedUI({containerID: 'ActivityFeed', width: "293", height: "271"});
    </script>
  </div>

  <!-- Advertisement -->
  <div class="ad">
    &nbsp;
  </div>
  <div class="ad">
    <a href="http://www.gigya.com" target="_blank"><img src="images/300x250_myoss_3frames.gif" height="250"
                                                        width="300"/></a>
  </div>
  <!-- ?php if (strpos($_SERVER['PHP_SELF'], 'index.php')) echo '<div><iframe src="http://www.facebook.com/plugins/like.php?app_id=165769706818801&amp;href=demo.gigya.com&amp;send=true&amp;layout=standard&amp;width=450&amp;show_faces=true&amp;action=recommend&amp;colorscheme=light&amp;font&amp;height=80" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:300px; height:80px;" allowTransparency="true"></iframe></div>'; ?-->

</div>
