<?php

/*
* @Author 		ParaTheme
* Copyright: 	2015 ParaTheme
*/

if ( ! defined('ABSPATH')) exit;  // if direct access

	if ( get_query_var('paged') ) {
	
		$paged = get_query_var('paged');
	
	} elseif ( get_query_var('page') ) {
	
		$paged = get_query_var('page');
	
	} else {
	
		$paged = 1;
	
	}
	
	$wp_query = new WP_Query( array (
							'post_type' => 'company',
							'post_status' => 'publish',	
							'orderby' => 'date',
							'order' => 'DESC',				
							'posts_per_page' =>$post_per_page,
							'paged' => $paged,
						) );
						
				
	$html .= '<div class="company-list">';						
						
	if( $wp_query->have_posts() ) :
	while ($wp_query->have_posts()) : $wp_query->the_post();

		$company_post_data = get_post(get_the_ID());
		
		unset($meta_query);
		$meta_query[] = array(
						'key' => 'job_bm_company_name',
						'value' => $company_post_data->post_title,
						'compare' => '=',
					);
				
		$wp_query_custom = new WP_Query(
				array (
				'post_type' => 'job',
				'post_status' => 'publish',
				'meta_query' => $meta_query,
			) );
		
		if ( $allow_empty_job_showing == 'false' )
		{
			if ( $wp_query_custom->found_posts < 1 )
				continue;
		}
		
		
		$html .= '<div class="single">';

		$html .= '<div style="padding-bottom: 10px; padding-left: 10px; padding-top: 10px; padding-right: 10px;">';
		
		$job_bm_cp_logo = get_post_meta(get_the_ID(),'job_bm_cp_logo', true);
		if(empty($job_bm_cp_logo)){
			
			$job_bm_cp_logo = job_bm_cp_plugin_url.'assets/global/images/company.png';
			
			}
		
		
				$html .= '<img align="left" src=" '.$job_bm_cp_logo.' ">
					<div style="margin:0px 0px -5px 62px;">
						<div class="hotjobsCompanyName">
							<a href="'.get_permalink().'">'.$company_post_data->post_title.'</a>
						</div> 
						<ul class="hotjobsBullet">';
						
		//---------- loading job list START ----------------------------// 
				$count = 0;
				
				
				if ( $wp_query_custom->have_posts() ):
				
				while ( $wp_query_custom->have_posts() ) : $wp_query_custom->the_post();	
					
					if ( $count < $max_job_count )
						$html .= '<li><a href="'.get_permalink().'" target="_blank">'.get_the_title().'</a></li>';		
				
					$count++;
					
				endwhile;
				
				else: $html .= '';
				endif;
				wp_reset_query();
		//---------- loading job list END ----------------------------// 
		
		$html .= '</ul></div>
				</div>';
		
		
		
		$html .= '</div>';
		
		endwhile;
		
		if($display_pagination == 'yes'){
			
			$html .= '<div class="paginate">';
			$big = 999999999; // need an unlikely integer
			$html .= paginate_links( array(
				'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'format' => '?paged=%#%',
				'current' => max( 1, $paged ),
				'total' => $wp_query->max_num_pages
				) );
		
			$html .= '</div >';	
			
			}
		

		
		
		
		
		wp_reset_query(); 
		endif;
		
		$html .= '</div>';