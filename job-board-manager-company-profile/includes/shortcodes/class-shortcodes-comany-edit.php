<?php

/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

class class_job_bm_cp_shortcodes_comany_edit{
	
    public function __construct(){
		
		add_shortcode( 'company_edit_form', array( $this, 'company_edit_display' ) );

   		}

	public function company_edit_display($atts, $content = null ) {

		ob_start();
		include( job_bm_cp_plugin_dir . 'templates/company-edit/company-edit.php');

		
	
		return ob_get_clean();
		
		}
	
			
	}
	
new class_job_bm_cp_shortcodes_comany_edit();