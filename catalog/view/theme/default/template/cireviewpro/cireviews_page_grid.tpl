<div class="cireview-wrap">
<div class="row">
<?php $row = (12/$reviewperrow); 

$col_sm_img = 12;
$col_sm_txt = 12;
if($reviewperrow == 1) {
$col_sm_img = 4;
$col_sm_txt = 6;
}
if($reviewperrow == 2) {
$col_sm_img = 5;
$col_sm_txt = 7;
}

?> 
<?php $jrow = round(100/$reviewperrow); ?> 
<?php foreach ($reviews as $review) { ?>
<div class="col-md-<?php echo $row; ?> col-sm-12 col-xs-12 xl-<?php echo $jrow; ?> xs-100 sm-100">
<div class="cireview-grid cireviews <?php  if($review['verified']) { echo 'ci-verified'; }  ?> <?php  if($review['imp']) { echo 'ci-imp'; }  ?>">
<div class="row">
<div class="col-sm-<?php echo $col_sm_img; ?> col-xs-12 xl-100 xs-100">
  <?php if($review['product']) { ?>
  <div class="cireview-product-thumb">
     <a href="<?php echo $review['product']['href']; ?>">
      <img src="<?php echo $review['product']['thumb']; ?>" alt="<?php echo $review['product']['name']; ?>" class="img-responsive" /> <br/>
      <?php echo $review['product']['name']; ?>
      </a>
  </div>
  <?php } ?>
  
</div>
<div class="col-sm-<?php echo $col_sm_txt; ?> col-xs-12 xl-100 xs-100">
  <?php  if($review['verified']) { ?>
  <div class="verified"><?php echo $text_verified; ?> <i class="fa fa-check-circle"></i></div>
  <?php }  ?>
  <?php if(!empty($review['author'])) { ?>
  <h3><?php echo $text_author; ?><?php echo $review['author']; ?></h3>
  <?php } ?>
  <?php if(!empty($review['reviewtitle'])) { ?>
  <h4><label class="control-label"><?php echo $text_title; ?></label><?php echo $review['reviewtitle']; ?></h4>
  <?php } ?>
  <ul class="list-unstyled average rating">
    <li><?php echo $text_date_added; ?><?php echo $review['date_added']; ?></li>
    <?php if ($review['rating']) { ?>
    <li><?php echo $text_rating; ?> 
      <?php for ($i = 1; $i <= $ratingstars; $i++) { ?>
      <?php if ($review['rating'] < $i) { ?>
      <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
      <?php } else { ?>
      <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
      <?php } ?>
      <?php } ?>
      <?php if ($reviewratingcount) { ?><span class="ciratingcount"> (<?php echo $review['rating']; ?>) </span><?php } ?>
    </li>
    <?php } ?>
  </ul>

<div class="all-rating">
  <?php if($review['cireview_ratings'] && count($review['cireview_ratings']) > 1) { ?>
  <ul class="list-unstyled">
    <?php foreach($review['cireview_ratings'] as $cireview_rating) { ?>
    <li class="cireview_rating-<?php echo $review['review_id']; ?>-<?php echo $cireview_rating['cireview_rating_id']; ?> ">
      <?php echo $cireview_rating['ciratingtype_name']; ?> :
      <div class="stars rating">
        <?php for ($i = 1; $i <= $ratingstars; $i++) { ?>
          <?php if ($cireview_rating['rating'] < $i) { ?>
          <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
          <?php } else { ?>
          <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
          <?php } ?>
        <?php } ?>
        <?php if ($reviewratingcount) { ?><span class="ciratingcount"> (<?php echo $cireview_rating['show_rating']; ?>) </span><?php } ?>
      </div>
    </li>
    <?php } ?>
  </ul>
  <?php } ?>
  </div>
      <p><?php echo $review['text']; ?></p>
      <?php if($review['attach_images']) { ?>
        <ul class="list list-inline cireviewattach_images" id="cireviewattach_images-<?php echo $review['review_id']; ?>">
          <?php foreach($review['attach_images'] as $attach_image) { ?>
          <li id="cireviewattach_image-<?php echo $attach_image['cireview_image_id']; ?>">
          <a href="<?php echo $attach_image['popup']; ?>" title="<?php echo $attach_image['title']; ?>"> <img src="<?php echo $attach_image['thumb']; ?>" alt="<?php echo $attach_image['alt']; ?>" title="<?php echo $attach_image['title']; ?>" /> </a> </li>
          <?php } ?>
        </ul>
      <?php } ?>
  <?php if($review['comment']) { ?>
  <div class="cireviewcomment">
  <label class="control-label"><?php echo $text_replyby; ?>: <?php echo $reviewreplyauthor; ?> </label> <br/>
  <?php echo $review['comment']; ?>
  </div>
  <?php } ?>
  <?php if($reviewvote) { ?>
  <div class="cireview-vote" id="cireview-vote-<?php echo $review['review_id']; ?>-<?php echo $review['product_id']; ?>-<?php echo $review['cireview_id']; ?>">

    <span class="vote-result">
      <?php echo $review['votes']['after_text']; ?>
    </span>
    
  </div>
  <?php } ?>
    <?php if($reviewshare) { ?>
    <!-- AddThis Button BEGIN -->
    <div class="addthis_toolbox addthis_default_style addthis_16x16_style" data-url="<?php echo $review['share']; ?>" addthis:url="<?php echo $review['share']; ?>" data-title="<?php echo $review['author']; ?>" addthis:title="<?php echo $review['author']; ?>" data-description="<?php echo $review['text']; ?>" addthis:description="<?php echo $review['text']; ?>">
    <a class="addthis_button_facebook"></a> 
    <a class="addthis_button_tweet"></a>
    <a class="addthis_button_google_plusone_share"></a> 
    <a class="addthis_button_email"></a>  
    <a class="addthis_button_compact"></a>
    <!--
    <a class="addthis_counter addthis_pill_style"></a>
    <a class="addthis_button_facebook_like"></a>         
    <a class="addthis_button_pinterest_pinit"></a>        
     -->
    </div>
    <!-- AddThis Button END -->
    <?php } ?>
  </div>
</div>
</div>
</div>
<?php } ?>

<?php if($reviewshare) { ?>
<script type="text/javascript">var addthis_config = {"data_track_clickback": true};</script>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-515eeaf54693130e"></script>
<?php } ?>
</div>
<div class="row j-margin">
  <div class="col-md-6 col-sm-12 xl-50 xs-100">
    <div class="text-left"><?php echo $results; ?></div>
  </div>
  <div class="col-md-6 col-sm-12 xl-50 xs-100">
    <div class="text-right"><?php echo $pagination; ?></div>
  </div>
</div>

<script type="text/javascript">
  $('.cireviewattach_images').each(function() {
    $(this).magnificPopup({
      type:'image',
      delegate: 'a',
      gallery: {
        enabled:true
      }
    });
  });
</script>
</div>
