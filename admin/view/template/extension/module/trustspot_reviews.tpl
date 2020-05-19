<?php echo $header; ?>
<?php echo $column_left; ?>

<div id="content">

  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" id="button_submit" form="form_trustspot_reviews" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
			</div>
			
      <h1><?php echo $heading_title; ?></h1>
			
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
			
    </div>
  </div>
	
  <div class="container-fluid">
    
		<?php if ($error_warning) { ?>
			<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
				<button type="button" class="close" data-dismiss="alert">&times;</button>
			</div>
    <?php } ?>
		
    <div class="panel panel-default">
      
			<div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
			
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form_trustspot_reviews" class="form-horizontal">

					<div class="alert alert-info alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<strong>
							<?php echo $text_alert_allow_reviews; ?>
						</strong>
					</div>
					
					<div style="margin-bottom:25px;"></div>
					
					
					<fieldset>
            <legend><?php echo $text_subsection_api_settings; ?></legend>

						<!-- trustspot_reviews_email -->
						<div class="form-group required">
							<label class="col-sm-2 control-label" for="input-trustspot_reviews_email">
								<?php echo $entry_trustspot_reviews_email; ?>
							</label>
							
							<div class="col-sm-10">
								<input type="text" name="trustspot_reviews_email" value="<?php echo $trustspot_reviews_email; ?>" placeholder="<?php echo $entry_trustspot_reviews_email; ?>" id="input-trustspot_reviews_email" class="form-control" />
								
								<?php if ($error_trustspot_reviews_email) { ?>
									<div class="text-danger"><?php echo $error_trustspot_reviews_email; ?></div>
								<?php } ?>
							</div>
						</div> 
						
						<!-- trustspot_reviews_api_key -->
						<div class="form-group required">
							<label class="col-sm-2 control-label" for="input-trustspot_reviews_api_key">
								<?php echo $entry_trustspot_reviews_api_key; ?>
							</label>
							
							<div class="col-sm-10">
								<input type="text" name="trustspot_reviews_api_key" value="<?php echo $trustspot_reviews_api_key; ?>" placeholder="<?php echo $entry_trustspot_reviews_api_key; ?>" id="input-trustspot_reviews_api_key" class="form-control" />
								
								<?php if ($error_trustspot_reviews_api_key) { ?>
									<div class="text-danger"><?php echo $error_trustspot_reviews_api_key; ?></div>
								<?php } ?>
							</div>
						</div> 
						
						<!-- trustspot_reviews_api_secret -->
						<div class="form-group required">
							<label class="col-sm-2 control-label" for="input-trustspot_reviews_api_secret">
								<?php echo $entry_trustspot_reviews_api_secret; ?>
							</label>
							
							<div class="col-sm-10">
								<input type="text" name="trustspot_reviews_api_secret" value="<?php echo $trustspot_reviews_api_secret; ?>" placeholder="<?php echo $entry_trustspot_reviews_api_secret; ?>" id="input-trustspot_reviews_api_secret" class="form-control" />
								
								<?php if ($error_trustspot_reviews_api_secret) { ?>
									<div class="text-danger"><?php echo $error_trustspot_reviews_api_secret; ?></div>
								<?php } ?>
							</div>
						</div> 
						
						
						<div class="buttons">
							<div class="pull-right">
								<button id="button_verify_api" class="btn btn-primary" data-loading-text="<?php echo $text_loading; ?>">
									<i class="fa fa-check"></i>&nbsp&nbsp<?php echo $button_verify_api; ?>
								</button>
							</div>
						</div>
						
						<div style="margin-bottom:25px;"></div>
					</fieldset>	

					
					<fieldset>	
						<legend><?php echo $text_subsection_order_settings; ?></legend>
						
						<!-- trustspot_reviews_order_status_id -->
						<div class="form-group">
							<label class="col-sm-2 control-label" for="input-trustspot_reviews_order_status_id">
								<span data-toggle="tooltip" title="<?php echo $help_trustspot_reviews_order_status_id; ?>">
									<?php echo $entry_trustspot_reviews_order_status_id; ?>
								</span>
							</label>

							<div class="col-sm-10">
								<select name="trustspot_reviews_order_status_id" id="input-trustspot_reviews_order_status_id" class="form-control">
									<?php foreach ($order_statuses as $order_status) { ?>
										<option value="<?php echo $order_status['order_status_id'];?>" <?php if ($trustspot_reviews_order_status_id == $order_status['order_status_id']) { echo " selected"; }?> >
											<?php echo $order_status['name'];?>
										</option>
									<?php } ?>
								</select>
							</div>
						</div> 
						
						<div style="margin-bottom:25px;"></div>
					</fieldset>	
					
					
					<fieldset>	
						<legend><?php echo $text_subsection_show_widgets_settings; ?></legend>
						
						<!-- trustspot_reviews_show_mini_widget_on_product_page -->
						<div class="form-group">
							<label class="col-sm-2 control-label" for="input-trustspot_reviews_show_mini_widget_on_product_page">
								<span data-toggle="tooltip" title="<?php echo $help_trustspot_reviews_show_mini_widget_on_product_page; ?>">
									<?php echo $entry_trustspot_reviews_show_mini_widget_on_product_page; ?>
								</span>
							</label>
							
							<div class="col-sm-10">
								<select name="trustspot_reviews_show_mini_widget_on_product_page" id="input-trustspot_reviews_show_mini_widget_on_product_page" class="form-control">
									<?php if ($trustspot_reviews_show_mini_widget_on_product_page) { ?>
									<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
									<option value="0"><?php echo $text_disabled; ?></option>
									<?php } else { ?>
									<option value="1"><?php echo $text_enabled; ?></option>
									<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						
						<!-- trustspot_reviews_show_mini_widget_on_category_page -->
						<div class="form-group">
							<label class="col-sm-2 control-label" for="input-trustspot_reviews_show_mini_widget_on_category_page">
								<span data-toggle="tooltip" title="<?php echo $help_trustspot_reviews_show_mini_widget_on_category_page; ?>">
									<?php echo $entry_trustspot_reviews_show_mini_widget_on_category_page; ?>
								</span>
							</label>
							<div class="col-sm-10">
								<select name="trustspot_reviews_show_mini_widget_on_category_page" id="input-trustspot_reviews_show_mini_widget_on_category_page" class="form-control">
									<?php if ($trustspot_reviews_show_mini_widget_on_category_page) { ?>
									<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
									<option value="0"><?php echo $text_disabled; ?></option>
									<?php } else { ?>
									<option value="1"><?php echo $text_enabled; ?></option>
									<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						
						<!-- trustspot_reviews_show_large_widget_on_product_page -->
						<div class="form-group">
							<label class="col-sm-2 control-label" for="input-trustspot_reviews_show_large_widget_on_product_page">
								<span data-toggle="tooltip" title="<?php echo $help_trustspot_reviews_show_large_widget_on_product_page; ?>">
									<?php echo $entry_trustspot_reviews_show_large_widget_on_product_page; ?>
								</span>
							</label>
							<div class="col-sm-10">
								<select name="trustspot_reviews_show_large_widget_on_product_page" id="input-trustspot_reviews_show_large_widget_on_product_page" class="form-control">
									<?php if ($trustspot_reviews_show_large_widget_on_product_page) { ?>
									<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
									<option value="0"><?php echo $text_disabled; ?></option>
									<?php } else { ?>
									<option value="1"><?php echo $text_enabled; ?></option>
									<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
					
						<div style="margin-bottom:25px;"></div>
					</fieldset>	
					
					
					<fieldset>	
						<legend><?php echo $text_subsection_common_settings; ?></legend>
						
						<!-- trustspot_reviews_status -->
						<div class="form-group">
							<label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
							<div class="col-sm-10">
								<select name="trustspot_reviews_status" id="input-status" class="form-control">
									<?php if ($trustspot_reviews_status) { ?>
									<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
									<option value="0"><?php echo $text_disabled; ?></option>
									<?php } else { ?>
									<option value="1"><?php echo $text_enabled; ?></option>
									<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
					</fieldset>	
					
        </form>
      </div>
    </div>
  </div>
</div>
	
<script type="text/javascript"><!--
function is_undefined(val){
	if(typeof(val)  === 'undefined') {
	return ''
	}
	else
		return val;
}


//verify_api
$('#button_verify_api').on('click', function(e) {
	e.preventDefault();

	$.ajax({
		url: 'index.php?route=<?php echo $module_path; ?>/getVerifyApiData&token=<?php echo $token; ?>',
		type: 'post',
		dataType: 'json',
		data: 'trustspot_reviews_email=' 		+ encodeURIComponent( is_undefined( $('input[name=\'trustspot_reviews_email\']').val() ) ) + 
					'&trustspot_reviews_api_key=' + encodeURIComponent( is_undefined( $('input[name=\'trustspot_reviews_api_key\']').val() ) ),
		beforeSend: function() {
			$('#button_verify_api').button('loading');
		},
		complete: function() {
			$('#button_verify_api').button('reset');
		},
		
		success: function(json) {
			$('.alert-success, .alert-danger').remove();

			if (json['error']) {
				alert(json['error']);
				$('#form_trustspot_reviews').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i><strong> ' + json['error'] + ' </strong><button type="button" class="close" data-dismiss="alert">&times;</button></div></div>');
				$('html, body').animate({ scrollTop: 0 }, 'slow');
			}

			if (json['success']) {
				$('#form_trustspot_reviews').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i><strong> ' + json['success'] + ' </strong><button type="button" class="close" data-dismiss="alert">&times;</button></div></div>');
				$('html, body').animate({ scrollTop: 0 }, 'slow');
				
				//setTimeout(function() { $('#button_submit').click(); }, 6000);
			}
		},
		
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});
//--></script>			
	
<?php echo $footer; ?>