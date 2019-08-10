<?php
/*
Plugin Name: Job Board Manager - Company Profile
Plugin URI: http://pickplugins.com
Description: Awesome Company Profile for Job Board Manager.
Version: 2.0.10
Author: pickplugins
Author URI: http://pickplugins.com
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 


class JobBoardManagerCompanyProfile{
	
	public function __construct(){
	
	define('job_bm_cp_plugin_url', plugins_url('/', __FILE__)  );
	define('job_bm_cp_plugin_dir', plugin_dir_path( __FILE__ ) );
	define('job_bm_cp_plugin_name', 'Job Board Manager - Company Profile' );
	define('job_bm_cp_plugin_version', '2.0.10' );


	// Class
	require_once( job_bm_cp_plugin_dir . 'includes/class-post-types.php');
	require_once( job_bm_cp_plugin_dir . 'includes/class-post-meta.php');
	require_once( job_bm_cp_plugin_dir . 'includes/class-shortcodes.php');
	require_once( job_bm_cp_plugin_dir . 'includes/class-functions.php');
	//require_once( job_bm_cp_plugin_dir . 'includes/class-settings.php');
    //require_once( job_bm_cp_plugin_dir . 'includes/class-upgrade.php');


    require_once( job_bm_cp_plugin_dir . 'includes/class-post-meta-company.php');
    require_once( job_bm_cp_plugin_dir . 'includes/class-post-meta-company-hook.php');




    //require_once( plugin_dir_path( __FILE__ ) . 'includes/shortcodes/class-shortcodes-my-companies.php');



	
	//require_once( plugin_dir_path( __FILE__ ) . 'includes/class-frontend-form-edit-company.php');		
	//require_once( plugin_dir_path( __FILE__ ) . 'includes/class-frontend-forms-input-company.php');		

	// Function's
	require_once( plugin_dir_path( __FILE__ ) . 'includes/functions.php');
	require_once( plugin_dir_path( __FILE__ ) . 'templates/company-single/company-single-template-functions.php');

	require_once( plugin_dir_path( __FILE__ ) . 'includes/functions-dashboard.php');
    require_once( plugin_dir_path( __FILE__ ) . 'includes/functions-settings.php');



	add_action( 'admin_enqueue_scripts', 'wp_enqueue_media' );
	add_action( 'wp_enqueue_scripts', array( $this, 'job_bm_cp_front_scripts' ) );
	add_action( 'admin_enqueue_scripts', array( $this, 'job_bm_cp_admin_scripts' ) );
	
	register_activation_hook(__FILE__, array( $this, 'job_bm_cp_install' ));
	
	add_action( 'plugins_loaded', array( $this, 'load_textdomain' ));
	
	
	}
	
	
	public function load_textdomain() {
        $locale = apply_filters( 'plugin_locale', get_locale(), 'job-board-manager-company-profile' );
        load_textdomain('job-board-manager-company-profile', WP_LANG_DIR .'/job-board-manager-company-profile/job-board-manager-company-profile-'. $locale .'.mo' );

        load_plugin_textdomain( 'job-board-manager-company-profile', false, plugin_basename( dirname( __FILE__ ) ) . '/languages/' );
	}
	
	
	
	
	public function job_bm_cp_install(){
		
		
		global $wpdb;
		
        $sql = "CREATE TABLE IF NOT EXISTS " . $wpdb->prefix . "job_bm_cp_follow"
                 ."( UNIQUE KEY id (id),
					id int(100) NOT NULL AUTO_INCREMENT,
					company_id	INT( 255 )	NOT NULL,
					follower_id	INT( 255 ) NOT NULL,
					follow	VARCHAR( 255 ) NOT NULL					
					)";
		$wpdb->query($sql);
		
		
		// Reset permalink
		$class_job_bm_cp_post_types= new class_job_bm_cp_post_types();
		$class_job_bm_cp_post_types->register_posttype_company();
		flush_rewrite_rules();
		
		
		do_action( 'job_bm_cp_action_install' );
		}		
		
	public function job_bm_cp_uninstall(){
		
		do_action( 'job_bm_cp_action_uninstall' );
		}		
		
	public function job_bm_cp_deactivation(){
		
		do_action( 'job_bm_cp_action_deactivation' );
		}
		
	public function job_bm_cp_front_scripts(){
		
		wp_enqueue_script('jquery');
		
		wp_enqueue_script('job_bm_cp_js', plugins_url( 'assets/front/js/scripts.js' , __FILE__ ) , array( 'jquery' ));
		wp_localize_script( 'job_bm_cp_js', 'job_bm_cp_ajax', array( 'job_bm_cp_ajaxurl' => admin_url( 'admin-ajax.php')));

		wp_enqueue_script('jquery.quote_rotator', plugins_url( 'assets/front/js/jquery.quote_rotator.js' , __FILE__ ) , array( 'jquery' ));


		wp_enqueue_style('job_bm_cp_company-list', job_bm_cp_plugin_url.'assets/global/css/company-list-ajax.css');
		wp_enqueue_style('job_bm_cp_style', job_bm_cp_plugin_url.'assets/front/css/style.css');		
		
		wp_enqueue_style('job_bm_cp_company_single', job_bm_cp_plugin_url.'assets/front/css/company-single.css');
        wp_enqueue_style('my-comany-list', job_bm_cp_plugin_url.'assets/front/css/my-comany-list.css');

        wp_register_style('job-bm-my-companies', job_bm_cp_plugin_url.'assets/front/css/my-companies.css');
        wp_register_script('job-bm-my-companies', job_bm_cp_plugin_url.'assets/front/js/scripts-my-companies.js');




    }

	public function job_bm_cp_admin_scripts(){
		
		wp_enqueue_script('jquery');	

		wp_enqueue_script('job_bm_cp_admin_js', plugins_url( 'assets/admin/js/scripts.js' , __FILE__ ) , array( 'jquery' ));
		wp_localize_script( 'job_bm_cp_admin_js', 'job_bm_cp_ajax', array( 'job_bm_cp_ajaxurl' => admin_url( 'admin-ajax.php')));
		

		wp_enqueue_style('job_bm_cp_company-list', job_bm_cp_plugin_url.'assets/global/css/company-list-ajax.css');
		wp_enqueue_style('job_bm_cp_style', job_bm_cp_plugin_url.'assets/admin/css/style.css');	
		
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'job_bm_cp_color_picker', plugins_url('/admin/js/color-picker.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
		
		}
	
	
	
	
	}

new JobBoardManagerCompanyProfile();