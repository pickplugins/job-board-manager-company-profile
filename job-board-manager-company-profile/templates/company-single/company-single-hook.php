<?php
if ( ! defined('ABSPATH')) exit;  // if direct access 


function job_bm_single_company($content) {

    global $post;

    if ($post->post_type == 'company'){

        ob_start();
        include( job_bm_cp_plugin_dir . 'templates/company-single/company-single.php');


        wp_enqueue_style('job_bm_company_single');
        //wp_enqueue_style('font-awesome-5');
        wp_enqueue_script('job-bm-single-company');


        return ob_get_clean();
    }
    else{
        return $content;
    }

}
add_filter( 'the_content', 'job_bm_single_company' );



add_filter( "comments_template", "job_bm_single_company_comment_template", 90 );

function job_bm_single_company_comment_template( $comment_template ) {
    global $post;

    if($post->post_type == 'company'){ // assuming there is a post type called business

        return job_bm_cp_plugin_dir . 'templates/company-single/company-single-comments.php';
    }else{
        return $comment_template;
    }
}




add_filter( "respond_link", "job_bm_single_company_respond_link", 100, 2 );

function job_bm_single_company_respond_link( $respond_link, $id ) {
    global $post;

    if($post->post_type == 'company'){ // assuming there is a post type called business

        return '';
    }else{
        return $respond_link;
    }
}







add_action('job_bm_company_single', 'job_bm_company_single_cover');

if(!function_exists('job_bm_company_single_cover')){
    function job_bm_company_single_cover($company_id){

        $job_bm_company_cover = get_post_meta($company_id, 'job_bm_company_cover', true);
        $thumb = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'full' );
        $thumb_url = isset($thumb['0']) ? $thumb['0'] : '';

        $job_bm_company_cover = !empty($job_bm_company_cover) ? $job_bm_company_cover : $thumb_url;

        ?>
        <div class="company-cover">
            <img src="<?php echo esc_url_raw($job_bm_company_cover); ?>">
        </div>
        <?php

    }
}




add_action('job_bm_company_single', 'job_bm_company_single_header');

if(!function_exists('job_bm_company_single_header')){
    function job_bm_company_single_header($company_id){

        $company_post_data = get_post($company_id);

        $job_bm_cp_logo = get_post_meta($company_id, 'job_bm_cp_logo', true);
        $job_bm_cp_city = get_post_meta($company_id, 'job_bm_cp_city', true);
        $job_bm_cp_country = get_post_meta($company_id, 'job_bm_cp_country', true);
        $job_bm_cp_tagline = get_post_meta($company_id, 'job_bm_cp_tagline', true);

        ?>
        <div class="company-header">
            <?php
            do_action('job_bm_company_single_header_top', $company_id);


            if(!empty($job_bm_cp_logo)){

                $job_bm_default_company_logo = get_option('job_bm_default_company_logo');

                if(is_serialized($job_bm_cp_logo)){

                    $job_bm_cp_logo = unserialize($job_bm_cp_logo);
                    if(!empty($job_bm_cp_logo[0])){
                        $job_bm_cp_logo = $job_bm_cp_logo[0];
                        $job_bm_cp_logo = wp_get_attachment_url($job_bm_cp_logo);
                    }
                    else{
                        $job_bm_cp_logo = $job_bm_default_company_logo;
                    }
                }



                ?>
                <div class="logo"><img src="<?php echo $job_bm_cp_logo; ?>" /></div>
                <?php

            }




            if(!empty($company_post_data->post_title)){

                ?>
                <div class="header-intro">
                    <div class="company-title"><?php echo $company_post_data->post_title; ?></div>
                    <div class="company-tagline"><?php echo $job_bm_cp_tagline; ?></div>
                    <div class="company-local"><?php echo $job_bm_cp_country; ?> <i class="fa fa-angle-right"></i> <?php echo $job_bm_cp_city; ?></div>

                </div>



                <?php

            }


            do_action('job_bm_company_single_header_bottom', $company_id);

        ?>
        </div>
        <?php


    }
}





add_action('job_bm_company_single_header_top', 'job_bm_company_single_header_top_follower');

if(!function_exists('job_bm_company_single_header_top_follower')){
    function job_bm_company_single_header_top_follower($company_id){

        $follower_id = get_current_user_id();

        global $wpdb;
        $table = $wpdb->prefix . "job_bm_cp_follow";

        $html = '';


        $html.= '<div class="follow">';

        $is_follow_query = $wpdb->get_results("SELECT * FROM $table WHERE company_id = '$company_id' AND follower_id = '$follower_id'", ARRAY_A);
        $is_follow = $wpdb->num_rows;
        if($is_follow > 0 ){

            $follow_text = __('Unfollow', 'job-board-manager-company-profile');
        }
        else{
            $follow_text = __('Follow', 'job-board-manager-company-profile');
        }


        $html.= '<span company_id="'.get_the_ID().'" class="follow-button">'.$follow_text.'</span>';



        $follower_query = $wpdb->get_results("SELECT * FROM $table WHERE company_id = '$company_id' ORDER BY id DESC LIMIT 10");

        $html.= '<div class="follower-list">';

        if(!empty($follower_query))
        foreach( $follower_query as $follower ){
            $follower_id = $follower->follower_id;
            $user = get_user_by( 'id', $follower_id );

            //var_dump($user);
            if(!empty($user->display_name)){
                $html .= '<div title="'.$user->display_name.'" class="follower follower-'.$follower_id.'">';
                $html .= get_avatar( $follower_id, 50 );
                $html .= '</div>';
            }


        }

        $html.= '</div>';

        $html.= '<div class="status"></div>';
        $html.= '</div>';

        echo $html;



    }
}




add_action('job_bm_company_single', 'job_bm_company_single_tabs');

if(!function_exists('job_bm_company_single_tabs')){
    function job_bm_company_single_tabs($company_id){

        $company_tabs = array();

        $company_tabs[] = array(
            'id' => 'description',
            'title' => sprintf(__('%s Descriptions','job-board-manager-company-profile'),'<i class="fas fa-file-signature"></i>'),
            'priority' => 1,
            'active' => true,
        );

        $company_tabs[] = array(
            'id' => 'jobs',
            'title' => sprintf(__('%s Jobs','job-board-manager-company-profile'),'<i class="fas fa-briefcase"></i>'),
            'priority' => 2,
            'active' => false,
        );

        $company_tabs[] = array(
            'id' => 'reviews',
            'title' => sprintf(__('%s Reviews','job-board-manager-company-profile'),'<i class="far fa-comment-dots"></i>'),
            'priority' => 2,
            'active' => false,
        );


        $company_tabs = apply_filters('job_bm_company_single_tabs', $company_tabs);

        $tabs_sorted = array();
        foreach ($company_tabs as $page_key => $tab) $tabs_sorted[$page_key] = isset( $tab['priority'] ) ? $tab['priority'] : 0;
        array_multisort($tabs_sorted, SORT_ASC, $company_tabs);

        ?>
        <div class="company-tabs">
            <ul class="tab-navs">
                <?php
                foreach ($company_tabs as $tab){
                    $id = $tab['id'];
                    $title = $tab['title'];
                    $active = $tab['active'];
                    $data_visible = isset($tab['data_visible']) ? $tab['data_visible'] : '';
                    $hidden = isset($tab['hidden']) ? $tab['hidden'] : false;
                    ?>
                    <li <?php if(!empty($data_visible)):  ?> data_visible="<?php echo $data_visible; ?>" <?php endif; ?> class="tab-nav <?php if($hidden) echo 'hidden';?> <?php if($active) echo 'active';?>" data-id="<?php echo $id; ?>"><?php echo $title; ?></li>
                    <?php
                }
                ?>
            </ul>
            <div class="clear"></div>

            <?php
            foreach ($company_tabs as $tab){
                $id = $tab['id'];
                $title = $tab['title'];
                $active = $tab['active'];
                ?>

                <div class="tab-content <?php if($active) echo 'active';?>" id="<?php echo $id; ?>">
                    <?php
                    do_action('job_bm_company_single_tabs_content_'.$id, $company_id);
                    ?>


                </div>

                <?php
            }
            ?>
        </div>
        <?php




    }
}





add_action('job_bm_company_single_tabs_content_description', 'job_bm_company_single_tabs_content_description');

if(!function_exists('job_bm_company_single_tabs_content_description')){
    function job_bm_company_single_tabs_content_description($company_id){

        $company_post_data = get_post($company_id);
        $job_bm_cp_type = get_post_meta($company_id, 'job_bm_cp_type', true);
        $job_bm_cp_address = get_post_meta($company_id, 'job_bm_cp_address', true);
        $job_bm_cp_website = get_post_meta($company_id, 'job_bm_cp_website', true);
        $job_bm_cp_founded = get_post_meta($company_id, 'job_bm_cp_founded', true);
        $job_bm_cp_size = get_post_meta($company_id, 'job_bm_cp_size', true);
        $job_bm_cp_revenue = get_post_meta($company_id, 'job_bm_cp_revenue', true);
        $job_bm_cp_mission = get_post_meta($company_id, '$job_bm_cp_mission', true);



        ?>
        <div class="company-overview">
            <h3><?php echo __('Quick overview','job-board-manager-company-profile'); ?></h3>

            <?php

            if(!empty($job_bm_cp_address)):
                ?>
                <div class="overview-item"><?php echo sprintf(__('%s Address: %s', 'job-board-manager-company-profile'),'<i class="fas fa-map-marked-alt"></i>', $job_bm_cp_address );?></div>
            <?php
            endif;

            if(!empty($job_bm_cp_website)):
                ?>
                <div class="overview-item"><?php echo sprintf(__('%s Website: %s', 'job-board-manager-company-profile'),'<i class="fas fa-external-link-square-alt"></i>', $job_bm_cp_website );?></div>
            <?php
            endif;

            if(!empty($job_bm_cp_founded)):
                ?>
                <div class="overview-item"><?php echo sprintf(__('%s Founded: %s', 'job-board-manager-company-profile'),'<i class="far fa-calendar-check"></i>', $job_bm_cp_founded );?></div>
            <?php
            endif;

            if(!empty($job_bm_cp_size)):
                ?>
                <div class="overview-item"><?php echo sprintf(__('%s Size: %s', 'job-board-manager-company-profile'),'<i class="fas fa-users"></i>', $job_bm_cp_size );?></div>
            <?php
            endif;

            if(!empty($job_bm_cp_revenue)):
                ?>
                <div class="overview-item"><?php echo sprintf(__('%s Revenue: %s', 'job-board-manager-company-profile'),'<i class="fas fa-money-check-alt"></i>', $job_bm_cp_revenue );?></div>
            <?php
            endif;

            ?>
            <?php



            $company_type = '';

            if(!empty($job_bm_cp_type)){

                foreach($job_bm_cp_type as $type_key=>$type_name){

                    $company_type.= $type_name.', ';
                }

                if(!empty($company_type)):
                    ?>
                    <div class="overview-item"><?php echo sprintf(__('%s Type: %s','job-board-manager-company-profile'),'<i class="fas fa-code-branch"></i>', $company_type );?></div>
                <?php
                endif;

            }




           ?>
            </div>
           <?php


        if(!empty($company_post_data->post_content)){

            ?>
            <h3><?php echo __('Company Descriptions','job-board-manager-company-profile'); ?></h3>

            <div  class="description">
                <?php echo wpautop($company_post_data->post_content); ?>
            </div>
            <?php
        }

    }
}


add_action('job_bm_company_single_tabs_content_jobs', 'job_bm_company_single_tabs_content_jobs');

if(!function_exists('job_bm_company_single_tabs_content_jobs')){
    function job_bm_company_single_tabs_content_jobs($company_id){

        $company_post_data = get_post($company_id);

        ?>
        <h3><?php echo __('Latest Jobs','job-board-manager-company-profile'); ?></h3>

        <?php

            echo do_shortcode('[job_bm_archive display_search="no" display_pagination="no" per_page="-1" company_name="'.$company_post_data->post_title.'"]');



    }
}




add_action('job_bm_company_single_tabs_content_reviews', 'job_bm_company_single_tabs_content_reviews');

if(!function_exists('job_bm_company_single_tabs_content_reviews')){
    function job_bm_company_single_tabs_content_reviews($company_id){

        $company_post_data = get_post($company_id);

        wp_enqueue_style('job-bm-job-submit');

        $args = array(
            'post_id' => $company_id, // use post_id, not post_ID
            //'count' => true //return only the count
            'number' => 5,

        );
        $comments = get_comments($args);

        ?>
        <div class="company-reviews">
            <h3><?php echo __('Latest Reviews','job-board-manager-company-profile'); ?></h3>

            <div class="reviews-list">

                <?php

                if(!empty($comments)):
                    foreach ($comments as $comment){

                        //var_dump($comment);


                        $user_id = $comment->user_id;
                        $comment_content = $comment->comment_content;
                        $comment_date = $comment->comment_date;


                        $comment_author = get_user_by("ID", $user_id);

                        $review_rate = (int) get_comment_meta($comment->comment_ID, 'review_rate', true);


                        //echo '<pre>'.var_export($review_rate, true).'</pre>';

                        ?>
                        <div class="review-item">
                            <div class="comment-rate">
                                <?php

                                for($i=1; $i<= 5; $i++){

                                    if($review_rate < $i){
                                        ?>
                                        <i class="far fa-star"></i>
                                        <?php

                                    }else{
                                        ?>
                                        <i class="fas fa-star"></i>
                                        <?php
                                    }



                                }

                                ?>

                            </div>

                            <div class="comment-author-avatar"><?php echo get_avatar($user_id, '60'); ?></div>

                            <div class="comment-author">
                                <?php echo $comment_author->display_name; ?>
                                <div class="comment-date"><?php echo $comment_date; ?></div>
                            </div>



                            <div class="comment-content"><?php echo $comment_content; ?></div>

                        </div>
                        <?php
                    }
                else:
                    ?>
                    <div class="comment no-comment"><?php echo __('No reviews yet. ','job-board-manager-company-profile'); ?></div>

                <?php
                endif;

                ?>

            </div>


            <h3><?php echo __('Write a reviews','job-board-manager-company-profile'); ?></h3>

            <form class="job-bm-job-submit company-reviews-submit" enctype="multipart/form-data" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">

                <?php

                if(!empty($_POST) && isset($_POST['job_bm_company_reviews_hide'])){
                    do_action('job_bm_company_submit_reviews_data',$company_id, $_POST);
                }


                do_action('job_bm_company_reviews_form', $company_id);

                ?>


            </form>
        </div>
        <?php


    }
}




add_action('job_bm_company_reviews_form', 'job_bm_company_reviews_form_rating');

function job_bm_company_reviews_form_rating($company_id){

    ?>
    <div class="form-field-wrap">
        <div class="field-title"><?php echo __('Rating','job-board-manager-company-profile'); ?></div>
        <div class="field-input">
            <select name="review_rate">
                <option value="5"><?php echo __('Best','job-board-manager-company-profile'); ?></option>
                <option value="4"><?php echo __('Pretty Good','job-board-manager-company-profile'); ?></option>
                <option value="3"><?php echo __('Good','job-board-manager-company-profile'); ?></option>
                <option value="2"><?php echo __('Poor','job-board-manager-company-profile'); ?></option>
                <option value="1"><?php echo __('Very Poor','job-board-manager-company-profile'); ?></option>

            </select>
            <p class="field-details"><?php echo __('Choose your rating','job-board-manager-company-profile');
                ?>
            </p>
        </div>
    </div>
    <?php
}

add_action('job_bm_company_reviews_form', 'job_bm_company_reviews_form_review_text');

function job_bm_company_reviews_form_review_text($company_id){

    ?>
    <div class="form-field-wrap">
        <div class="field-title"><?php echo __('Write your feedback','job-board-manager-company-profile'); ?></div>
        <div class="field-input">
            <textarea name="review_text"></textarea>
            <p class="field-details"><?php echo __('Write your reviews here.','job-board-manager-company-profile'); ?>
            </p>
        </div>
    </div>
    <?php
}



add_action('job_bm_company_reviews_form', 'job_bm_company_reviews_form_submit', 99);

function job_bm_company_reviews_form_submit($company_id){

    ?>

    <div class="form-field-wrap">
        <div class="field-title"></div>
        <div class="field-input">
            <input type="hidden" name="job_bm_company_reviews_hide" value="Y">
            <?php wp_nonce_field( 'job_bm_company_reviews_nonce','job_bm_company_reviews_nonce' ); ?>
            <input type="submit" value="<?php echo __('Submit','job-board-manager-company-profile'); ?>" ></input>
        </div>
    </div>
    <?php
}

















/* Process the submitted data  */

add_action('job_bm_company_submit_reviews_data', 'job_bm_company_submit_reviews_data', 90, 2);

function job_bm_company_submit_reviews_data($company_id, $post_data){

    $job_bm_company_submit_recaptcha		    = get_option('job_bm_company_submit_recaptcha');
    $job_bm_company_submit_account_required 	= get_option('job_bm_company_submit_account_required', 'yes');
    $job_bm_company_submit_post_status 		= get_option('job_bm_company_submit_post_status', 'pending' );
    $job_bm_job_login_page_id           = get_option('job_bm_job_login_page_id');
    $dashboard_page_url                 = get_permalink($job_bm_job_login_page_id);


    if ( is_user_logged_in() ) {
        $user_id = get_current_user_id();
    } else {
        $user_id = 0;
    }

    $error = new WP_Error();




    if(empty($post_data['review_rate'])){

        $error->add( 'review_rate', __( 'ERROR: Review rate is empty.', 'job-board-manager-company-profile' ) );
    }

    if(empty($post_data['review_text'])){

        $error->add( 'review_text', __( 'ERROR: Review text is empty.', 'job-board-manager-company-profile' ) );
    }

//    if(empty($post_data['g-recaptcha-response']) && $job_bm_company_submit_recaptcha =='yes'){
//
//        $error->add( 'g-recaptcha-response', __( 'ERROR: reCaptcha test failed.', 'job-board-manager-company-profile' ) );
//    }

    if( !is_user_logged_in()){

        $error->add( 'login',  sprintf (__('ERROR: Please <a target="_blank" href="%s">login</a> to submit reviews.',
            'job-board-manager-company-profile'), $dashboard_page_url ));
    }

    if(! isset( $_POST['job_bm_company_reviews_nonce'] ) || ! wp_verify_nonce( $_POST['job_bm_company_reviews_nonce'], 'job_bm_company_reviews_nonce' ) ){

        $error->add( '_wpnonce', __( 'ERROR: security test failed.', 'job-board-manager-company-profile' ) );
    }



    $errors = apply_filters( 'job_bm_company_reviews_submit_errors', $error, $post_data );






    if ( !$error->has_errors() ) {

        $allowed_html = array();
        $review_rate = isset($post_data['review_rate']) ? sanitize_text_field($post_data['review_rate']) : 5;
        $review_text = isset($post_data['review_text']) ? wp_kses($post_data['review_text'], $allowed_html) : "";


        $time = current_time('mysql');

        $data = array(
            'comment_post_ID' => $company_id,
//        'comment_author' => '',
//        'comment_author_email' => '',
//        'comment_author_url' => '',
            'comment_content' => $review_text,
            'user_id' => $user_id,
            'comment_date' => $time,
        );

        $comment_id = wp_insert_comment($data);

        update_comment_meta($comment_id, 'review_rate', $review_rate);

        //var_dump($review_rate);

        do_action('job_bm_company_reviews_submitted', $comment_id, $post_data);

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





add_action('job_bm_company_reviews_submitted', 'job_bm_company_reviews_submitted', 99, 2);

function job_bm_company_reviews_submitted($comment_id, $post_data){

    ?>
    <div class="reviews-done success">
        <?php echo __('Thanks for submit reviews.','job-board-manager-company-profile'); ?>
    </div>
    <?php

}



