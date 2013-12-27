<?php
require_once("config.php");

// The following method defines a UserAction object, which is used by some of the Gigya plugins 
//--------------------------------------------------------------------------------------------
function add_user_action($title, $pageUrl, $description, $imageUrl) {
  echo "<script>
    var defaultUserAction = new gigya.services.socialize.UserAction();
    defaultUserAction.setTitle('" . addslashes($title) . "');  // The title of the recipe page
    defaultUserAction.setLinkBack('" . $pageUrl . "');       // The page URL
    defaultUserAction.setDescription(\"" . addslashes($description) . "\");  // The description of the recipe page
    var shareimage = {
      href: '" . $pageUrl . "',
      src: '" . $imageUrl . "',			// The image of the recipe
      type: 'image'
    };
    defaultUserAction.addMediaItem(shareimage);
</script>";
}

// The following method presents Gigya's Reactions plugin:
//--------------------------------------------------------------------------------------------
function render_reactions($container_id, $bar_id) {
  echo "<script>
      // Define the Reaction buttons
      var textReactions = [
        {text: 'Recommend', ID: 'recommend', iconImgUp: 'images/reactions/Recommend.png', iconImgOver: 'images/reactions/Recommend_hover.png', tooltip: 'I recommend this recipe', feedMessage: 'I recommend this recipe!', headerText: 'You recommend this recipe,'}
        ,
        {text: 'Dislike', ID: 'dislike', iconImgUp: 'images/reactions/Dislike.png', iconImgOver: 'images/reactions/Dislike_hover.png', tooltip: 'I dislike this recipe', feedMessage: 'I dislike this recipe!', headerText: 'You dislike this recipe,'}
        ,
        {text: 'Delicious', ID: 'Delicious', iconImgUp: 'images/reactions/Delicious.png', iconImgOver: 'images/reactions/Delicious_hover.png', tooltip: 'This recipe is delicious', feedMessage: 'Delicious', headerText: 'You think this recipe is delicious,'}
        ,
        {text: 'Yuck', ID: 'yuck', iconImgUp: 'images/reactions/Yuck.png', iconImgOver: 'images/reactions/Yuck_hover.png', tooltip: 'This recipe is yucky', feedMessage: 'Yuck!', headerText: 'You think this recipe is yuck,'}
        ,
        {text: 'Innovative', ID: 'innovative', iconImgUp: 'images/reactions/Innovatice.png', iconImgOver: 'images/reactions/Innovatice_hover.png', tooltip: 'This recipe is innovative', userMessage: 'I think this recipe is innovative', headerText: 'You think this recipe is innovative,'}
      ];

      // Define the Reactions Plugin's params object
      var reactionParams = {
        barID: '" . $bar_id . "', //  Identifier of the content to which this reaction refers
        containerID: '" . $container_id . "',  // Reactions Plugin DIV Container
        reactions: textReactions,  // The reaction array from Step 1
        userAction: defaultUserAction,  // The UserAction object from Step 2
        bodyText: 'Share it with your friends:', // optional - text that appears in the Share popup
        showCounts: 'right', // optional - displays the counters on top of the buttons
        scope: 'both',
        privacy: 'public',
        showAlwaysShare: 'unchecked'
      };

      // Load the Reactions Plugin:
      gigya.services.socialize.showReactionsBarUI(reactionParams);
  </script>";
}

// The following method presents Gigya's Share-bar plugin:
//--------------------------------------------------------------------------------------------
function render_sharebar($container_id) {
  echo "<script>
      // Define the share buttons
      var shareButtons = [
          {
            'provider': 'Facebook',
            'iconImgUp': 'images/share_bar/Facebook.png' // override the default icon
          },
          {
            'provider': 'Twitter',
            'iconImgUp': 'images/share_bar/Twitter.png'
          },
           {
            'provider': 'Googleplus',
            'iconImgUp': 'images/share_bar/Google_Plus.png'
          },
          {
            'provider': 'LinkedIn',
            'iconImgUp': 'images/share_bar/LinkedIn.png'
          },
          {
            'provider': 'Messenger',
            'iconImgUp': 'images/share_bar/Messenger.png'
          },
          {
            'provider': 'digg',
            'iconImgUp': 'images/share_bar/Digg.png'
          },
         {
            'provider': 'share',
            'iconImgUp': 'images/share_bar/more_share.png'
          }
        ];
        
        // Define the Share Bar Plugin's params object
        var shareParams = {
		  userAction: defaultUserAction,
          showCounts: 'none',
          enabledProviders: '*,hyves,digg,aol',
          containerID: '" . $container_id . "',
          scope: 'both',
          privacy: 'public',
          iconsOnly: 'true',
          useEmailCaptcha: 'true', // Use a CAPTCHA mechanism when sending emails
		  shareButtons:shareButtons // list of providers  	
        };

        // Load the Share Bar Plugin:
        gigya.services.socialize.showShareBarUI(shareParams);

    </script>";
}


// The following method presents Gigya's Comments plugin:
//--------------------------------------------------------------------------------------------
function render_comments($container_id, $commentsCategoryID, $streamID) {
echo "<script>
var commentsParams = {
  categoryID: '" . $commentsCategoryID . "',
  containerID: '" . $container_id . "',
  streamID: '" . $streamID . "',
  scope: 'both',
  privacy: 'public',
  version: 2,
  deviceType: 'auto'
};
gigya.comments.showCommentsUI(commentsParams);
</script>";
}

// The following method presents Gigya's Ratings plugin:
//--------------------------------------------------------------------------------------------
function render_ratings($container_id, $categoryID, $streamID, $commentsUIid) {
echo "<script>
var params = {
  containerID: '" . $container_id . "',
  streamID: '" . $streamID . "',
  categoryID: '" . $categoryID . "',
  linkedCommentsUI:  '" . $commentsUIid . "'
}
gigya.comments.showRatingUI(params);
</script>";
}
