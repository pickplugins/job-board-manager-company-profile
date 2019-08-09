<?php

/*
* @Author 		ParaTheme
* @Folder	 	job-board-manager/includes
* Copyright: 	2015 ParaTheme
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

class class_job_bm_cp_post_types{
	
	public function __construct(){
		
		add_action( 'init', array( $this, 'register_posttype_company' ), 0 );
		add_action( 'init', array( $this, 'register_company_category' ), 0 );
		
		
		}
	
	public function register_posttype_company(){
		if ( post_type_exists( "company" ) )
		return;

		$singular  = __( 'Company', 'job-board-manager-company-profile' );
		$plural    = __( 'Company', 'job-board-manager-company-profile' );
	 
	 
		register_post_type( "company",
			apply_filters( "register_post_type_company", array(
				'labels' => array(
					'name' 					=> $plural,
					'singular_name' 		=> $singular,
					'menu_name'             => $singular,
					'all_items'             => sprintf( __( 'All %s', 'job-board-manager-company-profile' ), $plural ),
					'add_new' 				=> __( 'Add New', 'job-board-manager-company-profile' ),
					'add_new_item' 			=> sprintf( __( 'Add %s', 'job-board-manager-company-profile' ), $singular ),
					'edit' 					=> __( 'Edit', 'job-board-manager-company-profile' ),
					'edit_item' 			=> sprintf( __( 'Edit %s', 'job-board-manager-company-profile' ), $singular ),
					'new_item' 				=> sprintf( __( 'New %s', 'job-board-manager-company-profile' ), $singular ),
					'view' 					=> sprintf( __( 'View %s', 'job-board-manager-company-profile' ), $singular ),
					'view_item' 			=> sprintf( __( 'View %s', 'job-board-manager-company-profile' ), $singular ),
					'search_items' 			=> sprintf( __( 'Search %s', 'job-board-manager-company-profile' ), $plural ),
					'not_found' 			=> sprintf( __( 'No %s found', 'job-board-manager-company-profile' ), $plural ),
					'not_found_in_trash' 	=> sprintf( __( 'No %s found in trash', 'job-board-manager-company-profile' ), $plural ),
					'parent' 				=> sprintf( __( 'Parent %s', 'job-board-manager-company-profile' ), $singular )
				),
				'description' => sprintf( __( 'This is where you can create and manage %s.', 'job-board-manager-company-profile' ), $plural ),
				'public' 				=> true,
				'show_ui' 				=> true,
				'capability_type' 		=> 'post',
				'map_meta_cap'          => true,
				'publicly_queryable' 	=> true,
				'exclude_from_search' 	=> false,
				'hierarchical' 			=> false,
				'rewrite' 				=> true,
				'query_var' 			=> true,
				'supports' 				=> array('title','editor','thumbnail','custom-fields','author'),
				'show_in_nav_menus' 	=> false,
				'show_in_menu' 	=> 'edit.php?post_type=job',				
				'menu_icon' => 'dashicons-admin-users',
			) )
		); 
	 
	 
		}
	
	
	
	public function register_company_category(){

			$singular  = __( 'Company Category', 'job-board-manager-company-profile' );
			$plural    = __( 'Company Categories', 'job-board-manager-company-profile' );
	 
			register_taxonomy( "company_category",
				apply_filters( 'register_taxonomy_company_category_object_type', array( 'company' ) ),
				apply_filters( 'register_taxonomy_company_category_args', array(
					'hierarchical' 			=> true,
					'show_admin_column' 	=> true,					
					'update_count_callback' => '_update_post_term_count',
					'label' 				=> $plural,
					'labels' => array(
						'name'              => $plural,
						'singular_name'     => $singular,
						'menu_name'         => ucwords( $plural ),
						'search_items'      => sprintf( __( 'Search %s', 'job-board-manager-company-profile' ), $plural ),
						'all_items'         => sprintf( __( 'All %s', 'job-board-manager-company-profile' ), $plural ),
						'parent_item'       => sprintf( __( 'Parent %s', 'job-board-manager-company-profile' ), $singular ),
						'parent_item_colon' => sprintf( __( 'Parent %s:', 'job-board-manager-company-profile' ), $singular ),
						'edit_item'         => sprintf( __( 'Edit %s', 'job-board-manager-company-profile' ), $singular ),
						'update_item'       => sprintf( __( 'Update %s', 'job-board-manager-company-profile' ), $singular ),
						'add_new_item'      => sprintf( __( 'Add New %s', 'job-board-manager-company-profile' ), $singular ),
						'new_item_name'     => sprintf( __( 'New %s Name', 'job-board-manager-company-profile' ),  $singular )
					),
					'show_ui' 				=> true,
					'public' 	     		=> true,
					'rewrite' => array(
						'slug' => 'company_category', // This controls the base slug that will display before each term
						'with_front' => false, // Don't display the category base before "/locations/"
						'hierarchical' => true // This will allow URL's like "/locations/boston/cambridge/"
				),
				) )
			);

		}	
	
	
	
	
	
	
	
	
	}
	
	new class_job_bm_cp_post_types();