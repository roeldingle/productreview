<?php

require_once('lib/DB.php');
require_once('lib/Common.php');

/*
 * controller to view event listing
 * */
class adminIndex extends Controller_Admin
{
	/*class construct*/
    protected function run($aArgs){
    	$sProcess = ($aArgs['process']) ? : 'init';
    	$this->$sProcess($aArgs);
    	
    }
    
    private function init($aArgs){
    	$this->initTemplate();
    	$this->assignData($aArgs);
    	$this->setView();
    }
    
    /*template getter*/
    private function initTemplate(){
    	$this->importJS('index');
    	$this->importJS('libs/jquery.validate.mod');
    	$this->externalCSS('http://img.echosting.cafe24.com/css/module.css');
    	$this->importCSS('common');
    }
    
    /*template setter*/
    private function setView(){
    	$bView = $this->View();
    	if ($bView!==false) {
    		$this->setStatusCode('200');
    	}
    }
    
    /*assign table listing and pagination*/
    private function assignData($aArgs)
    {
    	$libKey = libKey::APP_KEY;
		$aData = DB::select_all($libKey);
		
		$this->assign('aData', $aData[1]);
		
    }
    
    
   
}

