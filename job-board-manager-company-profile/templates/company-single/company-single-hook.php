<?php
if ( ! defined('ABSPATH')) exit;  // if direct access 







function job_bm_single_company($content) {

    global $post;

    if ($post->post_type == 'company'){

        ob_start();
        include( job_bm_cp_plugin_dir . 'templates/company-single/company-single.php');

        //wp_enqueue_style('job_bm_job_single');
        //wp_enqueue_style('font-awesome-5');
        wp_enqueue_script('job-bm-single-company');


        return ob_get_clean();
    }
    else{
        return $content;
    }

}
add_filter( 'the_content', 'job_bm_single_company' );





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
                    <div class="company-name"><?php echo $company_post_data->post_title; ?></div>
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











//add_action('job_bm_company_single', 'job_bm_company_single_reviews');

if(!function_exists('job_bm_company_single_reviews')){
    function job_bm_company_single_reviews($company_id){



        $company_post_data = get_post($company_id);


        $job_bm_job_login_page_id = get_option('job_bm_job_login_page_id');


        echo '<div  class="reviews">';


        $comments = get_comments( array( 'post_id' => get_the_ID(), 'status' => 'approve', 'number' => 5,) );
        //var_dump($comments);

        if(empty($comments)){

            $taotal_comments = 0;
            $taotal_rate = 0;
            $ratings = 0;

        }
        else{

            //var_dump($comments);

            foreach($comments as $comment){

                $comment_ID = $comment->comment_ID;

                $review_rate[] = get_comment_meta( $comment_ID, 'job_bm_review_rate', true );

            }

            $taotal_comments = count($review_rate);
            $taotal_rate = array_sum($review_rate);
            $ratings = ($taotal_rate/$taotal_comments)*20;

        }

        echo '<div title="'.sprintf("%u&#37; - Total: %u",$ratings, $taotal_comments).'"  class="ratings"><div class="rate" style=" width:'.($ratings).'%;"></div></div><div class="ratings-des">'.sprintf("%u&#37; - Total: %u",$ratings, $taotal_comments).'</div>';

        echo '<ul  class="reviews-list">';

        foreach($comments as $comment){
            $comment_content = $comment->comment_content;
            $comment_author_email = $comment->comment_author_email;
            $comment_ID = $comment->comment_ID;
            $rate = get_comment_meta( $comment_ID, 'job_bm_review_rate', true );


            echo '<li class="review">';

            echo '';
            echo '<div class="comment"><div class="thumb">'.get_avatar( $comment_author_email, 50 ).'</div> <i class="fa fa-quote-left"></i> '.$comment_content.' <i class="fa fa-quote-right"></i></div>';
            //echo '<div class="rate">'.__(sprintf('Rate: %u', $rate),job_bm_cp).'/5</div>';

            echo '</li>';


        }


        echo '</ul>';


        echo '<div  class="reviews-input">
		
		<div  class="input-form">
		<span class="close"><i class="fa fa-times" aria-hidden="true"></i></span>';

        if(is_user_logged_in()){

            echo '<p>'.__('Rate','job-board-manager-company-profile').'<br/>';

            echo '<select class="rate-value">';
            echo '<option value="5">5</option>';
            echo '<option value="4">4</option>';
            echo '<option value="3">3</option>';
            echo '<option value="2">2</option>';
            echo '<option value="1">1</option>';
            echo '</select>';

            echo '</p>';

            echo '<p>'.__('Comments', 'job-board-manager-company-profile').'<br/>';
            echo '<textarea class="rate-comment">';
            echo '</textarea>';
            echo '</p>';
            echo '<div post-id="'.get_the_ID().'" class="submit button">'.__('Submit', 'job-board-manager-company-profile').'</div>';
            echo '<div class="message"></div>';



        }
        else{

            echo '<div class="message"><i class="fa fa-times"></i> '.sprintf(__('Please <a href="%s">login</a> to submit reviews','job-board-manager-company-profile'), get_permalink($job_bm_job_login_page_id)).'</div>';
        }


        echo '</div>
		</div>';

        echo '</div>';



    }
}




add_action('job_bm_company_single', 'job_bm_company_single_tabs');

if(!function_exists('job_bm_company_single_tabs')){
    function job_bm_company_single_tabs($company_id){

        $company_tabs = array();

        $company_tabs[] = array(
            'id' => 'description',
            'title' => sprintf(__('%s Descriptions','job-board-manager'),'<i class="fas fa-file-signature"></i>'),
            'priority' => 1,
            'active' => true,
        );

        $company_tabs[] = array(
            'id' => 'jobs',
            'title' => sprintf(__('%s Jobs','job-board-manager'),'<i class="fas fa-briefcase"></i>'),
            'priority' => 2,
            'active' => false,
        );

        $company_tabs[] = array(
            'id' => 'reviews',
            'title' => sprintf(__('%s Reviews','job-board-manager'),'<i class="far fa-comment-dots"></i>'),
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
                <div class="overview-item"><?php echo sprintf(__('%s Address: %s'),'<i class="fas fa-map-marked-alt"></i>', $job_bm_cp_address );?></div>
            <?php
            endif;

            if(!empty($job_bm_cp_website)):
                ?>
                <div class="overview-item"><?php echo sprintf(__('%s Website: %s'),'<i class="fas fa-external-link-square-alt"></i>', $job_bm_cp_website );?></div>
            <?php
            endif;

            if(!empty($job_bm_cp_founded)):
                ?>
                <div class="overview-item"><?php echo sprintf(__('%s Founded: %s'),'<i class="far fa-calendar-check"></i>', $job_bm_cp_founded );?></div>
            <?php
            endif;

            if(!empty($job_bm_cp_size)):
                ?>
                <div class="overview-item"><?php echo sprintf(__('%s Size: %s'),'<i class="fas fa-users"></i>', $job_bm_cp_size );?></div>
            <?php
            endif;

            if(!empty($job_bm_cp_revenue)):
                ?>
                <div class="overview-item"><?php echo sprintf(__('%s Revenue: %s'),'<i class="fas fa-money-check-alt"></i>', $job_bm_cp_revenue );?></div>
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
                    <div class="overview-item"><?php echo sprintf(__('%s Type: %s'),'<i class="fas fa-code-branch"></i>', $company_type );?></div>
                <?php
                endif;

            }




           ?>
            </div>
           <?php




        if(!empty($job_bm_cp_mission)):

            ?>
            <div class="mission"><strong><i class="fa fa-rocket"></i>'.__('Mission:','job-board-manager-company-profile').'</strong> '.$job_bm_cp_mission.'</div>
            <?php

        endif;















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


            echo do_shortcode('[job_list display_search="no" company_name="'.$company_post_data->post_title.'"]');



    }
}




add_action('job_bm_company_single_tabs_content_reviews', 'job_bm_company_single_tabs_content_reviews');

if(!function_exists('job_bm_company_single_tabs_content_reviews')){
    function job_bm_company_single_tabs_content_reviews($company_id){

        $company_post_data = get_post($company_id);

        wp_enqueue_style('job-bm-job-submit');

        if(!empty($_POST)){
            do_action('job_bm_company_submit_reviews_data', $_POST);
        }


        ?>
        <div class="company-reviews">
            <form class="job-bm-job-submit" enctype="multipart/form-data" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">


                <div class="form-field-wrap">
                    <div class="field-title"><?php esc_html_e('Ratting','job-board-manager'); ?></div>
                    <div class="field-input">
                        <select name="review_rate">
                            <option value="5">Best</option>
                            <option value="4">Pretty Good</option>
                            <option value="3">Good</option>
                            <option value="2">Poor</option>
                            <option value="1">Very Poor</option>




                        </select>
                        <p class="field-details"><?php esc_html_e('Choose your ratting','job-board-manager');
                            ?>
                        </p>
                    </div>
                </div>


                <div class="form-field-wrap">
                    <div class="field-title"><?php esc_html_e('Write your feedback','job-board-manager'); ?></div>
                    <div class="field-input">
                        <textarea name="review_text"></textarea>
                        <p class="field-details"><?php esc_html_e('Write your reviews here.','job-board-manager'); ?>
                        </p>
                    </div>
                </div>


                <div class="form-field-wrap">
                    <div class="field-title"></div>
                    <div class="field-input">
                        <input type="submit" value="Submit" ></input>
                    </div>
                </div>



            </form>
        </div>
        <?php


    }
}













