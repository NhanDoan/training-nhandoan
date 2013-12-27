/**
 * Mobile JS 
 * This file implements the mobile version of the menu
 * User:
 * Date: 10/1/13
 * Time: 3:34 PM
 */

(function ($) {
  $(document).ready(function () {
    $('.mobile-menu').click(function (e) {
      e.preventDefault();
      $('.menu').toggle();
    });
  });
})(jQuery);
