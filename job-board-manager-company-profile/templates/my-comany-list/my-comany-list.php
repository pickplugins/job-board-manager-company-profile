<?php
/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 


if ( get_query_var('paged') ) {$paged = get_query_var('paged');}
elseif ( get_query_var('page') ) {$paged = get_query_var('page');}
else {$paged = 1;}

$job_bm_list_per_page = get_option('job_bm_list_per_page');
$job_bm_company_edit_page_id = get_option('job_bm_company_edit_page_id');
$job_bm_company_edit_page_url = get_permalink($job_bm_company_edit_page_id);



$current_user_id = get_current_user_id();

$wp_query = new WP_Query(
    array(
        'post_type' => 'company',
        'post_status' => 'publish',
        'author' => $current_user_id,
        'orderby' => 'date',
        'order' => 'DESC',
        'posts_per_page' => $job_bm_list_per_page,
        'paged' => $paged,

    ) );
?>

<div class="my-comany-list">

<?php

if ( $wp_query->have_posts() ) :
    while ( $wp_query->have_posts() ) : $wp_query->the_post();

        $company_id = get_the_id();
        $job_bm_cp_logo = get_post_meta($company_id, 'job_bm_cp_logo', true);

       //echo var_export($job_bm_cp_logo, true);
    ?>

        <div class="item">
            <?php if(!empty($job_bm_cp_logo)){

                if(!empty($job_bm_cp_logo)){

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


                }
                else{
                    $job_bm_cp_logo = $job_bm_default_company_logo;
                }

                ?>
                <div class="thumb"><img src="<?php echo $job_bm_cp_logo; ?>" > </div>
            <?php


            }





                ?>




            <div class="details">
                <a class="item-title" href="<?php echo get_permalink(); ?>"><?php echo get_the_title();  ?></a>
                <a class="edit-link" href="<?php echo $job_bm_company_edit_page_url.'?company_id='.$company_id; ?>">Edit</a>

            </div>



        </div>

    <?php


    endwhile;

    echo '<div class="paginate">';
    $big = 999999999; // need an unlikely integer
    echo paginate_links( array(
        'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),

        'format' => '?paged=%#%',
        'current' => max( 1, $paged ),
        'total' => $wp_query->max_num_pages
    ) );

    echo '</div >';

    wp_reset_query();
else:

    echo __('No job found', job_bm_textdomain);


endif;









?>

</div>
