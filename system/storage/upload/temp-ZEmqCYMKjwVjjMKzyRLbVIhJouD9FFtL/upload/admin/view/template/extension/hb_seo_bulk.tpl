<?php echo $header; ?><?php echo $column_left; ?>

<div id="content">
<!--Header Start-->
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-latest" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
	  </div>
      <h1><?php echo $heading_title_seo; ?></h1>
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
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $heading_title_seo; ?></h3>
      </div>
      <div class="panel-body">
      		
      	<center><div id='loadgif' style='display:none;'><img src='view/image/loading-bar.gif'/></div></center>
		<div id="msgoutput" style="text-align:center;"></div>


          <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-language" class="form-horizontal">
	         <?php
				function ratio($a,$b,$action){
				 	if ($a == $b){
						$color = 'green';
					}elseif ($a / $b > 0.5){
						$color = 'orange';
					}else{
						$color = 'red';
					}
					
					return $z = '<span style="color:'.$color.';"><i class="fa fa-bar-chart"></i>  '.$a.' available : '.$b.' total <a href="'.$action.'" title="Refresh Data"> <i class="fa fa-refresh"></i> </a></span>';
				}
				?>	
	         	<ul class="nav nav-tabs" id="types">
					<li><a href="#type1" data-toggle="tab"><i class="fa fa-wrench"></i> Generator</a></li>
                    <li><a href="#type2" data-toggle="tab"><i class="fa fa-gears"></i> Settings</a></li>
				 </ul>
                 <div class="tab-content">
                 	<div class="tab-pane" id="type1"><!--type1 start-->
                    	
                        	         
			<ul class="nav nav-tabs" id="language">
			<?php foreach ($languages as $language) { ?>
			<li><a href="#language<?php echo $language['language_id']; ?>" data-toggle="tab"><?php echo $language['name']; ?></a></li>
			<?php } ?>
			</ul>
	              	
			<div class="tab-content"> <!-- language tab content -->
			<?php foreach ($languages as $language) { ?>
			<div class="tab-pane" id="language<?php echo $language['language_id']; ?>">
			
			<h4><?php echo $text_header_product; ?></h4>

				<table class="table table-hover">
				<thead>
					<tr>
						<td><?php echo $col_process_name; ?></td>
						<td><?php echo $col_process_parameter; ?></td>
						<td><?php echo $col_process_guide; ?></td>
						<td><?php echo $col_process_action; ?></td>
					</tr>
				</thead>
				<tbody>
				  <tr>
					<td class="col-sm-4"><?php echo $col_title; ?> <br /><?php echo ratio(${"p_title_count".$language['language_id']},${"all_product_count".$language['language_id']},$action); ?> </td>
					<td class="col-sm-4"><input type="text" class="form-control" class="form-control" name="hb_seo_prod_title_param_<?php echo $language['language_id']; ?>" value="<?php echo ${"hb_seo_prod_title_param_".$language['language_id']}; ?>" /> </td>
					<td class="col-sm-2"><span class="guide"><a href="#guide1" class="guide" data-effect="mfp-zoom-out" title="Guide"> <i class="fa fa-question-circle fa-lg"></i></a></span></td>
					<td class="col-sm-2"><a class="btn btn-primary" onclick="generateSeo('<?php echo $language['language_id']; ?>','generateproducttitle')"><?php echo $btn_generate; ?></a> <a class="btn btn-danger" onclick="clearSeo('<?php echo $language['language_id']; ?>','product_description','meta_title')"><?php echo $btn_clear; ?></a></td>
				  </tr>
				  <tr>
					<td><?php echo $col_h1; ?><br /><?php echo ratio(${"p_h1_count".$language['language_id']},${"all_product_count".$language['language_id']},$action); ?> </td>
					<td><input type="text" class="form-control" name="hb_seo_prod_h1_param_<?php echo $language['language_id']; ?>" value="<?php echo ${"hb_seo_prod_h1_param_".$language['language_id']}; ?>" /> </td>
					<td><span class="guide"><a href="#guide2" class="guide" data-effect="mfp-zoom-out" title="Guide"> <i class="fa fa-question-circle fa-lg"></i></a></span></td>
					<td><a class="btn btn-primary" onclick="generateSeo('<?php echo $language['language_id']; ?>','generateproducth1')"><?php echo $btn_generate; ?></a> <a class="btn btn-danger" onclick="clearSeo('<?php echo $language['language_id']; ?>','product_description', 'custom_h1')"><?php echo $btn_clear; ?></a></td>
				  </tr>
				 <tr>
					<td><?php echo $col_h2; ?><br /><?php echo ratio(${"p_h2_count".$language['language_id']},${"all_product_count".$language['language_id']},$action); ?> </td>
					<td><input type="text" class="form-control" name="hb_seo_prod_h2_param_<?php echo $language['language_id']; ?>" value="<?php echo ${"hb_seo_prod_h2_param_".$language['language_id']}; ?>" /> </td>
					<td><span class="guide"><a href="#guide3" class="guide" data-effect="mfp-zoom-out" title="Guide"> <i class="fa fa-question-circle fa-lg"></i></a></span></td>
					<td><a class="btn btn-primary" onclick="generateSeo('<?php echo $language['language_id']; ?>','generateproducth2')"><?php echo $btn_generate; ?></a> <a class="btn btn-danger" onclick="clearSeo('<?php echo $language['language_id']; ?>','product_description', 'custom_h2')"><?php echo $btn_clear; ?></a></td>
				  </tr>
				  <tr>
					<td><?php echo $col_img_alt; ?><br /><?php echo ratio(${"p_imgalt_count".$language['language_id']},${"all_product_count".$language['language_id']},$action); ?> </td>
					<td><input type="text" class="form-control" name="hb_seo_prod_alt_param_<?php echo $language['language_id']; ?>" value="<?php echo ${"hb_seo_prod_alt_param_".$language['language_id']}; ?>" /> </td>
					<td><span class="guide"><a href="#guide4" class="guide" data-effect="mfp-zoom-out" title="Guide"> <i class="fa fa-question-circle fa-lg"></i></a></span></td>
					<td><a class="btn btn-primary" onclick="generateSeo('<?php echo $language['language_id']; ?>','generateproductimgalt')"><?php echo $btn_generate; ?></a> <a class="btn btn-danger" onclick="clearSeo('<?php echo $language['language_id']; ?>','product_description', 'img_alt')"><?php echo $btn_clear; ?></a></td>
				  </tr>
				  <tr>
					<td><?php echo $col_meta_desc; ?><br /><?php echo ratio(${"p_desc_count".$language['language_id']},${"all_product_count".$language['language_id']},$action); ?> </td>
					<td><textarea rows="3" class="form-control" name="hb_seo_prod_mdesc_param_<?php echo $language['language_id']; ?>" ><?php echo ${"hb_seo_prod_mdesc_param_".$language['language_id']}; ?></textarea></td>
					<td><span class="guide"><a href="#guide5" class="guide" data-effect="mfp-zoom-out" title="Guide"> <i class="fa fa-question-circle fa-lg"></i></a></span></td>
					<td><a class="btn btn-primary" onclick="generateSeo('<?php echo $language['language_id']; ?>','generateproductmdesc')"><?php echo $btn_generate; ?></a> <a class="btn btn-danger"  onclick="clearSeo('<?php echo $language['language_id']; ?>','product_description', 'meta_description')"><?php echo $btn_clear; ?></a></td>
				  </tr>
				  <tr>
					<td><?php echo $col_meta_key; ?><br /><?php echo ratio(${"p_key_count".$language['language_id']},${"all_product_count".$language['language_id']},$action); ?> </td>
					<td><textarea rows="3" class="form-control" name="hb_seo_prod_mkey_param_<?php echo $language['language_id']; ?>" ><?php echo ${"hb_seo_prod_mkey_param_".$language['language_id']}?></textarea> </td>
					<td><span class="guide"><a href="#guide6" class="guide" data-effect="mfp-zoom-out" title="Guide"> <i class="fa fa-question-circle fa-lg"></i></a></span></td>
					<td><a class="btn btn-primary" onclick="generateSeo('<?php echo $language['language_id']; ?>','generateproductmkey')"><?php echo $btn_generate; ?></a> <a class="btn btn-danger" onclick="clearSeo('<?php echo $language['language_id']; ?>','product_description', 'meta_keyword')"><?php echo $btn_clear; ?></a></td>
				  </tr>
				  </tbody>
				 </table>

			<hr>
			<h4><?php echo $text_header_category; ?></h4>
			<table class="table table-hover">
			<thead>
				<tr>
					<td><?php echo $col_process_name; ?></td>
					<td><?php echo $col_process_parameter; ?></td>
					<td><?php echo $col_process_guide; ?></td>
					<td><?php echo $col_process_action; ?></td>
				</tr>
			</thead>
			<tbody>
			  <tr>
				<td class="col-sm-4"><?php echo $col_title; ?><br /><?php echo ratio(${"c_title_count".$language['language_id']},${"all_cat_count".$language['language_id']},$action); ?> </td>
				<td class="col-sm-4"><input type="text" class="form-control" name="hb_seo_cat_title_param_<?php echo $language['language_id']; ?>" value="<?php echo ${"hb_seo_cat_title_param_".$language['language_id']};?>" /> </td>
				<td class="col-sm-2"><span class="guide"><a href="#guide9" class="guide" data-effect="mfp-zoom-out" title="Guide"> <i class="fa fa-question-circle fa-lg"></i></a></span></td>
				<td class="col-sm-2"><a class="btn btn-primary" onclick="generateSeo('<?php echo $language['language_id']; ?>','generatecategorytitle')"><?php echo $btn_generate; ?></a> <a class="btn btn-danger" onclick="clearSeo('<?php echo $language['language_id']; ?>','category_description', 'meta_title')"><?php echo $btn_clear; ?></a></td>
			  </tr>
			  <tr>
				<td><?php echo $col_h1; ?><br /><?php echo ratio(${"c_h1_count".$language['language_id']},${"all_cat_count".$language['language_id']},$action); ?> </td>
				<td><input type="text" class="form-control" name="hb_seo_cat_h1_param_<?php echo $language['language_id']; ?>" value="<?php echo ${"hb_seo_cat_h1_param_".$language['language_id']};?>" /> </td>
				<td><span class="guide"><a href="#guide10" class="guide" data-effect="mfp-zoom-out" title="Guide"> <i class="fa fa-question-circle fa-lg"></i></a></span></td>
				<td><a class="btn btn-primary" onclick="generateSeo('<?php echo $language['language_id']; ?>','generatecategoryh1')"><?php echo $btn_generate; ?></a> <a class="btn btn-danger" onclick="clearSeo('<?php echo $language['language_id']; ?>','category_description', 'custom_h1')"><?php echo $btn_clear; ?></a></td>
			  </tr>
			 <tr>
				<td><?php echo $col_h2; ?><br /><?php echo ratio(${"c_h2_count".$language['language_id']},${"all_cat_count".$language['language_id']},$action); ?> </td>
				<td><input type="text" class="form-control" name="hb_seo_cat_h2_param_<?php echo $language['language_id']; ?>" value="<?php echo ${"hb_seo_cat_h2_param_".$language['language_id']};?>" /> </td>
				<td><span class="guide"><a href="#guide11" class="guide" data-effect="mfp-zoom-out" title="Guide"> <i class="fa fa-question-circle fa-lg"></i></a></span></td>
				<td><a class="btn btn-primary" onclick="generateSeo('<?php echo $language['language_id']; ?>','generatecategoryh2')"><?php echo $btn_generate; ?></a> <a class="btn btn-danger" onclick="clearSeo('<?php echo $language['language_id']; ?>','category_description', 'custom_h2')"><?php echo $btn_clear; ?></a></td>
			  </tr>
			  <tr>
				<td><?php echo $col_img_alt; ?><br /><?php echo ratio(${"c_imgalt_count".$language['language_id']},${"all_cat_count".$language['language_id']},$action); ?> </td>
				<td><input type="text" class="form-control" name="hb_seo_cat_alt_param_<?php echo $language['language_id']; ?>" value="<?php echo ${"hb_seo_cat_alt_param_".$language['language_id']};?>" /> </td>
				<td><span class="guide"><a href="#guide12" class="guide" data-effect="mfp-zoom-out" title="Guide"> <i class="fa fa-question-circle fa-lg"></i></a></span></td>
				<td><a class="btn btn-primary" onclick="generateSeo('<?php echo $language['language_id']; ?>','generatecategoryimgalt')"><?php echo $btn_generate; ?></a> <a class="btn btn-danger" onclick="clearSeo('<?php echo $language['language_id']; ?>','category_description', 'img_alt')"><?php echo $btn_clear; ?></a></td>
			  </tr>
			  <tr>
				<td><?php echo $col_meta_desc; ?><br /><?php echo ratio(${"c_desc_count".$language['language_id']},${"all_cat_count".$language['language_id']},$action); ?> </td>
				<td><textarea rows="3" class="form-control" name="hb_seo_cat_mdesc_param_<?php echo $language['language_id']; ?>" ><?php echo ${"hb_seo_cat_mdesc_param_".$language['language_id']};?></textarea> </td>
				<td><span class="guide"><a href="#guide13" class="guide" data-effect="mfp-zoom-out" title="Guide"> <i class="fa fa-question-circle fa-lg"></i></a></span></td>
				<td><a class="btn btn-primary" onclick="generateSeo('<?php echo $language['language_id']; ?>','generatecategorymdesc')"><?php echo $btn_generate; ?></a> <a class="btn btn-danger"  onclick="clearSeo('<?php echo $language['language_id']; ?>','category_description', 'meta_description')"><?php echo $btn_clear; ?></a></td>
			  </tr>
			  <tr>
				<td><?php echo $col_meta_key; ?><br /><?php echo ratio(${"c_key_count".$language['language_id']},${"all_cat_count".$language['language_id']},$action); ?> </td>
				<td><textarea rows="3" class="form-control" name="hb_seo_cat_mkey_param_<?php echo $language['language_id']; ?>" ><?php echo ${"hb_seo_cat_mkey_param_".$language['language_id']};?></textarea> </td>
				<td><span class="guide"><a href="#guide14" class="guide" data-effect="mfp-zoom-out" title="Guide"> <i class="fa fa-question-circle fa-lg"></i></a></span></td>
				<td><a class="btn btn-primary" onclick="generateSeo('<?php echo $language['language_id']; ?>','generatecategorymkey')"><?php echo $btn_generate; ?></a> <a class="btn btn-danger" onclick="clearSeo('<?php echo $language['language_id']; ?>','category_description', 'meta_keyword')"><?php echo $btn_clear; ?></a></td>
			  </tr>
			 </tbody>
			 </table>

			<hr>
			<h4><?php echo $text_header_information; ?></h4>
			
			<table class="table table-hover">
			<thead>
				<tr>
					<td><?php echo $col_process_name; ?></td>
					<td><?php echo $col_process_parameter; ?></td>
					<td><?php echo $col_process_guide; ?></td>
					<td><?php echo $col_process_action; ?></td>
				</tr>
			</thead>
			<tbody>
			  <tr>
				<td class="col-sm-4"><?php echo $col_title; ?><br /><?php echo ratio(${"i_title_count".$language['language_id']},${"all_info_count".$language['language_id']},$action); ?> </td>
				<td class="col-sm-4"><input type="text" class="form-control" name="hb_seo_info_title_param_<?php echo $language['language_id']; ?>" value="<?php echo ${"hb_seo_info_title_param_".$language['language_id']};?>" /></td>
				<td class="col-sm-2"><span class="guide"><a href="#guide22" class="guide" data-effect="mfp-zoom-out" title="Guide"> <i class="fa fa-question-circle fa-lg"></i></a></span></td>
				<td class="col-sm-2"><a class="btn btn-primary" onclick="generateSeo('<?php echo $language['language_id']; ?>','generateinfotitle')"><?php echo $btn_generate; ?></a> <a class="btn btn-danger" onclick="clearSeo('<?php echo $language['language_id']; ?>','information_description', 'meta_title')"><?php echo $btn_clear; ?></a></td>
			  </tr>
			  <tr>
				<td><?php echo $col_meta_desc; ?><br /><?php echo ratio(${"i_desc_count".$language['language_id']},${"all_info_count".$language['language_id']},$action); ?> </td>
				<td><textarea rows="3" class="form-control" name="hb_seo_info_mdesc_param_<?php echo $language['language_id']; ?>" ><?php echo ${"hb_seo_info_mdesc_param_".$language['language_id']};?></textarea></td>
				<td><span class="guide"><a href="#guide23" class="guide" data-effect="mfp-zoom-out" title="Guide"> <i class="fa fa-question-circle fa-lg"></i></a></span></td>
				<td><a class="btn btn-primary" onclick="generateSeo('<?php echo $language['language_id']; ?>','generateinfomdesc')"><?php echo $btn_generate; ?></a> <a class="btn btn-danger"  onclick="clearSeo('<?php echo $language['language_id']; ?>','information_description', 'meta_description')"><?php echo $btn_clear; ?></a></td>
			  </tr>
			  <tr>
				<td><?php echo $col_meta_key; ?><br /><?php echo ratio(${"i_key_count".$language['language_id']},${"all_info_count".$language['language_id']},$action); ?> </td>
				<td><textarea rows="3" class="form-control" name="hb_seo_info_mkey_param_<?php echo $language['language_id']; ?>" ><?php echo ${"hb_seo_info_mkey_param_".$language['language_id']};?></textarea></td>
				<td><span class="guide"><a href="#guide24" class="guide" data-effect="mfp-zoom-out" title="Guide"> <i class="fa fa-question-circle fa-lg"></i></a></span></td>
				<td><a class="btn btn-primary" onclick="generateSeo('<?php echo $language['language_id']; ?>','generateinfomkey')"><?php echo $btn_generate; ?></a> <a class="btn btn-danger" onclick="clearSeo('<?php echo $language['language_id']; ?>','information_description', 'meta_keyword')"><?php echo $btn_clear; ?></a></td>
			  </tr>
			  </tbody>
			 </table>
			</div>
			<?php } ?>
	  </div> <!-- language tab content end-->
	   <!-- BRAND HAS ONLY ONE LANGUAGE-->    
	      
			  <hr>
			   <hr>
	          <h4><?php echo $text_header_brand; ?></h4>     
	          <table class="table table-hover">
			  <thead>
				<tr>
					<td><?php echo $col_process_name; ?></td>
					<td><?php echo $col_process_parameter; ?></td>
					<td><?php echo $col_process_guide; ?></td>
					<td><?php echo $col_process_action; ?></td>
				</tr>
			</thead>
			<tbody>
              <tr>
                <td class="col-sm-4"><?php echo $col_title; ?><br /><?php echo ratio($b_title_count,$all_brand_count,$action); ?> </td>
                <td class="col-sm-4"><input type="text" class="form-control" name="hb_seo_brand_title_param" value="<?php echo $hb_seo_brand_title_param;?>" /></td>
				<td class="col-sm-2"><span class="guide"><a href="#guide16" class="guide" data-effect="mfp-zoom-out" title="Guide"> <i class="fa fa-question-circle fa-lg"></i></a></span></td>
              	<td class="col-sm-2"><a class="btn btn-primary" onclick="generateSeo('<?php echo $default_language; ?>','generatebrandtitle')"><?php echo $btn_generate; ?></a> <a class="btn btn-danger" onclick="clearSeo('<?php echo $default_language; ?>','manufacturer', 'custom_title')"><?php echo $btn_clear; ?></a></td>
              </tr>
              <tr>
                <td><?php echo $col_h1; ?><br /><?php echo ratio($b_h1_count,$all_brand_count,$action); ?> </td>
                <td><input type="text" class="form-control" name="hb_seo_brand_h1_param" value="<?php echo $hb_seo_brand_h1_param;?>" /></td>
				<td><span class="guide"><a href="#guide17" class="guide" data-effect="mfp-zoom-out" title="Guide"> <i class="fa fa-question-circle fa-lg"></i></a></span></td>
				<td><a class="btn btn-primary" onclick="generateSeo('<?php echo $default_language; ?>','generatebrandh1')"><?php echo $btn_generate; ?></a> <a class="btn btn-danger" onclick="clearSeo('<?php echo $default_language; ?>','manufacturer', 'custom_h1')"><?php echo $btn_clear; ?></a></td>
              </tr>
			 <tr>
                <td><?php echo $col_h2; ?><br /><?php echo ratio($b_h2_count,$all_brand_count,$action); ?> </td>
                <td><input type="text" class="form-control" name="hb_seo_brand_h2_param" value="<?php echo $hb_seo_brand_h2_param;?>" /></td>
				<td><span class="guide"><a href="#guide18" class="guide" data-effect="mfp-zoom-out" title="Guide"> <i class="fa fa-question-circle fa-lg"></i></a></span></td>
				<td><a class="btn btn-primary" onclick="generateSeo('<?php echo $default_language; ?>','generatebrandh2')"><?php echo $btn_generate; ?></a> <a class="btn btn-danger" onclick="clearSeo('<?php echo $default_language; ?>','manufacturer', 'custom_h2')"><?php echo $btn_clear; ?></a></td>
              </tr>
              <tr>
                <td><?php echo $col_meta_desc; ?><br /><?php echo ratio($b_desc_count,$all_brand_count,$action); ?> </td>
                <td><textarea rows="3" type="text" class="form-control" name="hb_seo_brand_mdesc_param" ><?php echo $hb_seo_brand_mdesc_param;?></textarea></td>
				<td><span class="guide"><a href="#guide19" class="guide" data-effect="mfp-zoom-out" title="Guide"> <i class="fa fa-question-circle fa-lg"></i></a></span></td>
				<td><a class="btn btn-primary" onclick="generateSeo('<?php echo $default_language; ?>','generatebrandmdesc')"><?php echo $btn_generate; ?></a> <a class="btn btn-danger"  onclick="clearSeo('<?php echo $default_language; ?>','manufacturer', 'brand_meta_description')"><?php echo $btn_clear; ?></a></td>
              </tr>
			  <tr>
                <td><?php echo $col_meta_key; ?><br /><?php echo ratio($b_key_count,$all_brand_count,$action); ?> </td>
                <td><textarea rows="3" class="form-control" name="hb_seo_brand_mkey_param"><?php echo $hb_seo_brand_mkey_param;?></textarea></td>
				<td><span class="guide"><a href="#guide20" class="guide" data-effect="mfp-zoom-out" title="Guide"> <i class="fa fa-question-circle fa-lg"></i></a></span></td>
				<td><a class="btn btn-primary" onclick="generateSeo('<?php echo $default_language; ?>','generatebrandmkey')"><?php echo $btn_generate; ?></a> <a class="btn btn-danger" onclick="clearSeo('<?php echo $default_language; ?>','manufacturer', 'brand_meta_keyword')"><?php echo $btn_clear; ?></a></td>
              </tr>
			  </tbody>
             </table>
			 
			 <hr>    
	          <table class="table table-hover">
              <tr>
                
				<td class="col-sm-2"></td>
              	<td class="col-sm-2"></td>
              </tr>
             </table>
			 <hr>
            
          </div>
                     
                     <div class="tab-pane" id="type2"><!--type2 start-->
                     	<table class="table table-bordered table-hover">
                        	<tr><td class="col-sm-6" style="color:#009900; font-weight:bold;"><?php echo $col_automation; ?></td>
               					 <td class="col-sm-6"><select name="hb_seo_bulk_auto" class="form-control">
                                 <option value="n" <?php echo ($hb_seo_bulk_auto == 'n')? 'selected':''; ?> >No</option>
							  <option value="y" <?php echo ($hb_seo_bulk_auto == 'y')? 'selected':''; ?> >Yes</option>
							  </select></td></tr>
							                        
                        	<tr>
                            	<td class="col-sm-6"><b>Set Passkey (Any alphanumeric characters. No Spaces Allowed)</b></td>
                                <td class="col-sm-6">
                                <input type="text" name="hb_seo_bulk_passkey" value="<?php echo $hb_seo_bulk_passkey; ?>" class="form-control" placeholder="Eg: LUZXNS122SKWDSD">
                            </tr>
                            
                            <tr>
                            	<td class="col-sm-6"><b>Number of products per batch</b></td>
                                <td class="col-sm-6">
                                <input type="text" name="hb_seo_bulk_ppb" value="<?php echo $hb_seo_bulk_ppb; ?>" class="form-control" placeholder="Eg: 2000">
                            </tr>
                            
                            <tr>
                            	<td class="col-sm-6"><b>Maximum Execution time (in seconds) limit per Product SEO generation (Recommended Value: Between 10 to 30 )</b></td>
                                <td class="col-sm-6">
                                <input type="text" name="hb_seo_bulk_time" value="<?php echo $hb_seo_bulk_time; ?>" class="form-control" placeholder="Eg: 20">
                            </tr>
                            
                        	<tr>
                            	<td class="col-sm-6"><b>Enable Automation for the selected language</b></td>
                                <td class="col-sm-6">
                                <select name="hb_seo_bulk_auto_lang" class="form-control">
                               		<option value="all" <?php if($hb_seo_bulk_auto_lang == 'all'){echo 'selected';}?>>ALL LANGUAGES</option>
                                	<?php foreach ($languages as $language) { ?>
                                	<option value="<?php echo $language['language_id']; ?>" <?php if($hb_seo_bulk_auto_lang == 1){echo 'selected';}?>><?php echo $language['name']; ?></option>
                                    <?php } ?>
                                </select>
                            </tr>
                            
                        	<tr>
                            	<td class="col-sm-6" style="color:#336"><b>Enable Product Page Meta Title Generation in Auto Mode</b></td>
                                <td class="col-sm-6"><input type="checkbox" name="hb_seo_bulk_auto_pmt" value="1" class="form-control" <?php if($hb_seo_bulk_auto_pmt == 1){echo 'checked';}?>></td>
                            </tr>
                            <tr>
                            	<td class="col-sm-6" style="color:#336"><b>Enable Product Page H1 Tag Generation in Auto Mode</b></td>
                                <td class="col-sm-6"><input type="checkbox" name="hb_seo_bulk_auto_ph1" value="1" class="form-control" <?php if($hb_seo_bulk_auto_ph1 == 1){echo 'checked';}?>></td>
                            </tr>
                            <tr>
                            	<td class="col-sm-6" style="color:#336"><b>Enable Product Page H2 Tag Generation in Auto Mode</b></td>
                                <td class="col-sm-6"><input type="checkbox" name="hb_seo_bulk_auto_ph2" value="1" class="form-control" <?php if($hb_seo_bulk_auto_ph2 == 1){echo 'checked';}?>></td>
                            </tr>
                            <tr>
                            	<td class="col-sm-6" style="color:#336"><b>Enable Product Page Image Alt Tag Generation in Auto Mode</b></td>
                                <td class="col-sm-6"><input type="checkbox" name="hb_seo_bulk_auto_pia" value="1" class="form-control" <?php if($hb_seo_bulk_auto_pia == 1){echo 'checked';}?>></td>
                            </tr>
                            <tr>
                            	<td class="col-sm-6" style="color:#336"><b>Enable Product Page Meta Description Generation in Auto Mode</b></td>
                                <td class="col-sm-6"><input type="checkbox" name="hb_seo_bulk_auto_pmd" value="1" class="form-control" <?php if($hb_seo_bulk_auto_pmd == 1){echo 'checked';}?>></td>
                            </tr>
                            <tr>
                            	<td class="col-sm-6" style="color:#336"><b>Enable Product Page Meta Keyword Generation in Auto Mode</b></td>
                                <td class="col-sm-6"><input type="checkbox" name="hb_seo_bulk_auto_pmk" value="1" class="form-control" <?php if($hb_seo_bulk_auto_pmk == 1){echo 'checked';}?>></td>
                            </tr>
                            
                            <tr>
                            	<td class="col-sm-6" style="color:#639"><b>Enable Category Page Meta Title Generation in Auto Mode</b></td>
                                <td class="col-sm-6"><input type="checkbox" name="hb_seo_bulk_auto_cmt" value="1" class="form-control" <?php if($hb_seo_bulk_auto_cmt == 1){echo 'checked';}?>></td>
                            </tr>
                            <tr>
                            	<td class="col-sm-6" style="color:#639"><b>Enable Category Page H1 Tag Generation in Auto Mode</b></td>
                                <td class="col-sm-6"><input type="checkbox" name="hb_seo_bulk_auto_ch1" value="1" class="form-control" <?php if($hb_seo_bulk_auto_ch1 == 1){echo 'checked';}?>></td>
                            </tr>
                            <tr>
                            	<td class="col-sm-6" style="color:#639"><b>Enable Category Page H2 Tag Generation in Auto Mode</b></td>
                                <td class="col-sm-6"><input type="checkbox" name="hb_seo_bulk_auto_ch2" value="1" class="form-control" <?php if($hb_seo_bulk_auto_ch2 == 1){echo 'checked';}?>></td>
                            </tr>
                            <tr>
                            	<td class="col-sm-6" style="color:#639"><b>Enable Category Page Image Alt Tag Generation in Auto Mode</b></td>
                                <td class="col-sm-6"><input type="checkbox" name="hb_seo_bulk_auto_cia" value="1" class="form-control" <?php if($hb_seo_bulk_auto_cia == 1){echo 'checked';}?>></td>
                            </tr>
                            <tr>
                            	<td class="col-sm-6" style="color:#639"><b>Enable Category Page Meta Description Generation in Auto Mode</b></td>
                                <td class="col-sm-6"><input type="checkbox" name="hb_seo_bulk_auto_cmd" value="1" class="form-control" <?php if($hb_seo_bulk_auto_cmd == 1){echo 'checked';}?>></td>
                            </tr>
                            <tr>
                            	<td class="col-sm-6" style="color:#639"><b>Enable Category Page Meta Keyword Generation in Auto Mode</b></td>
                                <td class="col-sm-6"><input type="checkbox" name="hb_seo_bulk_auto_cmk" value="1" class="form-control" <?php if($hb_seo_bulk_auto_cmk == 1){echo 'checked';}?>></td>
                            </tr>
                            
                            <tr>
                            	<td class="col-sm-6" style="color:#66F"><b>Enable Information Page Meta Title Generation in Auto Mode</b></td>
                                <td class="col-sm-6"><input type="checkbox" name="hb_seo_bulk_auto_imt" value="1" class="form-control" <?php if($hb_seo_bulk_auto_imt == 1){echo 'checked';}?>></td>
                            </tr>
                            <tr>
                            	<td class="col-sm-6" style="color:#66F"><b>Enable Information Page Meta Description Generation in Auto Mode</b></td>
                                <td class="col-sm-6"><input type="checkbox" name="hb_seo_bulk_auto_imd" value="1" class="form-control" <?php if($hb_seo_bulk_auto_imd == 1){echo 'checked';}?>></td>
                            </tr>
                            <tr>
                            	<td class="col-sm-6" style="color:#66F"><b>Enable Information Page Meta Keyword Generation in Auto Mode</b></td>
                                <td class="col-sm-6"><input type="checkbox" name="hb_seo_bulk_auto_imk" value="1" class="form-control" <?php if($hb_seo_bulk_auto_imk == 1){echo 'checked';}?>></td>
                            </tr>
                            
                            <tr>
                            	<td class="col-sm-6" style="color:#C30"><b>Enable Brand Page Meta Title Generation in Auto Mode</b></td>
                                <td class="col-sm-6"><input type="checkbox" name="hb_seo_bulk_auto_bmt" value="1" class="form-control" <?php if($hb_seo_bulk_auto_bmt == 1){echo 'checked';}?>></td>
                            </tr>
                            <tr>
                            	<td class="col-sm-6" style="color:#C30"><b>Enable Brand Page H1 Tag Generation in Auto Mode</b></td>
                                <td class="col-sm-6"><input type="checkbox" name="hb_seo_bulk_auto_bh1" value="1" class="form-control" <?php if($hb_seo_bulk_auto_bh1 == 1){echo 'checked';}?>></td>
                            </tr>
                            <tr>
                            	<td class="col-sm-6" style="color:#C30"><b>Enable Brand Page H2 Tag Generation in Auto Mode</b></td>
                                <td class="col-sm-6"><input type="checkbox" name="hb_seo_bulk_auto_bh2" value="1" class="form-control" <?php if($hb_seo_bulk_auto_bh2 == 1){echo 'checked';}?>></td>
                            </tr>
                            <tr>
                            	<td class="col-sm-6" style="color:#C30"><b>Enable Brand Page Meta Description Generation in Auto Mode</b></td>
                                <td class="col-sm-6"><input type="checkbox" name="hb_seo_bulk_auto_bmd" value="1" class="form-control" <?php if($hb_seo_bulk_auto_bmd == 1){echo 'checked';}?>></td>
                            </tr>
                            <tr>
                            	<td class="col-sm-6" style="color:#C30"><b>Enable Brand Page Meta Keyword Generation in Auto Mode</b></td>
                                <td class="col-sm-6"><input type="checkbox" name="hb_seo_bulk_auto_bmk" value="1" class="form-control" <?php if($hb_seo_bulk_auto_bmk == 1){echo 'checked';}?>></td>
                            </tr>
                            
                            <tr>
                            	<td class="col-sm-6"><b>Reset Batch</b></td>
                                <td class="col-sm-6"><a class="btn btn-warning" onClick="resetbatch();">Reset Batch</a></td>
                            </tr>
                            
                            <tr>
                            	<td class="col-sm-6"><b>Uninstall this Extension</b></td>
                                <td class="col-sm-6"><a href="<?php echo $uninstall;?>" class="btn btn-danger">UNINSTALL</a></td>
                            </tr>
                            
                            <tr>
                            	<td style="color:#060"><b>CRON JOB COMMAND FOR PRODUCT PAGES SEO GENERATION</b></td>
                                <td><div class="alert alert-info">wget --quiet --delete-after "<?php echo HTTP_CATALOG;?>index.php?route=seo/hb_seo/productcron&passkey=<?php echo $hb_seo_bulk_passkey; ?>"</div></td>
                            </tr>
                            <tr>
                            	<td style="color:#060"><b>CRON JOB COMMAND FOR CATEGORY/BRAND/INFORMATION PAGES SEO GENERATION</b></td>
                                <td><div class="alert alert-info">wget --quiet --delete-after "<?php echo HTTP_CATALOG;?>index.php?route=seo/hb_seo/miccron&passkey=<?php echo $hb_seo_bulk_passkey; ?>"</div></td>
                            </tr>
                        </table>

                     </div>
                   </div><!--tab content end -->
          </form>
    	
      </div>
    </div>
  </div>
  <div class="container-fluid"> <!--Huntbee copyrights-->
 <center>
  <span class="help">SEO BULK GENERATOR (EV <?php echo $extension_version;?>) &copy; <a href="http://www.huntbee.com/">WWW.HUNTBEE.COM</a> | <a href="http://www.huntbee.com/product-support">SUPPORT</a></span></center>
</div><!--Huntbee copyrights end-->
</div>
 <?php 
  for ($i = 1;$i<21;$i++){
  	echo '<div id="guide'.$i.'" class="white-popup mfp-with-anim mfp-hide"> <h4><u>GUIDE '.$i.'</u></h4> '.${'guide'.$i}.'</div>';
  }
  ?>

<script type="text/javascript"><!--
$('#types a:first').tab('show');
$('#language a:first').tab('show');
//--></script>
<script type="text/javascript"><!--
$(document).ready(function() {
$('.guide').magnificPopup({
  delegate: 'a',
  removalDelay: 500, 
  callbacks: {
    beforeOpen: function() {
       this.st.mainClass = this.st.el.attr('data-effect');
    }
  },
  midClick: true 
 });

});
</script>
<script type="text/javascript">
function generateSeo(language_id, button){
	$('#msgoutput').html('');
	$('#loadgif').show();
	$.ajax({
		  type: 'post',
		  url: '../index.php?route=seo/hb_seo/'+button+'&passkey=<?php echo $hb_seo_bulk_passkey; ?>',
		  data: {language_id: language_id},
		  dataType: 'json',
		  success: function(json) {
				if (json['success']) {
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

function clearSeo(language_id, table, column){
	$('#msgoutput').html('');
	$('#loadgif').show();
	$.ajax({
		  type: 'post',
		  url: '../index.php?route=seo/hb_seo/clearseo&passkey=<?php echo $hb_seo_bulk_passkey; ?>',
		  data: {language_id: language_id, table: table, column: column},
		  dataType: 'json',
		  success: function(json) {
				if (json['success']) {
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

function resetbatch(){
	$('#msgoutput').html('');
	$("html, body").animate({ scrollTop: 0 }, "slow");
	$('#loadgif').show();
	$.ajax({
		  type: 'post',
		  url: '../index.php?route=seo/hb_seo/resetbatch&passkey=<?php echo $hb_seo_bulk_passkey; ?>',
		  dataType: 'json',
		  success: function(json) {
				if (json['success']) {
					  $('#msgoutput').html(json['success']);
					  $('#loadgif').hide();
				}
		  },			
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
	 });
}
</script>
<link rel="stylesheet" href="view/stylesheet/magnific-popup.css"> 
<script src="view/stylesheet/jquery.magnific-popup.js"></script> 
<style type="text/css">
.white-popup {
  position: relative;
  background: #FFF;
  padding: 25px;
  width:auto;
  max-width: 700px;
  margin: 0 auto; 
}
.mfp-zoom-out .mfp-with-anim{opacity:0;transition:all 0.3s ease-in-out;transform:scale(1.3)}.mfp-zoom-out.mfp-bg{opacity:0;transition:all 0.3s ease-out}.mfp-zoom-out.mfp-ready .mfp-with-anim{opacity:1;transform:scale(1)}.mfp-zoom-out.mfp-ready.mfp-bg{opacity:0.8}.mfp-zoom-out.mfp-removing .mfp-with-anim{transform:scale(1.3);opacity:0}.mfp-zoom-out.mfp-removing.mfp-bg{opacity:0}@keyframes hinge{0%{transform:rotate(0);transform-origin:top left;animation-timing-function:ease-in-out}20%, 60%{transform:rotate(80deg);transform-origin:top left;animation-timing-function:ease-in-out}40%{transform:rotate(60deg);transform-origin:top left;animation-timing-function:ease-in-out}80%{transform:rotate(60deg) translateY(0);opacity:1;transform-origin:top left;animation-timing-function:ease-in-out}100%{transform:translateY(700px);opacity:0}}.hinge{animation-duration:1s;animation-name:hinge}.mfp-with-fade .mfp-content,.mfp-with-fade.mfp-bg{opacity:0;transition:opacity .5s ease-out}.mfp-with-fade.mfp-ready .mfp-content{opacity:1}.mfp-with-fade.mfp-ready.mfp-bg{opacity:0.8}.mfp-with-fade.mfp-removing.mfp-bg{opacity:0}
</style>

<?php echo $footer; ?>