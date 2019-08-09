<?php

/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 


class class_job_bm_cp_settings  {
	
	
    public function __construct(){


		add_filter('job_bm_settings_options',array( $this, 'job_bm_cp_settings_options_extra'));
        add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		
    }
	

	public function admin_menu() {

        $job_bm_company_logo_upgrade = get_option('job_bm_company_logo_upgrade', 'no');

        if( $job_bm_company_logo_upgrade=='no'){
            add_submenu_page( 'edit.php?post_type=job', __( 'Update logo', 'job-board-manager-company-profile' ), __( 'Update logo', 'job-board-manager-company-profile' ), 'manage_options', 'update-company-logo', array( $this, 'update_company_logo' ) );
        }


		
		do_action( 'job_bm_cp_action_admin_menus' );
		
	}
	
	public function update_company_logo(){
		
		include( 'menu/update-company-logo.php' );
		}
	

// ############### Filter for settings_options ###################

function job_bm_cp_settings_options_extra($options){
	
	$options['<i class="fa fa-university"></i> '.__('Company Profile', 'job-board-manager-company-profile')] = array(
	
	
								'job_bm_default_company_logo'=>array(
									'css_class'=>'default_company_logo',					
									'title'=>__('Default company logo' , 'job-board-manager-company-profile'),
									'option_details'=>__('Default company logo', 'job-board-manager-company-profile'),
									'input_type'=>'file', // text, radio, checkbox, select, 
									'input_values'=> job_bm_cp_plugin_url.'assets/front/images/logo.png', // could be array
									//'input_args'=> array('yes'=>__('Yes','job-board-manager-company-profile'),'no'=>__('No','job-board-manager-company-profile')),
									),	
	
	
	
								'job_bm_link_to_company_archive_page'=>array(
									'css_class'=>'link_to_company_archive_page',					
									'title'=>__('Company linked at archive page', 'job-board-manager-company-profile'),
									'option_details'=>__('Company linked at archive page', 'job-board-manager-company-profile'),
									'input_type'=>'select', // text, radio, checkbox, select, 
									'input_values'=> '', // could be array
									'input_args'=> array('yes'=>__('Yes', 'job-board-manager-company-profile'),'no'=>__('No', 'job-board-manager-company-profile')),
									),
									
								'job_bm_link_to_company_single_page'=>array(
									'css_class'=>'link_to_company_single_page',					
									'title'=>__('Company linked at single page', 'job-board-manager-company-profile'),
									'option_details'=>__('Company linked at single page', 'job-board-manager-company-profile'),
									'input_type'=>'select', // text, radio, checkbox, select, 
									'input_values'=> '', // could be array
									'input_args'=> array('yes'=>__('Yes', 'job-board-manager-company-profile'),'no'=>__('No', 'job-board-manager-company-profile')),
									),									
									
								);
			return $options;
			
		}


	}


new class_job_bm_cp_settings();

