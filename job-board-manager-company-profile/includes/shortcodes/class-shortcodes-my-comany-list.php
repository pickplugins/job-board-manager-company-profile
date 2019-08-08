<?php

/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

class class_job_bm_cp_shortcodes_my_comany_list{
	
    public function __construct(){
		
		add_shortcode( 'job_bm_my_company_list', array( $this, 'my_company_list_display' ) );

   		}

	public function my_company_list_display($atts, $content = null ) {

		ob_start();
		include( job_bm_cp_plugin_dir . 'templates/my-comany-list/my-comany-list.php');

		
	
		return ob_get_clean();
		
		}
	
			
	}
	
new class_job_bm_cp_shortcodes_my_comany_list();