<?php
if ( ! defined('ABSPATH')) exit;  // if direct access


do_action('job_bm_my_companies_before');
?>
<div class="job-bm-my-jobs my-companies">
    <?php
    do_action('job_bm_my_companies');
    ?>
</div>
<?php
do_action('job_bm_my_companies_after');