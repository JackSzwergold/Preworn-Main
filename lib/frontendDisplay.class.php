<?php

/**
 * Frontend Display Class (frontendDisplay.class.php) (c) by Jack Szwergold
 *
 * Frontend Display Class is licensed under a
 * Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International License.
 *
 * You should have received a copy of the license along with this
 * work. If not, see <http://creativecommons.org/licenses/by-nc-sa/4.0/>.
 *
 * w: http://www.preworn.com
 * e: me@preworn.com
 *
 * Created: 2014-01-22, js
 * Version: 2014-01-22, js: creation
 *          2014-01-22, js: development & cleanup
 *          2014-01-23, js: refinements
 *          2014-02-17, js: setting a 'base'
 *          2014-02-27, js: adding a page URL
 *          2015-05-10, js: adding DIV wrapper class & id
 *          2015-05-11, js: setting dynamic DIV wrapper creation
 *
 */

//**************************************************************************************//
// The beginnings of a frontend display class.

class frontendDisplay {

  private $DEBUG_MODE = FALSE;
  private $JSON_MODE = FALSE;

  private $html_content;
  private $json_content;

  private $content_type = 'text/html';
  private $charset = 'utf-8';
  private $doctype = 'html5';

  private $json_encode = FALSE;
  private $json_via_header = FALSE;

  private $javascripts = array();
  private $css = array();

  private $base = NULL;
  private $page_depth = 0;
  private $markdown_parts = array();

  private $view_mode = NULL;
  private $page_url = NULL;
  private $page_copyright = NULL;
  private $page_license = NULL;
  private $page_title = NULL;
  private $page_title_short = NULL;
  private $page_description = NULL;
  private $page_content = NULL;
  private $page_image = NULL;
  private $page_keyword = NULL;

  private $header_content = NULL;
  private $footer_content = NULL;

  private $page_div_wrapper_class = NULL;
  private $page_div_wrapper_id = NULL;
  private $page_div_wrappper_array = array();

  private $page_viewport = NULL;
  private $page_robots = NULL;

  private $payment_info = array();
  private $social_media_info = array();

  private $ad_banner = NULL;

  private $page_markdown_file = NULL;

  public function __construct() {

    if (!defined('BASE_PATH')) {
      define('BASE_PATH', '/');
    }

    if (!defined('BASE_URL')) {
      define('BASE_URL', '');
    }

  } // __construct


  //**************************************************************************************//
  // Set the debug mode.
  function setDebugMode($DEBUG_MODE = null) {
    if (!empty($DEBUG_MODE)) {
      $this->DEBUG_MODE = $DEBUG_MODE;
    }
  } // setDebugMode


  //**************************************************************************************//
  // Set the JSON mode.
  function setJSONMode($JSON_MODE = null) {
    if (!empty($JSON_MODE)) {
      $this->JSON_MODE = $JSON_MODE;
    }
  } // setJSONMode


  //**************************************************************************************//
  // Set the character set.
  function setContentType($content_type = null) {
    global $VALID_CONTENT_TYPES;
    if (!empty($content_type) && in_array($content_type, $VALID_CONTENT_TYPES)) {
      $this->content_type = $content_type;
    }
  } // setContentType


  //**************************************************************************************//
  // Set the character set.
  function setCharset($charset = null) {
    global $VALID_CHARSETS;
    if (!empty($charset) && in_array(strtolower($charset), $VALID_CHARSETS)) {
      $this->charset = $charset;
    }
  } // setCharset


  //**************************************************************************************//
  // Set the page mode.
  function setViewMode($view_mode = null) {
    $this->view_mode = $view_mode;
  } // setViewMode


  //**************************************************************************************//
  // Set the page URL.
  function setPageURL($page_url = null) {
    $this->page_url = $page_url;
  } // setPageURL


  //**************************************************************************************//
  // Set the page copyright.
  function setPageCopyright($page_copyright = null) {
    $this->page_copyright = $page_copyright;
  } // setPageCopyright


  //**************************************************************************************//
  // Set the page license.
  function setPageLicense($page_license = null) {
    $this->page_license = $page_license;
  } // setPageLicense


  //**************************************************************************************//
  // Set the page title.
  function setPageTitle($page_title = null) {
    $this->page_title = $page_title;
  } // setPageTitle


  //**************************************************************************************//
  // Set the page description.
  function setPageDescription($page_description = null) {
    $this->page_description = $page_description;
  } // setPageDescription


  //**************************************************************************************//
  // Set the page image.
  function setPageImage($page_image = null) {
    $this->page_image = $page_image;
  } // setPageImage


  //**************************************************************************************//
  // Set the Facebook admin stuff.
  function setPageFBAdmins($page_fb_admins = null) {
    $this->page_fb_admins = $page_fb_admins;
  } // setPageFBAdmins


  //**************************************************************************************//
  // Set the page content markdown file.
  function setPageContentMarkdown($md_file = null) {
    $this->page_markdown_file = $md_file;
  } // setPageContentMarkdown


  //**************************************************************************************//
  // Set the page content markdown file.
  function setPageJSONContent($json_content = null) {
    $this->json_content = $json_content;
  } // setPageJSONContent


  //**************************************************************************************//
  // Set the page content.
  function setPageContent($html_content = null) {
    $this->html_content = $html_content;
  } // setPageContent


  //**************************************************************************************//
  // Set the page DIVs.
  function setPageDivs($page_div_wrappper_array = array()) {
    $this->page_div_wrappper_array = $page_div_wrappper_array;
  } // setPageDivs


  //**************************************************************************************//
  // Set the page DIV wrapper.
  function setPageDivWrapper($page_div_wrapper_class = null, $page_div_wrapper_id = null) {
    $this->page_div_wrapper_class = $page_div_wrapper_class;
    $this->page_div_wrapper_id = $page_div_wrapper_id;
  } // setPageDivWrapper


  //**************************************************************************************//
  // Set the page viewport.
  function setPageViewport($page_viewport = null) {
    $this->page_viewport = $page_viewport;
  } // setPageViewport


  //**************************************************************************************//
  // Set the page robots.
  function setPageRobots($page_robots = null) {
    $this->page_robots = $page_robots;
  } // setPageRobots


  //**************************************************************************************//
  // Set the JavaScript stuff.
  function setJavaScriptItems($javascripts = array()) {
    $this->javascripts = $javascripts;
  } // setJavaScriptItems


  //**************************************************************************************//
  // Set the CSS stuff.
  function setCSSItems($css = array()) {
    $this->css = $css;
  } // setCSSItems


  //**************************************************************************************//
  // Set the Favicon stuff.
  function setFaviconItems($favicons = array()) {
    $this->favicons = $favicons;
  } // setFaviconItems


  //**************************************************************************************//
  // Set the HTML base.
  function setPageBase($page_base = null) {
    $this->base = $page_base;
  } // setPageBase


  //**************************************************************************************//
  // Set the page depth and markdown part.
  function setPageURLParts($markdown_parts = array()) {
    $this->page_depth = count($markdown_parts);
    $this->markdown_parts = $markdown_parts;
  } // setPageURLParts


  //**************************************************************************************//
  // Set the payment info.
  function setPaymentInfo($payment_info = null) {
    $this->payment_info = $payment_info;
  } // setPaymentInfo


  //**************************************************************************************//
  // Set the social media info.
  function setSocialMediaInfo($social_media_info = null) {
    $this->social_media_info = $social_media_info;
  } // setSocialMediaInfo


  //**************************************************************************************//
  // Set the ad banner stuff.
  function setAdBanner($ad_banner = null) {
    $this->ad_banner = $ad_banner;
  } // setAdBanner


  //**************************************************************************************//
  // Set the body header.
  function setBodyHeader($header_content = null) {
    $this->header_content = $header_content;
  } // setBodyHeader


  //**************************************************************************************//
  // Set the body footer.
  function setBodyFooter($footer_content = null) {
    $this->footer_content = $footer_content;
  } // setBodyFooter


  //**************************************************************************************//
  // Init the content.
  function initContent($response_header = NULL) {

    // If we are not in JSON mode, then build the HTML content.
    if (!$this->JSON_MODE) {
      $this->buildHTMLContent();
    }

  } // initContent


  //**************************************************************************************//
  // Display the content.
  function displayContent($response_header = NULL) {

    $this->renderContent($response_header);

  } // displayContent


  //**************************************************************************************//
  // Build the HTML content.
  function buildHTMLContent() {

    //**************************************************************************************//
    // Set the HTML content or load the markdown content as HTML content.

    $html_content = '';
    if (!empty($this->html_content)) {
      $html_content = $this->html_content;
    }
    else if (!empty($this->page_markdown_file)) {
      $html_content = $this->loadMarkdown($this->page_markdown_file);
    }

    //**********************************************************************************//
    // If the content is not empty, do something with it.

    if (!empty($html_content)) {

      //**********************************************************************************//
      // Set the meta tags

      $meta_content_array = $this->setMetaTags($this->page_description, $this->page_viewport, $this->page_robots);

      //**********************************************************************************//
      // Set the favicons.

      $favicon_array = $this->setFaviconArray();

      //**********************************************************************************//
      // Set the HTML/XHTML doctype.

      $doctype = $this->setDoctype();

      //**********************************************************************************//
      // Set the JavaScript.

      $javascript_array = $this->setJavaScriptArray();

      //**********************************************************************************//
      // Set the CSS.

      $css_array = $this->setCSSArray();

      //**********************************************************************************//
      // Set the body header.

      $header = '<div class="Header">'
              . $this->header_content
              . '</div>'
              ;

      //**********************************************************************************//
      // Set the body footer.

      $footer = '<div class="Footer">'
              . $this->footer_content
              . '</div>'
              ;

      //**********************************************************************************//
      // Set the view wrapper.

      if (!empty($this->view_mode)) {
        $body = sprintf('<div class="%sView">', $this->view_mode)
              . $this->setWrapper($html_content)
              . sprintf('</div><!-- .%sView -->', $this->view_mode)
              ;
      }
      else {
        $body = $this->setWrapper($html_content);
      }

      //**********************************************************************************//
      // Set the final HTML content.

      $ret = $doctype
           . '<head>'
           . '<title>' . $this->page_title . '</title>'
           . join('', $meta_content_array)
           . join('', $css_array)
           . join('', $favicon_array)
           . join('', $javascript_array)
           . (!empty($this->base) ? '<base href="' . $this->base . '" />' : '')
           . '</head>'
           . '<body>'
           . $header
           . $body
           . $footer
           . '</body>'
           . '</html>'
           ;

      //**********************************************************************************//
      // Set the HTML content class.

      $this->html_content = $ret;

    }

  } // buildHTMLContent


  //**************************************************************************************//
  // Set the doctype.
  function setDoctype() {

    $ret = '';

    if ($this->doctype == 'xhtml') {
      $ret = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'
           . '<html xmlns="http://www.w3.org/1999/xhtml">'
           ;
    }
    else if ($this->doctype == 'html5') {
      $ret = '<!DOCTYPE html>'
           . '<html lang="en">'
           ;
    }

    return $ret;

   } // setDoctype


  //**************************************************************************************//
  // Set the JavaScript stuff.
  function setJavaScriptArray() {

    // Roll through the JavaScripts array.
    $ret = array();
    foreach ($this->javascripts as $javascript) {
      $ret[] = sprintf('<script src="' . BASE_URL . '%s" type="%s"></script>', $javascript, 'text/javascript');
    }

    return $ret;

  } // setJavaScriptArray


  //**************************************************************************************//
  // Set the CSS stuff.
  function setCSSArray() {

    // Roll through the CSS array.
    $ret = array();
    foreach ($this->css as $css) {
      $ret[] = sprintf('<link rel="stylesheet" href="' . BASE_URL . '%s" type="text/css" />', $css);
    }

    return $ret;

  } // setCSSArray


  //**************************************************************************************//
  // Set the favicons.
  function setFaviconArray() {

    // Roll through the favicon array.
    $ret = array();
    foreach ($this->favicons as $favicon_type => $favicon_parts) {
      $parts = array();
      foreach ($favicon_parts as $favicon_key => $favicon_value) {
        $favicon_value = $favicon_key == 'href' ? BASE_URL . $favicon_value : $favicon_value;
        $parts[] = $favicon_key . '="' . $favicon_value . '"';
      }
      $ret[$favicon_type] = sprintf('<!-- %s favicon -->', $favicon_type);
      $ret[$favicon_type] .= sprintf('<link %s />', join(' ', $parts));
    }

    return $ret;

  } // setFaviconArray


  //**************************************************************************************//
  // Set the meta content.

  function setMetaTags($description = null, $viewport = null, $robots = null) {

    // Set the meta property values.
    $meta_http_equivs = array();
    $meta_http_equivs['content-type'] = 'text/html; charset=utf-8';
    // $meta_http_equivs['imagetoolbar'] = 'no';

    // Set the meta property values.
    $meta_names = array();
    if (!empty($description)) {
      $meta_names['description'] = $description;
    }
    if (!empty($viewport)) {
      $meta_names['viewport'] = $viewport;
    }
    if (!empty($robots)) {
      $meta_names['robots'] = $robots;
    }

    // The copyright changes between 'xhtml' & 'html5'
    $copyright_key = '';
    if ($this->doctype == 'xhtml') {
      $copyright_key = 'copyright';
    }
    else if ($this->doctype == 'html5') {
      $copyright_key = 'dcterms.rightsHolder';
      // $copyright_date_key = 'dcterms.dateCopyrighted';
    }
    if (!empty($copyright_key) && !empty($this->page_url)) {
      $meta_names[$copyright_key] = $this->page_copyright . '. ' . $this->page_license . '.';
      // $meta_names[$copyright_date_key] = date('Y');
    }
    $meta_names['apple-mobile-web-app-capable'] = 'yes';

    // Set the OpenGraph meta property values.
    $meta_properties = array();
    $meta_properties['og:title'] = $this->page_title;
    if (!empty($description)) {
      $meta_properties['og:description'] = $description;
    }
    $meta_properties['og:type'] = 'website';
    $meta_properties['og:locale'] = 'en_US';
    if (!empty($this->page_url)) {
      $meta_properties['og:url'] = $this->page_url;
    }
    if (!empty($this->page_title)) {
      $meta_properties['og:site_name'] = $this->page_title;
    }
    if (!empty($this->page_image)) {
      $meta_properties['og:image'] = $this->page_image;
    }

    // Set the Facebook specific meta property values.
    if (!empty($this->page_fb_admins)) {
      $meta_properties['fb:admins'] = $this->page_fb_admins;
    }

    $ret = array();

    // Roll through the '$meta_http_equivs'
    foreach ($meta_http_equivs as $http_equiv_key => $http_equiv_value) {
      $ret[] = sprintf('<meta http-equiv="%s" content="%s" />', $http_equiv_key, $http_equiv_value);
    }

    // Roll through the '$meta_names'
    foreach ($meta_names as $name_key => $name_value) {
      $ret[] = sprintf('<meta name="%s" content="%s" />', $name_key, $name_value);
    }

    // Roll through the '$meta_properties'
    foreach ($meta_properties as $property_key => $property_value) {
      $ret[] = sprintf('<meta property="%s" content="%s" />', $property_key, $property_value);
    }

    return $ret;

  } // setMetaTags


  //**************************************************************************************//
  // Load the markdown file.
  function loadMarkdown($markdown_file = null) {

    $ret = '';

    // If the markdown file exists and is not empty, do something.
    if (file_exists($markdown_file) && !empty($markdown_file)) {

      // Define BASE_FILEPATH
      $markdown_file_parts = pathinfo($markdown_file);
      $metadata_file = $markdown_file_parts['dirname'] . "/" . $markdown_file_parts['filename'] . '.yml';

      // If the metadata YAML file exists and is not empty, do something.
      if (file_exists($metadata_file) && !empty($metadata_file)) {
        $yaml_data = Spyc::YAMLLoad($metadata_file);
        $metadata_items = array('title', 'title_short', 'description', 'robots', 'copyright', 'license', 'keyword');
        foreach ($metadata_items as $metadata_item) {
          if (array_key_exists($metadata_item, $yaml_data)) {
            $page_variable_name = "page_" . $metadata_item;
            $this->$page_variable_name = $yaml_data[$metadata_item];
          }
        }
      }

      // Get the markdown file contents.
      $markdown_file_contents = file_get_contents($markdown_file);

      // Split and check the markdown contents for the copyright/license line and remove it if it’s there.
      $split_markdown = explode('***', $markdown_file_contents);
      $CUSTOM_COPYRIGHT = FALSE;
      if (count($split_markdown) > 1) {
        $last_paragraph = $split_markdown[count($split_markdown) - 1];
        $license_text = 'This work is licensed under a Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International License (CC-BY-NC-SA-4.0).';
        if (strpos($last_paragraph, $license_text)) {
          $CUSTOM_COPYRIGHT = TRUE;
          array_pop($split_markdown);
        }
      }

      // Process the markdown file contents.
      $ret = Parsedown::instance()->parse(join('***', $split_markdown));

      // Set a copyright box.
      if ($CUSTOM_COPYRIGHT) {
        $ret .= '<div class="Copyright">'
              . (!empty($this->page_title_short) ? '“' . $this->page_title_short . ',” ' : '')
              . (!empty($this->page_copyright) ? $this->page_copyright . '. ' : '')
              . (!empty($this->page_license) ? $this->page_license . '.' : '')
              . '</div>'
              ;
      }


    }

    return $ret;

  } // loadMarkdown


  //**************************************************************************************//
  // Set the navigation stuff.
  function setNavigation() {

    $li_items_l = array();
    if ($this->page_depth > 0) {
      $markdown_sliced = array_slice(array_values($this->markdown_parts), 0, -1);
      $back_url = BASE_PATH . join('/', $markdown_sliced);
      $li_items_l[] = '<li id="back">'
                    . sprintf('<a href="%s" title="back">«</a>', $back_url)
                    . '</li>'
                    ;
    }
    else {
      $li_items_l[] = '<li></li>';
    }

    $li_items_r = array();

    // Set the payment stuff.
    if (!empty($this->payment_info)) {
      foreach ($this->payment_info as $payment_key => $payment_value) {
        $li_items_r[] = sprintf('<li id="%s">', $payment_key)
                      . sprintf('<a href="%s" title="%s">%s %s</a>', $payment_value['url'], $payment_value['description'], $payment_value['short_name'], $payment_value['emoji'])
                      . '</li>'
                      ;
      }
    }

    // Set the social media stuff.
    if (!empty($this->social_media_info)) {
      foreach ($this->social_media_info as $social_media_key => $social_media_value) {
        $li_items_r[] = sprintf('<li id="%s">', $social_media_key)
                      . sprintf('<a href="%s" title="%s">%s %s</a>', $social_media_value['url'], $social_media_value['description'], $social_media_value['short_name'], $social_media_value['emoji'])
                      . '</li>'
                      ;
      }
    }

    if (!empty($li_items_l)) {
      $content_l = sprintf('<ul>%s</ul>', implode('', $li_items_l));
    }

    if (!empty($li_items_r)) {
      $content_r = sprintf('<ul>%s</ul>', implode('', $li_items_r));
    }

    $div_l = '';
    if (!empty($content_l)) {
      $div_l = '<div class="Left">'
             . $content_l
             . '</div><!-- .Left -->'
             ;
    }

    $div_r = '';
    if (!empty($content_r)) {
      $div_r = '<div class="Right">'
             . $content_r
             . '</div><!-- .Right -->'
             ;
    }

    $ret = '';
    if (!empty($content_l) || !empty($content_r)) {
      $ret = '<div class="Navigation">'
           . $div_l
           . $div_r
           . '</div><!-- .Navigation -->'
           ;
    }

    return $ret;

  } // setNavigation


  //**************************************************************************************//
  // Set the ad banner stuff.
  function setAdBannerFinal() {

    return '<div class="Ad">'
         . $this->ad_banner
         . '</div>'
         ;

  } // setAdBannerFinal


  //**************************************************************************************//
  // Set the wrapper.
  function setWrapper($body = null) {

    $body_div_stuff = array();
    $body_div_close_stuff = array();

    if (!empty($this->page_div_wrapper_class)) {
      $body_div_stuff[] = sprintf('class="%s"', $this->page_div_wrapper_class);
      $body_div_close_stuff[] = sprintf('.%s', $this->page_div_wrapper_class);
    }

    if (!empty($this->page_div_wrapper_id)) {
      $body_div_stuff[] = sprintf('id="%s"', $this->page_div_wrapper_id);
    }

    if (!empty($this->page_div_wrapper_class) || (!empty($this->page_div_wrapper_class) && !empty($this->page_div_wrapper_id))) {
      $body = sprintf('<div %s>', implode($body_div_stuff, ' '))
            . $body
            . sprintf('</div><!-- %s -->', implode($body_div_close_stuff, ' '))
            ;
    }

    // Set the wrapper divs.
    $div_opening = $div_closing = '';
    if (!empty($this->page_div_wrappper_array)) {
      $div_opening = '<div class="' . implode($this->page_div_wrappper_array, '">' . "\n" . '<div class="') . '">';
      $div_closing = '</div><!-- .' . implode(array_reverse($this->page_div_wrappper_array), '-->' . "\n" . '</div><!-- .') . ' -->';
    }

    $ret = (!empty($nameplate) ? $nameplate : '')
         . $div_opening
         . $body
         . $div_closing
         ;

    return $ret;

  } // setWrapper


  //**************************************************************************************//
  // Function to send content to output.
  private function renderContent ($response_header = NULL) {
    global $VALID_CONTENT_TYPES, $VALID_CHARSETS, $DEBUG_OUTPUT_JSON;

    // If we are in debugging mode, just dump the content array & exit.
    if ($this->JSON_MODE && !empty($this->json_content)) {
      $json_content = $this->json_encode ? json_encode($this->json_content) : $this->json_content;
      header(sprintf('Content-Type: %s; charset=%s', $this->content_type, $this->charset));
      if ($this->json_via_header) {
        header('X-JSON:' . $json_content);
      }
      else {
        header($response_header);
        echo $json_content;
      }
      exit();
    }
    else if ($this->DEBUG_MODE && !empty($this->html_content)) {
      header('Content-Type: text/plain; charset=utf-8');
      echo $this->html_content;
      exit();
    }
    else {
      header(sprintf('Content-Type: %s; charset=%s', $this->content_type, $this->charset));
      echo $this->html_content;
      exit();
    }

  } // renderContent

} // frontendDisplay

?>