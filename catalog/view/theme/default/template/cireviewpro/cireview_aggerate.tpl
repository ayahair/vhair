<div id="aggerate-cireview" class="cireview-wrap">
  <div class="cireview-aggerate cireviews">    
    <div class="row">
      <h3 class="cireview-aggerate-title"><a href="<?php echo $href_review; ?>"><?php echo $text_reviewover; ?></a></h3>
      <?php
      $colsm = 12;
      $jxl = 100;
      if($cireview_ratings && count($cireview_ratings) > 1) {
        $colsm = 7;
        $jxl = 70;
      }
      ?>
      <ul class="list-unstyled average rating text-center final-avrge">
        <li><label class="control-label"><?php echo $text_rating; ?></label> 
          <?php for ($i = 1; $i <= 5; $i++) { ?>
          <?php if ($avg_rating < $i) { ?>
          <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
          <?php } else { ?>
          <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
          <?php } ?>
          <?php } ?>
          <?php if ($reviewratingcount) { ?><span class="ciratingcount"> (<?php echo $show_avg_rating; ?>) </span><?php } ?>
        </li>
      </ul>
      <div class="col-sm-<?php echo $colsm; ?> col-xs-12 xl-<?php echo $jxl; ?> xs-100 sm-100 j-margin">
        <p><?php echo $text_total_reviews; ?> <br/>
          <span class="giverating addrating"><?php echo $text_write_review; ?></span>
        </p>
      </div>
      <?php if($cireview_ratings && count($cireview_ratings) > 1) { ?>
      <div class="col-sm-5 col-xs-12 all-rating xl-30 xs-100 sm-100 j-margin">        
        <?php if($cireview_ratings && count($cireview_ratings) > 1) { ?>
        <ul class="list-unstyled">
          <?php foreach($cireview_ratings as $cireview_rating) { ?>
          <li class="cireview_avgrating-<?php echo $cireview_rating['ciratingtype_id']; ?> ">
            <label class="control-label"><?php echo $cireview_rating['ciratingtype_name']; ?> : </label>
            <div class="stars rating">
              <?php for ($i = 1; $i <= 5; $i++) { ?>
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
      <?php } ?>
    </div>
  </div>
</div>