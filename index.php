<?php

                       
$sPage=null;
$variables=array();
$variables['messages']='';
$variables['errors']=array();
set_error_handler("displayErrors"); 
$aServer= filter_input_array(INPUT_SERVER);

$mType=filter_input(INPUT_GET,'type');
$bIsAjax=(isset($mType) && $mType=="ajax")?TRUE:FALSE;

defined("PHPFOX_CPR_BASEURL")
    or define("PHPFOX_CPR_BASEURL",str_replace('index.php', '', 'http://'.$aServer["SERVER_NAME"].esc_url($aServer["SCRIPT_NAME"])));

// include the config file for phpFox_CPR
if(checkIncludes(dirname(__FILE__) . "/resources/config.php"))
{
	require_once(dirname(__FILE__) . "/resources/config.php");
}

//include the templateFunctions file which merges and configures template outputs
if(checkIncludes(LIBRARY_PATH . "/templateFunctions.php"))
{
	require_once(LIBRARY_PATH . "/templateFunctions.php");
}


//if(checkIncludes(LIBRARY_PATH.'/fox_settings.php'))
//{
//	include_once(LIBRARY_PATH.'/fox_settings.php');
//}

// service interface handles db and file requests
if(checkIncludes(LIBRARY_PATH."/service.class.php"))
{
	include_once(LIBRARY_PATH."/service.class.php");
	$oService=new phpfoxCPR_service($_CONF);
}

// auth.class handles site authentication
if(checkIncludes(LIBRARY_PATH.'/auth.class.php'))
{
	include_once(LIBRARY_PATH.'/auth.class.php');
	$oAuth=new auth($oService, $_CONF['cpr']);
}

// Do some language stuff

// get available languages from /resource/language/language files
$aLangFiles=$oService->getLanguages();

$variables['languages']=$aLangFiles;

// Check 1-Requests, 2-Sessions, 3-Cookies for set language
$lang='';
$langR=(string)filter_input(INPUT_GET, 'lang');
$langS=isset($_SESSION['lang'])?(string)$_SESSION['lang']:NULL;
$langC=(string)filter_input(INPUT_COOKIE, 'lang');

// If Request is set, make this the lang, otherwise keep the cookie or session lang
if(isset($langR)&&strlen($langR))
{
    $lang=$langR;
    $_SESSION['lang'] = $langR;
    setcookie("phpfox_cpr_lang", $langR, time() + (3600 * 24 * 30));
}
elseif(isset($langS)&&strlen($langS))
{
    $lang = $langS;
}
elseif(isset($langC)&&strlen($langC))
{
    $lang = $langC;
}
else
{
    // If nothing is set, look at HTTP_ACCEPT_LANGUAGE
   $aLangMatches=$oService->prefered_language(filter_var($_SERVER['HTTP_ACCEPT_LANGUAGE'], FILTER_UNSAFE_RAW));
    
    foreach($aLangMatches as $sLangMatch=>$value)
    {
        $lang_file = 'lang_'.$sLangMatch.'_'.$aLangFiles[$sLangMatch]['label'].'.php';
        if(checkIncludes(LANGUAGE_PATH.'/'.$lang_file))
        {
            $lang=$sLangMatch;
            $_SESSION['lang'] = $sLangMatch;
            setcookie("phpfox_cpr_lang", $sLangMatch, time() + (3600 * 24 * 30));
            break;
        }
    }
}

if(empty($lang))
{
    $lang=$_CONF['cpr']['settings']['default_language'];
    $variables['current_language']="";
}
else
{
    $lang_file = 'lang_'.$lang.'_'.$aLangFiles[$lang]['label'].'.php';
    $variables['current_language']=$aLangFiles[$lang];
}

if(checkIncludes(LANGUAGE_PATH.'/'.$lang_file))
{
    include(LANGUAGE_PATH.'/'.$lang_file);
}

// Make sure that the PDO database object succeeded
// Since language was not instantiated before error occured
// the language phrase key was passed to build the phrase here
if(!$oService->getInfo()==true)
{
    $aServiceErrors=$oService->getErrors();
    foreach($aServiceErrors as $key=>$sServiceError)
    {
        $aErr1= explode('%1', $sServiceError);
        $aServiceErrors[$key]=$aErr1[0].$variables['lang'][$aErr1[1]];
    }

    $variables['errors']=array_merge($variables['errors'], $aServiceErrors);
    renderLayoutWithContentFile('error.php', $variables);
}

// password-compat required for new password system
if($bIsV4 && $bGood=checkIncludes(PHPFOX_DIR.PHPFOX_DS.'vendor'.PHPFOX_DS.'ircmaxell'.PHPFOX_DS.'password-compat'.PHPFOX_DS.'lib'.PHPFOX_DS.'password.php'))
{
	include_once(PHPFOX_DIR.PHPFOX_DS.'vendor'.PHPFOX_DS.'ircmaxell'.PHPFOX_DS.'password-compat'.PHPFOX_DS.'lib'.PHPFOX_DS.'password.php');
}

// cache.class required for cache clearing
//if(checkIncludes(LIBRARY_PATH . "/cache.class.php"))
//{
//    include_once(LIBRARY_PATH . "/cache.class.php");
//}

// Begin Authentication process
$oAuth->setLang($variables['lang']);
$sAuth=filter_input(INPUT_POST,'auth_action');

if(isset($sAuth))
{

	// Handle Logout
	if($sAuth=='logout')
	{
		$bGood=$oAuth->logout();
		$sPage='home.php';
                $_GET['page']='home';
		$variables['messages'] = $oAuth->getMessages();
	}

	// Handle Login Requests
	if($sAuth=='login')
	{
		$bReply=$oAuth->login(filter_input(INPUT_POST,'username'),filter_input(INPUT_POST,'password'));
                
		if($bReply==TRUE)
		{
			//header( 'Location: ' . $aServer['SCRIPT_NAME'] ); 
		}
		else
		{
			$sPage='home.php';
			$variables['messages'] = $oAuth->getMessages();
		}
	}
}

// Check login status and refresh if logged in
$oAuth->isExpired();

//If any errors have been detected display them
if(isset($variables['errors']) && count($variables['errors'])>0)
{
	$variables['current_page']='error';
	$sPage='error.php';
	renderLayoutWithContentFile($sPage, $variables);
	exit();
}


if($oAuth->login_check()==TRUE)
{
    // Make Cache object available
    //$oCache=new Phpfox_Cache($_CONF);
    
	// Handle Ajax requests
	if ($bIsAjax)
	{
            if($bGood=checkIncludes(AJAX_PATH.PHPFOX_DS.'ajax.php'))
            {
                    include_once(AJAX_PATH.PHPFOX_DS.'ajax.php');
                    $oAjax=new phpfoxCPR_Ajax();
            }

            $sCall = filter_input(INPUT_GET, 'call', FILTER_SANITIZE_STRING);
            $mParam = filter_input(INPUT_GET, 'param', FILTER_SANITIZE_NUMBER_INT);
            if (method_exists($oAjax, $sCall))
            {
                call_user_func(array($oAjax, $sCall),$mParam);
                exit;
            }
	}
        
	// Handle Add Actions
        $mItemAdd=filter_input(INPUT_POST,'addItem');

	if (isset($mItemAdd))
	{
 
             $args = array(
                "item_id" => FILTER_SANITIZE_NUMBER_INT,
                "name" => FILTER_SANITIZE_STRING,
                 "gf_flag" => FILTER_SANITIZE_STRING,
                "size" => FILTER_SANITIZE_STRING,
                "units" => FILTER_SANITIZE_STRING,
                "quantity" => array('filter'    => FILTER_VALIDATE_INT,
                                'flags'     => FILTER_REQUIRE_SCALAR, 
                                'options'   => array('min_range' => 0, 'max_range' => 100)),
                "location" => FILTER_SANITIZE_STRING,
                "shelf" => FILTER_SANITIZE_STRING,
                "use_by" => FILTER_SANITIZE_STRING,
                "upc" => FILTER_SANITIZE_ENCODED
            );
             

            $aVal=filter_input_array(INPUT_POST, $args);
            $aVal['use_by']=strtotime($aVal['use_by']);
            $aVal['gf_flag']= empty($aVal['gf_flag'])?0:1;
//            var_dump($aVal);die();            
            if(filter_input(INPUT_POST,'duplicate')=='on')
            {
                $aVal['item_id']=null;
                $mItemAdd='add';
            }           
            
            if($mItemAdd=='edit' && $aVal['item_id'] > 0)
            {
                $bGood=$oService->deleteItem($aVal['item_id']);
                if($bGood)
                {
                    $bGood=$oService->addItem($aVal);
                }
            }
            elseif($mItemAdd=='add')
            {
                $bGood=$oService->addItem($aVal);
            }
            else
            {
                   return false;
            }

            if(!$bGood)
            {
                $variables['errors'][]='Failed to save item';
            }
	}
        
	// Handle Browse Actions
        $mIdPlug=filter_input(INPUT_GET,'sample_id');
	if (isset($mIdPlug))
	{
		//list($bGood,$aErrors)=$oService->updateSample($mIdPlug);
//		if(!$bGood)
//		{
//			foreach($aErrors as $sError)
//			{
//				$variables['errors'][]=$sError;
//			}
//			$sPage='error.php';
//			renderLayoutWithContentFile($sPage, $variables);
//		}
	}
        
        
        


        
// Handle Sample Actions
        $mIdPlug=filter_input(INPUT_GET,'sample_id');
	if (isset($mIdPlug))
	{
		//list($bGood,$aErrors)=$oService->updateSample($mIdPlug);
		if(!$bGood)
		{
			foreach($aErrors as $sError)
			{
				$variables['errors'][]=$sError;
			}
			$sPage='error.php';
			renderLayoutWithContentFile($sPage, $variables);
		}
	}

        // Handle page requests
        $sReqPage=filter_input(INPUT_GET,'page');
        //$sReqPage='home';
	if (isset($sReqPage)) 
	{
		switch($sReqPage)
		{
			case 'home':

				$sPage='home.php';
				break;

			case 'sample':

				$sPage='sample.php';
				//$variables['aPlugins'] = $oService->getPlugins();
				//$variables['sFilePath'] = FILE_PATH;

				break;
                            
                        case 'add':

				$sPage='add.php';
                                $variables['names'] = $oService->getItemNames(); 
                                list($variables['names'], $variables['units'], $variables['size']) = $oService->getItemNames();

				break;
                            
                        case 'edit':
                                $mIdEdit=filter_input(INPUT_GET,'item_id');
                                if($mIdEdit)
                                {
                                    $sPage='add.php';
                                    $variables['aItem'] = $oService->getItem($mIdEdit);
                                    list($variables['names'], $variables['units'], $variables['size']) = $oService->getItemNames();
                                }
				break;                            
                            
                        case 'browse':

                                $mSort=filter_input(INPUT_GET,'sort_column');
                                $mSort=empty($mSort)?'name':$mSort;
				$sPage='browse.php';
				$variables['aItems'] = $oService->getItems($mSort);
				//$variables['sFilePath'] = FILE_PATH;

				break;
                            

			default:
				$sPage='home.php';
				break;
		}
	}
	else
	{
		$sPage='home.php';
	}

	$variables['current_page']=isset($sReqPage)?$sReqPage:'home';

	renderLayoutWithContentFile($sPage, $variables);
}
else
{
        if($bIsAjax)
        {
            echo "Logged out";exit;
        }

    
	// Handle Logged Out Page Requests
        $sPage='home.php';
	$variables['current_page']='home';
	renderLayoutWithContentFile(isset($sPage)?$sPage:'home.php', $variables);
}

function checkIncludes($sPath)
{

	try {if(!file_exists($sPath))
	{
		throw new Exception('Could not find '.$sPath);}
	}
catch (Exception $e)
{
        $variables='';
	if(!function_exists('renderLayoutWithContentFile'))
	{
		Echo '<h3>' . $e->getMessage()." in file ".$e->getFile()." at line ".$e->getLine().'</h3><br /> This file is required before the program can continue.'; 
		die();
	}
	else
	{
		$variables['errors'][]=$e->getMessage()." in file ".$e->getFile()." at line ".$e->getLine().'</h3><br /> This file is required before the program can continue.';
                if(!isset($_SESSION['lang']))
                {
                    include(LANGUAGE_PATH.PHPFOX_DS.$_CONF['cpr']['settings']['default_language']);
                }
                renderLayoutWithContentFile('error.php', $variables); 
	}
}

return true;

}

function displayErrors($errno, $errstr)
{
 global $variables;
$variables['errors'][]="<b>Error:</b> [$errno] $errstr";

}

function esc_url($url) {
 
    if ('' == $url) {
        return $url;
    }
 
    $url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);
 
    $strip = array('%0d', '%0a', '%0D', '%0A');
    $url = (string) $url;
 
    $count = 1;
    while ($count) {
        $url = str_replace($strip, '', $url, $count);
    }
 
    $url = str_replace(';//', '://', $url);
 
    $url = htmlentities($url);
 
    $url = str_replace('&amp;', '&#038;', $url);
    $url = str_replace("'", '&#039;', $url);
 
    if ($url[0] !== '/') {
        // We're only interested in relative links from $_SERVER['PHP_SELF']
        return '';
    } else {
        return $url;
    }
}

?>
