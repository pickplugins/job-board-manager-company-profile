<?php
if ( ! defined('ABSPATH')) exit;  // if direct access




add_action('job_bm_metabox_company_content_company_info','job_bm_metabox_company_content_company_info_title');


function job_bm_metabox_company_content_company_info_title($job_id){


    ?>
    <div class="section">
        <div class="section-title"><?php echo __('Company Information','job-board-manager'); ?></div>
        <p class="section-description"></p>
    </div>


    <?php


}







add_action('job_bm_metabox_company_content_company_info','job_bm_metabox_company_total_vacancies');

function job_bm_metabox_company_total_vacancies($job_id){

    $settings_tabs_field = new settings_tabs_field();

    $job_bm_cp_tagline = get_post_meta($job_id, 'job_bm_cp_tagline', true);

    $args = array(
        'id'		=> 'job_bm_cp_tagline',
        //'parent'		=> '',
        'title'		=> __('Company tag-line','job-board-manager'),
        'details'	=> __('Write your company tag-line','job-board-manager'),
        'type'		=> 'text',
        'value'		=> $job_bm_cp_tagline,
        'default'		=> '',
        'placeholder'		=> '',
    );

    $settings_tabs_field->generate_field($args);

}



add_action('job_bm_metabox_company_content_company_info','job_bm_metabox_company_years_experience');

function job_bm_metabox_company_years_experience($job_id){

    $settings_tabs_field = new settings_tabs_field();

    $job_bm_cp_mission = get_post_meta($job_id, 'job_bm_cp_mission', true);

    $args = array(
        'id'		=> 'job_bm_cp_mission',
        //'parent'		=> '',
        'title'		=> __('Company mission','job-board-manager'),
        'details'	=> __('Write company mission.','job-board-manager'),
        'type'		=> 'text',
        'value'		=> $job_bm_cp_mission,
        'default'		=> '',
        'placeholder'		=> '',
    );

    $settings_tabs_field->generate_field($args);

}



add_action('job_bm_metabox_company_content_company_info','job_bm_metabox_company_type');

function job_bm_metabox_company_type($job_id){

    $settings_tabs_field = new settings_tabs_field();

    $class_job_bm_cp_functions = new class_job_bm_cp_functions();
    $job_bm_cp_country_list = $class_job_bm_cp_functions->job_bm_cp_country_list();


    $job_bm_cp_country = get_post_meta($job_id, 'job_bm_cp_country', true);

    $args = array(
        'id'		=> 'job_bm_cp_country',
        //'parent'		=> '',
        'title'		=> __('Country','job-board-manager'),
        'details'	=> __('Select company country.','job-board-manager'),
        'type'		=> 'select',
        'value'		=> $job_bm_cp_country,
        'default'		=> '',
        'args'		=> $job_bm_cp_country_list,
    );

    $settings_tabs_field->generate_field($args);

}




add_action('job_bm_metabox_company_content_company_info','job_bm_metabox_company_salary_fixed');

function job_bm_metabox_company_salary_fixed($job_id){

    $settings_tabs_field = new settings_tabs_field();
    $job_bm_cp_city = get_post_meta($job_id, 'job_bm_cp_city', true);

    $args = array(
        'id'		=> 'job_bm_cp_city',
        //'parent'		=> '',
        'title'		=> __('Company city','job-board-manager'),
        'details'	=> __('Write company city','job-board-manager'),
        'type'		=> 'text',
        'value'		=> $job_bm_cp_city,
        'default'		=> '',
        'placeholder'		=> '',
    );

    $settings_tabs_field->generate_field($args);

}





add_action('job_bm_metabox_company_content_company_info','job_bm_metabox_company_salary_min');

function job_bm_metabox_company_salary_min($job_id){

    $settings_tabs_field = new settings_tabs_field();
    $job_bm_cp_address = get_post_meta($job_id, 'job_bm_cp_city', true);

    $args = array(
        'id'		=> 'job_bm_cp_address',
        //'parent'		=> '',
        'title'		=> __('Company address','job-board-manager'),
        'details'	=> __('Write company address','job-board-manager'),
        'type'		=> 'text',
        'value'		=> $job_bm_cp_address,
        'default'		=> '',
        'placeholder'		=> '',
    );

    $settings_tabs_field->generate_field($args);

}




add_action('job_bm_metabox_company_content_company_info','job_bm_metabox_company_content_company_info_logo');

function job_bm_metabox_company_content_company_info_logo($job_id){

    $settings_tabs_field = new settings_tabs_field();
    $job_bm_cp_logo = get_post_meta($job_id, 'job_bm_cp_logo', true);


    $job_bm_cp_logo = !empty($job_bm_cp_logo) ? $job_bm_cp_logo : job_bm_plugin_url."assets/front/images/placeholder.png";

    if(is_serialized($job_bm_cp_logo)){

        $job_bm_cp_logo = unserialize($job_bm_cp_logo);
        if(!empty($job_bm_cp_logo[0])){
            $job_bm_cp_logo = $job_bm_cp_logo[0];
            $job_bm_cp_logo = wp_get_attachment_url($job_bm_cp_logo);

            if($job_bm_cp_logo == false){
                $job_bm_cp_logo = job_bm_cp_plugin_url.'assets/global/images/company.png';

            }

        }
        else{
            $job_bm_cp_logo = job_bm_cp_plugin_url.'assets/global/images/company.png';
        }
    }



    $args = array(
        'id'		=> 'job_bm_cp_logo',
        //'parent'		=> '',
        'title'		=> __('Company logo','job-board-manager'),
        'details'	=> __('Upload company logo','job-board-manager'),
        'type'		=> 'media_url',
        'value'		=> $job_bm_cp_logo,
        'default'		=> '',
        'placeholder'		=> '',
    );

    $settings_tabs_field->generate_field($args);

}


add_action('job_bm_metabox_company_content_company_info','job_bm_metabox_company_content_company_info_website');

function job_bm_metabox_company_content_company_info_website($job_id){

    $settings_tabs_field = new settings_tabs_field();
    $job_bm_cp_website = get_post_meta($job_id, 'job_bm_cp_website', true);

    $args = array(
        'id'		=> 'job_bm_cp_website',
        //'parent'		=> '',
        'title'		=> __('Company website','job-board-manager'),
        'details'	=> __('Write company website','job-board-manager'),
        'type'		=> 'text',
        'value'		=> $job_bm_cp_website,
        'default'		=> '',
        'placeholder'		=> 'http://companywebsite.com',
    );

    $settings_tabs_field->generate_field($args);

}




add_action('job_bm_metabox_company_content_company_info','job_bm_metabox_company_salary_max');

function job_bm_metabox_company_salary_max($job_id){

    $settings_tabs_field = new settings_tabs_field();
    $job_bm_cp_founded = get_post_meta($job_id, 'job_bm_cp_founded', true);

    $args = array(
        'id'		=> 'job_bm_cp_founded',
        //'parent'		=> '',
        'title'		=> __('Company founded year','job-board-manager'),
        'details'	=> __('Write company founded year','job-board-manager'),
        'type'		=> 'text',
        'value'		=> $job_bm_cp_founded,
        'default'		=> '',
        'placeholder'		=> '1980',
    );

    $settings_tabs_field->generate_field($args);

}


add_action('job_bm_metabox_company_content_company_info','job_bm_metabox_company_salary_currency');

function job_bm_metabox_company_salary_currency($job_id){

    $settings_tabs_field = new settings_tabs_field();
    $job_bm_cp_size = get_post_meta($job_id, 'job_bm_cp_size', true);

    $args = array(
        'id'		=> 'job_bm_cp_size',
        //'parent'		=> '',
        'title'		=> __('Company worker size','job-board-manager'),
        'details'	=> __('Write company worker size','job-board-manager'),
        'type'		=> 'text',
        'value'		=> $job_bm_cp_size,
        'default'		=> '',
        'placeholder'		=> '12',
    );

    $settings_tabs_field->generate_field($args);

}





















add_action('job_bm_metabox_company_content_admin','job_bm_metabox_company_content_admin_featured');

function job_bm_metabox_company_content_admin_featured($job_id){

    $settings_tabs_field = new settings_tabs_field();
    $class_job_bm_functions = new class_job_bm_functions();
    $job_status_list = $class_job_bm_functions->job_status_list();

    $job_bm_cp_featured = get_post_meta($job_id, 'job_bm_cp_featured', true);

    $args = array(
        'id'		=> 'job_bm_cp_featured',
        //'parent'		=> '',
        'title'		=> __('Featured company','job-board-manager'),
        'details'	=> __('Choose company as featured','job-board-manager'),
        'type'		=> 'select',
        'value'		=> $job_bm_cp_featured,
        'default'		=> '',
        'args'		=> array('no'=>__('No', 'job-board-manager'),'yes'=>__('Yes', 'job-board-manager')),
    );

    $settings_tabs_field->generate_field($args);

}









add_action('job_bm_metabox_save_company','job_bm_metabox_save_company');

function job_bm_metabox_save_company($job_id){

    $job_bm_cp_tagline = isset($_POST['job_bm_cp_tagline']) ? sanitize_text_field($_POST['job_bm_cp_tagline']) : '';
    update_post_meta($job_id, 'job_bm_cp_tagline', $job_bm_cp_tagline);

    $job_bm_cp_country = isset($_POST['job_bm_cp_country']) ? sanitize_text_field($_POST['job_bm_cp_country']) : '';
    update_post_meta($job_id, 'job_bm_cp_country', $job_bm_cp_country);

    $job_bm_job_level = isset($_POST['job_bm_job_level']) ? sanitize_text_field($_POST['job_bm_job_level']) : '';
    update_post_meta($job_id, 'job_bm_job_level', $job_bm_job_level);

    $job_bm_cp_mission = isset($_POST['job_bm_cp_mission']) ? sanitize_text_field($_POST['job_bm_cp_mission']) : '';
    update_post_meta($job_id, 'job_bm_cp_mission', $job_bm_cp_mission);

    $job_bm_salary_type = isset($_POST['job_bm_salary_type']) ? sanitize_text_field($_POST['job_bm_salary_type']) : '';
    update_post_meta($job_id, 'job_bm_salary_type', $job_bm_salary_type);

    $job_bm_cp_city = isset($_POST['job_bm_cp_city']) ? sanitize_text_field($_POST['job_bm_cp_city']) : '';
    update_post_meta($job_id, 'job_bm_cp_city', $job_bm_cp_city);

    $job_bm_cp_address = isset($_POST['job_bm_cp_address']) ? sanitize_text_field($_POST['job_bm_cp_address']) : '';
    update_post_meta($job_id, 'job_bm_cp_address', $job_bm_cp_address);

    $job_bm_cp_founded = isset($_POST['job_bm_cp_founded']) ? sanitize_text_field($_POST['job_bm_cp_founded']) : '';
    update_post_meta($job_id, 'job_bm_cp_founded', $job_bm_cp_founded);

    $job_bm_cp_size = isset($_POST['job_bm_cp_founded']) ? sanitize_text_field($_POST['job_bm_cp_size']) : '';
    update_post_meta($job_id, 'job_bm_cp_size', $job_bm_cp_size);





    $job_bm_cp_website = isset($_POST['job_bm_cp_website']) ? sanitize_text_field($_POST['job_bm_cp_website']) : '';
    update_post_meta($job_id, 'job_bm_cp_website', $job_bm_cp_website);

    $job_bm_cp_logo = isset($_POST['job_bm_cp_logo']) ? sanitize_text_field($_POST['job_bm_cp_logo']) : '';
    update_post_meta($job_id, 'job_bm_cp_logo', $job_bm_cp_logo);


    $job_bm_cp_featured = isset($_POST['job_bm_cp_featured']) ? sanitize_text_field($_POST['job_bm_cp_featured']) : '';
    update_post_meta($job_id, 'job_bm_cp_featured', $job_bm_cp_featured);



}

