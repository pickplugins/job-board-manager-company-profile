jQuery(document).ready(function($){

	$(document).on('click','.company-tabs .tab-nav',function(){

		$(this).parent().parent().children('.tab-navs').children('.tab-nav').removeClass('active');
		$(this).addClass('active');
		id = $(this).attr('data-id');

		$(this).parent().parent().children('.tab-content').removeClass('active');
		$(this).parent().parent().children('.tab-content#'+id).addClass('active');

	})

});