<?php

require_once('lib/Common.php');
require_once('lib/DB.php');

class frontGallery extends Controller_Front
{
	private $iSeq;
	private $sPathUrl;
	private $aArgs;
	
	protected function run($aArgs)
	{
		$this->iSeq = $this->getSequence();
		$this->aArgs = $aArgs;
		$this->initTemplate();
		$this->assignData();
	}
	private function initTemplate()
	{
		$this->externalCSS('http://img.echosting.cafe24.com/css/module.css');
		$this->importCSS('common');
		$this->importJS('common');
		$this->setStatusCode('200');
	}
	
	private function getSettingData(){
		
		$libKey = libKey::APP_KEY;
		$aData = DB::select_all($libKey);
		return $aData[1];
	}
	
	private function assignData(){

		/*api path*/
		$sPathUrl = 'http://devsdk09.cafe24.com/test.xml';
		$sPruductNoUrl = (isset($this->aArgs['product_no'])) ? '?product_no='.$this->aArgs['product_no'] : '';
		$sUriExt = $sPruductNoUrl;
		$sPathUrl = $sPathUrl.$sUriExt;
		
		/*setting data*/
		$aSettingData = $this->getSettingData();
		
		/*pagination variables*/
		$iPage = (isset($this->aArgs['page'])) ? $this->aArgs['page'] : 1;
		$sHref = (isset($this->aArgs['product_no'])) ? '?product_no='.$this->aArgs['product_no'] : '';
		
		/*data to loop*/
		$aLoopData = Common::getXmlData($this->aArgs,$sPathUrl,$aSettingData);
		
		/*js data*/
		$aJsData['seq'] = $this->iSeq;
		$aJsData['loopdata'] = json_encode($aLoopData);
		$aJsData['args'] = json_encode($this->aArgs);
		$aJsData['settings'] = json_encode($aSettingData);
		$this->importJS('front_gallery',$aJsData);
		
		/*content data*/
		$sContent = '<ul class="productreview-list_'.$this->iSeq.'"></ul>';
		
		/*product gallery details*/
		$sProductGalleryDetails = '<div class="productreview-detail_'.$this->iSeq.'"><p class="subject">dfdf</p><p class="content">dfd</p></div>';
		
		
		
		/*assign data*/
		$aData = array(
				'title' => ucwords($aSettingData['review_title']),
				'total_reviews' => count($aLoopData),
				'gallery_class' => 'productreview_gallery_'.$this->iSeq,
				'gallery_image_class' => 'productreview_gallery_image_'.$this->iSeq,
				'gallery_index_class' => 'productreview_gallery_index_'.$this->iSeq,
				'details_class' => 'productreview-detail_'.$this->iSeq,
				'content_class' => 'productreview_gallery_content_'.$this->iSeq,
				'pager_class' => 'productreview_gallery_pagination_'.$this->iSeq
		);
		
		foreach($aData as $key=>$val){
			$this->assign($key, $val );
		}
		
		
	}
	
}