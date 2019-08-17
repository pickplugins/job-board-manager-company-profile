<?php
if ( ! defined('ABSPATH')) exit;  // if direct access

add_action('job_bm_company_list','job_bm_company_list_main');

if(!function_exists('job_bm_company_list_main')):

    function job_bm_company_list_main($atts){

        $max_job_count = isset($atts['max_job']) ? $atts['max_job'] : 3;


        $post_per_page = 10;
        $allow_empty_job_showing = true;

        if ( get_query_var('paged') ) {

            $paged = get_query_var('paged');

        } elseif ( get_query_var('page') ) {

            $paged = get_query_var('page');

        } else {

            $paged = 1;

        }

        $wp_query = new WP_Query( array (
            'post_type' => 'company',
            'post_status' => 'publish',
            'orderby' => 'date',
            'order' => 'DESC',
            'posts_per_page' =>$post_per_page,
            'paged' => $paged,
        ) );


        if( $wp_query->have_posts() ) :
            while ($wp_query->have_posts()) : $wp_query->the_post();

                $company_post_data = get_post(get_the_ID());

                unset($meta_query);
                $meta_query[] = array(
                    'key' => 'job_bm_company_name',
                    'value' => $company_post_data->post_title,
                    'compare' => '=',
                );

                $wp_query_custom = new WP_Query(
                    array (
                        'post_type' => 'job',
                        'post_status' => 'publish',
                        'meta_query' => $meta_query,
                    ) );

                if ( $allow_empty_job_showing == false ){
                    if ( $wp_query_custom->found_posts < 1 )
                        continue;
                }


                ?>
                <div class="list-item">

                        <?php

                        $job_bm_cp_logo = get_post_meta(get_the_ID(),'job_bm_cp_logo', true);


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



                        //var_dump($job_bm_cp_logo);

                        ?>
                        <div class="company-thumbnail">
                            <img  src="<?php echo $job_bm_cp_logo; ?>" />
                        </div>

                        <div class="company-details">
                            <div class="company-name">
                                <a href="<?php echo get_permalink(); ?>"><?php echo $company_post_data->post_title; ?></a>
                            </div>
                            <ul class="company-jobs">
                                <?php

                                $count = 0;


                                if ( $wp_query_custom->have_posts() ):

                                    while ( $wp_query_custom->have_posts() ) : $wp_query_custom->the_post();

                                        if ( $count < $max_job_count )

                                            ?>
                                            <li>
                                                <a href="<?php echo get_permalink(); ?>" target="_blank"><?php echo get_the_title(); ?></a>
                                            </li>
                                            <?php

                                        $count++;

                                    endwhile;

                                else:

                                endif;
                                wp_reset_query();

                                ?>
                            </ul>
                        </div>


                    <div class="clear"></div>

                </div>
                <?php




            endwhile;


            ?>
            <div class="paginate">
            <?php
            $big = 999999999; // need an unlikely integer
            echo paginate_links( array(
                'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                'format' => '?paged=%#%',
                'current' => max( 1, $paged ),
                'total' => $wp_query->max_num_pages
            ) );

            ?>
            </div>
            <?php







            wp_reset_query();
        endif;

        ?>

        <?php
    }

endif;




add_action('job_bm_company_list','job_bm_company_list_style');

if(!function_exists('job_bm_company_list_style')){
    function job_bm_company_list_style($atts){

        $column = isset($atts['column']) ? $atts['column'] : 2;

        ?>
        <style type="text/css">
            .job-bm-company-list .list-item{
                width: <?php echo 93/$column ?>%;
                display: inline-block;
                vertical-align: top;
            }
        </style>
        <?php


    }
}







