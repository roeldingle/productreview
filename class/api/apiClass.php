<?php
require_once('lib/Common.php');
require_once('lib/DB.php');

class apiClass extends Controller_Api
{
	
	protected function get($aArgs)
	{
		$sProcess = $aArgs['process'];
		
		switch($sProcess){
			
			case "saveSettings":
				$iId = 1;
		    	$libKey = libKey::APP_KEY;
		    	$aData = array();
		    	parse_str($aArgs['form'],$aData);
		    	
		    	/*validate*/
		    	$aValidData = array(
		    			'seq' => (is_string($aData['seq']) && trim($aData['seq']) != '') ? trim($aData['seq']) : 1,
		    			'active' => (is_string($aData['active']) && trim($aData['active']) != '') ? htmlspecialchars(trim($aData['active'])) : false,
		    			'datereg' => (is_string($aData['datereg']) && trim($aData['datereg']) != '') ? htmlspecialchars(trim($aData['datereg'])) : time(),
		    			'review_title' => (is_string($aData['review_title']) && trim($aData['review_title']) != '') ? trim($aData['review_title']) : false,
		    			'subject_char' => (is_string($aData['subject_char']) && trim($aData['subject_char']) != '') ? trim($aData['subject_char']) : false,
		    			'product_char' => (is_string($aData['product_char']) && trim($aData['product_char']) != '') ? trim($aData['product_char']) : false,
		    			'target' => (is_string($aData['target']) && trim($aData['target']) != '') ? trim($aData['target']) : false
		    	);
		    		
		    	/*validate*/
		    	foreach($aValidData as $k=>$v){
		    		if($v[$key] === false){
		    			$this->writeJS('alert("Invalid data ('.$key.').");');
		    			$this->writeJS('location.href="[link=admin/index]";');
		    			exit;
		    		}
		    	}
                
                if(is_array(DB::select($libKey,$iId))){
                    return DB::update($libKey,$iId,$aValidData);
                }else{
                    return DB::insert($libKey,$aValidData);
                }
				break;
		}

	}
	
	

}