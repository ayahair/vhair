<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-ciratingtype" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
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
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-ciratingtype" class="form-horizontal">
           <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-general" data-toggle="tab"><i class="fa fa-tags"></i> <?php echo $tab_general; ?></a></li>
            <li><a href="#tab-settings" data-toggle="tab"><i class="fa fa-cogs"></i> <?php echo $tab_settings; ?></a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="tab-general">
              <ul class="nav nav-tabs" id="language">
                <?php foreach ($languages as $language) { ?>
                <li><a href="#language<?php echo $language['language_id']; ?>" data-toggle="tab">
                  <?php if(VERSION >= '2.2.0.0') { ?>
                  <img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> 
                  <?php } else { ?>
                  <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" />
                  <?php } ?> <?php echo $language['name']; ?></a>
                </li>
                <?php } ?>
              </ul>
              <div class="tab-content">
                <?php foreach ($languages as $language) { ?>
                <div class="tab-pane" id="language<?php echo $language['language_id']; ?>">
                  <div class="form-group required">
                    <label class="col-sm-2 control-label" for="input-name<?php echo $language['language_id']; ?>"><?php echo $entry_name; ?></label>
                    <div class="col-sm-10">
                      <input type="text" name="ciratingtype_description[<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($ciratingtype_description[$language['language_id']]) ? $ciratingtype_description[$language['language_id']]['name'] : ''; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name<?php echo $language['language_id']; ?>" class="form-control" />
                      <?php if (isset($error_name[$language['language_id']])) { ?>
                      <div class="text-danger"><?php echo $error_name[$language['language_id']]; ?></div>
                      <?php } ?>
                    </div>
                  </div>
                </div>
                <?php } ?>
              </div>
            </div>

            <div class="tab-pane" id="tab-settings">
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
                <div class="col-sm-10">
                  <select name="status" id="input-status" class="form-control">
                    <?php if ($status) { ?>
                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                    <option value="0"><?php echo $text_disabled; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_enabled; ?></option>
                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="sort_order" value="<?php echo $sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_store; ?></label>
                <div class="col-sm-10">
                  <div class="well well-sm" style="height: 150px; overflow: auto;">
                    <div class="checkbox">
                      <label>
                        <?php if (in_array(0, $ciratingtype_store)) { ?>
                        <input type="checkbox" name="ciratingtype_store[]" value="0" checked="checked" />
                        <?php echo $text_default; ?>
                        <?php } else { ?>
                        <input type="checkbox" name="ciratingtype_store[]" value="0" />
                        <?php echo $text_default; ?>
                        <?php } ?>
                      </label>
                    </div>
                    <?php foreach ($stores as $store) { ?>
                    <div class="checkbox">
                      <label>
                        <?php if (in_array($store['store_id'], $ciratingtype_store)) { ?>
                        <input type="checkbox" name="ciratingtype_store[]" value="<?php echo $store['store_id']; ?>" checked="checked" />
                        <?php echo $store['name']; ?>
                        <?php } else { ?>
                        <input type="checkbox" name="ciratingtype_store[]" value="<?php echo $store['store_id']; ?>" />
                        <?php echo $store['name']; ?>
                        <?php } ?>
                      </label>
                    </div>
                    <?php } ?>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-product"><span data-toggle="tooltip" title="<?php echo $help_product; ?>"><?php echo $entry_product; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="product" value="" placeholder="<?php echo $entry_product; ?>" id="input-product" class="form-control" />
                  <div id="ciratingtype-product" class="well well-sm" style="height: 150px; overflow: auto;">
                    <?php foreach ($ciratingtype_products as $ciratingtype_product) { ?>
                    <div id="ciratingtype-product<?php echo $ciratingtype_product['product_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $ciratingtype_product['name']; ?>
                      <input type="hidden" name="ciratingtype_product[]" value="<?php echo $ciratingtype_product['product_id']; ?>" />
                    </div>
                    <?php } ?>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-category"><span data-toggle="tooltip" title="<?php echo $help_category; ?>"><?php echo $entry_category; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="category" value="" placeholder="<?php echo $entry_category; ?>" id="input-category" class="form-control" />
                  <div id="ciratingtype-category" class="well well-sm" style="height: 150px; overflow: auto;">
                    <?php foreach ($ciratingtype_categories as $ciratingtype_category) { ?>
                    <div id="ciratingtype-category<?php echo $ciratingtype_category['category_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $ciratingtype_category['name']; ?>
                      <input type="hidden" name="ciratingtype_category[]" value="<?php echo $ciratingtype_category['category_id']; ?>" />
                    </div>
                    <?php } ?>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-manufacturer"><span data-toggle="tooltip" title="<?php echo $help_manufacturer; ?>"><?php echo $entry_manufacturer; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="manufacturer" value="" placeholder="<?php echo $entry_manufacturer; ?>" id="input-manufacturer" class="form-control" />
                  <div id="ciratingtype-manufacturer" class="well well-sm" style="height: 150px; overflow: auto;">
                    <?php foreach ($ciratingtype_manufacturers as $ciratingtype_manufacturer) { ?>
                    <div id="ciratingtype-manufacturer<?php echo $ciratingtype_manufacturer['manufacturer_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $ciratingtype_manufacturer['name']; ?>
                      <input type="hidden" name="ciratingtype_manufacturer[]" value="<?php echo $ciratingtype_manufacturer['manufacturer_id']; ?>" />
                    </div>
                    <?php } ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>  
<script type="text/javascript"><!--
$('#language a:first').tab('show');

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

      $('#ciratingtype-category' + item['value']).remove();

      $('#ciratingtype-category').append('<div id="ciratingtype-category' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="ciratingtype_category[]" value="' + item['value'] + '" /></div>');
    }
  });

  $('#ciratingtype-category').delegate('.fa-minus-circle', 'click', function() {
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

      $('#ciratingtype-manufacturer' + item['value']).remove();

      $('#ciratingtype-manufacturer').append('<div id="ciratingtype-manufacturer' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="ciratingtype_manufacturer[]" value="' + item['value'] + '" /></div>');
    }
  });

  $('#ciratingtype-manufacturer').delegate('.fa-minus-circle', 'click', function() {
    $(this).parent().remove();
  });

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

      $('#ciratingtype-product' + item['value']).remove();

      $('#ciratingtype-product').append('<div id="ciratingtype-product' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="ciratingtype_product[]" value="' + item['value'] + '" /></div>');
    }
  });

  $('#ciratingtype-product').delegate('.fa-minus-circle', 'click', function() {
    $(this).parent().remove();
  });
//--></script></div>
<?php echo $footer; ?>