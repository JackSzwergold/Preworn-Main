<?php

/**
 * Frontend Display Helpers (frontendDisplayHelpers.php) (c) by Jack Szwergold
 *
 * Frontend Display Helpers is licensed under a
 * Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International License.
 *
 * You should have received a copy of the license along with this
 * work. If not, see <http://creativecommons.org/licenses/by-nc-sa/4.0/>.
 *
 * w: http://www.preworn.com
 * e: me@preworn.com
 *
 * Created: 2015-11-10, js
 * Version: 2015-11-10, js: creation
 *          2015-11-10, js: development
 *
 */

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

?>