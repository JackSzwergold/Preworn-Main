<?php

/**
 * Frontend Display Helper Class (frontendDisplayHelper.class.php) (c) by Jack Szwergold
 *
 * Frontend Display Helper Class is licensed under a
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
// The beginnings of a front end display helper class.

class frontendDisplayHelper {

  private $controller_default = '';
  private $controller_select = '';
  private $page_base = '';
  private $page_base_suffix = '';
  private $page_title = '';
  private $count = 1;

  private $url_parts = array();
  private $VIEW_MODE = '';
  private $DEBUG_MODE = FALSE;
  private $html_content = '';
  private $json_content = '';

  //**************************************************************************************//
  // Set the default controller.
  public function setDefaultController ($value) {
    if (!empty($value)) {
      $this->controller_default = $value;
    }
  } // setDefaultController


 //**************************************************************************************//
  // Set the selected controller.
  public function setSelectedController ($value) {
    if (!empty($value)) {
      $this->controller_select = $value;
    }
  } // setSelectedController


  //**************************************************************************************//
  // Set the page base.
  public function setPageBase ($value) {
    if (!empty($value)) {
      $this->page_base = $value;
    }
  } // setPageBase


  //**************************************************************************************//
  // Set the page base.
  public function setPageBaseSuffix ($value) {
    if (!empty($value)) {
      $this->page_base_suffix = $value;
    }
  } // setPageBaseSuffix


  //**************************************************************************************//
  // Set the count.
  public function setCount ($value) {
    if (!empty($value)) {
      $this->count = $value;
    }
  } // setCount


  //**************************************************************************************//
  // Filter the view mode.
  public function filterViewMode ($mode = null, $mode_options) {

    if (!empty($mode) && $mode == 'random') {
      $mode_keys = array_keys($mode_options);
      shuffle($mode_keys);
      $mode = $mode_keys[0];
    }
    else if (!empty($mode) && !array_key_exists($mode, $mode_options)) {
      $mode = $this->controller_default;
    }

    return $mode;

  } // filterViewMode
  
  
  public function initContent ($DEBUG_MODE = FALSE) {

  } // initContent


  //**************************************************************************************//
  // Get the view mode.
  public function getViewMode () {
    return $this->VIEW_MODE;
  } // getViewMode


  //**************************************************************************************//
  // Get the page title.
  public function getPageTitle () {
    return $this->page_title;
  } // getPageTitle


  //**************************************************************************************//
  // Get the URL parts.
  public function getURLParts () {
    return $this->url_parts;
  } // getURLParts


  //**************************************************************************************//
  // Get the HTML content.
  public function getHTMLContent () {
    return $this->html_content;
  } // getHTMLContent


  //**************************************************************************************//
  // Get the JSON content.
  public function getJSONContent () {
    return $this->json_content;
  } // getJSONContent


} // frontendDisplayHelper

?>