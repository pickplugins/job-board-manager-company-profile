<?php
if ( ! defined('ABSPATH')) exit;  // if direct access 


function job_bm_single_company($content) {

    global $post;

    if ($post->post_type == 'company'){

        ob_start();
        include( job_bm_cp_plugin_dir . 'templates/company-single/company-single.php');

        //wp_enqueue_style('job_bm_job_single');
        //wp_enqueue_style('font-awesome-5');
        //wp_enqueue_script('jquery-ui-accordion');

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

add_action('job_bm_company_single', 'job_bm_company_single_reviews');

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


        $company_post_data = get_post($company_id);

        $job_bm_cp_type = get_post_meta($company_id, 'job_bm_cp_type', true);

        $job_bm_cp_address = get_post_meta($company_id, 'job_bm_cp_address', true);
        $job_bm_cp_website = get_post_meta($company_id, 'job_bm_cp_website', true);
        $job_bm_cp_founded = get_post_meta($company_id, 'job_bm_cp_founded', true);
        $job_bm_cp_size = get_post_meta($company_id, 'job_bm_cp_size', true);
        $job_bm_cp_revenue = get_post_meta($company_id, 'job_bm_cp_revenue', true);
        $job_bm_cp_mission = get_post_meta($company_id, '$job_bm_cp_mission', true);



        echo '<div class="meta-info">';

        if(!empty($job_bm_cp_address)){
            echo '<div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress" class="meta"><strong><i class="fa fa-map-marker"></i>'.__('Address:','job-board-manager-company-profile').'</strong> '.$job_bm_cp_address.'</div>';
        }

        if(!empty($job_bm_cp_website)){
            echo '<div class="meta"><strong><i class="fa fa-link"></i>'.__('Website:', 'job-board-manager-company-profile').'</strong> '.$job_bm_cp_website.'</div>';
        }



        $company_type = '';

        if(!empty($job_bm_cp_type)){

            foreach($job_bm_cp_type as $type_key=>$type_name){

                $company_type.= $type_name.', ';
            }


            echo '<div class="meta"><strong><i class="fa fa-flag-o"></i>'.__('Type:','job-board-manager-company-profile').'</strong> '.$company_type.'</div>';
        }

        if(!empty($job_bm_cp_founded)){

            echo '<div class="meta"><strong><i class="fa fa-calendar-o"></i>'.__('Founded:','job-board-manager-company-profile').' </strong>'.$job_bm_cp_founded.'</div>';

        }
        if(!empty($job_bm_cp_size)){

            echo '<div class="meta"><strong><i class="fa fa-users"></i>'.__('Size:','job-board-manager-company-profile').'</strong> '.$job_bm_cp_size.'</div>';
        }
        if(!empty($job_bm_cp_revenue)){

            echo '<div class="meta"><strong><i class="fa fa-money"></i>'.__('Revenue:','job-board-manager-company-profile').'</strong> $'.$job_bm_cp_revenue.'</div>';
        }


        echo '</div>'; // .meta-info




        if(!empty($job_bm_cp_mission)){

            echo '<div class="mission"><strong><i class="fa fa-rocket"></i>'.__('Mission:','job-board-manager-company-profile').'</strong> '.$job_bm_cp_mission.'</div>';

        }

        if(!empty($company_post_data->post_content)){
            echo '<div  class="description">'.wpautop($company_post_data->post_content).'</div>';
        }






    }
}




add_action('job_bm_company_single', 'job_bm_company_single_jobs');

if(!function_exists('job_bm_company_single_jobs')){
    function job_bm_company_single_jobs($company_id){

        $company_post_data = get_post(get_the_ID());


        echo '<h2 class="job-list-header">'.sprintf(__('Jobs available from - %s', ''), $company_post_data->post_title).'</h2>';
        echo do_shortcode('[job_list display_search="no" company_name="'.$company_post_data->post_title.'"]');

    }
}