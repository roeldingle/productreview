$(function(){
	
	var indexMethods = getIndexMethods();
	var indexEvents = getIndexEvents(indexMethods);
	indexEvents.load();
	
	
	
});

function getIndexEvents( method ) {
	return {
		
		load : function() {
			var self = this;
			self.events();
		},
		
		/*clicked events*/
		events : function() {
			
			$('.btnSubmit').live('click',function(){
				var form = $(this).closest('form');
				method.saveSettings(form);
			});
			
		}
	}
}

function getIndexMethods() {
	
	return {
		saveSettings: function(form){
			var bConfirm = confirm("Are you sure to save?")
			
			if(bConfirm){
				
				var bValid = $(form).validateForm();
				
				
				if(bValid === true){
					$.ajax({
						type:"GET",
						url: "[link=api/Class]",
						data:{
							form: form.serialize(),
							process: 'saveSettings'
							},
						success: function(response){
							if(response.Data === true){
								alert('Saved');
								location.href="[link=admin/index]";
							}else{
								alert('Error saving');
							}
							
						}
					});
					
					
				}
				
			}
		}
	}
	
}