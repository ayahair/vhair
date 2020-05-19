<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-review" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-review" class="form-horizontal">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
            <li><a href="#tab-abuses" data-toggle="tab"><?php echo $tab_abuses; ?></a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="tab-general">
              
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-language"><?php echo $entry_language; ?></label>
                <div class="col-sm-10">
                  <select name="language_id" id="input-language" class="form-control">
                    <option value="0"><?php echo $text_language_none; ?></option>
                    <?php foreach($languages as $language) { ?>
                    <?php $sel = ''; ?>
                    <?php if($language['language_id']==$language_id) { ?>
                    <?php $sel = 'selected="selected"'; ?>
                    <?php } ?>
                    <option value="<?php echo $language['language_id']; ?>" <?php echo $sel; ?>><?php echo $language['name']; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-store"><?php echo $entry_store; ?></label>
                <div class="col-sm-10">
                  <select name="store_id" id="input-store" class="form-control">
                    <?php foreach($stores as $store) { ?>
                    <?php $sel = ''; ?>
                    <?php if($store['store_id']==$store_id) { ?>
                    <?php $sel = 'selected="selected"'; ?>
                    <?php } ?>
                    <option value="<?php echo $store['store_id']; ?>" <?php echo $sel; ?>><?php echo $store['name']; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-title"><?php echo $entry_title; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="title" value="<?php echo $title; ?>" placeholder="<?php echo $entry_title; ?>" id="input-title" class="form-control" />
                </div>
              </div>
              
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-author"><?php echo $entry_author; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="author" value="<?php echo $author; ?>" placeholder="<?php echo $entry_author; ?>" id="input-author" class="form-control" />
                  <?php if ($error_author) { ?>
                  <div class="text-danger"><?php echo $error_author; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-email"><?php echo $entry_email; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="email" value="<?php echo $email; ?>" placeholder="<?php echo $entry_email; ?>" id="input-email" class="form-control" />
                  <?php if ($error_email) { ?>
                  <div class="text-danger"><?php echo $error_email; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-product"><span data-toggle="tooltip" title="<?php echo $help_product; ?>"><?php echo $entry_product; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="product" value="<?php echo $product; ?>" placeholder="<?php echo $entry_product; ?>" id="input-product" class="form-control" />
                  <input type="hidden" name="product_id" value="<?php echo $product_id; ?>" />
                  <?php if ($error_product) { ?>
                  <div class="text-danger"><?php echo $error_product; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-text"><?php echo $entry_text; ?></label>
                <div class="col-sm-10">
                  <textarea name="text" cols="60" rows="8" placeholder="<?php echo $entry_text; ?>" id="input-text" class="form-control"><?php echo $text; ?></textarea>
                  <?php if ($error_text) { ?>
                  <div class="text-danger"><?php echo $error_text; ?></div>
                  <?php } ?>
                </div>
              </div>
              <?php foreach($rating_types as $rating_type) { ?>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-name"><?php echo $entry_rating; ?> <?php echo $rating_type['name']; ?> : </label>
                <div class="col-sm-10">
                  <div>
                    <?php for($i=1;$i<=5;$i++) { ?>
                    <label class="radio-inline">
                      <input type="radio" name="rating[<?php echo $rating_type['ciratingtype_id']; ?>]" value="<?php echo $i; ?>" <?php if (isset($rating[$rating_type['ciratingtype_id']]) && $rating[$rating_type['ciratingtype_id']] == $i) { echo 'checked="checked"'; }?> />

                      <input type="hidden" name="cireview_rating_id[<?php echo $rating_type['ciratingtype_id']; ?>]" value="" />
                      
                      <?php echo $i; ?>
                    </label>
                    <?php } ?>
                  </div>
                  <?php if (is_array($error_rating) && isset($error_rating[$rating_type['ciratingtype_id']])) { ?>
                  <div class="text-danger"><?php echo $error_rating[$rating_type['ciratingtype_id']]; ?></div>
                  <?php } ?>
                  <?php if (!is_array($error_rating)) { ?>
                  <div class="text-danger"><?php echo $error_rating; ?></div>
                  <?php } ?>
                </div>
              </div>
              <?php } ?>         
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-comment"><?php echo $entry_comment; ?></label>
                <div class="col-sm-10">
                  <textarea name="comment" cols="60" rows="8" placeholder="<?php echo $entry_comment; ?>" id="input-comment" class="form-control"><?php echo $comment; ?></textarea>
                </div>
              </div>
              <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-votes_up"><?php echo $entry_votes_up; ?></label>
                <div class="col-sm-3">
                  <input type="text" name="votes_up" value="<?php echo $votes_up; ?>" placeholder="<?php echo $entry_votes_up; ?>" id="input-votes_up" class="form-control" />
                  <?php if ($error_votes_up) { ?>
                  <div class="text-danger"><?php echo $error_votes_up; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-votes_down"><?php echo $entry_votes_down; ?></label>
                <div class="col-sm-3">
                  <input type="text" name="votes_down" value="<?php echo $votes_down; ?>" placeholder="<?php echo $entry_votes_down; ?>" id="input-votes_down" class="form-control" />
                  <?php if ($error_votes_down) { ?>
                  <div class="text-danger"><?php echo $error_votes_down; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-date-added"><?php echo $entry_date_added; ?></label>
                <div class="col-sm-3">
                  <div class="input-group datetime">
                    <input type="text" name="date_added" value="<?php echo $date_added; ?>" placeholder="<?php echo $entry_date_added; ?>" data-date-format="YYYY-MM-DD HH:mm:ss" id="input-date-added" class="form-control" />
                    <span class="input-group-btn">
                    <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                    </span>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_imp; ?></label>
                <div class="col-sm-10">
                  <div class="btn-group" data-toggle="buttons">
                    <label class="btn btn-default <?php echo $imp ? 'active' : ''; ?>">
                      <input name="imp" <?php echo $imp ? 'checked="checked"' : ''; ?> autocomplete="off" value="1" type="radio"><?php echo $text_yes; ?>
                    </label>
                    <label class="btn btn-default <?php echo !$imp ? 'active' : ''; ?>">
                      <input name="imp" <?php echo !$imp ? 'checked="checked"' : ''; ?> autocomplete="off" value="0" type="radio"> <?php echo $text_no; ?>
                    </label>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_attachimages; ?></label>
                <div class="col-sm-3 ciattachupload">
                  <button type="button" id="button-ciattachupload" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-default btn-block"><i class="fa fa-upload"></i> <?php echo $button_upload; ?></button>
                  <input type="hidden" name="cireview_image" value="<?php echo $cireview_image; ?>" id="input-ciattachupload" />
                </div>
              </div>


              <table class="table table-bordered table-striped ciattach_images">
                <thead>
                  <tr>
                    <td class="text-left"><?php echo $entry_attachimages; ?></td>
                    <td class="text-left"><?php echo $entry_attachimage_title; ?></td>
                    <td class="text-left"><?php echo $entry_attachimage_alt; ?></td>
                    <td class="text-right"><?php echo $column_action; ?></td>
                  </tr>
                </thead>                
                <tbody id="ciattach_images">
                  <?php if($attach_images) { ?>
                  <?php foreach ($attach_images as $attach_image) { ?>
                  <tr id="ciattach_image-<?php echo $attach_image['cireview_image_id']; ?>">
                    <td class="text-left">
                      <a target="_BLANK" href="<?php echo $attach_image['popup']; ?>"><img src="<?php echo $attach_image['thumb']; ?>" alt="<?php echo $heading_title; ?>" /></a>
                    </td>
                    <td class="text-left">
                      <?php foreach ($languages as $language) { ?>
                       <div class="input-group"><span class="input-group-addon"><?php if(VERSION >= '2.2.0.0') { ?><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /><?php } else{ ?><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /><?php } ?></span>
                          <input type="text" name="attach_image[<?php echo $attach_image['cireview_image_id']; ?>][description][<?php echo $language['language_id']; ?>][title]" value="<?php echo isset($attach_image['description'][$language['language_id']]['title']) ? $attach_image['description'][$language['language_id']]['title'] : ''; ?>" placeholder="<?php echo $entry_attachimage_title; ?>" class="form-control" />
                        </div> 
                      <?php } ?> 
                    </td>
                    <td class="text-left">
                      <?php foreach ($languages as $language) { ?>
                        <div class="input-group"><span class="input-group-addon"><?php if(VERSION >= '2.2.0.0') { ?><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /><?php } else{ ?><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /><?php } ?></span>
                          <input type="text" name="attach_image[<?php echo $attach_image['cireview_image_id']; ?>][description][<?php echo $language['language_id']; ?>][alt]" value="<?php echo isset($attach_image['description'][$language['language_id']]['alt']) ? $attach_image['description'][$language['language_id']]['alt']: ''; ?>" placeholder="<?php echo $entry_attachimage_alt; ?>" class="form-control" />
                        </div> 
                      <?php } ?> 
                    </td>
                    <td class="text-right">
                      <button data-id="<?php echo $attach_image['cireview_image_id']; ?>" type="button" class="attach_image_close close" data-dismiss="alert">&times;</button>
                    </td>
                  </tr>
                  <?php } ?>
                  <?php } ?>
                </tbody>
              </table>

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
            </div>
            <div class="tab-pane" id="tab-abuses">
              <div class="table-responsive">
                <table id="abuses" class="table table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                      <td class="text-left"><?php echo $entry_abusereason; ?></td>
                      <td class="text-left"><?php echo $entry_abusereason_detail; ?></td>
                      <td></td>
                    </tr>
                  </thead>
                  <tbody>
                  <?php 
                    if($abuses) {
                    foreach ($abuses as $abuse) { ?>
                    <tr id="abuse-row<?php echo $abuse['cireview_abuse_id']; ?>">
                      <td class="text-left"><?php echo $abuse['ciabreason_name']; ?></td>
                      <td class="text-left"><?php echo $abuse['text']; ?></td>
                      <td class="text-left">
                        <button type="button" data-toggle="tooltip" title="<?php echo $button_remove; ?>" data-id="<?php echo $abuse['cireview_abuse_id']; ?>" class="btn btn-danger abuse-remove"><i class="fa fa-trash-o"></i></button>
                      </td>
                    </tr>
                    <?php } } else { ?>
                    <tr><td class="text-center" colspan="3"><?php echo $text_no_abuse; ?></td></tr>
                    <?php } ?>
                  </tbody>    
                </table>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>



  <script type="text/javascript"><!--

  $('.abuse-remove').on('click', function() {
    $('.alert').remove();

    var $this = $(this);
    var id = $this.attr('data-id');
    
    if(id) {
      var c = confirm('ki a oye');
      if(c && id) {
        $.ajax({
          url: 'index.php?route=cireviewpro/cireviews/deleteAbuse&<?php echo $module_token; ?>=<?php echo $ci_token; ?>&review_id=<?php echo $review_id; ?>',
          type: 'post',
          data: 'id=' + id,
          dataType: 'json',
          beforeSend: function() {          
          },
          complete: function() {          
          },
          success: function(json) {
            $('.alert').remove();
            if (json['success']) {
               $('#abuse-row'+id).remove();

               $('#abuses').before('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');              
            }
          },
          error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
          }
        });
      }
    }

  });


$('.datetime').datetimepicker({
  pickDate: true,
  pickTime: true
});
//--></script>
  <script type="text/javascript"><!--
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
    $('input[name=\'product\']').val(item['label']);
    $('input[name=\'product_id\']').val(item['value']);   
  } 
});

  // $('.ciattach_images').each(function() {
  //   $(this).magnificPopup({
  //     type:'image',
  //     delegate: 'a',
  //     gallery: {
  //       enabled:true
  //     }
  //   });
  // });

  $('#ciattach_images').on('click', '.attach_image_close', function() {
    var $this = $(this);
    var id = $this.attr('data-id');
    if(id && confirm("Are you sure?")) {

      $.ajax({
        url: 'index.php?route=cireviewpro/cireviews/deleteImage&<?php echo $module_token; ?>=<?php echo $ci_token; ?>&review_id=<?php echo $review_id; ?>',
        type: 'post',
        data: 'id=' + id,
        dataType: 'json',
        beforeSend: function() {          
        },
        complete: function() {          
        },
        success: function(json) {
          if (json['success']) {

            $('input[name="cireview_image"]').val(json['code']);

            if(json['attach_images']) {
              var html = '';
              for(var i in json['attach_images']) {
                  html += '<tr id="ciattach_image-'+ json['attach_images'][i]['cireview_image_id'] +'">';
                  html += '    <td class="text-left"><a target="_BLANK" href="'+ json['attach_images'][i]['popup'] +'"> <img src="'+ json['attach_images'][i]['thumb'] +'" alt="<?php echo $heading_title; ?>" /> </a></td>';
                  html += '    <td class="text-left">';
                        <?php foreach ($languages as $language) { ?>
                  html += '       <div class="input-group"><span class="input-group-addon"><?php if(VERSION >= '2.2.0.0') { ?><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /><?php } else{ ?><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /><?php } ?></span>';
                  html += '          <input type="text" name="attach_image['+ json['attach_images'][i]['cireview_image_id'] +'][description][<?php echo $language['language_id']; ?>][title]" value="'+ ((typeof json['attach_images'][i]['description'][<?php echo $language['language_id']; ?>] != 'undefined') ? json['attach_images'][i]['description'][<?php echo $language['language_id']; ?>]['title'] : '') +'" placeholder="<?php echo $entry_attachimage_title; ?>" class="form-control" />';
                  html += '        </div>';
                        <?php } ?> 
                  html += '    </td>';
                  html += '    <td class="text-left">';
                        <?php foreach ($languages as $language) { ?>
                  html += '        <div class="input-group"><span class="input-group-addon"><?php if(VERSION >= '2.2.0.0') { ?><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /><?php } else{ ?><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /><?php } ?></span>';
                  html += '          <input type="text" name="attach_image['+ json['attach_images'][i]['cireview_image_id'] +'][description][<?php echo $language['language_id']; ?>][alt]" value="'+ ((typeof json['attach_images'][i]['description'][<?php echo $language['language_id']; ?>] != 'undefined') ? json['attach_images'][i]['description'][<?php echo $language['language_id']; ?>]['alt'] :'' ) +'" placeholder="<?php echo $entry_attachimage_alt; ?>" class="form-control" />';
                  html += '        </div>';
                        <?php } ?> 
                  html += '    </td>';
                  html += '    <td class="text-right"><button data-id="'+ json['attach_images'][i]['cireview_image_id'] +'" type="button" class="attach_image_close close" data-dismiss="alert">&times;</button></td>';
                  html += '  </tr>';
                }
              $('#ciattach_images').html(html);
            }
          }
          
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
      });

    }
  });

 $('#button-ciattachupload').on('click', function() {
    var node = this;

    $('.ciattachupload .alert').remove();

    $('#form-ciattach-upload').remove();

    $('body').prepend('<form enctype="multipart/form-data" id="form-ciattach-upload" style="display: none;"><input type="file" name="ciattachfile" /><input type="hidden" name="cireview_images" value="'+ $('input[name="cireview_image"]').val() +'"></form>');

    $('#form-ciattach-upload input[name=\'ciattachfile\']').trigger('click');

    if (typeof timer != 'undefined') {
        clearInterval(timer);
    }

    timer = setInterval(function() {
      if ($('#form-ciattach-upload input[name=\'ciattachfile\']').val() != '') {
        clearInterval(timer);

        $.ajax({
          url: 'index.php?route=cireviewpro/cireviews/upload&<?php echo $module_token; ?>=<?php echo $ci_token; ?>&review_id=<?php echo $review_id; ?>',
          type: 'post',
          dataType: 'json',
          data: new FormData($('#form-ciattach-upload')[0]),
          cache: false,
          contentType: false,
          processData: false,
          beforeSend: function() {
            $(node).button('loading');
          },
          complete: function() {
            $(node).button('reset');
          },
          success: function(json) {

            $('.ciattachupload .alert').remove();

            if (json['error']) {
              $(node).parent().find('input').after('<div class="alert alert-danger"><i class="fa fa-check-circle"></i> ' + json['error'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
            }

            if (json['success']) {
              $(node).parent().find('input').after('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');

              $('input[name="cireview_image"]').val(json['code']);

              if(json['attach_images']) {
                var html = '';
                for(var i in json['attach_images']) {
                  html += '<tr id="ciattach_image-'+ json['attach_images'][i]['cireview_image_id'] +'">';
                  html += '    <td class="text-left"><a target="_BLANK" href="'+ json['attach_images'][i]['popup'] +'"> <img src="'+ json['attach_images'][i]['thumb'] +'" alt="<?php echo $heading_title; ?>" /> </a></td>';
                  html += '    <td class="text-left">';
                        <?php foreach ($languages as $language) { ?>
                  html += '       <div class="input-group"><span class="input-group-addon"><?php if(VERSION >= '2.2.0.0') { ?><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /><?php } else{ ?><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /><?php } ?></span>';
                  html += '          <input type="text" name="attach_image['+ json['attach_images'][i]['cireview_image_id'] +'][description][<?php echo $language['language_id']; ?>][title]" value="'+ ((typeof json['attach_images'][i]['description'][<?php echo $language['language_id']; ?>] != 'undefined') ? json['attach_images'][i]['description'][<?php echo $language['language_id']; ?>]['title'] : '') +'" placeholder="<?php echo $entry_attachimage_title; ?>" class="form-control" />';
                  html += '        </div>';
                        <?php } ?> 
                  html += '    </td>';
                  html += '    <td class="text-left">';
                        <?php foreach ($languages as $language) { ?>
                  html += '        <div class="input-group"><span class="input-group-addon"><?php if(VERSION >= '2.2.0.0') { ?><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /><?php } else{ ?><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /><?php } ?></span>';
                  html += '          <input type="text" name="attach_image['+ json['attach_images'][i]['cireview_image_id'] +'][description][<?php echo $language['language_id']; ?>][alt]" value="'+ ((typeof json['attach_images'][i]['description'][<?php echo $language['language_id']; ?>] != 'undefined') ? json['attach_images'][i]['description'][<?php echo $language['language_id']; ?>]['alt'] :'' ) +'" placeholder="<?php echo $entry_attachimage_alt; ?>" class="form-control" />';
                  html += '        </div>';
                        <?php } ?> 
                  html += '    </td>';
                  html += '    <td class="text-right"><button data-id="'+ json['attach_images'][i]['cireview_image_id'] +'" type="button" class="attach_image_close close" data-dismiss="alert">&times;</button></td>';
                  html += '  </tr>';
                }
                $('#ciattach_images').html(html);
              }
            }
          },
          error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
          }
        });
      }
    }, 500);
  });
//--></script>
<style type="text/css">
.btn-group .active{ background : #1872A2; color: #fff; border-color: #1872A2; }
.btn-group .btn:hover{ background : #1872A2; color: #fff; border-color: #1872A2; }
</style>
</div>
<?php echo $footer; ?>