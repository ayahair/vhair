<!-- /*start working 25 july */ --><?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-cireviewlatest" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-cireviewlatest" class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-name"><?php echo $entry_name; ?></label>
            <div class="col-sm-10">
              <input type="text" name="name" value="<?php echo $name; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name" class="form-control" />
              <?php if ($error_name) { ?>
              <div class="text-danger"><?php echo $error_name; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-limit"><?php echo $entry_limit; ?></label>
            <div class="col-sm-10">
              <input type="text" name="limit" value="<?php echo $limit; ?>" placeholder="<?php echo $entry_limit; ?>" id="input-limit" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-ratingshow"><?php echo $entry_ratingshow; ?></label>
            <div class="col-sm-10">
              <div class="btn-group" data-toggle="buttons">
                <label class="btn btn-default <?php echo $ratingshow=='1' ? 'active' : ''; ?>">
                  <input name="ratingshow" <?php echo $ratingshow=='1' ? 'checked="checked"' : ''; ?> autocomplete="off" value="1" type="radio"><?php echo $text_yes; ?>
                </label>
                <label class="btn btn-default <?php echo $ratingshow=='0' ? 'active' : ''; ?>">
                  <input name="ratingshow" <?php echo $ratingshow=='0' ? 'checked="checked"' : ''; ?> autocomplete="off" value="0" type="radio"> <?php echo $text_no; ?>
                </label>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-ratingshowcount"><?php echo $entry_ratingshowcount; ?></label>
            <div class="col-sm-10">
              <div class="btn-group" data-toggle="buttons">
                <label class="btn btn-default <?php echo $ratingshowcount=='1' ? 'active' : ''; ?>">
                  <input name="ratingshowcount" <?php echo $ratingshowcount=='1' ? 'checked="checked"' : ''; ?> autocomplete="off" value="1" type="radio"><?php echo $text_yes; ?>
                </label>
                <label class="btn btn-default <?php echo $ratingshowcount=='0' ? 'active' : ''; ?>">
                  <input name="ratingshowcount" <?php echo $ratingshowcount=='0' ? 'checked="checked"' : ''; ?> autocomplete="off" value="0" type="radio"> <?php echo $text_no; ?>
                </label>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-titleshow"><?php echo $entry_titleshow; ?></label>
            <div class="col-sm-10">
              <div class="btn-group" data-toggle="buttons">
                <label class="btn btn-default <?php echo $titleshow=='1' ? 'active' : ''; ?>">
                  <input name="titleshow" <?php echo $titleshow=='1' ? 'checked="checked"' : ''; ?> autocomplete="off" value="1" type="radio"><?php echo $text_yes; ?>
                </label>
                <label class="btn btn-default <?php echo $titleshow=='0' ? 'active' : ''; ?>">
                  <input name="titleshow" <?php echo $titleshow=='0' ? 'checked="checked"' : ''; ?> autocomplete="off" value="0" type="radio"> <?php echo $text_no; ?>
                </label>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-reviewaddon"><?php echo $entry_reviewaddon; ?></label>
            <div class="col-sm-10">
              <div class="btn-group" data-toggle="buttons">
                <label class="btn btn-default <?php echo $reviewaddon=='DAYSAGO' ? 'active' : ''; ?>">
                  <input name="reviewaddon" <?php echo $reviewaddon=='DAYSAGO' ? 'checked="checked"' : ''; ?> autocomplete="off" value="DAYSAGO" type="radio"><?php echo $entry_daysago; ?>
                </label>
                <label class="btn btn-default <?php echo $reviewaddon=='DATEFORMAT' ? 'active' : ''; ?>">
                  <input name="reviewaddon" <?php echo $reviewaddon=='DATEFORMAT' ? 'checked="checked"' : ''; ?> autocomplete="off" value="DATEFORMAT" type="radio"> <?php echo $entry_dateformat; ?>
                </label>
              </div>
            </div>
          </div>
          <div class="form-group reviewaddon-dateformat">
            <label class="col-sm-2 control-label" for="input-dateformat"><?php echo $entry_dateformat; ?></label>
            <div class="col-sm-10">
              <input name="dateformat" value="<?php echo $dateformat; ?>" placeholder="<?php echo $entry_dateformat; ?>" id="input-dateformat" class="form-control" type="text" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-productthumb"><?php echo $entry_productthumb; ?></label>
            <div class="col-sm-10">
              <div class="row">
                <div class="col-sm-6">
                  <div class="input-group">
                  <input type="text" name="productthumb_width" value="<?php echo $productthumb_width; ?>" placeholder="<?php echo $text_width; ?>" id="input-productthumb-width" class="form-control" />
                  <span class="input-group-btn">
                    <button type="button" class="btn btn-primary"><i class="fa fa-arrows-h"></i></button>
                  </span>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="input-group">
                  <input type="text" name="productthumb_height" value="<?php echo $productthumb_height; ?>" placeholder="<?php echo $text_height; ?>"  id="input-productthumb-height" class="form-control" />
                  <span class="input-group-btn">
                    <button type="button" class="btn btn-primary"><i class="fa fa-arrows-v"></i></button>
                  </span>
                  </div>
                </div>
              </div> 
              <?php if ($error_productthumb) { ?>
              <div class="text-danger"><?php echo $error_productthumb; ?></div>
              <?php } ?>                                                        
            </div>
          </div>
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
        </form>
      </div>
    </div>
  </div>
  <script type="text/javascript"><!--  
  $('input[name="reviewaddon"]').on('change', function() {
  if($(this).val()=='DATEFORMAT') {
    $('.reviewaddon-dateformat').show();
  } else {
    $('.reviewaddon-dateformat').hide();
  }
  });
  $('input[name="reviewaddon"]:checked').trigger('change');  
  //--></script>
 </div>
<?php echo $footer; ?><!-- /*end working 25 july */ -->