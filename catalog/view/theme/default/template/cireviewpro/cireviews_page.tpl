<?php echo $header; ?>
<div class="container j-container <?php echo $journal_class; ?>" id="container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <?php if ($customcss) { ?><style type="text/css"><?php echo $customcss; ?></style><?php } ?>
  <div class="row"><?php echo $column_left; ?>
    <?php if($theme_name == 'journal2') { 
      echo $column_right; }
    ?>
    <?php echo $column_right; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6 xl-50'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9 xl-75'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12 xl-100'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
      <h2><?php echo $heading_title; ?></h2>
     
      <p><?php echo $description; ?></p>

      <div class="row">
        <?php if($theme_name == 'journal2') { ?> 
        <div class="product-filter">
          <div class="col-md-7 col-xs-12 xl-55 xs-100 display">
            &nbsp;
          </div>
          <?php if (!empty($limits)) { ?>
          <div class="limit"><b><?php echo $text_limit; ?></b>
            <select onchange="location = this.value;">
              <?php foreach ($limits as $limits_) { ?>
              <?php if ($limits_['value'] == $limit) { ?>
              <option value="<?php echo $limits_['href']; ?>" selected="selected"><?php echo $limits_['text']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $limits_['href']; ?>"><?php echo $limits_['text']; ?></option>
              <?php } ?>
              <?php } ?>
            </select>
          </div>
          <?php } ?>
          <?php if (!empty($sorts)) { ?>
          <div class="sort"><b><?php echo $text_sort; ?></b>
            <select onchange="location = this.value;">
              <?php foreach ($sorts as $sorts_) { ?>
              <?php if ($sorts_['value'] == $sort . '-' . $order) { ?>
              <option value="<?php echo $sorts_['href']; ?>" selected="selected"><?php echo $sorts_['text']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $sorts_['href']; ?>"><?php echo $sorts_['text']; ?></option>
              <?php } ?>
              <?php } ?>
            </select>
          </div>
          <?php } ?>
        </div>
        <?php } ?>
        <?php if($theme_name != 'journal2') { ?>
        <?php if (!empty($sorts)) { ?>
        <div class="col-md-3 col-xs-4 xl-25 xs-100">
          <div class="form-group input-group input-group-sm">
            <label class="input-group-addon" for="input-sort"><?php echo $text_sort; ?></label>
            <select id="input-sort" class="form-control" onchange="location = this.value;">
              <?php foreach ($sorts as $sorts_) { ?>
              <?php if ($sorts_['value'] == $sort . '-' . $order) { ?>
              <option value="<?php echo $sorts_['href']; ?>" selected="selected"><?php echo $sorts_['text']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $sorts_['href']; ?>"><?php echo $sorts_['text']; ?></option>
              <?php } ?>
              <?php } ?>
            </select>
          </div>
        </div>
        <?php } ?>
        <?php if (!empty($limits)) { ?>
        <div class="col-md-2 col-xs-3 xl-20 xs-100">
          <div class="form-group input-group input-group-sm">
            <label class="input-group-addon" for="input-limit"><?php echo $text_limit; ?></label>
            <select id="input-limit" class="form-control" onchange="location = this.value;">
              <?php foreach ($limits as $limits_) { ?>
              <?php if ($limits_['value'] == $limit) { ?>
              <option value="<?php echo $limits_['href']; ?>" selected="selected"><?php echo $limits_['text']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $limits_['href']; ?>"><?php echo $limits_['text']; ?></option>
              <?php } ?>
              <?php } ?>
            </select>
          </div>
        </div>
        <?php } ?>
        
        <?php if ($reviewsearch) { 
        $colmd = 12;
        $colxs =  12;
        $jxl = 100;
        $jxs = 100;

        if (!empty($sorts) && !empty($limits)) {
          $colmd = 7;
          $colxs =  5;
          $jxl = 55;
          $jxs = 100;
        }
        if (empty($sorts) && !empty($limits)) {
          $colmd = 10;
          $colxs =  9;
          $jxl = 80;
          $jxs = 100;
        }
        if (!empty($sorts) && empty($limits)) {
          $colmd = 9;
          $colxs =  8;
          $jxl = 75;
          $jxs = 100; 
        }
        ?>
        <div class="col-md-<?php echo $colmd; ?> col-xs-<?php echo $colxs; ?> xl-<?php echo $jxl; ?> xs-<?php echo $jxs; ?>">
          <div id="cireviewsearch" class="form-group input-group input-group-sm">
            <input type="text" name="cireviewsearch" value="<?php echo $cireviewsearch; ?>" placeholder="<?php echo $text_search; ?>" class="form-control" />
            <span class="input-group-btn">
              <button type="button" class="btn btn-default btn-sm"><i class="fa fa-search"></i></button>
            </span>
          </div>
        </div>

        <?php } ?>
        
        <?php } ?>
      </div>
      <?php if ($reviews) { ?>
      <?php echo $reviews_view; ?>      
      <?php } else { ?>
      <div class="row">
        <div class="col-sm-12 xl-100 xs-100">
           <h4 class="text-center"><?php echo $text_no_reviews; ?></h4> 
        </div>
      </div>
      <?php } ?>
    
      <?php if($promo_products) { ?>
      <div class="row">
        <div class="col-sm-12 xl-100 xs-100">
          <h2 class="text-<?php echo $reviewpromoalign; ?>"><?php echo $text_promoproduct_title; ?></h2>
          <ul class="list-inline list">
            <?php foreach($promo_products as $promo_product) { ?>
            <li>
              <div class="cireview-product-thumb">
                <a href="<?php echo $promo_product['href']; ?>">
                <?php if($promo_product['thumb']) { ?>                
                <img src="<?php echo $promo_product['thumb']; ?>" alt="<?php echo $promo_product['name']; ?>" class="img-responsive" /><br/>
                <?php } ?>
                <?php if ($reviewpromoproductnameshow) { ?>
                <h5><?php echo $promo_product['name']; ?></h5>
                <?php } ?>
                <?php if ($promo_product['rating']) { ?>
                <div class="rating">
                  <?php for ($i = 1; $i <= 5; $i++) { ?>
                  <?php if ($promo_product['rating'] < $i) { ?>
                  <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
                  <?php } else { ?>
                  <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
                  <?php } ?>
                  <?php } ?>
                </div>
                <?php } ?>
                <?php if ($promo_product['price']) { ?>
                <p class="price">
                  <?php if (!$promo_product['special']) { ?>
                  <?php echo $promo_product['price']; ?>
                  <?php } else { ?>
                  <span class="price-new"><?php echo $promo_product['special']; ?></span> <span class="price-old"><?php echo $promo_product['price']; ?></span>
                  <?php } ?>
                  <?php if ($promo_product['tax']) { ?>
                  <span class="price-tax"><?php echo $text_tax; ?> <?php echo $promo_product['tax']; ?></span>
                  <?php } ?>
                </p>
                <?php } ?>
                </a>
              </div>
            </li>
            <?php } ?>
          </ul>
        </div>
      </div>
      <?php } ?>

      <?php if($promo_categories) { ?>
      <div class="row">
        <div class="col-sm-12 xl-100 xs-100">
          <h2 class="text-<?php echo $reviewpromoalign; ?>"><?php echo $text_promocategory_title; ?></h2>
          <ul class="list-inline list">
            <?php foreach($promo_categories as $promo_category) { ?>
            <li>
              <div class="cireview-product-thumb">
                <a href="<?php echo $promo_category['href']; ?>">
                <?php if($promo_category['thumb']) { ?>                
                <img src="<?php echo $promo_category['thumb']; ?>" alt="<?php echo $promo_category['name']; ?>" class="img-responsive" /><br/>
                <?php } ?>
                <?php if ($reviewpromocategorynameshow) { ?>
                <h5><?php echo $promo_category['name']; ?></h5>
                <?php } ?>
                </a>
              </div>
            </li>
            <?php } ?>
          </ul>
        </div>
      </div>
      <?php } ?>

      <?php if($promo_manufacturers) { ?>
      <div class="row">
        <div class="col-sm-12 xl-100 xs-100">
          <h2 class="text-<?php echo $reviewpromoalign; ?>"><?php echo $text_promomanufacturer_title; ?></h2>
          <ul class="list-inline list">
            <?php foreach($promo_manufacturers as $promo_manufacturer) { ?>
            <li>
              <div class="cireview-product-thumb">
                <a href="<?php echo $promo_manufacturer['href']; ?>">
                <?php if($promo_manufacturer['thumb']) { ?>                
                <img src="<?php echo $promo_manufacturer['thumb']; ?>" alt="<?php echo $promo_manufacturer['name']; ?>" class="img-responsive" /><br/>
                <?php } ?>
                <?php if ($reviewpromomanufacturernameshow) { ?>
                <h5><?php echo $promo_manufacturer['name']; ?></h5>
                <?php } ?>
                </a>
              </div>
            </li>
            <?php } ?>
          </ul>
        </div>
      </div>
      <?php } ?>
      <?php echo $content_bottom; ?></div>
    <?php if($theme_name != 'journal2') { echo $column_right; } ?>
  </div>
  
  <?php if ($reviewsearch) { ?>
  <script type="text/javascript">
     /* Search */
    $('#cireviewsearch input[name=\'cireviewsearch\']').parent().find('button').on('click', function() {
      var url = $('base').attr('href') + 'index.php?route=cireviewpro/cireviews';

      var value = $('#cireviewsearch input[name=\'cireviewsearch\']').val();

      if (value) {
        url += '&cireviewsearch=' + encodeURIComponent(value);        
      }

      <?php if($reviewsortshow) { ?>
      <?php if($limit) { ?>
      url += '&limit=' + encodeURIComponent('<?php echo $limit; ?>');
      <?php } ?>
      <?php if($sort) { ?>
      url += '&sort=' + encodeURIComponent('<?php echo $sort; ?>');
      <?php } ?>
      <?php if($order) { ?>
      url += '&order=' + encodeURIComponent('<?php echo $order; ?>');
      <?php } ?>
      <?php } ?>
      location = url;
    });


    $('#cireviewsearch input[name=\'cireviewsearch\']').on('keydown', function(e) {
      if (e.keyCode == 13) {
        $('#cireviewsearch input[name=\'cireviewsearch\']').parent().find('button').trigger('click');
      }
    });
  </script>
  <?php } ?>
  
</div>
<?php echo $footer; ?>