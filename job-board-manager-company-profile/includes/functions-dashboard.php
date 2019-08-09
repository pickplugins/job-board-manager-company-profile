<?php
if ( ! defined('ABSPATH')) exit;  // if direct access 


add_filter('job_bm_dashboard_tabs','job_bm_dashboard_tabs_companies');
function job_bm_dashboard_tabs_companies($tabs){

    $tabs['my_companies'] =array(
        'title'=>__('My companies', 'job-board-manager'),
        'priority'=>5,
    );

    return $tabs;

}







add_action('job_bm_dashboard_tabs_content_my_companies', 'job_bm_dashboard_tabs_content_my_companies');

if(!function_exists('job_bm_dashboard_tabs_content_my_companies')){
    function job_bm_dashboard_tabs_content_my_companies(){

        echo do_shortcode('[job_bm_my_companies]');

    }
}


		