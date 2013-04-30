$(function(){
	
	var methods = getFrontBoardMethods();
	var events = getFrontBoardEvents(methods);
	events.load();
	
	
});
function getFrontBoardEvents( method ) {
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
		},
		
		/*clicked events*/
		events : function(aControllerData) {
			
			$('.view_details_'+aControllerData.seq).live('click',function(){
				$('.review_content_'+aControllerData.seq).fadeOut('fast');
				$(this).closest('tr').next('tr.review_content_'+aControllerData.seq).fadeIn('slow');
				
				$('.productreview_board_content_'+aControllerData.seq+' .selected').removeClass('selected');
				$(this).closest('tr').addClass('selected');
			});
			
			$('.productreview_show_rows_'+aControllerData.seq).live('change',function(){
				var iPage = 1;
				
				/*do methods*/
				method.makeLoopHtml(iPage,aControllerData);
			});
			
			
			$('.productreview_board_pagination_'+aControllerData.seq+' li a,.productreview_board_pagination_'+aControllerData.seq+' p a').live('click',function(){
				$('.productreview_board_pagination_'+aControllerData.seq+' li a.current').removeClass('current');
				$(this).addClass('current');
				var iPage = $(this).attr('alt');
				
				/*do methods*/
				method.makeLoopHtml(iPage,aControllerData);
			});
			
		}
	}
}

function getFrontBoardMethods( ) {
	
	return {
		
		makeLoopHtml: function(iPage,aControllerData){
			/*pagination*/
			var iSeq = aControllerData.seq;
			var iTotCount = aControllerData.loopdata.length;
			var iLimit = parseInt($('.productreview_show_rows_'+aControllerData.seq).val());
			var aLoopData = aControllerData.loopdata;
			var iOffset = (iPage-1)*iLimit;
			
			/*char limit*/
			var iSubCharLimit = parseInt(aControllerData.settings.subject_char);
			var iProdCharLimit = parseInt(aControllerData.settings.product_char);
			
			common.pagination(iSeq,iPage,iTotCount,iLimit,"board");
			
			var sData = '';
				/*table head*/
				sData += '<table border="1" summary="">';
				sData += '<colgroup>';
				sData += '<col style="width:45px;">';
				sData += '<col style="width:60px;">';
				
				if(aControllerData.args.product_no == undefined ){
					sData += '<col style="width:140px;">';
				}
				
				sData += '<col style="width:auto;">';
				sData += '<col style="width:66px;">';
				sData += '<col style="width:100px;">';
				sData += '<col style="width:150px;">';
				sData += '<col style="width:80px;">';
				sData += ' </colgroup>';
				sData += '<thead>';
				sData += '<tr>';
				sData += '<th scope="col">';
				sData += ' No';
				sData += '</th>';
				sData += '<th scope="col"></th>';
				
				if(aControllerData.args.product_no == undefined ){
					sData += '<th scope="col" class="product">';
					sData += 'Product';
					sData += '</th>';
				}
				
				sData += ' <th scope="col">';
				sData += ' Subject';
				sData += ' </th>';
				sData += '<th scope="col">';
				sData += 'Rate';
				sData += '</th>';
				sData += '<th scope="col">';
				sData += 'Author';
				sData += '</th>';
				sData += '<th scope="col">';
				sData += ' Created';
				sData += '</th>';
				sData += '<th scope="col" class="count">';
				sData += 'Count';
				sData += '</th>';
				sData += '</tr>';
				sData += ' </thead>';
				sData += '<tbody>';
	        
	        
			$.each(aLoopData.slice(iOffset,(iOffset +iLimit)), function(key,val){
				
				sSelectedClass = (key === 0) ? 'class="selected"' : '';
				
					sData += '<tr '+sSelectedClass+'>';
					sData += '<td>'+val.no+'</td>';
					sData += '<td><a href="'+val.rno+'"><img src="'+val.rimg+'" alt=""  class="product"  /></a></td>';
					
					if(aControllerData.args.product_no == undefined ){
						sData += '<td class="product"><a href="'+val.rno+'" class="view_details" > '+val.pname.substring(0,iProdCharLimit)+'</a><br /><strong>'+val.product_price+'won</strong></td>';
					}
					
					sData += '<td class="subject"><a href="javascript:void(0);" class="view_details_'+aControllerData.seq+'" >'+val.rsub.substring(0,iSubCharLimit)+'</a></td>';
					sData += '<td><img src="http://img.echosting.cafe24.com/apps/photo-review/skin1/ico_star'+val.rpoint+'.png" alt="1 Point"></td>';
					sData += '<td>'+val.rwriter+'</td>';
					sData += '<td class="date">'+val.rdate+'</td>';
					sData += '<td class="count">'+val.rhit+'</td>';
					sData += '</tr>';
					
					
					sData += '<tr class="reviewArea review_content_'+aControllerData.seq+'"';
					sData += (key !== 0) ? 'style="display:none;" ' : '';
					sData += '>';
					sData += '<td  colspan="8">';
					sData += '<div class="review_images_wrap">';
					sData += '<a href="'+val.rno+'"><img src="'+val.rimg+'" alt=""/></a>';
					sData += '</div>';
					sData += '<div class="review_wrap">';
					sData += '<p>'+val.rcont+'</p>';
					sData += '</div>';
					sData += '</td>';
					sData += '</tr>';
			});
			
			sData += '</tbody>';
			sData += '</table>';
			
			$('.productreview_board_content_'+aControllerData.seq).html(sData);
			
		}
	}
}
