var common = {
		
		pagination: function(iSeq,iPage,iTotCount,iLimit,sType){
			
			var iPage = parseInt(iPage);
			
			if(iTotCount > 0){
				
				var iPages = Math.ceil(iTotCount / iLimit);
				var sData = '';
				
				sData += '<p class="prev"><a href="javascript:void(0);" ';
				
				iPrevPage = iPage;
				
				if((iPage-1) <= 0){
					sData += 'style="background:none;" onclick="return false"';
					iPrevPage = iPage+1;
				}
				
				sData += ' alt="'+(iPrevPage-1)+'"></a></p>';
				
				
				sData += '<ol class="eventbanner_pagination pagination np nm nl">';
				
				for(iCounter = 0;iCounter < iPages; iCounter++){
					var iPageStatusClass = (iCounter+1) == iPage ? 'class="current"': '';
					sData += '<li><a '+iPageStatusClass+' href="javascript:void(0);" alt="'+(iCounter+1)+'">'+(iCounter+1)+'</a></li>';
					
				}
				
				sData += '</ol>';
				
				sData += '<p class="next"><a href="javascript:void(0);" ';
				
				iNextPage = iPage;
				if(iPage >= iPages){
					sData += 'style="background:none;"';
					iNextPage = iPage-1;
				}
				
				sData += ' alt="'+(iNextPage+1)+'" ></a></p>';
				
				$('.productreview_'+sType+'_pagination_'+iSeq).html(sData);
				
			
			}
		}
		
}