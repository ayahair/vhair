<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-cireviews_invitelogs').submit() : false;"><i class="fa fa-trash-o"></i></button>
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
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3>
      </div>
      <div class="panel-body">
        <div class="well">
          <div class="row">
            <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="input-order_id"><?php echo $entry_order_id; ?></label>
                <input type="text" name="filter_order_id" value="<?php echo $filter_order_id; ?>" placeholder="<?php echo $entry_order_id; ?>" id="input-order_id" class="form-control" />
              </div>
              <div class="form-group">
                <label class="control-label" for="input-date-added"><?php echo $entry_date_added; ?></label>
                <div class="input-group date">
                  <input type="text" name="filter_date_added" value="<?php echo $filter_date_added; ?>" placeholder="<?php echo $entry_date_added; ?>" data-date-format="YYYY-MM-DD" id="input-date-added" class="form-control" />
                  <span class="input-group-btn">
                  <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                  </span></div>
              </div>              
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="input-product"><?php echo $entry_product; ?></label>
                <input type="text" name="filter_product" value="<?php echo $filter_product; ?>" placeholder="<?php echo $entry_product; ?>" id="input-product" class="form-control" />
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
            <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="input-customer"><?php echo $entry_customer; ?></label>
                <input type="text" name="filter_customer" value="<?php echo $filter_customer; ?>" placeholder="<?php echo $entry_customer; ?>" id="input-customer" class="form-control" />
              </div>
              <div class="form-group">
                <label class="control-label" for="input-review_given"><?php echo $entry_review_given; ?></label>
                <select name="filter_review_given" id="input-review_given" class="form-control">
                  <option value="*"></option>
                  <option value="1" <?php if($filter_review_given=='1') { ?>selected="selected" <?php } ?>><?php echo $text_given; ?></option>
                  <option value="0" <?php if($filter_review_given=='0') { ?>selected="selected" <?php } ?>><?php echo $text_pending; ?></option>
                </select>
              </div>
              <button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-filter"></i> <?php echo $button_filter; ?></button>
            </div>
          </div>
        </div>
        <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-cireviews_invitelogs">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                  <td class="text-left"><?php if ($sort == 'cri.order_id') { ?>
                    <a href="<?php echo $sort_order_id; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_order_id; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_order_id; ?>"><?php echo $column_order_id; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'cri.store_id') { ?>
                    <a href="<?php echo $sort_store_id; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_store; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_store_id; ?>"><?php echo $column_store; ?></a>
                    <?php } ?></td>
                  
                  <td class="text-left"><?php echo $column_product; ?></td>
                  <td class="text-left"><?php echo $column_customer; ?></td>
                  <td class="text-left"><?php if ($sort == 'cri.review') { ?>
                    <a href="<?php echo $sort_review_given; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_review_given; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_review_given; ?>"><?php echo $column_review_given; ?></a>
                    <?php } ?></td>
                  <!-- /*29-08-2018*/ --><td class="text-left"><?php if ($sort == 'cri.invite') { ?>
                    <a href="<?php echo $sort_invite; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_invite; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_date_added; ?>"><?php echo $column_invite; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'cri.status') { ?>
                    <a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_status; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_date_added; ?>"><?php echo $column_status; ?></a>
                    <?php } ?></td><!-- /*29-08-2018*/ -->
                  <td class="text-left"><?php if ($sort == 'cri.date_added') { ?>
                    <a href="<?php echo $sort_date_added; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_added; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_date_added; ?>"><?php echo $column_date_added; ?></a>
                    <?php } ?></td>
                  <td class="text-right"><?php echo $column_action; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php if ($cireviews_invitelogs) { ?>
                <?php foreach ($cireviews_invitelogs as $cireviews_invitelog) { ?>
                <tr class=" ">
                  <td class="text-center"><?php if (in_array($cireviews_invitelog['cireview_invite_id'], $selected)) { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $cireviews_invitelog['cireview_invite_id']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $cireviews_invitelog['cireview_invite_id']; ?>" />
                    <?php } ?></td>
                  <td class="text-left"><?php echo $cireviews_invitelog['order_id']; ?></td>
                  <td class="text-left"><?php echo $cireviews_invitelog['store']; ?></td>
                  <td class="text-left">
                    <?php if( $cireviews_invitelog['product']) { ?>
                    <a href="<?php echo $cireviews_invitelog['product']['href']; ?>" target="_blank"><?php echo $cireviews_invitelog['product']['name']; ?></a>
                    <?php } ?>
                  </td>
                  <td class="text-left">
                    <?php if($cireviews_invitelog['customer']['is_customer']) { ?>
                    <a href="<?php echo $cireviews_invitelog['customer']['href']; ?>" target="_blank"><?php echo $cireviews_invitelog['customer']['firstname']; ?> <?php echo $cireviews_invitelog['customer']['lastname']; ?></a>
                    <?php } else { ?>
                    <?php echo $cireviews_invitelog['customer']['firstname']; ?> <?php echo $cireviews_invitelog['customer']['lastname']; ?>
                    <?php } ?>
                  </td>
                  <td class="text-left"><?php echo $cireviews_invitelog['review_given']; ?></td>
                  <!-- /*29-08-2018*/ --><td class="text-left"><label class="label <?php if($cireviews_invitelog['invite']==0) { ?>label-warning<?php } else { ?>label-default<?php } ?>"><?php echo $cireviews_invitelog['invite_text']; ?></label></td>
                  <td class="text-left"><label class="label <?php if($cireviews_invitelog['status']==0) { ?>label-danger<?php } else { ?>label-default<?php } ?>"><?php echo $cireviews_invitelog['status_text']; ?></label></td><!-- /*29-08-2018*/ -->
                  <td class="text-left"><?php echo $cireviews_invitelog['date_added']; ?></td>

                  <td class="text-right"><a href="<?php echo $cireviews_invitelog['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_view; ?>" class="btn btn-primary"><i class="fa fa-eye"></i></a></td>
                </tr>
                <?php } ?>
                <?php } else { ?>
                <tr>
                  <td class="text-center" colspan="10"><?php echo $text_no_results; ?></td>
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
  url = 'index.php?route=cireviewpro/cireviewpro_invitelog&<?php echo $module_token; ?>=<?php echo $ci_token; ?>';

  var filter_order_id = $('input[name=\'filter_order_id\']').val();

  if (filter_order_id) {
    url += '&filter_order_id=' + encodeURIComponent(filter_order_id);
  }

  var filter_product = $('input[name=\'filter_product\']').val();

  if (filter_product) {
    url += '&filter_product=' + encodeURIComponent(filter_product);
  }
  
  var filter_customer = $('input[name=\'filter_customer\']').val();

  if (filter_customer) {
    url += '&filter_customer=' + encodeURIComponent(filter_customer);
  }

  var filter_store_id = $('select[name=\'filter_store_id\']').val();

  if (filter_store_id != '*') {
    url += '&filter_store_id=' + encodeURIComponent(filter_store_id);
  }

  var filter_review_given = $('select[name=\'filter_review_given\']').val();

  if (filter_review_given != '*') {
    url += '&filter_review_given=' + encodeURIComponent(filter_review_given);
  }
 

  var filter_date_added = $('input[name=\'filter_date_added\']').val();
  if (filter_date_added) {
    url += '&filter_date_added=' + encodeURIComponent(filter_date_added);
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

$('input[name=\'filter_customer\']').autocomplete({
  'source': function(request, response) {
    $.ajax({
      url: 'index.php?route=customer/customer/autocomplete&<?php echo $module_token; ?>=<?php echo $ci_token; ?>&filter_name=' +  encodeURIComponent(request),
      dataType: 'json',
      success: function(json) {
        response($.map(json, function(item) {
          return {
            label: item['name'],
            value: item['customer_id']
          }
        }));
      }
    });
  },
  'select': function(item) {
    $('input[name=\'filter_customer\']').val(item['label']);
  }
});
//--></script>
<script src="view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
  <link href="view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css" type="text/css" rel="stylesheet" media="screen" />
  <script type="text/javascript"><!--
$('.date').datetimepicker({
  pickTime: false
});
//--></script>
</div>
<?php echo $footer; ?>