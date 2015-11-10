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
require_once BASE_FILEPATH . '/lib/Parsedown.php';

//**************************************************************************************//
// Set config options.

$DEBUG_OUTPUT_JSON = false;

//**************************************************************************************//
// Get the URL param & set the markdown file as well as the page title.

// Init the arrays.
$url_parts = array();
$markdown_parts = array();
$title_parts = array($SITE_TITLE);

// Parse the '$_GET' parameters.
foreach($VALID_GET_PARAMETERS as $get_parameter) {
  $$get_parameter = '';
  if (array_key_exists($get_parameter, $_GET) && !empty($_GET[$get_parameter])) {
    if (in_array($get_parameter, $VALID_GET_PARAMETERS)) {
      $$get_parameter = $_GET[$get_parameter];
    }
  }
}

// Set the controller.
if (!empty($controller)) {
  $url_parts[] = $controller;
  $markdown_parts[] = $controller;
  $title_parts[] = ucwords($controller);
  if (empty($page)) {
    $markdown_parts[] = 'index';
  }
}

// Set the page.
if (!empty($controller) && !empty($page)) {
  $url_parts[] = $page;
  $markdown_parts[] = $page;
  $title_parts[] = $page;
}

// Set the final markdown file path.
$markdown_file = 'markdown/' . join('/', $markdown_parts) . '.md';

if (!file_exists($markdown_file)) {
  $markdown_file = 'markdown/index.md';
  $title_parts = array($SITE_TITLE);
}

// Set the page title.
$page_title = join(' / ', $title_parts);
$page_title = ucwords(preg_replace('/_/', ' ', $page_title));

// Set the page base.
if (!empty($controller)) {
  $page_base = BASE_URL . $controller . '/';
}
else {
  $page_base = BASE_URL;
}

//**************************************************************************************//
// Init the "frontendDisplay()" class.

$frontendDisplayClass = new frontendDisplay('text/html', 'utf-8', FALSE, FALSE);
$frontendDisplayClass->setViewMode('mega');
$frontendDisplayClass->setPageTitle($page_title);
$frontendDisplayClass->setPageURL($SITE_URL . join('/', $url_parts));
$frontendDisplayClass->setPageCopyright($SITE_COPYRIGHT);
$frontendDisplayClass->setPageDescription($SITE_DESCRIPTION);
$frontendDisplayClass->setPageContentMarkdown($markdown_file);
// $frontendDisplayClass->setPageContent('Hello world!');
$frontendDisplayClass->setPageDivs($PAGE_DIVS_ARRAY);
// $frontendDisplayClass->setPageDivWrapper('PixelBoxWrapper');
$frontendDisplayClass->setPageViewport($SITE_VIEWPORT);
$frontendDisplayClass->setPageRobots($SITE_ROBOTS);
$frontendDisplayClass->setJavascripts($JAVASCRIPTS_ARRAY);
$frontendDisplayClass->setPageBase($page_base);
$frontendDisplayClass->setPageURLParts($markdown_parts);
$frontendDisplayClass->setAmazonInfo($AMAZON_INFO);
$frontendDisplayClass->setPayPalInfo($PAYPAL_INFO);
$frontendDisplayClass->initContent();


?>
