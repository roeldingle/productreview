<?php

class Common extends Controller_AdminExec
{
	protected function run($aArgs)
	{}
	
	public function getProductdata($sPathUrl,$aSettingData){
		
		$sXml =  'a:3:\{s:4:"code";s:3:"200";s:7:"message";s:2:"OK";s:4:"data";a:5:\{s:12:"total_record";i:1;s:11:"total_pages";d:1;s:12:"current_page";i:1;s:13:"current_where";a:4:\{s:10:"search_key";s:10:"product_no";s:12:"search_value";s:2:"66";s:14:"search_add_key";N;s:16:"search_add_value";N;\}s:8:"products";a:1:\{i:0;a:78:\{s:10:"product_no";i:66;s:12:"product_name";s:16:"blow jk (2color)";s:13:"product_price";i:45000;s:12:"product_code";s:2:"66";s:12:"product_made";s:0:"";s:16:"product_img_tiny";s:59:"http://devsdk09.cafe24.com/web/product/tiny/devsdk09_66.jpg";s:17:"product_img_small";s:60:"http://devsdk09.cafe24.com/web/product/small/devsdk09_66.jpg";s:18:"product_img_medium";s:61:"http://devsdk09.cafe24.com/web/product/medium/devsdk09_66.jpg";s:15:"product_img_big";s:58:"http://devsdk09.cafe24.com/web/product/big/devsdk09_66.jpg";s:15:"product_summary";s:0:"";s:19:"product_description";s:0:"";s:11:"product_buy";i:10;s:14:"product_custom";i:0;s:11:"product_min";i:0;s:16:"stock_warn_value";i:0;s:12:"remain_stock";i:0;s:12:"manage_stock";s:1:"C";s:12:"stock_d_type";s:1:"I";s:10:"is_display";s:1:"T";s:7:"made_in";s:0:"";s:15:"shipping_method";N;s:14:"global_mileage";s:1:"F";s:9:"is_shared";s:1:"F";s:11:"shared_date";N;s:9:"commision";N;s:14:"commision_type";s:1:"P";s:12:"mileage_type";s:1:"P";s:13:"mileage_value";i:0;s:10:"has_option";s:1:"T";s:7:"option1";N;s:7:"option2";N;s:7:"option3";N;s:11:"option_type";s:1:"E";s:17:"option1_necessary";s:1:"F";s:17:"option2_necessary";s:1:"F";s:17:"option3_necessary";s:1:"F";s:10:"option_add";s:1:"F";s:15:"add_option_name";s:0:"";s:11:"supplier_id";s:8:"devsdk09";s:18:"is_global_shipping";s:1:"T";s:12:"shipping_etc";N;s:8:"hitcount";i:0;s:10:"is_deleted";s:1:"F";s:14:"streaming_path";s:10:"<<500<<435";s:7:"is_open";N;s:7:"is_gift";s:1:"F";s:15:"order_min_price";i:0;s:15:"order_max_price";i:0;s:10:"gift_price";i:0;s:11:"product_max";i:0;s:15:"ma_product_code";s:0:"";s:10:"print_date";s:0:"";s:12:"release_date";s:0:"";s:9:"ship_type";s:1:"X";s:8:"ship_fee";i:0;s:18:"product_price_type";s:1:"F";s:16:"product_max_type";s:1:"F";s:10:"event_type";s:1:"T";s:10:"is_soldout";s:1:"F";s:9:"prd_brand";s:0:"";s:9:"prd_model";s:0:"";s:9:"item_name";s:0:"";s:20:"prd_main_category_no";i:35;s:17:"mileage_used_type";s:1:"B";s:16:"prd_tax_type_per";i:10;s:15:"prd_tax_decimal";s:1:" ";s:13:"prd_price_org";i:40909;s:13:"prd_price_tax";i:4091;s:11:"product_tag";s:0:"";s:15:"is_auto_soldout";N;s:17:"naver_kshop_event";s:0:"";s:20:"naver_used_exception";N;s:24:"exception_member_mileage";s:1:" ";s:10:"review_cnt";i:21;s:11:"category_no";i:35;s:20:"producyt_modify_date";s:26:"2012-09-11 10:26:17.081609";s:16:"product_reg_date";s:26:"2012-09-11 10:26:17.081609";s:19:"product_detail_link";s:36:"http://devsdk09.cafe24.com/surl/P/66";\}\}\}\}';
		$sXml = str_replace('\\','',$sXml);
		$aXml = unserialize($sXml);
		
		$aProductData = $aXml;
			
		foreach($aProductData as $k=>$v){
			$aProductData = $v['products'];
		}
		
		return $aProductData;
	}
	

	public function getXmlData($aArgs,$sPathUrl,$aSettingData){
		
		if(isset($aArgs['product_no'])) {
			$aProductData = Common::getProductdata($sPathUrl,$aSettingData);
		}else{
			$aProductData = false;
		}
	
	
		$aData = @simplexml_load_string(Common::file_get_contents_utf8($sPathUrl),'SimpleXMLElement', LIBXML_NOCDATA);
	
		$aReturnData = array();
	
			if($aProductData != false){
				
				$aApiData = array(
						'no' => iconv('euc-kr','UTF-8//IGNORE',$aProductData[0]['product_no']),
						'rno' => iconv('euc-kr','UTF-8//IGNORE',$aProductData[0]['product_detail_link']),
						'rimg' => iconv('euc-kr','UTF-8//IGNORE',$aProductData[0]['product_img_big']),
						'rsub' => iconv('euc-kr','UTF-8//IGNORE',$aProductData[0]['product_summary']),
						'rcont' => iconv('euc-kr','UTF-8//IGNORE',$aProductData[0]['product_description']),
						'rpoint' => 1,
						'rwriter' => iconv('euc-kr','UTF-8//IGNORE',$aProductData[0]['product_made']),
						'rdate' => iconv('euc-kr','UTF-8//IGNORE',$aProductData[0]['product_reg_date']),
						'rhit' => iconv('euc-kr','UTF-8//IGNORE',$aProductData[0]['hitcount']),
							
						/*product data*/
						'pno' => $aProductData[0]['product_no'],
						'pname' => $aProductData[0]['product_name'],
						'product_price' => $aProductData[0]['product_price']
				);
		
				array_push($aReturnData,$aApiData);
		
			}else{
				foreach($aData->searchkey as $key=>$val){
					foreach($val as $key=>$val){
							
						/*limit for product name*/
						$aApiData = array(
								'no' => (string)$val->no,
								'rno' => (string)$val->pno,
								'rimg' => (string)$val->rimg,
								
								/*limited*/
								'rsub' => (string)$val->rsub,
								'rcont' => (string)$val->rcont,

										
								'rpoint' => (string)$val->rpoint,
								'rwriter' => (string)$val->rwriter,
								'rdate' => (string)$val->rdate,
								'rhit' => (string)$val->rhit,
						
								/*product data*/
								'pno' => $aProductData[0]['product_no'],
								'pname' => 'Static product name',
								'product_price' => 0
						);
						array_push($aReturnData,$aApiData);
				
					}
				}
			}	
		
		
				
			
		return $aReturnData;
	}
	
	
	
	
	public function file_get_contents_utf8($fn) {
		$content = file_get_contents($fn);
		return mb_convert_encoding($content, 'cp949','euc-kr');
	}
	
    
 	
	
	
	
}