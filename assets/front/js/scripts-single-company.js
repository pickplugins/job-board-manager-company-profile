jQuery(document).ready(function($){



	$(document).on('click', '.company-single .follow-button', function() {
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

	$(document).on('click','.company-single .company-tabs .tab-nav',function(){

		$(this).parent().parent().children('.tab-navs').children('.tab-nav').removeClass('active');
		$(this).addClass('active');
		id = $(this).attr('data-id');

		$(this).parent().parent().children('.tab-content').removeClass('active');
		$(this).parent().parent().children('.tab-content#'+id).addClass('active');

	})

});