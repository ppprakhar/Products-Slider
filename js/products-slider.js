(jQuery)(function($){
	$(document).ready(function(){
		$('select[name="post_types"]').change(function(){
			var v = $(this).val();
			if( v !== ''){
				$.ajax({
					type: 'POST',
					url: ajaxurl,
					type: 'json',
					data: {
						action: products_slider.action,
						post_type : v
					},
					success: function(res){
						alert(res);
					}
				});
			}

		});
	});
});