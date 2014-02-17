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
// Get the URL param & set the markdown file.

$markdown_parts = array();

if (array_key_exists('controller', $_GET) && !empty($_GET['controller'])) {
  if (in_array('controller', $VALID_CONTROLLERS)) {
    $markdown_parts[] = $_GET['controller'];
  }
}
else {
    $markdown_parts[] = 'index';
}

if (array_key_exists('page', $_GET) && !empty($_GET['page'])) {
  $markdown_parts[] = $_GET['page'];
}

$markdown_file = 'markdown/' . join('/', $markdown_parts) . '.md';

//**************************************************************************************//
// Init the "frontendDisplay()" class.

$frontendDisplayClass = new frontendDisplay('text/html', 'utf-8', FALSE, FALSE);
$frontendDisplayClass->setViewMode('mega');
$frontendDisplayClass->setPageTitle('preworn');
$frontendDisplayClass->setPageDescription('this site is jack szwergold’s the calling card, gallery, portfolio, playground, white wall, black box, idea sandbox &amp; daily distraction.');
$frontendDisplayClass->setPageContentMarkdown($markdown_file);
// $frontendDisplayClass->setPageContent('Hello world!');
$frontendDisplayClass->setPageViewport('width=device-width, initial-scale=0.4, maximum-scale=2, minimum-scale=0.4, user-scalable=yes');
$frontendDisplayClass->setPageRobots('noindex, nofollow');
// $frontendDisplayClass->setJavascripts(array('script/common.js'));
$frontendDisplayClass->initContent();


?>
