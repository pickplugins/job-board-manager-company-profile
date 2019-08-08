<?php
/*
* @Author 		ParaTheme
* Copyright: 	2015 ParaTheme
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

		get_header();

		do_action('job_bm_action_before_company_single');

		while ( have_posts() ) : the_post(); 
		?>
        <div itemscope itemtype="http://schema.org/Organization" id="company-single-<?php the_ID(); ?>" <?php post_class('company-single entry-content'); ?>>
        <?php
			do_action('job_bm_action_company_single_main');
		?>
        </div>
		<?php
		endwhile;
        do_action('job_bm_action_after_company_single');
        //do_action('job_bm_action_after_company_related');

		get_footer();
		
