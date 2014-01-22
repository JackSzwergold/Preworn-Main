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
// Set the mode.

$mode = 'mega';

//**************************************************************************************//
// Set the sundry metadata stuff.

$description = 'this site is jack szwergold’s the calling card, gallery, portfolio, playground, white wall, black box, idea sandbox &amp; daily distraction.';


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
         
         . '<h1>preworn</h1>'
         . '<p>' . $description . '</p>'
         . '<br />'

         . '<h3>current projects</h3>'
         . '<p><a href="mosaic/" title="image mosaic" target="_top">image mosaic</a>: a dynamically generated image mosaic using php, the gd graphics libarary, html &amp; css</p>'
         . '<br />'

         . '<h3>skills</h3>'
         . '<p>i’m a highly skilled unix systems administrator, web developer &amp; systems engineer with 20+ years of experience which includes a strong professional history in the fine art world.</p>'

         . '<p>specialties: unix systems administration, shell scripting &amp; other common web/unix/internet scripting languages as well as software development using php (object oriented &amp; flat), javascript, mysql, css, json, html, dhtml, xhtml &amp; xml. very comfortable working in the unix shell in ubuntu, redhat, centos &amp; solaris environments. can install/configure packages from repositories &amp; compile from source code on most any platform.</p>'

         . '<p>i work primarily on the ubuntu &amp; mac os x platforms but have deep experience with many different flavors of unix spanning back to the early 1990s. so i can jump onto the console, maneuver around the terminal and get the job done regardless of os.</p>'

         . '<br />'

         . '<h3>contact</h3>'
         . '<p>me [at] preworn [dot] com</p>'
         . '<br />'

         . '<h3>community</h3>'
         . '<p><a href="http://stackoverflow.com/users/117259/jakegould" target="_blank">stack overflow</a> &bull; <a href="http://serverfault.com/users/100013/jakegould" target="_blank">server fault</a> &bull; <a href="http://www.linkedin.com/in/jackszwergold" target="_blank">linked in</a></p>'
         . '<br />'


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