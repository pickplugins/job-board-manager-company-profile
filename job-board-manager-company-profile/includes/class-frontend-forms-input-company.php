<?php

/*
* @Author 		ParaTheme
* Copyright: 	2015 ParaTheme
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

class class_frontend_forms_input_company{
	
    public function __construct(){
		
		add_shortcode( 'company_submit_form', array( $this, 'company_submit_form_display' ) );	

   	}

	public function company_submit_form_display($atts, $content = null ) {
					
			$class_frontend_forms_company = new class_frontend_forms_company();
			$class_job_bm_cp_post_meta = new class_job_bm_cp_post_meta();

			$form_info['form-id']='company-submit-form';
			$form_info['post_title']='yes';			
			$form_info['post_content']='yes';		

			$html = '';
	
			$html.= $class_frontend_forms_company->frontend_forms_html($form_info,$class_job_bm_cp_post_meta->company_meta_options());

			return $html;
		}
			
	}
	
	new class_frontend_forms_input_company();