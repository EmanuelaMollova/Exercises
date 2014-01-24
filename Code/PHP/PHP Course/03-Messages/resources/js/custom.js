$( document ).ready(function() {
	$('#fixed_date').on('click', function(){
		$('#dmy').removeClass('hidden');
	});
	
	$('#all_dates').on('click', function(){
		$('#dmy').addClass('hidden');		
	});
});