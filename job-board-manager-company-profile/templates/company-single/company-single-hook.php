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










add_action('job_bm_company_single', 'job_bm_company_single_header');

if(!function_exists('job_bm_company_single_header')){
    function job_bm_company_single_header($company_id){

        $company_post_data = get_post($company_id);

        $job_bm_cp_logo = get_post_meta($company_id, 'job_bm_cp_logo', true);
        $job_bm_cp_city = get_post_meta($company_id, 'job_bm_cp_city', true);
        $job_bm_cp_country = get_post_meta($company_id, 'job_bm_cp_country', true);
        $job_bm_cp_tagline = get_post_meta($company_id, 'job_bm_cp_tagline', true);



        $header_html = '';
        echo '<div class="company-header">';

        $thumb = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'full' );
        $thumb_url = $thumb['0'];

        if(!empty($thumb_url)){
            $header_html .= '<div class="thumb"><img src="'.$thumb_url.'" /></div>';
        }

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



            $header_html .= '<div class="logo"><img src="'.$job_bm_cp_logo.'" /></div>';

        }




        if(!empty($company_post_data->post_title)){
            $header_html .= '<h1 itemprop="name" class="name">'.$company_post_data->post_title.'<span class="tagline">'.$job_bm_cp_tagline.'</span><span class="local">'.$job_bm_cp_country.' <i class="fa fa-angle-right"></i> '.$job_bm_cp_city.'</span></h1>';
            $header_html .= '';

        }

        echo apply_filters('job_bm_cp_filter_company_single_header',$header_html);


        echo '</div>'; // .company-header


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



add_action('job_bm_company_single', 'job_bm_company_single_meta');

if(!function_exists('job_bm_company_single_meta')){
    function job_bm_company_single_meta($company_id){





    }
}






add_action('job_bm_company_single', 'job_bm_company_single_tabs');

if(!function_exists('job_bm_company_single_tabs')){
    function job_bm_company_single_tabs($company_id){

        $company_tabs = array();

        $company_tabs[] = array(
            'id' => 'description',
            'title' => sprintf(__('%s Descriptions','job-board-manager'),'<i class="fas fa-list-ul"></i>'),
            'priority' => 1,
            'active' => true,
        );

        $company_tabs[] = array(
            'id' => 'jobs',
            'title' => sprintf(__('%s Jobs','job-board-manager'),'<i class="far fa-copy"></i>'),
            'priority' => 2,
            'active' => false,
        );

        $company_tabs[] = array(
            'id' => 'reviews',
            'title' => sprintf(__('%s Reviews','job-board-manager'),'<i class="far fa-copy"></i>'),
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


















