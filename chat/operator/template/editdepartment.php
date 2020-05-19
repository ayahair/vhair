<?php include_once 'header.php';?>

<?php if ($errors) { ?>
<div class="alert alert-danger">
<?php if (isset($errors["e"])) echo $errors["e"];
	  if (isset($errors["e1"])) echo $errors["e1"];?>
</div>
<?php } ?>

<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data">
<div class="box">
<div class="box-header with-border">
  <h3 class="box-title"><?php echo $jkl["g47"];?></h3>
</div><!-- /.box-header -->
<div class="box-body">

<div class="table-responsive">
<table class="table table-striped">
<tr>
	<td>
	<div class="form-group">
		<label for="title"><?php echo $jkl["g16"];?></label>
		<input type="text" name="title" id="title" class="form-control<?php if (isset($errors["e"])) echo " is-invalid";?>" value="<?php echo $JAK_FORM_DATA["title"];?>" />
	</div>
	</td>
</tr>
<tr>
	<td>
	<div class="form-group">
		<label for="email"><?php echo $jkl["g68"];?></label>
		<input type="text" name="email" id="email" class="form-control<?php if (isset($errors["e1"])) echo " is-invalid";?>" value="<?php echo $JAK_FORM_DATA["email"];?>" />
	</div>
	</td>
</tr>
<tr>
	<td>
	<div class="form-group">
		<label for="faq"><?php echo $jkl["g278"];?></label>
		<input type="text" name="faq" id="faq" class="form-control" value="<?php echo $JAK_FORM_DATA["faq_url"];?>" />
	</div>
	</td>
</tr>
<tr>
	<td>
	<div class="form-group">
		<label for="desc"><?php echo $jkl["g52"];?></label>
		<textarea name="description" id="desc" rows="5" class="form-control"><?php echo $JAK_FORM_DATA["description"];?></textarea>
		</div>
	</td>
</tr>
</table>
</div>

</div>
<div class="box-footer">
	<a href="<?php echo JAK_rewrite::jakParseurl('departments');?>" class="btn btn-default"><?php echo $jkl["g103"];?></a>
	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $jkl["g38"];?></button>
</div>
</div>
</form>
		
<?php include_once 'footer.php';?>