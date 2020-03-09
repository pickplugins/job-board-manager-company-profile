=== Job Board Manager - Company Profile ===
	Contributors: pickplugins
	Donate link: http://pickplugins.com
	Tags:  Company Profile, Job Board Manager, Job Board, Job, Job Poster, job manager, job, job list, job listing, Job Listings, job lists, job management, job manager,
	Requires at least: 4.1
	Tested up to: 5.2
	Stable tag: 1.0.10
	License: GPLv2 or later
	License URI: http://www.gnu.org/licenses/gpl-2.0.html

	Company Profile for Job Board Manager plugin

== Description ==

**Company Profile** add-on allows you to create company or organization page for **Job Board Manager** plugin. user can create company page and edit via job dashboard. these company can be added under job meta field data to filter jobs by company. user can follow company to get notified when job posted from followed companies.

### Job Board Manager by [http://pickplugins.com](http://pickplugins.com)

* [Get Job Board Manager &raquo;](https://wordpress.org/plugins/job-board-manager/)
* [Live Demo](http://www.pickplugins.com/demo/job-board-manager/company/microsoft/)
* [Documentation](https://pickplugins.com/documentation/job-board-manager-company-profile/)

**Company Single Page**

**Company Profile** add-on create single company page where the company information displayed, user can learn more about the company.

**Company Submit**

There is a shortcode to submit or create company, user can create own company pages. you can add custom input fields via action hook and validated and save under company meta fields.
`
[job_bm_company_submit_form]
`

**Company Edit**

User can edit/update their existing company information, you can create a new page to use following shortcode to display company edit form. user will able to access edit page from job dashboard.
`
[job_bm_company_edit_form]
`

**Company List**

You can display list companies with pagination and list of latest job from each company. you can use following shortcode to display company list.
`
[job_bm_company_list]
`

**My Companies**

User can see their created list of companies via job dashboard and you can display anywhere via following shortcode
`
[job_bm_my_companies]
`

**Company Following**

User can follow company by clicking **Follow** button under company profile page, and user can see the available job post from followed company via job feed add-on.

**Company Star Reviews**

User can put star reviews and feedback for companies. there is **reviews** tabs under company page to display list of reviews and reviews submit form at bottom.


<strong>Translation</strong>

Plugin is translation ready, you can contribute in translation here https://translate.wordpress.org/projects/wp-plugins/job-board-manager-company-profile/

== Installation ==

1. Install as regular WordPress plugin.<br />
2. Go your plugin setting via WordPress Dashboard and find "<strong>Job Board Manager - Company Profile</strong>" activate it.<br />




== Screenshots ==

1. screenshot-1
2. screenshot-2
3. screenshot-3
4. screenshot-4
5. screenshot-5
6. screenshot-6
7. screenshot-7
8. screenshot-8
9. screenshot-9
10. screenshot-10


== Changelog ==

    = 1.0.10 =
    * 13/09/2019 - remove - remove common.css

	= 1.0.9 =
    * 19/11/2016 - fix - company address save issue fixed.

	= 1.0.8 =
    * 19/11/2016 - update - update documentation.


	= 1.0.7 =
    * 18/11/2016 - remove - removed unnecessary files and code

	= 1.0.6 =
    * 10/08/2019 - update - action hook removed 'job_bm_action_before_company_single' and alter by
    job_bm_before_company_single
   * 10/08/2019 - update - action hook removed 'job_bm_action_company_single_main' and alter by
   job_bm_company_single_main
   * 10/08/2019 - update - action hook removed 'job_bm_action_after_company_single' and alter by
   job_bm_after_company_single


	= 1.0.5 =
    * 16/11/2016 - fix - translation issue fixed.

	= 1.0.4 =
    * 05/10/2016 - add - translation file added.

	= 1.0.3 =
    * 22/04/2016 - add - translation ready.

	= 1.0.2 =
    * 31/03/2016 - Company List Grid with open job list.
	* 31/03/2016 - add - company follow.

	= 1.0.1 =
    * 05/09/2015 - add - ajax load company list suggest.

	= 1.0.0 =
    * 05/08/2015 Initial release.