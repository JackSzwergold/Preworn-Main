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
// Require the basics.

require_once BASE_FILEPATH . '/lib/Parsedown.php';

//**************************************************************************************//
// Set the mode.

$mode = 'mega';

//**************************************************************************************//
// Here is the function to parse the parameters.

function parse_parameters ($SITE_TITLE, $VALID_GET_PARAMETERS) {

  // Init the arrays.
  $url_parts = array();
  $markdown_parts = array();
  $title_parts = array($SITE_TITLE);
  $markdown_file = '';

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
  if (count($markdown_parts) > 0) {
    $markdown_file = 'markdown/' . join('/', $markdown_parts) . '.md';
  }

  // Check of the final markdown file exists.
  if (!file_exists($markdown_file)) {

    // If the file doesn’t exist, just go to the next parent directory.
    $markdown_file = 'markdown/' . join('/', array_slice($markdown_parts, 0, -1)) . '/index.md';

    // This might no longer be needed.
    if (TRUE) {
      // Set the title.
      $title_parts = array($SITE_TITLE);
      if (!empty($controller)) {
        $title_parts[] = ucwords($controller);
      }
    }

    // If the file doesn’t exist, just go to the next parent directory.
    if (count($markdown_parts) > 0 && file_exists($markdown_file)) {
      // header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
      header("HTTP/1.1 301 Moved Permanently");
      header('Location: ' . BASE_URL . join('/', array_slice($markdown_parts, 0, -1)));
    }

    // And if that parent directory doesn’t exist, just bounce back to the base URL of the site.
    if (!file_exists($markdown_file)) {
      // header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
      header("HTTP/1.1 301 Moved Permanently");
      header('Location: ' . BASE_URL);
    }

  }

  // Set the page title.
  $page_title = join(' / ', $title_parts);
  $page_title = preg_replace('/_/', ' ', $page_title);
  // $page_title = ucwords($page_title);

  return array($controller, $page, $page_title, $url_parts, $markdown_parts, $markdown_file);

} // parse_parameters

//**************************************************************************************//
// Run the actual function and get the parts.

list($controller, $page, $page_title, $url_parts, $markdown_parts, $markdown_file) = parse_parameters($SITE_TITLE, $VALID_GET_PARAMETERS);

?>