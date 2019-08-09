<?php
/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

	//$job_bm_field_editor = get_option( 'job_bm_field_editor' );
	//$job_bm_job_edit_page_id = get_option('job_bm_job_edit_page_id');
	//$edit_page_url = get_permalink($job_bm_job_edit_page_id);
	
	$job_bm_account_required_post_job = get_option('job_bm_account_required_post_job');
	$job_bm_reCAPTCHA_enable = get_option('job_bm_reCAPTCHA_enable');	
	$job_bm_job_login_page_id = get_option('job_bm_job_login_page_id');
	$login_page_url = get_permalink($job_bm_job_login_page_id);

	if ( is_user_logged_in() ) 
		{
			$userid = get_current_user_id();
		}
	else{
			$userid = 0;
			
			if( $job_bm_account_required_post_job=='yes'){
				
				echo sprintf(__('Please <a href="%s">login</a> to submit job.', 'job-board-manager-company-profile'), $login_page_url) ;
				return;
				}
			
		}






	$class_pickform = new class_pickform();
	


		
	$class_job_bm_cp_functions = new class_job_bm_cp_functions();
	$comapny_input_fields = $class_job_bm_cp_functions->comapny_input_fields();
		
	//echo '<pre>'.var_export($comapny_input_fields, true).'</pre>';
	
	$job_title = $comapny_input_fields['post_title'];	
	$job_content = $comapny_input_fields['post_content'];
	$post_thumbnail = $comapny_input_fields['post_thumbnail'];
	$recaptcha = $comapny_input_fields['recaptcha'];		
	
	$post_taxonomies = $comapny_input_fields['post_taxonomies'];
	$company_category = $post_taxonomies['company_category'];
	
	
			
	
/*

	if(!empty($job_bm_field_editor)){
		
		$meta_fields = $job_bm_field_editor;
		}
	else{
		$meta_fields = $comapny_input_fields['meta_fields'];
		}

*/
		
		
	$meta_fields = $comapny_input_fields['meta_fields'];
	
	//var_dump($comapny_input_fields['company_info']['meta_fields']);		
	
	//echo '<pre>'.var_export($meta_fields, true).'</pre>';

	//echo '<pre>'.var_export($_POST, true).'</pre>';
?>
			

					

        

	<div class="comany-submit job-submit pickform">
    	<div class="validations">
        
		<?php



		if(isset($_POST['post_job_hidden'])){
			
			
			$validations = array();
			
			
			if(empty($_POST['post_title'])){
				
				 $validations['post_title'] = '';
				 echo '<div class="failed"><b><i class="fa fa-exclamation-circle" aria-hidden="true"></i> '.$job_title['title'].'</b> '.__('missing', 'job-board-manager-company-profile').'.</div>';
				}
			
			if(empty($_POST['post_content'])){
				
				 $validations['post_content'] = '';
				 echo '<div class="failed"><b><i class="fa fa-exclamation-circle" aria-hidden="true"></i> '.$job_content['title'].'</b> '.__('missing', 'job-board-manager-company-profile').'.</div>';
				}

			if(empty($_POST['post_thumbnail'])){

				$validations['post_thumbnail'] = '';
				echo '<div class="failed"><b><i class="fa fa-exclamation-circle" aria-hidden="true"></i> '.$post_thumbnail['title'].'</b> '.__('missing', 'job-board-manager-company-profile').'.</div>';
			}


			
			if($job_bm_reCAPTCHA_enable=='yes'){
				if(empty($_POST['g-recaptcha-response'])){
					
					 $validations['recaptcha'] = '';
					 echo '<div class="failed"><b><i class="fa fa-exclamation-circle" aria-hidden="true"></i> '.$recaptcha['title'].'</b> '.__('missing', 'job-board-manager-company-profile').'.</div>';
					}
				
				}
			
			
			
			
			
			
			if(empty($_POST['company_category'])){
				
				 $validations['company_category'] = '';
				 echo '<div class="failed"><b><i class="fa fa-exclamation-circle" aria-hidden="true"></i> '.$company_category['title'].'</b> '.__('missing', 'job-board-manager-company-profile').'.</div>';
				}				
			
			
			
		
			foreach($meta_fields as $fields){
				
				$fields = $fields['meta_fields'];
				
				foreach($fields as $key=>$field_data){
					
					$meta_key = $field_data['meta_key'];
					$meta_title = $field_data['title'];	
									
					if(isset($_POST[$meta_key]))
					 $valid = $class_pickform->validations($field_data, $_POST[$meta_key]);
					 
					 if(!empty( $valid)){
						 $validations[$meta_key] = $valid;
						 echo '<div class="failed"><b><i class="fa fa-exclamation-circle" aria-hidden="true"></i> '.$meta_title.'</b> '.$valid.'.</div>';
						 
						 }					 
					}
			}
			
			if(empty($validations)){
				
				$job_bm_submitted_job_status = get_option('job_bm_submitted_job_status');
				
				// all data is filled.
				$job_title_val = $class_pickform->sanitizations($_POST['post_title'], 'text');
				$job_content_val = $class_pickform->sanitizations($_POST['post_content'], 'wp_editor');
				$job_thumbnail_val = $class_pickform->sanitizations($_POST['post_thumbnail'], 'file');
				$company_category_val = $class_pickform->sanitizations($_POST['company_category'], 'select_multi');	
				
				$job_post = array(
				  'post_title'    => $job_title_val,
				  'post_content'  => $job_content_val,
				  'post_status'   => $job_bm_submitted_job_status,
				  'post_type'   => 'company',
				  'post_author'   => $userid,
				);
				
				// Insert the post into the database
				//wp_insert_post( $my_post );

				//echo '<pre>'.var_export($job_thumbnail_val, true).'</pre>';


				$job_ID = wp_insert_post($job_post);

				$post_thumbnail_id = $job_thumbnail_val[0];
				update_post_meta( $job_ID, '_thumbnail_id', $post_thumbnail_id );


				echo '<div class="success"><i class="fa fa-check"></i> '.__('Company Submitted successfully.', 'job-board-manager-company-profile').'</div>';
				
				
				$taxonomy = 'company_category';
				
				wp_set_post_terms( $job_ID, $company_category_val, $taxonomy );

					foreach($meta_fields as $group_key=>$group_data){
						
						$group_meta_fields = $group_data['meta_fields'];
						
						foreach($group_meta_fields as $key=>$field_data){
							$meta_key = $field_data['meta_key'];						
							$input_type = $field_data['input_type'];
							
							if(is_array( $_POST[$meta_key])){
								$meta_value = $class_pickform->sanitizations($_POST[$meta_key], $input_type);
								
								$meta_value = serialize($meta_value);
								}
							else{
								$meta_value = $class_pickform->sanitizations($_POST[$meta_key], $input_type);
								}
							
							
							update_post_meta($job_ID, $meta_key , $meta_value);
							
							//var_dump($field_data_new);
							}
					}
				
				?>
                <script>
				jQuery(document).ready(function($)
					{
	
						//window.location.href = "<?php echo get_preview_post_link($job_ID); ?>";
					})
				
				
				</script>
                <?php
				
				
				
				
				
				}
			else{
				
				$job_title = array_merge($job_title, array('input_values'=>$class_pickform->sanitizations($_POST['post_title'], 'text')));
				$job_content = array_merge($job_content, array('input_values'=>$class_pickform->sanitizations($_POST['post_content'], 'wp_editor')));

				if(!empty($_POST['post_thumbnail'])){

					$post_thumbnail = array_merge($post_thumbnail, array('input_values'=>$class_pickform->sanitizations($_POST['post_thumbnail'], 'file')));
				}




				if(isset($_POST['company_category']))
				$company_category = array_merge($company_category, array('input_values'=>$class_pickform->sanitizations($_POST['company_category'], 'select_multi')));


				//var_dump($job_title);
				//var_dump($job_content);				
				//var_dump($company_category);					
				
					foreach($meta_fields as $group_key=>$group_data){
						
						$group_title = $group_data['title'];
						$group_details = $group_data['details'];						
						$group_meta_fields = $group_data['meta_fields'];						
						
						//$fields = $fields['meta_fields'];
						$meta_fields_new[$group_key]['title'] = $group_title;
						$meta_fields_new[$group_key]['details'] = $group_details;						
						
						foreach($group_meta_fields as $key=>$field_data){
							$meta_key = $field_data['meta_key'];
							$input_type = $field_data['input_type'];							
							
							if(!empty($_POST[$meta_key])){
								$meta_value = $class_pickform->sanitizations($_POST[$meta_key], $input_type);
								}
							else{
								$meta_value = '';
								}
							
							$meta_fields_new[$group_key]['meta_fields'][$key] =  array_merge($field_data, array('input_values'=>$meta_value));	
							
							//var_dump($field_data_new);
							}
					}
				
				//var_dump($field_data_new);
				//echo '<pre>'.var_export($meta_fields_new, true).'</pre>';
				
				if(!empty($meta_fields_new)){
					
					$meta_fields = $meta_fields_new;
					
					}
				
				
				}
				
			
			
			}
		
		
		

		
		
		?>
        
        
        </div>
    <?php

	do_action('job_bm_action_before_comapny_submit');

	?>
    
    
    



        
		
            <form enctype="multipart/form-data"   method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
            <input type="hidden" name="post_job_hidden" value="Y">
        
        <?php
		
			//var_dump($job_title);
		
			do_action('job_bm_action_comapny_submit_main');
			
			echo '<div class="option">';
			echo $class_pickform->field_set($job_title);
			
			echo '</div>';
			
			
			
			echo '<div class="option">';
			echo $class_pickform->field_set($job_content);
			
			echo '</div>';	


			
			echo '<div class="option">';
			echo $class_pickform->field_set($company_category);

			echo '</div>';






			echo '<div class="option">';
			echo $class_pickform->field_set($post_thumbnail);

			echo '</div>';












		?>
            <div class="meta-fields">
            
            <?php
            
			//echo '<pre>'.var_export($meta_fields, true).'</pre>';
			
			//var_dump($meta_fields);
			foreach($meta_fields as $fields){
				
				echo '<div class="steps-title">'.$fields['title'].'</div>';
				
				echo '<div class="steps-body">';
				
				$fields = $fields['meta_fields'];
				
				foreach($fields as $key=>$field_data){
					//var_dump($field_data);
				?>
				<div class="option">

					
                    <?php
					if(!empty($field_data['display'])){
						$display = $field_data['display'];
						}
					else{
						$display = 'yes';
						}
					
					
					
					if($display=='yes')
                    echo $class_pickform->field_set($field_data);
					?>

				</div>
				<?php
					
					}

				echo '</div>';
				}
			
			?>
            
            
            </div>


        
		   <script>
           
    
        jQuery(".meta-fields").steps({
            headerTag: ".steps-title",
            bodyTag: ".steps-body",
            transitionEffect: "slide",
            onFinished: function (event, currentIndex){
                jQuery('.job-submit-button').fadeIn();
            },
			labels: {
				cancel: "<?php echo __('Cancel', 'job-board-manager-company-profile'); ?>",
				current: "<?php echo __('current step:', 'job-board-manager-company-profile'); ?>",
				pagination: "<?php echo __('Pagination', 'job-board-manager-company-profile'); ?>",
				finish: "<?php echo __('Finish', 'job-board-manager-company-profile'); ?>",
				next: "<?php echo __('Next', 'job-board-manager-company-profile'); ?>",
				previous: "<?php echo __('Previous', 'job-board-manager-company-profile'); ?>",
				loading: "<?php echo __('Loading ...', 'job-board-manager-company-profile'); ?>"
			}
            
            
        });
    
    
           </script>
        


            <div class="job-submit-button">
            
            <?php		
                
                if($job_bm_reCAPTCHA_enable=='yes'){
					
					echo '<div class="option">';
					echo $class_pickform->field_set($recaptcha);
					echo '</div>';
					
					}

                
                
                
                
                
                
                
                
                wp_nonce_field( 'job_bm' );
            ?>
                
    
                <input type="submit"  name="submit" value="<?php _e('Submit', 'job-board-manager-company-profile'); ?>" />
    
            </div>


            </form>
        
        
        <?php
        
		do_action('job_bm_action_after_comapny_submit');
		
		?>
        
    </div>
        


        

		
		
