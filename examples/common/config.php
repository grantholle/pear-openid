<?php
/**
 * OpenID
 *
 * PHP Version 5.2.0+
 *
 * @category  Auth
 * @package   OpenID
 * @author    Bill Shupp <hostmaster@shupp.org>
 * @copyright 2009 Bill Shupp
 * @license   http://www.opensource.org/licenses/bsd-license.php FreeBSD
 * @link      http://github.com/shupp/openid
 */

ini_set('session.save_handler', 'files');

set_include_path(dirname(__FILE__) . '/../../:' . get_include_path());

/**
 * Required files
 */
require_once 'src/RelyingParty.php';
require_once 'src/Discover.php';
require_once 'src/Store.php';
require_once 'src/Extensions/SREG10.php';
require_once 'src/Extensions/SREG11.php';
require_once 'src/Extensions/AX.php';
require_once 'src/Extensions/UI.php';
require_once 'src/Extensions/OAuth.php';
require_once 'src/Message.php';
require_once 'src/Observers/Log.php';
require_once 'Net/URL2.php';

session_start();

// Determine realm and return_to
$base = 'http';
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
    $base .= 's';
}
$base .= '://' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'];

$realm    = $base . '/';
$returnTo = $base . dirname($_SERVER['PHP_SELF']);
if ($returnTo[strlen($returnTo) - 1] != '/') {
    $returnTo .= '/';
}
$returnTo .= 'relyingparty.php';

// SQL storage example
// $storeOptions = array(
//     'dsn' => 'mysql://user:pass@db.example.com/openid'
// );
// OpenID::setStore(OpenID_Store::factory('MDB2', $storeOptions));
//
// // The first time you run it, you'll also need to create the tables:
// OpenID::getStore()->createTables();

?>
