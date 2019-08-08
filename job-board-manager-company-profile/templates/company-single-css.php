<?php
/*
* @Author 		ParaTheme
* Copyright: 	2015 ParaTheme
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 


	$job_bm_job_type_bg_color = get_option('job_bm_job_type_bg_color');
	$job_bm_job_status_bg_color = get_option('job_bm_job_status_bg_color');	
	
	echo '<style type="text/css">';			
	
	if(!empty($job_bm_job_type_bg_color)){
		foreach($job_bm_job_type_bg_color as $job_type_key=>$job_type_color){
			
			echo '.job-single .job_type.'.$job_type_key.'{background:'.$job_type_color.'}';			
			}
		}

	if(!empty($job_bm_job_status_bg_color)){
		foreach($job_bm_job_status_bg_color as $job_status_key=>$job_status_color){
			
			echo '.job-single .job_status.'.$job_status_key.'{background:'.$job_status_color.'}';			
			}		
		}
	echo '</style>';	
