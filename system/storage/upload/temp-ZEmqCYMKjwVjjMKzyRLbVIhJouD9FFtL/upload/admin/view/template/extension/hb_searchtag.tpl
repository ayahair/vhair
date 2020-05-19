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
          <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-language" class="form-horizontal">
			<ul class="nav nav-tabs" id="language">
			<?php foreach ($languages as $language) { ?>
			<li><a href="#language<?php echo $language['language_id']; ?>" data-toggle="tab"> <?php echo $language['name']; ?></a></li>
			<?php } ?>
			</ul>
	              	
			<div class="tab-content"> <!-- language tab content -->
			<?php foreach ($languages as $language) { ?>
			<div class="tab-pane" id="language<?php echo $language['language_id']; ?>">	
			<h3 style="color:#0099CC"><?php echo $text_search; ?></h3>		
			<table class="table table-hover">
				<tr>
					<td><b><?php echo $text_meta_title; ?></b></td>
					<td><textarea rows="3" class="form-control" name="hb_searchtag_smt_<?php echo $language['language_id']; ?>" ><?php echo ${"hb_searchtag_smt_".$language['language_id']};?></textarea></td>
			    </tr>
				<tr>
					<td><b><?php echo $text_mt_shortcodes; ?></b></td>
					<td><span style="color:teal">{page} : Page Number , {store_name} : Store Name , {total} : Product Count , {tag} : Search/Tag Word</span></td>
			    </tr>
				<tr>
					<td><b><?php echo $text_meta_description; ?></b></td>
					<td><textarea rows="3" class="form-control" name="hb_searchtag_smd_<?php echo $language['language_id']; ?>" ><?php echo ${"hb_searchtag_smd_".$language['language_id']};?></textarea></td>
			    </tr>
				<tr>
					<td><b><?php echo $text_md_shortcodes; ?></b></td>
					<td><span style="color:teal">{page} : Page Number , {store_name} : Store Name , {total} : Product Count , {tag} : Search/Tag Word</span></td>
			    </tr>
				<tr>
					<td><b><?php echo $text_meta_keyword; ?></b></td>
					<td><textarea rows="3" class="form-control" name="hb_searchtag_smk_<?php echo $language['language_id']; ?>" ><?php echo ${"hb_searchtag_smk_".$language['language_id']};?></textarea></td>
			    </tr>
				<tr>
					<td><b><?php echo $text_mk_shortcodes; ?></b></td>
					<td><span style="color:teal">{products} - Product titles</span></td>
			    </tr>
			 </table>
	
			 <h3 style="color:#0099CC"><?php echo $text_tag; ?></h3>
			 <table class="table table-hover">
			 	<tr>
					<td><b><?php echo $text_meta_title; ?></b></td>
					<td><textarea rows="3" class="form-control" name="hb_searchtag_tmt_<?php echo $language['language_id']; ?>" ><?php echo ${"hb_searchtag_tmt_".$language['language_id']};?></textarea></td>
			    </tr>
				<tr>
					<td><b><?php echo $text_mt_shortcodes; ?></b></td>
					<td><span style="color:teal">{page} : Page Number , {store_name} : Store Name , {total} : Product Count , {tag} : Search/Tag Word</span></td>
			    </tr>
				<tr>
					<td><b><?php echo $text_meta_description; ?></b></td>
					<td><textarea rows="3" class="form-control" name="hb_searchtag_tmd_<?php echo $language['language_id']; ?>" ><?php echo ${"hb_searchtag_tmd_".$language['language_id']};?></textarea></td>
			    </tr>
				<tr>
					<td><b><?php echo $text_md_shortcodes; ?></b></td>
					<td><span style="color:teal">{page} : Page Number , {store_name} : Store Name , {total} : Product Count , {tag} : Search/Tag Word</span></td>
			    </tr>
				<tr>
					<td><b><?php echo $text_meta_keyword; ?></b></td>
					<td><textarea rows="3" class="form-control" name="hb_searchtag_tmk_<?php echo $language['language_id']; ?>" ><?php echo ${"hb_searchtag_tmk_".$language['language_id']};?></textarea></td>
			    </tr>
				<tr>
					<td><b><?php echo $text_mk_shortcodes; ?></b></td>
					<td><span style="color:teal">{products} - Product titles</span></td>
			    </tr>
			 </table>
			</div>
			<?php } ?>
	  </div> <!-- language tab content end-->
          </form>
      </div>
    </div>
  </div>
  <div class="container-fluid"> <!--Huntbee copyrights-->
 <center>
  <span class="help"><?php echo $heading_title; ?> Version <?php echo $extension_version; ?> &copy; <a href="http://www.huntbee.com/">WWW.HUNTBEE.COM</a> | <a href="http://www.huntbee.com/product-support">SUPPORT</a></span></center>
</div><!--Huntbee copyrights end-->
</div>
<script type="text/javascript"><!--
$('#language a:first').tab('show');
//--></script>
<?php echo $footer; ?>