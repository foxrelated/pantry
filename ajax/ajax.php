<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class phpfoxCPR_Ajax
{

    function __construct()
    {

        include(dirname(dirname(__FILE__)) . "/resources/config.php");
        include(PHPFOX_SETTINGS."/server.sett.php");
        $this->_CONF=$_CONF;
        include_once(LIBRARY_PATH."/service.class.php");
        $this->_oService=new phpfoxCPR_service($this->_CONF);
    }

    function getPlugin($qpp)
    {
        $qp=(int)filter_var($qpp, FILTER_SANITIZE_NUMBER_INT);
        list($sTargetPlugin, $sPath, $sFile)=$this->extractPlugin($qp);

        if(isset($sTargetPlugin) && file_exists($sTargetPlugin))
        {
            $result=file_get_contents($sTargetPlugin);
            $result_trim_i = preg_replace('/[\t]/', '    ', trim($result));
            $result_trim = htmlspecialchars($result_trim_i);
            echo '<span class="ui-widget-emphasis">Plugin file: '.$sFile.'<br />Located at: '.$sPath.'</span><pre><code>'.$result_trim.'</code></pre>';
            return true;
        }
        else
        {
            echo 'File '.$sTargetPlugin.' not found.';
            return true;
        }

    }

    private function extractPlugin($qp)
    {
        $sTargetPlugin='';
        $sFlagDisabled='';

        $sCache=FILE_PATH.PHPFOX_DS.'cache_plugin.php';

        $sCacheContents=file_get_contents($sCache);
        $aCacheContents=  explode('***', $sCacheContents);

        list($aPluginModules, $aPluginProducts)=unserialize($aCacheContents[1]);

        foreach($aPluginModules as $key=>$aPluginModule)
        {
            if(array_key_exists($qp, $aPluginModule))
            {
//                if(substr($aPluginModule[$qp], -5)=='(OFF)')
  //              {
    //                $aPluginModule[$qp]=substr_replace($aPluginModule[$qp],'',-5);
      //              $sFlagDisabled='_OFF';
        //        }

          //      $aPluginModule[$qp]=(substr($aPluginModule[$qp], -5)=='(OFF)')?substr_replace($aPluginModule[$qp],'',-5):$aPluginModule[$qp];

                $sTargetPlugin=PHPFOX_DIR.$aPluginModule[$qp].$key.$sFlagDisabled.'.php';
                $sPath=$aPluginModule[$qp];
                $sFile=$key.'.php';
            }
        }



        foreach($aPluginProducts as $key=>$aPluginModule)
        {
            if(array_key_exists($qp, $aPluginModule))
            {
                $sTargetPlugin=PHPFOX_DIR.$aPluginModule[$qp].$key.'.php';
                $sPath=$aPluginModule[$qp];
                $sFile=$key.'.php';
            }
        }

        return array($sTargetPlugin, $sPath, $sFile);
    }
    
    
    function adjustItem($item)
    {
        $bDown=$item<0?true:false;
        $iItem=abs((int)filter_var($item, FILTER_SANITIZE_NUMBER_INT));

        $bGood=$this->_oService->incrItem($iItem, $bDown);
        
        if($bGood)
        {
            return true;
        }
        else
        {
            echo 'Failed to update';
            return false;
        }

    }    
    
    function deleteItem($item)
    {
        $iItem=(int)filter_var($item, FILTER_SANITIZE_NUMBER_INT);

        $bGood=$this->_oService->deleteItem($iItem);
        if($bGood){$test='Good!';}
//if (window.console) console.log($test);        
        if($bGood)
        {
//            alert('Item Deleted');
//            return true;
            echo "true";
        }
        else
        {
            echo 'Failed to delete';
            return false;
        }
    }        
    
    
    
    
}
