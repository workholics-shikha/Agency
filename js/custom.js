jQuery(function ($) {
	
	 $("#package_form").validate({
                    rules:{
                        package_name: {
                            required: true,
                        },package_title:{
                            required: true
                        },package_amount: {
                            required: true,
                        },days:{
                            required: true
                        },package_image: {
                            accept:"image/*"
                        },image: {
                            accept:"image/*"
                        }
					
				}
		  
				 
	});
		 
	$("#blog_form").validate({
			rules:{
				blog_image: {
                            accept:"image/*"
                        }
			}
	})
	
});