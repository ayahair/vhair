<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
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
        <?php if($cireview_invite) { ?>
        <div class="row">
          <div class="col-md-4">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-shopping-cart"></i> <?php echo $text_invite_detail; ?></h3>
              </div>
              <table class="table">
                <tbody>
                  <tr>
                    <td ><button data-toggle="tooltip" title="<?php echo $text_store; ?>" class="btn btn-info btn-xs"><i class="fa fa-shopping-cart fa-fw"></i></button></td>
                    <td><a href="<?php echo $store_url; ?>" target="_blank"><?php echo $store_name; ?></a></td>
                  </tr>
                  <tr>
                    <td><button data-toggle="tooltip" title="<?php echo $text_date_added; ?>" class="btn btn-info btn-xs"><i class="fa fa-calendar fa-fw"></i></button></td>
                    <td><?php echo $date_added; ?></td>
                  </tr>
                  <tr>
                    <td><?php echo $text_review_status; ?></td>
                    <td>
                      <?php if($given_review) { ?> 
                        <a href="<?php echo $review_url; ?>" target="_blank"><?php echo $text_review_view; ?></a>
                        <?php } else { ?>
                        <?php echo $text_pending; ?>
                        <?php } ?>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="col-md-4">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-user"></i> <?php echo $text_customer_detail; ?></h3>
              </div>
              <table class="table">
                <tr>
                  <td ><button data-toggle="tooltip" title="<?php echo $text_customer; ?>" class="btn btn-info btn-xs"><i class="fa fa-user fa-fw"></i></button></td>
                  <td><?php if ($customer) { ?>
                    <a href="<?php echo $customer; ?>" target="_blank"><?php echo $firstname; ?> <?php echo $lastname; ?></a>
                    <?php } else { ?>
                    <?php echo $firstname; ?> <?php echo $lastname; ?>
                    <?php } ?></td>
                </tr>
                <tr>
                  <td><button data-toggle="tooltip" title="<?php echo $text_email; ?>" class="btn btn-info btn-xs"><i class="fa fa-envelope-o fa-fw"></i></button></td>
                  <td><a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></td>
                </tr>
                <tr>
                  <td><button data-toggle="tooltip" title="<?php echo $text_telephone; ?>" class="btn btn-info btn-xs"><i class="fa fa-phone fa-fw"></i></button></td>
                  <td><?php echo $telephone; ?></td>
                </tr>
              </table>
            </div>
          </div>
          <div class="col-md-4">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-cog"></i> <?php echo $text_order_detail; ?></h3>
              </div>
              <table class="table">
                <tbody>
                  <tr>
                    <td><?php echo $text_order_id; ?></td>
                    <td id="order_id" class="text-left"><?php echo $order_id; ?></td>
                    <td class="text-center"><a href="<?php echo $order_href; ?>" target="_blank"><?php echo $text_order_view; ?></a></td>
                  </tr>
                  <tr>
                    <td><?php echo $text_product; ?></td>
                    <td class="text-left"><?php echo $product; ?></td>
                    <td class="text-center"><a href="<?php echo $product_url; ?>" target="_blank"><?php echo $text_product_view; ?></a></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="col-md-12">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_action; ?></h3>
              </div>
              <table class="table">
                <tbody>
                  <tr>
                    <td>
                      <div class="form-group clearfix">
                        <label class="control-label col-sm-12" for="input-status"><?php echo $entry_status; ?></label>
                        <div class="col-sm-12">
                          <label class="radio-inline">
                            <?php if ($status) { ?>
                            <input class="update-status" type="radio" name="status" value="1" checked="checked" />
                            <?php echo $text_enabled; ?>
                            <?php } else { ?>
                            <input class="update-status" type="radio" name="status" value="1" />
                            <?php echo $text_enabled; ?>
                            <?php } ?>
                          </label>
                          <label class="radio-inline">
                            <?php if (!$status) { ?>
                            <input class="update-status" type="radio" name="status" value="0" checked="checked" />
                            <?php echo $text_disabled; ?>
                            <?php } else { ?>
                            <input class="update-status" type="radio" name="status" value="0" />
                            <?php echo $text_disabled; ?>
                            <?php } ?>
                          </label>
                        </div>
                      </div>
                      <div class="form-group clearfix">
                        <label class="control-label col-sm-12" for="input-invite"><?php echo $entry_invite; ?></label>
                        <div class="col-sm-12">
                          <label class="radio-inline">
                            <?php if ($invite) { ?>
                            <input class="update-invite" type="radio" name="invite" value="1" checked="checked" />
                            <?php echo $text_reminder_go; ?>
                            <?php } else { ?>
                            <input class="update-invite"  type="radio" name="invite" value="1" />
                            <?php echo $text_reminder_go; ?>
                            <?php } ?>
                          </label>
                          <label class="radio-inline">
                            <?php if (!$invite) { ?>
                            <input class="update-invite"  type="radio" name="invite" value="0" checked="checked" />
                            <?php echo $text_reminder_notgo; ?>
                            <?php } else { ?>
                            <input class="update-invite"  type="radio" name="invite" value="0" />
                            <?php echo $text_reminder_notgo; ?>
                            <?php } ?>
                          </label>
                        </div>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <td class="text-left"><?php echo $column_reminder_id; ?></td>
                <td class="text-left"><?php echo $column_date_added; ?></td>
              </tr>
            </thead>
            <tbody>
              <?php foreach($invite_reminders as $invite_reminder) { ?>
              <tr>
                <td>#<?php echo $invite_reminder['cireview_invitereminder_id']; ?></td>
                <td><?php echo $invite_reminder['date_added']; ?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
        <?php } else { ?>
        <div class="text-center">
          <h2><?php echo $text_no_record; ?></h2>
        </div>
        <?php } ?>    
      </div>
    </div>
  </div>
  <script type="text/javascript">
    $('.update-invite').on('change', function() {
      var value = $(this).val();
      var $this = $(this);
      $.ajax({
        url: 'index.php?route=cireviewpro/cireviewpro_invitelog/updateInvite&<?php echo $module_token; ?>=<?php echo $ci_token; ?>',
        type: 'get',
        data: 'cireview_invite_id=<?php echo $cireview_invite_id; ?>&value='+value,
        dataType: 'json',
        beforeSend: function() {
          
        },
        complete: function() {
          
        },
        success: function(json) {
          $('.alert, .text-danger').remove();

          var $panel = $this.parents('.panel.panel-default').first()

          if (json['success']) {
            $panel.before('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
          }
          if (json['error']) {
           $panel.before('<div class="alert alert-danger"><i class="fa fa-check-circle"></i> ' + json['error'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>'); 
          }

          // $('html, body').animate({ scrollTop: ($panel.offset().top - 60) }, 'slow');
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
      });

    });
    $('.update-status').on('change', function() {
      var value = $(this).val();
      var $this = $(this);
      $.ajax({
        url: 'index.php?route=cireviewpro/cireviewpro_invitelog/updateStatus&<?php echo $module_token; ?>=<?php echo $ci_token; ?>',
        type: 'get',
        data: 'cireview_invite_id=<?php echo $cireview_invite_id; ?>&value='+value,
        dataType: 'json',
        beforeSend: function() {
          
        },
        complete: function() {
          
        },
        success: function(json) {
          $('.alert, .text-danger').remove();

          var $panel = $this.parents('.panel.panel-default').first()

          if (json['success']) {
            $panel.before('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
          }
          if (json['error']) {
           $panel.before('<div class="alert alert-danger"><i class="fa fa-check-circle"></i> ' + json['error'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>'); 
          }

          // $('html, body').animate({ scrollTop: ($panel.offset().top - 60) }, 'slow');
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
      });
    });
  </script>
</div>
<?php echo $footer; ?>