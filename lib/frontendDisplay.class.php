<?

/**
 * Frontend Display Class (frontendDisplay.class.php)
 *
 * Programming: Jack Szwergold <JackSzwergold@gmail.com>
 *
 * Created: 2014-01-22, js
 * Version: 2014-01-22, js: creation
 *          2014-01-22, js: development & cleanup
 *          2014-01-23, js: refinements
 *
 */

//**************************************************************************************//
// The beginnings of a frontend display class.

class frontendDisplay {

  private $DEBUG_MODE = FALSE;

  private $content_type = 'text/html';
  private $charset = 'utf-8';
  private $doctype = 'html5';

  private $json_encode = FALSE;
  private $json_via_header = FALSE;

  private $params = array();

  private $view_mode = NULL;
  private $page_title = NULL;
  private $page_description = NULL;
  private $page_content = NULL;

  private $page_markdown_file = NULL;

  public function __construct($content_type = NULL, $charset = NULL, $json_encode = NULL, $DEBUG_MODE = NULL) {
    global $VALID_CONTENT_TYPES, $VALID_CHARSETS;

    if (!empty($content_type) && in_array($content_type, $VALID_CONTENT_TYPES)) {
      $this->content_type = $content_type;
    }

    if (!empty($charset) && in_array(strtolower($charset), $VALID_CHARSETS)) {
      $this->charset = $charset;
    }

    if (!empty($json_encode)) {
      $this->json_encode = $json_encode;
    }

    // if (!empty($json_via_header)) {
    //   $this->json_via_header = $json_via_header;
    // }

    if (!empty($DEBUG_MODE)) {
      $this->DEBUG_MODE = $DEBUG_MODE;
    }

  } // __construct


  //**************************************************************************************//
  // Set the page mode.
  function setViewMode($view_mode = null) {
    $this->view_mode = $view_mode;
  } // setViewMode


  //**************************************************************************************//
  // Set the page description.
  function setPageTitle($page_title = null) {
    $this->page_title = $page_title;
  } // setPageTitle


  //**************************************************************************************//
  // Set the page description.
  function setPageDescription($page_description = null) {
    $this->page_description = $page_description;
  } // setPageDescription


  //**************************************************************************************//
  // Set the page content markdown file.
  function setPageContentMarkdown($md_file = null) {
    $this->page_markdown_file = $md_file;
  } // setPageContentMarkdown


  //**************************************************************************************//
  // Set the page content file.
  function setPageContent($content = null) {
    $this->content = $content;
  } // setPageContent


  //**************************************************************************************//
  // Set the favicons.
  function setFavicons() {

    $ret = array();

    $ret[] = '<!-- Opera Speed Dial Favicon -->'
           . '<link rel="icon" type="image/png" href="favicons/speeddial-160px.png" />'
           ;

    $ret[] = '<!-- Standard Favicon -->'
           . '<link rel="icon" type="image/x-icon" href="favicons/favicon.ico" />'
           ;

    $ret[] = '<!-- For iPhone 4 Retina display: -->'
           . '<link rel="apple-touch-icon-precomposed" sizes="114x114" href="favicons/apple-touch-icon-114x114-precomposed.png" />'
           ;

    $ret[] = '<!-- For iPad: -->'
           . '<link rel="apple-touch-icon-precomposed" sizes="72x72" href="favicons/apple-touch-icon-72x72-precomposed.png" />'
           ;

    $ret[] = '<!-- For iPhone: -->'
           . '<link rel="apple-touch-icon-precomposed" href="favicons/apple-touch-icon-57x57-precomposed.png" />'
           ;

    return $ret;

  } // setFavicons


  //**************************************************************************************//
  // Set the meta content.

  function setMetacontent($description = null) {

    $meta_copyright = '';
    if ($this->doctype == 'xhtml') {
      $meta_copyright = '<meta name="copyright" content="(c) copyright ' . date('Y') . ' jack szwergold. all rights reserved." />';
    }
    else if ($this->doctype == 'html5') {
      $meta_copyright = '<meta name="dcterms.rightsHolder" content="(c) copyright ' . date('Y') . ' jack szwergold. all rights reserved.">';
    }

    $ret = array();

    $ret[] = '<meta http-equiv="content-type" content="text/html; charset=utf-8" />';
    $ret[] = '<meta name="description" content="' . $description . '" />';
    $ret[] = $meta_copyright;
    $ret[] = '<meta property="og:title" content="image mosaic" />';
    $ret[] = '<meta property="og:description" content="' . $description . '" />';
    $ret[] = '<meta property="og:type" content="website" />';
    $ret[] = '<meta property="og:locale" content="en_US" />';
    $ret[] = '<meta property="og:url" content="http://www.preworn.com/" />';
    $ret[] = '<meta property="og:site_name" content="preworn" />';
    $ret[] = '<meta property="og:image" content="http://www.preworn.com/favicons/speeddial-160px.png" />';
    $ret[] = '<meta name="robots" content="noindex,nofollow" />';
    $ret[] = '<meta name="viewport" content="width=device-width, initial-scale=0.4, maximum-scale=2, minimum-scale=0.4, user-scalable=yes" />';

    return $ret;

  } // setMetacontent


  //**************************************************************************************//
  // Load the markdown file.
  function loadMarkdown($md_file = null) {

    if (empty($md_file)) {
      return;
    }

    $md_file = file_get_contents($md_file);
    $ret = Parsedown::instance()->parse($md_file);

    return $ret;

  } // loadMarkdown


  //**************************************************************************************//
  // Set the wrapper.
  function setWrapper($body = null) {

    $ret = '<div class="Wrapper">'
         . '<div class="Padding">'

         . '<div class="Content">'
         . '<div class="Padding">'

         . '<div class="Section">'
         . '<div class="Padding">'
         . '<div class="Middle">'

         . '<div class="Core">'
         . '<div class="Padding">'

         . '<div class="Grid">'
         . '<div class="Padding">'

         . '<div class="PixelBoxWrapper">'

         . $body

         . '</div><!-- .PixelBoxWrapper -->'

         . '</div><!-- .Padding -->'
         . '</div><!-- .Grid -->'

         . '</div><!-- .Middle -->'
         . '</div><!-- .Padding -->'
         . '</div><!-- .Section -->'

         . '</div><!-- .Padding -->'
         . '</div><!-- .Core -->'

         . '</div><!-- .Padding -->'
         . '</div><!-- .Content -->'

          . '</div><!-- .Padding -->'
          . '</div><!-- .Wrapper -->'
          ;

    return $ret;

  } // setWrapper


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
  // Set the JavaScript.
  function setJavaScript() {

    $ret = array();

    $ret[] = '<script src="script/json2.js" type="text/javascript"></script>';
    $ret[] = '<script type="text/javascript" src="script/jquery/jquery-1.10.2.min.js"></script>';
    $ret[] = '<script type="text/javascript" src="script/jquery/jquery.noconflict.js"></script>';
    # $ret[] = '<script type="text/javascript" src="script/common.js"></script>';

    return $ret;

  } // setJavaScript


  //**************************************************************************************//
  // Init the content.
  function initContent($response_header = NULL) {
    global $VALID_CONTROLLERS;

    //**************************************************************************************//
    // Filtrer the URL parameters

    $this->filterURLParameters();

    //**************************************************************************************//
    // Load the markdown content.

    $content = '';
    if (!empty($this->content)) {
      $content = $this->content;
    }
    else if (!empty($this->page_markdown_file)) {
      $content = $this->loadMarkdown($this->page_markdown_file);
    }
    

    //**********************************************************************************//
    // If the content is not empty, do something with it.

    if (!empty($content)) {
    
      //**********************************************************************************//
      // Set the favicons

      $meta_content = $this->setMetacontent($this->page_description);

      //**********************************************************************************//
      // Set the favicons

      $favicons = $this->setFavicons();

      //**********************************************************************************//
      // Set the HTML/XHTML doctype.

      $doctype = $this->setDoctype();


      //**********************************************************************************//
      // Set the JavaScript.

      $javascript = $this->setJavaScript();


      //**********************************************************************************//
      // Set the view wrapper.

      $body = sprintf('<div class="%sView">', $this->view_mode)
            . $this->setWrapper($content)
            . sprintf('</div><!-- .%sView -->', $this->view_mode)
            ;

       //**********************************************************************************//
      // Set the final content.

      $ret = $doctype
           . '<head>'
           . '<title>' . $this->page_title . '</title>'
           . join('', $meta_content)
           . '<link rel="stylesheet" href="css/style.css" type="text/css" />'
           . join('', $favicons)
           . join('', $javascript)
           . '</head>'
           . '<body>'
           . $body
           . '</body>'
           . '</html>'
           ;

      //**********************************************************************************//
      // Return the output.
    
      $this->renderContent($ret, $response_header);

    }

  } // initContent


  //**************************************************************************************//
  // Filter through the URL parameters.
  private function filterURLParameters() {
    global $VALID_GET_PARAMETERS;

    $this->params['controller'] = null;
    $this->params['id'] = 0;
    $this->params['_debug'] = FALSE;

    foreach($_GET as $parameter_key => $parameter_value) {

      if (in_array($parameter_key, $VALID_GET_PARAMETERS)) {
        if ($parameter_key == 'controller') {
          $this->params['controller'] = preg_replace('/[^A-Za-z-_]/s', '', trim($_GET['controller']));
        }
        else if ($parameter_key == 'id') {
          $this->params['id'] = intval($_GET['id']);
        }
        else if ($parameter_key == '_debug') {
          $this->params['_debug'] = TRUE;
          $this->DEBUG_MODE = TRUE;
        }
      }
    }

  } // filterURLParameters


  //**************************************************************************************//
  // Function to send content to output.
  private function renderContent ($content, $response_header = NULL) {
    global $VALID_CONTENT_TYPES, $VALID_CHARSETS, $DEBUG_OUTPUT_JSON;

    // If we are in debugging mode, just dump the content array & exit.
    if ($this->DEBUG_MODE) {
      header('Content-Type: text/plain; charset=utf-8');
      if ($DEBUG_OUTPUT_JSON && $this->json_encode) {
        $json_content = json_encode($content);
        // Strip back slahes from forward slashes so we can read URLs.
        $json_content = str_replace('\/','/', $json_content);
        echo prettyPrint($json_content);
      }
      else {
        print_r($content);
      }
      exit();
    }
    else if (FALSE) {
      $json_content = $this->json_encode ? json_encode($content) : '';
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
    else {
      header(sprintf('Content-Type: %s; charset=%s', $this->content_type, $this->charset));
      echo $content;
      exit();
    }

  } // renderContent

} // frontendDisplay

?>