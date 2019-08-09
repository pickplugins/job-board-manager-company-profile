<?php
if ( ! defined('ABSPATH')) exit;  // if direct access

$company_id_id = isset($_GET['company_id']) ? $_GET['company_id'] : '';


?>
<div class="job-bm-job-submit company-edit">
    <?php
    if(!empty($_POST)){
        do_action('job_bm_company_edit_data', $company_id_id, $_POST);
    }
    ?>
    <?php do_action('job_bm_company_edit_before', $company_id_id); ?>
    <form enctype="multipart/form-data" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
        <?php
		do_action('job_bm_company_edit_form', $company_id_id);
		?>
    </form>
	<?php do_action('job_bm_company_edit_after', $company_id_id); ?>
</div>