<?php
$_['heading_title']     = 'SEO Product Tags Bulk Generator';

$_['text_success']     			= 'Success: You have updated the changes!';

//column title
$_['entry_parameters'] = 'SET PATTERN FOR TAGS GENERATION';
$_['help_parameters'] = '{p} - Product Name <br> {c} - Category<br> {b} - Brand<br> {m} - Model<br> {u} - UPC<br> {p*} - Generate tags from product name regardless of special characters<br> {c*} - Generate tags from product categories regardless of special characters';

$_['entry_stop_words'] = 'Enter Stop Words separated by comma';
$_['help_stop_words'] = 'These words will be excluded in tag generation.';

$_['entry_automatic'] = 'Enable Automatic Tag Generation';
$_['help_automatic'] = 'If set to yes, tags will be generated automatically whenever you add or update product';

$_['btn_generate']  	 = '<i class="fa fa-play-circle"></i> Generate';
$_['btn_clear']  	 = '<i class="fa fa-trash"></i>  Clear';

$_['text_report'] = 'Report';

$_['text_loading'] = 'Generating...';
$_['text_clear'] = 'Deleting...';
$_['text_success_clear'] = '<div class="alert alert-success"><i class="fa fa-check-circle"></i> Product Tags Cleared Successfully!
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>';
$_['text_success_generate'] = '<div class="alert alert-success"><i class="fa fa-check-circle"></i> Tags Generated Successfully for %s products!
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>';
?>