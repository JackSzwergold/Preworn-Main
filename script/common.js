/**
 * Common (common.js)
 *
 * Programming: Jack Szwergold <JackSzwergold@gmail.com>
 *
 * Created: 2014-01-19, js
 * Version: 2014-01-19, js: creation
 *          2014-01-19, js: ...
 *
 */

(function($) {

$(document).ready(function() {

  var item = $('.PixelBoxWrapper');
  item.css({ marginTop: ($(window).height() / 2) - (item.outerHeight() / 2) });
  $(window).resize(function () {
    item.css({ marginTop: ($(window).height() / 2) - (item.outerHeight() / 2) });
  });

});
})(jQuery);