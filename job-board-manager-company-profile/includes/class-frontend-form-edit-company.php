<?php

/*
* @Author 		ParaTheme
* Copyright: 	2015 ParaTheme
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

class class_frontend_forms_company{
	
	public function __construct(){
	}
	
	public function frontend_forms_html($form_info,$meta_options){
			$html = '';
			
			$job_bm_reCAPTCHA_enable = get_option('job_bm_reCAPTCHA_enable');		
			$job_bm_reCAPTCHA_site_key = get_option('job_bm_reCAPTCHA_site_key');
			$job_bm_reCAPTCHA_secret_key = get_option('job_bm_reCAPTCHA_secret_key');
			
			$job_bm_submitted_company_status = get_option('job_bm_submitted_company_status');				
			$job_bm_account_required_post_job = get_option('job_bm_account_required_post_job');
			$job_bm_company_login_page_id = get_option('job_bm_company_login_page_id');			


			if( empty($job_bm_company_login_page_id)) $job_bm_company_login_page_id = '#';
			if( empty($job_bm_submitted_company_status))	$job_bm_submitted_company_status = 'pending';
			if( is_user_logged_in() )  $userid = get_current_user_id();

			if($job_bm_account_required_post_job=='yes' && !is_user_logged_in())
				return '<div class="job_bm_front_error"><i class="fa fa-exclamation-triangle"></i> '.sprintf(__('Please <a href="%s">login</a> to continue !', job_bm_categories_textdomain), get_permalink($job_bm_company_login_page_id)).' </div>';
			
			$html.= '<div class="frontend-forms '.$form_info['form-id'].'">';
			$html.= '<div class="validations" ></div>';	
			
			if(isset($_GET['job_edit_id'])){
					$job_edit_id = (int)$_GET['job_edit_id'];
					$job_data = get_post($job_edit_id);
					
					$post_title = $job_data->post_title;
					$post_content = $job_data->post_content;
				}
			else{
					$post_title ='';
					$post_content ='';
				}
				
				
				
			if( empty($_POST['frontend_form_hidden']) )
			{}
			elseif(isset($_POST['frontend_form_hidden']) && $_POST['frontend_form_hidden'] == 'Y' && !empty($_POST['g-recaptcha-response']))
			{
				$post_title = sanitize_text_field($_POST['post_title']);
				$post_content = sanitize_text_field($_POST['post_content']);				

				$job_post = array(
				  'post_title'    => $post_title,
				  'post_content'  => $post_content,
				  'post_status'   => $job_bm_submitted_company_status,
				  'post_type'   => 'company',
				  'post_author'   => $userid,
				);

				$new_post_ID = wp_insert_post($job_post);
	
					
				foreach($meta_options as $key=>$options)
				{
					foreach($options as $option_key=>$option_info)
					{
						if(!empty($_POST[$option_key]))
						{
							
							$option_value = $_POST[$option_key];
							$option_value = job_bm_sanitize_data($option_info['input_type'],$_POST[$option_key]);
						}
						else
						{
							$option_value = '';
						}
						update_post_meta($new_post_ID, $option_key , $option_value);
					}
				}
					
				$job_bm_submitted_company_status = get_option('job_bm_submitted_company_status');
				if ( empty($job_bm_submitted_company_status) ) $job_bm_submitted_company_status ="Pending";	
				$html.= '<div class="message green" ><i class="fa fa-check-square-o"></i> '.__('Company Submited', 'job-board-manager-company-profile').'</div>';
				$html.= '<div class="submission-status" ><i class="fa fa-exclamation-triangle"></i> '.__('Submission Status: ','job-board-manager-company-profile').''.$job_bm_submitted_company_status.'</div>';
					
				$html.= apply_filters('job_bm_after_company_submitted','', $new_post_ID);
					
					/*require_once(  plugin_dir_path( __FILE__ ) .'menu/emails-templates.php');
					

					
					global $current_user; // to get user display name
					
					$vars = array(
						'{site_name}'=> get_bloginfo('name'),
						'{site_description}' => get_bloginfo('description'),
						'{site_url}' => get_bloginfo('url'),						
					 	'{site_logo_url}' => get_option('job_bm_logo_url'),
					  
					  	'{user_name}' => $current_user->display_name,						  
					  	'{user_avatar}' => get_avatar( $userid, 60 ),
					  	'{user_email}' => '',
													
					  	'{job_title}'  => get_the_title($new_post_ID),						  			
					  	'{job_url}'  => get_permalink($new_post_ID),
					  	'{job_edit_url}'  => get_admin_url().'post.php?post='.$new_post_ID.'&action=edit',						
					  	'{new_post_ID}'  => $new_post_ID,	
					  	'{job_content}'  => $post_content,												

					);
					
					$admin_email = get_option('admin_email');					
					$job_bm_email_templates_data = get_option( 'job_bm_email_templates_data' );
					
					
					if(empty($job_bm_email_templates_data)){
						
						$class_company_bm_emails = new class_company_bm_emails();
						$templates_data = $class_company_bm_emails->job_bm_email_templates_data();
						$job_bm_email_templates_data = $templates_data;
						
						}
					else{
						$class_company_bm_emails = new class_company_bm_emails();
						$templates_data = $class_company_bm_emails->job_bm_email_templates_data();
						
						$job_bm_email_templates_data =array_merge($templates_data, $job_bm_email_templates_data);
						
						}	
					
					
					//$class_company_bm_emails = new class_company_bm_emails();
					//$job_bm_email_templates_data = $class_company_bm_emails->job_bm_email_templates_data();
					
					
					$email_body = strtr($job_bm_email_templates_data['new_company_submitted']['html'], $vars);
					$email_subject =strtr($job_bm_email_templates_data['new_company_submitted']['subject'], $vars);
					
					$headers = "";
					$headers .= "From: ".get_option('job_bm_from_email')." \r\n";
					$headers .= "MIME-Version: 1.0\r\n";
					$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
					
					wp_mail($admin_email, $email_subject, $email_body, $headers);
					*/
					
				}
				else
				{
					$html.= '<div class="message warring" ><i class="fa fa-close"></i> '.__('Something error', 'job-board-manager-company-profile').'</div>';
					
					}
		
		
			global $post;
			
			//$meta_options = $this->meta_options();
			//var_dump($meta_options);
			
			
			$html.= '<form id="frontend-form-company-submit" enctype="multipart/form-data"   method="post" action="'.str_replace( '%7E', '~', $_SERVER['REQUEST_URI']).'">';

			$html.= '<input type="hidden" name="frontend_form_hidden" value="Y">';	

			$html.= '<div class="option-box" >';	
			$html.= '<p class="option-title" >'.__('Company Title' , 'job-board-manager-company-profile').'</p>';
			$html.= '<p class="option-info"></p>';
			$html.= '<input type="text" class="post_title" name="post_title" value="'.sanitize_text_field($post_title).'" />';
			$html.= '</div>';
			
			$html.= '<div class="option-box" >';
			$html.= '<p class="option-title" >'.__('Company Content' , 'job-board-manager-company-profile').'</p>';
			$html.= '<p class="option-info"></p>';
			//To get wp_editor as variable
			ob_start();
			wp_editor( stripslashes($post_content), 'post_content', $settings = array('textarea_name'=>'post_content','media_buttons'=>false,'wpautop'=>true,'teeny'=>true,'editor_height'=>'150px', ) );				
			$editor_contents = ob_get_clean();
			
			$html.= $editor_contents;

			$html.= '</div>';

			$html_nav = '';
			$html_box = '';
					
			$i=1;
			foreach($meta_options as $key=>$options){
			if($i==1){
				$html_nav.= '<li nav="'.$i.'" class="nav'.$i.' active">'.$key.'</li>';				
				}
			else{
				$html_nav.= '<li nav="'.$i.'" class="nav'.$i.'">'.$key.'</li>';
				}
				
				
			if($i==1){
				$html_box.= '<li style="display: block;" class="box'.$i.' tab-box active">';				
				}
			else{
				$html_box.= '<li style="display: none;" class="box'.$i.' tab-box">';
				}

				
			foreach($options as $option_key=>$option_info){
				
				if(isset($_GET['job_edit_id'])){
					$option_value =  get_post_meta( (int)$_GET['job_edit_id'], $option_key, true );
					}
				else{
					$option_value =  get_post_meta( $post->ID, $option_key, true );
					}
				
				
				//var_dump($option_value);
				
				
				if(empty($option_value)){
					$option_value = $option_info['input_values'];
					}
				
				
				$html_box.= '<div class="option-box '.$option_info['css_class'].'">';
				$html_box.= '<p class="option-title">'.$option_info['title'].'</p>';
				$html_box.= '<p class="option-info">'.$option_info['option_details'].'</p>';
				
				if($option_info['input_type'] == 'text'){
				$html_box.= '<input id="'.$option_key.'" type="text" placeholder="" name="'.$option_key.'" value="'.$option_value.'" /> ';					

					}
				elseif($option_info['input_type'] == 'textarea'){
					$html_box.= '<textarea placeholder="" id="'.$option_key.'" name="'.$option_key.'" >'.$option_value.'</textarea> ';
					
					}
					
				elseif($option_info['input_type'] == 'wp_editor'){
					
					
					ob_start();
					wp_editor( stripslashes($option_value), $option_key, $settings = array('textarea_name'=>$option_key,'media_buttons'=>false,'wpautop'=>true,'teeny'=>true,'editor_height'=>'150px', ) );				
					$editor_contents = ob_get_clean();
					
					$html_box.= $editor_contents;
					
					
					
					}
					
					
					
				elseif($option_info['input_type'] == 'radio'){
					
					$input_args = $option_info['input_args'];
					
					foreach($input_args as $input_args_key=>$input_args_values){
						
						if($input_args_key == $option_value){
							$checked = 'checked';
							}
						else{
							$checked = '';
							}
							
						$html_box.= '<label><input class="'.$option_key.'" type="radio" '.$checked.' value="'.$input_args_key.'" name="'.$option_key.'"   >'.$input_args_values.'</label><br/>';
						}
					
					
					}
					
					
				elseif($option_info['input_type'] == 'select'){
					
					$input_args = $option_info['input_args'];
					$html_box.= '<select name="'.$option_key.'" >';
					foreach($input_args as $input_args_key=>$input_args_values){
						
						if($input_args_key == $option_value){
							$selected = 'selected';
							}
						else{
							$selected = '';
							}
						
						$html_box.= '<option '.$selected.' value="'.$input_args_key.'">'.$input_args_values.'</option>';

						}
					$html_box.= '</select>';
					
					}					
					
					
					
					
					
					
					
					
				elseif($option_info['input_type'] == 'checkbox'){
					
					
					
					
					$input_args = $option_info['input_args'];

					foreach($input_args as $input_args_key=>$input_args_values){

						if ( !empty($option_value) ){
							if(in_array($input_args_key,$option_value)){
							$checked = 'checked';
							}
							else{
								$checked = '';
								}
							$html_box.= '<label><input class="'.$option_key.'" '.$checked.' value="'.$input_args_key.'" name="'.$option_key.'[]"  type="checkbox" >'.$input_args_values.'</label><br/>';
							
						}
						
						
						}
					
					}
					
				elseif($option_info['input_type'] == 'file'){
					
					$html_box.= '<input  type="text" id="file_'.$option_key.'" name="'.$option_key.'" value="'.$option_value.'" />';
					//$html_box.= '<br /><br /><div style="overflow:hidden;max-height:150px;max-width:150px;" class="logo-preview"></div>';
					
					
					$html_box .= '<div id="file-upload-container">';
					//$html_box .= '<span class="loading">loading</span>';	
			
					$html_box .= '<a title="filetype: (jpg, png, jpeg), max size: 200Mb" id="file-uploader" class="button" href="#">'.__('Upload','job-board-manager-company-profile' ).'</a>
					<div id="uploaded-image-container"></div></div>';
					

					}		
					
					
										
					
								
				$html_box.= '</div>';
				
				}
			$html_box.= '</li>';
			
			
			$i++;
			}
			
			
			$html.= '<ul class="tab-nav">';
			$html.= $html_nav;			
			$html.= '</ul>';
			$html.= '<ul class="box">';
			$html.= $html_box;
			$html.= '</ul>';
					
			$html.= apply_filters( 'frontend_forms_html_scripts','');	
			
			
					
		
			if($job_bm_reCAPTCHA_enable=='yes'){
				
				$html.= '<div class="option-box" >';	
				$html.= '<p class="option-title" >reCAPTCHA</p>';	
				$html.= '<p class="option-info"></p>';
				$html.= '<script src="https://www.google.com/recaptcha/api.js"></script>';	
				$html.= '<div class="g-recaptcha" data-sitekey="'.$job_bm_reCAPTCHA_site_key.'"></div>';	
				$html.= '</div>';
				
				}
			else{
				
				$html.= '<input type="hidden" name="g-recaptcha-response" value="yes" />';
				
				}
			

			
			
			
			
			
			
			$html.= '<input class="button job-bm-submit" type="submit" value="'.__('Submit', 'job-board-manager-company-profile' ).'" />';
			

			$html.= '</form>';
			$html.= '</div>';
			
			$html.= '
			
        <script>
		jQuery(document).ready(function($)
			{
				var job_bm_salary_type = $(".job_bm_salary_type:checked").val();
				
				if(job_bm_salary_type =="fixed"){
					
					$(".option-box.salary_fixed").fadeIn();
					}
				else if(job_bm_salary_type =="min-max"){
					
					
					$(".option-box.salary_min").fadeIn();
					$(".option-box.salary_max").fadeIn();					
					}
				
			})
		</script>
			
			
			';			
			
			
			
			
			
			
			
					
			
			return $html;
		}
	
	}
	
new class_frontend_forms_company();