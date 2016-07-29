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
require_once BASE_FILEPATH . '/lib/frontendDisplayHelper.class.php';
require_once BASE_FILEPATH . '/lib/requestFiltering.class.php';
require_once BASE_FILEPATH . '/lib/markdownHelper.class.php';
require_once BASE_FILEPATH . '/lib/Spyc.php';

//**************************************************************************************//
// Manage the request filering stuff.

$requestFilteringClass = new requestFiltering();
$params = $requestFilteringClass->process_parameters();
$DEBUG_MODE = $requestFilteringClass->process_debug_mode($params);
$JSON_MODE = $requestFilteringClass->process_json_mode($params);
$page_base_suffix = $requestFilteringClass->process_page_base_suffix($JSON_MODE);

$url_parts = $requestFilteringClass->process_url_parts($params);
$controller = $requestFilteringClass->process_controllers($url_parts);
$page_base = $requestFilteringClass->process_page_base($controller);

//**************************************************************************************//
// Now move onto the markdown helper stuff.

$markdownHelperClass = new markdownHelper();
$markdown_file = $markdownHelperClass->process_markdown_file($params);
$page_title = $markdownHelperClass->process_page_title($params);

//**************************************************************************************//
// Now deal with the front end display helper class related stuff.

$frontendDisplayHelperClass = new frontendDisplayHelper();
$frontendDisplayHelperClass->setController($controller);
$frontendDisplayHelperClass->setPageBase($page_base);
$frontendDisplayHelperClass->setPageBaseSuffix($page_base_suffix);
$frontendDisplayHelperClass->setCount(array_key_exists('count', $params) ? $params['count'] : 1);
$frontendDisplayHelperClass->initContent($DEBUG_MODE);

// $VIEW_MODE = $frontendDisplayHelperClass->getViewMode();
// $page_title = $frontendDisplayHelperClass->getPageTitle();
// $url_parts = $frontendDisplayHelperClass->getURLParts();
$html_content = $frontendDisplayHelperClass->getHTMLContent();
$json_content = $frontendDisplayHelperClass->getJSONContent();

//**************************************************************************************//
// Init the front end display class and set other things.

$frontendDisplayClass = new frontendDisplay();
$frontendDisplayClass->setJSONMode($JSON_MODE);
$frontendDisplayClass->setDebugMode($DEBUG_MODE);
$frontendDisplayClass->setContentType(($JSON_MODE ? 'application/json' : 'text/html'));
$frontendDisplayClass->setCharset('utf-8');
$frontendDisplayClass->setViewMode($VIEW_MODE);
$frontendDisplayClass->setPageTitle($page_title);
$frontendDisplayClass->setPageURL($SITE_URL . implode('/', $url_parts));
$frontendDisplayClass->setPageCopyright($SITE_COPYRIGHT);
$frontendDisplayClass->setPageLicense($SITE_LICENSE);
$frontendDisplayClass->setPageDescription($SITE_DESCRIPTION);
$frontendDisplayClass->setPageKeyword($SITE_KEYWORD);
$frontendDisplayClass->setPageImage($SITE_URL . $SITE_IMAGE);
$frontendDisplayClass->setPageFBAdmins($SITE_FB_ADMINS);
$frontendDisplayClass->setPageContentMarkdown($markdown_file);
$frontendDisplayClass->setPageDivs($PAGE_DIVS_ARRAY);
$frontendDisplayClass->setPageDivWrapper();
$frontendDisplayClass->setPageViewport($SITE_VIEWPORT);
$frontendDisplayClass->setPageRobots($SITE_ROBOTS);
$frontendDisplayClass->setJavaScriptItems($JAVASCRIPTS_ITEMS);
$frontendDisplayClass->setLinkItems($LINK_ITEMS);
$frontendDisplayClass->setFaviconItems($FAVICONS);
$frontendDisplayClass->setPageBase($page_base . $page_base_suffix);
$frontendDisplayClass->setPageURLParts($params);
// $frontendDisplayClass->setPaymentInfo($PAYMENT_INFO);
$frontendDisplayClass->setSocialMediaInfo($SOCIAL_MEDIA_INFO);
$frontendDisplayClass->setAdBanner($AMAZON_RECOMMENDATION);

//**************************************************************************************//
// Init the core content and set the header and footer items..

// Set the core content.
$frontendDisplayClass->initCoreContent();

// Set the header.
$navigation = $frontendDisplayClass->setNavigation();
$frontendDisplayClass->setBodyHeader($navigation);

// Set the footer.
$ad_banner = $frontendDisplayClass->setAdBannerFinal();
$frontendDisplayClass->setBodyFooter($ad_banner);

//**************************************************************************************//
// Init and display the final content.

$frontendDisplayClass->initHTMLContent();

?>
