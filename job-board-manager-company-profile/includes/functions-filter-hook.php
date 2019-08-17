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


//add_filter('the_title', 'job_bm_company_post_title');

function job_bm_company_post_title($title){

    if(is_singular('company') && in_the_loop()){
        return '';
    }else{
        return $title;
    }

}


add_filter('post_thumbnail_html', 'job_bm_company_post_thumbnail', 90);

function job_bm_company_post_thumbnail($thumbnail){

    if(is_singular('company')){
        return '';
    }else{
        return $thumbnail;
    }


}

add_filter( "comments_template", "job_bm_company_comment_template", 99 );
function job_bm_company_comment_template( $comment_template ) {
    global $post;

    if ( !( is_singular() && ( have_comments() || 'open' == $post->comment_status ) ) ) {
        return;
    }
    if($post->post_type == 'company'){

        //var_dump(job_bm_cp_plugin_dir . 'templates/company-single/company-single-comments.php');

        return job_bm_cp_plugin_dir . 'templates/company-single/company-single-comments.php';
    }
}

