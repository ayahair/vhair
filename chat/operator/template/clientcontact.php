<div class="modal-header">
	<h4 class="modal-title"><?php echo $jkl["m1"];?></h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
</div>
<div class="modal-body">
    	
    	<div class="jak-thankyou"></div>
    	
		<form role="form" class="jak-ajaxform" method="post" action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']);?>">
			
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
					    <label class="control-label" for="name"><?php echo $jkl["g54"];?></label>
						<input type="text" name="name" id="name" class="form-control" value="<?php echo $rowi['name'];?>" />
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
					    <label class="control-label" for="email"><?php echo $jkl["g220"];?></label>
						<input type="text" name="email" id="email" class="form-control" value="<?php echo $rowi['email'];?>" />
					</div>
				</div>
			</div>
			
			<div class="form-group">
			    <label class="control-label" for="subject"><?php echo $jkl["g221"];?></label>
				<input type="text" name="subject" id="subject" class="form-control" placeholder="<?php echo $jkl["g221"];?>" />
			</div>
			<div class="form-group">
			    <label class="control-label" for="message"><?php echo $jkl["g146"];?></label>
			    <textarea name="message" id="message" rows="5" class="form-control"></textarea>
			</div>
				
			<button type="submit" class="btn btn-primary btn-block ls-submit"><?php echo $jkl["g4"];?></button>
			
			<input type="hidden" name="send_email" value="1" />
			
		</form>
		
		<?php if (isset($MESSAGES_ALL) && is_array($MESSAGES_ALL)) { ?>
		<hr>
		<h3><?php echo $jkl["g222"];?></h3>
		<div class="panel-group" id="accordion">
		<?php foreach($MESSAGES_ALL as $v) { ?>
		  <div class="panel panel-default">
		    <div class="panel-heading">
		      <h4 class="panel-title">
		        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $v["id"];?>">
		          <?php echo $v["operator"];?> / <?php echo JAK_base::jakTimesince($v['sent'], JAK_DATEFORMAT, JAK_TIMEFORMAT);?>
		        </a>
		      </h4>
		    </div>
		    <div id="collapse<?php echo $v["id"];?>" class="panel-collapse collapse">
		    <div class="panel-body">
		    	<h3><?php echo $v["subject"];?></h3>
		      	<p><?php echo $v["message"];?></p>
		    </div>
		   </div>
		  </div>
		  <?php } ?>
		  
		</div>
		
		<?php } ?>
		
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $jkl["g180"];?></button>
	</div>

<script type="text/javascript" src="../js/contact.js"></script>

<script type="text/javascript">
	ls.main_url = "<?php echo BASE_URL;?>";
	ls.lsrequest_uri = "<?php echo JAK_PARSE_REQUEST;?>";
	ls.ls_submit = "<?php echo $jkl['g4'];?>";
	ls.ls_submitwait = "<?php echo $jkl['g67'];?>";
</script>
