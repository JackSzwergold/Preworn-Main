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
  $markdown_parts = array();
  $title_parts = array($SITE_TITLE);

  // Parse the '$_GET' parameters.
  $params = array();
  foreach($VALID_GET_PARAMETERS as $get_parameter) {
    if (array_key_exists($get_parameter, $_GET) && !empty($_GET[$get_parameter])) {
      if (in_array($get_parameter, $VALID_GET_PARAMETERS)) {
        $params[$get_parameter] = $_GET[$get_parameter];
        $markdown_parts[$get_parameter] = $_GET[$get_parameter];
        $title_parts[$get_parameter] = ucwords($_GET[$get_parameter]);
      }
    }
  }

  // Assume the full path given is for an actual Markdown file.
  $markdown_file = '';
  if (count($markdown_parts) > 0) {
    $markdown_file = 'markdown/' . join('/', $markdown_parts) . '.md';
  }

  // If that full path for a file doens’t exist do the following.
  if (!file_exists($markdown_file)) {

    // For this test we are assuming of the file doesn’t exist, it might be a directory.
    $markdown_offset = 0;
    $markdown_file = 'markdown/' . join('/', $markdown_parts) . '/index.md';

    // Test if the file exists or not and test up the parent path tree.
    if (!file_exists($markdown_file)) {
      for ($markdown_offset = -1; $markdown_offset >= -count($markdown_parts); $markdown_offset--) {
        $markdown_sliced = array_slice($markdown_parts, 0, $markdown_offset);
        $markdown_file = 'markdown/' . join('/', $markdown_sliced) . '/index.md';
        if (file_exists($markdown_file)) {
          break;
        }
      }
    }

    // If the file doesn’t exist, just go to the next parent directory.
    if (count($markdown_parts) > 0 && file_exists($markdown_file)) {
      $markdown_sliced = array_slice($markdown_parts, 0, $markdown_offset);
      $redirect_path = join('/', $markdown_sliced);
      if ($markdown_offset < 0 && file_exists($markdown_file)) {
        header("HTTP/1.1 301 Moved Permanently");
        header('Location: ' . BASE_URL .  $redirect_path);
      }
    }

  }

  // Set the page title.
  $page_title = join(' / ', $title_parts);
  $page_title = preg_replace('/_/', ' ', $page_title);
  // $page_title = ucwords($page_title);

  // Silly hacks for silly logic that I need to clean up at some point.
  $controller = (array_key_exists('controller', $params) && !empty($params['controller'])) ? $params['controller'] : '';
  $page = (array_key_exists('page', $params) && !empty($params['page'])) ? $params['page'] : '';
  $url_parts = $params;

  return array($controller, $page, $page_title, $url_parts, $markdown_parts, $markdown_file);

} // parse_parameters

//**************************************************************************************//
// Run the actual function and get the parts.

list($controller, $page, $page_title, $url_parts, $markdown_parts, $markdown_file) = parse_parameters($SITE_TITLE, $VALID_GET_PARAMETERS);

?>