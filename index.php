<?php

/**
 * Preworn Index (index.php)
 *
 * Programming: Jack Szwergold <JackSzwergold@gmail.com>
 *
 * Created: 2014-01-20, js
 * Version: 2014-01-20, js: creation
 *          2014-01-20, js: development & cleanup
 *
 */

//**************************************************************************************//
// Redirect & debugging stuff.

# phpinfo();
# header('Location: /mosaic/');
# echo $_SERVER['SERVER_NAME'];
# echo '<br />';
# echo $_SERVER['SERVER_ADDR'];
# die();

//**************************************************************************************//
// Require Parsedown

require_once 'lib/Parsedown.php';

//**************************************************************************************//
// Set the mode.

$mode = 'mega';

//**************************************************************************************//
// Set the sundry metadata stuff.

$description = 'this site is jack szwergold’s the calling card, gallery, portfolio, playground, white wall, black box, idea sandbox &amp; daily distraction.';

//**************************************************************************************//
// Load the markdown verskon of the body text.

$md_body = file_get_contents('index.md');
$body = Parsedown::instance()->parse($md_body);

//**************************************************************************************//
// Set the content in the wrapper area.

$wrapper = '<div class="Wrapper">'
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

//**************************************************************************************//
// Set the view wrapper.

$body = sprintf('<div class="%sView">', $mode)
      . $wrapper
      . sprintf('</div><!-- .%sView -->', $mode)
      ;

//**************************************************************************************//
// Set the favicons.

$favicons = array();

$favicons[] = '<!-- Opera Speed Dial Favicon -->'
            . '<link rel="icon" type="image/png" href="favicons/speeddial-160px.png" />'
            ;

$favicons[] = '<!-- Standard Favicon -->'
            . '<link rel="icon" type="image/x-icon" href="favicons/favicon.ico" />'
            ;

$favicons[] = '<!-- For iPhone 4 Retina display: -->'
            . '<link rel="apple-touch-icon-precomposed" sizes="114x114" href="favicons/apple-touch-icon-114x114-precomposed.png" />'
            ;

$favicons[] = '<!-- For iPad: -->'
            . '<link rel="apple-touch-icon-precomposed" sizes="72x72" href="favicons/apple-touch-icon-72x72-precomposed.png" />'
            ;

$favicons[] = '<!-- For iPhone: -->'
            . '<link rel="apple-touch-icon-precomposed" href="favicons/apple-touch-icon-57x57-precomposed.png" />'
            ;


//**************************************************************************************//
// Return the output.

echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'
   . '<html xmlns="http://www.w3.org/1999/xhtml">'
   . '<head>'

   . '<title>preworn</title>'
   . '<meta http-equiv="content-type" content="text/html; charset=utf-8" />'
   . '<meta name="description" content="' . $description . '" />'
   . '<meta name="copyright" content="(c) copyright ' . date('Y') . ' jack szwergold. all rights reserved." />'
   . '<meta property="og:title" content="image mosaic" />'
   . '<meta property="og:description" content="' . $description . '" />'
   . '<meta property="og:type" content="website" />'
   . '<meta property="og:locale" content="en_US" />'
   . '<meta property="og:url" content="http://www.preworn.com/" />'
   . '<meta property="og:site_name" content="preworn" />'
   . '<meta property="og:image" content="http://www.preworn.com/favicons/speeddial-160px.png" />'
   . '<meta name="robots" content="noindex,nofollow" />'
   . '<meta name="viewport" content="width=device-width, initial-scale=0.4, maximum-scale=2, minimum-scale=0.4, user-scalable=yes" />'
   . '<link rel="stylesheet" href="css/style.css" type="text/css" />'

   . join('', $favicons)

   . '<script src="script/json2.js" type="text/javascript"></script>'
   . '<script type="text/javascript" src="script/jquery/jquery-1.10.2.min.js"></script>'
   . '<script type="text/javascript" src="script/jquery/jquery.noconflict.js"></script>'
   # . '<script type="text/javascript" src="script/common.js"></script>'

   . '</head>'
   . '<body>'
   . $body
   . '</body>'
   . '</html>'
   ;

?>