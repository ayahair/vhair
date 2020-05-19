<div class="cireview-column-wrap">
<div class="row"> 
<?php foreach ($reviews as $review) { ?>
<div class="col-md-12 col-sm-12 col-xs-12 xl-100 xs-100 sm-100">
<div class="cireview-list cireviews">
<div class="row">
<div class="col-sm-12 col-xs-12 xl-100 xs-100">
  <div class="ciproductname"><a href="<?php echo $review['href']; ?>"><?php echo $review['product']['name']; ?></a></div>
  <?php if (($ratingshow) || (!empty($review['reviewtitle'])) ) { ?><div class="cistars rating"><?php //echo $text_rating; ?><?php } ?>
    <?php if ($ratingshow) { ?>
      <?php for ($i = 1; $i <= 5; $i++) { ?>
      <?php if ($review['rating'] < $i) { ?>
      <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
      <?php } else { ?>
      <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
      <?php } ?>
      <?php } ?>
      <!-- /*new update starts*/ --><?php if ($ratingshowcount) { ?><span class="ciratingcount"> (<?php echo $review['rating']; ?>) </span><?php } ?><!-- /*new update ends*/ -->
    <?php } ?>
    <?php if(!empty($review['reviewtitle'])) { ?><span class="reviewtitle"><a href="<?php echo $review['href']; ?>"><?php echo $review['reviewtitle']; ?></a></span><?php } ?>
  <?php if (($ratingshow) || (!empty($review['reviewtitle'])) ) { ?></div><?php } ?>
  <p><?php echo $review['text']; ?></p>
  <div class="cipublished"><?php echo $text_date_added; ?> <?php echo $review['date_added']; ?> <?php if(!empty($review['author'])) { ?> <?php echo $text_author; ?> <?php echo $review['author']; ?><?php } ?></div>
</div>
</div>
</div>
</div>
<?php } ?>
</div>
</div>