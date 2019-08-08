<?php	


/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 


if(!empty($_POST['update_logo_hidden']))
{

    $nonce = sanitize_text_field($_POST['_wpnonce']);

    if(wp_verify_nonce( $nonce, 'nonce_update_logo' ) && $_POST['update_logo_hidden'] == 'Y') {


        $action_start = 'yes';


    }


}
	
?>





<div class="wrap">

	<div id="icon-tools" class="icon32"><br></div><?php echo "<h2>".__(sprintf('%s - Update logo',job_bm_cp_plugin_name), 'job-board-manager-company-profile')."</h2>";?>
    
    <div class="para-settings job-bm-admin">
    
   		<div class="option-box">

            <?php


            if(!empty($action_start)):


                $wp_query = new WP_Query(
                    array (
                        'post_type' => 'company',
                        'post_status' => 'any',
                        'order' => 'DESC',
                        'posts_per_page' => -1,


                    ) );

            if ( $wp_query->have_posts() ) :

            global $wpdb;
            $prefix = $wpdb->prefix;
            $table = $prefix . "posts";

            $i = 1;
            while ( $wp_query->have_posts() ) : $wp_query->the_post();

                $company_title = get_the_title();
                $job_bm_cp_logo = get_post_meta(get_the_id(), 'job_bm_cp_logo', true);

                echo '<a href="'.get_permalink().'">'.$company_title.'</a><br/>';


                if(is_serialized($job_bm_cp_logo)){

                    echo 'already update';
                    //echo $job_bm_cp_logo.'<br/>';
                }
                else{

                    echo '<img style="width:30px" src="'.$job_bm_cp_logo.'" /><br/>';

                    echo 'external image can not update, please update manually.' ;

                    $attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $table WHERE guid='%s';", $job_bm_cp_logo ));


                    if(!empty($attachment ) && !empty($attachment[0])){

                        $attachment_id = $attachment[0];
                        $job_bm_cp_logo_new  = serialize(array($attachment_id));

                        echo 'Update successful.';
                        //echo '<pre> '.var_export($attachment_id, true).'</pre>';

                        update_post_meta(get_the_id(), 'job_bm_cp_logo', $job_bm_cp_logo_new);
                    }

                }

                echo '<br/>######### <br/><br/>';

                $i++;
            endwhile;
            else:

                echo __('No company found',job_bm_textdomain);

            endif;



            update_option('job_bm_company_logo_upgrade','yes');



            else:

                ?>
                <form method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">

                    <input type="hidden" name="update_logo_hidden" value="Y">





                    <?php wp_nonce_field( 'nonce_update_logo' ); ?>
                    <input class="button primary" type="submit" value="Start Update">

                </form>
            <?php

            endif;

            ?>






            
        </div>    
    

        
        
        
        
        
        
        
        
        
    
    </div>

</div>
