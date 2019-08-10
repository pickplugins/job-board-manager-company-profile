<?php
/*
* @Author 		ParaTheme
* Copyright: 	2015 ParaTheme
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 




add_action( 'job_bm_action_company_single_main', 'job_bm_template_company_single_header', 10 );
add_action( 'job_bm_action_company_single_main', 'job_bm_template_company_single_reviews', 10 );
add_action( 'job_bm_action_company_single_main', 'job_bm_template_company_single_meta', 10 );
add_action( 'job_bm_action_company_single_main', 'job_bm_template_company_single_job_list', 20 );	
add_action( 'job_bm_action_company_single_main', 'job_bm_template_company_single_related', 20 );	
//add_action( 'job_bm_action_company_single_main', 'job_bm_template_company_single_sidebar', 20 );
//add_action( 'job_bm_action_company_single_main', 'job_bm_template_company_single_css', 20 );





function get_custom_post_type_template_company($single_template) {
     global $post;

     if ($post->post_type == 'company') {
          $single_template = job_bm_cp_plugin_dir . 'templates/company-single.php';
     }
     return $single_template;
}
add_filter( 'single_template', 'get_custom_post_type_template_company' );






if ( ! function_exists( 'job_bm_template_company_single_related' ) ) 
{
function job_bm_template_company_single_related() 
{
	$check = 0;
	$id = get_the_ID();
	$job_bm_cp_city = get_post_meta( $id, 'job_bm_cp_city', true );
	
	
	$job_bm_cp_type = get_post_meta( $id, 'job_bm_cp_type', true );
	
	if(empty($job_bm_cp_type)){
		$job_bm_cp_type = array();
		}
	
	foreach( $job_bm_cp_type as $key=>$value ) {
		$job_bm_cp_type = $value;
	}
	
	$wp_query = new WP_Query(
		array (
			'post_type' => 'company',
			'orderby' => 'date',
			'order' => 'DESC',
			'meta_query' => array(
				'relation' => 'OR',
				array(
					'key' => 'job_bm_cp_type',
					'value' => $job_bm_cp_type,
					'compare' => 'LIKE',
				),
				array(
					'key' => 'job_bm_cp_city',
					'value' => $job_bm_cp_city,
					'compare' => 'LIKE',
				),
			)
		) );
	
	$html = '';	
	$html .= '<h2 class="related-company-header">'.__('Related Company','job-board-manager-company-profile').'</h2>';
	$html .= '<div class="related-company-container">';
	
	if ( $wp_query->have_posts() ) :
		while ( $wp_query->have_posts() ) : $wp_query->the_post();	
	if( $id != get_the_ID() ): $check = 1;
		
		$html .= '<div class="single-company">';
		
		$job_bm_cp_logo = get_post_meta( get_the_ID(), 'job_bm_cp_logo', true);

		$thumb = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'full' );
		$thumb_url = $thumb['0'];	
		
		
		if(empty($thumb_url)){
			
			$thumb_url = job_bm_cp_plugin_url.'assets/global/images/company.png';
			
			}
		
		$html .= '<div class="thumb"><a href="'.get_the_permalink().'"><img src="'.$thumb_url.'" /></a></div>';
		$html .= '<span itemprop="name" class="name"><a href="'.get_the_permalink().'">'.get_the_title().'</a></span>';	

		$html .= '</div>'; // single company
			
	endif;		
		endwhile;
	wp_reset_query();
	
	$html .= '</div>'; // company container
	endif;		
	
	if ( $check == 1 ) echo $html;
}
}

if ( ! function_exists( 'job_bm_template_company_single_header' ) ) {

	
	function job_bm_template_company_single_header() {
				
		require_once( job_bm_cp_plugin_dir. 'templates/company-single-header.php');
	}
}




if ( ! function_exists( 'job_bm_template_company_single_meta' ) ) {

	
	function job_bm_template_company_single_meta() {
				
		require_once( job_bm_cp_plugin_dir. 'templates/company-single-meta.php');
	}
}

if ( ! function_exists( 'job_bm_template_company_single_reviews' ) ) {

	
	function job_bm_template_company_single_reviews() {
				
		require_once( job_bm_cp_plugin_dir. 'templates/company-single-reviews.php');
	}
}




if ( ! function_exists( 'job_bm_template_company_single_job_list' ) ) {

	
	function job_bm_template_company_single_job_list() {
				
		require_once( job_bm_cp_plugin_dir. 'templates/company-single-job-list.php');
	}
}





if ( ! function_exists( 'job_bm_template_company_single_css' ) ) {

	
	function job_bm_template_company_single_css() {
				
		require_once( job_bm_cp_plugin_dir. 'templates/company-single-css.php');
	}
}








