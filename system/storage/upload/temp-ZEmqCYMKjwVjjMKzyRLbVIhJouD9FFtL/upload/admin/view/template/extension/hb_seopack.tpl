<?php echo $header; ?><?php echo $column_left; ?>

<div id="content">
<!--Header Start-->
  <div class="page-header">
    <div class="container-fluid">
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
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-puzzle-piece"></i> <?php echo $heading_title; ?></h3>
      </div>
      <div class="panel-body">
      	 <div class="row" style="text-align:center;color:#0099CC;">
		  <div class="col-lg-3 col-md-3 col-sm-6"><a href="<?php echo $link_seobulk; ?>"><i class="fa fa-cubes fa-5x"></i> <h2>SEO On-Page Bulk Generator</h2></a></div>
		  <div class="col-lg-3 col-md-3 col-sm-6"><a href="<?php echo $link_sitemap; ?>"><i class="fa fa-sitemap fa-5x"></i> <h2>SEO XML Sitemap & SEO URL Generator</h2></a></div>
		  <div class="col-lg-3 col-md-3 col-sm-6"><a href="<?php echo $link_seoimage; ?>"><i class="fa fa-picture-o fa-5x"></i> <h2>Product Images Bulk SEO Rename</h2></a></div>
		  <div class="col-lg-3 col-md-3 col-sm-6"><a href="<?php echo $link_seosnippets; ?>"><i class="fa fa-newspaper-o fa-5x"></i> <h2>SEO Structured data Markup / Rich Snippet </a></h2></div>
		</div>	
		
		<br />
		<br />
    	<div class="row" style="text-align:center;color:#0099CC;">
		  <div class="col-lg-3 col-md-3 col-sm-6"><a onclick="$('#canonical').toggle();"><i class="fa fa-files-o fa-5x"></i> <h2>SEO Auto Canonical Links </h2></a></div>
		  <div class="col-lg-3 col-md-3 col-sm-6"><a href="<?php echo $link_tags; ?>"><i class="fa fa-tags fa-5x"></i> <h2>SEO Product Tags Generator </h2></a></div>
		  <div class="col-lg-3 col-md-3 col-sm-6"><a href="<?php echo $link_errormanager; ?>"><i class="fa fa-chain-broken fa-5x"></i> <h2>Broken Links / 404 Page Manager </h2></a></div>
<!--		  <div class="col-lg-3 col-md-3 col-sm-6"><a onclick="$('#hbtags').toggle();"><i class="fa fa-tags fa-5x"></i> <h2>SEO Product Tags Generator </h2></a></div>
		  <div class="col-lg-3 col-md-3 col-sm-6"><a onclick="$('#hberrormanager').toggle();"><i class="fa fa-chain-broken fa-5x"></i> <h2>Broken Links / 404 Page Manager </h2></a></div>
-->		  <div class="col-lg-3 col-md-3 col-sm-6"></div>
		</div>
		
		<br />
		<br />
		<div id="info"></div>
		<div id="canonical" class="alert alert-success" style="display:none;">
			<h4>This is a vqmod extension and automatically adds canonical links to webpages. It also adds canonical paginated series. The changes can be only viewed in the html source code. For more information contact our support.</h4>
		</div>
		<div id="hbtags" class="alert alert-success"  style="display:none;">
			<h4>This extension is not available in this extension. Buy this extension from <a href="" target="_blank">HuntBee.com</a></h4>
		</div>	
		<div id="hberrormanager" class="alert alert-success"  style="display:none;">
			<h4>This extension is not available in this extension. Buy this extension from <a href="" target="_blank">HuntBee.com</a></h4>
		</div>		
		
    </div>
  </div>
  <div class="container-fluid"> <!--Huntbee copyrights-->
 <center>
  <span class="help">SEO PACK (EV 6.0) &copy; <a href="http://www.huntbee.com/">WWW.HUNTBEE.COM</a> | <a href="http://www.huntbee.com/product-support">SUPPORT</a></span></center>
</div><!--Huntbee copyrights end-->
</div>
<?php echo $footer; ?>