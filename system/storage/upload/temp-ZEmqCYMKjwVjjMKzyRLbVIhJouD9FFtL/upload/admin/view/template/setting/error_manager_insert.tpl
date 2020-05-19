<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-error-insert" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $heading_title; ?></h3>
      </div>
      <div class="panel-body">
        <form action="" method="post" enctype="multipart/form-data" id="form-error-insert">
		<div class="table-responsive">
        <table class="table table-bordered table-hover">
		<tr>
        	<td><b><?php echo $text_error_url; ?></b> <label class="control-label"><span data-toggle="tooltip" title="<?php echo $text_error_url_help; ?>"></span></label></td>
            <td><textarea name="error_url" cols="80" rows="6" class="form-control"></textarea></td>
        </tr>
        <tr>
        	<td><b><?php echo $text_redirect_url; ?></b></td>
            <td><textarea name="redirect_url" cols="80" rows="2" class="form-control"></textarea></td>
        </tr>
        <tr>
        	<td><b><?php echo $text_redirect_type; ?></b></td>
            <td><select name="redirect_type" class="form-control" id="redirect_type">
                        <option value="301" >301 Moved Permanently</option>
                        <option value="302" >302 Found</option>
                        <option value="307" >307 Moved Temporarily</option>
                 </select></td>
        </tr>
        <tr>
        	<td><b><?php echo $text_redirect_author; ?></b></td>
            <td><select name="redirect_author" class="form-control" id="redirect_author">
                    <option value="1">Common Redirect</option>
                    <option value="2">404 Redirect</option>
                 </select></td>
        </tr>
        
        </table>
		</div>
      </form>
      </div>
    </div>
  </div>

<?php echo $footer; ?>
