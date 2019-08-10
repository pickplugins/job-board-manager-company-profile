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




	$header_html = '';
	echo '<div class="company-header">';
	
	$thumb = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'full' );
	$thumb_url = $thumb['0'];	
	
	if(!empty($thumb_url)){
		$header_html .= '<div class="thumb"><img src="'.$thumb_url.'" /></div>';
		}
	
	if(!empty($job_bm_cp_logo)){

            $job_bm_default_company_logo = get_option('job_bm_default_company_logo');

            if(is_serialized($job_bm_cp_logo)){

                $job_bm_cp_logo = unserialize($job_bm_cp_logo);
                if(!empty($job_bm_cp_logo[0])){
                    $job_bm_cp_logo = $job_bm_cp_logo[0];
                    $job_bm_cp_logo = wp_get_attachment_url($job_bm_cp_logo);
                }
                else{
                    $job_bm_cp_logo = $job_bm_default_company_logo;
                }
            }


		
		$header_html .= '<div class="logo"><img src="'.$job_bm_cp_logo.'" /></div>';
		
		}

		
		
	
	if(!empty($company_post_data->post_title)){
		$header_html .= '<h1 itemprop="name" class="name">'.$company_post_data->post_title.'<span class="tagline">'.$job_bm_cp_tagline.'</span><span class="local">'.$job_bm_cp_country.' <i class="fa fa-angle-right"></i> '.$job_bm_cp_city.'</span></h1>';	
		$header_html .= '';			
		
		}

	echo apply_filters('job_bm_cp_filter_company_single_header',$header_html);		
	

	echo '</div>'; // .company-header	
		
