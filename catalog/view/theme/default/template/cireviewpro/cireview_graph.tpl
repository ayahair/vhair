<?php if($reviewgraph) { ?>
<style type="text/css">
<?php if($reviewgraph_color) { ?>
  #cireview-graph .progress .progress-bar { 
      background-color: <?php echo $reviewgraph_color; ?>;  
  }
  #cireview-graph .cireview-stars .fa-star, #cireview-graph .cireview-stars .fa-star + .fa-star-o { 
      color: <?php echo $reviewgraph_color; ?>;  
  }
  <?php } ?>
</style>

<?php if($reviewgraph_option == 'PROGRESSBAR') { ?>
<div class="cireview-bars">
<ul class="list-unstyled">
<?php foreach($ratingreviews as $reviewrating => $totalreviews) {
$ariavalue = ($review_total) ? round(($totalreviews * 100) / $review_total, 2) : 0;
?>
  <li class="cirating-filter" data-cirating="<?php echo $reviewrating; ?>">
    <div class="n-star"><?php echo $reviewrating; ?> <i class="fa fa-star-o"></i></div>
    <div class="progress">
      <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $ariavalue; ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $ariavalue; ?>%"></div>
    </div> 
    <div class="progress-value"><?php echo $ariavalue; ?>%</div>        
  </li>
<?php } ?>
</ul>
</div>
<?php } ?>
<?php if($reviewgraph_option == 'RATINGSTARS') { ?>
<div class="cireview-stars">
<ul class="list-unstyled rating">
<?php foreach($ratingreviews as $reviewrating => $totalreviews) {
$ariavalue = ($review_total) ? round(($totalreviews * 100) / $review_total, 2) : 0;
?>  
  <li class="cirating-filter" data-cirating="<?php echo $reviewrating; ?>">
    <div class="rating-stars">
    <?php for ($i = 1; $i <= 5; $i++) { ?>
    <?php if ($reviewrating < $i) { ?>
    <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
    <?php } else { ?>
    <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
    <?php } ?>
    <?php } ?>
    </div>
    <div class="rating-value"><?php echo $ariavalue; ?>%</div>
  </li>
<?php } ?>
</ul>
</div>
<?php } ?>

<?php } ?>