<?php
/*
* @Author 		ParaTheme
* Copyright: 	2015 ParaTheme
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

	$company_post_data = get_post(get_the_ID());

	echo '<h2 class="job-list-header">'.sprintf(__('Jobs available from - %s', 'job-board-manager-company-profile'), $company_post_data->post_title).'</h2>';
	echo do_shortcode('[job_list display_search="no" company_name="'.$company_post_data->post_title.'"]');	