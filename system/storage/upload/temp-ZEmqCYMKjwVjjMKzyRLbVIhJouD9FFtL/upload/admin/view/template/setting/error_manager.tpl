<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right"><a href="<?php echo $insert; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>
        <button type="submit" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary" onclick="$('#form-setting').prop('action', '<?php echo $action; ?>'); $('#form-setting').prop('target', '_self'); $('#form-setting').submit();"><i class="fa fa-save"></i></button>
        <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="$('#form-errors').prop('action', '<?php echo $delete; ?>'); $('#form-errors').prop('target', '_self'); $('#form-errors').submit();"><i class="fa fa-trash-o"></i></button>
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
      <div class="panel-body">
      	<ul class="nav nav-tabs">
            <li class="active"><a href="#tab-manager" data-toggle="tab"><i class="fa fa-link"></i> <?php echo $tab_manager; ?></a></li>
            <li><a href="#tab-setting" data-toggle="tab"><i class="fa fa-gears"></i> <?php echo $tab_setting; ?></a></li>
	        <li><a href="#tab-tools" data-toggle="tab"><i class="fa fa-wrench"></i> <?php echo $tab_tools; ?></a></li>
        </ul>
        <div class="tab-content">  <!--class tab-content -->
	         <div class="tab-pane active" id="tab-manager">
        <div class="well">
          <div class="row">
            <div class="col-sm-4">
				<div class="form-group">
                <label class="control-label" for="input-status"><?php echo $filter_type; ?></label>
                <select name="type" class="form-control">
                		<option value="0" <?php echo ($type==0)? 'selected':'' ?>>ALL</option>
                        <option value="301" <?php echo ($type==301)? 'selected':'' ?>>301 Moved Permanently</option>
                        <option value="302" <?php echo ($type==302)? 'selected':'' ?>>302 Found</option>
                        <option value="307" <?php echo ($type==307)? 'selected':'' ?>>307 Moved Temporarily</option>
                 </select>
              </div>
            </div>
            <div class="col-sm-4">
				<div class="form-group">
                <label class="control-label" for="input-status"><?php echo $filter_author; ?></label>
                <select name="author" class="form-control">
                        <option value="0" <?php echo ($author==0)? 'selected':'' ?>>ALL</option>
                        <option value="1" <?php echo ($author==1)? 'selected':'' ?>>General- Admin Added</option>
                        <option value="2" <?php echo ($author==2)? 'selected':'' ?>>404 - Admin Added</option>
                        <option value="3" <?php echo ($author==3)? 'selected':'' ?>>404 System Recorded</option>
                 </select>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="input-status"><?php echo $filter_link; ?></label>
                <select name="link" class="form-control">
                        <option value="0" <?php echo ($link==0)? 'selected':'' ?>><?php echo $option_all; ?></option>
                        <option value="1" <?php echo ($link==1)? 'selected':'' ?>><?php echo $option_blank_redirect; ?></option>
                        <option value="2" <?php echo ($link==2)? 'selected':'' ?>><?php echo $option_filled_redirect; ?></option>
                 </select>
              </div>
              <button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-search"></i> <?php echo $button_filter; ?></button>
            </div>
          </div>
        </div>
        
             	<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-errors">
                      <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                          <thead>
                            <tr>
                              <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                              <td class="text-left"><?php echo $column_error_url; ?></td>
                              <td class="text-left"><?php echo $column_redirect_url; ?></td>
                              <td class="text-right"><?php if ($sort == 'hits') { ?>
                                <a href="<?php echo $sort_hits; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_hits; ?></a>
                                <?php } else { ?>
                                <a href="<?php echo $sort_hits; ?>"><?php echo $column_hits; ?></a>
                                <?php } ?></td>
                                <td class="text-right"><?php echo $column_redirect_hits; ?></td>
                              <td class="text-left"><?php echo $column_referrer; ?></td>
                               <td class="text-right"><?php if ($sort == 'date_modified') { ?>
                                <a href="<?php echo $sort_date_modified; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_recent_date; ?></a>
                                <?php } else { ?>
                                <a href="<?php echo $sort_date_modified; ?>"><?php echo $column_recent_date; ?></a>
                                <?php } ?></td>
                            </tr>
                          </thead>
                          <tbody>
                            <?php if ($errorlinks) { ?>
                            <?php foreach ($errorlinks as $errorlink) { ?>
                            <tr>
                              <td style="text-align: center;"><?php if ($errorlink['selected']) { ?>
                                <input type="checkbox" name="selected[]" value="<?php echo $errorlink['id']; ?>" checked="checked" />
                                <?php } else { ?>
                                <input type="checkbox" name="selected[]" value="<?php echo $errorlink['id']; ?>" />
                                <?php } ?></td>
                              <td class="text-left"><?php echo $errorlink['error']; ?>  <a href="<?php echo $errorlink['error']; ?>" target="_blank" title="<?php echo $text_open_new_tab; ?>"><i class="fa fa-external-link"></i></a>
                                                    <span id="author"><?php echo $errorlink['author']; ?></span>
							  </td>
                              <td class="text-left">
                              
                              <input class="form-control" name="redirect" id="redirect" value="<?php echo $errorlink['redirect']; ?>" size="50" onblur="updateredirect(this.value,'<?php echo $errorlink['id']; ?>')">
                              <span id="code<?php echo $errorlink['type']; ?>"><?php echo $errorlink['type']; ?></span>
                              <div id='loadingmessage<?php echo $errorlink['id']; ?>' style='display:none'><img src='view/image/loading.gif'/></div><br /><div id="msg<?php echo $errorlink['id']; ?>"></div>
                              </td>
                              
                              
                              <td class="text-right"><?php echo $errorlink['hits']; ?> </td>
                              <td class="text-right"><?php echo $errorlink['redirect_hits']; ?> </td>
                              <td class="text-left"><a class="ajax" href="<?php echo $view_referrer; ?>&id=<?php echo $errorlink['id']; ?>" title="<?php echo $errorlink['error']; ?>">View Referrers</a></td>
                              <td class="text-right"><?php echo $errorlink['date_modified']; ?></td>
                            </tr>
                            <?php } ?>
                            <?php } else { ?>
                            <tr>
                              <td class="center" colspan="7"><?php echo $text_no_results; ?></td>
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
             </div><!--tab-manager-->
             
             <div class="tab-pane" id="tab-setting">
             <form id="form-setting" name="exclude"  method="post" enctype="multipart/form-data" action="<?php echo $action; ?>">
             	<div class="form-group">
		                <label class="col-sm-4"><span><?php echo $column_query_exclude; ?></span></label>
		                <div class="col-sm-8">
							<input type="text" name="hb_404_excludequery" placeholder="sort,order" value="<?php echo $hb_404_excludequery; ?>" class="form-control" /><br>
		                </div>
		         </div>
                 <hr>
				<div class="form-group">
		                <label class="col-sm-4"><span><?php echo $column_error_exclude; ?></span></label>
		                <div class="col-sm-8">
		                  <textarea class="form-control" rows="5" cols="60" name="hb_404_excludeterms"><?php echo $hb_404_excludeterms; ?></textarea><br>
		                </div>
		         </div>
                 <hr>
                 <div class="form-group">
		                <label class="col-sm-4"><span><?php echo $column_ignore_ip; ?></span></label>
		                <div class="col-sm-8">
		                  <textarea class="form-control" rows="5" cols="60" name="hb_404_ignoreip"><?php echo $hb_404_ignoreip; ?></textarea><br>
		                </div>
		         </div>
                 <hr>
                 <div class="form-group">
		                <label class="col-sm-4"><span><?php echo $column_ignore_agent; ?></span></label>
		                <div class="col-sm-8">
		                  <textarea class="form-control" rows="5" cols="60" name="hb_404_ignoreagents"><?php echo $hb_404_ignoreagents; ?></textarea><br>
		                </div>
		         </div>
                 <hr>
                 <div class="form-group">
		                <label class="col-sm-4"><span><?php echo $column_default_url; ?></span></label>
		                <div class="col-sm-8">
                          <input type="text" name="hb_404_defaulturl" value="<?php echo $hb_404_defaulturl; ?>" class="form-control" /><br>
		                </div>
		         </div>
                 <hr>
                 <div class="form-group">
		                <label class="col-sm-4"><span><?php echo $column_redirect_type; ?></span></label>
		                <div class="col-sm-8">
							<select class="form-control" name="hb_404_type">
                            <option value="301" <?php echo ($hb_404_type == "301")? 'selected':''; ?>>Moved Permanently</option>
                            <option value="302" <?php echo ($hb_404_type == "302")? 'selected':''; ?>>Found</option>
                            <option value="307" <?php echo ($hb_404_type == "307")? 'selected':''; ?>>Moved Temporarily</option>
                            </select>	<br><br>	                
                         </div>
		         </div>
                 <hr>
				 <div class="form-group">
		                <label class="col-sm-4"><span><?php echo $column_smart_url; ?></span></label>
		                <div class="col-sm-8">
							<input type="checkbox" name="hb_404_smarturl" value="1" <?php echo ($hb_404_smarturl == "1")? 'checked':''; ?> class="form-control" /><br> <br>               
                         </div>
		         </div>
                 <hr>
                 <div class="form-group">
		                <label class="col-sm-4"><span><?php echo $column_enable_page; ?></span></label>
		                <div class="col-sm-8">
							<select class="form-control" name="hb_404_enablepage">
                            <option value="1" <?php echo ($hb_404_enablepage == "1")? 'selected':''; ?>>Enable</option>
                            <option value="0" <?php echo ($hb_404_enablepage == "0")? 'selected':''; ?>>Disable</option>
                            </select>	<br><br>	                
                         </div>
		         </div>
                 <hr>
                 
                 <br><br>
                 <h3><?php echo $column_page_designer; ?></h3>
                 <ul class="nav nav-tabs" id="languages">
	                <?php foreach ($languages as $language) { ?>
	                <li><a href="#languages<?php echo $language['language_id']; ?>" data-toggle="tab"><?php echo $language['name']; ?></a></li>
	                <?php } ?>
	              </ul>
                 <div class="tab-content"> <!-- language tab content -->
                 <?php foreach ($languages as $language) { ?>
                 	<div class="tab-pane" id="languages<?php echo $language['language_id']; ?>">
                 		<div class="form-group required">
		                		<div class="col-sm-12">
                                    <textarea name="hb_404_page_<?php echo $language['language_id']; ?>" id="page<?php echo $language['language_id']; ?>"><?php echo ${'hb_404_page_'.$language['language_id']};?></textarea>
                         		</div>
		             	</div>
		            	<hr>
                 	</div>
                 <?php } ?>
                </div> <!-- language tab content -->
                </form>
             </div><!--tab-setting-->
             <div class="tab-pane" id="tab-tools">
             		<div class="table-responsive">
                        <table class="table table-bordered table-hover">
                        	<tr>
                            	<td><?php echo $tool_redirect_update; ?></td>
                                <td align="center"><input type="text" class="form-control" id="old_url" placeholder="Existing URL"><i class="fa fa-angle-double-down"></i><br><input type="text" class="form-control" placeholder="New URL" id="new_url"></td>
                                <td><button type="button" onClick="update_redirect();" id="update_redirect" class="btn btn-primary">UPDATE</button></td>
                            </tr>
                            <tr>
                            	<td><?php echo $tool_type_update; ?></td>
                                <td align="center">
                                <select name="type" class="form-control" id="old_type">
                                        <option value="301" >301 Moved Permanently</option>
                                        <option value="302" >302 Found</option>
                                        <option value="307" >307 Moved Temporarily</option>
                                 </select>
                                
                                <i class="fa fa-angle-double-down"></i><br>
                                <select name="type" class="form-control" id="new_type">
                                        <option value="301" >301 Moved Permanently</option>
                                        <option value="302" >302 Found</option>
                                        <option value="307" >307 Moved Temporarily</option>
                                 </select>
                                </td>
                                <td><button type="button" onClick="update_type();" id="update_redirect" class="btn btn-primary">UPDATE</button></td>
                            </tr>
                            <tr>
                            	<td><?php echo $tool_assign_default; ?></td>
                                <td><?php echo $hb_404_defaulturl; ?></td>
                                <td><button type="button" onClick="update_default();" id="update_default" class="btn btn-primary" <?php if(strlen($hb_404_defaulturl)< 4) { echo 'disabled';} ?>>UPDATE</button></td>
                            </tr>
                            <tr>
                            	<td colspan="2"><?php echo $tool_reset; ?></td>
                                <td><button type="button" onClick="reset_all();" id="reset_all" class="btn btn-danger">DELETE</button></td>
                            </tr>
                        </table>
                    </div>    
             </div><!--tab-setting-->
         </div><!--class tab-content -->  
       </div> 
    </div>
  </div>
    <div class="container-fluid"> <!--Huntbee copyrights-->
 <center>
  <span class="help"><?php echo $heading_title; ?> - Version <?php echo $extension_version; ?> &copy; <a href="http://www.huntbee.com/">HUNTBEE.COM</a> | <a href="http://www.huntbee.com/index.php?route=account/support">SUPPORT</a></span></center>
</div><!--Huntbee copyrights end-->
</div>
<style>
#code404{
	text-align:right; font-size:9px; float:right; background-color:#F00; color:#FFF; padding:2px;
}
#code301{
	text-align:right; font-size:9px; float:right; background-color:#060; color:#FFF; padding:2px;
}
#code302{
	text-align:right; font-size:9px; float:right; background-color:#C30; color:#FFF; padding:2px;
}
#code307{
	text-align:right; font-size:9px; float:right; background-color:#060; color:#FFF; padding:2px;
}
#author{
	text-align:right; font-size:9px; float:right; background-color:#06F; color:#FFF; padding:2px; margin-top: -3px; margin-right: -9px;
}
</style>
  <script type="text/javascript" src="view/javascript/summernote/summernote.js"></script>
  <link href="view/javascript/summernote/summernote.css" rel="stylesheet" />
  <script type="text/javascript" src="view/javascript/summernote/opencart.js"></script> 
<script type="text/javascript"><!--
$('#languages a:first').tab('show');
//--></script>
 <script type="text/javascript"><!--
<?php foreach ($languages as $language) { ?>
$('#page<?php echo $language['language_id']; ?>').summernote({height: 300});
<?php } ?>
//--></script>
<script type="text/javascript">
$('#button-filter').on('click', function() {
	url = 'index.php?route=setting/errormanager&token=<?php echo $token; ?>';
	
	var flink = $('select[name=\'link\']').prop('value');

	if (flink) {
		url += '&link=' + encodeURIComponent(flink);
	}
	
	var author = $('select[name=\'author\']').prop('value');

	if (author) {
		url += '&author=' + encodeURIComponent(author);
	}
	
	var type = $('select[name=\'type\']').prop('value');

	if (type) {
		url += '&type=' + encodeURIComponent(type);
	}
				
	location = url;
});
</script>  

<script type="text/javascript"><!--
$('#form input').keydown(function(e) {
	if (e.keyCode == 13) {
		filter();
	}
});
//--></script> 

<script type="text/javascript">
function updateredirect(redirect, id){
	$('#msg'+id).html('');
	$('#loadingmessage'+id).show();
	$.ajax({
		  type: 'post',
		  url: 'index.php?route=setting/errormanager/updateRedirect&token=<?php echo $token; ?>',
		  data: {redirect: redirect, id: id},
		  dataType: 'json',
		  success: function(json) {
				if (json['success']) {
					  $('#msg'+id).html(json['success']);
					  $('#loadingmessage'+id).hide();
				}
		  }
	 });

 }
 function update_redirect(){
	 var oldurl = $('#old_url').val();
	 var newurl = $('#new_url').val();
	 location = 'index.php?route=setting/errormanager/tool_bulkredirectupdate&token=<?php echo $token; ?>&old='+oldurl+'&new='+newurl;
 }
 function update_type(){
	 var oldtype = $('#old_type').val();
	 var newtype = $('#new_type').val();
	 location = 'index.php?route=setting/errormanager/tool_bulktype&token=<?php echo $token; ?>&old='+oldtype+'&new='+newtype;
 }
 function update_default(){
	 location = 'index.php?route=setting/errormanager/tool_bulkdefault&token=<?php echo $token; ?>';
 }
 function reset_all(){
	 location = 'index.php?route=setting/errormanager/tool_resetall&token=<?php echo $token; ?>';
 }
</script>
<link href="view/colorbox.css" rel="stylesheet">
<script src="view/javascript/jquery.colorbox-min.js"></script>
<script>
			$(document).ready(function(){
				$(".ajax").colorbox();
			});
</script>
<?php echo $footer; ?>
