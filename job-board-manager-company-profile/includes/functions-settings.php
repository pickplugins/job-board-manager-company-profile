<?php
if ( ! defined('ABSPATH')) exit;  // if direct access 


add_filter('job_bm_settings_tabs','job_bm_settings_tabs_companies');
function job_bm_settings_tabs_companies($job_bm_settings_tab){

    $job_bm_settings_tab[] = array(
        'id' => 'company',
        'title' => sprintf(__('%s Company','job-board-manager'),'<i class="fas fa-calendar-alt"></i>'),
        'priority' => 10,
        'active' => false,
    );

    return $job_bm_settings_tab;

}




add_action('job_bm_settings_tabs_content_company', 'job_bm_settings_tabs_content_company');

if(!function_exists('job_bm_settings_tabs_content_company')) {
    function job_bm_settings_tabs_content_company($tab){

        $settings_tabs_field = new settings_tabs_field();

        $job_bm_account_required_post_job = get_option('job_bm_account_required_post_job');
        $job_bm_reCAPTCHA_enable = get_option('job_bm_reCAPTCHA_enable');

        $job_bm_submitted_job_status = get_option('job_bm_submitted_job_status');
        $job_bm_redirect_preview_link = get_option('job_bm_redirect_preview_link');

        ?>
        <div class="section">
            <div class="section-title"><?php echo __('Company submission', 'job-board-manager'); ?></div>
            <p class="description section-description"><?php echo __('Customize option for company submit.', 'job-board-manager'); ?></p>

            <?php


            $args = array(
                'id'		=> 'job_bm_company_submit_account_required',
                //'parent'		=> '',
                'title'		=> __('Account required','job-board-manager'),
                'details'	=> __('Account required to submit company.','job-board-manager'),
                'type'		=> 'select',
                //'multiple'		=> true,
                'value'		=> $job_bm_account_required_post_job,
                'default'		=> '',
                'args'		=> array( 'yes'=>__('Yes','job-board-manager'), 'no'=>__('No','job-board-manager'),),
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'job_bm_company_submit_recaptcha',
                //'parent'		=> '',
                'title'		=> __('reCAPTCHA enable','job-board-manager'),
                'details'	=> __('Enable reCAPTCHA to protect spam on company submit form.','job-board-manager'),
                'type'		=> 'select',
                //'multiple'		=> true,
                'value'		=> $job_bm_reCAPTCHA_enable,
                'default'		=> '',
                'args'		=> array( 'yes'=>__('Yes','job-board-manager'), 'no'=>__('No','job-board-manager'),),
            );

            $settings_tabs_field->generate_field($args);




            $args = array(
                'id'		=> 'job_bm_company_submit_post_status',
                //'parent'		=> '',
                'title'		=> __('Submitted company status','job-board-manager'),
                'details'	=> __('Choose job status for newly submitted companies.','job-board-manager'),
                'type'		=> 'select',
                //'multiple'		=> true,
                'value'		=> $job_bm_submitted_job_status,
                'default'		=> '',
                'args'		=> array( 'draft'=>__('Draft','job-board-manager'), 'pending'=>__('Pending','job-board-manager'), 'publish'=>__('Published','job-board-manager'), 'private'=>__('Private','job-board-manager'), 'trash'=>__('Trash','job-board-manager')),
            );

            $settings_tabs_field->generate_field($args);





            $page_list = job_bm_page_list_id();
            //$page_list = array_merge($page_list, array('job_preview'=>'Job Preview'));

            $page_list['company_preview'] = __('-- Company Preview --', 'job-board-manager');
            $page_list['company_link'] = __('-- Company Link --', 'job-board-manager');

            $args = array(
                'id'		=> 'job_bm_company_submit_redirect',
                //'parent'		=> '',
                'title'		=> __('Redirect after company submit','job-board-manager'),
                'details'	=> __('Redirect other link after company submitted','job-board-manager'),
                'type'		=> 'select',
                //'multiple'		=> true,
                'value'		=> $job_bm_redirect_preview_link,
                'default'		=> '',
                'args'		=> $page_list,
            );

            $settings_tabs_field->generate_field($args);







            ?>


        </div>


        <div class="section">
            <div class="section-title"><?php echo __('Company Edit', 'job-board-manager'); ?></div>
            <p class="description section-description"><?php echo __('Customize option for company edit.', 'job-board-manager'); ?></p>

            <?php



            $args = array(
                'id'		=> 'job_bm_company_edit_recaptcha',
                //'parent'		=> '',
                'title'		=> __('reCAPTCHA enable','job-board-manager'),
                'details'	=> __('Enable reCAPTCHA to protect spam on company edit form.','job-board-manager'),
                'type'		=> 'select',
                //'multiple'		=> true,
                'value'		=> $job_bm_reCAPTCHA_enable,
                'default'		=> '',
                'args'		=> array( 'yes'=>__('Yes','job-board-manager'), 'no'=>__('No','job-board-manager'),),
            );

            $settings_tabs_field->generate_field($args);




            $args = array(
                'id'		=> 'job_bm_company_edit_post_status',
                //'parent'		=> '',
                'title'		=> __('Submitted company status','job-board-manager'),
                'details'	=> __('Choose job status for newly edited companies.','job-board-manager'),
                'type'		=> 'select',
                //'multiple'		=> true,
                'value'		=> $job_bm_submitted_job_status,
                'default'		=> '',
                'args'		=> array( 'draft'=>__('Draft','job-board-manager'), 'pending'=>__('Pending','job-board-manager'), 'publish'=>__('Published','job-board-manager'), 'private'=>__('Private','job-board-manager'), 'trash'=>__('Trash','job-board-manager')),
            );

            $settings_tabs_field->generate_field($args);





            $page_list = job_bm_page_list_id();
            //$page_list = array_merge($page_list, array('job_preview'=>'Job Preview'));

            $page_list['company_preview'] = __('-- Company Preview --', 'job-board-manager');
            $page_list['company_link'] = __('-- Company Link --', 'job-board-manager');

            $args = array(
                'id'		=> 'job_bm_company_edit_redirect',
                //'parent'		=> '',
                'title'		=> __('Redirect after company edit','job-board-manager'),
                'details'	=> __('Redirect other link after company edited','job-board-manager'),
                'type'		=> 'select',
                //'multiple'		=> true,
                'value'		=> $job_bm_redirect_preview_link,
                'default'		=> '',
                'args'		=> $page_list,
            );

            $settings_tabs_field->generate_field($args);







            ?>


        </div>

        <?php


    }
}





add_action('job_bm_settings_tabs_content_pages', 'job_bm_settings_tabs_content_pages_company', 20);

if(!function_exists('job_bm_settings_tabs_content_pages_company')) {
    function job_bm_settings_tabs_content_pages_company($tab){

        $settings_tabs_field = new settings_tabs_field();


        $job_bm_company_edit_page_id = get_option('job_bm_company_edit_page_id');



        ?>
        <div class="section">
            <div class="section-title"><?php echo __('Company page settings', 'job-board-manager'); ?></div>
            <p class="description section-description"><?php echo __('Choose option for pages.', 'job-board-manager'); ?></p>

            <?php

            $args = array(
                'id'		=> 'job_bm_company_edit_page_id',
                //'parent'		=> '',
                'title'		=> __('Company edit page','job-board-manager'),
                'details'	=> __('Choose the page for company edit page, where the shortcode <code>[job_bm_company_edit_form]</code> used.','job-board-manager'),
                'type'		=> 'select',
                //'multiple'		=> true,
                'value'		=> $job_bm_company_edit_page_id,
                'default'		=> '',
                'args'		=> job_bm_page_list_id(),
            );

            $settings_tabs_field->generate_field($args);





            ?>


        </div>
        <?php


    }
}





add_action('job_bm_settings_save', 'job_bm_settings_save_company', 20);

if(!function_exists('job_bm_settings_save_company')) {
    function job_bm_settings_save_company($tab){


        $job_bm_company_edit_page_id = isset($_POST['job_bm_company_edit_page_id']) ? sanitize_text_field($_POST['job_bm_company_edit_page_id']) : '';

        update_option('job_bm_company_edit_page_id', $job_bm_company_edit_page_id);




    }
}
