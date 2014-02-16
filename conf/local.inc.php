<?php

/**
 * Preworn Local Config File (local.inc.php)
 *
 * Programming: Jack Szwergold <JackSzwergold@gmail.com>
 *
 * Created: 2014-02-16, js
 * Version: 2014-02-16, js: creation
 *          2014-02-16, js: development & cleanup
 *
 */

if ($_SERVER['SERVER_NAME'] == 'localhost') {
  define('BASE_PATH', '/Preworn-Main/');
}
else {
  define('BASE_PATH', '/');
}

?>
