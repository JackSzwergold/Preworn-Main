<?php

/**
 * Local Config File (local.inc.php) (c) by Jack Szwergold
 *
 * Local Config File is licensed under a
 * Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International License.
 *
 * You should have received a copy of the license along with this
 * work. If not, see <http://creativecommons.org/licenses/by-nc-sa/4.0/>.
 *
 * w: http://www.preworn.com
 * e: me@preworn.com
 *
 * Created: 2014-02-16, js
 * Version: 2014-02-16, js: creation
 *          2014-02-16, js: development & cleanup
 *
 */

/**************************************************************************************************/
// Define localized defaults.

// Set the base URL path.
if ($_SERVER['SERVER_NAME'] == 'localhost') {
  define('BASE_PATH', '/Preworn-Main/');
}
else {
  define('BASE_PATH', '/');
}

// Set the view mode.
// $VIEW_MODE = 'mega';
$VIEW_MODE = null;

// Site descriptive info.
$SITE_TITLE = 'Preworn';
$SITE_DESCRIPTION = 'This site is Jack Szwergold’s technical portfolio and calling card.';
$SITE_URL = 'http://www.preworn.com/';
$SITE_COPYRIGHT = '(c) Copyright ' . date('Y') . ' Jack Szwergold. Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International License.';
$SITE_ROBOTS = 'noindex, nofollow';
$SITE_VIEWPORT = 'width=device-width, initial-scale=0.4, maximum-scale=2, minimum-scale=0.4, user-scalable=yes';
$SITE_IMAGE = 'favicons/icon_200x200.png';
$SITE_FB_ADMINS = '504768652';

// Favicon info.
$FAVICONS = array();
$FAVICONS['standard']['rel'] = 'icon';
$FAVICONS['standard']['type'] = 'image/png';
$FAVICONS['standard']['href'] = 'favicons/favicon.ico';
$FAVICONS['opera']['rel'] = 'icon';
$FAVICONS['opera']['type'] = 'image/png';
$FAVICONS['opera']['href'] = 'favicons/speeddial-160px.png';
$FAVICONS['iphone']['rel'] = 'apple-touch-icon-precomposed';
$FAVICONS['iphone']['href'] = 'favicons/apple-touch-icon-57x57-precomposed.png';
$FAVICONS['iphone4_retina']['rel'] = 'apple-touch-icon-precomposed';
$FAVICONS['iphone4_retina']['sizes'] = '114x114';
$FAVICONS['iphone4_retina']['href'] = 'favicons/apple-touch-icon-114x114-precomposed.png';
$FAVICONS['ipad']['rel'] = 'apple-touch-icon-precomposed';
$FAVICONS['ipad']['sizes'] = '72x72';
$FAVICONS['ipad']['href'] = 'favicons/apple-touch-icon-72x72-precomposed.png';
    
// Payment info.
$PAYMENT_INFO = array();
// $PAYMENT_INFO['amazon']['short_name'] = 'Amazon';
// $PAYMENT_INFO['amazon']['emoji'] = '🎥📚📀';
// $PAYMENT_INFO['amazon']['url'] = 'http://www.amazon.com/?tag=preworn-20';
// $PAYMENT_INFO['amazon']['description'] = 'Support me when you buy things on Amazon with this link.';
// $PAYMENT_INFO['paypal']['short_name'] = 'PayPal';
// $PAYMENT_INFO['paypal']['emoji'] = '💰💸💳';
// $PAYMENT_INFO['paypal']['url'] = 'https://www.paypal.me/JackSzwergold';
// $PAYMENT_INFO['paypal']['description'] = 'Support me with a PayPal donation.';

// Social media info.
$SOCIAL_MEDIA_INFO = array();
$SOCIAL_MEDIA_INFO['instagram']['short_name'] = 'Instagram';
$SOCIAL_MEDIA_INFO['instagram']['emoji'] = '📸';
$SOCIAL_MEDIA_INFO['instagram']['url'] = 'https://www.instagram.com/jackszwergold/';
$SOCIAL_MEDIA_INFO['twitter']['short_name'] = 'Twitter';
$SOCIAL_MEDIA_INFO['twitter']['emoji'] = '🐦';
$SOCIAL_MEDIA_INFO['twitter']['url'] = 'https://twitter.com/jackszwergold/';

// Ad info.
$AMAZON_AD_468X60 = '<iframe src="//rcm-na.amazon-adsystem.com/e/cm?o=1&p=13&l=ez&f=ifr&linkID=1c6a1177fa3fdbc8199838d723f94324&t=preworn-20&tracking_id=preworn-20" width="468" height="60" style="border: none;"></iframe>';
$AMAZON_AD_728X90 = '<iframe src="//rcm-na.amazon-adsystem.com/e/cm?o=1&p=48&l=ur1&category=amazonhomepage&f=ifr&linkID=fed6cd5c49cfa40a0d42c588facc1502&t=preworn-20&tracking_id=preworn-20" width="728" height="90" style="border: none;"></iframe>';

// Set the page DIVs array.
$PAGE_DIVS_ARRAY = array();
$PAGE_DIVS_ARRAY[] = 'Wrapper';
$PAGE_DIVS_ARRAY[] = 'Content';

// Set the JavaScript array.
$JAVASCRIPTS_ITEMS = array();
// $JAVASCRIPTS_ITEMS[] = 'script/json2.js';
// $JAVASCRIPTS_ITEMS[] = 'script/jquery/jquery-1.11.3.min.js';
// $JAVASCRIPTS_ITEMS[] = 'script/jquery/jquery-1.11.3.min.map';
// $JAVASCRIPTS_ITEMS[] = 'script/jquery/jquery.noconflict.js';

// Set the CSS array.
$CSS_ITEMS = array();
$CSS_ITEMS[] = 'css/style.css';
$CSS_ITEMS[] = 'css/colors.css';

// Set the controller and parameter stuff.
$VALID_CONTROLLERS = array('controller');
$DISPLAY_CONTROLLERS = array('controller');
$VALID_GET_PARAMETERS = array('_debug', 'controller', 'page', 'section', 'subsection');

?>
