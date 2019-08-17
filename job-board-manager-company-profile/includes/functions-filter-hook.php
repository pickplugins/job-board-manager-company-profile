<?php
if ( ! defined('ABSPATH')) exit;  // if direct access 

add_filter('job_bm_job_archive_loop_item_company', 'job_bm_job_archive_loop_item_company');

function job_bm_job_archive_loop_item_company($company){

    $job_bm_archive_page_id = get_option('job_bm_archive_page_id');
    $job_bm_archive_page_url = get_permalink($job_bm_archive_page_id);

    $company_data = get_page_by_title($company, 'OBJECT', 'company');

    if(!empty($company_data)):
        $company_url = get_permalink($company_data->ID);



        $html = '';
        $html .= '<a href="'.$company_url.'">'.$company.'</a>';
    else:
        $html = $company;
    endif;


    return $html;

}





