<div id="ajax-login-block">
</div>
<div id="ajax-loader">
    <img src="<?php echo $loader_img; ?>" alt="" />
</div>
<div class="ajax-body-login">
    <div class="account-login">
		<a href="javascript:void(0);" class="a-close-frm" onclick="ocajaxlogin.closeForm();"><span>X</span></a>
        <div class="ajax-content">
            <?php echo $ajax_login_content ?>
        </div>
    </div>
    <div class="account-register">
        <a href="javascript:void(0);" class="a-close-frm" onclick="ocajaxlogin.closeForm();"><span>X</span></a>
        <div class="ajax-content">
            <?php echo $ajax_register_content ?>
        </div>
    </div>
    <div class="account-success">
        <div class="ajax-content">
            <?php echo $ajax_success_content ?>
        </div>
    </div>
    <div class="logout-success">
        <div class="ajax-content">
            <?php echo $ajax_logoutsuccess_content ?>
        </div>
    </div>
</div>
