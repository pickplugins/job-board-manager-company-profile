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

        $html.= '<i class="fa fa-exclamation-circle"></i> '.__('You are not authorized to delete this job.','job-board-manager');

    }
    else{

        $company_id = (int)sanitize_text_field($_POST['company_id']);

        $current_user_id = get_current_user_id();

        $post_data = get_post($company_id, ARRAY_A);

        $author_id = $post_data['post_author'];

        if( $current_user_id == $author_id ){

            if(wp_trash_post($company_id)){
                $html.=	'<i class="fa fa-check"></i> '.__('Company Deleted.','job-board-manager');
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























function job_bm_cp_ajax_submit_reviews(){
	
	$post_id = (int)$_POST['post_id'];
	$rate_value = (int)$_POST['rate_value'];	
	$rate_comment = sanitize_text_field($_POST['rate_comment']);	
	
	
	$current_user = wp_get_current_user();

	$comment_author_email = $current_user->user_email;
	$comment_author = $current_user->user_nicename;

	$data = array(
		'comment_post_ID' => $post_id,
		'comment_author_email' => $comment_author_email,	
		'comment_author_url' => '',	
		'comment_author' => $comment_author,						
		'comment_content' => $rate_comment,
		'comment_type' => '',
		'comment_parent' => 0,
		'comment_author_IP' => $_SERVER['REMOTE_ADDR'],
		'comment_agent' => $_SERVER['HTTP_USER_AGENT'],
		'comment_date' => current_time('mysql'),
		'comment_approved' => 1
	);
	
	
	$comments = get_comments( array( 'post_id' => $post_id, 'status' => 'all', 'author_email'=>$comment_author_email ) );
	
	
	if(!empty($comments)){
		
		echo '<i class="fa fa-times"></i> '.__('You already submitted a reviews', 'job-board-manager-company-profile');

		
		}
	else{
		
		$comment_id = wp_insert_comment( $data );
		add_comment_meta( $comment_id, 'job_bm_review_rate', $rate_value );
		
		echo '<i class="fa fa-check" aria-hidden="true"></i> '.__('Review submitted.', 'job-board-manager-company-profile');
		}
	
	
	
	
	die();
	}

add_action('wp_ajax_job_bm_cp_ajax_submit_reviews', 'job_bm_cp_ajax_submit_reviews');
add_action('wp_ajax_nopriv_job_bm_cp_ajax_submit_reviews', 'job_bm_cp_ajax_submit_reviews');



function SetFeaturedImage( $image_url, $post_id  ){
    $upload_dir = wp_upload_dir();
    $image_data = file_get_contents($image_url);
    $filename = basename($image_url);
    if(wp_mkdir_p($upload_dir['path']))     $file = $upload_dir['path'] . '/' . $filename;
    else                                    $file = $upload_dir['basedir'] . '/' . $filename;
    file_put_contents($file, $image_data);

    $wp_filetype = wp_check_filetype($filename, null );
    $attachment = array(
        'post_mime_type' => $wp_filetype['type'],
        'post_title' => sanitize_file_name($filename),
        'post_content' => '',
        'post_status' => 'inherit'
    );
    $attach_id = wp_insert_attachment( $attachment, $file, $post_id );
    require_once(ABSPATH . 'wp-admin/includes/image.php');
    $attach_data = wp_generate_attachment_metadata( $attach_id, $file );
    $res1= wp_update_attachment_metadata( $attach_id, $attach_data );
    $res2= set_post_thumbnail( $post_id, $attach_id );
}






function job_bm_cp_ajax_company_single_header_extra($html){
	
	$company_id = get_the_ID();
	$follower_id = get_current_user_id();
	
	global $wpdb;
	$table = $wpdb->prefix . "job_bm_cp_follow";

	
	
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
	
	foreach( $follower_query as $follower )
		{
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
	$html.= '<div class="clear"></div>';
	
	return $html;
	
	
	}
	
add_filter('job_bm_cp_filter_company_single_header','job_bm_cp_ajax_company_single_header_extra');


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









		