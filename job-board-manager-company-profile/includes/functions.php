<?php
/*
* @Author 		ParaTheme
* @Folder	 	job-board-manager/includes
* Copyright: 	2015 ParaTheme
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 





function job_bm_ajax_delete_company_by_id() {

    $job_bm_can_user_delete_jobs = get_option('job_bm_can_user_delete_jobs');

    $html = '';


    if($job_bm_can_user_delete_jobs=='no'){

        $html.= '<i class="fa fa-exclamation-circle"></i> '.__('You are not authorized to delete this job.','job-board-manager-company-profile');

    }
    else{

        $company_id = (int)sanitize_text_field($_POST['company_id']);

        $current_user_id = get_current_user_id();

        $post_data = get_post($company_id, ARRAY_A);

        $author_id = $post_data['post_author'];

        if( $current_user_id == $author_id ){

            if(wp_trash_post($company_id)){
                $html.=	'<i class="fa fa-check"></i> '.__('Company Deleted.','job-board-manager-company-profile');
                $response['is_deleted'] = 'yes';

                do_action('job_bm_job_trash', $company_id);

            }
            else{
                $html.=	'<i class="fa fa-exclamation-circle"></i> '.__('Something going wrong.','job-board-manager');
                $response['is_deleted'] = 'no';
            }
        }

        else{

            $html.=	'<i class="fa fa-exclamation-circle"></i> '.__('You are not authorized to delete this company.','job-board-manager');
            $response['is_deleted'] = 'no';
        }
    }

    $response['html'] = $html;

    echo json_encode($response);

    //echo $html;

    die();
}

add_action('wp_ajax_job_bm_ajax_delete_company_by_id', 'job_bm_ajax_delete_company_by_id');
//add_action('wp_ajax_nopriv_job_bm_ajax_delete_job_by_id', 'job_bm_ajax_delete_job_by_id');



function job_bm_cp_ajax_company_folowing(){
	

		$company_id = (int)$_POST['company_id'];


		$html = array();
		
		
		if ( is_user_logged_in() ) 
			{
				$follower_id = get_current_user_id();
		
				global $wpdb;
				$table = $wpdb->prefix . "job_bm_cp_follow";
				$result = $wpdb->get_results("SELECT * FROM $table WHERE company_id = '$company_id' AND follower_id = '$follower_id'", ARRAY_A);
				$already_insert = $wpdb->num_rows;
			
				if($already_insert > 0 )
					{
							
						$wpdb->delete( $table, array( 'company_id' => $company_id, 'follower_id' => $follower_id), array( '%d','%d' ) );
						//$wpdb->query("UPDATE $table SET followed = '$followed' WHERE author_id = '$authorid' AND follower_id = '$follower_id'");

						$html['follower_id'] = $follower_id;
						$html['follow_status'] = 'unfollow';
						$html['follow_class'] = 'follow_no';
						$html['follow_text'] = 'Follow';						
					}
				else
					{
						$wpdb->query( $wpdb->prepare("INSERT INTO $table 
													( id, company_id, follower_id, follow)
											VALUES	( %d, %d, %d, %s )",
											array	( '', $company_id, $follower_id, 'yes')
													));
						
						$html['follower_id'] = $follower_id;
						$html['follow_status'] = 'following';
						$html['follow_class'] = 'follow_yes';
						$html['follow_text'] = 'Unfollow';	
						$html['follower_html'] = '<div class="follower follower-'.$follower_id.'">'.get_avatar( $follower_id, 32 ).'</div>';
	
						
					}

			}
		else
			{
				$html['login_error'] = __('Please login first.', 'job-board-manager-company-profile');
			}
		
		
		echo json_encode($html);
		

		die();		

	}

add_action('wp_ajax_job_bm_cp_ajax_company_folowing', 'job_bm_cp_ajax_company_folowing');
add_action('wp_ajax_nopriv_job_bm_cp_ajax_company_folowing', 'job_bm_cp_ajax_company_folowing');










function job_bm_cp_ajax_job_company_list(){
	
	$name = $_POST['name'];
	$company_name = '';
	
  
	  
	  
	global $wpdb;
	
	$company_ids = $wpdb->get_col("select ID from $wpdb->posts where post_title like '%".$name."%' ");
	if(!empty($company_ids)){
		
		$args = array(	'post_type' => 'company',
						'post_status' => 'publish',
						'post__in' => $company_ids,
						'orderby' => 'title',
						'order' => 'ASC',
						'posts_per_page' => 10,);
						
		$company_data = get_posts($args);		
			
			
		if(!empty($company_data)){
			
			foreach($company_data as $key=>$values){
				
				$company_name.= '<div company-id="'.$values->ID.'"  company-data="'.$values->post_title.'" class="item">'.$values->post_title.'</div>';
				
				}
			}
		else{
			
			$company_name.= '<div class="item">'.__('Nothing found', 'job-board-manager-company-profile').'</div>';
			}
						
		}
	else{
		
		$company_name.= '<div class="item">'.__('Nothing found', 'job-board-manager-company-profile').'</div>';
		} 
	  


	echo $company_name;

	
	die();
	}
add_action('wp_ajax_job_bm_cp_ajax_job_company_list', 'job_bm_cp_ajax_job_company_list');
add_action('wp_ajax_nopriv_job_bm_cp_ajax_job_company_list', 'job_bm_cp_ajax_job_company_list');



	function job_bm_cp_ajax_company_info_by_id(){
		
		$company_id = (int)$_POST['company_id'];
		
		$comapny['job_bm_cp_city'] = get_post_meta($company_id,'job_bm_cp_city',true);
		$comapny['job_bm_cp_address'] = get_post_meta($company_id,'job_bm_cp_address',true);
		$comapny['job_bm_cp_logo'] = get_post_meta($company_id,'job_bm_cp_logo',true);		
		$comapny['job_bm_cp_website'] = get_post_meta($company_id,'job_bm_cp_website',true);					
		
		echo json_encode($comapny);

		die();
		}

add_action('wp_ajax_job_bm_cp_ajax_company_info_by_id', 'job_bm_cp_ajax_company_info_by_id');
add_action('wp_ajax_nopriv_job_bm_cp_ajax_company_info_by_id', 'job_bm_cp_ajax_company_info_by_id');









		