<?php

$_CONF['db']['driver'] = 'mysqli';
$_CONF['db']['host'] = 'localhost'; 
$_CONF['db']['user'] = 'Hometest';
$_CONF['db']['pass'] = 'whoknew?';
$_CONF['db']['name'] = 'pantry';
$_CONF['db']['prefix'] = '';
$_CONF['db']['port'] = '';
$_CONF['core.folder'] = '/';


$cprSessionTimeout=3600; // Session timeout in seconds
$bruteForceAttemptLimit=5; // How many failed login attempts in below timespan until lockout
$bruteForceTimespan=2;  // Check above limit in the last x hours
$defaultProfilePicture="noprofile.png"; // Show this if no phpFox user profile picture set
$bIsV4=FALSE;
define("SECURE", FALSE);    // FOR DEVELOPMENT ONLY!!!!
defined('PHPFOX') 
    or define('PHPFOX', true);
defined('PHPFOX_DS') 
    or define('PHPFOX_DS', DIRECTORY_SEPARATOR);
if(file_exists(dirname(dirname(dirname(__FILE__))) . PHPFOX_DS . 'PF.Base'))
{
    $bIsV4=TRUE;
    defined('V4') 
        or define('V4', TRUE);
    defined('PHPFOX_BASE') 
        or define('PHPFOX_BASE', 'PF.Base' . PHPFOX_DS);
    defined('PHPFOX_SITE')
        or define('PHPFOX_SITE', dirname(dirname(dirname(__FILE__))) . PHPFOX_DS . 'PF.Site' . PHPFOX_DS);
}
defined('PHPFOX_DIR') 
    or define('PHPFOX_DIR', ($bIsV4)?dirname(dirname(dirname(__FILE__))) . PHPFOX_DS . 'PF.Base' . PHPFOX_DS:dirname(dirname(dirname(__FILE__))) . PHPFOX_DS);
defined("PHPFOX_CPR_BASEURL")
    or define("PHPFOX_CPR_BASEURL",str_replace('index.php', '', 'http://'.$_SERVER['HTTP_HOST'].$_SERVER["PHP_SELF"]));
defined('PHPFOX_DIR_MODULE') 
    or define('PHPFOX_DIR_MODULE', PHPFOX_DIR . 'module' . PHPFOX_DS);
defined('PHPFOX_DIR_MODULE_PLUGIN')
    or define('PHPFOX_DIR_MODULE_PLUGIN', 'include' . PHPFOX_DS . 'plugin');
defined('PHPFOX_DIR_FILE') 
    or define('PHPFOX_DIR_FILE', PHPFOX_DIR . 'file' . PHPFOX_DS);
defined('PHPFOX_DIR_CACHE') 
    or define('PHPFOX_DIR_CACHE', PHPFOX_DIR_FILE . 'cache' . PHPFOX_DS);
defined("LIBRARY_PATH")
    or define("LIBRARY_PATH", realpath(dirname(__FILE__) . '/library'));
defined("TEMPLATES_PATH")
    or define("TEMPLATES_PATH", realpath(dirname(__FILE__) . '/templates'));
defined("LANGUAGE_PATH")
    or define("LANGUAGE_PATH", realpath(dirname(__FILE__) . '/language'));
defined("PHPFOX_SETTINGS")
    or define("PHPFOX_SETTINGS", ($bIsV4)?PHPFOX_DIR."file/settings":PHPFOX_DIR."include/setting");
defined("FILE_PATH")
    or define("FILE_PATH", realpath(dirname(dirname(__FILE__))) . PHPFOX_DS . 'file');
defined("AJAX_PATH")
    or define("AJAX_PATH", realpath(dirname(dirname(__FILE__))) . PHPFOX_DS . 'ajax');
defined("PHPFOX_CONSTANTS")
    or define("PHPFOX_CONSTANTS", PHPFOX_DIR . "include/setting");
defined("IMAGE_LAYOUT_PATH")
    or define("IMAGE_LAYOUT_PATH", realpath(dirname(dirname(__FILE__))) . "/img/layout");


$_CONF['cpr'] = array(
    "urlPath" => array(),
    "settings"=> array(
        'sess_timeout'      =>3600, // Session timeout in seconds
        'bruteforce_limit'  =>5, // How many failed login attempts in below timespan until lockout
        'bruteForce_span'   =>2,  // Check above limit in the last x hours
        'default_pic'       =>"noprofile.png", // Show this if no phpFox user profile picture set
        'default_language'  => "lang_en-us_US-English.php" // Change to your default language filename
    )
);
//print_r($_CONF);
/*
    Error reporting.
*/
ini_set("error_reporting", "true");
error_reporting(E_ALL|E_STRICT);



?>