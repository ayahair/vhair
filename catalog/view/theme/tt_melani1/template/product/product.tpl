<?php echo $header; ?>
	<div class="container">
		<ul class="breadcrumb">
			<?php foreach ($breadcrumbs as $breadcrumb) { ?>
				<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
			<?php } ?>
		</ul>
		<div class="row"><?php echo $column_left; ?>
			<?php if ($column_left && $column_right) { ?>
				<?php $class = 'col-sm-6'; ?>
			<?php } elseif ($column_left || $column_right) { ?>
				<?php $class = 'col-md-9 col-sm-12'; ?>
			<?php } else { ?>
				<?php $class = 'col-sm-12'; ?>
			<?php } ?>
			<div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
				<div class="row">
					<?php if ($column_left || $column_right) { ?>
						<?php $class = 'col-sm-6'; ?>
					<?php } else { ?>
						<?php $class = 'col-sm-5'; ?>
					<?php } ?>
					<div class="col-1 col-xlg-4 col-sm-5">
						<?php if ($thumb || $images) { ?>
							<div class="thumbnails">
								<?php if ($thumb) { ?>
									<a class="thumbnail" title="<?php echo $heading_title; ?>">
									<img src="<?php echo $thumb; ?>" data-zoom-image="<?php echo $popup; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" />
									</a>
								<?php } ?>
							</div>
							<div class="image-additional-container owl-style3">
								<div class="owl-container">
									<div class="image-additional" id="gallery_01">
										<?php if ($thumb) { ?>
										<a class="thumbnail" style="display: none" href="#" data-image="<?php echo $thumb; ?>" data-zoom-image="<?php echo $popup; ?>" title="<?php echo $heading_title; ?>"><img src="<?php echo $thumb; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" /></a>
										<?php } ?>
										<?php if ($images) { ?>
										<?php foreach ($images as $image) { ?>
										<a style="display: none" class="thumbnail" href="#" data-image="<?php echo $image['thumb']; ?>" data-zoom-image="<?php echo $image['popup']; ?>" title="<?php echo $heading_title; ?>"> <img src="<?php echo $image['thumb']; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" /></a>
										<?php } ?>
										<?php } ?>
									</div>
								</div>
							</div>
						<?php } ?>
					</div>
					<?php if ($column_left || $column_right) { ?>
						<?php $class = 'col-sm-6'; ?>
					<?php } else { ?>
						<?php $class = 'col-sm-7'; ?>
					<?php } ?>
					<div class="col-2 col-xlg-8 col-sm-7 product-info-main">

						<?php if ($tags) { ?>
							<p style="padding-left: 20px;" class="tags-product"><?php //echo $text_tags; ?>
								<?php for ($i = 0; $i < count($tags); $i++) { ?>
								<?php if ($i < (count($tags) - 1)) { ?>
								<a href="<?php echo $tags[$i]['href']; ?>"><?php echo $tags[$i]['tag']; ?></a>,
								<?php } else { ?>
								<a href="<?php echo $tags[$i]['href']; ?>"><?php echo $tags[$i]['tag']; ?></a>
								<?php } ?>
								<?php } ?>
							</p>
						<?php } ?>
						
						<h1 class="product-name" style="padding-left: 20px;"><?php echo $heading_title; ?></h1>
						<?php if ($review_status) { ?>
							<div class="ratings" style="padding-left: 20px;">
								<div class="rating-box">
								<?php for ($i = 0; $i <= 5; $i++) { ?>
								<?php if ($rating == $i) {
								$class_r= "rating".$i;
								echo '<div class="'.$class_r.'" style="float:left;">rating</div>';
								} 
								}  ?>
								<a href="javascript:void()" data-toggle="tab" aria-expanded="true" style="margin-left:10px;    position: relative;top:-3px;color: #999;" class="gw_look_review"><?php echo $tab_review; ?></a>
								</div>
							</div>
						<?php } ?>	
						<?php if ($price) { ?>
							<?php if (!$special) { ?>
								<div class="price-box box-regular" style="padding-left: 20px;    color: #cc0003;font-size: 24px;font-weight: bold;">
											<span class="regular-price">
                								<span class="<?php echo $live_options['live_options_price_container']; ?>"><?php echo $price; ?></span>
											</span>
								</div>
							<?php } else { ?>
								<div class="price-box box-special">
									<p class="special-price">
            							<span class="<?php echo $live_options['live_options_special_container']; ?>"><?php echo $special; ?></span>
									</p>
									<p class="old-price">
                						<span class="<?php echo $live_options['live_options_price_container']; ?>"><?php echo $price; ?></span>
									</p>
								</div>
							<?php } ?>
						<?php } ?>	
						
						
						
						<div class="box-info" style="padding-left: 20px;">
					
						
						</div>
							
						<p class="short-des" style="margin-left: 20px;padding: 0;">
						</p>
					
						<div id="product">
							<?php if ($options) { ?>
								<?php foreach ($options as $option) { ?>
									<?php if ($option['type'] == 'select') { ?>
										<div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
											<label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
											<select name="option[<?php echo $option['product_option_id']; ?>]" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control">
												<option value=""><?php echo $text_select; ?></option>
												<?php foreach ($option['product_option_value'] as $option_value) { ?>
													<option value="<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
													<?php if ($option_value['price']) { ?>
													(<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
													<?php } ?>
													</option>
												<?php } ?>
											</select>
										</div>
									<?php } ?>
									<?php if ($option['type'] == 'radio') { ?>
										<div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?> option-radio">
											<label class="control-label"><?php echo $option['name']; ?></label>
											<div id="input-option<?php echo $option['product_option_id']; ?>"  >
												<?php foreach ($option['product_option_value'] as $option_value) { ?>
												
														<a class="option-radio-a swatch-span" >
																			<input style="display:none" type="radio" id="radio_option[<?php echo $option['product_option_id']; ?>]"  name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" />

															<?php echo $option_value['name']; ?>
														<?php if ($option_value['price']) { ?>
														(<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
														<?php } ?>
														 </a>											
													
														
												<?php } ?>
											</div>
										</div>
									<?php } ?>
									<?php if ($option['type'] == 'checkbox') { ?>
										<div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
											<label class="control-label"><?php echo $option['name']; ?></label>
											<div id="input-option<?php echo $option['product_option_id']; ?>">
												<?php foreach ($option['product_option_value'] as $option_value) { ?>
												<div class="checkbox">
													<label>
														<input type="checkbox" name="option[<?php echo $option['product_option_id']; ?>][]" value="<?php echo $option_value['product_option_value_id']; ?>" />
														<?php if ($option_value['image']) { ?>
														<img src="<?php echo $option_value['image']; ?>" alt="<?php echo $option_value['name'] . ($option_value['price'] ? ' ' . $option_value['price_prefix'] . $option_value['price'] : ''); ?>" class="img-thumbnail" /> 
														<?php } ?>
														<?php echo $option_value['name']; ?>
														<?php if ($option_value['price']) { ?>
														(<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
														<?php } ?>
													</label>
												</div>
											<?php } ?>
											</div>
										</div>
									<?php } ?>
									<?php if ($option['type'] == 'image') { ?>
										<div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
											<label class="control-label"><?php echo $option['name']; ?></label>
											<div id="input-option<?php echo $option['product_option_id']; ?>">
												<?php foreach ($option['product_option_value'] as $option_value) { ?>
													<div class="radio">
														<label>
															<input type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" />
															<img src="<?php echo $option_value['image']; ?>" alt="<?php echo $option_value['name'] . ($option_value['price'] ? ' ' . $option_value['price_prefix'] . $option_value['price'] : ''); ?>" class="img-thumbnail" /> <?php echo $option_value['name']; ?>
															<?php if ($option_value['price']) { ?>
															(<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
															<?php } ?>
														</label>
													</div>
												<?php } ?>
											</div>
										</div>
									<?php } ?>
									<?php if ($option['type'] == 'text') { ?>
										<div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
											<label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
											<input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" placeholder="<?php echo $option['name']; ?>" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
										</div>
									<?php } ?>
									<?php if ($option['type'] == 'textarea') { ?>
										<div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
											<label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
											<textarea name="option[<?php echo $option['product_option_id']; ?>]" rows="5" placeholder="<?php echo $option['name']; ?>" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control"><?php echo $option['value']; ?></textarea>
										</div>
									<?php } ?>
									<?php if ($option['type'] == 'file') { ?>
										<div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
											<label class="control-label"><?php echo $option['name']; ?></label>
											<button type="button" id="button-upload<?php echo $option['product_option_id']; ?>" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-default btn-block"><i class="fa fa-upload"></i> <?php echo $button_upload; ?></button>
											<input type="hidden" name="option[<?php echo $option['product_option_id']; ?>]" value="" id="input-option<?php echo $option['product_option_id']; ?>" />
										</div>
									<?php } ?>
									<?php if ($option['type'] == 'date') { ?>
										<div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
											<label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
											<div class="input-group date">
												<input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" data-date-format="YYYY-MM-DD" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
												<span class="input-group-btn">
												<button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
												</span>
											</div>
										</div>
									<?php } ?>
									<?php if ($option['type'] == 'datetime') { ?>
										<div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
											<label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
											<div class="input-group datetime">
												<input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" data-date-format="YYYY-MM-DD HH:mm" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
												<span class="input-group-btn">
												<button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
												</span>
											</div>
										</div>
									<?php } ?>
									<?php if ($option['type'] == 'time') { ?>
										<div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
											<label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
											<div class="input-group time">
												<input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" data-date-format="HH:mm" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
												<span class="input-group-btn">
												<button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
												</span>
											</div>
										</div>
									<?php } ?>
								<?php } ?>
							<?php } ?>
						
							<?php if ($recurrings) { ?>
								<h3><?php echo $text_payment_recurring ?></h3>
								<div class="form-group required">
									<select name="recurring_id" class="form-control">
										<option value=""><?php echo $text_select; ?></option>
										<?php foreach ($recurrings as $recurring) { ?>
											<option value="<?php echo $recurring['recurring_id'] ?>"><?php echo $recurring['name'] ?></option>
										<?php } ?>
									</select>
									<div class="help-block" id="recurring-description"></div>
								</div>
							<?php } ?>
						
							<?php if ($minimum > 1) { ?>
								<div class="alert alert-info"><i class="fa fa-info-circle"></i> <?php echo $text_minimum; ?></div>
							<?php } ?>
						</div>
								  
						<div class="form-group" style="padding:0px 20px;">
							<label class="control-label" for="input-quantity"><?php echo $entry_qty; ?></label>
							<div class="quantity-box">
								<input type="button" id="minus" value="-" class="form-control" />					
								<input type="text" name="quantity" value="<?php echo $minimum; ?>" size="2" id="input-quantity" class="form-control" />
								<input type="button" id="plus" value="&#43;" class="form-control"/>
							</div>
						
							<button class="button button-cart" type="button" id="button-cart" data-loading-text="<?php echo $text_loading; ?>"><span><?php echo $button_cart; ?></span></button>
								<input type="button" title="Buy Now" value="Buy Now" data-loading-text="<?php echo $text_loading; ?>" id="button-buynow" class="btn btn-primary btn-lg " style="width:163.75px;float:left; background:#EC006C; ;border-color:#EC006C;  margin-top: 10px;margin-left:10px;height:50px;"	 />

							<button style="margin-left:20px;" class="button btn-wishlist" type="button" data-toggle="tooltip" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $product_id; ?>');"><i class="icon-heart"></i><span><?php echo $button_wishlist; ?></span></button>
							<button class="button btn-compare" type="button" data-toggle="tooltip" title="<?php echo $button_compare; ?>" onclick="compare.add('<?php echo $product_id; ?>');"><i class="icon-refresh"></i><span><?php echo $button_compare; ?></span></button>

						</div>
							<div class="form-group" style="padding:0px 20px;">
						<a href="javascript:void(0)" title="PayPal Express Checkout" id="paypal-express" style="text-decoration:none;">
<img src="https://www.paypalobjects.com/webstatic/en_US/i/buttons/checkout-logo-medium.png" alt="PayPal Express Checkout" style="float:left;"></a>
											<a href="javascript:void(0)" title="PayPal Express Checkout" id="paypal-express-credit" style="text-decoration:none;">

<img src="https://avhair.com/catalog/image/catalog/ppguest_1.gif" alt="PayPal Express Checkout" style="float:left;"></a>
						</div>
						<input type="hidden" name="product_id" value="<?php echo $product_id; ?>" />	  
						<!-- AddThis Button BEGIN -->
						<div style="padding: 20px;" class="addthis_toolbox addthis_default_style" data-url="<?php echo $share; ?>"><a class="addthis_button_facebook_like" fb:like:layout="button_count"></a> <a class="addthis_button_tweet"></a> <a class="addthis_button_pinterest_pinit"></a> <a class="addthis_counter addthis_pill_style"></a></div>
						<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-515eeaf54693130e"></script>
						<!-- AddThis Button END -->
						
					</div>
					
				</div>
				
				<div class="col-3 product-info-detailed">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#tab-description" data-toggle="tab"><?php echo $tab_description; ?></a></li>
						<?php if ($attribute_groups) { ?>
						<li><a href="#tab-specification" data-toggle="tab"><?php echo $tab_attribute; ?></a></li>
						<?php } ?>
						<?php if ($review_status) { ?>
						<li><a href="#tab-review" id="review-title" data-toggle="tab"><?php echo $tab_review; ?></a></li>
						<?php } ?>
					</ul>
					<div class="tab-content">
						<div class="tab-pane active" id="tab-description"><?php echo $description; ?></div>
						<?php if ($attribute_groups) { ?>
						<div class="tab-pane" id="tab-specification">
						<table class="table table-bordered">
						<?php foreach ($attribute_groups as $attribute_group) { ?>
						<thead>
						<tr>
						<td colspan="2"><strong><?php echo $attribute_group['name']; ?></strong></td>
						</tr>
						</thead>
						<tbody>
						<?php foreach ($attribute_group['attribute'] as $attribute) { ?>
						<tr>
						<td><?php echo $attribute['name']; ?></td>
						<td><?php echo $attribute['text']; ?></td>
						</tr>
						<?php } ?>
						</tbody>
						<?php } ?>
						</table>
						</div>
						<?php } ?>
						<?php if ($review_status) { ?>
						<div class="tab-pane" id="tab-review">

         
			<?php if($cireviewpro_status) {			
				/* Product Review Pro Starts */
				 echo $cireviewpro;
				/* Product Review Pro Ends */
			?>
			<form class="form-horizontal hide" id="form-review" style="display: none;">
			<?php } else { ?>
			<?php if($cireviewpro_status) {			
				/* Product Review Pro Starts */
				 echo $cireviewpro;
				/* Product Review Pro Ends */
			?>
			<form class="form-horizontal hide" id="form-review" style="display: none;">
			<?php } else { ?>
			<?php if($cireviewpro_status) {			
				/* Product Review Pro Starts */
				 echo $cireviewpro;
				/* Product Review Pro Ends */
			?>
			<form class="form-horizontal hide" id="form-review" style="display: none;">
			<?php } else { ?>
			<form class="form-horizontal" id="form-review">
			<?php } ?>
			<?php } ?>
			<?php } ?>
						</div>
						<?php } ?>
					</div>
				</div>
				<div class="col-related">
					<?php if ($products) { ?>
						<div class="related-product-container quickview-add module-style1">
							<div class="group-title">
								<h2>
									<?php 
									$title2 = explode(' ',$text_related,3); 
									for($i=0;$i<count($title2);$i++){ 
									$j=$i+1;
									echo $j>1 ? "<span class='word2'> ".$title2[$i]." </span>" : "<span> ".$title2[$i]." </span>";
									}
									?>
								</h2>
							</div>
							<div class="owl-container">
								<div class="related-product ">
									<?php foreach ($products as $product) { ?>
										<div class="row_items">
											<div class="item">
												<div class="item-inner">
													<div class="images-container">
														
														
														<?php if ($product['is_new']):
															if($product['special']): ?>
																<div class="label-pro-sale"><span><?php echo round(($product['special_num']-$product['price_num'])/$product['price_num']*100)."%"; ?></span></div>
																<div class="label-pro-new"><span><?php echo $text_new; ?></span></div>
															<?php else: ?>
																<div class="label-pro-new"><span><?php echo $text_new; ?></span></div>
															<?php endif; ?>
														<?php else: ?>
															<?php if($product['special']): ?>
																<div class="label-pro-sale"><span><?php echo round(($product['special_num']-$product['price_num'])/$product['price_num']*100)."%"; ?></span></div>
															<?php endif; ?>
														<?php endif; ?>
														
														<a href="<?php echo $product['href']; ?>">
															<?php if ($product['thumb']) { ?>
																<?php if($product['rotator_image']){ ?>
																	<img class="img-r" src="<?php echo $product['rotator_image']; ?>" alt="<?php echo $product['name']; ?>" />
																<?php } ?>
																<img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" />
															<?php } ?>
														</a>
														<div class="actions">
															<ul class="add-to-links">
																<li>
																	<a class="link-wishlist" title="<?php echo $button_wishlist; ?>" data-toggle="tooltip" onclick="wishlist.add('<?php echo $product['product_id']; ?>');">
																	<em><?php echo $button_wishlist; ?></em>
																	</a>
																</li>
																<li>
																	<a class="link-compare" title="<?php echo $button_compare; ?>" data-toggle="tooltip" onclick="compare.add('<?php echo $product['product_id']; ?>');">
																	<em><?php echo $button_compare; ?></em>
																	</a>
																</li>
															</ul>

														</div><!-- actions -->
								  
													</div> <!-- image -->

									
													<div class="des-container">
														<?php if ($product['tags']) { ?>
															<p class="tags-product">
															<?php for ($i = 0; $i < count($product['tags']); $i++) { ?>
															<?php if ($i < (count($product['tags']) - 1)) { ?>
															<a href="<?php echo $product['tags'][$i]['href']; ?>"><?php echo $product['tags'][$i]['tag']; ?></a>,
															<?php } else { ?>
															<a href="<?php echo $product['tags'][$i]['href']; ?>"><?php echo $product['tags'][$i]['tag']; ?></a>
															<?php } ?>
															<?php } ?>
															</p>
														<?php } ?>
														<h2 class="product-name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></h2>
														
														
														<?php if ($product['price']) { ?>
															<?php if (!$product['special']) { ?>
																<div class="price-box box-regular">
																<span class="regular-price">
																<span class="price"><?php echo $product['price']; ?></span>
																</span>
																</div>
															<?php } else { ?>
																<div class="price-box box-special">
																<p class="special-price"><span class="price"><?php echo $product['special']; ?></span></p>
																<p class="old-price"><span class="price"><?php echo $product['price']; ?></span></p>
																</div>
															<?php } ?>
														<?php } ?>
														
														<?php 
															$showdes = 0;
															if ($showdes) :
														?>
															<p class="product-des">
																<?php echo $product['description']; ?>
															</p>
														<?php endif; ?>
														
														<button class="button btn-cart" type="button" data-toggle="tooltip" title="<?php echo $button_cart; ?>" onclick="cart.add('<?php echo $product['product_id']; ?>');">
															<span><span><?php echo $button_cart; ?></span></span>
															</button>
														<div class="box-hover">
															<?php if (isset($product['rating'])) { ?>
																<div class="ratings">
																<div class="rating-box">
																<?php for ($i = 0; $i <= 5; $i++) { ?>
																<?php if ($product['rating'] == $i) {
																$class_r= "rating".$i;
																echo '<div class="'.$class_r.'">rating</div>';
																} 
																}  ?>
																
																</div>
																</div>
															<?php } ?>
														</div>
													</div>
												</div>
											</div>
										</div>
									<?php } ?>
								</div>
							</div>
						</div>
					<?php } ?>
				</div>
				<?php echo $content_bottom; ?>
			</div>
			<?php echo $column_right; ?>
		</div>
	</div>
	
<script type="text/javascript"><!--
$('.gw_look_review').click(function(){
	$('#review-title').click() 
	$('html, body').animate({
		scrollTop: $('#review-title').offset().top
	}, 500);
})
$('select[name=\'recurring_id\'], input[name="quantity"]').change(function(){
	$.ajax({
		url: 'index.php?route=product/product/getRecurringDescription',
		type: 'post',
		data: $('input[name=\'product_id\'], input[name=\'quantity\'], select[name=\'recurring_id\']'),
		dataType: 'json',
		beforeSend: function() {
			$('#recurring-description').html('');
		},
		success: function(json) {
			$('.alert, .text-danger').remove();

			if (json['success']) {
				$('#recurring-description').html(json['success']);
			}
		}
	});
});
//--></script>
<script type="text/javascript"><!--

		$('#button-buynow').on('click', function() {
				$.ajax({
					url: 'index.php?route=checkout/cart/add',
					type: 'post',
					data: $('input[name=\'product_id\'], #input-quantity, #product input[type=\'text\'], #product input[type=\'hidden\'], #product input[type=\'radio\']:checked, #product input[type=\'checkbox\']:checked, #product select, #product textarea'),
					dataType: 'json',
					beforeSend: function() {
						$('#button-cart').button('loading');
					},
					complete: function() {
						$('#button-cart').button('reset');
					},
					success: function(json) {
						$('.alert, .text-danger').remove();
						$('.form-group').removeClass('has-error');
						if (json['error']) {
							if (json['error']['option']) {
								for (i in json['error']['option']) {
									var element = $('#input-option' + i.replace('_', '-'));
									if (element.parent().hasClass('input-group')) {
										element.parent().after('<div class="text-danger" style="clear:both">' + json['error']['option'][i] + '</div>');
									} else {
										element.after('<div class="text-danger" style="clear:both">' + json['error']['option'][i] + '</div>');
									}
								}
							}
							if (json['error']['recurring']) {
								$('select[name=\'recurring_id\']').after('<div class="text-danger" style="clear:both">' + json['error']['recurring'] + '</div>');
							}
							$('.text-danger').parent().addClass('has-error');
						}
						if (json['success']) {
							location = "index.php?route=checkout/checkout";
						}
					},
					error: function(xhr, ajaxOptions, thrownError) {
						alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
				});
			});

		$('#paypal-express').on('click', function() {
				$.ajax({
					url: 'index.php?route=checkout/cart/add',
					type: 'post',
					data: $('input[name=\'product_id\'], #input-quantity, #product input[type=\'text\'], #product input[type=\'hidden\'], #product input[type=\'radio\']:checked, #product input[type=\'checkbox\']:checked, #product select, #product textarea'),
					dataType: 'json',
					beforeSend: function() {
						$('#button-cart').button('loading');
					},
					complete: function() {
						$('#button-cart').button('reset');
					},
					success: function(json) {
						$('.alert, .text-danger').remove();
						$('.form-group').removeClass('has-error');
						if (json['error']) {
							if (json['error']['option']) {
								for (i in json['error']['option']) {
									var element = $('#input-option' + i.replace('_', '-'));
									if (element.parent().hasClass('input-group')) {
										element.parent().after('<div class="text-danger" style="clear:both">' + json['error']['option'][i] + '</div>');
									} else {
										element.after('<div class="text-danger" style="clear:both">' + json['error']['option'][i] + '</div>');
									}
								}
							}
							if (json['error']['recurring']) {
								$('select[name=\'recurring_id\']').after('<div class="text-danger" style="clear:both">' + json['error']['recurring'] + '</div>');
							}
							$('.text-danger').parent().addClass('has-error');
						}
						if (json['success']) {
							location = "index.php?route=extension/payment/pp_express/express&creditcard=0";
						}
					},
					error: function(xhr, ajaxOptions, thrownError) {
						alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
				});
		});
			$('#paypal-express-credit').on('click', function() {
				$.ajax({
					url: 'index.php?route=checkout/cart/add',
					type: 'post',
					data: $('input[name=\'product_id\'], #input-quantity, #product input[type=\'text\'], #product input[type=\'hidden\'], #product input[type=\'radio\']:checked, #product input[type=\'checkbox\']:checked, #product select, #product textarea'),
					dataType: 'json',
					beforeSend: function() {
						$('#button-cart').button('loading');
					},
					complete: function() {
						$('#button-cart').button('reset');
					},
					success: function(json) {
						$('.alert, .text-danger').remove();
						$('.form-group').removeClass('has-error');
						if (json['error']) {
							if (json['error']['option']) {
								for (i in json['error']['option']) {
									var element = $('#input-option' + i.replace('_', '-'));
									if (element.parent().hasClass('input-group')) {
										element.parent().after('<div class="text-danger" style="clear:both">' + json['error']['option'][i] + '</div>');
									} else {
										element.after('<div class="text-danger" style="clear:both">' + json['error']['option'][i] + '</div>');
									}
								}
							}
							if (json['error']['recurring']) {
								$('select[name=\'recurring_id\']').after('<div class="text-danger" style="clear:both">' + json['error']['recurring'] + '</div>');
							}
							$('.text-danger').parent().addClass('has-error');
						}
						if (json['success']) {
							location = "index.php?route=extension/payment/pp_express/express&creditcard=1";
						}
					},
					error: function(xhr, ajaxOptions, thrownError) {
						alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
				});
		});
$('#button-cart').on('click', function() {
	$.ajax({
		url: 'index.php?route=checkout/cart/add',
		type: 'post',
		data: $('input[name=\'product_id\'], #input-quantity, #product input[type=\'text\'], #product input[type=\'hidden\'], #product input[type=\'radio\']:checked, #product input[type=\'checkbox\']:checked, #product select, #product textarea'),
		dataType: 'json',
		beforeSend: function() {
			$('#button-cart').button('loading');
		},
		complete: function() {
			$('#button-cart').button('reset');
		},
		success: function(json) {
			$('.alert, .text-danger').remove();
			$('.form-group').removeClass('has-error');

			if (json['error']) {
				if (json['error']['option']) {
					for (i in json['error']['option']) {
						var element = $('#input-option' + i.replace('_', '-'));

						if (element.parent().hasClass('input-group')) {
							element.parent().after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
						} else {
							element.after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
						}
					}
				}

				if (json['error']['recurring']) {
					$('select[name=\'recurring_id\']').after('<div class="text-danger">' + json['error']['recurring'] + '</div>');
				}

				// Highlight any found errors
				$('.text-danger').parent().addClass('has-error');
			}

			if (json['success']) {
				$('body').before('<div class="alert alert-success">' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');

				$('#cart-total').html(json['total']);

				$('html, body').animate({ scrollTop: 0 }, 'slow');

				$('#cart > ul').load('index.php?route=common/cart/info ul li');
			}
		},
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
	});
});
//--></script>
<script type="text/javascript"><!--
$('.date').datetimepicker({
	pickTime: false
});

$('.datetime').datetimepicker({
	pickDate: true,
	pickTime: true
});

$('.time').datetimepicker({
	pickDate: false
});

$('button[id^=\'button-upload\']').on('click', function() {
	var node = this;

	$('#form-upload').remove();

	$('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file" /></form>');

	$('#form-upload input[name=\'file\']').trigger('click');

	if (typeof timer != 'undefined') {
    	clearInterval(timer);
	}

	timer = setInterval(function() {
		if ($('#form-upload input[name=\'file\']').val() != '') {
			clearInterval(timer);

			$.ajax({
				url: 'index.php?route=tool/upload',
				type: 'post',
				dataType: 'json',
				data: new FormData($('#form-upload')[0]),
				cache: false,
				contentType: false,
				processData: false,
				beforeSend: function() {
					$(node).button('loading');
				},
				complete: function() {
					$(node).button('reset');
				},
				success: function(json) {
					$('.text-danger').remove();

					if (json['error']) {
						$(node).parent().find('input').after('<div class="text-danger">' + json['error'] + '</div>');
					}

					if (json['success']) {
						alert(json['success']);

						$(node).parent().find('input').attr('value', json['code']);
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		}
	}, 500);
});
//--></script>
<script type="text/javascript"><!--
$('#review').delegate('.pagination a', 'click', function(e) {
    e.preventDefault();

    $('#review').fadeOut('slow');

    $('#review').load(this.href);

    $('#review').fadeIn('slow');
});

$('#review').load('index.php?route=product/product/review&product_id=<?php echo $product_id; ?>');

$('#button-review').on('click', function() {
	$.ajax({
		url: 'index.php?route=product/product/write&product_id=<?php echo $product_id; ?>',
		type: 'post',
		dataType: 'json',
		data: $("#form-review").serialize(),
		beforeSend: function() {
			$('#button-review').button('loading');
		},
		complete: function() {
			$('#button-review').button('reset');
		},
		success: function(json) {
			$('.alert-success, .alert-danger').remove();

			if (json['error']) {
				$('#review').after('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
			}

			if (json['success']) {
				$('#review').after('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '</div>');

				$('input[name=\'name\']').val('');
				$('textarea[name=\'text\']').val('');
				$('input[name=\'rating\']:checked').prop('checked', false);
			}
		}
	});
});
var minimum = <?php echo $minimum; ?>;
  $("#input-quantity").change(function(){
    if ($(this).val() < minimum) {
      alert("Minimum Quantity: "+minimum);
      $("#input-quantity").val(minimum);
    }
  });
  // increase number of product
  function minus(minimum){
      var currentval = parseInt($("#input-quantity").val());
      $("#input-quantity").val(currentval-1);
      if($("#input-quantity").val() <= 0 || $("#input-quantity").val() < minimum){
          alert("Minimum Quantity: "+minimum);
          $("#input-quantity").val(minimum);
     }
  };
  // decrease of product
  function plus(){
      var currentval = parseInt($("#input-quantity").val());
     $("#input-quantity").val(currentval+1);
  };
  $('#minus').click(function(){
    minus(minimum);
  });
  $('#plus').click(function(){
    plus();
  });
  // zoom
	$(".thumbnails img").elevateZoom({
		zoomType : "window",
		cursor: "crosshair",
		gallery:'gallery_01', 
		galleryActiveClass: "active", 
		imageCrossfade: true,
		responsive: true,
		zoomWindowOffetx: 0,
		zoomWindowOffety: 0,
	});
	// slider	 
	$(".image-additional").owlCarousel({
		navigation: true,
		pagination: false,
		slideSpeed : 500,
		lazyLoad : true,
		goToFirstSpeed : 1500,
		addClassActive: true,
		items : 4, 
		itemsDesktop : [1199,3],
		itemsDesktopSmall : [1024,3],
		itemsTablet: [640,3],
		itemsMobile : [480,3],
		
		afterInit: function(){
			$('#gallery_01 .owl-wrapper .owl-item:first-child').addClass('active');
		},
		beforeInit: function(){
			$(".image-additional .thumbnail").show();
		}
	});	
	$('#gallery_01 .owl-item .thumbnail:first').addClass('active2');
	$('#gallery_01 .owl-item .thumbnail').each(function(){
		$(this).click(function(){
			$('#gallery_01 .owl-item').removeClass('active2');
			$(this).parent().addClass('active2');
		});
	});
	$('.option-radio-a').on('click', function(){
		$(this).find('input').attr('checked', 'checked')
		$(this).parent().find('.option-radio-a').removeClass('active')
		$(this).addClass('active')
		window.price_with_options_ajax_call()
	})
	// related products	 
	$(".related-product").owlCarousel({
		navigation: true,
		pagination: false,
		addClassActive: true,
		lazyLoad : true,
		slideSpeed : 500,
		goToFirstSpeed : 1500,
		items : 6, 
		itemsDesktop : [1599,4],
		itemsDesktopSmall : [991,3],
		itemsTablet: [767,2],
		itemsMobile : [479,1],
		
		afterInit : function(){
			this.$owlItems.removeClass('first')
			this.$owlItems.removeClass('last')
			this.$owlItems .eq(this.currentItem).addClass('first');
			this.$owlItems .eq(this.currentItem + (this.owl.visibleItems.length - 1)).addClass('last');
		},
		afterAction: function(el){
			this.$owlItems.removeClass('first')
			this.$owlItems.removeClass('last')
			this.$owlItems .eq(this.currentItem).addClass('first');
			this.$owlItems .eq(this.currentItem + (this.owl.visibleItems.length - 1)).addClass('last');
		},
	});

//--></script>

<script type="text/javascript" src="index.php?route=product/live_options/js&product_id=<?php echo $product_id; ?>"></script>
			
<?php echo $footer; ?>
