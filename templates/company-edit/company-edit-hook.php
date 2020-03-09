<?php
if ( ! defined('ABSPATH')) exit;  // if direct access 



/* Display question title field */

add_action('job_bm_company_edit_form', 'job_bm_company_edit_form_title', 0);

function job_bm_company_edit_form_title($company_id){

    $company_post = get_post($company_id);

    $post_title = isset($_POST['post_title']) ? sanitize_text_field($_POST['post_title']) : $company_post->post_title;

    ?>
    <div class="form-field-wrap">
        <div class="field-title"><?php echo __('Company name','job-board-manager-company-profile'); ?></div>
        <div class="field-input">
            <input placeholder="" type="text" value="<?php echo $post_title; ?>" name="post_title">
            <p class="field-details"><?php echo __('Write your company name','job-board-manager-company-profile');
            ?></p>
        </div>
    </div>
    <?php
}


/* Display question details input field*/

add_action('job_bm_company_edit_form', 'job_bm_company_edit_form_content', 10);

function job_bm_company_edit_form_content($company_id){

    $company_post = get_post($company_id);

    $field_id = 'post_content';
    $allowed_html = apply_filters('job_bm_company_edit_allowed_html_tags', array());
    $post_content = isset($_POST['post_content']) ? wp_kses($_POST['post_content'], $allowed_html) : $company_post->post_content;


    ?>
    <div class="form-field-wrap">
        <div class="field-title"><?php echo __('Company description','job-board-manager-company-profile'); ?></div>
        <div class="field-input">
            <?php
            ob_start();
            wp_editor( esc_html($post_content), $field_id, $settings = array('textarea_name'=>$field_id,
                'media_buttons'=>false,'wpautop'=>true,'editor_height'=>'200px', ) );
            echo ob_get_clean();

            ?>

            <p class="field-details"><?php echo __('Write your company details.','job-board-manager-company-profile'); ?></p>

        </div>
    </div>
    <?php
}




/* Display category input field  */

add_action('job_bm_company_edit_form', 'job_bm_company_edit_form_categories', 20);

function job_bm_company_edit_form_categories($company_id){

    $company_categories = get_the_terms($company_id, 'company_category');


    //var_dump($company_categories);

    $company_category_id = isset($company_categories[0]->term_id) ? $company_categories[0]->term_id : '';

    $company_category = isset($_POST['company_category']) ? sanitize_text_field($_POST['company_category']) : $company_category_id;

    $categories = get_terms( array(
        'taxonomy' => 'company_category',
        'hide_empty' => false,
    ) );

    $terms = array();

    //var_dump($categories);



    if(!empty($categories)) {
        foreach ($categories as $category) {

            $name = $category->name;
            $cat_ID = $category->term_id;
            $terms[$cat_ID] = $name;
        }
    }

    ?>
    <div class="form-field-wrap">
        <div class="field-title"><?php echo __('Company category','job-board-manager-company-profile'); ?></div>
        <div class="field-input">
            <select name="company_category" >
                <?php
                if(!empty($terms)):
                    foreach ($terms as $term_id => $term_name){

                        $selected = ($company_category == $term_id) ? 'selected' : '';

                        ?>
                        <option <?php echo $selected; ?> value="<?php echo esc_attr($term_id); ?>"><?php echo esc_html
                            ($term_name); ?></option>
                        <?php
                    }
                endif;
                ?>
            </select>
            <p class="field-details"><?php echo __('Select company category.','job-board-manager-company-profile'); ?></p>

        </div>
    </div>
    <?php
}






add_action('job_bm_company_edit_form', 'job_bm_company_edit_form_job_info_title', 30);


function job_bm_company_edit_form_job_info_title($company_id){


    ?>
    <div class="form-field-wrap ">
        <div class="field-separator"><?php echo __('Company Information','job-board-manager-company-profile'); ?></div>
    </div>
    <?php
}











/* Display vacancies input field  */

add_action('job_bm_company_edit_form', 'job_bm_company_edit_form_tagline', 30);


function job_bm_company_edit_form_tagline($company_id){

    $job_bm_cp_tagline = get_post_meta($company_id, 'job_bm_cp_tagline', true);

    $job_bm_cp_tagline = isset($_POST['job_bm_cp_tagline']) ? sanitize_text_field($_POST['job_bm_cp_tagline']) : $job_bm_cp_tagline;

    ?>
    <div class="form-field-wrap">
        <div class="field-title"><?php echo __('Company tag-line','job-board-manager-company-profile'); ?></div>
        <div class="field-input">
            <input placeholder="" type="text" value="<?php echo $job_bm_cp_tagline; ?>" name="job_bm_cp_tagline">
            <p class="field-details"><?php echo __('Write your company tag-line','job-board-manager-company-profile');
                ?></p>
        </div>
    </div>
    <?php
}




/* Display years_experience input field  */

add_action('job_bm_company_edit_form', 'job_bm_company_edit_form_mission', 30);

function job_bm_company_edit_form_mission($company_id){

    $job_bm_cp_mission = get_post_meta($company_id, 'job_bm_cp_mission', true);

    $job_bm_cp_mission = isset($_POST['job_bm_cp_mission']) ? sanitize_text_field($_POST['job_bm_cp_mission']) : $job_bm_cp_mission;

    ?>
    <div class="form-field-wrap">
        <div class="field-title"><?php echo __('Company mission','job-board-manager-company-profile'); ?></div>
        <div class="field-input">
            <input placeholder="" type="text" value="<?php echo $job_bm_cp_mission; ?>" name="job_bm_cp_mission">
            <p class="field-details"><?php echo __('Write company mission.','job-board-manager-company-profile');
                ?></p>
        </div>
    </div>
    <?php
}



/* Display job_type input field  */

add_action('job_bm_company_edit_form', 'job_bm_company_edit_form_country', 30);

function job_bm_company_edit_form_country($company_id){

    $job_bm_cp_country = get_post_meta($company_id, 'job_bm_cp_country', true);

    $class_job_bm_cp_functions = new class_job_bm_cp_functions();
    $job_bm_cp_country_list = $class_job_bm_cp_functions->job_bm_cp_country_list();

    $job_bm_cp_country = isset($_POST['job_bm_cp_country']) ? sanitize_text_field($_POST['job_bm_cp_country']) : $job_bm_cp_country;


    ?>
    <div class="form-field-wrap">
        <div class="field-title"><?php echo __('Country','job-board-manager-company-profile'); ?></div>
        <div class="field-input">
            <select name="job_bm_cp_country" >
                <?php
                if(!empty($job_bm_cp_country_list)):
                    foreach ($job_bm_cp_country_list as $job_type => $job_type_name){

                        $selected = ($job_bm_cp_country == $job_type) ? 'selected' : '';

                        ?>
                        <option <?php echo $selected; ?> value="<?php echo esc_attr($job_type); ?>"><?php echo esc_html
                            ($job_type_name); ?></option>
                        <?php
                    }
                endif;
                ?>
            </select>
            <p class="field-details"><?php echo __('Select company country.','job-board-manager-company-profile'); ?></p>

        </div>
    </div>
    <?php
}


add_action('job_bm_company_edit_form', 'job_bm_company_edit_form_city', 30);

function job_bm_company_edit_form_city($company_id){

    $job_bm_cp_city = get_post_meta($company_id, 'job_bm_cp_city', true);

    $job_bm_cp_city = isset($_POST['job_bm_cp_city']) ? sanitize_text_field($_POST['job_bm_cp_city']) : $job_bm_cp_city;

    ?>
    <div class="form-field-wrap ">
        <div class="field-title"><?php echo __('Company city','job-board-manager-company-profile'); ?></div>
        <div class="field-input">
            <input placeholder="" type="text" value="<?php echo $job_bm_cp_city; ?>" name="job_bm_cp_city">
            <p class="field-details"><?php echo __('Write company city','job-board-manager-company-profile');
                ?></p>
        </div>
    </div>
    <?php
}



add_action('job_bm_company_edit_form', 'job_bm_company_edit_form_address', 30);

function job_bm_company_edit_form_address($company_id){

    $job_bm_cp_address = get_post_meta($company_id, 'job_bm_cp_address', true);

    $job_bm_cp_address = isset($_POST['job_bm_cp_address']) ? sanitize_text_field($_POST['job_bm_cp_address']) : $job_bm_cp_address;

    ?>
    <div class="form-field-wrap " >
        <div class="field-title"><?php echo __('Company address','job-board-manager-company-profile'); ?></div>
        <div class="field-input">
            <input placeholder="" type="text" value="<?php echo $job_bm_cp_address; ?>" name="job_bm_cp_address">
            <p class="field-details"><?php echo __('Write company address','job-board-manager-company-profile');
                ?></p>
        </div>
    </div>
    <?php
}



add_action('job_bm_company_edit_form', 'job_bm_company_edit_form_logo', 30);
function job_bm_company_edit_form_logo($company_id){

    $job_bm_cp_logo = get_post_meta($company_id, 'job_bm_cp_logo', true);
    $job_bm_cp_logo = !empty($job_bm_cp_logo) ? $job_bm_cp_logo : job_bm_cp_plugin_url.'assets/global/images/company.png';

    $job_bm_cp_logo = isset($_POST['job_bm_cp_logo']) ? sanitize_text_field($_POST['job_bm_cp_logo']) : $job_bm_cp_logo;

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


    ?>
    <div class="form-field-wrap job-bm-media-upload">
        <div class="field-title"><?php echo __('Company logo','job-board-manager-company-profile'); ?></div>
        <div class="field-input">
            <div class="media-preview-wrap" style="">
                <img class="media-preview" src="<?php echo $job_bm_cp_logo; ?>" style="width:100%;box-shadow: none;"/>
            </div>

            <input placeholder="" type="text" value="<?php echo $job_bm_cp_logo; ?>" name="job_bm_cp_logo">
            <span class="media-upload " id=""><?php echo __('Upload','job-board-manager-company-profile');?></span>
            <!--            <span class="media-clear" id="">--><?php //echo __('Clear','job-board-manager-company-profile');?><!--</span>-->

            <p class="field-details"><?php echo __('Upload company logo','job-board-manager-company-profile');
                ?></p>
        </div>
    </div>
    <?php
}





add_action('job_bm_company_edit_form', 'job_bm_company_edit_form_website', 30);

function job_bm_company_edit_form_website($company_id){

    $job_bm_cp_website = get_post_meta($company_id, 'job_bm_cp_website', true);

    $job_bm_cp_website = isset($_POST['job_bm_cp_website']) ? sanitize_text_field($_POST['job_bm_cp_website']) : $job_bm_cp_website;

    ?>
    <div class="form-field-wrap " >
        <div class="field-title"><?php echo __('Company website','job-board-manager-company-profile'); ?></div>
        <div class="field-input">
            <input placeholder="" type="text" value="<?php echo $job_bm_cp_website; ?>" name="job_bm_cp_website">
            <p class="field-details"><?php echo __('Write company website ','job-board-manager-company-profile');
                ?></p>
        </div>
    </div>
    <?php
}



add_action('job_bm_company_edit_form', 'job_bm_company_edit_form_founded', 30);

function job_bm_company_edit_form_founded($company_id){

    $job_bm_cp_founded = get_post_meta($company_id, 'job_bm_cp_founded', true);

    $job_bm_cp_founded = isset($_POST['job_bm_cp_founded']) ? sanitize_text_field($_POST['job_bm_cp_founded']) : $job_bm_cp_founded;

    ?>
    <div class="form-field-wrap" >
        <div class="field-title"><?php echo __('Company founded year','job-board-manager-company-profile'); ?></div>
        <div class="field-input">
            <input placeholder="<?php echo __('1980','job-board-manager-company-profile'); ?>" type="text" value="<?php echo $job_bm_cp_founded; ?>" name="job_bm_cp_founded">
            <p class="field-details"><?php echo __('Write company founded year','job-board-manager-company-profile');
                ?></p>
        </div>
    </div>
    <?php
}




add_action('job_bm_company_edit_form', 'job_bm_company_edit_form_size', 30);


function job_bm_company_edit_form_size($company_id){

    $job_bm_cp_size = get_post_meta($company_id, 'job_bm_cp_size', true);

    $job_bm_cp_size = isset($_POST['job_bm_cp_size']) ? sanitize_text_field($_POST['job_bm_cp_size']) : $job_bm_cp_size;

    ?>
    <div class="form-field-wrap">
        <div class="field-title"><?php echo __('Company worker size','job-board-manager-company-profile'); ?></div>
        <div class="field-input">
            <input placeholder="12" type="text" value="<?php echo $job_bm_cp_size; ?>" name="job_bm_cp_size">
            <p class="field-details"><?php echo __('Write company worker szie','job-board-manager-company-profile');
                ?></p>
        </div>
    </div>
    <?php
}









/* display reCaptcha */

add_action('job_bm_company_edit_form', 'job_bm_company_edit_form_recaptcha', 60);

function job_bm_company_edit_form_recaptcha($company_id){

    $job_bm_company_edit_recaptcha		= get_option('job_bm_company_edit_recaptcha');
    $job_bm_reCAPTCHA_site_key		        = get_option('job_bm_reCAPTCHA_site_key');

    if($job_bm_company_edit_recaptcha != 'yes'){
        return;
    }

    ?>
    <div class="form-field-wrap">
        <div class="field-title"></div>
        <div class="field-input">
            <div class="g-recaptcha" data-sitekey="<?php echo $job_bm_reCAPTCHA_site_key; ?>"></div>
            <script src="https://www.google.com/recaptcha/api.js"></script>
            <p class="field-details"><?php echo __('Please prove you are human.','job-board-manager-company-profile'); ?></p>

        </div>
    </div>
    <?php
}


/* Display nonce  */

add_action('job_bm_company_edit_form', 'job_bm_company_edit_form_nonce' );

function job_bm_company_edit_form_nonce($company_id){

    ?>
    <div class="form-field-wrap">
        <div class="field-title"></div>
        <div class="field-input">

            <?php wp_nonce_field( 'job_bm_company_edit_nonce','job_bm_company_edit_nonce' ); ?>

        </div>
    </div>
    <?php
}


/* Display submit button */

add_action('job_bm_company_edit_form', 'job_bm_company_edit_form_submit', 90);

function job_bm_company_edit_form_submit($company_id){

    ?>
    <div class="form-field-wrap">
        <div class="field-title"></div>
        <div class="field-input">
            <input type="submit"  name="submit" value="<?php _e('Submit', 'job-board-manager-company-profile'); ?>" />
        </div>
    </div>
    <?php
}





/* Process the submitted data  */

add_action('job_bm_company_edit_data', 'job_bm_company_edit_data', 99, 2);

function job_bm_company_edit_data($company_id, $post_data){

    $job_bm_company_edit_recaptcha		    = get_option('job_bm_company_edit_recaptcha');
    $job_bm_company_submit_account_required 	= get_option('job_bm_company_submit_account_required', 'yes');
    $job_bm_company_edit_post_status 		= get_option('job_bm_company_edit_post_status', 'pending' );
    $job_bm_job_login_page_id           = get_option('job_bm_job_login_page_id');
    $dashboard_page_url                 = get_permalink($job_bm_job_login_page_id);


    if ( is_user_logged_in() ) {
        $user_id = get_current_user_id();
    } else {
        $user_id = 0;
    }

    $error = new WP_Error();




    if(empty($post_data['post_title'])){

        $error->add( 'post_title', __( 'ERROR: Company name is empty.', 'job-board-manager-company-profile' ) );
    }

    if(empty($post_data['post_content'])){

        $error->add( 'post_content', __( 'ERROR: Company details is empty.', 'job-board-manager-company-profile' ) );
    }

    if(empty($post_data['job_bm_cp_tagline'])){

        $error->add( 'job_bm_cp_tagline', __( 'ERROR: Company tag-line is empty.', 'job-board-manager-company-profile' ) );
    }



    if(empty($post_data['job_bm_cp_size'])){

        $error->add( 'job_bm_cp_size', __( 'ERROR: Company size is empty.', 'job-board-manager-company-profile' ) );
    }






    if(empty($post_data['job_bm_cp_logo'])){

        $error->add( 'job_bm_cp_logo', __( 'ERROR: Company logo is empty.', 'job-board-manager-company-profile' ) );
    }

    if(empty($post_data['g-recaptcha-response']) && $job_bm_company_edit_recaptcha =='yes'){

        $error->add( 'g-recaptcha-response', __( 'ERROR: reCaptcha test failed.', 'job-board-manager-company-profile' ) );
    }

    if($job_bm_company_submit_account_required == 'yes' && !is_user_logged_in()){

        $error->add( 'login',  sprintf (__('ERROR: Please <a target="_blank" href="%s">login</a> to submit question.',
            'job-board-manager-company-profile'), $dashboard_page_url ));
    }

    if(! isset( $_POST['job_bm_company_edit_nonce'] ) || ! wp_verify_nonce( $_POST['job_bm_company_edit_nonce'], 'job_bm_company_edit_nonce' ) ){

        $error->add( '_wpnonce', __( 'ERROR: security test failed.', 'job-board-manager-company-profile' ) );
    }



    $errors = apply_filters( 'job_bm_company_edit_errors', $error, $post_data );






    if ( !$error->has_errors() ) {

        $allowed_html = array();

        $post_title = isset($post_data['post_title']) ? $post_data['post_title'] :'';
        $post_content = isset($post_data['post_content']) ? wp_kses_post($post_data['post_content'], $allowed_html) :
            "";


        wp_update_post(
            array(
                'ID'    => $company_id,
                'post_title'    => $post_title,
                'post_content'  => $post_content,
                'post_status'  => $job_bm_company_edit_post_status,


            )
        );

        do_action('job_bm_company_edited', $company_id, $post_data);

    }
    else{

        $error_messages = $error->get_error_messages();

        ?>
        <div class="errors">
            <?php

            if(!empty($error_messages))
            foreach ($error_messages as $message){
                ?>
                <div class="job-bm-error"><?php echo $message; ?></div>
                <?php
            }
            ?>
        </div>
        <?php
    }
}


/* Display save data after submitted question */

add_action('job_bm_company_edited', 'job_bm_company_edited_save_data', 90, 2);

function job_bm_company_edited_save_data($company_id, $post_data){

    $user_id = get_current_user_id();

    $company_category = isset($post_data['company_category']) ? sanitize_text_field($post_data['company_category']) : "";
    $job_bm_cp_tagline = isset($post_data['job_bm_cp_tagline']) ? sanitize_text_field($post_data['job_bm_cp_tagline']) : "";
    $job_bm_cp_mission = isset($post_data['job_bm_cp_mission']) ? sanitize_text_field($post_data['job_bm_cp_mission']) : "";
    $job_bm_cp_country = isset($post_data['job_bm_cp_country']) ? sanitize_text_field($post_data['job_bm_cp_country']) : "";
    $job_bm_cp_city = isset($post_data['job_bm_cp_city']) ? sanitize_text_field($post_data['job_bm_cp_city']) : "";
    $job_bm_cp_address = isset($post_data['job_bm_cp_address']) ? sanitize_text_field($post_data['job_bm_cp_address']) : "";
    $job_bm_cp_website = isset($post_data['job_bm_cp_website']) ? sanitize_text_field($post_data['job_bm_cp_website']) : "";
    $job_bm_cp_founded = isset($post_data['job_bm_cp_founded']) ? sanitize_text_field($post_data['job_bm_cp_founded']) : "";
    $job_bm_cp_size = isset($post_data['job_bm_cp_size']) ? sanitize_text_field($post_data['job_bm_cp_size']) : "";
    $job_bm_cp_logo = isset($post_data['job_bm_cp_logo']) ? sanitize_text_field($post_data['job_bm_cp_logo']) : "";




    wp_set_post_terms( $company_id, $company_category, 'company_category' );


    update_post_meta($company_id, 'job_bm_cp_tagline', $job_bm_cp_tagline);
    update_post_meta($company_id, 'job_bm_cp_mission', $job_bm_cp_mission);
    update_post_meta($company_id, 'job_bm_cp_country', $job_bm_cp_country);
    update_post_meta($company_id, 'job_bm_cp_city', $job_bm_cp_city);
    update_post_meta($company_id, 'job_bm_cp_address', $job_bm_cp_address);
    update_post_meta($company_id, 'job_bm_cp_website', $job_bm_cp_website);
    update_post_meta($company_id, 'job_bm_cp_founded', $job_bm_cp_founded);

    update_post_meta($company_id, 'job_bm_cp_size', $job_bm_cp_size);

    update_post_meta($company_id, 'job_bm_cp_logo', $job_bm_cp_logo);


}






/* Display success message after submitted question */

add_action('job_bm_company_edited', 'job_bm_company_edited_message', 80, 2);

function job_bm_company_edited_message($company_id, $post_data){

    ?>
    <div class="job-submitted success">
        <?php echo apply_filters('job_bm_company_edited_thank_you', _e('Thanks for update your company.', 'job-board-manager-company-profile')); ?>
    </div>
    <?php


}







add_action('job_bm_company_edited', 'job_bm_company_edited_redirect', 99999, 2);

function job_bm_company_edited_redirect($company_id, $post_data){

    $job_bm_company_edit_redirect 	= get_option('job_bm_company_edit_redirect');




    if(!empty($job_bm_company_edit_redirect)):

        if($job_bm_company_edit_redirect =='company_preview'){
            $redirect_page_url = get_preview_post_link($company_id);
        }
        elseif($job_bm_company_edit_redirect =='company_link'){
            $redirect_page_url = get_permalink($company_id);
        }
        else{
            $job_bm_job_login_page_id 	= get_option('job_bm_job_login_page_id');
            $redirect_page_url 					= get_permalink($job_bm_job_login_page_id).'?tabs=my_companies';
        }

        ?>
        <script>
            jQuery(document).ready(function($) {
                window.location.href = '<?php echo $redirect_page_url; ?>';
            })
        </script>
    <?php

    endif;



//    if ( wp_safe_redirect($redirect_page_url) ) {
//        exit;
//    }


}

