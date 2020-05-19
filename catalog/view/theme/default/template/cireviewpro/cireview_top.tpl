<?php if($reviews) { ?>
<div class="cireview-top">
<div class="citop-heading"><?php echo $text_topreview; ?></div>
<?php $j = 1; foreach($reviews as $review) { ?>
<div class="cireview-inner clearfix">
	<div class="citop-count"><?php echo $j; ?></div>	
	<div class="outof">
    <?php if ($review['rating']) { ?>
		<div class="trate"><?php echo $review['show_rating']; ?><sup>/<?php echo $ratingstars; ?></sup></div>
		<ul class="list-unstyled top-rating">
			<li>
        <?php for ($i = 1; $i <= $ratingstars; $i++) { ?>
        <?php if ($review['rating'] < $i) { ?>
        <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
        <?php } else { ?>
        <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
        <?php } ?>
        <?php } ?>
			</li>	
		</ul>
    <?php } ?>
	</div>
	<div class="ci-custom-mat">
		<?php if($review['reviewtitle']) { ?><div class="citop-reviewtitle"><?php echo $review['reviewtitle']; ?></div><?php } ?>
		<?php if($review['text']) { ?><div class="citop-description"><?php echo $review['text']; ?></div><?php } ?>
		<?php if($review['author']) { ?><div class="author"><?php echo $review['author']; ?></div><?php } ?>
		<div class="ci-date"><?php echo $review['date_added']; ?></div>
	</div>	
</div>
<?php $j++; } ?>
</div>
<?php } ?>