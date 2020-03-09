<?php
if ( ! defined('ABSPATH')) exit;  // if direct access 

$company_id = get_the_ID();


do_action('job_bm_before_company_single', $company_id);

?>
<div itemscope itemtype="http://schema.org/Organization" id="company-single-<?php the_ID(); ?>" class="company-single">

<?php
        do_action('job_bm_company_single', $company_id);
    ?>
</div>
<?php
do_action('job_bm_after_company_single', $company_id);


