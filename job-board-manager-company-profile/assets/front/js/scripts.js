jQuery(document).ready(function($)
	{


	
	
	
	
	
		
		$(document).on('click', '.company-single .follow-button', function()
			{
				//alert('Hello');
				company_id = $(this).attr('company_id');
				
				
				
					$.ajax(
						{
					type: 'POST',
					context: this,
					url:job_bm_cp_ajax.job_bm_cp_ajaxurl,
					data: {"action": "job_bm_cp_ajax_company_folowing", "company_id":company_id,},
					success: function(data)
							{	
								//
								
								var html = JSON.parse(data)
								
								var login_error = html['login_error'];
								var follow_status = html['follow_status'];
								var follow_text = html['follow_text'];								
								var follow_class = html['follow_class'];
								var follower_html = html['follower_html'];																		
								var follower_id = html['follower_id'];	
								
								//alert(follower_id);
								
								if(follow_status=='following'){
									$('.follower-list').prepend(follower_html);
									$(this).html(follow_text);	
									}
								else if(follow_status=='unfollow'){
									
									$('.follower-list .follower-'+follower_id).fadeOut();	
									$(this).html(follow_text);
									}
								else{
									$('.follow .status' ).html(login_error);
									}
								
								
								
								
							}
						});
				
			})
		
		
		
		
		
		
		
		
		
		
		
		$("#job_bm_company_name").attr('autocomplete','off');		
		$("#job_bm_company_name").wrap("<div id='company-name-wrapper'></div>");
		
		$("#company-name-wrapper").append("<div id='company-list'></div>");		

		$(document).on('keyup', '#job_bm_company_name', function()
			{
				
				var name = $(this).val();
				
				if(name=='' || name == null){
						$("#company-list").html('<div value="" class="item">Start Typing...<div>');
					}
				else{
					
					$.ajax(
						{
					type: 'POST',
					context: this,
					url:job_bm_cp_ajax.job_bm_cp_ajaxurl,
					data: {"action": "job_bm_cp_ajax_job_company_list", "name":name,},
					success: function(data)
							{	
								$("#company-list").html(data);	
							}
						});
					
					}
				
			})



		$(document).on('click', '#company-list .item', function(){
			
			
				var name = $(this).attr('company-data');
				var company_id = $(this).attr('company-id');			

				$("#job_bm_company_name").val(name);
				
				
					$.ajax(
						{
					type: 'POST',
					context: this,
					url:job_bm_cp_ajax.job_bm_cp_ajaxurl,
					data: {"action": "job_bm_cp_ajax_company_info_by_id", "company_id":company_id,},
					success: function(data)
							{	
								company = $.parseJSON(data);

								$('#job_bm_location').val(company.job_bm_cp_city);								
								$('#job_bm_address').val(company.job_bm_cp_address);
								$('#file_job_bm_company_logo').val(company.job_bm_cp_logo);								
								$('#job_bm_company_website').val(company.job_bm_cp_website);								
																
																
								
							}
						});
				
				
				
			
			})









	});