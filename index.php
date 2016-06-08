<?php

/**
 * Index Controller (index.php) (c) by Jack Szwergold
 *
 * Index Controller is licensed under a
 * Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International License.
 *
 * You should have received a copy of the license along with this
 * work. If not, see <http://creativecommons.org/licenses/by-nc-sa/4.0/>.
 *
 * w: http://www.preworn.com
 * e: me@preworn.com
 *
 * Created: 2014-01-20, js
 * Version: 2014-01-20, js: creation
 *          2014-01-20, js: development & cleanup
 *          2014-02-16, js: adding configuration settings
 *          2014-02-16, js: adding controller logic
 *          2014-02-17, js: setting a 'base'
 *          2014-03-02, js: adding a better page URL
 *
 */

//**************************************************************************************//
// Require the basic configuration settings & functions.

require_once 'conf/conf.inc.php';
require_once BASE_FILEPATH . '/common/functions.inc.php';
require_once BASE_FILEPATH . '/lib/frontendDisplay.class.php';
require_once BASE_FILEPATH . '/lib/contentCreation.class.php';
require_once BASE_FILEPATH . '/lib/Spyc.php';

//**************************************************************************************//
// Init the "contentCreation()" class.

$contentCreationClass = new contentCreation();
list($params, $page_title, $markdown_file) = $contentCreationClass->init();

//**************************************************************************************//
// Set the debug mode value.

$DEBUG_MODE = array_key_exists('_debug', $params);

//**************************************************************************************//
// Set the JSON mode value.

$JSON_MODE = array_key_exists('json', $params);

//**************************************************************************************//
// Set the page base.

$page_base = BASE_URL;
$controller = 'small';
if (array_key_exists('controller', $params) && !empty($params['controller']) && $params['controller'] != 'index') {
  $controller = $params['controller'];
  $page_base = BASE_URL . $params['controller'] . '/';
}

//**************************************************************************************//
// Set the query suffix to the page base.

$page_base_suffix = $JSON_MODE ? '?json' : '';

//**************************************************************************************//
// Init the front end display class and set other things.

$frontendDisplayClass = new frontendDisplay();
$frontendDisplayClass->setJSONMode($JSON_MODE);
$frontendDisplayClass->setDebugMode($DEBUG_MODE);
$frontendDisplayClass->setContentType(($JSON_MODE ? 'application/json' : 'text/html'));
$frontendDisplayClass->setCharset('utf-8');
$frontendDisplayClass->setViewMode($VIEW_MODE);
$frontendDisplayClass->setPageTitle($page_title);
$frontendDisplayClass->setPageURL($SITE_URL . join('/', $params));
$frontendDisplayClass->setPageCopyright($SITE_COPYRIGHT);
$frontendDisplayClass->setPageDescription($SITE_DESCRIPTION);
$frontendDisplayClass->setPageContentMarkdown($markdown_file);
$frontendDisplayClass->setPageDivs($PAGE_DIVS_ARRAY);
$frontendDisplayClass->setPageDivWrapper();
$frontendDisplayClass->setPageViewport($SITE_VIEWPORT);
$frontendDisplayClass->setPageRobots($SITE_ROBOTS);
$frontendDisplayClass->setJavaScriptItems($JAVASCRIPTS_ITEMS);
$frontendDisplayClass->setCSSItems($CSS_ITEMS);
$frontendDisplayClass->setFaviconItems($FAVICONS);
$frontendDisplayClass->setPageBase($page_base . $page_base_suffix);
$frontendDisplayClass->setPageURLParts($params);
$frontendDisplayClass->setPaymentInfo($PAYMENT_INFO);

//**************************************************************************************//
// Init header and footer stuff.

$nameplate = $frontendDisplayClass->setNameplate();
$frontendDisplayClass->setBodyHeader($nameplate);
$amazon_ad_468x60 = '<iframe src="//rcm-na.amazon-adsystem.com/e/cm?o=1&p=13&l=ez&f=ifr&linkID=feede769df2856e2565b6b6685a88b80&t=preworn-20&tracking_id=preworn-20" width="468" height="60" scrolling="no" border="0" marginwidth="0" style="border:none;" frameborder="0"></iframe>';
$frontendDisplayClass->setBodyFooter($amazon_ad_468x60 . '<br /><br />');

//**************************************************************************************//
// Init the content.

$frontendDisplayClass->initContent();

?>
