<h3 class="cireview-heading"><?php echo $heading_title; ?></h3>
<?php if ($reviews) { ?>
<?php echo $reviews_view; ?>      
<?php } else { ?>
<div class="row">
  <div class="col-sm-12 xl-100 xs-100">
     <h4 class="text-center"><?php echo $text_no_reviews; ?></h4> 
  </div>
</div>
<?php } ?>