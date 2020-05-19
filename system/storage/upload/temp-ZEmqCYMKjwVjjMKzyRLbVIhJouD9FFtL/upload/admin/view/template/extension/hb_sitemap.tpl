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
                <li class="active"><a href="#tab-sitemap" data-toggle="tab"><?php echo $tab_sitemap; ?></a></li>
                <li><a href="#tab-customlist" data-toggle="tab"><?php echo $tab_customlist; ?></a></li>
				<li><a href="#tab-seoalias" data-toggle="tab"><?php echo $tab_seoalias; ?></a></li>
                <li><a href="#tab-setting" data-toggle="tab"><?php echo $tab_setting; ?></a></li>
	          </ul>
			
			<div class="tab-content">
	            
	            <div class="tab-pane active" id="tab-sitemap">
	            
               		<ul class="nav nav-tabs" id="store">
	                <?php foreach ($stores as $store) { ?>
	                <li><a href="#store<?php echo $store['store_id']; ?>" data-toggle="tab"><?php echo $store['name']; ?></a></li>
	                <?php } ?>
	              	</ul>
                    
                    <div class="tab-content"> <!-- language tab content -->
                        <?php foreach ($stores as $store) { ?>
                            <div class="tab-pane" id="store<?php echo $store['store_id']; ?>">
								<div id="sitemap-files-<?php echo $store['store_id']; ?>"></div>
							</div>
						<?php } ?>
                    </div>

	            </div>

				<div class="tab-pane" id="tab-customlist">
				
					<ul class="nav nav-tabs" id="store2">
	                <?php foreach ($stores as $store) { ?>
	                <li><a href="#store2<?php echo $store['store_id']; ?>" data-toggle="tab"><?php echo $store['name']; ?></a></li>
	                <?php } ?>
	              	</ul>
                    
                    <div class="tab-content"> <!-- language tab content -->
                        <?php foreach ($stores as $store) { ?>
                            <div class="tab-pane" id="store2<?php echo $store['store_id']; ?>">
							
                                <table class="table table-hover">
                                <thead>
                                <tr>
                                <th><?php echo $col_header; ?></th>
                                <th><?php echo $col_freq; ?></th>
                                <th><?php echo $col_priority; ?></th>
                                <th><?php echo $col_action; ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                <td><input type="text" id="hb_loc_<?php echo $store['store_id']; ?>" value="" class="form-control" /></td>
                                <td><select class="form-control" id="hb_freq_<?php echo $store['store_id']; ?>">
                             <option>monthly</option>
                            <option>weekly</option>
                            <option>yearly</option>
                            <option>daily</option>
                            <option>hourly</option>
                            <option>always</option>
                            <option>never</option>
                            </select></td>
                                <td><select class="form-control" id="hb_priority_<?php echo $store['store_id']; ?>">
                            <?php for ($i = 1.0;$i>0.1;$i-=0.1){ ?>
                            	<option><?php echo $i; ?></option>
                            <?php }  ?>                          	
                            </select></td>
							<td><a class="btn btn-success" id="addlink" onclick="addlink('<?php echo $store['store_id']; ?>')"><?php echo $btn_add; ?></a></td>
                                </tr>
                                
                                <?php if(${"all_links".$store['store_id']}) { ?>
                                <?php foreach (${"all_links".$store['store_id']} as $all_link) { ?>
                                <tr>
                                	<td><?php echo $all_link['loc']; ?></td>
                                    <td><?php echo $all_link['freq']; ?></td>
                                    <td><?php echo $all_link['priority']; ?></td>
                                    <td><a class="btn btn-danger" id="removelink" onclick="removelink('<?php echo $all_link['id']; ?>')"><?php echo $btn_remove; ?></a></td>
                                </tr>
                                <?php } ?>
                                <?php } else { ?>
                                <tr><td colspan="5"><?php echo $text_no_records; ?></td></tr>
								<?php } ?>
                                </tbody>
                                </table>

			
                             </div>
                        <?php } ?>
                    </div>


	            </div>
	            
				 <div class="tab-pane" id="tab-seoalias">
					 <div id="seourl_holder"></div>
				 </div>
				 
	            <div class="tab-pane" id="tab-setting">
				<h3><i class="fa fa-wrench"></i> Settings</h3>
				
					<a onclick="location = '<?php echo $uninstall; ?>';" class="btn btn-danger"><i class="fa fa-trash"></i> UNINSTALL</a>
                    <a class="btn btn-warning" onclick="autogeneratemap('resetsitemapdir')"><?php echo $btn_dir; ?></a> 
					<a class="btn btn-warning" onclick="clearbatch()"><?php echo $btn_clear_batch; ?></a> 
					<hr><br>
			     	
			        <div class="form-group">
		                <label class="col-sm-4"><span><?php echo $text_link_count; ?></span></label>
		                <div class="col-sm-8">
		                  <input type="text" name="hb_sitemap_max_entries" value="<?php echo $hb_sitemap_max_entries; ?>" class="form-control" />
		                </div>
		             </div>
			         <div class="form-group">
		                <label class="col-sm-4"><span><?php echo $text_automatic; ?></span></label>
		                <div class="col-sm-8">
							<select class="form-control" name="hb_sitemap_automatic">
                            <option value="1" <?php echo ($hb_sitemap_automatic == "1")? 'selected':''; ?>>Enable</option>
                            <option value="0" <?php echo ($hb_sitemap_automatic == "0")? 'selected':''; ?>>Disable</option>
                            </select>		                
                            </div>
		             </div>
					 <div class="form-group">
		                <label class="col-sm-4"><span>Set Passkey (Any alphanumeric characters. No Spaces Allowed)</span></label>
		                <div class="col-sm-8">
		                  <input type="text" name="hb_sitemap_passkey" value="<?php echo $hb_sitemap_passkey; ?>" class="form-control" placeholder="Eg: LUZXNS122SKWDSD">
		                </div>
		             </div>
					 <div class="form-group">
		                <label class="col-sm-4"><span>Maximum Execution time (in seconds) limit while processing batches (Recommended Value: Between 10 to 30 )</span></label>
		                <div class="col-sm-8">
		                  <input type="text" name="hb_sitemap_time" value="<?php echo $hb_sitemap_time; ?>" class="form-control" placeholder="Eg: 20">
		                </div>
		             </div>

			        <hr>

			        
                    <table class="table table-hover">
                        <thead>
                        <tr>
                        <th><?php echo $col_header; ?></th><th><?php echo $col_priority; ?></th><th><?php echo $col_freq; ?></th>
                        </tr>
                        </thead>
                        <tbody>
			              <tr>
                          	<td><?php echo $col_product; ?></td>
                            <td><select class="form-control" name="hb_sitemap_product_priority" >
                            <?php for ($i = 1.0;$i>0.1;$i-=0.1){ ?>
                            	<option value="<?php echo (string)$i; ?>" <?php echo ($hb_sitemap_product_priority == (string)$i)? 'selected':''; ?>><?php echo $i; ?></option>
                            <?php }  ?>                            	
                            </select></td>
                            <td><select class="form-control" name="hb_sitemap_product_freq">
							<option <?php echo ($hb_sitemap_product_freq == "weekly")? 'selected':''; ?>>weekly</option>
                             <option <?php echo ($hb_sitemap_product_freq == "monthly")? 'selected':''; ?>>monthly</option>
                            <option <?php echo ($hb_sitemap_product_freq == "yearly")? 'selected':''; ?>>yearly</option>
                            <option <?php echo ($hb_sitemap_product_freq == "daily")? 'selected':''; ?>>daily</option>
                            <option <?php echo ($hb_sitemap_product_freq == "always")? 'selected':''; ?>>always</option>
                            <option <?php echo ($hb_sitemap_product_freq == "hourly")? 'selected':''; ?>>hourly</option>
                            <option <?php echo ($hb_sitemap_product_freq == "never")? 'selected':''; ?>>never</option>
                            </select></td>
                          </tr>
                          <tr>
                          	<td><?php echo $col_category; ?></td>
                            <td><select class="form-control" name="hb_sitemap_category_priority">
                            <?php for ($i = 1.0;$i>0.1;$i-=0.1){ ?>
                            	<option value="<?php echo (string)$i; ?>" <?php echo ($hb_sitemap_category_priority == (string)$i)? 'selected':''; ?>><?php echo $i; ?></option>
                            <?php }  ?>                          	
                            </select></td>
                            <td><select class="form-control" name="hb_sitemap_category_freq">
                            <option <?php echo ($hb_sitemap_category_freq == "monthly")? 'selected':''; ?>>monthly</option>
                             <option <?php echo ($hb_sitemap_category_freq == "weekly")? 'selected':''; ?>>weekly</option>
                            <option <?php echo ($hb_sitemap_category_freq == "yearly")? 'selected':''; ?>>yearly</option>
                           <option <?php echo ($hb_sitemap_category_freq == "always")? 'selected':''; ?>>always</option>
                            <option <?php echo ($hb_sitemap_category_freq == "daily")? 'selected':''; ?>>daily</option>
                            <option <?php echo ($hb_sitemap_category_freq == "hourly")? 'selected':''; ?>>hourly</option>
                            <option <?php echo ($hb_sitemap_category_freq == "never")? 'selected':''; ?>>never</option>
                            </select></td>
                          </tr>
                          <tr>
                          	<td><?php echo $col_brand; ?></td>
                            <td><select class="form-control" name="hb_sitemap_brand_priority">
                            <?php for ($i = 1.0;$i>0.1;$i-=0.1){ ?>
                            	<option value="<?php echo (string)$i; ?>" <?php echo ($hb_sitemap_brand_priority == (string)$i)? 'selected':''; ?>><?php echo $i; ?></option>
                            <?php }  ?>                           	
                            </select></td>
                            <td><select class="form-control" name="hb_sitemap_brand_freq">
                            <option <?php echo ($hb_sitemap_brand_freq == "monthly")? 'selected':''; ?>>monthly</option>
                            <option <?php echo ($hb_sitemap_brand_freq == "weekly")? 'selected':''; ?>>weekly</option>
                            <option <?php echo ($hb_sitemap_brand_freq == "yearly")? 'selected':''; ?>>yearly</option>
                            <option <?php echo ($hb_sitemap_brand_freq == "daily")? 'selected':''; ?>>daily</option>
                            <option <?php echo ($hb_sitemap_brand_freq == "always")? 'selected':''; ?>>always</option>
                            <option <?php echo ($hb_sitemap_brand_freq == "hourly")? 'selected':''; ?>>hourly</option>
                            <option <?php echo ($hb_sitemap_brand_freq == "never")? 'selected':''; ?>>never</option>
                            </select></td>
                          </tr>
                          <tr>
                          	<td><?php echo $col_info; ?></td>
                            <td><select class="form-control" name="hb_sitemap_info_priority">
                            <?php for ($i = 1.0;$i>0.1;$i-=0.1){ ?>
                            	<option value="<?php echo (string)$i; ?>" <?php echo ($hb_sitemap_info_priority == (string)$i)? 'selected':''; ?>><?php echo $i; ?></option>
                            <?php }  ?>                            	
                            </select></td>
                           <td><select class="form-control" name="hb_sitemap_info_freq">
                            <option <?php echo ($hb_sitemap_info_freq == "monthly")? 'selected':''; ?>>monthly</option>
                            <option <?php echo ($hb_sitemap_info_freq == "weekly")? 'selected':''; ?>>weekly</option>
                            <option <?php echo ($hb_sitemap_info_freq == "yearly")? 'selected':''; ?>>yearly</option>
                            <option <?php echo ($hb_sitemap_info_freq == "daily")? 'selected':''; ?>>daily</option>
                            <option <?php echo ($hb_sitemap_info_freq == "always")? 'selected':''; ?>>always</option>
                            <option <?php echo ($hb_sitemap_info_freq == "hourly")? 'selected':''; ?>>hourly</option>
                            <option <?php echo ($hb_sitemap_info_freq == "never")? 'selected':''; ?>>never</option>
                            </select></td>
                          </tr>
                
                          <tr>
                          	<td><?php echo $col_tag; ?></td>
                            <td><select class="form-control" name="hb_sitemap_tag_priority">
                            <?php for ($i = 1.0;$i>0.1;$i-=0.1){ ?>
                            	<option value="<?php echo (string)$i; ?>" <?php echo ($hb_sitemap_tag_priority == (string)$i)? 'selected':''; ?>><?php echo $i; ?></option>
                            <?php }  ?>                             	
                            </select></td>
                            <td><select class="form-control" name="hb_sitemap_tag_freq">
                            <option <?php echo ($hb_sitemap_tag_freq == "monthly")? 'selected':''; ?>>monthly</option>
                            <option <?php echo ($hb_sitemap_tag_freq == "weekly")? 'selected':''; ?>>weekly</option>
                            <option <?php echo ($hb_sitemap_tag_freq == "yearly")? 'selected':''; ?>>yearly</option>
                            <option <?php echo ($hb_sitemap_tag_freq == "daily")? 'selected':''; ?>>daily</option>
                            <option <?php echo ($hb_sitemap_tag_freq == "always")? 'selected':''; ?>>always</option>
                            <option <?php echo ($hb_sitemap_tag_freq == "hourly")? 'selected':''; ?>>hourly</option>
                            <option <?php echo ($hb_sitemap_tag_freq == "never")? 'selected':''; ?>>never</option>
                            </select></td>
                          </tr>
                          </tbody>
                         </table>
						 
					<div class="form-group">
		                <label class="col-sm-4"><span>CRON JOB COMMAND FOR PRODUCT XML SITEMAP GENERATION</span></label>
		                <div class="col-sm-8">
		                  <div class="alert alert-info">wget --quiet --delete-after "<?php echo HTTP_CATALOG;?>index.php?route=sitemap/hb_sitemap/productxmlcron&store_id=all&cron=1&passkey=<?php echo $hb_sitemap_passkey; ?>"</div>
		                </div>
		             </div>
					 
					 <div class="form-group">
		                <label class="col-sm-4"><span>CRON JOB COMMAND FOR PRODUCT TAGS XML SITEMAP GENERATION</span></label>
		                <div class="col-sm-8">
		                 <div class="alert alert-info">wget --quiet --delete-after "<?php echo HTTP_CATALOG;?>index.php?route=sitemap/hb_sitemap/producttagxmlcron&store_id=all&cron=1&passkey=<?php echo $hb_sitemap_passkey; ?>"</div>
		                </div>
		             </div>
					 
					 <div class="form-group">
		                <label class="col-sm-4"><span>CRON JOB COMMAND FOR CATEGORY / BRAND / INFORMATION PAGES / CUSTOM LINKS SITEMAP GENERATION</span></label>
		                <div class="col-sm-8">
		                  <div class="alert alert-info">wget --quiet --delete-after "<?php echo HTTP_CATALOG;?>index.php?route=sitemap/hb_sitemap/micxmlcron&passkey=<?php echo $hb_sitemap_passkey; ?>"</div>
		                </div>
		             </div>
	            </div>
            </div>
 			
          </form>
    	
      </div>
    </div>
  </div>
  <div class="container-fluid"> <!--Huntbee copyrights-->
 <center>
 <span style="color:#00CCCC; font-style:italic">If your website is using multi-language URL, contact our support for implementing multi-language URL XML Sitemap. Additional customization work charge is applicable.</span><br /><br />
  <span class="help">XML SITEMAP GENERATOR PRO VERSION <?php echo $extension_version; ?> &copy; <a href="http://www.huntbee.com/">HUNTBEE.COM</a> | <a href="http://www.huntbee.com/index.php?route=account/support/">SUPPORT</a></span></center>
</div><!--Huntbee copyrights end-->
</div>

<script type="text/javascript"><!--
$('#store a:first').tab('show');
$('#store2 a:first').tab('show');
//--></script>
<script type="text/javascript"><!--
$( document ).ready(function() {
    loadsitemapfiles();
	loadseourlholder();
});
function loadsitemapfiles(){
<?php foreach ($stores as $store) { ?>
	$('#sitemap-files-<?php echo $store['store_id']; ?>').load('index.php?route=extension/hb_sitemap/loadsitemapfiles&token=<?php echo $token; ?>&store_id=<?php echo $store['store_id']; ?>');
<?php } ?>
}

function loadseourlholder(){
	$('#seourl_holder').load('index.php?route=extension/hb_sitemap/loadseourlholder&token=<?php echo $token; ?>');
}
</script>
<script type="text/javascript">
function clearbatch(){
	$('#msgoutput').html('');
	$("html, body").animate({ scrollTop: 0 }, "slow");
	$('#loadgif').show();
	$.ajax({
		  type: 'post',
		  url: '../index.php?route=sitemap/hb_sitemap/resetbatch&passkey=<?php echo $hb_sitemap_passkey; ?>',
		  dataType: 'json',
		  success: function(json) {
				if (json['success']) {
					  loadsitemapfiles();
					  $('#msgoutput').html(json['success']);
					  $('#loadgif').hide();
				}
		  },			
			error: function(xhr, ajaxOptions, thrownError) {
				$('#loadgif').hide();
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}

	 });
					
}

function generatemap(store_id,button){
	$('#msgoutput').html('');
	$("html, body").animate({ scrollTop: 0 }, "slow");
	$('#loadgif').show();
	$.ajax({
		  type: 'post',
		  url: '../index.php?route=sitemap/hb_sitemap/'+button+'&store_id='+store_id+'&passkey=<?php echo $hb_sitemap_passkey; ?>',
		  data: {store_id: store_id},
		  dataType: 'json',
		  success: function(json) {
				if (json['success']) {
					  $('#msgoutput').html(json['success']);
					  $('#loadgif').hide();
					  loadsitemapfiles();
				}
		  },			
			error: function(xhr, ajaxOptions, thrownError) {
				$('#loadgif').hide();
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}	  
	 });
}

function resetproductbatch (id,column){
	$('#msgoutput').html('');
	$('#loadgif').show();
	$.ajax({
		  type: 'post',
		  url: 'index.php?route=extension/hb_sitemap/resetproductbatch&token=<?php echo $token; ?>',
		  data: {id: id, column : column},
		  dataType: 'json',
		  success: function(json) {
				if (json['success']) {
						loadsitemapfiles();	
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

function addlink(store_id){
	$('#msgoutput').html('');
	$('#loadgif').show();
	$.ajax({
		  type: 'post',
		  url: 'index.php?route=extension/hb_sitemap/addlink&token=<?php echo $token; ?>',
		  data: {loc: $('#hb_loc_'+store_id).val(), freq: $('#hb_freq_'+store_id).val(), priority:$('#hb_priority_'+store_id).val(), store_id: store_id},
		  dataType: 'json',
		  success: function(json) {
				if (json['success']) {
					  $('#msgoutput').html(json['success']);
					  $('#loadgif').hide();
					  $("html, body").animate({ scrollTop: 0 }, "slow");
					  //window.setTimeout(function(){location.reload()},2000)
				}
		  },			
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}

	 });					
}

function removelink(id){
	$('#msgoutput').html('');
	$('#loadgif').show();
	$.ajax({
		  type: 'post',
		  url: 'index.php?route=extension/hb_sitemap/removelink&token=<?php echo $token; ?>',
		  data: {id: id},
		  dataType: 'json',
		  success: function(json) {
				if (json['success']) {
					  $('#msgoutput').html(json['success']);
					  $('#loadgif').hide();
					  $("html, body").animate({ scrollTop: 0 }, "slow");
					 // window.setTimeout(function(){location.reload()},2000)
				}
		  },			
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}

	 });					
}

function generateSeo(button){
	$('#msgoutput').html('');
	 $("html, body").animate({ scrollTop: 0 }, "slow");
	$('#loadgif').show();
	$.ajax({
		  type: 'post',
		  url: '../index.php?route=sitemap/hb_sitemap/'+button,
		  dataType: 'json',
		  success: function(json) {
				if (json['success']) {
					  loadseourlholder();
					  $('#msgoutput').html(json['success']);
					  $('#loadgif').hide();
				}
		  },			
			error: function(xhr, ajaxOptions, thrownError) {
				$('#loadgif').hide();
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
	 });
}
function clearSeo(button){
	$('#msgoutput').html('');
	$("html, body").animate({ scrollTop: 0 }, "slow");	$('#loadgif').show();
	$.ajax({
		  type: 'post',
		  url: '../index.php?route=sitemap/hb_sitemap/clearseo&passkey=<?php echo $hb_sitemap_passkey; ?>',
		  data: {clearname: button},
		  dataType: 'json',
		  success: function(json) {
				if (json['success']) {
					  loadseourlholder();
					  $('#msgoutput').html(json['success']);
					  $('#loadgif').hide();
				}
		  },			
			error: function(xhr, ajaxOptions, thrownError) {
				$('#loadgif').hide();
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
	 });
}

function autogeneratemap(button){
	$('#msgoutput').html('');
	$("html, body").animate({ scrollTop: 0 }, "slow");
	$('#loadgif').show();
	$.ajax({
		  type: 'post',
		  url: 'index.php?route=extension/hb_sitemap/'+button+'&token=<?php echo $token; ?>',
		  dataType: 'json',
		  success: function(json) {
				if (json['success']) {
					  $('#msgoutput').html(json['success']);
					  $('#loadgif').hide();
					  loadsitemapfiles();
				}
		  },			
			error: function(xhr, ajaxOptions, thrownError) {
				$('#loadgif').hide();
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}	  
	 });
					
}
</script>
<?php echo $footer; ?>