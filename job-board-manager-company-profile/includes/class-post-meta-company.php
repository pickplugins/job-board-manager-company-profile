<?php
if ( ! defined('ABSPATH')) exit;  // if direct access

class class_job_bm_post_metabox_company{
	
	public function __construct(){

		//meta box action for "job"
		add_action('add_meta_boxes', array($this, 'job_bm_post_meta_company'));
		add_action('save_post', array($this, 'meta_boxes_company_save'));



		}

	

	
	
	
	public function job_bm_post_meta_company($post_type){

            add_meta_box('metabox-company-data',__('Company data', 'job-board-manager'), array($this, 'meta_box_company_data'), 'company', 'normal', 'high');

		}






	public function meta_box_company_data($post) {
 
        // Add an nonce field so we can check for it later.
        wp_nonce_field('company_nonce_check', 'company_nonce_check_value');
 
        // Use get_post_meta to retrieve an existing value from the database.
       // $job_bm_data = get_post_meta($post -> ID, 'job_bm_data', true);

        $post_id = $post->ID;


        $settings_tabs_field = new settings_tabs_field();

        $job_bm_settings_tab = array();

        $job_bm_settings_tab[] = array(
            'id' => 'company_info',
            'title' => sprintf(__('%s Company info','job-board-manager'),'<i class="far fa-building"></i>'),
            'priority' => 1,
            'active' => true,
        );

        if(current_user_can('manage_options')):
            $job_bm_settings_tab[] = array(
                'id' => 'admin',
                'title' => sprintf(__('%s Admin action','job-board-manager'),'<i class="fas fa-tools"></i>'),
                'priority' => 3,
                'active' => false,
            );
        endif;






        $job_bm_settings_tab = apply_filters('job_bm_metabox_company_navs', $job_bm_settings_tab);

        $tabs_sorted = array();
        foreach ($job_bm_settings_tab as $page_key => $tab) $tabs_sorted[$page_key] = isset( $tab['priority'] ) ? $tab['priority'] : 0;
        array_multisort($tabs_sorted, SORT_ASC, $job_bm_settings_tab);

		?>


        <div class="settings-tabs vertical">
            <ul class="tab-navs">
                <?php
                foreach ($job_bm_settings_tab as $tab){
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
            <?php
            foreach ($job_bm_settings_tab as $tab){
                $id = $tab['id'];
                $title = $tab['title'];
                $active = $tab['active'];
                ?>

                <div class="tab-content <?php if($active) echo 'active';?>" id="<?php echo $id; ?>">
                    <?php
                    do_action('job_bm_metabox_company_content_'.$id, $post_id);
                    ?>
                </div>
                <?php
            }
            ?>
        </div>
        <div class="clear clearfix"></div>

        <?php

        wp_enqueue_script( 'settings-tabs' );
        wp_enqueue_style( 'settings-tabs' );



   		}




	public function meta_boxes_company_save($post_id){

        /*
         * We need to verify this came from the our screen and with
         * proper authorization,
         * because save_post can be triggered at other times.
         */

        // Check if our nonce is set.
        if (!isset($_POST['company_nonce_check_value']))
            return $post_id;

        $nonce = $_POST['company_nonce_check_value'];

        // Verify that the nonce is valid.
        if (!wp_verify_nonce($nonce, 'company_nonce_check'))
            return $post_id;

        // If this is an autosave, our form has not been submitted,
        //     so we don't want to do anything.
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
            return $post_id;

        // Check the user's permissions.
        if ('page' == $_POST['post_type']) {

            if (!current_user_can('edit_page', $post_id))
                return $post_id;

        } else {

            if (!current_user_can('edit_post', $post_id))
                return $post_id;
        }

        /* OK, its safe for us to save the data now. */

        // Sanitize the user input.

        // Update the meta field.

        do_action('job_bm_metabox_save_company', $post_id);


					
		}
	
	}


new class_job_bm_post_metabox_company();