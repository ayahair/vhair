<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <a href="<?php echo $add; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>
        <button type="submit" form="form-cireviews" formaction="<?php echo $copy; ?>" data-toggle="tooltip" title="<?php echo $button_copy; ?>" class="btn btn-default"><i class="fa fa-copy"></i></button>
        <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-cireviews').submit() : false;"><i class="fa fa-trash-o"></i></button>
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

    <style type="text/css">
      .rating .fa-stack i {
          font-size: 24px;
          color: <?php echo !empty($reviewgraph_color) ? $reviewgraph_color : '#FC0'; ?>;
      }
    </style>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3>
      </div>
      <div class="panel-body">
        <div class="well">
          <div class="row">
            <div class="col-sm-3">
              <div class="form-group">
                <label class="control-label" for="input-product"><?php echo $entry_product; ?></label>
                <input type="text" name="filter_product" value="<?php echo $filter_product; ?>" placeholder="<?php echo $entry_product; ?>" id="input-product" class="form-control" />
              </div>
              <div class="form-group">
                <label class="control-label" for="input-date-added"><?php echo $entry_date_added; ?></label>
                <div class="input-group date">
                  <input type="text" name="filter_date_added" value="<?php echo $filter_date_added; ?>" placeholder="<?php echo $entry_date_added; ?>" data-date-format="YYYY-MM-DD" id="input-date-added" class="form-control" />
                  <span class="input-group-btn">
                  <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                  </span></div>
              </div>              
              <div class="form-group">
                <label class="control-label" for="input-store"><?php echo $entry_store; ?></label>
                <select name="filter_store_id" id="input-store" class="form-control">
                  <option value="*"></option>
                  <?php foreach($stores as $store) { ?>
                  <?php $sel = ''; ?>
                  <?php if ($store['store_id'] == $filter_store_id) { ?>
                  <?php $sel = 'selected="selected"'; ?>
                  <?php } ?>
                  <option value="<?php echo $store['store_id']; ?>" <?php echo $sel; ?> ><?php echo $store['name']; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <label class="control-label" for="input-title"><?php echo $entry_title; ?></label>
                <input type="text" name="filter_title" value="<?php echo $filter_title; ?>" placeholder="<?php echo $entry_title; ?>" id="input-title" class="form-control review_filter" data-label="title" />
              </div>
              <div class="form-group">
                <label class="control-label" for="input-rating"><?php echo $entry_rating; ?></label>
                <select name="filter_rating" id="input-rating" class="form-control">
                  <option value="*"></option>
                  <option value="1" <?php if ($filter_rating==1) { echo 'selected="selected"'; } ?>>1</option>
                  <option value="2" <?php if ($filter_rating==2) { echo 'selected="selected"'; } ?>>2</option>
                  <option value="3" <?php if ($filter_rating==3) { echo 'selected="selected"'; } ?>>3</option>
                  <option value="4" <?php if ($filter_rating==4) { echo 'selected="selected"'; } ?>>4</option>
                  <option value="5" <?php if ($filter_rating==5) { echo 'selected="selected"'; } ?>>5</option>
                </select>
              </div>              
              <div class="form-group">
                <label class="control-label" for="input-language"><?php echo $entry_language; ?></label>
                <select name="filter_language_id" id="input-language" class="form-control">
                  <option value="*"></option>
                  <?php foreach($languages as $language) { ?>
                  <?php $sel = ''; ?>
                  <?php if ($language['language_id'] == $filter_language_id) { ?>
                  <?php $sel = 'selected="selected"'; ?>
                  <?php } ?>
                  <option value="<?php echo $language['language_id']; ?>" <?php echo $sel; ?> ><?php echo $language['name']; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <label class="control-label" for="input-author"><?php echo $entry_author; ?></label>
                <input type="text" name="filter_author" value="<?php echo $filter_author; ?>" placeholder="<?php echo $entry_author; ?>" id="input-author" class="form-control" data-label="author" />
              </div>
               <div class="form-group">
                <label class="control-label" for="input-vote"><?php echo $entry_vote; ?></label>
                <select name="filter_vote" id="input-vote" class="form-control">
                  <option value="*"></option>
                  <option value="1" <?php if ($filter_vote) { echo 'selected="selected"'; } ?>><?php echo $text_vote_up; ?></option>
                  <option value="0" <?php if (!$filter_vote && !is_null($filter_vote)) { echo 'selected="selected"'; } ?>><?php echo $text_vote_down; ?></option>
                </select>
              </div>
              <div class="form-group">
                <label class="control-label" for="input-imp"><?php echo $entry_imp_filter; ?></label>
                <select name="filter_imp" id="input-imp" class="form-control">
                  <option value="*"></option>
                  <option value="1" <?php if ($filter_imp) { echo 'selected="selected"'; } ?>><?php echo $text_yes; ?></option>
                  <option value="0" <?php if (!$filter_imp && !is_null($filter_imp)) { echo 'selected="selected"'; } ?>><?php echo $text_no; ?></option>
                </select>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <label class="control-label" for="input-email"><?php echo $entry_email; ?></label>
                <input type="text" name="filter_email" value="<?php echo $filter_email; ?>" placeholder="<?php echo $entry_email; ?>" id="input-email" class="form-control" data-label="email" />
              </div>
              <div class="form-group">
                <label class="control-label" for="input-status"><?php echo $entry_status; ?></label>
                <select name="filter_status" id="input-status" class="form-control">
                  <option value="*"></option>
                  <option value="1" <?php if ($filter_status) { echo 'selected="selected"'; } ?>><?php echo $text_enabled; ?></option>
                  <option value="0" <?php if (!$filter_status && !is_null($filter_status)) { echo 'selected="selected"'; } ?>><?php echo $text_disabled; ?></option>
                </select>
              </div>
              <div class="form-group">
                <label class="control-label" for="input-attachimages"><?php echo $entry_attachimages; ?></label>
                <select name="filter_attachimages" id="input-attachimages" class="form-control">
                  <option value="*"></option>
                  <option value="1" <?php if ($filter_attachimages) { echo 'selected="selected"'; } ?>><?php echo $text_yes; ?></option>
                  <option value="0" <?php if (!$filter_attachimages && !is_null($filter_attachimages)) { echo 'selected="selected"'; } ?>><?php echo $text_no; ?></option>
                </select>
              </div>
              <button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-filter"></i> <?php echo $button_filter; ?></button>
            </div>
          </div>
        </div>
        <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-cireviews">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                  <td class="text-left"><?php if ($sort == 'product_name') { ?>
                    <a href="<?php echo $sort_product_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_product_name; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_product_name; ?>"><?php echo $column_product_name; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php echo $column_reviewinfo; ?></td>
                  <!-- <td class="text-left"><?php if ($sort == 'cr.title') { ?>
                    <a href="<?php echo $sort_title; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_title; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_title; ?>"><?php echo $column_title; ?></a>
                    <?php } ?></td> -->
                  <td class="text-left"><?php if ($sort == 'cr.store_id') { ?>
                    <a href="<?php echo $sort_store_id; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_store; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_store_id; ?>"><?php echo $column_store; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'cr.language_id') { ?>
                    <a href="<?php echo $sort_language_id; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_language; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_language_id; ?>"><?php echo $column_language; ?></a>
                    <?php } ?></td>
                  <?php /* <td class="text-left"><?php echo $column_rating; ?></td> */ ?>
                  <td class="text-center"><?php if ($sort == 'r.status') { ?>
                    <a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_status; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_status; ?>"><?php echo $column_status; ?></a>
                    <?php } ?></td>
                </tr>
              </thead>
              <tbody>
                <?php if ($cireviews) { ?>
                <?php foreach ($cireviews as $cireview) { ?>
                <tr>
                  <td class="text-center"><?php if (in_array($cireview['review_id'], $selected)) { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $cireview['review_id']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $cireview['review_id']; ?>" />
                    <?php } ?></td>
                  <td class="text-left" width="15%">
                    <table class="table table-hover table-bordered">
                      <thead>
                        <tr>
                          <td><?php echo $column_product_name; ?></td>
                          <td><?php echo $column_image; ?></td>
                          <td><?php echo $column_view; ?></td>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td><strong><?php echo $cireview['product_name']; ?></strong></td>
                          <td><img src="<?php echo $cireview['product_thumb']; ?>" alt="<?php echo $cireview['product_name']; ?>" class="img-responsive" /></td>
                          <td><a href="<?php echo $cireview['product_url']; ?>" class="btn btn-success btn-xs" data-toggle="tooltip" title="<?php echo $button_view; ?>" target="_blank"><i class="fa fa-eye"></i></a></td>
                        </tr>
                      </tbody>
                    </table>
                  </td>
                  <td class="text-left">
                    <table class="table table-hover table-bordered">
                      <thead>
                        <tr>
                          <td colspan="2" class="text-center">
                            <?php if($cireview['title']) { ?>
                            <a href="<?php echo $cireview['edit']; ?>" class="btn btn-success btn-xs"><i class="fa fa-eye"></i> <?php echo $cireview['title']; ?></a>
                            <?php } else { ?>
                            <a href="<?php echo $cireview['edit']; ?>" class="btn btn-success btn-xs"><i class="fa fa-eye"></i> <?php echo $column_reviewinfo; ?></a>
                            <?php } ?>

                            <?php if ($sort == 'r.date_added') { ?>
                            <a href="<?php echo $sort_date_added; ?>" class="<?php /*echo strtolower($order);*/ ?> btn btn-info btn-xs" data-toggle="tooltip" title="<?php echo $column_date_added; ?>"><i class="fa fa-clock-o"></i> <?php echo $cireview['date_added']; ?></a>
                            <?php } else { ?>
                            <a href="<?php echo $sort_date_added; ?>" class="btn btn-info btn-xs" data-toggle="tooltip" title="<?php echo $column_date_added; ?>"><i class="fa fa-clock-o"></i> <?php echo $cireview['date_added']; ?></a>
                            <?php } ?>

                            <a href="<?php echo $cireview['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i>
                          </td>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td><?php if($cireview['customer_url']) { ?><a class="btn btn-success btn-xs" data-toggle="tooltip" title="<?php echo $column_author; ?>" target="_blank" href="<?php echo $cireview['customer_url']; ?>"><i class="fa fa-user"></i></a><?php } else { ?><label class="label label-primary label-xs" data-toggle="tooltip" title="<?php echo $column_author; ?>"><i class="fa fa-user"></i></label><?php } ?></td>
                          <td><?php if ($sort == 'r.author') { ?>
                            <a href="<?php echo $sort_author; ?>" class="<?php /*echo strtolower($order);*/ ?>"><?php echo $cireview['author']; ?></a>
                            <?php } else { ?>
                            <a href="<?php echo $sort_author; ?>"><?php echo $cireview['author']; ?></a>
                            <?php } ?></td>
                        </tr>
                        <?php if(!empty($cireview['email'])) { ?>
                        <tr>
                          <td><label class="label label-info label-xs" data-toggle="tooltip" title="<?php echo $column_email; ?>"><i class="fa fa-envelope"></i></label></td>
                          <td><?php if ($sort == 'cr.email') { ?>
                            <a href="<?php echo $sort_email; ?>" class="<?php /*echo strtolower($order);*/ ?>"><?php echo $cireview['email']; ?></a>
                            <?php } else { ?>
                            <a href="<?php echo $sort_email; ?>"><?php echo $cireview['email']; ?></a>
                            <?php } ?>
                          </td>
                        </tr>
                        <?php } ?>
                        <tr>
                          <td>
                            <label href="<?php echo $sort_imp; ?>" class="label label-danger label-xs" data-toggle="tooltip" title="<?php echo $column_imp; ?>" ><i class="fa fa-exclamation-triangle"></i></label>
                          </td>
                          <td>
                            <?php if ($sort == 'cr.imp') { ?>
                            <a href="<?php echo $sort_imp; ?>" class="<?php /*echo strtolower($order);*/ ?> btn btn-<?php echo $cireview['imp_class']; ?> btn-xs" style="<?php if($cireview['imp_class']=='default') {?>background-color: #777; color: #fff; border-color: #777;<?php } ?>" ><?php echo $cireview['imp']; ?></a>
                            <?php } else { ?>
                            <a href="<?php echo $sort_imp; ?>" class="btn btn-<?php echo $cireview['imp_class']; ?> btn-xs" style="<?php if($cireview['imp_class']=='default') {?>background-color: #777; color: #fff; border-color: #777;<?php } ?>"><?php echo $cireview['imp']; ?></a>
                          <?php } ?>

                            <?php /* <label class="label label-<?php echo $cireview['imp_class']; ?>"><?php echo $cireview['imp']; ?></label> */ ?>
                          </td>
                        </tr>
                        <tr>
                          <td><?php /* if ($sort == 'r.rating') { ?>
                            <a href="<?php echo $sort_rating; ?>" class="<?php echo strtolower($order); ?> btn btn-info btn-xs" data-toggle="tooltip" title="<?php echo $column_avgrating; ?>"><i class="fa fa-star"></i></a>
                            <?php } else { ?>
                            <a href="<?php echo $sort_rating; ?>" class="btn btn-info btn-xs" data-toggle="tooltip" title="<?php echo $column_avgrating; ?>"><i class="fa fa-star"></i></a>
                          <?php } */ ?> 
                            <label class="label label-default label-xs" data-toggle="tooltip" title="<?php echo $column_avgrating; ?>"><i class="fa fa-star"></i></label>
                          </td>
                          <td>

                            <?php if ($sort == 'r.rating') { ?>
                            <a href="<?php echo $sort_rating; ?>" class="<?php /*echo strtolower($order);*/ ?>">
                              <div class="rating">
                              <?php for ($i = 1; $i <= 5; $i++) { ?>
                              <?php if ($cireview['rating'] < $i) { ?>
                              <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-1x"></i></span>
                              <?php } else { ?>
                              <span class="fa fa-stack"><i class="fa fa-star fa-stack-1x"></i><i class="fa fa-star-o fa-stack-1x"></i></span>
                              <?php } ?>
                              <?php } ?>
                            </div>
                            </a>
                            <?php } else { ?>
                            <a href="<?php echo $sort_rating; ?>" >
                              <div class="rating">
                              <?php for ($i = 1; $i <= 5; $i++) { ?>
                              <?php if ($cireview['rating'] < $i) { ?>
                              <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-1x"></i></span>
                              <?php } else { ?>
                              <span class="fa fa-stack"><i class="fa fa-star fa-stack-1x"></i><i class="fa fa-star-o fa-stack-1x"></i></span>
                              <?php } ?>
                              <?php } ?>
                            </div>
                            </a>
                          <?php } ?>
                          </td>
                        </tr>
                        <tr>
                          <td><label class="label label-warning label-xs" data-toggle="tooltip" title="<?php echo $column_votes; ?>"><i class="fa fa-thumbs-up"></i></label></td>
                          <td>
                            <?php if ($sort == 'vote_up') { ?>
                            <a href="<?php echo $sort_vote_up; ?>" class="<?php /*echo strtolower($order);*/ ?> btn btn-success btn-xs" data-toggle="tooltip" title="<?php echo $column_vote_up; ?>"><?php echo $column_vote_up; ?><i class="fa fa-thumbs-up"></i> <?php echo $cireview['votes_up']; ?></a>
                            <?php } else { ?>
                            <a href="<?php echo $sort_vote_up; ?>" class="btn btn-success btn-xs" data-toggle="tooltip" title="<?php echo $column_vote_up; ?>"><i class="fa fa-thumbs-up"></i> <?php echo $cireview['votes_up']; ?></a>
                            <?php } ?>

                            <?php if ($sort == 'vote_down') { ?>
                            <a href="<?php echo $sort_vote_down; ?>" class="<?php /*echo strtolower($order);*/ ?> btn btn-success btn-xs" data-toggle="tooltip" title="<?php echo $column_vote_down; ?>"><?php echo $column_vote_down; ?><i class="fa fa-thumbs-down"></i> <?php echo $cireview['votes_down']; ?></a>
                            <?php } else { ?>
                            <a href="<?php echo $sort_vote_down; ?>" class="btn btn-danger btn-xs" data-toggle="tooltip" title="<?php echo $column_vote_down; ?>"><i class="fa fa-thumbs-down"></i> <?php echo $cireview['votes_down']; ?></a>
                            <?php } ?>
                          </td>
                        </tr>
                        <?php if(!empty($cireview['attach_images'])) { ?>
                        <tr>
                          <td><label class="label label-success label-xs" data-toggle="tooltip" title="<?php echo $column_image; ?>"><i class="fa fa-photo"></i></label></td>
                          <td>                            
                            <ul class="list list-inline ciattach_images">
                              <?php foreach($cireview['attach_images'] as $attach_image) { ?>
                              <li>
                                <a target="_BLANK" href="<?php echo $attach_image['popup']; ?>"><img src="<?php echo $attach_image['thumb']; ?>" alt="<?php echo $heading_title; ?>" /></a>
                              </li>
                              <?php } ?>
                            </ul>
                            
                            
                          </td>
                        </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </td>
                  <td class="text-left"><label class="label label-success label-xs"><i class="fa fa-opencart"></i> <?php echo $cireview['store']; ?></label></td>
                  <td class="text-left"><label class="label label-default label-xs"><?php echo $cireview['flag_html']; ?> <?php echo $cireview['language']; ?></label></td>
                  <?php /*<td class="text-left">
                    <?php foreach($cireview['ratings'] as $ratings) { ?>
                    <label><?php echo $ratings['ciratingtype_name']; ?> </label>
                    <div class="rating">
                    <?php for ($i = 1; $i <= 5; $i++) { ?>
                    <?php if ($ratings['rating'] < $i) { ?>
                    <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-1x"></i></span>
                    <?php } else { ?>
                    <span class="fa fa-stack"><i class="fa fa-star fa-stack-1x"></i><i class="fa fa-star-o fa-stack-1x"></i></span>
                    <?php } ?>
                    <?php } ?>
                    </div>
                    <?php } ?>
                  </td> */ ?>
                  <td class="text-center">
                    <label class="label label-<?php if($cireview['ostatus']) { ?>success<?php } else { ?>danger<?php } ?> label-xs"><?php echo $cireview['status']; ?></label></td>
                </tr>
                <?php } ?>
                <?php } else { ?>
                <tr>
                  <td class="text-center" colspan="16"><?php echo $text_no_results; ?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </form>
        <div class="row">
          <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
          <div class="col-sm-6 text-right"><?php echo $results; ?></div>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript"><!--
$('#button-filter').on('click', function() {
  url = 'index.php?route=cireviewpro/cireviews&<?php echo $module_token; ?>=<?php echo $ci_token; ?>';

  var filter_product = $('input[name=\'filter_product\']').val();
  if (filter_product) {
    url += '&filter_product=' + encodeURIComponent(filter_product);
  }
  
  var filter_store_id = $('select[name=\'filter_store_id\']').val();

  if (filter_store_id != '*') {
    url += '&filter_store_id=' + encodeURIComponent(filter_store_id);
  }
  
  var filter_language_id = $('select[name=\'filter_language_id\']').val();

  if (filter_language_id != '*') {
    url += '&filter_language_id=' + encodeURIComponent(filter_language_id);
  }
    
  var filter_imp = $('select[name=\'filter_imp\']').val();

  if (filter_imp != '*') {
    url += '&filter_imp=' + encodeURIComponent(filter_imp);
  }
  
  
  var filter_title = $('input[name=\'filter_title\']').val();
  if (filter_title) {
    url += '&filter_title=' + encodeURIComponent(filter_title);
  }

  var filter_author = $('input[name=\'filter_author\']').val();
  if (filter_author) {
    url += '&filter_author=' + encodeURIComponent(filter_author);
  }

  var filter_email = $('input[name=\'filter_email\']').val();
  if (filter_email) {
    url += '&filter_email=' + encodeURIComponent(filter_email);
  }

  var filter_date_added = $('input[name=\'filter_date_added\']').val();
  if (filter_date_added) {
    url += '&filter_date_added=' + encodeURIComponent(filter_date_added);
  }

  var filter_rating = $('select[name=\'filter_rating\']').val();

  if (filter_rating != '*') {
    url += '&filter_rating=' + encodeURIComponent(filter_rating);
  }

  var filter_vote = $('select[name=\'filter_vote\']').val();

  if (filter_vote != '*') {
    url += '&filter_vote=' + encodeURIComponent(filter_vote);
  }
  var filter_status = $('select[name=\'filter_status\']').val();

  if (filter_status != '*') {
    url += '&filter_status=' + encodeURIComponent(filter_status);
  }
  
  var filter_attachimages = $('select[name=\'filter_attachimages\']').val();

  if (filter_attachimages != '*') {
    url += '&filter_attachimages=' + encodeURIComponent(filter_attachimages);
  }
  
  location = url;
});
//--></script> 
<script type="text/javascript"><!--

$('input[name=\'filter_product\']').autocomplete({
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
    $('input[name=\'filter_product\']').val(item['label']);
  }
});


$('.review_filter').each(function() {
  var $this = $(this);
  var filter_name = $(this).attr('name');
  var label = $(this).attr('data-label');


  $this.autocomplete({
    'source': function(request, response) {
      $.ajax({
        url: 'index.php?route=cireviewpro/cireviews/autocomplete&<?php echo $module_token; ?>=<?php echo $ci_token; ?>&'+filter_name+'=' +  encodeURIComponent(request),
        dataType: 'json',
        success: function(json) {
          response($.map(json, function(item) {
            return {
              label: item[label],
              value: item['review_id']
            }
          }));
        }
      });
    },
    'select': function(item) {
      $this.val(item['label']);
    }
  });
});
//--></script>

<script src="view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
  <link href="view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css" type="text/css" rel="stylesheet" media="screen" />
  <script type="text/javascript"><!--
$('.date').datetimepicker({
  pickTime: false
});

$('.ciattach_images').each(function() {
  $(this).magnificPopup({
    type:'image',
    delegate: 'a',
    gallery: {
      enabled:true
    }
  });
});
//--></script>
</div>
<?php echo $footer; ?>