<table class="table table-hover">
	<tr>
		<td><?php echo $text_product_seo; ?></td>
		<td>  <?php echo $product_seourl_count; ?> <?php echo $text_available; ?> |  <?php echo $product_total; ?> <?php echo $text_total; ?> </td>
		<td><a class="btn btn-primary" onclick="generateSeo('generateproducturl')"><?php echo $btn_generate_seo; ?></a></td>
		<td><a class="btn btn-danger" onclick="clearSeo('product_id=%')"><?php echo $btn_clear; ?></a></td>
	</tr>
	<tr>
		<td><?php echo $text_category_seo; ?></td>
		<td>  <?php echo $category_seourl_count; ?> <?php echo $text_available; ?> |  <?php echo $category_total; ?> <?php echo $text_total; ?> </td>
		<td><a class="btn btn-primary" onclick="generateSeo('generatecategoryurl')"><?php echo $btn_generate_seo; ?></a></td>
		<td><a class="btn btn-danger" onclick="clearSeo('category_id=%')"><?php echo $btn_clear; ?></a></td>
	</tr>
	<tr>
		<td><?php echo $text_information_seo; ?></td>
		<td>  <?php echo $information_seourl_count; ?> <?php echo $text_available; ?> |  <?php echo $information_total; ?> <?php echo $text_total; ?> </td>
		<td><a class="btn btn-primary" onclick="generateSeo('generateinfourl')"><?php echo $btn_generate_seo; ?></a></td>
		<td><a class="btn btn-danger" onclick="clearSeo('information_id=%')"><?php echo $btn_clear; ?></a></td>
	</tr>
	<tr>
		<td><?php echo $text_brand_seo; ?></td>
		<td>  <?php echo $brand_seourl_count; ?> <?php echo $text_available; ?> |  <?php echo $brand_total; ?> <?php echo $text_total; ?> </td>
		<td><a class="btn btn-primary" onclick="generateSeo('generatebrandurl')"><?php echo $btn_generate_seo; ?></a></td>
		<td><a class="btn btn-danger" onclick="clearSeo('manufacturer_id=%')"><?php echo $btn_clear; ?></a></td>
	</tr>
</table>