<?php
if ( ! defined('ABSPATH')) exit;  // if direct access


do_action('job_bm_company_list_before');
?>
<div class="job-bm-company-list">
    <?php
    do_action('job_bm_company_list');
    ?>
</div>
<?php
do_action('job_bm_company_list_after');