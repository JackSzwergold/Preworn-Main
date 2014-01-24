<?php

/**
 * Preworn Index Controller (index.php)
 *
 * Programming: Jack Szwergold <JackSzwergold@gmail.com>
 *
 * Created: 2014-01-20, js
 * Version: 2014-01-20, js: creation
 *          2014-01-20, js: development & cleanup
 *
 */

//**************************************************************************************//
// Require the basic configuration settings & functions.

require_once 'common/functions.inc.php';
require_once 'lib/frontendDisplay.class.php';
require_once 'lib/Parsedown.php';


//**************************************************************************************//
// Define the valid arrays.

$VALID_CONTROLLERS = array('portfolio');
$DISPLAY_CONTROLLERS = array('portfolio');
$VALID_GET_PARAMETERS = array('_debug', 'portfolio');
$VALID_CONTENT_TYPES = array('application/json','text/plain','text/html');
$VALID_CHARSETS = array('utf-8','iso-8859-1','cp-1252');

//**************************************************************************************//
// Set config options.

$DEBUG_OUTPUT_JSON = false;

//**************************************************************************************//
// Init the "frontendDisplay()" class.

$frontendDisplayClass = new frontendDisplay('text/html', 'utf-8', FALSE, FALSE);
$frontendDisplayClass->setViewMode('mega');
$frontendDisplayClass->setPageTitle('preworn');
$frontendDisplayClass->setPageDescription('this site is jack szwergold’s the calling card, gallery, portfolio, playground, white wall, black box, idea sandbox &amp; daily distraction.');
$frontendDisplayClass->setPageContentMarkdown('index.md');
$frontendDisplayClass->initContent();


?>
