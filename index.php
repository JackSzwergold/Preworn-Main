<?php

/**
 * Preworn Index Controller (index.php)
 *
 * Programming: Jack Szwergold <JackSzwergold@gmail.com>
 *
 * Created: 2014-01-20, js
 * Version: 2014-01-20, js: creation
 *          2014-01-20, js: development & cleanup
 *          2014-02-16, js: adding configuration settings
 *          2014-02-16, js: adding controller logic
 *          2014-02-17, js: setting a 'base'
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
$markdown_parts = array();
$title_parts = array('preworn');

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
  $markdown_parts[] = $controller;
  $title_parts[] = $controller;
  if (empty($page)) {
    $markdown_parts[] = 'index';
  }
}

// Set the page.
if (!empty($controller) && !empty($page)) {
  $markdown_parts[] = $page;
  $title_parts[] = $page;
}

// Set the final markdown file path.
$markdown_file = 'markdown/' . join('/', $markdown_parts) . '.md';

if (!file_exists($markdown_file)) {
  $markdown_file = 'markdown/index.md';
  $title_parts = array('preworn');
}

// Set the page title.
$page_title = join(' / ', $title_parts);
$page_title = preg_replace('/_/', ' ', $page_title);

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
$frontendDisplayClass->setPageDescription('this site is jack szwergold’s the calling card, gallery, portfolio, playground, white wall, black box, idea sandbox &amp; daily distraction.');
$frontendDisplayClass->setPageContentMarkdown($markdown_file);
// $frontendDisplayClass->setPageContent('Hello world!');
$frontendDisplayClass->setPageViewport('width=device-width, initial-scale=0.4, maximum-scale=2, minimum-scale=0.4, user-scalable=yes');
$frontendDisplayClass->setPageRobots('noindex, nofollow');
// $frontendDisplayClass->setJavascripts(array('script/common.js'));
$frontendDisplayClass->setPageBase($page_base);
$frontendDisplayClass->initContent();


?>
