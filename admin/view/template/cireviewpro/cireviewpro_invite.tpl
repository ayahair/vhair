<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-cireviewpro" data-toggle="tooltip" title="<?php echo $button_mail; ?>" class="btn btn-primary"><i class="fa fa-envelope"></i> <?php echo $button_mail; ?></button>
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
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $heading_title; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-cireviewpro" class="form-horizontal">
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-customer"><span data-toggle="tooltip" title="<?php echo $help_customer; ?>"><?php echo $entry_customer; ?></span></label>
            <div class="col-sm-10">
              <input type="text" name="cireviewpro_invite_customer" value="<?php echo $cireviewpro_invite_customer; ?>" placeholder="<?php echo $entry_customer; ?>" id="input-customer" class="form-control" />
              <div id="customers" class="well well-sm" style="height: 150px; overflow: auto;">
                <?php foreach ($cireviewpro_invite_customers as $customer) { ?>
                <div id="customer<?php echo $customer['customer_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $customer['name']; ?>
                  <input type="hidden" name="cireviewpro_invite_customers[]" value="<?php echo $customer['customer_id']; ?>" />
                </div>
                <?php } ?>
              </div>
              <?php if ($error_customers) { ?>
              <div class="text-danger"><?php echo $error_customers; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-product"><span data-toggle="tooltip" title="<?php echo $help_product; ?>"><?php echo $entry_product; ?></span></label>
            <div class="col-sm-10">
              <input type="text" name="cireviewpro_invite_product" value="<?php echo $cireviewpro_invite_product; ?>" placeholder="<?php echo $entry_product; ?>" id="input-product" class="form-control" />
              <input type="hidden" name="cireviewpro_invite_product_id" value="<?php echo $cireviewpro_invite_product_id; ?>" />
              <?php if ($error_product) { ?>
              <div class="text-danger"><?php echo $error_product; ?></div>
              <?php } ?>
            </div>
          </div>
          <fieldset>
            <legend><?php echo $legend_email ?></legend>
            <div class="row">
              <div class="col-sm-12">
                <div class="customeremail">
                  <div class="buttons text-right">
                    <a data-loading="<?php echo $text_loading; ?>" class="btn btn-primary save-template"><?php echo $button_save; ?></a>
                  </div>
                  
                  <div class="form-group required">
                    <label class="col-sm-2 control-label" for="input-subject"><?php echo $entry_subject; ?></label>
                    <div class="col-sm-10">
                      <input type="text" name="cireviewpro_invite_subject" rows="5" placeholder="<?php echo $entry_subject; ?>" id="input-subject" class="form-control" value="<?php echo $cireviewpro_invite_subject; ?>" />
                      <?php if ($error_subject) { ?>
                      <div class="text-danger"><?php echo $error_subject; ?></div>
                      <?php } ?>
                    </div>
                  </div>
                  <div class="form-group required">
                    <label class="col-sm-2 control-label" for="input-message"><?php echo $entry_message; ?></label>
                    <div class="col-sm-10">
                      <textarea name="cireviewpro_invite_message" rows="5" placeholder="<?php echo $entry_message; ?>" id="input-message" class="form-control summernote" data-toggle="summernote" data-lang=""><?php echo $cireviewpro_invite_message; ?></textarea>
                      <?php if ($error_message) { ?>
                      <div class="text-danger"><?php echo $error_message; ?></div>
                      <?php } ?>
                    </div>
                  </div>                
                </div>
              </div>
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
                        <td>{LINK}</td>
                        <td><?php echo $code_link; ?></td>
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
                        <td>{PRODUCT_NAME}</td>
                        <td><?php echo $code_product_name; ?></td>
                      </tr>
                      <tr>
                        <td>{PRODUCT_IMAGE}</td>
                        <td><?php echo $code_product_image; ?></td>
                      </tr>
                      <tr>
                        <td>{PRODUCT_LINK}</td>
                        <td><?php echo $code_product_link; ?></td>
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
$('#input-message').summernote({ height: 300 });
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
$('input[name=\'cireviewpro_invite_product\']').autocomplete({
  'source': function(request, response) {
    $.ajax({
      url: 'index.php?route=catalog/product/autocomplete&<?php echo $module_token; ?>=<?php echo $ci_token; ?>&filter_name=' +  encodeURIComponent(request),
      dataType: 'json',
      success: function(json) {
        json.unshift({
          product_id: 0,
          name: '<?php echo $text_none; ?>'
        });

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
    $('input[name=\'cireviewpro_invite_product\']').val(item['label']);
    $('input[name=\'cireviewpro_invite_product_id\']').val(item['value']);
  }
});

// Customer
$('input[name=\'cireviewpro_invite_customer\']').autocomplete({
  'source': function(request, response) {
    $.ajax({
      url: 'index.php?route=<?php echo (VERSION > '2.0.3.1') ? 'customer' : 'sale'; ?>/customer/autocomplete&<?php echo $module_token; ?>=<?php echo $ci_token; ?>&filter_name=' +  encodeURIComponent(request),      
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
    $('input[name=\'cireviewpro_invite_customer\']').val('');

    $('#customer' + item['value']).remove();

    $('#customers').append('<div id="customer' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="cireviewpro_invite_customers[]" value="' + item['value'] + '" /></div>');
  }
});

$('#customers').delegate('.fa-minus-circle', 'click', function() {
  $(this).parent().remove();
});

$('.save-template').on('click', function() {
  var $this = $(this);
  $('.alert').remove();
  $.ajax({
    url: 'index.php?route=cireviewpro/cireviewpro_invite/saveTemplate&<?php echo $module_token; ?>=<?php echo $ci_token; ?>&store_id=<?php echo $store_id; ?>',
    type: 'post',
    data: $('#form-cireviewpro').serialize(),
    dataType: 'json',
    beforeSend: function() {
      $this.button('loading');
    },
    complete: function() {
      $this.button('reset');
    },
    success: function(json) {
      $('.alert').remove();
      $this.parent().before('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
    },
    error: function(xhr, ajaxOptions, thrownError) {
      alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
    }
  });
});

//--></script></div>
<?php echo $footer; ?>