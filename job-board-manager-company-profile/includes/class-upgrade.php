<?php

/*
* @Author 		ParaTheme
* @Folder	 	job-board-manager/includes
* Copyright: 	2015 ParaTheme
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

class class_job_bm_cp_upgrade{
	
    public function __construct(){


		add_action( 'admin_notices', array( $this, 'notice_upgrade_company_logo' ) );


   		}
		
		

	public function notice_upgrade_company_logo() {

        $job_bm_company_logo_upgrade = get_option('job_bm_company_logo_upgrade', 'no');


        $html= '';

        if( $job_bm_company_logo_upgrade=='no'){


            $admin_url = get_admin_url();

            $html.= '<div class="update-nag">';

            $html.= sprintf(__('Please update company logo data <b> <a href="%sedit.php?post_type=job&page=update-company-logo">Update</a></b>','job-board-manager-company-profile'), $admin_url);


            $html.= '</div>';
        }


        echo $html;



		}
		


		
	
	}
	
new class_job_bm_cp_upgrade();