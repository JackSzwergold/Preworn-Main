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

if ($_SERVER['SERVER_NAME'] == 'localhost') {
  define('BASE_PATH', '/Preworn-Main/');
}
else {
  define('BASE_PATH', '/');
}

/**************************************************************************************************/
// Define localized defaults.

$SITE_TITLE = 'Preworn';
$SITE_DESCRIPTION = 'This site is Jack Szwergold’s the technical calling card and portfolio.';
$SITE_URL = 'http://www.preworn.com/';
$SITE_COPYRIGHT = '(c) Copyright ' . date('Y') . ' Jack Szwergold. Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International License.';
$SITE_ROBOTS = 'noindex, nofollow';
$SITE_VIEWPORT = 'width=device-width, initial-scale=0.4, maximum-scale=2, minimum-scale=0.4, user-scalable=yes';

$AMAZON_INFO = array();
$AMAZON_INFO['short_name'] = 'amazon';
$AMAZON_INFO['url'] = 'http://www.amazon.com/?tag=preworn-20';
$AMAZON_INFO['description'] = 'Support me when you buy things on Amazon with this link.';

$PAYPAL_INFO = array();
$PAYPAL_INFO['short_name'] = 'paypal';
$PAYPAL_INFO['url'] = 'https://www.paypal.me/JackSzwergold';
$PAYPAL_INFO['description'] = 'Support me with a PayPal donation.';

$VALID_CONTROLLERS = array('controller');
$DISPLAY_CONTROLLERS = array('controller');

$VALID_GET_PARAMETERS = array('_debug', 'controller', 'page', 'section', 'subsection');

?>
