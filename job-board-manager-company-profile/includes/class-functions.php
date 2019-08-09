<?php

/*
* @Author 		ParaTheme
* Copyright: 	2015 ParaTheme
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

class class_job_bm_cp_functions{
	





	public function comapny_input_fields(){
		
		$job_bm_cp_country_list = $this->job_bm_cp_country_list();
		
		$input_fields['post_title'] = array(
														'meta_key'=>'post_title',
														'css_class'=>'post_title',
														'required'=>'yes', // (yes, no) is this field required.
														'placeholder'=>__('Write company title here', 'job-board-manager-company-profile'),
														'title'=>__('Company Title', 'job-board-manager-company-profile'),
														'option_details'=>__('Company title here', 'job-board-manager-company-profile'),
														'input_type'=>'text', // text, radio, checkbox, select,
														'input_values'=>'', // could be array
														//'field_args'=> array('size'=>'',),
														);
														
														
		$input_fields['post_content'] = array(
														'meta_key'=>'post_content',
														'css_class'=>'post_content',
														'required'=>'yes', // (yes, no) is this field required.
														//'placeholder'=>'',
														'title'=>__('Company Descriptions', 'job-board-manager-company-profile'),
														'option_details'=>__('Write company descriptions here', 'job-board-manager-company-profile'),
														'input_type'=>'wp_editor', // text, radio, checkbox, select,
														'input_values'=>'', // could be array
														//'field_args'=> array('size'=>'',),
														);													
														
														
		
		
		$input_fields['post_thumbnail'] = array(
														'meta_key'=>'post_thumbnail',
														'css_class'=>'post_thumbnail',
														'required'=>'no', // (yes, no) is this field required.
														//'placeholder'=>'thumbnail',
														'title'=>__('Company featured image', 'job-board-manager-company-profile'),
														'option_details'=>__('Job featured image, upload single image only.', 'job-board-manager-company-profile'),
														'input_type'=>'file', // text, radio, checkbox, select,
														'input_values'=>'', // could be array
														//'field_args'=> array('size'=>'',),
														);	
		
		
		
		
		$input_fields['post_taxonomies'] =	array(	
								
														'company_category'=>array(
															'meta_key'=>'company_category',
															'css_class'=>'company_category',
															'required'=>'no', // (yes, no) is this field required.
															'display'=>'yes', // (yes, no)															
															//'placeholder'=>'job_category',
															'title'=>__('Company Category', 'job-board-manager-company-profile'),
															'option_details'=>__('Select company category.', 'job-board-manager-company-profile'),
															'input_type'=>'select', // text, radio, checkbox, select,
															'input_values'=>array(''), // could be array
															'input_args'=> job_bm_get_terms('company_category'), // job_bm_get_terms('ads_cat')
															
															),
								
/*

														array(
															'meta_key'=>'ads_tag',
															'css_class'=>'ads_tag',
															'placeholder'=>'ads_tag',
															'title'=>__('Job tags', 'job-board-manager-company-profile'),
															'option_details'=>__('Choose Job Tags, you can select multiple.', 'job-board-manager-company-profile'),
															'input_type'=>'select_multi', // text, radio, checkbox, select,
															'input_values'=>array(''), // could be array
															'input_args'=> job_bm_get_terms('ads_tag'),
															//'field_args'=> array('size'=>'',),
															),

*/								

														);
		
		
		$input_fields['recaptcha'] = array(
														'meta_key'=>'recaptcha',
														'css_class'=>'recaptcha',
														'required'=>'yes', // (yes, no) is this field required.
														'display'=>'yes', // (yes, no)
														//'placeholder'=>'',
														'title'=>__('reCaptcha', 'job-board-manager-company-profile'),
														'option_details'=>__('reCaptcha test.', 'job-board-manager-company-profile'),
														'input_type'=>'recaptcha', // text, radio, checkbox, select,
														'input_values'=>get_option('job_bm_reCAPTCHA_site_key'), // could be array
														//'field_args'=> array('size'=>'',),
														);
														
															
		
		
		$input_fields['meta_fields'] =	array(
										
										'company_info'=>array(
										
												'title'=>__('Company Info','job-board-manager-company-profile'),
												'details'=>__('Company Information details','job-board-manager-company-profile'),
												'meta_fields'=> array(
												
																	'job_bm_cp_tagline'=>array(
																		'meta_key'=>'job_bm_cp_tagline',
																		'css_class'=>'tagline',
																		//'placeholder'=>__('Write Company Name Here.','job-board-manager-company-profile'),
																		'required'=>'yes', // (yes, no) is this field required.
																		'display'=>'yes', // (yes, no)
																		'title'=>__('Company Tagline', 'job-board-manager-company-profile'),
																		'option_details'=>__('Company tagline here', 'job-board-manager-company-profile'),
																		'input_type'=>'text', // text, radio, checkbox, select, 
																		'input_values'=>'', // could be array
																		),
																			
																	'job_bm_cp_mission'=>array(
																		'meta_key'=>'job_bm_cp_mission',
																		'css_class'=>'display_company_name',	
																		//'placeholder'=>__('','job-board-manager-company-profile'),
																		'required'=>'yes', // (yes, no) is this field required.	
																		'display'=>'yes', // (yes, no)	
																		'title'=>__('Company Mission','job-board-manager-company-profile'),
																		'option_details'=>__('Company mission details here','job-board-manager-company-profile'),
																		'input_type'=>'textarea', // text, radio, checkbox, select, 
																		'input_values'=> '', // could be array
																		),
												
												
												
																	'job_bm_cp_country'=>array(
																		'meta_key'=>'job_bm_cp_country',
																		'css_class'=>'location',		
																		//'placeholder'=>__('','job-board-manager-company-profile'),
																		'required'=>'yes', // (yes, no) is this field required.		
																		'title'=>__('Country','job-board-manager-company-profile'),
																		'display'=>'yes', // (yes, no)
																		'option_details'=>__('Country, ex: Bangladesh','job-board-manager-company-profile'),
																		'input_type'=>'select', // text, radio, checkbox, select, 
																		'input_values'=>'', // could be array
																		'input_args'=> $job_bm_cp_country_list,
																		),
																		
																	'job_bm_cp_city'=>array(
																		'meta_key'=>'job_bm_cp_city',
																		'css_class'=>'city',		
																		//'placeholder'=>__('','job-board-manager-company-profile'),
																		'required'=>'yes', // (yes, no) is this field required.		
																		'display'=>'yes', // (yes, no)
																		'title'=>__('City','job-board-manager-company-profile'),
																		'option_details'=>__('Company City, ex: Dhaka','job-board-manager-company-profile'),
																		'input_type'=>'text', // text, radio, checkbox, select, 
																		'input_values'=>'', // could be array
																		),									
																		
																	'job_bm_cp_hq_address'=>array(
																		'meta_key'=>'job_bm_cp_hq_address',
																		'css_class'=>'hq_address',	
																		//'placeholder'=>__('','job-board-manager-company-profile'),
																		'required'=>'no', // (yes, no) is this field required.	
																		'display'=>'yes', // (yes, no)		
																		'title'=>__('Headquarter Address','job-board-manager-company-profile'),
																		'option_details'=>__('Headquarter address here','job-board-manager-company-profile'),
																		'input_type'=>'textarea', // text, radio, checkbox, select, 
																		'input_values'=> '', // could be array
																		
																		),
									
																							
																	'job_bm_cp_address'=>array(
																		'meta_key'=>'job_bm_cp_address',
																		'css_class'=>'address',	
																		//'placeholder'=>__('','job-board-manager-company-profile'),
																		'required'=>'no', // (yes, no) is this field required.	
																		'display'=>'yes', // (yes, no)		
																		'title'=>__('Address','job-board-manager-company-profile'),
																		'option_details'=>__('Full Address, ex: House No: 254, Road: 5, Mirpur-12, Dhaka','job-board-manager-company-profile'),
																		'input_type'=>'textarea', // text, radio, checkbox, select, 
																		'input_values'=>'', // could be array
																		),

																	'job_bm_cp_logo'=>array(
																		'meta_key'=>'job_bm_cp_logo',
																		'css_class'=>'company_logo',	
																		//'placeholder'=>__('','job-board-manager-company-profile'),
																		'required'=>'no', // (yes, no) is this field required.	
																		'display'=>'yes', // (yes, no)		
																		'title'=>__('Company Logo','job-board-manager-company-profile'),
																		'option_details'=>__('Add company logo. upload single image only.','job-board-manager-company-profile'),
																		'input_type'=>'file', // text, radio, checkbox, select,
																		'input_values'=>job_bm_plugin_url.'assets/admin/images/demo-logo.png', // could be array
																		),

																	),
										
												),
		
		
										'more_info'=>array(
										
												'title'=>__('More Info','job-board-manager-company-profile'),
												'details'=>__('More Information details.','job-board-manager-company-profile'),
												'meta_fields'=> array(
												
																	'job_bm_cp_website'=>array(
																		'meta_key'=>'job_bm_cp_website',
																		'css_class'=>'website',		
																		'required'=>'yes', // (yes, no) is this field required.		
																		'display'=>'yes', // (yes, no)	
																		'title'=>__('Website','job-board-manager-company-profile'),
																		'option_details'=>__('Company Website URL.','job-board-manager-company-profile'),
																		'input_type'=>'text', // text, radio, checkbox, select, 
																		'input_values'=> '', // could be array
																		),		
												
																	'job_bm_cp_founded'=>array(
																		'meta_key'=>'job_bm_cp_founded',
																		'css_class'=>'job_bm_cp_founded',		
																		'required'=>'no', // (yes, no) is this field required.	
																		'display'=>'yes', // (yes, no)		
																		'title'=>__('Founded','job-board-manager-company-profile'),
																		'option_details'=>__('Company founded year.','job-board-manager-company-profile'),
																		'input_type'=>'text', // text, radio, checkbox, select, 
																		'input_values'=>'', // could be array
																		),
																		
																	'job_bm_cp_revenue'=>array(
																		'meta_key'=>'job_bm_cp_revenue',
																		'css_class'=>'revenue',
																		'required'=>'no', // (yes, no) is this field required.
																		'display'=>'yes', // (yes, no)
																		'title'=>__('Yearly Revenue','job-board-manager-company-profile'),
																		'option_details'=>__('Yearly Revenue ($).','job-board-manager-company-profile'),
																		'input_type'=>'text', // text, radio, checkbox, select, 
																		'input_values'=>'', // could be array
																		),
																		
																	'job_bm_cp_size'=>array(
																		'meta_key'=>'job_bm_cp_size',
																		'css_class'=>'job_bm_cp_size',	
																		'required'=>'no', // (yes, no) is this field required.
																		'display'=>'yes', // (yes, no)			
																		'title'=>__('Total Emplyee','job-board-manager-company-profile'),
																		'option_details'=>__('Total Emplyee Size.','job-board-manager-company-profile'),
																		'input_type'=>'text', // text, radio, checkbox, select, 
																		'input_values'=>'', // could be array
																		),
																		
/*

																	'job_bm_cp_type'=>array(
																		'meta_key'=>'job_bm_cp_type',
																		'css_class'=>'job_bm_cp_type',		
																		'required'=>'no', // (yes, no) is this field required.
																		'display'=>'yes', // (yes, no)		
																		'title'=>__('Company Type','job-board-manager-company-profile'),
																		'option_details'=>__('What kind of company.','job-board-manager-company-profile'),
																		'input_type'=>'wp_editor', // text, radio, checkbox, select, 
																		'input_values'=>'', // could be array
																		),

*/	
																																	
																	
																	
																	
																	)
															),
		
		
		
		
											);


		
			$input_fields_all = apply_filters( 'job_bm_cp_filters_input_fields', $input_fields );

			

			return $input_fields_all;
		
		
	}
















	public function job_bm_cp_companylist_themes($themes = array()){

			$themes = array(
							'flat'=>'Flat',			
							);
			
			foreach(apply_filters( 'job_bm_cp_companylist_themes', $themes ) as $theme_key=> $theme_name)
				{
					$theme_list[$theme_key] = $theme_name;
				}

			
			return $theme_list;

		}
	
		
	public function job_bm_cp_companylist_themes_dir($themes_dir = array()){
		
			$main_dir = job_bm_cp_plugin_dir.'themes/companylist/';
			
			$themes_dir = array(
							'flat'=>$main_dir.'flat',
				
							);
			
			foreach(apply_filters( 'job_bm_cp_companylist_themes_dir', $themes_dir ) as $theme_key=> $theme_dir)
				{
					$theme_list_dir[$theme_key] = $theme_dir;
				}

			
			return $theme_list_dir;

		}


	public function job_bm_cp_companylist_themes_url($themes_url = array()){
		
			$main_url = job_bm_cp_plugin_url.'themes/companylist/';
			
			$themes_url = array(
							'flat'=>$main_url.'flat',
				
							);
			
			foreach(apply_filters( 'job_bm_cp_companylist_themes_url', $themes_url ) as $theme_key=> $theme_url)
				{
					$theme_list_url[$theme_key] = $theme_url;
				}

			return $theme_list_url;

		}
		
// #################################################################	
		

	
	public function job_bm_cp_country_list($country_list = array()){

			$country_list = array(
								'AF' => 'Afghanistan',
								'AX' => 'Aland Islands',
								'AL' => 'Albania',
								'DZ' => 'Algeria',
								'AS' => 'American Samoa',
								'AD' => 'Andorra',
								'AO' => 'Angola',
								'AI' => 'Anguilla',
								'AQ' => 'Antarctica',
								'AG' => 'Antigua And Barbuda',
								'AR' => 'Argentina',
								'AM' => 'Armenia',
								'AW' => 'Aruba',
								'AU' => 'Australia',
								'AT' => 'Austria',
								'AZ' => 'Azerbaijan',
								'BS' => 'Bahamas',
								'BH' => 'Bahrain',
								'BD' => 'Bangladesh',
								'BB' => 'Barbados',
								'BY' => 'Belarus',
								'BE' => 'Belgium',
								'BZ' => 'Belize',
								'BJ' => 'Benin',
								'BM' => 'Bermuda',
								'BT' => 'Bhutan',
								'BO' => 'Bolivia',
								'BA' => 'Bosnia And Herzegovina',
								'BW' => 'Botswana',
								'BV' => 'Bouvet Island',
								'BR' => 'Brazil',
								'IO' => 'British Indian Ocean Territory',
								'BN' => 'Brunei Darussalam',
								'BG' => 'Bulgaria',
								'BF' => 'Burkina Faso',
								'BI' => 'Burundi',
								'KH' => 'Cambodia',
								'CM' => 'Cameroon',
								'CA' => 'Canada',
								'CV' => 'Cape Verde',
								'KY' => 'Cayman Islands',
								'CF' => 'Central African Republic',
								'TD' => 'Chad',
								'CL' => 'Chile',
								'CN' => 'China',
								'CX' => 'Christmas Island',
								'CC' => 'Cocos (Keeling) Islands',
								'CO' => 'Colombia',
								'KM' => 'Comoros',
								'CG' => 'Congo',
								'CD' => 'Congo, Democratic Republic',
								'CK' => 'Cook Islands',
								'CR' => 'Costa Rica',
								'CI' => 'Cote D\'Ivoire',
								'HR' => 'Croatia',
								'CU' => 'Cuba',
								'CY' => 'Cyprus',
								'CZ' => 'Czech Republic',
								'DK' => 'Denmark',
								'DJ' => 'Djibouti',
								'DM' => 'Dominica',
								'DO' => 'Dominican Republic',
								'EC' => 'Ecuador',
								'EG' => 'Egypt',
								'SV' => 'El Salvador',
								'GQ' => 'Equatorial Guinea',
								'ER' => 'Eritrea',
								'EE' => 'Estonia',
								'ET' => 'Ethiopia',
								'FK' => 'Falkland Islands (Malvinas)',
								'FO' => 'Faroe Islands',
								'FJ' => 'Fiji',
								'FI' => 'Finland',
								'FR' => 'France',
								'GF' => 'French Guiana',
								'PF' => 'French Polynesia',
								'TF' => 'French Southern Territories',
								'GA' => 'Gabon',
								'GM' => 'Gambia',
								'GE' => 'Georgia',
								'DE' => 'Germany',
								'GH' => 'Ghana',
								'GI' => 'Gibraltar',
								'GR' => 'Greece',
								'GL' => 'Greenland',
								'GD' => 'Grenada',
								'GP' => 'Guadeloupe',
								'GU' => 'Guam',
								'GT' => 'Guatemala',
								'GG' => 'Guernsey',
								'GN' => 'Guinea',
								'GW' => 'Guinea-Bissau',
								'GY' => 'Guyana',
								'HT' => 'Haiti',
								'HM' => 'Heard Island & Mcdonald Islands',
								'VA' => 'Holy See (Vatican City State)',
								'HN' => 'Honduras',
								'HK' => 'Hong Kong',
								'HU' => 'Hungary',
								'IS' => 'Iceland',
								'IN' => 'India',
								'ID' => 'Indonesia',
								'IR' => 'Iran, Islamic Republic Of',
								'IQ' => 'Iraq',
								'IE' => 'Ireland',
								'IM' => 'Isle Of Man',
								'IL' => 'Israel',
								'IT' => 'Italy',
								'JM' => 'Jamaica',
								'JP' => 'Japan',
								'JE' => 'Jersey',
								'JO' => 'Jordan',
								'KZ' => 'Kazakhstan',
								'KE' => 'Kenya',
								'KI' => 'Kiribati',
								'KR' => 'Korea',
								'KW' => 'Kuwait',
								'KG' => 'Kyrgyzstan',
								'LA' => 'Lao People\'s Democratic Republic',
								'LV' => 'Latvia',
								'LB' => 'Lebanon',
								'LS' => 'Lesotho',
								'LR' => 'Liberia',
								'LY' => 'Libyan Arab Jamahiriya',
								'LI' => 'Liechtenstein',
								'LT' => 'Lithuania',
								'LU' => 'Luxembourg',
								'MO' => 'Macao',
								'MK' => 'Macedonia',
								'MG' => 'Madagascar',
								'MW' => 'Malawi',
								'MY' => 'Malaysia',
								'MV' => 'Maldives',
								'ML' => 'Mali',
								'MT' => 'Malta',
								'MH' => 'Marshall Islands',
								'MQ' => 'Martinique',
								'MR' => 'Mauritania',
								'MU' => 'Mauritius',
								'YT' => 'Mayotte',
								'MX' => 'Mexico',
								'FM' => 'Micronesia, Federated States Of',
								'MD' => 'Moldova',
								'MC' => 'Monaco',
								'MN' => 'Mongolia',
								'ME' => 'Montenegro',
								'MS' => 'Montserrat',
								'MA' => 'Morocco',
								'MZ' => 'Mozambique',
								'MM' => 'Myanmar',
								'NA' => 'Namibia',
								'NR' => 'Nauru',
								'NP' => 'Nepal',
								'NL' => 'Netherlands',
								'AN' => 'Netherlands Antilles',
								'NC' => 'New Caledonia',
								'NZ' => 'New Zealand',
								'NI' => 'Nicaragua',
								'NE' => 'Niger',
								'NG' => 'Nigeria',
								'NU' => 'Niue',
								'NF' => 'Norfolk Island',
								'MP' => 'Northern Mariana Islands',
								'NO' => 'Norway',
								'OM' => 'Oman',
								'PK' => 'Pakistan',
								'PW' => 'Palau',
								'PS' => 'Palestinian Territory, Occupied',
								'PA' => 'Panama',
								'PG' => 'Papua New Guinea',
								'PY' => 'Paraguay',
								'PE' => 'Peru',
								'PH' => 'Philippines',
								'PN' => 'Pitcairn',
								'PL' => 'Poland',
								'PT' => 'Portugal',
								'PR' => 'Puerto Rico',
								'QA' => 'Qatar',
								'RE' => 'Reunion',
								'RO' => 'Romania',
								'RU' => 'Russian Federation',
								'RW' => 'Rwanda',
								'BL' => 'Saint Barthelemy',
								'SH' => 'Saint Helena',
								'KN' => 'Saint Kitts And Nevis',
								'LC' => 'Saint Lucia',
								'MF' => 'Saint Martin',
								'PM' => 'Saint Pierre And Miquelon',
								'VC' => 'Saint Vincent And Grenadines',
								'WS' => 'Samoa',
								'SM' => 'San Marino',
								'ST' => 'Sao Tome And Principe',
								'SA' => 'Saudi Arabia',
								'SN' => 'Senegal',
								'RS' => 'Serbia',
								'SC' => 'Seychelles',
								'SL' => 'Sierra Leone',
								'SG' => 'Singapore',
								'SK' => 'Slovakia',
								'SI' => 'Slovenia',
								'SB' => 'Solomon Islands',
								'SO' => 'Somalia',
								'ZA' => 'South Africa',
								'GS' => 'South Georgia And Sandwich Isl.',
								'ES' => 'Spain',
								'LK' => 'Sri Lanka',
								'SD' => 'Sudan',
								'SR' => 'Suriname',
								'SJ' => 'Svalbard And Jan Mayen',
								'SZ' => 'Swaziland',
								'SE' => 'Sweden',
								'CH' => 'Switzerland',
								'SY' => 'Syrian Arab Republic',
								'TW' => 'Taiwan',
								'TJ' => 'Tajikistan',
								'TZ' => 'Tanzania',
								'TH' => 'Thailand',
								'TL' => 'Timor-Leste',
								'TG' => 'Togo',
								'TK' => 'Tokelau',
								'TO' => 'Tonga',
								'TT' => 'Trinidad And Tobago',
								'TN' => 'Tunisia',
								'TR' => 'Turkey',
								'TM' => 'Turkmenistan',
								'TC' => 'Turks And Caicos Islands',
								'TV' => 'Tuvalu',
								'UG' => 'Uganda',
								'UA' => 'Ukraine',
								'AE' => 'United Arab Emirates',
								'GB' => 'United Kingdom',
								'US' => 'United States',
								'UM' => 'United States Outlying Islands',
								'UY' => 'Uruguay',
								'UZ' => 'Uzbekistan',
								'VU' => 'Vanuatu',
								'VE' => 'Venezuela',
								'VN' => 'Viet Nam',
								'VG' => 'Virgin Islands, British',
								'VI' => 'Virgin Islands, U.S.',
								'WF' => 'Wallis And Futuna',
								'EH' => 'Western Sahara',
								'YE' => 'Yemen',
								'ZM' => 'Zambia',
								'ZW' => 'Zimbabwe',
							);
			
			foreach(apply_filters( 'job_bm_cp_filter_country_list', $country_list ) as $country_key=> $country_name)
				{
					$country_list[$country_key] = $country_name;
				}

			
			return $country_list;

		}	
	
		
		

	public function job_bm_cp_company_types(){
	
		$company_types = array(
		'others'=> 'Others',		
		'advertising-ageny'=> 'Advertising Ageny',
		'agro-based-firms'=>	'Agro based firms',	
		'amusement-park'=>	'Amusement Park',
		'architecture-firm'=>	'Architecture Firm',
		'automobile'=>	'Automobile',	
		'airline'=>	'Airline',
		'animal-plant-breeding'=>'Animal/Plant Breeding',
		'audit-firms'=>'Audit Firms /Tax Consultant',
		'banks'=>'Banks',	
		'bakery'=>'Bakery (Cake, Biscuit, Bread)',	
		'bar'=>'Bar/Pub',
		'bicycle'=>'Bicycle',
		'bpo-data-entry-firm'=>'BPO/ Data Entry Firm',	
		'beverage'=>'Beverage',		
		'buying-house'=>'Buying House',		
		'boutique'=>'Boutique/ Fashion',	
		'brick'=>'Brick',		
		'call-center'=>'Call Center',
		'catering'=>'Catering',	
		'cement'=>'Cement',
		'chemical-industries'=>'Chemical Industries',
		'clearing'=>'Clearing & Forwarding (C&F)',	
		'club'=>'Club',		
		'cng-conversion'=>'CNG Conversion',			
		'college'=>'College',
		'consulting-firms'=>'Consulting Firms',	
		'cultural-centre'=>'Cultural Centre',	
		'departmental-store'=>'Departmental store',
		'developer'=>'Developer',	
		'diagnostic-centre'=>'Diagnostic Centre',	
		'dry-cell'=>'Dry cell (Battery)',	
		'dyeing-factory'=>'Dyeing Factory',		
		'electric-wire'=>'Electric Wire/Cable',
		'embassies'=>'Embassies/Foreign Consulate',	
		'elevator'=>'Escalator/Elevator/Lift',	
		'farming'=>'Farming',	
		'filling-station'=>'Filling Station',		
		'financial-consultants'=>'Financial Consultants',
		'fisheries'=>'Fisheries',	
		'food'=>'Food (Packaged)/Beverage',	
		'fuel-petroleum'=>'Fuel/Petroleum',	
		'furniture-manufacturer'=>'Furniture Manufacturer',		
		'garments'=>'Garments',
		'gas'=>'Gas',	
		'govt'=>'Govt./ Semi Govt./ Autonomous body',	
		'group-of-companies'=>'Group of Companies',	
		'handicraft'=>'Handicraft',		
		'healthcare-lifestyle-product'=>'Healthcare/Lifestyle product',
		'hospital'=>'Hospital',	
		'immigration-education-consultancy'=>'Immigration & Education Consultancy ',	
		'importer'=>'Importer',	
		'indenting-firm'=>'Indenting Firm',		
		'insurance'=>'Insurance',	
		'inventory-warehouse'=>'Inventory/Warehouse',	
		'isp'=>'ISP',	
		'jewelry-gem'=>'Jewelry/Gem',		
		'kindergarten'=>'Kindergarten',	
		'land-phone'=>'Land Phone',		
		'law-firm'=>'Law Firm',	
		'leasing'=>'Leasing',	
		'livestock'=>'Livestock',	
		'logistic-courier-air-express'=>'Logistic/Courier/Air Express Companies',	
		'lpg-gas-cylinder-gas'=>'LPG Gas/Cylinder Gas',		
		'madrasa'=>'Madrasa',		
		'manpower-recruitment'=>'Manpower Recruitment',			
		'manufacturing'=>'Manufacturing (FMCG)',
		'market-research'=>'Market Research Firms',	
		'medical-equipment'=>'Medical Equipment',	
		'mineral-water'=>'Mineral Water',		
		'micro-credit'=>'Micro-Credit',		
		'mining'=>'Mining',		
		'mobile-accessories'=>'Mobile Accessories',	
		'museum'=>'Museum',		
		'motel'=>'Motel',	
		'motor-workshop'=>'Motor Workshop',			
		'motor-vehicle-body-manufacturer'=>'Motor Vehicle body manufacturer',		
		'newspaper-magazine'=>'Multinational Companies',		
		'newspaper'=>'Newspaper/Magazine',
		'ngo'=>'NGO',	
		'online-newspaper-portal'=>'Online Newspaper/ News Portal',	
		'overseas-companies'=>'Overseas Companies',		
		'packaging-industry'=>'Packaging Industry',	
		'paint'=>'Paint',		
		'paper'=>'Paper',	
		'park'=>'Park',	
		'party-community-center'=>'Party/ Community Center',	
		'physiotherapy-center'=>'Physiotherapy center',		
		'port-service'=>'Port Service',		
		'pottery'=>'Pottery',	
		'poultry'=>'Poultry',	
		'power'=>'Power',			
		'professional-photographers'=>'Professional Photographers',		
		'pest-control'=>'Pest Control',			
		'pharmaceutical-Medicine-'=>'Pharmaceutical/Medicine Companies',		
		'pstn'=>'PSTN',		
		'public-relation-companies'=>'Public Relation Companies',	
		'radio'=>'Radio',	
		'religious-place'=>'Religious Place',	
		'real-estate'=>'Real Estate',			
		'research-organization'=>'Research Organization',	
		'resort'=>'Resort',			
		'restaurant'=>'Restaurant',		
		'retail-store'=>'Retail Store',		
		'salt'=>'Salt',		
		'sanitary-ware'=>'Sanitary ware',		
		'satellite-tv'=>'Satellite TV',		
		'science-laboratory'=>'Science Laboratory',
		'school'=>'School',		
		'share-brokerage-securities-house'=>'Share Brokerage/ Securities House',	
		'security-service'=>'Security Service',		
		'shipping'=>'Shipping',	
		'shopping-mall'=>'Shopping mall',	
		'shipyard'=>'Shipyard',
		'shrimp'=>'Shrimp',	
		'software-company'=>'Software Company',		
		'spinning'=>'Spinning',	
		'steel'=>'Steel',	
		'sports-complex'=>'Sports Complex',		
		'super-store'=>'Super store',		
		'supply-chain'=>'Supply Chain',	
		'sweater-industry'=>'Sweater Industry',			
		'swimming-pool'=>'Swimming Pool',
		'tailor-shop'=>'Tailor shop',		
		'tannery-footwear'=>'Tannery/Footwear',	
		'textile'=>'Textile',	
		'tea-garden'=>'Tea Garden',		
		'technical-infrastructure'=>'Technical Infrastructure',		
		'Telecommunication'=>'Telecommunication',		
		'travel-agent'=>'Travel Agent',		
		'tiles-ceramic'=>'Tiles/Ceramic',	
		'third-party-auditor'=>'Third Party Auditor',			
		'toiletries'=>'Toiletries',		
		'toy'=>'Toy',
		'tobacco'=>'Tobacco',	
		'tyre-manufacturer'=>'Tyre manufacturer',	
		'training-institutes'=>'Training Institutes',	
		'transportation'=>'Transportation',
		'transport-service'=>'Transport Service',
		'trading-export-import'=>'Trading or Export/Import',
		'tour-operator'=>'Tour Operator',	
		'venture-capital-firm'=>'Venture Capital Firm',
		'university'=>'University',		
		'watch'=>'Watch',		
		'wholesale'=>'Wholesale',
		'web-media-Blog'=>'Web Media/Blog',	
		'washing-factory'=>'Washing Factory',
		
		);
	
	return apply_filters('job_bm_cp_filters_company_types',$company_types);
	
	}
		
		
		
		
		
		
		
		
		
		
		

		
		
	
	public function job_bm_cp_list_user_role(){
		
		global $wp_roles;
		$roles = $wp_roles->get_names();
		return $roles;
		}	
		
		
	
	}
	
	new class_job_bm_cp_functions();