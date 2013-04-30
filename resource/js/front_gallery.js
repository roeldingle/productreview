$(function(){
	
	var methods = getFrontGalleryMethods();
	var events = getFrontGalleryEvents(methods);
	events.load();
	
	
});
function getFrontGalleryEvents( method ) {
	return {
		
		load : function() {
			var self = this;
			/*php variables*/
			var aControllerData = {
				seq: '<?php echo $seq;?>',
				args: '<?php echo $args;?>',
				settings: '<?php echo $settings;?>',
				loopdata: '<?php echo $loopdata;?>'
			}
			
			/*omit double quote inside style attribute*/
			aControllerData.loopdata = aControllerData.loopdata.replace('style="','style=&quot;')
			aControllerData.loopdata = aControllerData.loopdata.replace('">','&quot;>');
			aControllerData.loopdata =  $.parseJSON(aControllerData.loopdata);
			
			/*args*/
			aControllerData.args =  $.parseJSON(aControllerData.args);
			
			/*settings*/
			aControllerData.settings =  $.parseJSON(aControllerData.settings);
			
			self.initialized(aControllerData);
			self.events(aControllerData);
		},
		
		initialized: function(aControllerData){
			/*content*/
			var iPage = 1;
			method.makeLoopHtml(iPage,aControllerData);
			method.changeGallery(aControllerData.seq);
		},
		
		/*clicked events*/
		events : function(aControllerData) {
			
			$('.preview_image_'+aControllerData.seq).live('click',function(){
				$(this).parent('li').siblings('.selected').removeClass('selected');
				$(this).closest('li').addClass('selected');
				method.changeGallery(aControllerData.seq,$(this));
			});
			
			$('.productreview_gallery_pagination_'+aControllerData.seq+' li a,.productreview_gallery_pagination_'+aControllerData.seq+' p a').live('click',function(){
				$('.productreview_gallery_pagination_'+aControllerData.seq+' li a.current').removeClass('current');
				$(this).addClass('current');
				var iPage = $(this).attr('alt');
				
				/*do methods*/
				method.makeLoopHtml(iPage,aControllerData);
				method.changeGallery(aControllerData.seq);
			});
			
			$('.productreview_gallery_'+aControllerData.seq+' .gallery_prev').live('click',function(){
				$('.productreview_gallery_content_'+aControllerData.seq+' li.selected').removeClass('selected').prev('li').addClass('selected');
				/*do methods*/
				method.changeGallery(aControllerData.seq);
			});
			
			$('.productreview_gallery_'+aControllerData.seq+' .gallery_next').live('click',function(){
				$('.productreview_gallery_content_'+aControllerData.seq+' li.selected').removeClass('selected').next('li').addClass('selected');
				/*do methods*/
				method.changeGallery(aControllerData.seq);
			});
			
		}
	}
}

function getFrontGalleryMethods( ) {
	return {
		
		changeGallery: function(seq){
			var elem = $('.productreview_gallery_content_'+seq+' .selected .preview_image_'+seq);
			var sImageSrc = elem.children('img').attr('src');
			var sProductName = elem.children('.subject.sub').text();
			var sSubject = elem.children('span.subject').text();
			var sContent = elem.children('span.content').text();
			var iIndex = parseInt(elem.attr('alt'))+1;
			var iLenght = $('.'+elem.attr('class').split(' ')[1]).length;
			
			$('.productreview_gallery_image_'+seq).hide();
			
			/*prev button*/
			if(iIndex <= 1){
				$('.productreview_gallery_'+seq+' .gallery_prev').addClass('disabled');
			}else{
				$('.productreview_gallery_'+seq+' .gallery_prev').removeClass('disabled');
			}
			
			if(iIndex >= iLenght){
				$('.productreview_gallery_'+seq+' .gallery_next').addClass('disabled');
			}else{
				$('.productreview_gallery_'+seq+' .gallery_next').removeClass('disabled');
			}
			
			/*distribute to dom*/
			$('.productreview_gallery_image_'+seq).attr('src',sImageSrc);
			$('.productreview_gallery_image_'+seq).fadeIn('slow');
			
			var sGalleryIndex = '<strong class="current">'+iIndex+'</strong> | <strong>'+iLenght+'</strong>';
			$('.productreview_gallery_index_'+seq).html(sGalleryIndex);
			
			var sDetails = '';
			sDetails += '<p class="subject" ><strong>Subject : </strong>'+sSubject+'</p>';
			sDetails += '<p class="content" >'+sContent+'</p>';
			
			$('.productreview-detail_'+seq).html(sDetails);
			
		},
	
		makeLoopHtml: function(iPage,aControllerData){
			
			/*pagination*/
			var iSeq = aControllerData.seq;
			var iTotCount = aControllerData.loopdata.length;
			var iLimit = 5;
			var aLoopData = aControllerData.loopdata;
			var iOffset = (iPage-1)*iLimit;
			
			/*char limit*/
			var iSubCharLimit = parseInt(aControllerData.settings.subject_char);
			var iProdCharLimit = parseInt(aControllerData.settings.product_char);
			
			
			common.pagination(iSeq,iPage,iTotCount,iLimit,"gallery");
			
			sData = '';
			$.each(aLoopData.slice(iOffset,(iOffset +iLimit)), function(key,val){
				
				sSelectedClass = (key === 0) ? 'class="selected"' : '';
				
				sData += '<li '+sSelectedClass+'>';
				sData += '<a href="javascript:void(0);" class="image preview_image_'+aControllerData.seq+'" alt="'+key+'"><img src="'+val['rimg']+'" alt=""><span class="subject" style="display:none">'+val.rsub.substring(0,iSubCharLimit)+'</span><span class="content" style="display:none"><p>'+val.rcont+'</p></span></a>';
				
				if(aControllerData.args.product_no == undefined ){
					
					var target = (aControllerData.settings.target === 'new') ? 'target="_blank"' : '';
					
					sData += '<p class="product">';
					sData += '<a href="'+val.rno+'" class="product_sub" '+target+' alt="" >'+val.pname.substring(0,iProdCharLimit)+'</a> '+val.product_price+'won';
					sData += '</p>';
				}
				
				sData += '<p class="star">';
				sData += '<img src="http://img.echosting.cafe24.com/apps/photo-review/skin1/ico_star'+val.rpoint+'.png" alt="'+val.rpoint+' Point"><strong>'+val.rwriter+'</strong>';
				sData += '</p><em>'+val.rdate+'</em>';
				sData += '</li>';
			});
			
			$('.productreview_gallery_content_'+aControllerData.seq).html(sData);
			
		}
	}
}
