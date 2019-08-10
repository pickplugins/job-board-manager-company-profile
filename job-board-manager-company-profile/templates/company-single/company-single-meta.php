<?php
/*
* @Author 		ParaTheme
* Copyright: 	2015 ParaTheme
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 


	$company_post_data = get_post(get_the_ID());

	$class_job_bm_company_meta = new class_job_bm_cp_post_meta();
	$company_meta_options = $class_job_bm_company_meta->company_meta_options();
	
	//var_dump($company_meta_options);
	
	foreach($company_meta_options as $options_tab=>$options){
		
		foreach($options as $option_key=>$option_data){
			
			$meta_key_values[$option_key] = get_post_meta(get_the_ID(), $option_key, true);
			${$option_key} = get_post_meta(get_the_ID(), $option_key, true);			
			//var_dump(${$option_key});
			}
		}







	echo '<div class="meta-info">';	
		
	if(!empty($job_bm_cp_address)){
	echo '<div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress" class="meta"><strong><i class="fa fa-map-marker"></i>'.__('Address:','job-board-manager-company-profile').'</strong> '.$job_bm_cp_address.'</div>';
		}		
		
	if(!empty($job_bm_cp_website)){
	echo '<div class="meta"><strong><i class="fa fa-link"></i>'.__('Website:', 'job-board-manager-company-profile').'</strong> '.$job_bm_cp_website.'</div>';
		}

	
	
	$company_type = '';
	
	if(!empty($job_bm_cp_type)){

		foreach($job_bm_cp_type as $type_key=>$type_name){
			
			$company_type.= $type_name.', ';
			}
	
	
			echo '<div class="meta"><strong><i class="fa fa-flag-o"></i>'.__('Type:','job-board-manager-company-profile').'</strong> '.$company_type.'</div>';
		}

	if(!empty($job_bm_cp_founded)){
		
	echo '<div class="meta"><strong><i class="fa fa-calendar-o"></i>'.__('Founded:','job-board-manager-company-profile').' </strong>'.$job_bm_cp_founded.'</div>';
	
		}
	if(!empty($job_bm_cp_size)){
		
		echo '<div class="meta"><strong><i class="fa fa-users"></i>'.__('Size:','job-board-manager-company-profile').'</strong> '.$job_bm_cp_size.'</div>';
		}
	if(!empty($job_bm_cp_revenue)){
		
		echo '<div class="meta"><strong><i class="fa fa-money"></i>'.__('Revenue:','job-board-manager-company-profile').'</strong> $'.$job_bm_cp_revenue.'</div>';
		}
	
	
	echo '</div>'; // .meta-info
	
	
	
	
	if(!empty($job_bm_cp_mission)){
		
		echo '<div class="mission"><strong><i class="fa fa-rocket"></i>'.__('Mission:','job-board-manager-company-profile').'</strong> '.$job_bm_cp_mission.'</div>';
		
		}

	if(!empty($company_post_data->post_content)){
		echo '<div  class="description">'.wpautop($company_post_data->post_content).'</div>';
		}	
	
	
	
		
		
