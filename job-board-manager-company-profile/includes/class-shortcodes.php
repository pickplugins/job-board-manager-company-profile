<?php
if ( ! defined('ABSPATH')) exit;  // if direct access 

class class_job_bm_cp_shortcodes{
	
    public function __construct(){
		
		add_shortcode( 'company_list', array( $this, 'job_bm_cp_companylist_display' ) );	
		//add_shortcode( 'company_job_list', array( $this, 'job_bm_cp_job_list' ) );		
        add_shortcode( 'job_bm_company_submit_form', array( $this, 'company_submit_display' ) );
        add_shortcode( 'job_bm_company_edit_form', array( $this, 'company_edit_display' ) );

   		}





    public function company_submit_display($atts, $content = null ) {


        include( job_bm_cp_plugin_dir . 'templates/company-submit/company-submit-hook.php');


        ob_start();
        include( job_bm_cp_plugin_dir . 'templates/company-submit/company-submit.php');

        wp_enqueue_style('job-bm-job-submit');

        wp_enqueue_script('job-bm-media-upload');
        wp_enqueue_style('job-bm-media-upload');
        // For media uploader in front-end
        wp_enqueue_media();
        wp_enqueue_style('common');

        return ob_get_clean();

    }


    public function company_edit_display($atts, $content = null ) {


        $job_bm_can_user_edit_published_jobs = get_option('job_bm_can_user_edit_published_jobs');
        $job_bm_job_login_page_id = get_option('job_bm_job_login_page_id');
        $dashboard_page_url = get_permalink($job_bm_job_login_page_id);
        $dashboard_page_title = get_the_title($job_bm_job_login_page_id);


        $userid = get_current_user_id();


        if(!isset($_GET['company_id'])):
            return apply_filters('job_bm_company_edit_invalid_id_text', sprintf(__('Company id is invalid. please go to %s » <a href="%s">My Companies</a> see your companies.', 'job-board-manager'), '<strong>'.$dashboard_page_title.'</strong>',$dashboard_page_url.'?tabs=my_companies'));
        endif;

        $company_id = sanitize_text_field($_GET['company_id']);

        // job poster author id.
        $job_post_data = get_post($company_id, ARRAY_A);
        $author_id = (int)$job_post_data['post_author'];

        //var_dump($userid);
        //var_dump($author_id);

        if(!is_user_logged_in()){
            return apply_filters('job_bm_company_edit_login_required_text', sprintf(__('Please <a href="%s">login</a> to edit job.', 'job-board-manager'), $dashboard_page_url));

        }


        if($job_bm_can_user_edit_published_jobs != 'yes' || $userid != $author_id){

            do_action('job_bm_company_edit_login_required');

            return apply_filters('job_bm_company_edit_unauthorized_text', __('Sorry! you are not authorized to edit this company.', 'job-board-manager'));

        }



        include( job_bm_cp_plugin_dir . 'templates/company-edit/company-edit-hook.php');


        ob_start();
        include( job_bm_cp_plugin_dir . 'templates/company-edit/company-edit.php');

        wp_enqueue_style('job-bm-job-submit');

        wp_enqueue_script('job-bm-media-upload');
        wp_enqueue_style('job-bm-media-upload');
        // For media uploader in front-end
        wp_enqueue_media();
        wp_enqueue_style('common');

        return ob_get_clean();

    }



	public function job_bm_cp_companylist_display($atts, $content = null ) {
			$atts = shortcode_atts(
				array(
					'id' => '',				
					'themes' => 'flat',
					'post_per_page' => 10,
					'max_job_count' => 3,					
					'allow_empty_job_showing' => 'true',
					'display_pagination' => 'no',					
					
					), $atts);
		
			$company_id = $atts['id'];	
			$themes = $atts['themes'];						
			$post_per_page = $atts['post_per_page'];
			$max_job_count = $atts['max_job_count'];				
			$display_pagination = $atts['display_pagination'];						
			$allow_empty_job_showing = $atts['allow_empty_job_showing'];			
			$job_bm_cp_job_list_thmes = $atts['themes'];
			
			
			$html = '';
			//$job_bm_cp_themes = get_post_meta( $post_id, 'job_bm_cp_themes', true );
			//$job_bm_cp_license_key = get_option('job_bm_cp_license_key');
			
/*
			if(empty($job_bm_cp_license_key))
				{
					return '<b>"'.job_bm_cp_plugin_name.'" Error:</b> Please activate your license.';
				}

*/
			
			$class_job_bm_cp_functions = new class_job_bm_cp_functions();
			$job_bm_cp_companylist_themes_dir = $class_job_bm_cp_functions->job_bm_cp_companylist_themes_dir();
			$job_bm_cp_companylist_themes_url = $class_job_bm_cp_functions->job_bm_cp_companylist_themes_url();

			
			
			echo '<link  type="text/css" media="all" rel="stylesheet"  href="'.$job_bm_cp_companylist_themes_url[$themes].'/style.css" >';				

			include $job_bm_cp_companylist_themes_dir[$themes].'/index.php';				

			return $html;
	
	
		}
		


		
	
	}
	
	new class_job_bm_cp_shortcodes();