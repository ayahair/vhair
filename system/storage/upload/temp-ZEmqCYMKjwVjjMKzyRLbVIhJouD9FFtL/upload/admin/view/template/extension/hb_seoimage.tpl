<?php echo $header; ?><?php echo $column_left; ?>

<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-latest" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $heading_title; ?></h3>
      </div>
      <div class="panel-body">
      <br>
      	<center><div id='loadgif' style='display:none;'><img src='view/image/loading-bar.gif'/></div></center>
		<div id="msgoutput" style="text-align:center;"></div>
        <br>


          <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-language" class="form-horizontal">
	         <ul class="nav nav-tabs">
                <li class="active"><a href="#tab-dashboard" data-toggle="tab"><?php echo $tab_dashboard; ?></a></li>
                <li><a href="#tab-setting" data-toggle="tab"><?php echo $tab_setting; ?></a></li>
	          </ul>
			
			<div class="tab-content">
	            
	            <div class="tab-pane active" id="tab-dashboard">
	            	<div id="ext-dashboard"></div>
	            </div>

	            <div class="tab-pane" id="tab-setting">
				<h3><i class="fa fa-wrench"></i> Settings</h3>
				
					<a onclick="location = '<?php echo $uninstall; ?>';" class="btn btn-danger"><i class="fa fa-trash"></i> UNINSTALL</a><br /><hr />
			     	
			        <div class="form-group">
		                <label class="col-sm-4"><span><?php echo $text_link_count; ?></span></label>
		                <div class="col-sm-8">
		                  <input type="text" name="hb_seoimage_max_entries" value="<?php echo $hb_seoimage_max_entries; ?>" class="form-control" />
		                </div>
		             </div>
			        <hr>
					<div class="form-group">
		                <label class="col-sm-4"><span><?php echo $text_language; ?></span></label>
		                <div class="col-sm-8">
							<select class="form-control" name="hb_seoimage_language">
                            <?php foreach ($languages as $language) { ?>
							  <option value="<?php echo $language['language_id']; ?>" <?php echo ($hb_seoimage_language ==  $language['language_id'])? 'selected':''; ?> ><?php echo $language['name']; ?></option>
			                 <?php } ?> 
                            </select>		                
                            </div>
		             </div>
			        <hr>
					
					<div class="form-group">
		                <label class="col-sm-4"><span><?php echo $text_target_folder; ?></span></label>
		                <div class="col-sm-8">
		                  <input type="text" name="hb_seoimage_target_folder" placeholder="products" value="<?php echo $hb_seoimage_target_folder; ?>" class="form-control" />
		                </div>
		             </div>
			        <hr>
					<div class="form-group">
		                <label class="col-sm-4"><span><?php echo $text_unassigned_folder; ?></span></label>
		                <div class="col-sm-8">
		                  <input type="text" name="hb_seoimage_unassigned_folder" placeholder="others" value="<?php echo $hb_seoimage_unassigned_folder; ?>" class="form-control" />
		                </div>
		             </div>
					 <div class="form-group">
		                <label class="col-sm-4"><span><?php echo $text_retain_filetype; ?></span></label>
		                <div class="col-sm-8">
							<input type="checkbox" value="1" name="hb_seoimage_retain_type" class="form-control" <?php echo ($hb_seoimage_retain_type == 1)? 'checked':''; ?> />
							<br /><span style="color:#FF6600; font-style:italic">A JPG extension image is recommended for SEO, however if you are using images that has transparent background, changing the image type (eg: <strong>.png</strong> or <strong>.gif</strong>) to <strong>.jpg</strong> will remove the transparent property. Carefully select this setting.</span>
		                </div>
		             </div>
			        <hr>

	            </div>
            </div>
 			
          </form>
    	
      </div>
    </div>
  </div>
  <div class="container-fluid"> <!--Huntbee copyrights-->
 <center>
 <span style="color:#FF0000; font-style:italic"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Image folder backup and database backup is strictly recommended</span><br /><br />
  <span class="help"><?php echo $heading_title; ?> VERSION <?php echo $extension_version;?> &copy; <a href="http://www.huntbee.com/">HUNTBEE.COM</a> | <a href="http://www.huntbee.com/index.php?route=account/support/">SUPPORT</a></span></center>
</div><!--Huntbee copyrights end-->
</div>

<script type="text/javascript"><!--
$('#store a:first').tab('show');
$('#store2 a:first').tab('show');
//--></script>
<script type="text/javascript"><!--
$( document ).ready(function() {
    loaddashboard();
});
function loaddashboard(){
	$('#ext-dashboard').load('index.php?route=extension/hb_seoimage/loaddashboard&token=<?php echo $token; ?>');
}
</script>
<script type="text/javascript">
function batchestimate(){
	$('#msgoutput').html('');
	$('#loadgif').show();
	$.ajax({
		  type: 'post',
		  url: 'index.php?route=extension/hb_seoimage/estimatebatch&token=<?php echo $token; ?>',
		  dataType: 'json',
		  success: function(json) {
				if (json['success']) {
					  $('#msgoutput').html(json['success']);
					  $('#loadgif').hide();
					  $("html, body").animate({ scrollTop: 0 }, "slow");
					  loaddashboard();
				}
		  },			
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}	  
	 });
}

function clearbatch(){
	$('#msgoutput').html('');
	$('#loadgif').show();
	$.ajax({
		  type: 'post',
		  url: 'index.php?route=extension/hb_seoimage/resetbatch&token=<?php echo $token; ?>',
		  dataType: 'json',
		  success: function(json) {
				if (json['success']) {
					  loaddashboard();
					  $('#msgoutput').html(json['success']);
					  $('#loadgif').hide();
					  $("html, body").animate({ scrollTop: 0 }, "slow");
					  
				}
		  },			
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
	 });
}

function generatebatchmap(id){
	$('#msgoutput').html('');
	$('#loadgif').show();
	$.ajax({
		  type: 'post',
		  url: 'index.php?route=extension/hb_seoimage/renameproductimage&token=<?php echo $token; ?>',
		  data: {id: id},
		  dataType: 'json',
		  success: function(json) {
				if (json['success']) {
					  $('#msgoutput').html(json['success']);
					  $('#loadgif').hide();
					  $("html, body").animate({ scrollTop: 0 }, "slow");
					   loaddashboard();
				}
		  },			
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}	  
	 });
}

function generateaddmap(id){
	$('#msgoutput').html('');
	$('#loadgif').show();
	$.ajax({
		  type: 'post',
		  url: 'index.php?route=extension/hb_seoimage/renameadditionalproductimage&token=<?php echo $token; ?>',
		  data: {id: id},
		  dataType: 'json',
		  success: function(json) {
				if (json['success']) {
					  $('#msgoutput').html(json['success']);
					  $('#loadgif').hide();
					  $("html, body").animate({ scrollTop: 0 }, "slow");
					   loaddashboard();
				}
		  },			
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}	  
	 });
}

function resetproductbatch (id,column){
	$('#msgoutput').html('');
	$("html, body").animate({ scrollTop: 0 }, "slow"); 
	$('#loadgif').show();
	$.ajax({
		  type: 'post',
		  url: 'index.php?route=extension/hb_seoimage/resetproductbatch&token=<?php echo $token; ?>',
		  data: {id: id, column : column},
		  dataType: 'json',
		  success: function(json) {
				if (json['success']) {
						loaddashboard();	
					  $('#msgoutput').html(json['success']);
					  $('#loadgif').hide();
				}
		  },			
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}

	 });
					
}

function autogenerate(button){
	$('#msgoutput').html('');
	$("html, body").animate({ scrollTop: 0 }, "slow");
	$('#loadgif').show();
	$.ajax({
		  type: 'post',
		  url: 'index.php?route=extension/hb_seoimage/'+button+'&token=<?php echo $token; ?>',
		  dataType: 'json',
		  success: function(json) {
				if (json['success']) {
					  $('#msgoutput').html(json['success']);
					  $('#loadgif').hide();
					 loaddashboard();
				}
		  },			
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}	  
	 });
}
</script>
<?php echo $footer; ?>