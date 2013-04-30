<?php

/*
 * @description
 * 	->library class for redis data manipulation
 * 	->uses redis HASH data type
 * 
 * @implementation
 * <?php
 * require_once('lib/DB.php');
 * class adminIndex extends Controller_Admin
 * 	{
 * 
 * 	}
 * ?>
 * 
 * */

class DB extends Controller_AdminExec
{
	protected function run($aArgs)
	{
		
	}
	
	/*
	* @description
	* 	->select a set of redis data
	*
	* @params
	* 	$libKey -> (string) library defined key
	* 	$iId -> (int) selected set of redis data
	*
	* @implementation
	* 
	* 	php
	*		$iId = $aArgs['seq'];
	*		$libKey = libKey::BA_KEY;
	*
	* 		$aData = DB::select($libKey,$iId);
	*
	* */	
	
	public function select($libKey,$aId){
		$aData = $this->Redis->HGET($libKey, intval($aId));
		$aData = array($aData);
		foreach( $aData as $key=>$value) {
			$aData[$key] = unserialize($value);
	
		}
		
		
		return $aData[0];
		
	}
	
	
	/*
	 * @description
	 * 	->insert redis data
	 * 
	 * @params
	 * 	$libKey -> (string) library defined key
	 * 	$aData -> (array) data to store/insert
	 * 
	 * @implementation
	 * 
	 * 	php
	 * 		$libKey = libKey::BA_KEY;
	 * 		$aData = array();
	 *  	$aData['seq'] = $this->Redis->incr( libKey::BA_KEY_SEQ );
	 * 		$aData['active'] = 1;
	 * 		$aData['field_array'] = array(
	 * 			"key1" => "value 1",
	 * 			"key2" => "value 2"
	 * 		);
	 * 		DB::insert($libKey,$aData);
	 * 
	 * */
	
	public function insert($libKey,$aData){
		
		$sDataSerial = serialize($aData);
		$iResult = $this->Redis->HSET( $libKey ,$aData['seq'], $sDataSerial );
		
		return ( $iResult > 0 ) ? true : false;
		
		//return $sDataSerial;
	}
	
	/*
	* @description
	* 	->update redis data
	* 	->will get delete selected set of data and replace with modified data
	*
	* @params
	* 	$libKey -> (string) library defined key
	* 	$iId -> (int) selected set of redis data
	* 	$aData -> (array) data to store/insert
	*
	* @implementation
	* 
	* 	html
	* 	<?php foreach($aData as $k=>$v) { ?>
	* 		<input type="checkbox" name="seq" value="<?= $v['seq']; >" />
	* 	<?php } ?>
	* 
	* 	php
	* 		$libKey = libKey::BA_KEY;
	*		$iId = $aArgs['seq'];
	* 		$aData = array();
	*   	$aData['seq'] = $this->Redis->incr( libKey::BA_KEY_SEQ );
	* 		$aData['active'] = 1;
	* 		$aData['field_array'] = array(
	* 			"key1" => "value 1",
	* 			"key2" => "value 2"
	* 		);
	* 		DB::update($libKey,$iId,$aData);
	*
	* */
	
	public function update($libKey,$iId,$aData){
		$sDataSerial = serialize($aData);
		if(self::delete($libKey,$iId)){
			$iResult = $this->Redis->HSET( $libKey ,intval($iId), $sDataSerial );
		}
		return ( $iResult > 0 ) ? true : false;
	}
	
	/*
	* @description
	* 	->delete a set of redis data
	*
	* @params
	* 	$libKey -> (string) library defined key
	* 	$iId -> (int) selected set of redis data
	*
	* @implementation
	*
	* 	php
	*		$iId = $aArgs['seq'];
	*		$libKey = libKey::BA_KEY;
	*
	* 		DB::delete($libKey,$iId);
	*
	* */
	
	public function delete($libKey,$iId){
		$bResult = $this->Redis->HDEL($libKey,intval($iId));
		return $bResult;
	}
	
	/*
	* @description
	* 	->select all redis data
	*
	* @params
	* 	$libKey -> (string) library defined key
	*
	* @implementation
	*
	* 	php
	*		$libKey = libKey::BA_KEY;
	* 		$aData = DB::select_all($libKey);
	*
	* */
	
	public function select_all($libKey){
		$aData = $this->Redis->HGETALL($libKey);
		foreach( $aData as $key=>$value) {
			$aData[$key] = unserialize($value);
		}
		
		return DB::_array_sort($aData,'seq',SORT_DESC);
	}
	
	/*
	 * @description
	* 	->delete all redis data
	*
	* @params
	* 	$libKey -> (string) library defined key
	*
	* @implementation
	*
	* 	php
	*		$libKey = libKey::BA_KEY;
	* 		DB::delete_all($libKey);
	*
	* */
	
	public function delete_all($libKey){
		$bResult = $this->Redis->DEL($libKey);
		return $bResult;
	}
	
	
	/*
	 * @description
	* 	->sort array via array key
	*
	*  @params
	* 	$array -> (array) array to sort
	* 	$on -> (string) array key to sort with
	*   $order -> () sort to ascending or descending
	*
	* @implementation
	*
	* foreach( $aData as $key=>$value) {
	*		$aData[$key] = unserialize($value);
	*	}
	*
	*  return array_sort($aData,'seq',SORT_DESC);
	*
	* */
	public function _array_sort($array, $on, $order=SORT_ASC)
	{
	$new_array = array();
	$sortable_array = array();
	
	if (count($array) > 0) {
	foreach ($array as $k => $v) {
	if (is_array($v)) {
	foreach ($v as $k2 => $v2) {
	if ($k2 == $on) {
	$sortable_array[$k] = $v2;
	}
	}
	} else {
	$sortable_array[$k] = $v;
	}
	}
	
	switch ($order) {
	case SORT_ASC:
	asort($sortable_array);
	break;
	case SORT_DESC:
	arsort($sortable_array);
	break;
	}
	
	foreach ($sortable_array as $k => $v) {
	$new_array[$k] = $array[$k];
	}
	}
	
	return $new_array;
	}
	
	
}