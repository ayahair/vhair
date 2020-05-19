<?php echo $header; ?><?php echo $column_left; ?>

<div id="content">
<!--Header Start-->
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-latest" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
	  </div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
 <!--Header End--> 
 
  <div class="container-fluid">
    <!--Start - Error / Success Message if any -->
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
	<!--End - Error / Success Message if any -->
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $heading_title; ?></h3>
      </div>
      <div class="panel-body">
      		
      	<center><div id='loadgif' style='display:none;'><img src='view/image/loading-bar.gif'/></div></center>
		<div id="msgoutput" style="text-align:center;"></div>


          <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-language" class="form-horizontal">
			<ul class="nav nav-tabs" id="language">
			<?php foreach ($languages as $language) { ?>
			<li><a href="#language<?php echo $language['language_id']; ?>" data-toggle="tab"><?php echo $language['name']; ?></a></li>
			<?php } ?>
			</ul>
	              	
			<div class="tab-content"> <!-- language tab content -->
			<?php foreach ($languages as $language) { ?>
			<div class="tab-pane" id="language<?php echo $language['language_id']; ?>">			
			<table class="table table-hover">
				<tr>
				<td><b><?php echo $entry_stop_words; ?></b></td>
				<td><textarea rows="3" class="form-control" name="hb_tags_stopwords_<?php echo $language['language_id']; ?>" ><?php echo ${"hb_tags_stopwords_".$language['language_id']};?></textarea></td>
				<td><?php echo $help_stop_words; ?></td>
				<td></td>
			  </tr>
			  <tr>
				<td class="col-sm-4"><b><?php echo $entry_parameters; ?> </b></td>
				<td><textarea rows="3" class="form-control" name="hb_tags_parameter_<?php echo $language['language_id']; ?>" ><?php echo ${"hb_tags_parameter_".$language['language_id']};?></textarea></td>
				<td class="col-sm-2"><?php echo $help_parameters; ?></td>
				<td class="col-sm-2"><a class="btn btn-primary" onclick="generatetags('<?php echo $language['language_id']; ?>')"><?php echo $btn_generate; ?></a> <a class="btn btn-danger" onclick="cleartags('<?php echo $language['language_id']; ?>')"><?php echo $btn_clear; ?></a></td>
			  </tr>
			  
			  <tr>
				<td><b><?php echo $text_report; ?></b></td>
				<td colspan="3"><div style="color:#339999; font-weight:bold;" id="graph_<?php echo $language['language_id']; ?>"></div></td>
			  </tr>
			 </table>
			</div>
			<?php } ?>
	  </div> <!-- language tab content end-->
	  		<hr>    
	          <table class="table table-hover">
              <tr>
                <td class="col-sm-4" style="color:#009900; font-weight:bold;"><?php echo $entry_automatic; ?></td>
                <td class="col-sm-4"><select name="hb_tags_auto" class="form-control">
							  <option value="1" <?php echo ($hb_tags_auto == 1)? 'selected':''; ?> >Yes</option>
							  <option value="0" <?php echo ($hb_tags_auto == 0)? 'selected':''; ?> >No</option>
							  </select></td>
				<td class="col-sm-2"><?php echo $help_automatic; ?></td>
              	<td class="col-sm-2"></td>
              </tr>
             </table>
			 <hr>
          </form>
      </div>
    </div>
  </div>
  <div class="container-fluid"> <!--Huntbee copyrights-->
 <center>
  <span class="help"><?php echo $heading_title; ?> (EV <?php echo $extension_version;?>) &copy; <a href="http://www.huntbee.com/">WWW.HUNTBEE.COM</a> | <a href="http://www.huntbee.com/product-support">SUPPORT</a> | <a href="<?php echo $uninstall;?>">UNINSTALL</a></span></center>
</div><!--Huntbee copyrights end-->
</div>
<script type="text/javascript"><!--
$( document ).ready(function() {
    loadgraph();
});
function loadgraph(){
<?php foreach ($languages as $language) { ?>
	$('#graph_<?php echo $language['language_id']; ?>').load('index.php?route=extension/hb_tags/graph&token=<?php echo $token; ?>&language_id=<?php echo $language['language_id']; ?>');
<?php } ?>
}
//--></script>
<script type="text/javascript"><!--
$('#language a:first').tab('show');
//--></script>
<script type="text/javascript">
function generatetags(language_id){
	$('#msgoutput').html('');
	$('#loadgif').show();
	$.ajax({
		  type: 'post',
		  url: 'index.php?route=extension/hb_tags/generate&token=<?php echo $token; ?>',
		  data: {language_id: language_id},
		  dataType: 'json',
		  success: function(json) {
				if (json['success']) {
					 loadgraph();
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

function cleartags(language_id){
	$('#msgoutput').html('');
	$('#loadgif').show();
	$.ajax({
		  type: 'post',
		  url: 'index.php?route=extension/hb_tags/cleartags&token=<?php echo $token; ?>',
		  data: {language_id: language_id},
		  dataType: 'json',
		  success: function(json) {
				if (json['success']) {
						loadgraph();
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
</script>
<?php echo $footer; ?>