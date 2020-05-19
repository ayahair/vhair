<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-cireviewpro" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i> <?php echo $button_save; ?></button>
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
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="alert alert-info">
      The following line should be added to the CRON, if you want automatically send notification. How to set cron job in directadmin?
      <br/>
      <strong>wget -q <?php echo $front_site; ?>index.php?route=cireviewpro/cireviewcron/cron</strong>
      <br/>
      or
      <br/>
      <strong>wget -q "<?php echo $front_site; ?>index.php?route=cireviewpro/cireviewcron/cron"</strong>
      <br/>
      <br/>
      If you have a problem to set the cron job on your own server, please use setcronjob.com or easycron.com and use following the url.
      <br/>
      <strong><?php echo $front_site; ?>index.php?route=cireviewpro/cireviewcron/cron</strong>

    </div>
    


    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $heading_title; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-cireviewpro" class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="cireviewpro_cron_status" id="input-status" class="form-control">
                <option value="1" <?php if($cireviewpro_cron_status) { echo 'selected="selected"'; } ?>><?php echo $text_enabled; ?></option>
                <option value="0" <?php if(!$cireviewpro_cron_status && !is_null($cireviewpro_cron_status)) { echo 'selected="selected"'; } ?>><?php echo $text_disabled; ?></option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-onorder"><span data-toggle="tooltip" title="<?php echo $help_onorder; ?>"><?php echo $entry_onorder; ?></span></label>
            <div class="col-sm-10">
              <input type="checkbox" name="cireviewpro_cron_onorder" id="input-onorder" class="form-control" value="1" <?php if($cireviewpro_cron_onorder) { echo 'checked="checked"'; } ?> />
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-orderstatuses"><span data-toggle="tooltip" title="<?php echo $help_orderstatuses; ?>"><?php echo $entry_orderstatuses; ?></span></label>
            <div class="col-sm-10">
              <select name="cireviewpro_cron_orderstatuses[]" id="input-orderstatuses" class="form-control" multiple="multiple" style="height: 150px;">
                <?php 
                foreach($order_statuses as $order_status) { 
                $sel = '';
                if(in_array($order_status['order_status_id'], $cireviewpro_cron_orderstatuses)) {
                  $sel = 'selected="selected"';
                }
                ?>
                <option value="<?php echo $order_status['order_status_id']; ?>" <?php echo $sel; ?>><?php echo $order_status['name']; ?></option>
                <?php } ?>
              </select>
              <span class="help"><?php echo $help_selectmultiple; ?></span>
              <?php if ($error_orderstatuses) { ?>
              <div class="text-danger"><?php echo $error_orderstatuses; ?></div>
              <?php } ?>

            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-customer_groups"><span data-toggle="tooltip" title="<?php echo $help_customer_groups; ?>"><?php echo $entry_customer_groups; ?></span></label>
            <div class="col-sm-10">
              <select name="cireviewpro_cron_customer_groups[]" id="input-customer_groups" class="form-control" multiple="multiple" style="height: 150px;">
                <?php 
                foreach($customer_groups as $customer_group) { 
                $sel = '';
                if(in_array($customer_group['customer_group_id'], $cireviewpro_cron_customer_groups)) {
                  $sel = 'selected="selected"';
                }
                ?>
                <option value="<?php echo $customer_group['customer_group_id']; ?>" <?php echo $sel; ?>><?php echo $customer_group['name']; ?></option>
                <?php } ?>
              </select>
              <span class="help"><?php echo $help_selectmultiple; ?></span>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-resendold"><span data-toggle="tooltip" title="<?php echo $help_resendold; ?>"><?php echo $entry_resendold; ?></span></label>
            <div class="col-sm-10">
              <input type="checkbox" name="cireviewpro_cron_resendold" id="input-resendold" class="form-control" value="1" <?php if($cireviewpro_cron_resendold) { echo 'checked="checked"'; } ?> />
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-dayinterval"><span data-toggle="tooltip" title="<?php echo $help_dayinterval; ?>"><?php echo $entry_dayinterval; ?></span></label>
            <div class="col-sm-10">
              <input type="text" name="cireviewpro_cron_dayinterval"  placeholder="<?php echo $entry_dayinterval; ?>" id="input-dayinterval" class="form-control" value="<?php echo $cireviewpro_cron_dayinterval; ?>" />
              <span class="help"><?php echo $help_dayinterval1; ?></span>
              <?php if ($error_dayinterval) { ?>
              <div class="text-danger"><?php echo $error_dayinterval; ?></div>
              <?php } ?>
            </div>
          </div>
          <!-- /*29-08-2018*/ --><div class="form-group required">
            <label class="col-sm-2 control-label" for="input-maxreminders"><span data-toggle="tooltip" title="<?php echo $help_maxreminders; ?>"><?php echo $entry_maxreminders; ?></span></label>
            <div class="col-sm-10">
              <input type="text" name="cireviewpro_cron_maxreminders"  placeholder="<?php echo $entry_maxreminders; ?>" id="input-maxreminders" class="form-control" value="<?php echo $cireviewpro_cron_maxreminders; ?>" />
              <?php if ($error_maxreminders) { ?>
              <div class="text-danger"><?php echo $error_maxreminders; ?></div>
              <?php } ?>
            </div>
          </div><!-- /*29-08-2018*/ -->
          <fieldset>
            <legend><?php echo $legend_email ?></legend>
            <div class="customeremail">
              <ul class="nav nav-tabs" id="language">
                <?php foreach ($languages as $language) { ?>
                <li><a href="#language<?php echo $language['language_id']; ?>" data-toggle="tab"><?php if(VERSION >= '2.2.0.0') { ?>
                  <img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> 
                <?php } else{ ?>
                  <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" />
                <?php } ?> <?php echo $language['name']; ?></a></li>
                <?php } ?>
              </ul>
              <div class="tab-content">
                <?php foreach ($languages as $language) { ?>
                <div class="tab-pane" id="language<?php echo $language['language_id']; ?>">
                  <div class="form-group required">
                    <label class="col-sm-2 control-label" for="input-subject<?php echo $language['language_id']; ?>"><?php echo $entry_subject; ?></label>
                    <div class="col-sm-10">
                      <input type="text" name="cireviewpro_cron_mail[<?php echo $language['language_id']; ?>][subject]" rows="5" placeholder="<?php echo $entry_subject; ?>" id="input-subject<?php echo $language['language_id']; ?>" class="form-control" value="<?php echo isset($cireviewpro_cron_mail[$language['language_id']]) ? $cireviewpro_cron_mail[$language['language_id']]['subject'] : ''; ?>" />
                      <?php if (isset($error_subject[$language['language_id']])) { ?>
                      <div class="text-danger"><?php echo $error_subject[$language['language_id']]; ?></div>
                      <?php } ?>
                    </div>
                  </div>
                  <div class="form-group required">
                    <label class="col-sm-2 control-label" for="input-message<?php echo $language['language_id']; ?>"><?php echo $entry_message; ?></label>
                    <div class="col-sm-10">
                      <textarea name="cireviewpro_cron_mail[<?php echo $language['language_id']; ?>][message]" rows="5" placeholder="<?php echo $entry_message; ?>" id="input-message<?php echo $language['language_id']; ?>" class="form-control summernote
                      " data-toggle="summernote" data-lang=""><?php echo isset($cireviewpro_cron_mail[$language['language_id']]) ? $cireviewpro_cron_mail[$language['language_id']]['message'] : ''; ?></textarea>
                      <?php if (isset($error_message[$language['language_id']])) { ?>
                      <div class="text-danger"><?php echo $error_message[$language['language_id']]; ?></div>
                      <?php } ?>
                    </div>
                  </div>
                </div>
                <?php } ?>
              </div>  
            </div>
            <div class="form-group">
              <div class="col-sm-12">
                <div class="table-responsive">
                  <table class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <td><?php echo $code_code; ?></td>
                        <td><?php echo $code_translate; ?></td>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>{FIRSTNAME}</td>
                        <td><?php echo $code_firstname; ?></td>
                      </tr>
                      <tr>
                        <td>{LASTNAME}</td>
                        <td><?php echo $code_lastname; ?></td>
                      </tr>
                      <tr>
                        <td>{EMAIL}</td>
                        <td><?php echo $code_email; ?></td>
                      </tr>
                      <tr>
                        <td>{STORE_NAME}</td>
                        <td><?php echo $code_store_name; ?></td>
                      </tr>
                      <tr>
                        <td>{LOGO}</td>
                        <td><?php echo $code_logo; ?></td>
                      </tr>
                      <tr>
                        <td>{ORDER_PRODUCTS}</td>
                        <td><?php echo $code_products; ?></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </fieldset>
        </form>
      </div>
    </div>
  </div>

<?php if(VERSION <= '2.2.0.0') { ?>
<script type="text/javascript"><!--
<?php foreach ($languages as $language) { ?>
$('#input-message<?php echo $language['language_id']; ?>').summernote({ height: 300 });
<?php } ?>
//--></script>
<?php } else if (VERSION <= '2.3.0.2') { ?>
<script type="text/javascript" src="view/javascript/summernote/summernote.js"></script>
<link href="view/javascript/summernote/summernote.css" rel="stylesheet" />
<script type="text/javascript" src="view/javascript/summernote/opencart.js"></script>
<?php } else { ?>
<link href="view/javascript/codemirror/lib/codemirror.css" rel="stylesheet" />
<link href="view/javascript/codemirror/theme/monokai.css" rel="stylesheet" />
<script type="text/javascript" src="view/javascript/codemirror/lib/codemirror.js"></script> 
<script type="text/javascript" src="view/javascript/codemirror/lib/xml.js"></script> 
<script type="text/javascript" src="view/javascript/codemirror/lib/formatting.js"></script> 
<script type="text/javascript" src="view/javascript/summernote/summernote.js"></script>
<link href="view/javascript/summernote/summernote.css" rel="stylesheet" />
<script type="text/javascript" src="view/javascript/summernote/summernote-image-attributes.js"></script> 
<script type="text/javascript" src="view/javascript/summernote/opencart.js"></script> 
<?php } ?>
<script type="text/javascript"><!--
$('#language a:first').tab('show');
//--></script></div>
<?php echo $footer; ?>