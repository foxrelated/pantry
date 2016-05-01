<?php

class phpfoxCPR_service
{

    private $_validSettings='';
    private $_errors=array();
    private $_variables=array();

    function __construct($_CONF)
    {
        $this->_messages='';
        $this->_CONF=$_CONF;

        // get language support for messages
        include LANGUAGE_PATH.PHPFOX_DS.$this->_CONF['cpr']['settings']['default_language'];
        $this->_variables=$variables;

        $this->_oDBObj=$this->_getDbase();
        if(!is_object($this->_oDBObj))
        {
            $this->_errors[]=$this->_oDBObj;
        }
    }

    function getInfo()
    {
        if(is_object($this->_oDBObj))
        {
            return 'true';
        }
        else
        {
            return false;
        }
    }

    function getErrors()
    {
        return $this->_errors;
    }
    
    function getConfigSetting($setting)
    {
//        var_dump($this->_CONF['cpr']);
        if(isset($this->_CONF['cpr']['settings'][$setting]))
        {
             return $this->_CONF['cpr']['settings'][$setting]; 
        }
    }

    function GetFoxUser($sUser)
    {
        $Setup = $this->_oDBObj->prepare("
            SELECT user_id, email, full_name, password, password_salt, user_group_id 
            FROM  ".$this->_CONF['db']['prefix']."user 
            WHERE email=:email AND user_group_id=:ugId");
        $Setup->bindValue(':email', $sUser, PDO::PARAM_STR);
        $Setup->bindValue(':ugId', (int)1, PDO::PARAM_INT);
        $Setup->execute();
        $aUser = $Setup->fetch(PDO::FETCH_ASSOC);

        if(isset($aUser['password']))
        {
            return $aUser;
        }
        else
        {
                $aUser['user_id']=0;
                return $aUser;
        }
    }
    
    function setLoginData($iId)
    {
        $now = time();
        $ipaddress = filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP);
        
        $sQry =  "UPDATE ".$this->_CONF['db']['prefix']."user "
                . "set last_login = :last_login, "
                . "last_ip_address = :last_ip_address "
                . "WHERE `user_id` = :user_id";

        $stmt = $this->_oDBObj->prepare($sQry);
        $stmt->bindParam(':last_login', $now);
        $stmt->bindParam(':last_ip_address', $ipaddress);
        $stmt->bindParam(':user_id', $iId);
        return $stmt->execute();

    }
    
    function setLoginAttempt($iId)
    {
        
        $now = time();
        $iIdCheck=isset($iId)?$iId:0;
        $typeid = 'pantry_session_login';
        $ipaddress = filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP);
 
        $stmt = $this->_oDBObj->prepare("INSERT INTO ".$this->_CONF['db']['prefix']."user_ip 
                    (user_id, type_id, ip_address, time_stamp)
            VALUES (:user_id, :type_id, :ip_address, :time_stamp)");
        $stmt->bindParam(':user_id', $iIdCheck);
        $stmt->bindParam(':type_id', $typeid);
        $stmt->bindParam(':ip_address', $ipaddress);
        $stmt->bindParam(':time_stamp', $now);
        $stmt->execute();
        
        return false;
    }
    
    function checkbrute($user_id) 
    {
        
        // Get timestamp of current time 
        $now = time();

        // All login attempts are counted from the past 2 hours. 
        $valid_attempts = $now - ($this->getConfigSetting('bruteForce_span') * 60 * 60);
        $type_id = "pantry_session_login";
        
        $sQueryAttempts="SELECT time_stamp FROM ".$this->_CONF['db']['prefix']."user_ip	WHERE `user_id` = :user AND time_stamp > :valid AND type_id = :typeid;";
        $stmt = $this->_oDBObj->prepare($sQueryAttempts);
        $stmt->bindParam(':user', $user_id);
        $stmt->bindParam(':valid', $valid_attempts);
        $stmt->bindParam(':typeid', $type_id);
        
        if($result = $stmt->execute())
        {
            $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($stmt->rowCount() > $this->getConfigSetting('bruteforce_limit')) 
            {
                return true;
            } 
            else 
            {
                return false;
            }
        }
    }

    function getLanguages()
    {
        $aLangBuild=array();
        $aLangFiles = array_diff(scandir(LANGUAGE_PATH), array('..', '.'));
        foreach ($aLangFiles as $sLangFile)
        {
            //preg_match("/lang_[a-z]{2,2}_.+\.php/u", $sLangFile)
            if(preg_match("/lang_[a-z]{2,2}-?[a-z]?[a-z]?_.+\.php/u", $sLangFile))
            {
                $aTemp=explode('_', $sLangFile);
                $sLabel=str_replace('.php', '', $aTemp[2]);
                if(file_exists(IMAGE_LAYOUT_PATH.PHPFOX_DS.$aTemp[1].'.png'))
                {
                     $aLangBuild[$aTemp[1]]['img']=PHPFOX_CPR_BASEURL.'img/layout/'.$aTemp[1].'.png';
                }
                else
                {
                    $aLangBuild[$aTemp[1]]['img']=PHPFOX_CPR_BASEURL.'img/layout/xx.png';
                }
                $aLangBuild[$aTemp[1]]['label']=$sLabel;
            }
        }
        return $aLangBuild;
    }
    
    function prefered_language($sHttpAcceptLanguage) 
    {

        $available_languages = array_flip(array_keys($this->getLanguages()));

        $alangs=array();
        $matches=array();
        preg_match_all('~([\w-]+)(?:[^,\d]+([\d.]+))?~', strtolower($sHttpAcceptLanguage), $matches, PREG_SET_ORDER);

        foreach($matches as $match) {

            list($a, $b) = explode('-', $match[1]) + array('', '');
            $value = isset($match[2]) ? (float) $match[2] : 1.0;

            if(isset($available_languages[$match[1]])) {
                $alangs[$match[1]] = $value;
                continue;
            }

            if(isset($available_languages[$a])) {
                $alangs[$a] = $value - 0.1;
            }

        }
        arsort($alangs);

        return $alangs;
    }
    
    function getItem($iItem)
    {
        $sQry =  "SELECT * FROM ".$this->_CONF['db']['prefix']."items ";
        $sQry.="WHERE `item_id` = :item_id ";
        $stmt = $this->_oDBObj->prepare($sQry);
        $stmt->bindParam(':item_id', $iItem);
        $stmt->execute();
        $aItem=$stmt->fetch(PDO::FETCH_ASSOC);
        $aItem['use_by']=  date('M d, Y', $aItem['use_by']);
        return $aItem;
    }
    
    function getItemNames()
    {
        $sQry =  "SELECT distinct(name) FROM ".$this->_CONF['db']['prefix']."items ";
        $stmt = $this->_oDBObj->prepare($sQry);
        $stmt->execute();
        $aNames=$stmt->fetchAll(PDO::FETCH_ASSOC);

        $sQry =  "SELECT distinct(units) FROM ".$this->_CONF['db']['prefix']."items ";
        $stmt = $this->_oDBObj->prepare($sQry);
        $stmt->execute();
        $aUnits=$stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $sQry =  "SELECT distinct(size) FROM ".$this->_CONF['db']['prefix']."items ";
        $stmt = $this->_oDBObj->prepare($sQry);
        $stmt->execute();
        $aSize=$stmt->fetchAll(PDO::FETCH_ASSOC);        
        
        
        return array($aNames, $aUnits, $aSize);
    }
    
    
    function addItem($aItem)
    {
        if($aItem['item_id'] > 0)
        {
            $stmt = $this->_oDBObj->prepare("INSERT INTO ".$this->_CONF['db']['prefix']."items  
                        (item_id, name, gf_flag, size, units, quantity, location, shelf, use_by, upc)
                VALUES (:item_id, :name, :gf_flag, :size, :units, :quantity, :location, :shelf, :use_by, :upc)"); 
            
            $stmt->bindParam(':item_id', $aItem['item_id']);
        }
        else
        {
            $stmt = $this->_oDBObj->prepare("INSERT INTO ".$this->_CONF['db']['prefix']."items  
                        (name, gf_flag, size, units, quantity, location, shelf, use_by, upc)
                VALUES (:name, :gf_flag, :size, :units, :quantity, :location, :shelf, :use_by, :upc)");
        }
        
        $stmt->bindParam(':name', $aItem['name']);
        $stmt->bindParam(':gf_flag', $aItem['gf_flag']);
        $stmt->bindParam(':size', $aItem['size']);
        $stmt->bindParam(':units', $aItem['units']);
        $stmt->bindParam(':quantity', $aItem['quantity']);
        $stmt->bindParam(':location', $aItem['location']);
        $stmt->bindParam(':shelf', $aItem['shelf']);
        $stmt->bindParam(':use_by', $aItem['use_by']);
        $stmt->bindParam(':upc', $aItem['upc']);
        return $stmt->execute();
    }
    
    function getItems($sSort)
    {
        $sSort =  empty($sSort)?"use_by":$sSort;
        $sQueryItems="SELECT * FROM ".$this->_CONF['db']['prefix']."items ORDER BY ".$sSort." ASC;";
        //die($sSort);
        $statement = $this->_oDBObj->prepare($sQueryItems);
        $statement->execute();

        $aItems=$statement->fetchAll(PDO::FETCH_ASSOC);
        foreach($aItems as $key => $aValue)
        {
            $aItems[$key] = array('quantity' => $aValue['quantity']) + $aValue;
            $aItems[$key]['use_by'] =  $aValue['use_by']==0?'':date("Y-m-d", $aValue['use_by']);
            $aItems[$key]['upc'] =  $aValue['upc']==0?'':$aValue['upc'];
            $aItems[$key]['gf_flag'] =  $aItems[$key]['gf_flag']==1?'<img src="/img/layout/gf.png"/>':"";
        }
        return $aItems;
    }
    
    function incrItem($iItem, $bDown=false)
    {
        $sQry =  "UPDATE ".$this->_CONF['db']['prefix']."items SET `quantity` = `quantity`";
        $sQry.=$bDown?"-1 ":"+1 ";
        $sQry.="WHERE `item_id` = :item_id ";
        $stmt = $this->_oDBObj->prepare($sQry);
        $stmt->bindParam(':item_id', $iItem);
        return $stmt->execute();
    }
    
    function deleteItem($iItem)
    {
        $sql = "DELETE FROM ".$this->_CONF['db']['prefix']."items WHERE item_id =  :item_id";
        $stmt = $this->_oDBObj->prepare($sql);
        $stmt->bindParam(':item_id', $iItem, PDO::PARAM_INT);   
        return $stmt->execute();        
    }
    
    private function _getDbase()
    {
        $sPort = ($this->_CONF['db']['port'])?"port=".$this->_CONF['db']['port'].";":"";
        $sArgs = "host=".$this->_CONF['db']['host'].";dbname=".$this->_CONF['db']['name'].";".$sPort;

        switch($this->_CONF['db']['driver'])
        {
            case 'postgres':
                $dsn='pgsql:'.$sArgs;
                break;	
            case 'mssql':
                $dsn='mssql:'.$sArgs;
                break;
            case 'oracle':
                $dsn='oci:'.$sArgs;
                break;		
            case 'sqlite':
                $dsn='sqlite:'.$sArgs;
                break;
            default:
                $dsn='mysql:'.$sArgs;
                break;
        }

        try 
        {
            $oDBObj = new PDO($dsn, $this->_CONF['db']['user'], $this->_CONF['db']['pass'], array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        }
        catch (PDOException $e) 
        {
            $oDBObj = $e->getMessage () . "<br />"."%1MESSAGES_CHECK_SERVER_SETT";
        }

        return $oDBObj;
    }
}
?>