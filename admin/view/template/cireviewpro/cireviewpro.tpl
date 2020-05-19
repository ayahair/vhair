<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-cireviewpro" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-success"><i class="fa fa-check-circle"></i> <?php echo $button_save; ?></button>
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
    <pre>";<?php print_r($error_warning);  ?>"<pre>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-exclamation-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
        <div class="pull-right">
          <select name="store_id" onchange="window.location = 'index.php?route=cireviewpro/cireviewpro&<?php echo $module_token; ?>=<?php echo $ci_token; ?>&store_id='+ this.value;">
            <option value="0"><?php echo $text_default; ?></option>
            <?php foreach($stores as $store) { ?>
            <option value="<?php echo $store['store_id']; ?>" <?php echo ($store['store_id'] == $store_id) ? 'selected="selected"' : ''; ?>><?php echo $store['name']; ?></option>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="panel-body">
        <?php if ($requiresync) { ?>
        <div class="alert-reviewsync row">
          <div class="col-sm-8 alert-cireview">
        <div class="alert alert-warning"><i class="fa fa-exclamation-circle"></i> <?php echo $text_requiresync; ?>
        </div></div>
        <div class="col-sm-4"><button type="button" class="btn btn-primary btn-xs doreviewsync"><i class="fa fa-refresh"></i> <?php echo $button_reviewsync; ?></button></div>
        </div>
        <?php } ?>
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-cireviewpro" class="form-horizontal">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#tab-general" data-toggle="tab"><i class="fa fa-cogs"></i> <?php echo $tab_general; ?></a></li>
          <li><a href="#tab-pageinfo" data-toggle="tab"><i class="fa fa-image"></i> <?php echo $tab_pageinfo; ?></a></li>
          <li><a href="#tab-email" data-toggle="tab"><i class="fa fa-envelope"></i> <?php echo $tab_email; ?></a></li>
          <li><a href="#tab-css" data-toggle="tab"><i class="fa fa-eye-slash"></i> <?php echo $tab_css; ?></a></li>
          <li><a href="#tab-support" data-toggle="tab"><i class="fa fa-user"></i> <?php echo $tab_support; ?></a></li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="tab-general">
            <div class="row">
              <div class="col-sm-3">
                <ul class="nav nav-pills nav-stacked" id="general-option">
                  <li class="active"><a href="#tab-general-option-setting" data-toggle="tab"><i class="fa fa-power-off"></i> <?php echo $text_reviewsetting; ?></a></li>
                  <li><a href="#tab-general-option-form" data-toggle="tab"><i class="fa fa-file"></i> <?php echo $text_reviewform; ?></a></li>
                  <li><a href="#tab-general-option-image" data-toggle="tab"><i class="fa fa-paperclip"></i> <?php echo $text_reviewimage; ?></a></li>
                  <li><a href="#tab-general-option-rating" data-toggle="tab"><i class="fa fa-star"></i> <?php echo $text_reviewrating; ?></a></li>
                  <li><a href="#tab-general-option-vote" data-toggle="tab"><i class="fa fa-thumbs-up"></i> <?php echo $text_reviewvote; ?></a></li>
                  <li><a href="#tab-general-option-abuse" data-toggle="tab"><i class="fa fa-ban"></i> <?php echo $text_reviewabuse; ?></a></li>
                  <li><a href="#tab-general-option-page" data-toggle="tab"><i class="fa fa-list"></i> <?php echo $text_reviewpage; ?></a></li>
                  <li><a href="#tab-general-option-filter" data-toggle="tab"><i class="fa fa-filter"></i> <?php echo $text_reviewfilter; ?></a></li>
                  <li><a href="#tab-general-option-coupon" data-toggle="tab"><i class="fa fa-gift"></i> <?php echo $text_reviewcoupon; ?></a></li>
                  <li><a href="#tab-general-option-reward" data-toggle="tab"><i class="fa fa-dollar"></i> <?php echo $text_reviewreward; ?></a></li>
                  <li><a href="#tab-general-option-rewardsuccess" data-toggle="tab"><i class="fa fa-info-circle"></i> <?php echo $text_reviewsuccess; ?></a></li>
                </ul>
              </div>
              <div class="col-sm-9">
                <div class="tab-content">
                  <div class="tab-pane active" id="tab-general-option-setting">
                    <div class="form-group">
                      <label class="col-sm-12 control-label" for="input-cireviewpro-status"><?php echo $entry_status; ?></label>
                      <div class="col-sm-12">
                        <div class="btn-group" data-toggle="buttons">
                          <label class="btn btn-default <?php echo $cireviewpro_status ? 'active' : ''; ?>">
                            <input name="cireviewpro_status" <?php echo $cireviewpro_status ? 'checked="checked"' : ''; ?> autocomplete="off" value="1" type="radio"><?php echo $text_enabled; ?>
                          </label>
                          <label class="btn btn-default <?php echo !$cireviewpro_status ? 'active' : ''; ?>">
                            <input name="cireviewpro_status" <?php echo !$cireviewpro_status ? 'checked="checked"' : ''; ?> autocomplete="off" value="0" type="radio"> <?php echo $text_disabled; ?>
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-12 control-label" for="input-reviewadmindir"><span data-toggle="tooltip" title="<?php echo $help_reviewadmindir; ?>"><?php echo $entry_reviewadmindir; ?></span></label>
                      <div class="col-sm-6 col-md-4">
                        <input name="cireviewpro_reviewadmindir" value="<?php echo $cireviewpro_reviewadmindir; ?>" placeholder="<?php echo $entry_reviewadmindir; ?>" id="input-reviewadmindir" class="form-control" type="text" />
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-12 control-label" for="input-is_multistore"><?php echo $entry_is_multistore; ?></label>
                      <div class="col-sm-12">
                        <div class="btn-group" data-toggle="buttons">
                          <label class="btn btn-default <?php echo $cireviewpro_is_multistore ? 'active' : ''; ?>">
                            <input name="cireviewpro_is_multistore" <?php echo $cireviewpro_is_multistore ? 'checked="checked"' : ''; ?> autocomplete="off" value="1" type="radio"><?php echo $text_yes; ?>
                          </label>
                          <label class="btn btn-default <?php echo !$cireviewpro_is_multistore ? 'active' : ''; ?>">
                            <input name="cireviewpro_is_multistore" <?php echo !$cireviewpro_is_multistore ? 'checked="checked"' : ''; ?> autocomplete="off" value="0" type="radio"> <?php echo $text_no; ?>
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-12 control-label" for="input-is_multilanguage"><?php echo $entry_is_multilanguage; ?></label>
                      <div class="col-sm-12">
                        <div class="btn-group" data-toggle="buttons">
                          <label class="btn btn-default <?php echo $cireviewpro_is_multilanguage ? 'active' : ''; ?>">
                            <input name="cireviewpro_is_multilanguage" <?php echo $cireviewpro_is_multilanguage ? 'checked="checked"' : ''; ?> autocomplete="off" value="1" type="radio"><?php echo $text_yes; ?>
                          </label>
                          <label class="btn btn-default <?php echo !$cireviewpro_is_multilanguage ? 'active' : ''; ?>">
                            <input name="cireviewpro_is_multilanguage" <?php echo !$cireviewpro_is_multilanguage ? 'checked="checked"' : ''; ?> autocomplete="off" value="0" type="radio"> <?php echo $text_no; ?>
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-12 control-label" for="input-reviewimp"><?php echo $entry_reviewimp; ?></label>
                      <div class="col-sm-12">
                        <div class="btn-group" data-toggle="buttons">
                          <label class="btn btn-default <?php echo $cireviewpro_reviewimp ? 'active' : ''; ?>">
                            <input name="cireviewpro_reviewimp" <?php echo $cireviewpro_reviewimp ? 'checked="checked"' : ''; ?> autocomplete="off" value="1" type="radio"><?php echo $text_yes; ?>
                          </label>
                          <label class="btn btn-default <?php echo !$cireviewpro_reviewimp ? 'active' : ''; ?>">
                            <input name="cireviewpro_reviewimp" <?php echo !$cireviewpro_reviewimp ? 'checked="checked"' : ''; ?> autocomplete="off" value="0" type="radio"> <?php echo $text_no; ?>
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-12 control-label" for="input-reviewapprove"><?php echo $entry_reviewapprove; ?></label>
                      <div class="col-sm-12">
                        <div class="btn-group" data-toggle="buttons">
                          <label class="btn btn-default <?php echo $cireviewpro_reviewapprove=='NO' ? 'active' : ''; ?>">
                            <input name="cireviewpro_reviewapprove" <?php echo $cireviewpro_reviewapprove=='NO' ? 'checked="checked"' : ''; ?> autocomplete="off" value="NO" type="radio"><?php echo $text_no; ?>
                          </label>
                          <label class="btn btn-default <?php echo $cireviewpro_reviewapprove=='LOGGED' ? 'active' : ''; ?>">
                            <input name="cireviewpro_reviewapprove" <?php echo $cireviewpro_reviewapprove=='LOGGED' ? 'checked="checked"' : ''; ?> autocomplete="off" value="LOGGED" type="radio"> <?php echo $text_onlylogged; ?>
                          </label>
                          <label class="btn btn-default <?php echo $cireviewpro_reviewapprove=='BOTH' ? 'active' : ''; ?>">
                            <input name="cireviewpro_reviewapprove" <?php echo $cireviewpro_reviewapprove=='BOTH' ? 'checked="checked"' : ''; ?> autocomplete="off" value="BOTH" type="radio"> <?php echo $text_onlyboth; ?>
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-12 control-label" for="input-reviewpurchaseonly"><span data-toggle="tooltip" title="<?php echo $help_reviewpurchaseonly; ?>"><?php echo $entry_reviewpurchaseonly; ?></span></label>
                      <div class="col-sm-12">
                        <div class="btn-group" data-toggle="buttons">
                          <label class="btn btn-default <?php echo $cireviewpro_reviewpurchaseonly ? 'active' : ''; ?>">
                            <input name="cireviewpro_reviewpurchaseonly" <?php echo $cireviewpro_reviewpurchaseonly ? 'checked="checked"' : ''; ?> autocomplete="off" value="1" type="radio"><?php echo $text_yes; ?>
                          </label>
                          <label class="btn btn-default <?php echo !$cireviewpro_reviewpurchaseonly ? 'active' : ''; ?>">
                            <input name="cireviewpro_reviewpurchaseonly" <?php echo !$cireviewpro_reviewpurchaseonly ? 'checked="checked"' : ''; ?> autocomplete="off" value="0" type="radio"> <?php echo $text_no; ?>
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-12 control-label" for="input-verifypurchase_orderstatus"><span data-toggle="tooltip" title="<?php echo $help_verifypurchase_orderstatus; ?>"><?php echo $entry_verifypurchase_orderstatus; ?></span></label>
                      <div class="col-sm-12">
                        <div class="well well-sm" style="height: 150px; overflow: auto;">
                          <?php foreach ($order_statuses as $order_status) { ?>
                          <div class="checkbox">
                            <label>
                              <?php if (in_array($order_status['order_status_id'], $cireviewpro_verifypurchase_orderstatus)) { ?>
                              <input type="checkbox" name="cireviewpro_verifypurchase_orderstatus[]" value="<?php echo $order_status['order_status_id']; ?>" checked="checked" />
                              <?php echo $order_status['name']; ?>
                              <?php } else { ?>
                              <input type="checkbox" name="cireviewpro_verifypurchase_orderstatus[]" value="<?php echo $order_status['order_status_id']; ?>" />
                              <?php echo $order_status['name']; ?>
                              <?php } ?>
                            </label>
                          </div>
                          <?php } ?>
                        </div>
                        <?php if ($error_verifypurchase_orderstatus) { ?>
                        <div class="text-danger"><?php echo $error_verifypurchase_orderstatus; ?></div>
                        <?php } ?>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-12 control-label" for="input-reviewguest"><?php echo $entry_reviewguest; ?></label>
                      <div class="col-sm-12">
                        <div class="btn-group" data-toggle="buttons">
                          <label class="btn btn-default <?php echo $cireviewpro_reviewguest ? 'active' : ''; ?>">
                            <input name="cireviewpro_reviewguest" <?php echo $cireviewpro_reviewguest ? 'checked="checked"' : ''; ?> autocomplete="off" value="1" type="radio"><?php echo $text_yes; ?>
                          </label>
                          <label class="btn btn-default <?php echo !$cireviewpro_reviewguest ? 'active' : ''; ?>">
                            <input name="cireviewpro_reviewguest" <?php echo !$cireviewpro_reviewguest ? 'checked="checked"' : ''; ?> autocomplete="off" value="0" type="radio"> <?php echo $text_no; ?>
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-12 control-label" for="input-reviewmax"><span data-toggle="tooltip" title="<?php echo $help_reviewmax; ?>"><?php echo $entry_reviewmax; ?></span></label>
                      <div class="col-sm-6 col-md-4">
                        <input name="cireviewpro_reviewmax" value="<?php echo $cireviewpro_reviewmax; ?>" placeholder="<?php echo $entry_reviewmax; ?>" id="input-reviewmax" class="form-control" type="text" />
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-12 control-label" for="input-reviewviewsource"><?php echo $entry_reviewviewsource; ?></label>
                      <div class="col-sm-12">
                        <div class="btn-group" data-toggle="buttons">
                          <label class="btn btn-default <?php echo $cireviewpro_reviewviewsource ? 'active' : ''; ?>">
                            <input name="cireviewpro_reviewviewsource" <?php echo $cireviewpro_reviewviewsource ? 'checked="checked"' : ''; ?> autocomplete="off" value="1" type="radio"><?php echo $text_yes; ?>
                          </label>
                          <label class="btn btn-default <?php echo !$cireviewpro_reviewviewsource ? 'active' : ''; ?>">
                            <input name="cireviewpro_reviewviewsource" <?php echo !$cireviewpro_reviewviewsource ? 'checked="checked"' : ''; ?> autocomplete="off" value="0" type="radio"> <?php echo $text_no; ?>
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-12 control-label" for="input-richsnippets"><span data-toggle="tooltip" title="<?php echo $help_richsnippets; ?>"><?php echo $entry_richsnippets; ?></span></label>
                      <div class="col-sm-4">
                        <div class="btn-group" data-toggle="buttons">
                          <label class="btn btn-default <?php echo $cireviewpro_richsnippets ? 'active' : ''; ?>">
                            <input name="cireviewpro_richsnippets" <?php echo $cireviewpro_richsnippets ? 'checked="checked"' : ''; ?> autocomplete="off" value="1" type="radio"><?php echo $text_yes; ?>
                          </label>
                          <label class="btn btn-default <?php echo !$cireviewpro_richsnippets ? 'active' : ''; ?>">
                            <input name="cireviewpro_richsnippets" <?php echo !$cireviewpro_richsnippets ? 'checked="checked"' : ''; ?> autocomplete="off" value="0" type="radio"> <?php echo $text_no; ?>
                          </label>
                        </div>
                      </div>
                      <div class="col-sm-8 text-left">
                        <div class="alert alert-info">
                          <?php echo $help_richsnippets_verify; ?>
                          <br/>
                         <a href="https://search.google.com/structured-data/testing-tool" target="_BLANK">https://search.google.com/structured-data/testing-tool</a>
                        
                        </div>
                      </div>
                    </div>
                    <fieldset>
                      <legend><?php echo $legend_reviewshare; ?></legend>
                      <div class="form-group">
                        <label class="col-sm-12 control-label" for="input-reviewshare"><?php echo $entry_reviewshare; ?></label>
                        <div class="col-sm-12">
                          <div class="btn-group" data-toggle="buttons">
                            <label class="btn btn-default <?php echo $cireviewpro_reviewshare ? 'active' : ''; ?>">
                              <input name="cireviewpro_reviewshare" <?php echo $cireviewpro_reviewshare ? 'checked="checked"' : ''; ?> autocomplete="off" value="1" type="radio"><?php echo $text_yes; ?>
                            </label>
                            <label class="btn btn-default <?php echo !$cireviewpro_reviewshare ? 'active' : ''; ?>">
                              <input name="cireviewpro_reviewshare" <?php echo !$cireviewpro_reviewshare ? 'checked="checked"' : ''; ?> autocomplete="off" value="0" type="radio"> <?php echo $text_no; ?>
                            </label>
                          </div>
                        </div>
                      </div>
                    </fieldset>
                  </div>
                  <div class="tab-pane" id="tab-general-option-form">
                    <div class="form-group">
                      <label class="col-sm-12 control-label" for="input-cireviewpro-captcha"><?php echo $entry_captcha; ?></label>
                      <div class="col-sm-12">
                        <div class="btn-group" data-toggle="buttons">
                          <label class="btn btn-default <?php echo $cireviewpro_captcha ? 'active' : ''; ?>">
                            <input name="cireviewpro_captcha" <?php echo $cireviewpro_captcha ? 'checked="checked"' : ''; ?> autocomplete="off" value="1" type="radio"><?php echo $text_yes; ?>
                          </label>
                          <label class="btn btn-default <?php echo !$cireviewpro_captcha ? 'active' : ''; ?>">
                            <input name="cireviewpro_captcha" <?php echo !$cireviewpro_captcha ? 'checked="checked"' : ''; ?> autocomplete="off" value="0" type="radio"> <?php echo $text_no; ?>
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-12 control-label" for="input-reviewreply"><span data-toggle="tooltip" title="<?php echo $help_reviewreply; ?>"><?php echo $entry_reviewreply; ?></span></label>
                      <div class="col-sm-12">
                        <div class="btn-group" data-toggle="buttons">
                          <label class="btn btn-default <?php echo $cireviewpro_reviewreply ? 'active' : ''; ?>">
                            <input name="cireviewpro_reviewreply" <?php echo $cireviewpro_reviewreply ? 'checked="checked"' : ''; ?> autocomplete="off" value="1" type="radio"><?php echo $text_yes; ?>
                          </label>
                          <label class="btn btn-default <?php echo !$cireviewpro_reviewreply ? 'active' : ''; ?>">
                            <input name="cireviewpro_reviewreply" <?php echo !$cireviewpro_reviewreply ? 'checked="checked"' : ''; ?> autocomplete="off" value="0" type="radio"> <?php echo $text_no; ?>
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-12 control-label" for="input-reviewreplyauthor"><?php echo $entry_reviewreplyauthor; ?></label>
                      <div class="col-sm-12">
                        <input name="cireviewpro_reviewreplyauthor" value="<?php echo $cireviewpro_reviewreplyauthor; ?>" placeholder="<?php echo $entry_reviewreplyauthor; ?>" id="input-reviewreplyauthor" class="form-control" type="text" />
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <label class="col-sm-12 control-label" for="input-reviewaddon"><?php echo $entry_reviewaddon; ?></label>
                      <div class="col-sm-12">
                        <div class="btn-group" data-toggle="buttons">
                          <label class="btn btn-default <?php echo $cireviewpro_reviewaddon=='DAYSAGO' ? 'active' : ''; ?>">
                            <input name="cireviewpro_reviewaddon" <?php echo $cireviewpro_reviewaddon=='DAYSAGO' ? 'checked="checked"' : ''; ?> autocomplete="off" value="DAYSAGO" type="radio"><?php echo $entry_daysago; ?>
                          </label>
                          <label class="btn btn-default <?php echo $cireviewpro_reviewaddon=='DATEFORMAT' ? 'active' : ''; ?>">
                            <input name="cireviewpro_reviewaddon" <?php echo $cireviewpro_reviewaddon=='DATEFORMAT' ? 'checked="checked"' : ''; ?> autocomplete="off" value="DATEFORMAT" type="radio"> <?php echo $entry_dateformat; ?>
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="form-group reviewaddon-dateformat">
                    
                      <label class="col-sm-12 control-label" for="input-reviewdateformat"><?php echo $entry_reviewdateformat; ?></label>
                      <div class="col-sm-12">
                        <input name="cireviewpro_reviewdateformat" value="<?php echo $cireviewpro_reviewdateformat; ?>" placeholder="<?php echo $entry_reviewdateformat; ?>" id="input-reviewdateformat" class="form-control" type="text" />
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-12 control-label" for="input-reviewlimit"><?php echo $entry_reviewlimit; ?></label>
                      <div class="col-sm-12">
                        <input type="text" name="cireviewpro_reviewlimit" value="<?php echo $cireviewpro_reviewlimit; ?>" placeholder="<?php echo $entry_reviewlimit; ?>" class="form-control" />
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-12 control-label" for="input-reviewterm"><span data-toggle="tooltip" title="<?php echo $help_reviewterm; ?>"><?php echo $entry_reviewterm; ?></span></label>
                      <div class="col-sm-12">
                        <select name="cireviewpro_reviewterm_id" id="input-reviewterm" class="form-control">
                          <option value="0"><?php echo $text_none; ?></option>
                          <?php foreach ($informations as $information) { ?>
                          <?php if ($information['information_id'] == $cireviewpro_reviewterm_id) { ?>
                          <option value="<?php echo $information['information_id']; ?>" selected="selected"><?php echo $information['title']; ?></option>
                          <?php } else { ?>
                          <option value="<?php echo $information['information_id']; ?>"><?php echo $information['title']; ?></option>
                          <?php } ?>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                    <fieldset>
                      <legend><?php echo $entry_reviewfields; ?></legend>
                      <div class="form-group">
                        <label class="col-sm-12 control-label" for="input-reviewemail"><span data-toggle="tooltip" title="<?php echo $help_reviewemail; ?>"><?php echo $entry_reviewemail; ?></span></label>
                        <div class="col-sm-12">
                          <div class="btn-group" data-toggle="buttons">
                            <label class="btn btn-default <?php echo $cireviewpro_reviewemail ? 'active' : ''; ?>">
                              <input name="cireviewpro_reviewemail" <?php echo $cireviewpro_reviewemail ? 'checked="checked"' : ''; ?> autocomplete="off" value="1" type="radio"><?php echo $text_yes; ?>
                            </label>
                            <label class="btn btn-default <?php echo !$cireviewpro_reviewemail ? 'active' : ''; ?>">
                              <input name="cireviewpro_reviewemail" <?php echo !$cireviewpro_reviewemail ? 'checked="checked"' : ''; ?> autocomplete="off" value="0" type="radio"> <?php echo $text_no; ?>
                            </label>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label class="col-sm-12 control-label" for="input-reviewauthor"><span data-toggle="tooltip" title="<?php echo $help_reviewauthor; ?>"><?php echo $entry_reviewauthor; ?></span></label>
                            <div class="col-sm-12">
                              <div class="btn-group" data-toggle="buttons">
                                <label class="btn btn-default <?php echo $cireviewpro_reviewauthor ? 'active' : ''; ?>">
                                  <input name="cireviewpro_reviewauthor" <?php echo $cireviewpro_reviewauthor ? 'checked="checked"' : ''; ?> autocomplete="off" value="1" type="radio"><?php echo $text_yes; ?>
                                </label>
                                <label class="btn btn-default <?php echo !$cireviewpro_reviewauthor ? 'active' : ''; ?>">
                                  <input name="cireviewpro_reviewauthor" <?php echo !$cireviewpro_reviewauthor ? 'checked="checked"' : ''; ?> autocomplete="off" value="0" type="radio"> <?php echo $text_no; ?>
                                </label>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label class="col-sm-12 control-label" for="input-reviewauthor_require"><?php echo $entry_reviewauthor_require; ?></label>
                            <div class="col-sm-12">
                              <div class="btn-group" data-toggle="buttons">
                                <label class="btn btn-default <?php echo $cireviewpro_reviewauthor_require ? 'active' : ''; ?>">
                                  <input name="cireviewpro_reviewauthor_require" <?php echo $cireviewpro_reviewauthor_require ? 'checked="checked"' : ''; ?> autocomplete="off" value="1" type="radio"><?php echo $text_yes; ?>
                                </label>
                                <label class="btn btn-default <?php echo !$cireviewpro_reviewauthor_require ? 'active' : ''; ?>">
                                  <input name="cireviewpro_reviewauthor_require" <?php echo !$cireviewpro_reviewauthor_require ? 'checked="checked"' : ''; ?> autocomplete="off" value="0" type="radio"> <?php echo $text_no; ?>
                                </label>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label class="col-sm-12 control-label" for="input-reviewtitle"><?php echo $entry_reviewtitle; ?></label>
                            <div class="col-sm-12">
                              <div class="btn-group" data-toggle="buttons">
                                <label class="btn btn-default <?php echo $cireviewpro_reviewtitle ? 'active' : ''; ?>">
                                  <input name="cireviewpro_reviewtitle" <?php echo $cireviewpro_reviewtitle ? 'checked="checked"' : ''; ?> autocomplete="off" value="1" type="radio"><?php echo $text_yes; ?>
                                </label>
                                <label class="btn btn-default <?php echo !$cireviewpro_reviewtitle ? 'active' : ''; ?>">
                                  <input name="cireviewpro_reviewtitle" <?php echo !$cireviewpro_reviewtitle ? 'checked="checked"' : ''; ?> autocomplete="off" value="0" type="radio"> <?php echo $text_no; ?>
                                </label>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label class="col-sm-12 control-label" for="input-reviewtitle_require"><?php echo $entry_reviewtitle_require; ?></label>
                            <div class="col-sm-12">
                              <div class="btn-group" data-toggle="buttons">
                                <label class="btn btn-default <?php echo $cireviewpro_reviewtitle_require ? 'active' : ''; ?>">
                                  <input name="cireviewpro_reviewtitle_require" <?php echo $cireviewpro_reviewtitle_require ? 'checked="checked"' : ''; ?> autocomplete="off" value="1" type="radio"><?php echo $text_yes; ?>
                                </label>
                                <label class="btn btn-default <?php echo !$cireviewpro_reviewtitle_require ? 'active' : ''; ?>">
                                  <input name="cireviewpro_reviewtitle_require" <?php echo !$cireviewpro_reviewtitle_require ? 'checked="checked"' : ''; ?> autocomplete="off" value="0" type="radio"> <?php echo $text_no; ?>
                                </label>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label class="col-sm-12 control-label" for="input-reviewtext"><span data-toggle="tooltip" title="<?php echo $help_reviewtext; ?>"><?php echo $entry_reviewtext; ?></span></label>
                            <div class="col-sm-12">
                              <div class="btn-group" data-toggle="buttons">
                                <label class="btn btn-default <?php echo $cireviewpro_reviewtext ? 'active' : ''; ?>">
                                  <input name="cireviewpro_reviewtext" <?php echo $cireviewpro_reviewtext ? 'checked="checked"' : ''; ?> autocomplete="off" value="1" type="radio"><?php echo $text_yes; ?>
                                </label>
                                <label class="btn btn-default <?php echo !$cireviewpro_reviewtext ? 'active' : ''; ?>">
                                  <input name="cireviewpro_reviewtext" <?php echo !$cireviewpro_reviewtext ? 'checked="checked"' : ''; ?> autocomplete="off" value="0" type="radio"> <?php echo $text_no; ?>
                                </label>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label class="col-sm-12 control-label" for="input-reviewtext_require"><?php echo $entry_reviewtext_require; ?></label>
                            <div class="col-sm-12">
                              <div class="btn-group" data-toggle="buttons">
                                <label class="btn btn-default <?php echo $cireviewpro_reviewtext_require ? 'active' : ''; ?>">
                                  <input name="cireviewpro_reviewtext_require" <?php echo $cireviewpro_reviewtext_require ? 'checked="checked"' : ''; ?> autocomplete="off" value="1" type="radio"><?php echo $text_yes; ?>
                                </label>
                                <label class="btn btn-default <?php echo !$cireviewpro_reviewtext_require ? 'active' : ''; ?>">
                                  <input name="cireviewpro_reviewtext_require" <?php echo !$cireviewpro_reviewtext_require ? 'checked="checked"' : ''; ?> autocomplete="off" value="0" type="radio"> <?php echo $text_no; ?>
                                </label>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </fieldset>
                  </div>
                  <div class="tab-pane" id="tab-general-option-image">
                    <div class="form-group">
                      <label class="col-sm-12 control-label" for="input-reviewimages"><?php echo $entry_reviewimages; ?></label>
                      <div class="col-sm-12">
                        <div class="btn-group" data-toggle="buttons">
                          <label class="btn btn-default <?php echo $cireviewpro_reviewimages ? 'active' : ''; ?>">
                            <input name="cireviewpro_reviewimages" <?php echo $cireviewpro_reviewimages ? 'checked="checked"' : ''; ?> autocomplete="off" value="1" type="radio"><?php echo $text_yes; ?>
                          </label>
                          <label class="btn btn-default <?php echo !$cireviewpro_reviewimages ? 'active' : ''; ?>">
                            <input name="cireviewpro_reviewimages" <?php echo !$cireviewpro_reviewimages ? 'checked="checked"' : ''; ?> autocomplete="off" value="0" type="radio"> <?php echo $text_no; ?>
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-12 control-label" for="input-reviewimagespath"><span data-toggle="tooltip" title="<?php echo $help_reviewimagespath; ?>"><?php echo $entry_reviewimagespath; ?></span></label>
                      <div class="col-sm-12">
                        <input type="text" name="cireviewpro_reviewimagespath" value="<?php echo $cireviewpro_reviewimagespath; ?>" placeholder="<?php echo $entry_reviewimagespath; ?>" id="input-reviewimagespath" class="form-control" />
                      </div>
                    </div>
                    <div class="form-group required">
                      <label class="col-sm-12 control-label" for="input-reviewimageslimit"><?php echo $entry_reviewimageslimit; ?></label>
                      <div class="col-sm-12">
                        <input type="text" name="cireviewpro_reviewimageslimit" value="<?php echo $cireviewpro_reviewimageslimit; ?>" placeholder="<?php echo $entry_reviewimageslimit; ?>" id="input-reviewimageslimit" class="form-control" />
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-12 control-label" for="input-reviewimagesthumb"><?php echo $entry_reviewimagesthumb; ?></label>
                      <div class="col-sm-12">
                        <div class="row">
                          <div class="col-sm-6">
                            <div class="input-group">
                              <input type="text" name="cireviewpro_reviewimagesthumb_width" value="<?php echo $cireviewpro_reviewimagesthumb_width; ?>" placeholder="<?php echo $text_width; ?>" id="input-reviewimagesthumb-width" class="form-control" />
                              <span class="input-group-btn">
                                <button type="button" class="btn btn-primary"><i class="fa fa-arrows-h"></i></button>
                              </span>
                            </div>
                          </div>
                          <div class="col-sm-6">
                            <div class="input-group">
                              <input type="text" name="cireviewpro_reviewimagesthumb_height" value="<?php echo $cireviewpro_reviewimagesthumb_height; ?>" placeholder="<?php echo $text_height; ?>"  id="input-reviewimagesthumb-height" class="form-control" />
                              <span class="input-group-btn">
                                <button type="button" class="btn btn-primary"><i class="fa fa-arrows-v"></i></button>
                              </span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-12 control-label" for="input-reviewimagespopup"><?php echo $entry_reviewimagespopup; ?></label>
                      <div class="col-sm-12">
                        <div class="row">
                          <div class="col-sm-6">
                            <div class="input-group">
                              <input type="text" name="cireviewpro_reviewimagespopup_width" value="<?php echo $cireviewpro_reviewimagespopup_width; ?>" placeholder="<?php echo $text_width; ?>" id="input-reviewimagespopup-width" class="form-control" />
                              <span class="input-group-btn">
                                <button type="button" class="btn btn-primary"><i class="fa fa-arrows-h"></i></button>
                              </span>
                            </div>
                          </div>
                          <div class="col-sm-6">
                            <div class="input-group">
                              <input type="text" name="cireviewpro_reviewimagespopup_height" value="<?php echo $cireviewpro_reviewimagespopup_height; ?>" placeholder="<?php echo $text_height; ?>"  id="input-reviewimagespopup-height" class="form-control" />
                              <span class="input-group-btn">
                                <button type="button" class="btn btn-primary"><i class="fa fa-arrows-v"></i></button>
                              </span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-12 control-label" for="input-file-ext-allowed"><span data-toggle="tooltip" title="<?php echo $help_file_ext_allowed; ?>"><?php echo $entry_file_ext_allowed; ?></span></label>
                      <div class="col-sm-12">
                        <textarea name="cireviewpro_file_ext_allowed" rows="5" placeholder="<?php echo $entry_file_ext_allowed; ?>" id="input-file-ext-allowed" class="form-control"><?php echo $cireviewpro_file_ext_allowed; ?></textarea>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-12 control-label" for="input-file-mime-allowed"><span data-toggle="tooltip" title="<?php echo $help_file_mime_allowed; ?>"><?php echo $entry_file_mime_allowed; ?></span></label>
                      <div class="col-sm-12">
                        <textarea name="cireviewpro_file_mime_allowed" rows="5" placeholder="<?php echo $entry_file_mime_allowed; ?>" id="input-file-mime-allowed" class="form-control"><?php echo $cireviewpro_file_mime_allowed; ?></textarea>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane" id="tab-general-option-rating">
                    <p><h3><?php echo $text_alterratingstars; ?></h3></p>
                    <?php /* <div class="form-group">
                      <label class="col-sm-12 control-label" for="input-ratingstars"><?php echo $entry_ratingstars; ?></label>
                      <div class="col-sm-12">
                        <div class="btn-group" data-toggle="buttons">
                          <?php for($i=1;$i<=5;$i++) { ?>
                          <label class="btn btn-default <?php echo $cireviewpro_ratingstars==$i ? 'active' : ''; ?>">
                            <input name="cireviewpro_ratingstars" <?php echo $cireviewpro_ratingstars==$i ? 'checked="checked"' : ''; ?> autocomplete="off" value="<?php echo $i; ?>" type="radio"><?php echo $i; ?>
                          </label>
                          <?php } ?>
                        </div>
                      </div>
                    </div> */ ?>
                    <input name="cireviewpro_ratingstars" value="5" type="hidden" class="hide" style="display: none;" />
                    <div class="form-group">
                      <label class="col-sm-12 control-label" for="input-rating"><?php echo $entry_rating; ?></label>
                      <div class="col-sm-12">
                        <div class="btn-group" data-toggle="buttons">
                          <label class="btn btn-default <?php echo $cireviewpro_rating ? 'active' : ''; ?>">
                            <input name="cireviewpro_rating" <?php echo $cireviewpro_rating ? 'checked="checked"' : ''; ?> autocomplete="off" value="1" type="radio"><?php echo $text_yes; ?>
                          </label>
                          <label class="btn btn-default <?php echo !$cireviewpro_rating ? 'active' : ''; ?>">
                            <input name="cireviewpro_rating" <?php echo !$cireviewpro_rating ? 'checked="checked"' : ''; ?> autocomplete="off" value="0" type="radio"> <?php echo $text_no; ?>
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-12 control-label" for="input-reviewrating"><?php echo $entry_reviewrating; ?></label>
                      <div class="col-sm-12">
                        <div class="btn-group" data-toggle="buttons">
                          <label class="btn btn-default <?php echo $cireviewpro_reviewrating ? 'active' : ''; ?>">
                            <input name="cireviewpro_reviewrating" <?php echo $cireviewpro_reviewrating ? 'checked="checked"' : ''; ?> autocomplete="off" value="1" type="radio"><?php echo $text_yes; ?>
                          </label>
                          <label class="btn btn-default <?php echo !$cireviewpro_reviewrating ? 'active' : ''; ?>">
                            <input name="cireviewpro_reviewrating" <?php echo !$cireviewpro_reviewrating ? 'checked="checked"' : ''; ?> autocomplete="off" value="0" type="radio"> <?php echo $text_no; ?>
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-12 control-label" for="input-reviewratingcount"><?php echo $entry_reviewratingcount; ?></label>
                      <div class="col-sm-12">
                        <div class="btn-group" data-toggle="buttons">
                          <label class="btn btn-default <?php echo $cireviewpro_reviewratingcount ? 'active' : ''; ?>">
                            <input name="cireviewpro_reviewratingcount" <?php echo $cireviewpro_reviewratingcount ? 'checked="checked"' : ''; ?> autocomplete="off" value="1" type="radio"><?php echo $text_yes; ?>
                          </label>
                          <label class="btn btn-default <?php echo !$cireviewpro_reviewratingcount ? 'active' : ''; ?>">
                            <input name="cireviewpro_reviewratingcount" <?php echo !$cireviewpro_reviewratingcount ? 'checked="checked"' : ''; ?> autocomplete="off" value="0" type="radio"> <?php echo $text_no; ?>
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-12 control-label" for="input-reviewgraph"><?php echo $entry_reviewgraph; ?></label>
                      <div class="col-sm-12">
                        <div class="btn-group" data-toggle="buttons">
                          <label class="btn btn-default <?php echo $cireviewpro_reviewgraph ? 'active' : ''; ?>">
                            <input name="cireviewpro_reviewgraph" <?php echo $cireviewpro_reviewgraph ? 'checked="checked"' : ''; ?> autocomplete="off" value="1" type="radio"><?php echo $text_yes; ?>
                          </label>
                          <label class="btn btn-default <?php echo !$cireviewpro_reviewgraph ? 'active' : ''; ?>">
                            <input name="cireviewpro_reviewgraph" <?php echo !$cireviewpro_reviewgraph ? 'checked="checked"' : ''; ?> autocomplete="off" value="0" type="radio"> <?php echo $text_no; ?>
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-12 control-label" for="input-reviewgraph_option"><?php echo $entry_reviewgraph_option; ?></label>
                      <div class="col-sm-12">
                        <div class="btn-group" data-toggle="buttons">
                          <label class="btn btn-default <?php echo $cireviewpro_reviewgraph_option=='RATINGSTARS' ? 'active' : ''; ?>">
                            <input name="cireviewpro_reviewgraph_option" <?php echo $cireviewpro_reviewgraph_option=='RATINGSTARS' ? 'checked="checked"' : ''; ?> autocomplete="off" value="RATINGSTARS" type="radio"><?php echo $text_ratingstars; ?>
                          </label>
                          <label class="btn btn-default <?php echo $cireviewpro_reviewgraph_option=='PROGRESSBAR' ? 'active' : ''; ?>">
                            <input name="cireviewpro_reviewgraph_option" <?php echo $cireviewpro_reviewgraph_option=='PROGRESSBAR' ? 'checked="checked"' : ''; ?> autocomplete="off" value="PROGRESSBAR" type="radio"> <?php echo $text_progressbar; ?>
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-12 control-label"><?php echo $entry_reviewgraph_color; ?></label>
                      <div class="col-sm-4">
                        <div class="input-group colorpicker colorpicker-component">
                          <input type="text" name="cireviewpro_reviewgraph_color" value="<?php echo $cireviewpro_reviewgraph_color; ?>" class="form-control" />
                          <span class="input-group-addon"><i></i></span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane" id="tab-general-option-vote">
                    <div class="form-group">
                      <label class="col-sm-12 control-label" for="input-reviewgetvote"><?php echo $entry_reviewgetvote; ?></label>
                      <div class="col-sm-12">
                        <div class="btn-group" data-toggle="buttons">
                          <label class="btn btn-default <?php echo $cireviewpro_reviewgetvote ? 'active' : ''; ?>">
                            <input name="cireviewpro_reviewgetvote" <?php echo $cireviewpro_reviewgetvote ? 'checked="checked"' : ''; ?> autocomplete="off" value="1" type="radio"><?php echo $text_yes; ?>
                          </label>
                          <label class="btn btn-default <?php echo !$cireviewpro_reviewgetvote ? 'active' : ''; ?>">
                            <input name="cireviewpro_reviewgetvote" <?php echo !$cireviewpro_reviewgetvote ? 'checked="checked"' : ''; ?> autocomplete="off" value="0" type="radio"> <?php echo $text_no; ?>
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-12 control-label" for="input-reviewvoteguest"><?php echo $entry_reviewvoteguest; ?></label>
                      <div class="col-sm-12">
                        <div class="btn-group" data-toggle="buttons">
                          <label class="btn btn-default <?php echo $cireviewpro_reviewvoteguest ? 'active' : ''; ?>">
                            <input name="cireviewpro_reviewvoteguest" <?php echo $cireviewpro_reviewvoteguest ? 'checked="checked"' : ''; ?> autocomplete="off" value="1" type="radio"><?php echo $text_yes; ?>
                          </label>
                          <label class="btn btn-default <?php echo !$cireviewpro_reviewvoteguest ? 'active' : ''; ?>">
                            <input name="cireviewpro_reviewvoteguest" <?php echo !$cireviewpro_reviewvoteguest ? 'checked="checked"' : ''; ?> autocomplete="off" value="0" type="radio"> <?php echo $text_no; ?>
                          </label>
                        </div>
                      </div>
                    </div>
                    <br/>
                    <hr/>
                    <ul class="nav nav-tabs" id="cireview_votelanguage">
                      <?php foreach ($languages as $language) { ?>
                        <li><a href="#cireview_votelanguage<?php echo $language['language_id']; ?>" data-toggle="tab"><?php if(VERSION >= '2.2.0.0') { ?>
                          <img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" />
                        <?php } else{ ?>
                          <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" />
                        <?php } ?> <?php echo $language['name']; ?></a></li>
                      <?php } ?>
                    </ul>
                    <div class="tab-content">
                      <?php foreach ($languages as $language) { ?>
                      <div class="tab-pane" id="cireview_votelanguage<?php echo $language['language_id']; ?>">
                        <!-- Was this review is helpful? Yes / No 100% found this review helpful.
                        In your opinion is useful. 100% found this review helpful.
                        In your opinion is useless. 0% found this review helpful. -->
                        <div class="form-group">
                          <label class="col-sm-12 control-label" for="input-reviewvote<?php echo $language['language_id']; ?>"><span data-toggle="tooltip" title="<?php echo $help_reviewvotebefore; ?>"><?php echo $entry_reviewvotebefore; ?></span></label>
                          <div class="col-sm-12">
                            <input id="input-reviewvote<?php echo $language['language_id']; ?>" type="text" name="cireviewpro_reviewvote[<?php echo $language['language_id']; ?>][before]" value="<?php echo isset($cireviewpro_reviewvote[$language['language_id']]['before']) ? $cireviewpro_reviewvote[$language['language_id']]['before']: ''; ?>" class="form-control" placeholder="<?php echo $placeholder_reviewvotebefore; ?>" />
                            <?php if (isset($error_cireviewpro_reviewvote['before'][$language['language_id']])) { ?>
                            <div class="text-danger"><?php echo $error_cireviewpro_reviewvote['before'][$language['language_id']]; ?></div>
                            <?php } ?>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-12 control-label" for="input-reviewvoteyes<?php echo $language['language_id']; ?>"><span data-toggle="tooltip" title="<?php echo $help_reviewvoteyes; ?>"><?php echo $entry_reviewvoteyes; ?></span></label>
                          <div class="col-sm-12">
                            <input id="input-reviewvoteyes<?php echo $language['language_id']; ?>" type="text" name="cireviewpro_reviewvote[<?php echo $language['language_id']; ?>][yes]" value="<?php echo isset($cireviewpro_reviewvote[$language['language_id']]['yes']) ? $cireviewpro_reviewvote[$language['language_id']]['yes']: ''; ?>" class="form-control" placeholder="<?php echo $placeholder_reviewvoteyes; ?>" />
                            <?php if (isset($error_cireviewpro_reviewvote['yes'][$language['language_id']])) { ?>
                            <div class="text-danger"><?php echo $error_cireviewpro_reviewvote['yes'][$language['language_id']]; ?></div>
                            <?php } ?>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-12 control-label" for="input-reviewvoteno<?php echo $language['language_id']; ?>"><span data-toggle="tooltip" title="<?php echo $help_reviewvoteno; ?>"><?php echo $entry_reviewvoteno; ?></span></label>
                          <div class="col-sm-12">
                            <input id="input-reviewvoteno<?php echo $language['language_id']; ?>" type="text" name="cireviewpro_reviewvote[<?php echo $language['language_id']; ?>][no]" value="<?php echo isset($cireviewpro_reviewvote[$language['language_id']]['no']) ? $cireviewpro_reviewvote[$language['language_id']]['no']: ''; ?>" class="form-control" placeholder="<?php echo $placeholder_reviewvoteno; ?>" />
                            <?php if (isset($error_cireviewpro_reviewvote['no'][$language['language_id']])) { ?>
                            <div class="text-danger"><?php echo $error_cireviewpro_reviewvote['no'][$language['language_id']]; ?></div>
                            <?php } ?>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-12 control-label" for="input-reviewvoteoutof<?php echo $language['language_id']; ?>"><span data-toggle="tooltip" title="<?php echo $help_reviewvoteoutof; ?>"><?php echo $entry_reviewvoteoutof; ?></span></label>
                          <div class="col-sm-12">
                            <input id="input-reviewvoteoutof<?php echo $language['language_id']; ?>" type="text" name="cireviewpro_reviewvote[<?php echo $language['language_id']; ?>][outof]" value="<?php echo isset($cireviewpro_reviewvote[$language['language_id']]['outof']) ? $cireviewpro_reviewvote[$language['language_id']]['outof']: ''; ?>" class="form-control" placeholder="<?php echo $placeholder_reviewvoteoutof; ?>" />
                            <?php if (isset($error_cireviewpro_reviewvote['outof'][$language['language_id']])) { ?>
                            <div class="text-danger"><?php echo $error_cireviewpro_reviewvote['outof'][$language['language_id']]; ?></div>
                            <?php } ?>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-12 control-label" for="input-reviewvotepercent<?php echo $language['language_id']; ?>"><span data-toggle="tooltip" title="<?php echo $help_reviewvotepercent; ?>"><?php echo $entry_reviewvotepercent; ?></span></label>
                          <div class="col-sm-12">
                            <input id="input-reviewvotepercent<?php echo $language['language_id']; ?>" type="text" name="cireviewpro_reviewvote[<?php echo $language['language_id']; ?>][percent]" value="<?php echo isset($cireviewpro_reviewvote[$language['language_id']]['percent']) ? $cireviewpro_reviewvote[$language['language_id']]['percent']: ''; ?>" class="form-control" placeholder="<?php echo $placeholder_reviewvotepercent; ?>" />
                            <?php if (isset($error_cireviewpro_reviewvote['percent'][$language['language_id']])) { ?>
                            <div class="text-danger"><?php echo $error_cireviewpro_reviewvote['percent'][$language['language_id']]; ?></div>
                            <?php } ?>
                          </div>
                        </div>
                      </div>
                      <?php } ?>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-12 control-label" for="input-reviewvotetype"><?php echo $entry_reviewvotetype; ?></label>
                      <div class="col-sm-12">
                        <div class="btn-group" data-toggle="buttons">
                          <label class="btn btn-default <?php echo $cireviewpro_reviewvotetype=='PERCENT' ? 'active' : ''; ?>">
                            <input name="cireviewpro_reviewvotetype" <?php echo $cireviewpro_reviewvotetype=='PERCENT' ? 'checked="checked"' : ''; ?> autocomplete="off" value="PERCENT" type="radio"><?php echo $text_percent_find_usefull; ?>
                          </label>
                          <label class="btn btn-default <?php echo $cireviewpro_reviewvotetype=='OUTOF' ? 'active' : ''; ?>">
                            <input name="cireviewpro_reviewvotetype" <?php echo $cireviewpro_reviewvotetype=='OUTOF' ? 'checked="checked"' : ''; ?> autocomplete="off" value="OUTOF" type="radio"> <?php echo $text_outof_find_usefull; ?>
                          </label>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane" id="tab-general-option-abuse">
                    <div class="form-group">
                      <label class="col-sm-12 control-label" for="input-reviewabuse"><?php echo $entry_reviewabuse; ?></label>
                      <div class="col-sm-12">
                        <div class="btn-group" data-toggle="buttons">
                          <label class="btn btn-default <?php echo $cireviewpro_reviewabuse ? 'active' : ''; ?>">
                            <input name="cireviewpro_reviewabuse" <?php echo $cireviewpro_reviewabuse ? 'checked="checked"' : ''; ?> autocomplete="off" value="1" type="radio"><?php echo $text_yes; ?>
                          </label>
                          <label class="btn btn-default <?php echo !$cireviewpro_reviewabuse ? 'active' : ''; ?>">
                            <input name="cireviewpro_reviewabuse" <?php echo !$cireviewpro_reviewabuse ? 'checked="checked"' : ''; ?> autocomplete="off" value="0" type="radio"> <?php echo $text_no; ?>
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-12 control-label" for="input-reviewabuseguest"><?php echo $entry_reviewabuseguest; ?></label>
                      <div class="col-sm-12">
                        <div class="btn-group" data-toggle="buttons">
                          <label class="btn btn-default <?php echo $cireviewpro_reviewabuseguest ? 'active' : ''; ?>">
                            <input name="cireviewpro_reviewabuseguest" <?php echo $cireviewpro_reviewabuseguest ? 'checked="checked"' : ''; ?> autocomplete="off" value="1" type="radio"><?php echo $text_yes; ?>
                          </label>
                          <label class="btn btn-default <?php echo !$cireviewpro_reviewabuseguest ? 'active' : ''; ?>">
                            <input name="cireviewpro_reviewabuseguest" <?php echo !$cireviewpro_reviewabuseguest ? 'checked="checked"' : ''; ?> autocomplete="off" value="0" type="radio"> <?php echo $text_no; ?>
                          </label>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane" id="tab-general-option-filter">
                    <div class="form-group">
                      <label class="col-sm-12 control-label" for="input-reviewsortdefault"><?php echo $entry_reviewsortdefault; ?></label>
                      <div class="col-sm-12">
                        <select name="cireviewpro_reviewsortdefault" class="form-control">
                          <option value="r.cireview_id-DESC" <?php if($cireviewpro_reviewsortdefault=='r.cireview_id-DESC') { echo 'selected="selected"'; } ?>><?php echo $text_sort_default; ?></option>
                          <option value="r.rating-DESC" <?php if($cireviewpro_reviewsortdefault=='r.rating-DESC') { echo 'selected="selected"'; } ?>><?php echo $text_sort_rating_desc; ?></option>
                          <option value="r.rating-ASC" <?php if($cireviewpro_reviewsortdefault=='r.rating-ASC') { echo 'selected="selected"'; } ?>><?php echo $text_sort_rating_asc; ?></option>
                          <option value="p.date_added-DESC" <?php if($cireviewpro_reviewsortdefault=='p.date_added-DESC') { echo 'selected="selected"'; } ?>><?php echo $text_sort_dateadd_desc; ?></option>
                          <option value="p.date_added-ASC" <?php if($cireviewpro_reviewsortdefault=='p.date_added-ASC') { echo 'selected="selected"'; } ?>><?php echo $text_sort_dateadd_asc; ?></option>
                        </select>
                      </div>
                    </div>
                    <fieldset>
                      <legend><?php echo $legend_reviewproduct; ?></legend>
                      <div class="form-group">
                        <label class="col-sm-12 control-label" for="input-reviewfilters"><?php echo $entry_reviewfilters; ?></label>
                        <div class="col-sm-12">
                          <div class="btn-group" data-toggle="buttons">
                            <label class="btn btn-default <?php echo $cireviewpro_reviewfilters ? 'active' : ''; ?>">
                              <input name="cireviewpro_reviewfilters" <?php echo $cireviewpro_reviewfilters ? 'checked="checked"' : ''; ?> autocomplete="off" value="1" type="radio"><?php echo $text_yes; ?>
                            </label>
                            <label class="btn btn-default <?php echo !$cireviewpro_reviewfilters ? 'active' : ''; ?>">
                              <input name="cireviewpro_reviewfilters" <?php echo !$cireviewpro_reviewfilters ? 'checked="checked"' : ''; ?> autocomplete="off" value="0" type="radio"> <?php echo $text_no; ?>
                            </label>
                          </div>
                        </div>
                      </div>
                    </fieldset>
                    <fieldset>
                      <legend><?php echo $legend_reviewpage; ?></legend>
                      <div class="form-group">
                        <label class="col-sm-12 control-label" for="input-reviewsortshow"><?php echo $entry_reviewsortshow; ?></label>
                        <div class="col-sm-12">
                          <div class="btn-group" data-toggle="buttons">
                            <label class="btn btn-default <?php echo $cireviewpro_reviewsortshow ? 'active' : ''; ?>">
                              <input name="cireviewpro_reviewsortshow" <?php echo $cireviewpro_reviewsortshow ? 'checked="checked"' : ''; ?> autocomplete="off" value="1" type="radio"><?php echo $text_yes; ?>
                            </label>
                            <label class="btn btn-default <?php echo !$cireviewpro_reviewsortshow ? 'active' : ''; ?>">
                              <input name="cireviewpro_reviewsortshow" <?php echo !$cireviewpro_reviewsortshow ? 'checked="checked"' : ''; ?> autocomplete="off" value="0" type="radio"> <?php echo $text_no; ?>
                            </label>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-12 control-label" for="input-reviewsearch"><?php echo $entry_reviewsearch; ?></label>
                        <div class="col-sm-12">
                          <div class="btn-group" data-toggle="buttons">
                            <label class="btn btn-default <?php echo $cireviewpro_reviewsearch ? 'active' : ''; ?>">
                              <input name="cireviewpro_reviewsearch" <?php echo $cireviewpro_reviewsearch ? 'checked="checked"' : ''; ?> autocomplete="off" value="1" type="radio"><?php echo $text_yes; ?>
                            </label>
                            <label class="btn btn-default <?php echo !$cireviewpro_reviewsearch ? 'active' : ''; ?>">
                              <input name="cireviewpro_reviewsearch" <?php echo !$cireviewpro_reviewsearch ? 'checked="checked"' : ''; ?> autocomplete="off" value="0" type="radio"> <?php echo $text_no; ?>
                            </label>
                          </div>
                        </div>
                      </div>
                    </fieldset>
                  </div>
                  <div class="tab-pane" id="tab-general-option-page">
                    <div class="form-group">
                      <label class="col-sm-12 control-label" for="input-reviewview"><?php echo $entry_reviewview; ?></label>
                      <div class="col-sm-12">
                        <div class="btn-group" data-toggle="buttons">
                          <label class="btn btn-default <?php echo $cireviewpro_reviewview=='LIST' ? 'active' : ''; ?>">
                            <input name="cireviewpro_reviewview" <?php echo $cireviewpro_reviewview=='LIST' ? 'checked="checked"' : ''; ?> autocomplete="off" value="LIST" type="radio"><?php echo $text_list; ?>
                          </label>
                          <label class="btn btn-default <?php echo $cireviewpro_reviewview=='GRID' ? 'active' : ''; ?>">
                            <input name="cireviewpro_reviewview" <?php echo $cireviewpro_reviewview=='GRID' ? 'checked="checked"' : ''; ?> autocomplete="off" value="GRID" type="radio"> <?php echo $text_grid; ?>
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-12 control-label" for="input-reviewperrow"><?php echo $entry_reviewperrow; ?></label>
                      <div class="col-sm-12">
                        <div class="btn-group" data-toggle="buttons">
                          <?php for($i=1;$i<=6;$i++) { if($i==5) { continue; } ?>
                          <label class="btn btn-default <?php echo $cireviewpro_reviewperrow==$i ? 'active' : ''; ?>">
                            <input name="cireviewpro_reviewperrow" <?php echo $cireviewpro_reviewperrow==$i ? 'checked="checked"' : ''; ?> autocomplete="off" value="<?php echo $i; ?>" type="radio"><?php echo $i; ?>
                          </label>
                          <?php } ?>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-12 control-label" for="input-reviewpageimagesthumb"><?php echo $entry_reviewpageimagesthumb; ?></label>
                      <div class="col-sm-12">
                        <div class="row">
                          <div class="col-sm-6">
                            <div class="input-group">
                            <input type="text" name="cireviewpro_reviewpageimagesthumb_width" value="<?php echo $cireviewpro_reviewpageimagesthumb_width; ?>" placeholder="<?php echo $text_width; ?>" id="input-reviewpageimagesthumb-width" class="form-control" />
                            <span class="input-group-btn">
                              <button type="button" class="btn btn-primary"><i class="fa fa-arrows-h"></i></button>
                            </span>
                            </div>
                          </div>
                          <div class="col-sm-6">
                            <div class="input-group">
                              <input type="text" name="cireviewpro_reviewpageimagesthumb_height" value="<?php echo $cireviewpro_reviewpageimagesthumb_height; ?>" placeholder="<?php echo $text_height; ?>"  id="input-reviewpageimagesthumb-height" class="form-control" />
                              <span class="input-group-btn">
                                <button type="button" class="btn btn-primary"><i class="fa fa-arrows-v"></i></button>
                              </span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-12 control-label" for="input-reviewpageimagespopup"><?php echo $entry_reviewpageimagespopup; ?></label>
                      <div class="col-sm-12">
                        <div class="row">
                          <div class="col-sm-6">
                            <div class="input-group">
                              <input type="text" name="cireviewpro_reviewpageimagespopup_width" value="<?php echo $cireviewpro_reviewpageimagespopup_width; ?>" placeholder="<?php echo $text_width; ?>" id="input-reviewpageimagespopup-width" class="form-control" />
                              <span class="input-group-btn">
                                <button type="button" class="btn btn-primary"><i class="fa fa-arrows-h"></i></button>
                              </span>
                            </div>
                          </div>
                          <div class="col-sm-6">
                            <div class="input-group">
                              <input type="text" name="cireviewpro_reviewpageimagespopup_height" value="<?php echo $cireviewpro_reviewpageimagespopup_height; ?>" placeholder="<?php echo $text_height; ?>"  id="input-reviewpageimagespopup-height" class="form-control" />
                              <span class="input-group-btn">
                                <button type="button" class="btn btn-primary"><i class="fa fa-arrows-v"></i></button>
                              </span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-12 control-label" for="input-reviewpageproductthumb"><?php echo $entry_reviewpageproductthumb; ?></label>
                      <div class="col-sm-12">
                        <div class="row">
                          <div class="col-sm-6">
                            <div class="input-group">
                              <input type="text" name="cireviewpro_reviewpageproductthumb_width" value="<?php echo $cireviewpro_reviewpageproductthumb_width; ?>" placeholder="<?php echo $text_width; ?>" id="input-reviewpageproductthumb-width" class="form-control" />
                              <span class="input-group-btn">
                                <button type="button" class="btn btn-primary"><i class="fa fa-arrows-h"></i></button>
                              </span>
                            </div>
                          </div>
                          <div class="col-sm-6">
                            <div class="input-group">
                              <input type="text" name="cireviewpro_reviewpageproductthumb_height" value="<?php echo $cireviewpro_reviewpageproductthumb_height; ?>" placeholder="<?php echo $text_height; ?>"  id="input-reviewpageproductthumb-height" class="form-control" />
                              <span class="input-group-btn">
                                <button type="button" class="btn btn-primary"><i class="fa fa-arrows-v"></i></button>
                              </span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <label class="col-sm-12 control-label" for="input-reviewpageaddon"><?php echo $entry_reviewaddon; ?></label>
                      <div class="col-sm-12">
                        <div class="btn-group" data-toggle="buttons">
                          <label class="btn btn-default <?php echo $cireviewpro_reviewpageaddon=='DAYSAGO' ? 'active' : ''; ?>">
                            <input name="cireviewpro_reviewpageaddon" <?php echo $cireviewpro_reviewpageaddon=='DAYSAGO' ? 'checked="checked"' : ''; ?> autocomplete="off" value="DAYSAGO" type="radio"><?php echo $entry_daysago; ?>
                          </label>
                          <label class="btn btn-default <?php echo $cireviewpro_reviewpageaddon=='DATEFORMAT' ? 'active' : ''; ?>">
                            <input name="cireviewpro_reviewpageaddon" <?php echo $cireviewpro_reviewpageaddon=='DATEFORMAT' ? 'checked="checked"' : ''; ?> autocomplete="off" value="DATEFORMAT" type="radio"> <?php echo $entry_dateformat; ?>
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="form-group reviewpageaddon-dateformat">
                    
                      <label class="col-sm-12 control-label" for="input-reviewpagedateformat"><?php echo $entry_reviewpagedateformat; ?></label>
                      <div class="col-sm-12">
                        <input name="cireviewpro_reviewpagedateformat" value="<?php echo $cireviewpro_reviewpagedateformat; ?>" placeholder="<?php echo $entry_reviewpagedateformat; ?>" id="input-reviewpagedateformat" class="form-control" type="text" />
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-12 control-label" for="input-reviewpagelimit"><?php echo $entry_reviewpagelimit; ?></label>
                      <div class="col-sm-12">
                        <input type="text" name="cireviewpro_reviewpagelimit" value="<?php echo $cireviewpro_reviewpagelimit; ?>" placeholder="<?php echo $entry_reviewpagelimit; ?>" class="form-control" />
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-12 control-label" for="input-reviewpagetitleshow"><?php echo $entry_reviewpagetitleshow; ?></label>
                      <div class="col-sm-12">
                        <div class="btn-group" data-toggle="buttons">
                          <label class="btn btn-default <?php echo $cireviewpro_reviewpagetitleshow ? 'active' : ''; ?>">
                            <input name="cireviewpro_reviewpagetitleshow" <?php echo $cireviewpro_reviewpagetitleshow ? 'checked="checked"' : ''; ?> autocomplete="off" value="1" type="radio"><?php echo $text_yes; ?>
                          </label>
                          <label class="btn btn-default <?php echo !$cireviewpro_reviewpagetitleshow ? 'active' : ''; ?>">
                            <input name="cireviewpro_reviewpagetitleshow" <?php echo !$cireviewpro_reviewpagetitleshow ? 'checked="checked"' : ''; ?> autocomplete="off" value="0" type="radio"> <?php echo $text_no; ?>
                          </label>
                        </div>
                      </div>
                    </div>
                    <fieldset>
                      <legend><?php echo $legend_promo; ?></legend>
                      <div class="form-group">
                        <label class="col-sm-12 control-label" for="input-reviewpromoshow"><?php echo $entry_reviewpromoshow; ?></label>
                        <div class="col-sm-12">
                          <div class="btn-group" data-toggle="buttons">
                            <label class="btn btn-default <?php echo $cireviewpro_reviewpromoshow ? 'active' : ''; ?>">
                              <input name="cireviewpro_reviewpromoshow" <?php echo $cireviewpro_reviewpromoshow ? 'checked="checked"' : ''; ?> autocomplete="off" value="1" type="radio"><?php echo $text_yes; ?>
                            </label>
                            <label class="btn btn-default <?php echo !$cireviewpro_reviewpromoshow ? 'active' : ''; ?>">
                              <input name="cireviewpro_reviewpromoshow" <?php echo !$cireviewpro_reviewpromoshow ? 'checked="checked"' : ''; ?> autocomplete="off" value="0" type="radio"> <?php echo $text_no; ?>
                            </label>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-12 control-label" for="input-reviewpromoalign"><?php echo $entry_reviewpromoalign; ?></label>
                        <div class="col-sm-12">
                          <div class="btn-group" data-toggle="buttons">
                            <label class="btn btn-default <?php echo $cireviewpro_reviewpromoalign=='LEFT' ? 'active' : ''; ?>">
                              <input name="cireviewpro_reviewpromoalign" <?php echo $cireviewpro_reviewpromoalign=='LEFT' ? 'checked="checked"' : ''; ?> autocomplete="off" value="LEFT" type="radio"><?php echo $text_align_left; ?>
                            </label>
                            <label class="btn btn-default <?php echo $cireviewpro_reviewpromoalign=='CENTER' ? 'active' : ''; ?>">
                              <input name="cireviewpro_reviewpromoalign" <?php echo $cireviewpro_reviewpromoalign=='CENTER' ? 'checked="checked"' : ''; ?> autocomplete="off" value="CENTER" type="radio"> <?php echo $text_align_center; ?>
                            </label>
                            <label class="btn btn-default <?php echo $cireviewpro_reviewpromoalign=='RIGHT' ? 'active' : ''; ?>">
                              <input name="cireviewpro_reviewpromoalign" <?php echo $cireviewpro_reviewpromoalign=='RIGHT' ? 'checked="checked"' : ''; ?> autocomplete="off" value="RIGHT" type="radio"> <?php echo $text_align_right; ?>
                            </label>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-12 control-label" for="input-reviewpromoproductnameshow"><?php echo $entry_reviewpromoproductnameshow; ?></label>
                        <div class="col-sm-12">
                          <div class="btn-group" data-toggle="buttons">
                            <label class="btn btn-default <?php echo $cireviewpro_reviewpromoproductnameshow ? 'active' : ''; ?>">
                              <input name="cireviewpro_reviewpromoproductnameshow" <?php echo $cireviewpro_reviewpromoproductnameshow ? 'checked="checked"' : ''; ?> autocomplete="off" value="1" type="radio"><?php echo $text_yes; ?>
                            </label>
                            <label class="btn btn-default <?php echo !$cireviewpro_reviewpromoproductnameshow ? 'active' : ''; ?>">
                              <input name="cireviewpro_reviewpromoproductnameshow" <?php echo !$cireviewpro_reviewpromoproductnameshow ? 'checked="checked"' : ''; ?> autocomplete="off" value="0" type="radio"> <?php echo $text_no; ?>
                            </label>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-12 control-label" for="input-reviewpromoproductpriceshow"><?php echo $entry_reviewpromoproductpriceshow; ?></label>
                        <div class="col-sm-12">
                          <div class="btn-group" data-toggle="buttons">
                            <label class="btn btn-default <?php echo $cireviewpro_reviewpromoproductpriceshow ? 'active' : ''; ?>">
                              <input name="cireviewpro_reviewpromoproductpriceshow" <?php echo $cireviewpro_reviewpromoproductpriceshow ? 'checked="checked"' : ''; ?> autocomplete="off" value="1" type="radio"><?php echo $text_yes; ?>
                            </label>
                            <label class="btn btn-default <?php echo !$cireviewpro_reviewpromoproductpriceshow ? 'active' : ''; ?>">
                              <input name="cireviewpro_reviewpromoproductpriceshow" <?php echo !$cireviewpro_reviewpromoproductpriceshow ? 'checked="checked"' : ''; ?> autocomplete="off" value="0" type="radio"> <?php echo $text_no; ?>
                            </label>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-12 control-label" for="input-reviewpromoproductratingshow"><?php echo $entry_reviewpromoproductratingshow; ?></label>
                        <div class="col-sm-12">
                          <div class="btn-group" data-toggle="buttons">
                            <label class="btn btn-default <?php echo $cireviewpro_reviewpromoproductratingshow ? 'active' : ''; ?>">
                              <input name="cireviewpro_reviewpromoproductratingshow" <?php echo $cireviewpro_reviewpromoproductratingshow ? 'checked="checked"' : ''; ?> autocomplete="off" value="1" type="radio"><?php echo $text_yes; ?>
                            </label>
                            <label class="btn btn-default <?php echo !$cireviewpro_reviewpromoproductratingshow ? 'active' : ''; ?>">
                              <input name="cireviewpro_reviewpromoproductratingshow" <?php echo !$cireviewpro_reviewpromoproductratingshow ? 'checked="checked"' : ''; ?> autocomplete="off" value="0" type="radio"> <?php echo $text_no; ?>
                            </label>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-12 control-label" for="input-reviewpromocategorynameshow"><?php echo $entry_reviewpromocategorynameshow; ?></label>
                        <div class="col-sm-12">
                          <div class="btn-group" data-toggle="buttons">
                            <label class="btn btn-default <?php echo $cireviewpro_reviewpromocategorynameshow ? 'active' : ''; ?>">
                              <input name="cireviewpro_reviewpromocategorynameshow" <?php echo $cireviewpro_reviewpromocategorynameshow ? 'checked="checked"' : ''; ?> autocomplete="off" value="1" type="radio"><?php echo $text_yes; ?>
                            </label>
                            <label class="btn btn-default <?php echo !$cireviewpro_reviewpromocategorynameshow ? 'active' : ''; ?>">
                              <input name="cireviewpro_reviewpromocategorynameshow" <?php echo !$cireviewpro_reviewpromocategorynameshow ? 'checked="checked"' : ''; ?> autocomplete="off" value="0" type="radio"> <?php echo $text_no; ?>
                            </label>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-12 control-label" for="input-reviewpromomanufacturernameshow"><?php echo $entry_reviewpromomanufacturernameshow; ?></label>
                        <div class="col-sm-12">
                          <div class="btn-group" data-toggle="buttons">
                            <label class="btn btn-default <?php echo $cireviewpro_reviewpromomanufacturernameshow ? 'active' : ''; ?>">
                              <input name="cireviewpro_reviewpromomanufacturernameshow" <?php echo $cireviewpro_reviewpromomanufacturernameshow ? 'checked="checked"' : ''; ?> autocomplete="off" value="1" type="radio"><?php echo $text_yes; ?>
                            </label>
                            <label class="btn btn-default <?php echo !$cireviewpro_reviewpromomanufacturernameshow ? 'active' : ''; ?>">
                              <input name="cireviewpro_reviewpromomanufacturernameshow" <?php echo !$cireviewpro_reviewpromomanufacturernameshow ? 'checked="checked"' : ''; ?> autocomplete="off" value="0" type="radio"> <?php echo $text_no; ?>
                            </label>
                          </div>
                        </div>
                      </div>
                      <br/>
                      <hr/>
                      <ul class="nav nav-tabs" id="cireview_reviewpromolanguage">
                        <?php foreach ($languages as $language) { ?>
                        <li><a href="#cireview_reviewpromolanguage<?php echo $language['language_id']; ?>" data-toggle="tab">
                          <?php if(VERSION >= '2.2.0.0') { ?>
                            <img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" />
                          <?php } else{ ?>
                            <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" />
                          <?php } ?> <?php echo $language['name']; ?></a></li>
                        <?php } ?>
                      </ul>
                      <div class="tab-content">
                        <?php foreach ($languages as $language) { ?>
                        <div class="tab-pane" id="cireview_reviewpromolanguage<?php echo $language['language_id']; ?>">
                          <div class="form-group ">
                            <label class="col-sm-12 control-label" for="input-reviewpromoproduct<?php echo $language['language_id']; ?>"><?php echo $entry_reviewpromotextproduct; ?></label>
                            <div class="col-sm-12">
                              <input id="input-reviewpromoproduct<?php echo $language['language_id']; ?>" type="text" name="cireviewpro_reviewpromo[<?php echo $language['language_id']; ?>][product]" value="<?php echo isset($cireviewpro_reviewpromo[$language['language_id']]['product']) ? $cireviewpro_reviewpromo[$language['language_id']]['product']: ''; ?>" class="form-control" />
                            </div>
                          </div>
                          <div class="form-group ">
                            <label class="col-sm-12 control-label" for="input-reviewpromocategory<?php echo $language['language_id']; ?>"><?php echo $entry_reviewpromotextcategory; ?></label>
                            <div class="col-sm-12">
                              <input id="input-reviewpromocategory<?php echo $language['language_id']; ?>" type="text" name="cireviewpro_reviewpromo[<?php echo $language['language_id']; ?>][category]" value="<?php echo isset($cireviewpro_reviewpromo[$language['language_id']]['category']) ? $cireviewpro_reviewpromo[$language['language_id']]['category']: ''; ?>" class="form-control" />
                            </div>
                          </div>
                          <div class="form-group ">
                            <label class="col-sm-12 control-label" for="input-reviewpromomanufacturer<?php echo $language['language_id']; ?>"><?php echo $entry_reviewpromotextmanufacturer; ?></label>
                            <div class="col-sm-12">
                              <input id="input-reviewpromomanufacturer<?php echo $language['language_id']; ?>" type="text" name="cireviewpro_reviewpromo[<?php echo $language['language_id']; ?>][manufacturer]" value="<?php echo isset($cireviewpro_reviewpromo[$language['language_id']]['manufacturer']) ? $cireviewpro_reviewpromo[$language['language_id']]['manufacturer']: ''; ?>" class="form-control" />
                            </div>
                          </div>
                        </div>
                        <?php } ?>
                      </div>
                      <h4><?php echo $text_promoproduct; ?></h4>
                      <div class="form-group">
                        <label class="col-sm-12 control-label" for="input-reviewpromoproduct"><?php echo $entry_reviewpromoproduct; ?></label>
                        <div class="col-sm-12">
                          <div class="row">
                            <div class="col-sm-6">
                              <div class="input-group">
                                <input type="text" name="cireviewpro_reviewpromoproduct_width" value="<?php echo $cireviewpro_reviewpromoproduct_width; ?>" placeholder="<?php echo $text_width; ?>" id="input-reviewpromoproduct-width" class="form-control" />
                                <span class="input-group-btn">
                                  <button type="button" class="btn btn-primary"><i class="fa fa-arrows-h"></i></button>
                                </span>
                              </div>
                            </div>
                            <div class="col-sm-6">
                              <div class="input-group">
                                <input type="text" name="cireviewpro_reviewpromoproduct_height" value="<?php echo $cireviewpro_reviewpromoproduct_height; ?>" placeholder="<?php echo $text_height; ?>"  id="input-reviewpromoproduct-height" class="form-control" />
                                <span class="input-group-btn">
                                  <button type="button" class="btn btn-primary"><i class="fa fa-arrows-v"></i></button>
                                </span>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <h4><?php echo $text_promocategory; ?></h4>
                      <div class="form-group">
                        <label class="col-sm-12 control-label" for="input-reviewpromocategory"><?php echo $entry_reviewpromocategory; ?></label>
                        <div class="col-sm-12">
                          <div class="row">
                            <div class="col-sm-6">
                              <div class="input-group">
                                <input type="text" name="cireviewpro_reviewpromocategory_width" value="<?php echo $cireviewpro_reviewpromocategory_width; ?>" placeholder="<?php echo $text_width; ?>" id="input-reviewpromocategory-width" class="form-control" />
                                <span class="input-group-btn">
                                  <button type="button" class="btn btn-primary"><i class="fa fa-arrows-h"></i></button>
                                </span>
                              </div>
                            </div>
                            <div class="col-sm-6">
                              <div class="input-group">
                                <input type="text" name="cireviewpro_reviewpromocategory_height" value="<?php echo $cireviewpro_reviewpromocategory_height; ?>" placeholder="<?php echo $text_height; ?>"  id="input-reviewpromocategory-height" class="form-control" />
                                <span class="input-group-btn">
                                  <button type="button" class="btn btn-primary"><i class="fa fa-arrows-v"></i></button>
                                </span>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <h4><?php echo $text_promomanufacturer; ?></h4>
                      <div class="form-group">
                        <label class="col-sm-12 control-label" for="input-reviewpromomanufacturer"><?php echo $entry_reviewpromomanufacturer; ?></label>
                        <div class="col-sm-12">
                          <div class="row">
                            <div class="col-sm-6">
                              <div class="input-group">
                                <input type="text" name="cireviewpro_reviewpromomanufacturer_width" value="<?php echo $cireviewpro_reviewpromomanufacturer_width; ?>" placeholder="<?php echo $text_width; ?>" id="input-reviewpromomanufacturer-width" class="form-control" />
                                <span class="input-group-btn">
                                  <button type="button" class="btn btn-primary"><i class="fa fa-arrows-h"></i></button>
                                </span>
                              </div>
                            </div>
                            <div class="col-sm-6">
                              <div class="input-group">
                                <input type="text" name="cireviewpro_reviewpromomanufacturer_height" value="<?php echo $cireviewpro_reviewpromomanufacturer_height; ?>" placeholder="<?php echo $text_height; ?>"  id="input-reviewpromomanufacturer-height" class="form-control" />
                                <span class="input-group-btn">
                                  <button type="button" class="btn btn-primary"><i class="fa fa-arrows-v"></i></button>
                                </span>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </fieldset>
                  </div>
                  <div class="tab-pane" id="tab-general-option-coupon">
                    <div class="form-group">
                      <label class="col-sm-12 control-label" for="input-reviewcoupon"><?php echo $entry_reviewcoupon; ?></label>
                      <div class="col-sm-12">
                        <div class="btn-group" data-toggle="buttons">
                          <label class="btn btn-default <?php echo $cireviewpro_reviewcoupon ? 'active' : ''; ?>">
                            <input name="cireviewpro_reviewcoupon" <?php echo $cireviewpro_reviewcoupon ? 'checked="checked"' : ''; ?> autocomplete="off" value="1" type="radio"><?php echo $text_yes; ?>
                          </label>
                          <label class="btn btn-default <?php echo !$cireviewpro_reviewcoupon ? 'active' : ''; ?>">
                            <input name="cireviewpro_reviewcoupon" <?php echo !$cireviewpro_reviewcoupon ? 'checked="checked"' : ''; ?> autocomplete="off" value="0" type="radio"> <?php echo $text_no; ?>
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-12 control-label" for="input-reviewcouponguest"><?php echo $entry_reviewcouponguest; ?></label>
                      <div class="col-sm-12">
                        <div class="btn-group" data-toggle="buttons">
                          <label class="btn btn-default <?php echo $cireviewpro_reviewcouponguest ? 'active' : ''; ?>">
                            <input name="cireviewpro_reviewcouponguest" <?php echo $cireviewpro_reviewcouponguest ? 'checked="checked"' : ''; ?> autocomplete="off" value="1" type="radio"><?php echo $text_yes; ?>
                          </label>
                          <label class="btn btn-default <?php echo !$cireviewpro_reviewcouponguest ? 'active' : ''; ?>">
                            <input name="cireviewpro_reviewcouponguest" <?php echo !$cireviewpro_reviewcouponguest ? 'checked="checked"' : ''; ?> autocomplete="off" value="0" type="radio"> <?php echo $text_no; ?>
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-12 control-label" for="input-reviewcouponpurchaseonly"><span data-toggle="tooltip" title="<?php echo $help_reviewcouponpurchaseonly; ?>"><?php echo $entry_reviewcouponpurchaseonly; ?></span></label>
                      <div class="col-sm-12">
                        <div class="btn-group" data-toggle="buttons">
                          <label class="btn btn-default <?php echo $cireviewpro_reviewcouponpurchaseonly ? 'active' : ''; ?>">
                            <input name="cireviewpro_reviewcouponpurchaseonly" <?php echo $cireviewpro_reviewcouponpurchaseonly ? 'checked="checked"' : ''; ?> autocomplete="off" value="1" type="radio"><?php echo $text_yes; ?>
                          </label>
                          <label class="btn btn-default <?php echo !$cireviewpro_reviewcouponpurchaseonly ? 'active' : ''; ?>">
                            <input name="cireviewpro_reviewcouponpurchaseonly" <?php echo !$cireviewpro_reviewcouponpurchaseonly ? 'checked="checked"' : ''; ?> autocomplete="off" value="0" type="radio"> <?php echo $text_no; ?>
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-12 control-label" for="input-reviewcoupontype"><span data-toggle="tooltip" title="<?php echo $help_reviewcoupontype; ?>"><?php echo $entry_reviewcoupontype; ?></span></label>
                      <div class="col-sm-12">
                        <select name="cireviewpro_reviewcoupontype" id="input-reviewcoupontype" class="form-control">
                          <?php if ($cireviewpro_reviewcoupontype == 'P') { ?>
                          <option value="P" selected="selected"><?php echo $text_percent; ?></option>
                          <?php } else { ?>
                          <option value="P"><?php echo $text_percent; ?></option>
                          <?php } ?>
                          <?php if ($cireviewpro_reviewcoupontype == 'F') { ?>
                          <option value="F" selected="selected"><?php echo $text_amount; ?></option>
                          <?php } else { ?>
                          <option value="F"><?php echo $text_amount; ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-12 control-label" for="input-reviewcoupondiscount"><?php echo $entry_reviewcoupondiscount; ?></label>
                      <div class="col-sm-12">
                        <input type="text" name="cireviewpro_reviewcoupondiscount" value="<?php echo $cireviewpro_reviewcoupondiscount; ?>" placeholder="<?php echo $entry_reviewcoupondiscount; ?>" id="input-reviewcoupondiscount" class="form-control" />
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-12 control-label" for="input-reviewcoupondays"><span data-toggle="tooltip" title="<?php echo $help_reviewcoupondays; ?>"><?php echo $entry_reviewcoupondays; ?></span></label>
                      <div class="col-sm-12">
                        <input type="text" name="cireviewpro_reviewcoupondays" value="<?php echo $cireviewpro_reviewcoupondays; ?>" placeholder="<?php echo $entry_reviewcoupondays; ?>" id="input-reviewcoupondays" class="form-control" />
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-12 control-label" for="input-reviewcoupontotal"><span data-toggle="tooltip" title="<?php echo $help_reviewcoupontotal; ?>"><?php echo $entry_reviewcoupontotal; ?></span></label>
                      <div class="col-sm-12">
                        <input type="text" name="cireviewpro_reviewcoupontotal" value="<?php echo $cireviewpro_reviewcoupontotal; ?>" placeholder="<?php echo $entry_reviewcoupontotal; ?>" id="input-reviewcoupontotal" class="form-control" />
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-12 control-label"><span data-toggle="tooltip" title="<?php echo $help_reviewcouponlogged; ?>"><?php echo $entry_reviewcouponlogged; ?></span></label>
                      <div class="col-sm-12">
                        <div class="btn-group" data-toggle="buttons">
                          <label class="btn btn-default <?php echo $cireviewpro_reviewcouponlogged ? 'active' : ''; ?>">
                            <input name="cireviewpro_reviewcouponlogged" <?php echo $cireviewpro_reviewcouponlogged ? 'checked="checked"' : ''; ?> autocomplete="off" value="1" type="radio"><?php echo $text_yes; ?>
                          </label>
                          <label class="btn btn-default <?php echo !$cireviewpro_reviewcouponlogged ? 'active' : ''; ?>">
                            <input name="cireviewpro_reviewcouponlogged" <?php echo !$cireviewpro_reviewcouponlogged ? 'checked="checked"' : ''; ?> autocomplete="off" value="0" type="radio"> <?php echo $text_no; ?>
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-12 control-label"><?php echo $entry_reviewcouponshipping; ?></label>
                      <div class="col-sm-12">
                        <div class="btn-group" data-toggle="buttons">
                          <label class="btn btn-default <?php echo $cireviewpro_reviewcouponshipping ? 'active' : ''; ?>">
                            <input name="cireviewpro_reviewcouponshipping" <?php echo $cireviewpro_reviewcouponshipping ? 'checked="checked"' : ''; ?> autocomplete="off" value="1" type="radio"><?php echo $text_yes; ?>
                          </label>
                          <label class="btn btn-default <?php echo !$cireviewpro_reviewcouponshipping ? 'active' : ''; ?>">
                            <input name="cireviewpro_reviewcouponshipping" <?php echo !$cireviewpro_reviewcouponshipping ? 'checked="checked"' : ''; ?> autocomplete="off" value="0" type="radio"> <?php echo $text_no; ?>
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-12 control-label" for="input-reviewcouponproduct"><span data-toggle="tooltip" title="<?php echo $help_reviewcouponproduct; ?>"><?php echo $entry_reviewcouponproduct; ?></span></label>
                      <div class="col-sm-12">
                        <input type="text" name="cireviewpro_reviewcouponproduct" value="" placeholder="<?php echo $entry_reviewcouponproduct; ?>" id="input-reviewcouponproduct" class="form-control" />
                        <div id="reviewcouponproduct" class="well well-sm" style="height: 150px; overflow: auto;">
                          <?php foreach ($cireviewpro_reviewcoupon_products as $cireviewpro_reviewcoupon_product) { ?>
                          <div id="reviewcouponproduct<?php echo $cireviewpro_reviewcoupon_product['product_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $cireviewpro_reviewcoupon_product['name']; ?>
                            <input type="hidden" name="cireviewpro_reviewcoupon_product[]" value="<?php echo $cireviewpro_reviewcoupon_product['product_id']; ?>" />
                          </div>
                          <?php } ?>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-12 control-label" for="input-reviewcouponcategory"><span data-toggle="tooltip" title="<?php echo $help_reviewcouponcategory; ?>"><?php echo $entry_reviewcouponcategory; ?></span></label>
                      <div class="col-sm-12">
                        <input type="text" name="cireviewpro_reviewcouponcategory" value="" placeholder="<?php echo $entry_reviewcouponcategory; ?>" id="input-reviewcouponcategory" class="form-control" />
                        <div id="reviewcouponcategory" class="well well-sm" style="height: 150px; overflow: auto;">
                          <?php foreach ($cireviewpro_reviewcoupon_categories as $cireviewpro_reviewcoupon_category) { ?>
                          <div id="reviewcouponcategory<?php echo $cireviewpro_reviewcoupon_category['category_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $cireviewpro_reviewcoupon_category['name']; ?>
                            <input type="hidden" name="cireviewpro_reviewcoupon_category[]" value="<?php echo $cireviewpro_reviewcoupon_category['category_id']; ?>" />
                          </div>
                          <?php } ?>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-12 control-label" for="input-reviewcouponuses-total"><span data-toggle="tooltip" title="<?php echo $help_reviewcouponuses_total; ?>"><?php echo $entry_reviewcouponuses_total; ?></span></label>
                      <div class="col-sm-12">
                        <input type="text" name="cireviewpro_reviewcouponuses_total" value="<?php echo $cireviewpro_reviewcouponuses_total; ?>" placeholder="<?php echo $entry_reviewcouponuses_total; ?>" id="input-reviewcouponuses-total" class="form-control" />
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-12 control-label" for="input-reviewcouponuses-customer"><span data-toggle="tooltip" title="<?php echo $help_reviewcouponuses_customer; ?>"><?php echo $entry_reviewcouponuses_customer; ?></span></label>
                      <div class="col-sm-12">
                        <input type="text" name="cireviewpro_reviewcouponuses_customer" value="<?php echo $cireviewpro_reviewcouponuses_customer; ?>" placeholder="<?php echo $entry_reviewcouponuses_customer; ?>" id="input-reviewcouponuses-customer" class="form-control" />
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane" id="tab-general-option-reward">
                    <div class="form-group">
                      <label class="col-sm-12 control-label" for="input-reviewreward"><?php echo $entry_reviewreward; ?></label>
                      <div class="col-sm-12">
                        <div class="btn-group" data-toggle="buttons">
                          <label class="btn btn-default <?php echo $cireviewpro_reviewreward ? 'active' : ''; ?>">
                            <input name="cireviewpro_reviewreward" <?php echo $cireviewpro_reviewreward ? 'checked="checked"' : ''; ?> autocomplete="off" value="1" type="radio"><?php echo $text_yes; ?>
                          </label>
                          <label class="btn btn-default <?php echo !$cireviewpro_reviewreward ? 'active' : ''; ?>">
                            <input name="cireviewpro_reviewreward" <?php echo !$cireviewpro_reviewreward ? 'checked="checked"' : ''; ?> autocomplete="off" value="0" type="radio"> <?php echo $text_no; ?>
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-12 control-label" for="input-reviewrewardpurchaseonly"><span data-toggle="tooltip" title="<?php echo $help_reviewrewardpurchaseonly; ?>"><?php echo $entry_reviewrewardpurchaseonly; ?></span></label>
                      <div class="col-sm-12">
                        <div class="btn-group" data-toggle="buttons">
                          <label class="btn btn-default <?php echo $cireviewpro_reviewrewardpurchaseonly ? 'active' : ''; ?>">
                            <input name="cireviewpro_reviewrewardpurchaseonly" <?php echo $cireviewpro_reviewrewardpurchaseonly ? 'checked="checked"' : ''; ?> autocomplete="off" value="1" type="radio"><?php echo $text_yes; ?>
                          </label>
                          <label class="btn btn-default <?php echo !$cireviewpro_reviewrewardpurchaseonly ? 'active' : ''; ?>">
                            <input name="cireviewpro_reviewrewardpurchaseonly" <?php echo !$cireviewpro_reviewrewardpurchaseonly ? 'checked="checked"' : ''; ?> autocomplete="off" value="0" type="radio"> <?php echo $text_no; ?>
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-12 control-label" for="input-rewardpoints"><?php echo $entry_rewardpoints; ?></label>
                      <div class="col-sm-12">
                        <input name="cireviewpro_rewardpoints" value="<?php echo $cireviewpro_rewardpoints; ?>" placeholder="<?php echo $entry_rewardpoints; ?>" id="input-rewardpoints" class="form-control" type="text" />
                        <?php if ($error_cireviewpro_rewardpoints) { ?>
                        <div class="text-danger"><?php echo $error_cireviewpro_rewardpoints; ?></div>
                        <?php } ?>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-12 control-label" for="input-rewarddesc"><?php echo $entry_rewarddesc; ?></label>
                      <div class="col-sm-12">
                        <input name="cireviewpro_rewarddesc" value="<?php echo $cireviewpro_rewarddesc; ?>" placeholder="<?php echo $entry_rewarddesc; ?>" id="input-rewardpoints" class="form-control" type="text" />
                      </div>
                    </div>
                  </div>
                  
                  <div class="tab-pane" id="tab-general-option-rewardsuccess">
                    <div class="form-group">
                      <label class="col-sm-12 control-label" for="input-rewardsuccessalert"><?php echo $entry_rewardsuccessalert; ?></label>
                      <div class="col-sm-12">
                        <div class="btn-group" data-toggle="buttons">
                          <label class="btn btn-default <?php echo $cireviewpro_rewardsuccessalert=='DEFAULT' ? 'active' : ''; ?>">
                            <input name="cireviewpro_rewardsuccessalert" <?php echo $cireviewpro_rewardsuccessalert=='DEFAULT' ? 'checked="checked"' : ''; ?> autocomplete="off" value="DEFAULT" type="radio"><?php echo $text_successdefault; ?>
                          </label>
                          <label class="btn btn-default <?php echo $cireviewpro_rewardsuccessalert=='POPUP' ? 'active' : ''; ?>">
                            <input name="cireviewpro_rewardsuccessalert" <?php echo $cireviewpro_rewardsuccessalert=='POPUP' ? 'checked="checked"' : ''; ?> autocomplete="off" value="POPUP" type="radio"> <?php echo $text_successpopup; ?>
                          </label>
                        </div>
                      </div>
                    </div>
                    <fieldset>
                      <legend><?php echo $legend_rewardsuccessmsg; ?></legend>
                      <br/>
                      <ul class="nav nav-tabs" id="review-successmsg-language">
                        <?php foreach ($languages as $language) { ?>
                        <li><a href="#review-successmsg-language<?php echo $language['language_id']; ?>" data-toggle="tab"><?php if(VERSION >= '2.2.0.0') { ?>
                          <img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" />
                        <?php } else { ?>
                          <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /><?php } ?> <?php echo $language['name']; ?></a></li>
                        <?php } ?>
                      </ul>
                      <div class="tab-content">
                        <?php foreach ($languages as $language) { ?>
                        <div class="tab-pane" id="review-successmsg-language<?php echo $language['language_id']; ?>">
                          <div class="form-group required review-successmsg-title">
                            <label class="col-sm-2 control-label" for="input-review-successmsg-title<?php echo $language['language_id']; ?>"><span data-toggle="tooltip" title="<?php echo $help_rewardsuccessmsg_title; ?>"><?php echo $entry_rewardsuccessmsg_title; ?></span></label>
                            <div class="col-sm-10">
                              <input type="text" name="cireviewpro_reviewsuccessmsg[<?php echo $language['language_id']; ?>][title]" value="<?php echo isset($cireviewpro_reviewsuccessmsg[$language['language_id']]) ? $cireviewpro_reviewsuccessmsg[$language['language_id']]['title'] : ''; ?>" placeholder="<?php echo $entry_rewardsuccessmsg_title; ?>" id="input-review-successmsg-title<?php echo $language['language_id']; ?>" class="form-control" />
                              <?php if (isset($error_reviewsuccessmsg['title'][$language['language_id']])) { ?>
                              <div class="text-danger"><?php echo $error_reviewsuccessmsg['title'][$language['language_id']]; ?></div>
                              <?php } ?>
                            </div>
                          </div>
                          <div class="form-group required">
                            <label class="col-sm-2 control-label" for="input-review-successmsg-message<?php echo $language['language_id']; ?>"><?php echo $entry_rewardsuccessmsg; ?></label>
                            <div class="col-sm-10">
                              <textarea name="cireviewpro_reviewsuccessmsg[<?php echo $language['language_id']; ?>][message]" rows="5" placeholder="<?php echo $entry_rewardsuccessmsg; ?>" id="input-review-successmsg-message<?php echo $language['language_id']; ?>" class="form-control summernote" data-toggle="summernote" data-lang=""><?php echo isset($cireviewpro_reviewsuccessmsg[$language['language_id']]) ? $cireviewpro_reviewsuccessmsg[$language['language_id']]['message'] : ''; ?></textarea>
                              <?php if (isset($error_reviewsuccessmsg['message'][$language['language_id']])) { ?>
                              <div class="text-danger"><?php echo $error_reviewsuccessmsg['message'][$language['language_id']]; ?></div>
                              <?php } ?>
                            </div>
                          </div>
                          <div class="form-group required">
                            <label class="col-sm-2 control-label" for="input-review-successmsg-messagepending<?php echo $language['language_id']; ?>"><?php echo $entry_rewardsuccessmsg_pending; ?></label>
                            <div class="col-sm-10">
                              <textarea name="cireviewpro_reviewsuccessmsg[<?php echo $language['language_id']; ?>][messagepending]" rows="5" placeholder="<?php echo $entry_rewardsuccessmsg_pending; ?>" id="input-review-successmsg-messagepending<?php echo $language['language_id']; ?>" class="form-control summernote" data-toggle="summernote" data-lang=""><?php echo isset($cireviewpro_reviewsuccessmsg[$language['language_id']]) ? $cireviewpro_reviewsuccessmsg[$language['language_id']]['messagepending'] : ''; ?></textarea>
                              <?php if (isset($error_reviewsuccessmsg['messagepending'][$language['language_id']])) { ?>
                              <div class="text-danger"><?php echo $error_reviewsuccessmsg['messagepending'][$language['language_id']]; ?></div>
                              <?php } ?>
                            </div>
                          </div>
                          <div class="form-group required review-successmsg-couponcode">
                            <label class="col-sm-2 control-label" for="input-review-successmsg-couponcode<?php echo $language['language_id']; ?>"><span data-toggle="tooltip" title="<?php echo $help_rewardsuccessmsg_couponcode; ?>"><?php echo $entry_rewardsuccessmsg_couponcode; ?></span></label>
                            <div class="col-sm-10">
                              <textarea name="cireviewpro_reviewsuccessmsg[<?php echo $language['language_id']; ?>][couponcode]" rows="5" placeholder="<?php echo $entry_rewardsuccessmsg_couponcode; ?>" id="input-review-successmsg-couponcode<?php echo $language['language_id']; ?>" class="form-control summernote" data-toggle="summernote" data-lang=""><?php echo isset($cireviewpro_reviewsuccessmsg[$language['language_id']]) ? $cireviewpro_reviewsuccessmsg[$language['language_id']]['couponcode'] : ''; ?></textarea>
                              <?php if (isset($error_reviewsuccessmsg['couponcode'][$language['language_id']])) { ?>
                              <div class="text-danger"><?php echo $error_reviewsuccessmsg['couponcode'][$language['language_id']]; ?></div>
                              <?php } ?>
                            </div>
                          </div>
                          <div class="form-group required review-successmsg-rewardpoints">
                            <label class="col-sm-2 control-label" for="input-review-successmsg-rewardpoints<?php echo $language['language_id']; ?>"><span data-toggle="tooltip" title="<?php echo $help_rewardsuccessmsg_rewardpoints; ?>"><?php echo $entry_rewardsuccessmsg_rewardpoints; ?></span> <br/> </label>
                            <div class="col-sm-10">
                              <textarea name="cireviewpro_reviewsuccessmsg[<?php echo $language['language_id']; ?>][rewardpoints]" rows="5" placeholder="<?php echo $entry_rewardsuccessmsg_rewardpoints; ?>" id="input-review-successmsg-rewardpoints<?php echo $language['language_id']; ?>" class="form-control summernote" data-toggle="summernote" data-lang=""><?php echo isset($cireviewpro_reviewsuccessmsg[$language['language_id']]) ? $cireviewpro_reviewsuccessmsg[$language['language_id']]['rewardpoints'] : ''; ?></textarea>
                              <?php if (isset($error_reviewsuccessmsg['rewardpoints'][$language['language_id']])) { ?>
                              <div class="text-danger"><?php echo $error_reviewsuccessmsg['rewardpoints'][$language['language_id']]; ?></div>
                              <?php } ?>
                            </div>
                          </div>
                        </div>
                        <?php } ?>
                      </div>
                    </fieldset>
                  </div>
                  
                </div>
              </div>
            </div>
            </div>
            <div class="tab-pane" id="tab-pageinfo">
              <div class="row">
                <div class="col-sm-9">
                  <ul class="nav nav-tabs" id="pageinfo">
                    <li class="active"><a href="#tab-review-list" data-toggle="tab"><i class="fa fa-image"></i> <?php echo $tab_review_list; ?></a></li>
                    <li><a href="#tab-promotion" data-toggle="tab"><i class="fa fa-tag"></i> <?php echo $tab_promotion; ?></a></li>
                    <li><a href="#tab-review-policy" data-toggle="tab"><i class="fa fa-info-circle"></i> <?php echo $tab_review_policy; ?></a></li>
                  </ul>
                  <div class="tab-content">
                    <div class="tab-pane active" id="tab-review-list">
                      <?php if(VERSION <= '2.3.0.2') { ?>
                      <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-review-list-keyword"><span data-toggle="tooltip" title="<?php echo $help_keyword; ?>"><?php echo $entry_keyword; ?></span></label>
                        <div class="col-sm-10">
                          <input type="text" name="cireviewpro_reviewlistpage_keyword" value="<?php echo $cireviewpro_reviewlistpage_keyword; ?>" placeholder="<?php echo $entry_keyword; ?>" id="input-review-list-keyword" class="form-control" />
                          <?php if ($error_cireviewpro_reviewlistpage_keyword) { ?>
                          <div class="text-danger"><?php echo $error_cireviewpro_reviewlistpage_keyword; ?></div>
                          <?php } ?>
                        </div>
                      </div>
                      <?php } else { ?>
                      <div class="alert alert-info"><i class="fa fa-info-circle"></i> <?php echo $text_keyword; ?></div>            
                      <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                          <thead>
                            <tr>
                              <td class="text-left"><?php echo $entry_store; ?></td>
                              <td class="text-left"><?php echo $entry_keyword; ?></td>
                            </tr>
                          </thead>
                          <tbody>
                          <?php foreach($all_stores as $store) { ?>
                          <?php if($store['store_id'] == $store_id) { ?>
                          <tr>
                            <td class="text-left"><?php echo $store['name']; ?></td>
                            <td class="text-left"><?php foreach($languages as $language) { ?>
                              <div class="input-group"><span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></span>
                                <input type="text" name="cireviewpro_reviewlistpage_keyword[<?php echo $store['store_id']; ?>][<?php echo $language['language_id']; ?>]" value="<?php echo isset($cireviewpro_reviewlistpage_keyword[$store['store_id']][$language['language_id']]) ? $cireviewpro_reviewlistpage_keyword[$store['store_id']][$language['language_id']] : ''; ?>" placeholder="<?php echo $entry_keyword; ?>" class="form-control" />
                              </div>
                              <?php if(isset($error_cireviewpro_reviewlistpage_keyword[$store['store_id']][$language['language_id']])) { ?>
                              <div class="text-danger"><?php echo $error_cireviewpro_reviewlistpage_keyword[$store['store_id']][$language['language_id']]; ?></div>
                              <?php } ?>
                              <?php } ?></td>
                          </tr>
                          <?php } ?>
                          <?php } ?>
                            </tbody>
                        </table>
                      </div>
                      <?php } ?>
                      <br/>
                      <hr/>
                      <ul class="nav nav-tabs" id="review-list-language">
                        <?php foreach ($languages as $language) { ?>
                        <li><a href="#review-list-language<?php echo $language['language_id']; ?>" data-toggle="tab"><?php if(VERSION >= '2.2.0.0') { ?>
                          <img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" />
                        <?php } else { ?>
                          <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /><?php } ?> <?php echo $language['name']; ?></a></li>
                        <?php } ?>
                      </ul>
                      <div class="tab-content">
                        <?php foreach ($languages as $language) { ?>
                        <div class="tab-pane" id="review-list-language<?php echo $language['language_id']; ?>">
                          <div class="form-group required">
                            <label class="col-sm-2 control-label" for="input-review-list-title<?php echo $language['language_id']; ?>"><?php echo $entry_title; ?></label>
                            <div class="col-sm-10">
                              <input type="text" name="cireviewpro_reviewlistpage[<?php echo $language['language_id']; ?>][title]" value="<?php echo isset($cireviewpro_reviewlistpage[$language['language_id']]) ? $cireviewpro_reviewlistpage[$language['language_id']]['title'] : ''; ?>" placeholder="<?php echo $entry_title; ?>" id="input-review-list-title<?php echo $language['language_id']; ?>" class="form-control" />
                              <?php if (isset($error_cireviewpro_reviewlistpage['title'][$language['language_id']])) { ?>
                              <div class="text-danger"><?php echo $error_cireviewpro_reviewlistpage['title'][$language['language_id']]; ?></div>
                              <?php } ?>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-2 control-label" for="input-review-list-message<?php echo $language['language_id']; ?>"><?php echo $entry_message; ?></label>
                            <div class="col-sm-10">
                              <textarea name="cireviewpro_reviewlistpage[<?php echo $language['language_id']; ?>][message]" rows="5" placeholder="<?php echo $entry_message; ?>" id="input-review-list-message<?php echo $language['language_id']; ?>" class="form-control summernote" data-toggle="summernote" data-lang=""><?php echo isset($cireviewpro_reviewlistpage[$language['language_id']]) ? $cireviewpro_reviewlistpage[$language['language_id']]['message'] : ''; ?></textarea>
                            </div>
                          </div>
                          <div class="form-group required">
                            <label class="col-sm-2 control-label" for="input-review-list-meta-title<?php echo $language['language_id']; ?>"><?php echo $entry_meta_title; ?></label>
                            <div class="col-sm-10">
                              <input type="text" name="cireviewpro_reviewlistpage[<?php echo $language['language_id']; ?>][meta_title]" value="<?php echo isset($cireviewpro_reviewlistpage[$language['language_id']]) ? $cireviewpro_reviewlistpage[$language['language_id']]['meta_title'] : ''; ?>" placeholder="<?php echo $entry_meta_title; ?>" id="input-review-list-meta-title<?php echo $language['language_id']; ?>" class="form-control" />
                              <?php if (isset($error_cireviewpro_reviewlistpage['meta_title'][$language['language_id']])) { ?>
                              <div class="text-danger"><?php echo $error_cireviewpro_reviewlistpage['meta_title'][$language['language_id']]; ?></div>
                              <?php } ?>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-2 control-label" for="input-review-list-meta-description<?php echo $language['language_id']; ?>"><?php echo $entry_meta_description; ?></label>
                            <div class="col-sm-10">
                              <textarea name="cireviewpro_reviewlistpage[<?php echo $language['language_id']; ?>][meta_description]" rows="5" placeholder="<?php echo $entry_meta_description; ?>" id="input-review-list-meta-description<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($cireviewpro_reviewlistpage[$language['language_id']]) ? $cireviewpro_reviewlistpage[$language['language_id']]['meta_description'] : ''; ?></textarea>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-2 control-label" for="input-review-list-meta-keyword<?php echo $language['language_id']; ?>"><?php echo $entry_meta_keyword; ?></label>
                            <div class="col-sm-10">
                              <textarea name="cireviewpro_reviewlistpage[<?php echo $language['language_id']; ?>][meta_keyword]" rows="5" placeholder="<?php echo $entry_meta_keyword; ?>" id="input-review-list-meta-keyword<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($cireviewpro_reviewlistpage[$language['language_id']]) ? $cireviewpro_reviewlistpage[$language['language_id']]['meta_keyword'] : ''; ?></textarea>
                            </div>
                          </div>
                        </div>
                        <?php } ?>
                      </div>
                    </div>
                    <div class="tab-pane" id="tab-promotion">
                      <fieldset>
                        <legend><?php echo $legend_product; ?></legend>
                        <div class="form-group">
                          <label class="col-sm-2 control-label" for="input-product"><span data-toggle="tooltip" title="<?php echo $help_product; ?>"><?php echo $entry_product; ?></span></label>
                          <div class="col-sm-10">
                            <input type="text" name="product" value="" placeholder="<?php echo $entry_product; ?>" id="input-product" class="form-control" />
                            <div id="cireviewpropage-product" class="well well-sm" style="height: 150px; overflow: auto;">
                              <?php foreach ($cireviewpro_products as $cireviewpro_product) { ?>
                              <div id="cireviewpropage-product<?php echo $cireviewpro_product['product_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $cireviewpro_product['name']; ?>
                                <input type="hidden" name="cireviewpro_product[]" value="<?php echo $cireviewpro_product['product_id']; ?>" />
                              </div>
                              <?php } ?>
                            </div>
                          </div>
                        </div>
                      </fieldset>
                      <fieldset>
                        <legend><?php echo $legend_category; ?></legend>
                        <div class="form-group">
                          <label class="col-sm-2 control-label" for="input-category"><span data-toggle="tooltip" title="<?php echo $help_category; ?>"><?php echo $entry_category; ?></span></label>
                          <div class="col-sm-10">
                            <input type="text" name="category" value="" placeholder="<?php echo $entry_category; ?>" id="input-category" class="form-control" />
                            <div id="cireviewpropage-category" class="well well-sm" style="height: 150px; overflow: auto;">
                              <?php foreach ($cireviewpro_categories as $cireviewpro_category) { ?>
                              <div id="cireviewpropage-category<?php echo $cireviewpro_category['category_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $cireviewpro_category['name']; ?>
                                <input type="hidden" name="cireviewpro_category[]" value="<?php echo $cireviewpro_category['category_id']; ?>" />
                              </div>
                              <?php } ?>
                            </div>
                          </div>
                        </div>
                      </fieldset>
                      <fieldset>
                        <legend><?php echo $legend_manufacturer; ?></legend>
                        <div class="form-group">
                          <label class="col-sm-2 control-label" for="input-manufacturer"><span data-toggle="tooltip" title="<?php echo $help_manufacturer; ?>"><?php echo $entry_manufacturer; ?></span></label>
                          <div class="col-sm-10">
                            <input type="text" name="manufacturer" value="" placeholder="<?php echo $entry_manufacturer; ?>" id="input-manufacturer" class="form-control" />
                            <div id="cireviewpropage-manufacturer" class="well well-sm" style="height: 150px; overflow: auto;">
                              <?php foreach ($cireviewpro_manufacturers as $cireviewpro_manufacturer) { ?>
                              <div id="cireviewpropage-manufacturer<?php echo $cireviewpro_manufacturer['manufacturer_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $cireviewpro_manufacturer['name']; ?>
                                <input type="hidden" name="cireviewpro_manufacturer[]" value="<?php echo $cireviewpro_manufacturer['manufacturer_id']; ?>" />
                              </div>
                              <?php } ?>
                            </div>
                          </div>
                        </div>
                      </fieldset>
                    </div>
                    
                    <div class="tab-pane" id="tab-review-policy">
                      <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo $entry_reviewpolicy; ?></label>
                          <div class="col-sm-10">
                            <div class="btn-group" data-toggle="buttons">
                              <label class="btn btn-default <?php echo $cireviewpro_reviewpolicy ? 'active' : ''; ?>">
                                <input name="cireviewpro_reviewpolicy" <?php echo $cireviewpro_reviewpolicy ? 'checked="checked"' : ''; ?> autocomplete="off" value="1" type="radio"><?php echo $text_yes; ?>
                              </label>
                              <label class="btn btn-default <?php echo !$cireviewpro_reviewpolicy ? 'active' : ''; ?>">
                                <input name="cireviewpro_reviewpolicy" <?php echo !$cireviewpro_reviewpolicy ? 'checked="checked"' : ''; ?> autocomplete="off" value="0" type="radio"> <?php echo $text_no; ?>
                              </label>
                            </div>
                          </div>
                      </div>
                      <div class="reviewpolicy">
                        <ul class="nav nav-tabs" id="review-policy-language">
                          <?php foreach ($languages as $language) { ?>
                          <li><a href="#review-policy-language<?php echo $language['language_id']; ?>" data-toggle="tab"><?php if(VERSION >= '2.2.0.0') { ?>
                            <img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" />
                          <?php } else { ?>
                            <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /><?php } ?> <?php echo $language['name']; ?></a></li>
                          <?php } ?>
                        </ul>
                        <div class="tab-content">
                          <?php foreach ($languages as $language) { ?>
                          <div class="tab-pane" id="review-policy-language<?php echo $language['language_id']; ?>">
                            <div class="form-group required">
                              <label class="col-sm-2 control-label" for="input-review-policy-title<?php echo $language['language_id']; ?>"><?php echo $entry_title; ?></label>
                              <div class="col-sm-10">
                                <input type="text" name="cireviewpro_reviewpolicypage[<?php echo $language['language_id']; ?>][title]" value="<?php echo isset($cireviewpro_reviewpolicypage[$language['language_id']]) ? $cireviewpro_reviewpolicypage[$language['language_id']]['title'] : ''; ?>" placeholder="<?php echo $entry_title; ?>" id="input-review-policy-title<?php echo $language['language_id']; ?>" class="form-control" />
                                <?php if (isset($error_cireviewpro_reviewpolicypage['title'][$language['language_id']])) { ?>
                                <div class="text-danger"><?php echo $error_cireviewpro_reviewpolicypage['title'][$language['language_id']]; ?></div>
                                <?php } ?>
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="col-sm-2 control-label" for="input-review-policy-message<?php echo $language['language_id']; ?>"><?php echo $entry_message; ?></label>
                              <div class="col-sm-10">
                                <textarea name="cireviewpro_reviewpolicypage[<?php echo $language['language_id']; ?>][message]" rows="5" placeholder="<?php echo $entry_message; ?>" id="input-review-policy-message<?php echo $language['language_id']; ?>" class="form-control summernote" data-toggle="summernote" data-lang=""><?php echo isset($cireviewpro_reviewpolicypage[$language['language_id']]) ? $cireviewpro_reviewpolicypage[$language['language_id']]['message'] : ''; ?></textarea>
                              </div>
                            </div> <?php /*
                            <div class="form-group required">
                              <label class="col-sm-2 control-label" for="input-review-policy-meta-title<?php echo $language['language_id']; ?>"><?php echo $entry_meta_title; ?></label>
                              <div class="col-sm-10">
                                <input type="text" name="cireviewpro_reviewpolicypage[<?php echo $language['language_id']; ?>][meta_title]" value="<?php echo isset($cireviewpro_reviewpolicypage[$language['language_id']]) ? $cireviewpro_reviewpolicypage[$language['language_id']]['meta_title'] : ''; ?>" placeholder="<?php echo $entry_meta_title; ?>" id="input-review-policy-meta-title<?php echo $language['language_id']; ?>" class="form-control" />
                                <?php if (isset($error_cireviewpro_reviewpolicypage['meta_title'][$language['language_id']])) { ?>
                                <div class="text-danger"><?php echo $error_cireviewpro_reviewpolicypage['meta_title'][$language['language_id']]; ?></div>
                                <?php } ?>
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="col-sm-2 control-label" for="input-review-policy-meta-description<?php echo $language['language_id']; ?>"><?php echo $entry_meta_description; ?></label>
                              <div class="col-sm-10">
                                <textarea name="cireviewpro_reviewpolicypage[<?php echo $language['language_id']; ?>][meta_description]" rows="5" placeholder="<?php echo $entry_meta_description; ?>" id="input-review-policy-meta-description<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($cireviewpro_reviewpolicypage[$language['language_id']]) ? $cireviewpro_reviewpolicypage[$language['language_id']]['meta_description'] : ''; ?></textarea>
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="col-sm-2 control-label" for="input-review-policy-meta-keyword<?php echo $language['language_id']; ?>"><?php echo $entry_meta_keyword; ?></label>
                              <div class="col-sm-10">
                                <textarea name="cireviewpro_reviewpolicypage[<?php echo $language['language_id']; ?>][meta_keyword]" rows="5" placeholder="<?php echo $entry_meta_keyword; ?>" id="input-review-policy-meta-keyword<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($cireviewpro_reviewpolicypage[$language['language_id']]) ? $cireviewpro_reviewpolicypage[$language['language_id']]['meta_keyword'] : ''; ?></textarea>
                              </div>
                            </div>*/ ?>
                          </div>
                          <?php } ?>
                        </div>
                      </div>
                    </div>
                    
                  </div>
                </div>
                <div class="col-sm-3">
                  <br>
                  <table class="table table-bordered">
                    <thead>
                      <tr><td><?php echo $const_names; ?></td><td><?php echo $const_short_codes; ?></td>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td><?php echo $const_product_name; ?></td><td>{PRODUCT_NAME}</td>
                      </tr>
                      <tr>
                        <td><?php echo $const_product_image; ?></td><td>{PRODUCT_IMAGE}</td>
                      </tr>
                      <tr>
                        <td><?php echo $const_product_description; ?></td><td>{PRODUCT_DESCRIPTION}</td>
                      </tr>
                      <tr>
                        <td><?php echo $const_product_link; ?></td><td>{PRODUCT_LINK}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="tab-pane" id="tab-email">
              <div class="row">
                <div class="col-sm-9">
                  <div class="form-group">
                    <label class="col-sm-12 control-label" for="input-mailproductimagethumb"><?php echo $entry_mailproductimagethumb; ?></label>
                    <div class="col-sm-12">
                      <div class="row">
                        <div class="col-sm-6">
                          <div class="input-group">
                          <input type="text" name="cireviewpro_mailproductimagethumb_width" value="<?php echo $cireviewpro_mailproductimagethumb_width; ?>" placeholder="<?php echo $text_width; ?>" id="input-mailproductimagethumb-width" class="form-control" />
                          <span class="input-group-btn">
                            <button type="button" class="btn btn-primary"><i class="fa fa-arrows-h"></i></button>
                          </span>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="input-group">
                          <input type="text" name="cireviewpro_mailproductimagethumb_height" value="<?php echo $cireviewpro_mailproductimagethumb_height; ?>" placeholder="<?php echo $text_height; ?>"  id="input-mailproductimagethumb-height" class="form-control" />
                          <span class="input-group-btn">
                            <button type="button" class="btn btn-primary"><i class="fa fa-arrows-v"></i></button>
                          </span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-12 control-label" for="input-maillogoimagethumb"><?php echo $entry_maillogoimagethumb; ?></label>
                    <div class="col-sm-12">
                      <div class="row">
                        <div class="col-sm-6">
                          <div class="input-group">
                          <input type="text" name="cireviewpro_maillogoimagethumb_width" value="<?php echo $cireviewpro_maillogoimagethumb_width; ?>" placeholder="<?php echo $text_width; ?>" id="input-maillogoimagethumb-width" class="form-control" />
                          <span class="input-group-btn">
                            <button type="button" class="btn btn-primary"><i class="fa fa-arrows-h"></i></button>
                          </span>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="input-group">
                          <input type="text" name="cireviewpro_maillogoimagethumb_height" value="<?php echo $cireviewpro_maillogoimagethumb_height; ?>" placeholder="<?php echo $text_height; ?>"  id="input-maillogoimagethumb-height" class="form-control" />
                          <span class="input-group-btn">
                            <button type="button" class="btn btn-primary"><i class="fa fa-arrows-v"></i></button>
                          </span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <br/>
                  <hr/>
                  <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab-customer-email" data-toggle="tab"><i class="fa fa-user"></i> <?php echo $tab_customeremail; ?></a></li>
                     <li><a href="#tab-admin-email" data-toggle="tab"><i class="fa fa-envelope-square"></i> <?php echo $tab_adminemail; ?></a></li>
                     <li><a href="#tab-mail-promotion" data-toggle="tab"><i class="fa fa-tag"></i> <?php echo $tab_mail_promotion; ?></a></li>
                  </ul>
                  <div class="tab-content">
                      <div class="tab-pane active" id="tab-customer-email">
                        <div class="form-group">
                          <label class="col-sm-2 control-label"><?php echo $entry_customersend; ?></label>
                            <div class="col-sm-10">
                              <div class="btn-group" data-toggle="buttons">
                                <label class="btn btn-default <?php echo $cireviewpro_customersend ? 'active' : ''; ?>">
                                  <input name="cireviewpro_customersend" <?php echo $cireviewpro_customersend ? 'checked="checked"' : ''; ?> autocomplete="off" value="1" type="radio"><?php echo $text_yes; ?>
                                </label>
                                <label class="btn btn-default <?php echo !$cireviewpro_customersend ? 'active' : ''; ?>">
                                  <input name="cireviewpro_customersend" <?php echo !$cireviewpro_customersend ? 'checked="checked"' : ''; ?> autocomplete="off" value="0" type="radio"> <?php echo $text_no; ?>
                                </label>
                              </div>
                            </div>
                        </div>
                        <div class="customeremail" style="<?php if (!$cireviewpro_customersend) { echo 'display: none;'; } ?>" >
                          <ul class="nav nav-tabs" id="customeremail">
                            <?php foreach ($languages as $language) { ?>
                            <li><a href="#customeremail<?php echo $language['language_id']; ?>" data-toggle="tab">
                            <?php if(VERSION >= '2.2.0.0') { ?>
                              <img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" />
                            <?php } else{ ?>
                              <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" />
                            <?php } ?> <?php echo $language['name']; ?></a></li>
                            <?php } ?>
                          </ul>
                          <div class="tab-content">
                            <?php foreach ($languages as $language) { ?>
                            <div class="tab-pane" id="customeremail<?php echo $language['language_id']; ?>">
                              <div class="form-group required">
                                <label class="col-sm-2 control-label" for="input-customertitle<?php echo $language['language_id']; ?>"><?php echo $entry_customertitle; ?></label>
                                <div class="col-sm-10">
                                  <input type="text" name="cireviewpro_customer[<?php echo $language['language_id']; ?>][customertitle]" rows="5" placeholder="<?php echo $entry_customertitle; ?>" id="input-customertitle<?php echo $language['language_id']; ?>" class="form-control" value="<?php echo isset($cireviewpro_customer[$language['language_id']]) ? $cireviewpro_customer[$language['language_id']]['customertitle'] : ''; ?>" />
                                  <?php if (isset($error_customertitle[$language['language_id']])) { ?>
                                  <div class="text-danger"><?php echo $error_customertitle[$language['language_id']]; ?></div>
                                  <?php } ?>
                                </div>
                              </div>
                              <div class="form-group required">
                                <label class="col-sm-2 control-label" for="input-customermessage<?php echo $language['language_id']; ?>"><?php echo $entry_customermessage; ?></label>
                                <div class="col-sm-10">
                                  <textarea name="cireviewpro_customer[<?php echo $language['language_id']; ?>][customermessage]" rows="5" placeholder="<?php echo $entry_customermessage; ?>" id="input-customermessage<?php echo $language['language_id']; ?>" class="form-control summernote" data-toggle="summernote" data-lang=""><?php echo isset($cireviewpro_customer[$language['language_id']]) ? $cireviewpro_customer[$language['language_id']]['customermessage'] : ''; ?></textarea>
                                  <?php if (isset($error_customermessage[$language['language_id']])) { ?>
                                  <div class="text-danger"><?php echo $error_customermessage[$language['language_id']]; ?></div>
                                  <?php } ?>
                                </div>
                              </div>
                            </div>
                            <?php } ?>
                          </div>
                        </div>
                      </div>
                      <div class="tab-pane" id="tab-mail-promotion">
                        <fieldset>
                          <legend><?php echo $legend_product; ?></legend>
                          <div class="form-group">
                            <label class="col-sm-2 control-label" for="input-mailproduct"><span data-toggle="tooltip" title="<?php echo $help_product; ?>"><?php echo $entry_product; ?></span></label>
                            <div class="col-sm-10">
                              <input type="text" name="mailproduct" value="" placeholder="<?php echo $entry_product; ?>" id="input-mailproduct" class="form-control" />
                              <div id="cireviewpropage-mailproduct" class="well well-sm" style="height: 150px; overflow: auto;">
                                <?php foreach ($cireviewpro_mailproducts as $cireviewpro_mailproduct) { ?>
                                <div id="cireviewpropage-mailproduct<?php echo $cireviewpro_mailproduct['product_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $cireviewpro_mailproduct['name']; ?>
                                  <input type="hidden" name="cireviewpro_mailproduct[]" value="<?php echo $cireviewpro_mailproduct['product_id']; ?>" />
                                </div>
                                <?php } ?>
                              </div>
                            </div>
                          </div>
                        </fieldset>
                        <fieldset>
                          <legend><?php echo $legend_category; ?></legend>
                          <div class="form-group">
                            <label class="col-sm-2 control-label" for="input-mailcategory"><span data-toggle="tooltip" title="<?php echo $help_category; ?>"><?php echo $entry_category; ?></span></label>
                            <div class="col-sm-10">
                              <input type="text" name="mailcategory" value="" placeholder="<?php echo $entry_category; ?>" id="input-mailcategory" class="form-control" />
                              <div id="cireviewpropage-mailcategory" class="well well-sm" style="height: 150px; overflow: auto;">
                                <?php foreach ($cireviewpro_mailcategories as $cireviewpro_mailcategory) { ?>
                                <div id="cireviewpropage-mailcategory<?php echo $cireviewpro_mailcategory['category_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $cireviewpro_mailcategory['name']; ?>
                                  <input type="hidden" name="cireviewpro_mailcategory[]" value="<?php echo $cireviewpro_mailcategory['category_id']; ?>" />
                                </div>
                                <?php } ?>
                              </div>
                            </div>
                          </div>
                        </fieldset>
                        <fieldset>
                          <legend><?php echo $legend_manufacturer; ?></legend>
                          <div class="form-group">
                            <label class="col-sm-2 control-label" for="input-mailmanufacturer"><span data-toggle="tooltip" title="<?php echo $help_manufacturer; ?>"><?php echo $entry_manufacturer; ?></span></label>
                            <div class="col-sm-10">
                              <input type="text" name="mailmanufacturer" value="" placeholder="<?php echo $entry_manufacturer; ?>" id="input-mailmanufacturer" class="form-control" />
                              <div id="cireviewpropage-mailmanufacturer" class="well well-sm" style="height: 150px; overflow: auto;">
                                <?php foreach ($cireviewpro_mailmanufacturers as $cireviewpro_mailmanufacturer) { ?>
                                <div id="cireviewpropage-mailmanufacturer<?php echo $cireviewpro_mailmanufacturer['manufacturer_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $cireviewpro_mailmanufacturer['name']; ?>
                                  <input type="hidden" name="cireviewpro_mailmanufacturer[]" value="<?php echo $cireviewpro_mailmanufacturer['manufacturer_id']; ?>" />
                                </div>
                                <?php } ?>
                              </div>
                            </div>
                          </div>
                        </fieldset>
                      </div>
                      <div class="tab-pane" id="tab-admin-email">
                        <div class="form-group">
                          <label class="col-sm-2 control-label"><?php echo $entry_adminsend; ?></label>
                            <div class="col-sm-10">
                              <div class="btn-group" data-toggle="buttons">
                                <label class="btn btn-default <?php echo $cireviewpro_adminsend ? 'active' : ''; ?>">
                                  <input name="cireviewpro_adminsend" <?php echo $cireviewpro_adminsend ? 'checked="checked"' : ''; ?> autocomplete="off" value="1" type="radio"><?php echo $text_yes; ?>
                                </label>
                                <label class="btn btn-default <?php echo !$cireviewpro_adminsend ? 'active' : ''; ?>">
                                  <input name="cireviewpro_adminsend" <?php echo !$cireviewpro_adminsend ? 'checked="checked"' : ''; ?> autocomplete="off" value="0" type="radio"> <?php echo $text_no; ?>
                                </label>
                              </div>
                            </div>
                        </div>
                        <div class="adminemail" style="<?php if (!$cireviewpro_adminsend) { echo 'display: none;'; } ?>">
                          <div class="form-group">
                            <label class="col-sm-2 control-label" for="input-adminmail"><?php echo $entry_adminmail; ?></label>
                            <div class="col-sm-10">
                              <input type="text" name="cireviewpro_adminmail" placeholder="<?php echo $entry_adminmail; ?>" id="input-adminmail" class="form-control" value="<?php echo $cireviewpro_adminmail; ?>" />
                            </div>
                          </div>
                          <ul class="nav nav-tabs" id="adminemail">
                            <?php foreach ($languages as $language) { ?>
                            <li><a href="#adminemail<?php echo $language['language_id']; ?>" data-toggle="tab">
                              <?php if(VERSION >= '2.2.0.0') { ?>
                              <img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" />
                            <?php } else{ ?>
                              <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" />
                            <?php } ?> <?php echo $language['name']; ?></a></li>
                            <?php } ?>
                          </ul>
                          <div class="tab-content">
                            <?php foreach ($languages as $language) { ?>
                            <div class="tab-pane" id="adminemail<?php echo $language['language_id']; ?>">
                              <div class="form-group required">
                                <label class="col-sm-2 control-label" for="input-admintitle<?php echo $language['language_id']; ?>"><?php echo $entry_admintitle; ?></label>
                                <div class="col-sm-10">
                                  <input type="text" name="cireviewpro_admin[<?php echo $language['language_id']; ?>][admintitle]" rows="5" placeholder="<?php echo $entry_admintitle; ?>" id="input-admintitle<?php echo $language['language_id']; ?>" class="form-control" value="<?php echo isset($cireviewpro_admin[$language['language_id']]) ? $cireviewpro_admin[$language['language_id']]['admintitle'] : ''; ?>" />
                                  <?php if (isset($error_admintitle[$language['language_id']])) { ?>
                                  <div class="text-danger"><?php echo $error_admintitle[$language['language_id']]; ?></div>
                                  <?php } ?>
                                </div>
                              </div>
                              <div class="form-group required">
                                <label class="col-sm-2 control-label" for="input-adminmessage<?php echo $language['language_id']; ?>"><?php echo $entry_adminmessage; ?></label>
                                <div class="col-sm-10">
                                  <textarea name="cireviewpro_admin[<?php echo $language['language_id']; ?>][adminmessage]" rows="5" placeholder="<?php echo $entry_adminmessage; ?>" id="input-adminmessage<?php echo $language['language_id']; ?>" class="form-control summernote" data-toggle="summernote" data-lang=""><?php echo isset($cireviewpro_admin[$language['language_id']]) ? $cireviewpro_admin[$language['language_id']]['adminmessage'] : ''; ?></textarea>
                                  <?php if (isset($error_adminmessage[$language['language_id']])) { ?>
                                  <div class="text-danger"><?php echo $error_adminmessage[$language['language_id']]; ?></div>
                                  <?php } ?>
                                </div>
                              </div>
                            </div>
                            <?php } ?>
                          </div>
                        </div>
                      </div>
                  </div>
                </div>
                <div class="col-sm-3">
                  <br>
                  <table class="table table-bordered">
                    <thead>
                      <tr><td><?php echo $const_names; ?></td><td><?php echo $const_short_codes; ?></td>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td><?php echo $const_product_name; ?></td><td>{PRODUCT_NAME}</td>
                      </tr>
                      <tr>
                        <td><?php echo $const_product_image; ?></td><td>{PRODUCT_IMAGE}</td>
                      </tr>
                      <tr>
                        <td><?php echo $const_product_description; ?></td><td>{PRODUCT_DESCRIPTION}</td>
                      </tr>
                      <tr>
                        <td><?php echo $const_product_link; ?></td><td>{PRODUCT_LINK}</td>
                      </tr>
                    </tbody>
                    <thead>
                      <tr><td><?php echo $const_names; ?></td><td><?php echo $const_short_codes; ?></td>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td><?php echo $const_logo; ?></td><td>{LOGO}</td>
                      </tr>
                      <tr>
                        <td><?php echo $const_store_name; ?></td><td>{STORE_NAME}</td>
                      </tr>
                      <tr>
                        <td><?php echo $const_store_link; ?></td><td>{STORE_LINK}</td>
                      </tr>
                    </tbody>
                    <thead>
                      <tr><td><?php echo $const_names; ?></td><td><?php echo $const_short_codes; ?></td>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td><?php echo $const_review_author; ?></td><td>{REVIEW_AUTHOR}</td>
                      </tr>
                      <tr>
                        <td><?php echo $const_review_email; ?></td><td>{REVIEW_EMAIL}</td>
                      </tr>
                      <tr>
                        <td><?php echo $const_review_title; ?></td><td>{REVIEW_TITLE}</td>
                      </tr>
                      <tr>
                        <td><?php echo $const_review_text; ?></td><td>{REVIEW_TEXT}</td>
                      </tr>
                      <tr>
                        <td><?php echo $const_review_rating; ?></td><td>{REVIEW_RATING}</td>
                      </tr>
                      <tr>
                        <td><?php echo $const_review_ratings; ?></td><td>{REVIEW_ALL_RATING}</td>
                      </tr>
                      <tr>
                        <td><?php echo $const_review_attachment; ?></td><td>{REVIEW_ATTACHMENT}</td>
                      </tr>
                      <tr>
                        <td><?php echo $const_review_link; ?></td><td>{REVIEW_LINK}</td>
                      </tr>
                    </tbody>
                    <thead>
                      <tr><td><?php echo $const_names; ?></td><td><?php echo $const_short_codes; ?></td>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td><?php echo $const_promo_product; ?></td><td>{PROMO_PRODUCT}</td>
                      </tr>
                      <tr>
                        <td><?php echo $const_promo_category; ?></td><td>{PROMO_CATEGORY}</td>
                      </tr>
                      <tr>
                        <td><?php echo $const_promo_manufacturer; ?></td><td>{PROMO_MANUFACTURER}</td>
                      </tr>
                    </tbody>
                    <thead>
                      <tr><td><?php echo $const_names; ?></td><td><?php echo $const_short_codes; ?></td>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td><?php echo $const_coupon_code; ?></td><td>{COUPON_CODE}</td>
                      </tr>
                      <tr>
                        <td><?php echo $const_reward_points; ?></td><td>{REWARD_POINTS}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="tab-pane" id="tab-css">
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-cireviewpro-custom"><span data-toggle="tooltip" title="<?php echo $help_customcss; ?>"><?php echo $entry_customcss; ?></span></label>
                  <div class="col-sm-10">
                    <textarea name="cireviewpro_customcss" rows="10" placeholder="<?php echo $entry_customcss; ?>" id="input-cireviewpro-custom" class="form-control"><?php echo $cireviewpro_customcss; ?></textarea>
                  </div>
              </div>
            </div>
            <?php /* CodingInspect Support Starts */ ?>
            <div class="tab-pane text-center" id="tab-support">
              <div class="support-wrap">
                <i class="fa fa-life-ring" aria-hidden="true"></i>
                <div class="ciinfo">
                  <h4>For any type of support please contact us at</h4>
                  <h3>codinginspect@gmail.com</h3>
                </div>
              </div>
            </div>
            <?php /* CodingInspect Support Ends */ ?>
          </div>
        </form>
      </div>
    </div>
  </div>
<?php if(VERSION <= '2.2.0.0') { ?>
<script type="text/javascript"><!--
<?php foreach ($languages as $language) { ?>
$('#input-review-page-message<?php echo $language['language_id']; ?>').summernote({ height: 300 });
$('#input-review-success-message<?php echo $language['language_id']; ?>').summernote({ height: 300 });
$('#input-customermessage<?php echo $language['language_id']; ?>').summernote({ height: 300 });
$('#input-adminmessage<?php echo $language['language_id']; ?>').summernote({ height: 300 });
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
// Product
$('input[name=\'product\']').autocomplete({
  'source': function(request, response) {
    $.ajax({
      url: 'index.php?route=catalog/product/autocomplete&<?php echo $module_token; ?>=<?php echo $ci_token; ?>&filter_name=' +  encodeURIComponent(request),
      dataType: 'json',
      success: function(json) {
        response($.map(json, function(item) {
          return {
            label: item['name'],
            value: item['product_id']
          }
        }));
      }
    });
  },
  'select': function(item) {
    $('input[name=\'product\']').val('');
    $('#cireviewpropage-product' + item['value']).remove();
    $('#cireviewpropage-product').append('<div id="cireviewpropage-product' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="cireviewpro_product[]" value="' + item['value'] + '" /></div>');
  }
});
$('#cireviewpropage-product').delegate('.fa-minus-circle', 'click', function() {
  $(this).parent().remove();
});
// Category
$('input[name=\'category\']').autocomplete({
  'source': function(request, response) {
    $.ajax({
      url: 'index.php?route=catalog/category/autocomplete&<?php echo $module_token; ?>=<?php echo $ci_token; ?>&filter_name=' +  encodeURIComponent(request),
      dataType: 'json',
      success: function(json) {
        response($.map(json, function(item) {
          return {
            label: item['name'],
            value: item['category_id']
          }
        }));
      }
    });
  },
  'select': function(item) {
    $('input[name=\'category\']').val('');
    $('#cireviewpropage-category' + item['value']).remove();
    $('#cireviewpropage-category').append('<div id="cireviewpropage-category' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="cireviewpro_category[]" value="' + item['value'] + '" /></div>');
  }
});
$('#cireviewpropage-category').delegate('.fa-minus-circle', 'click', function() {
  $(this).parent().remove();
});
// Manufacturer
$('input[name=\'manufacturer\']').autocomplete({
  'source': function(request, response) {
    $.ajax({
      url: 'index.php?route=catalog/manufacturer/autocomplete&<?php echo $module_token; ?>=<?php echo $ci_token; ?>&filter_name=' +  encodeURIComponent(request),
      dataType: 'json',
      success: function(json) {
        response($.map(json, function(item) {
          return {
            label: item['name'],
            value: item['manufacturer_id']
          }
        }));
      }
    });
  },
  'select': function(item) {
    $('input[name=\'manufacturer\']').val('');
    $('#cireviewpropage-manufacturer' + item['value']).remove();
    $('#cireviewpropage-manufacturer').append('<div id="cireviewpropage-manufacturer' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="cireviewpro_manufacturer[]" value="' + item['value'] + '" /></div>');
  }
});
$('#cireviewpropage-manufacturer').delegate('.fa-minus-circle', 'click', function() {
  $(this).parent().remove();
});
//--></script>
<script type="text/javascript"><!--
$('input[name=\'cireviewpro_reviewcouponproduct\']').autocomplete({
  'source': function(request, response) {
    $.ajax({
      url: 'index.php?route=catalog/product/autocomplete&<?php echo $module_token; ?>=<?php echo $ci_token; ?>&filter_name=' +  encodeURIComponent(request),
      dataType: 'json',
      success: function(json) {
        response($.map(json, function(item) {
          return {
            label: item['name'],
            value: item['product_id']
          }
        }));
      }
    });
  },
  'select': function(item) {
    $('input[name=\'cireviewpro_reviewcouponproduct\']').val('');
    $('#reviewcouponproduct' + item['value']).remove();
    $('#reviewcouponproduct').append('<div id="reviewcouponproduct' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="cireviewpro_reviewcoupon_product[]" value="' + item['value'] + '" /></div>');
  }
});
$('#reviewcouponproduct').delegate('.fa-minus-circle', 'click', function() {
  $(this).parent().remove();
});
// Category
$('input[name=\'cireviewpro_reviewcouponcategory\']').autocomplete({
  'source': function(request, response) {
    $.ajax({
      url: 'index.php?route=catalog/category/autocomplete&<?php echo $module_token; ?>=<?php echo $ci_token; ?>&filter_name=' +  encodeURIComponent(request),
      dataType: 'json',
      success: function(json) {
        response($.map(json, function(item) {
          return {
            label: item['name'],
            value: item['category_id']
          }
        }));
      }
    });
  },
  'select': function(item) {
    $('input[name=\'cireviewpro_reviewcouponcategory\']').val('');
    $('#reviewcouponcategory' + item['value']).remove();
    $('#reviewcouponcategory').append('<div id="reviewcouponcategory' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="cireviewpro_reviewcoupon_category[]" value="' + item['value'] + '" /></div>');
  }
});
$('#reviewcouponcategory').delegate('.fa-minus-circle', 'click', function() {
  $(this).parent().remove();
});
//--></script>
<script type="text/javascript"><!--
// MailProduct
$('input[name=\'mailproduct\']').autocomplete({
  'source': function(request, response) {
    $.ajax({
      url: 'index.php?route=catalog/product/autocomplete&<?php echo $module_token; ?>=<?php echo $ci_token; ?>&filter_name=' +  encodeURIComponent(request),
      dataType: 'json',
      success: function(json) {
        response($.map(json, function(item) {
          return {
            label: item['name'],
            value: item['product_id']
          }
        }));
      }
    });
  },
  'select': function(item) {
    $('input[name=\'mailproduct\']').val('');
    $('#cireviewpropage-mailproduct' + item['value']).remove();
    $('#cireviewpropage-mailproduct').append('<div id="cireviewpropage-mailproduct' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="cireviewpro_mailproduct[]" value="' + item['value'] + '" /></div>');
  }
});
$('#cireviewpropage-mailproduct').delegate('.fa-minus-circle', 'click', function() {
  $(this).parent().remove();
});
// MailCategory
$('input[name=\'mailcategory\']').autocomplete({
  'source': function(request, response) {
    $.ajax({
      url: 'index.php?route=catalog/category/autocomplete&<?php echo $module_token; ?>=<?php echo $ci_token; ?>&filter_name=' +  encodeURIComponent(request),
      dataType: 'json',
      success: function(json) {
        response($.map(json, function(item) {
          return {
            label: item['name'],
            value: item['category_id']
          }
        }));
      }
    });
  },
  'select': function(item) {
    $('input[name=\'mailcategory\']').val('');
    $('#cireviewpropage-mailcategory' + item['value']).remove();
    $('#cireviewpropage-mailcategory').append('<div id="cireviewpropage-mailcategory' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="cireviewpro_mailcategory[]" value="' + item['value'] + '" /></div>');
  }
});
$('#cireviewpropage-mailcategory').delegate('.fa-minus-circle', 'click', function() {
  $(this).parent().remove();
});
// MailManufacturer
$('input[name=\'mailmanufacturer\']').autocomplete({
  'source': function(request, response) {
    $.ajax({
      url: 'index.php?route=catalog/manufacturer/autocomplete&<?php echo $module_token; ?>=<?php echo $ci_token; ?>&filter_name=' +  encodeURIComponent(request),
      dataType: 'json',
      success: function(json) {
        response($.map(json, function(item) {
          return {
            label: item['name'],
            value: item['manufacturer_id']
          }
        }));
      }
    });
  },
  'select': function(item) {
    $('input[name=\'mailmanufacturer\']').val('');
    $('#cireviewpropage-mailmanufacturer' + item['value']).remove();
    $('#cireviewpropage-mailmanufacturer').append('<div id="cireviewpropage-mailmanufacturer' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="cireviewpro_mailmanufacturer[]" value="' + item['value'] + '" /></div>');
  }
});
$('#cireviewpropage-mailmanufacturer').delegate('.fa-minus-circle', 'click', function() {
  $(this).parent().remove();
});
//--></script>
<script type="text/javascript"><!--
$('#review-list-language a:first').tab('show');

$('#review-policy-language a:first').tab('show');
$('#review-successmsg-language a:first').tab('show');

$('#customeremail a:first').tab('show');
$('#adminemail a:first').tab('show');
$('#cireview_votelanguage a:first').tab('show');
$('#cireview_reviewpromolanguage a:first').tab('show');
$('input[name="cireviewpro_customersend"]').on('change', function() {
  if($(this).val()==1) {
    $('.customeremail').show();
  } else {
    $('.customeremail').hide();
  }
});
$('input[name="cireviewpro_customersend"]:checked').trigger('change');
$('input[name="cireviewpro_adminsend"]').on('change', function() {
  if($(this).val()==1) {
    $('.adminemail').show();
  } else {
    $('.adminemail').hide();
  }
});
$('input[name="cireviewpro_adminsend"]:checked').trigger('change');

$('input[name="cireviewpro_reviewpolicy"]').on('change', function() {
  if($(this).val()==1) {
    $('.reviewpolicy').show();
  } else {
    $('.reviewpolicy').hide();
  }
});
$('input[name="cireviewpro_reviewpolicy"]:checked').trigger('change');
$('input[name="cireviewpro_rewardsuccessalert"]').on('change', function() {
  if($(this).val()=='DEFAULT') {
    $('.review-successmsg-title').hide();
  } else {
    $('.review-successmsg-title').show();
  }
});
$('input[name="cireviewpro_rewardsuccessalert"]:checked').trigger('change');
$('input[name="cireviewpro_reviewreward"]').on('change', function() {
  if($(this).val()==1) {
    $('.review-successmsg-rewardpoints').show();
  } else {
    $('.review-successmsg-rewardpoints').hide();
  }
});
$('input[name="cireviewpro_reviewreward"]:checked').trigger('change');
$('input[name="cireviewpro_reviewcoupon"]').on('change', function() {
  if($(this).val()==1) {
    $('.review-successmsg-couponcode').show();
  } else {
    $('.review-successmsg-couponcode').hide();
  }
});
$('input[name="cireviewpro_reviewcoupon"]:checked').trigger('change');

$('input[name="cireviewpro_reviewpageaddon"]').on('change', function() {
  if($(this).val()=='DATEFORMAT') {
    $('.reviewpageaddon-dateformat').show();
  } else {
    $('.reviewpageaddon-dateformat').hide();
  }
});
$('input[name="cireviewpro_reviewpageaddon"]:checked').trigger('change');

$('input[name="cireviewpro_reviewaddon"]').on('change', function() {
  if($(this).val()=='DATEFORMAT') {
    $('.reviewaddon-dateformat').show();
  } else {
    $('.reviewaddon-dateformat').hide();
  }
});
$('input[name="cireviewpro_reviewaddon"]:checked').trigger('change');

// Color Picker
$('.colorpicker').colorpicker();
<?php if ($requiresync) { ?>
$('.doreviewsync').on('click', function() {
  var $this = $(this);
  var old_classes = $this.find('i').attr('class');
  $.ajax({
    url: 'index.php?route=cireviewpro/cireviewpro/doReviewSync&<?php echo $module_token; ?>=<?php echo $ci_token; ?>',
    type: 'post',
    data: 'sync=1',
    dataType: 'json',
    beforeSend: function() {
      $this.find('i').addClass('fa-spinner');
    },
    complete: function() {
      $this.find('i').removeClass('fa-spinner');
    },
    success: function(json) {
      if (json['error']) {
        $('#form-cireviewpro').before('<div class="alert alert-danger alert-dismissible"><i class="fa fa-check-circle"></i> ' + json['error'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
      }
      if (json['success']) {
        $('.alert-cireview').html('<div class="alert alert-success"><i class="fa fa-exclamation-circle"></i> '+ json['success'] +' </div>');
        setTimeout(function() {
          $('.alert-reviewsync').remove();
        }, 5000);
      }
    },
    error: function(xhr, ajaxOptions, thrownError) {
      alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
    }
  });
});
<?php } ?>
//--></script>
</div>
<?php echo $footer; ?>