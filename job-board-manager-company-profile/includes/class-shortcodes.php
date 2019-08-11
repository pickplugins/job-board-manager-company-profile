<?php
if ( ! defined('ABSPATH')) exit;  // if direct access 

class class_job_bm_company_shortcodes{
	
    public function __construct(){

        add_shortcode( 'job_bm_company_submit_form', array( $this, 'company_submit_display' ) );
        add_shortcode( 'job_bm_company_edit_form', array( $this, 'company_edit_display' ) );
        add_shortcode( 'job_bm_my_companies', array( $this, 'job_bm_my_companies_display' ) );
        add_shortcode( 'job_bm_company_list', array( $this, 'job_bm_company_list_display' ) );


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




    public function job_bm_my_companies_display($atts, $content = null ) {

        $atts = shortcode_atts(
            array(
                //'themes' => 'flat',
                'display_edit' => 'yes',
                'display_delete' => 'yes',
            ), $atts);

        $display_edit = $atts['display_edit'];
        $display_delete = $atts['display_delete'];

        include( job_bm_cp_plugin_dir . 'templates/my-companies/my-companies-hook.php');


        ob_start();

        include( job_bm_cp_plugin_dir . 'templates/my-companies/my-companies.php');

        wp_localize_script('job-bm-my-companies', 'job_bm_ajax', array( 'job_bm_ajaxurl' => admin_url( 'admin-ajax.php')));

        wp_enqueue_script('job-bm-my-companies');
        wp_enqueue_style('job-bm-my-companies');

        //wp_enqueue_script('job-bm-my-jobs');
        wp_enqueue_style('job-bm-my-jobs');

        return ob_get_clean();

    }


    public function job_bm_company_list_display($atts, $content = null ) {

        $atts = shortcode_atts(
            array(
                //'themes' => 'flat',
                'display_edit' => 'yes',
                'display_delete' => 'yes',
            ), $atts);

        $display_edit = $atts['display_edit'];
        $display_delete = $atts['display_delete'];

        include( job_bm_cp_plugin_dir . 'templates/company-list/company-list-hook.php');


        ob_start();

        include( job_bm_cp_plugin_dir . 'templates/company-list/company-list.php');

        //wp_localize_script('job-bm-my-companies', 'job_bm_ajax', array( 'job_bm_ajaxurl' => admin_url( 'admin-ajax
        //.php')));

        //wp_enqueue_script('job-bm-company_list');
        wp_enqueue_style('job-bm-company-list');

        //wp_enqueue_script('job-bm-my-jobs');
        //wp_enqueue_style('job-bm-my-jobs');

        return ob_get_clean();

    }





}
	
	new class_job_bm_company_shortcodes();