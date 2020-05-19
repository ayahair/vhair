<footer>
	<div class="newsletter-group">
		<div class="container">
			<div class="container-inner">
				<?php if(isset($block4)){ ?>
					<?php echo $block4; ?>
				<?php } ?>
				<?php if(isset($block6)){ ?>
					<?php echo $block6; ?>
				<?php } ?>
			</div>
		</div>
	</div>
	<div class="footer-top">
	  <div class="container">
		<div class="row">
			<?php if(isset($block5)){ ?>
				<?php echo $block5; ?>
			<?php } ?>
		</div>
	  </div>
	</div>
	<div class="footer-bottom">
		<div class="container">
			<div class="container-inner">
				
				<div class="footer-copyright">
					<span><?php echo $copyright; ?></span>
				</div>
				<?php if(isset($block7)){ ?>
					<?php echo $block7; ?>
				<?php } ?>
			</div>
		</div>
	</div>
	  
  <div id="back-top"><i class="fa fa-angle-up"></i></div>

<script type="text/javascript">
$(document).ready(function(){
	// hide #back-top first
	$("#back-top").hide();
	// fade in #back-top
	$(function () {
		$(window).scroll(function () {
			if ($(this).scrollTop() > 300) {
				$('#back-top').fadeIn();
			} else {
				$('#back-top').fadeOut();
			}
		});
		// scroll body to 0px on click
		$('#back-top').click(function () {
			$('body,html').animate({scrollTop: 0}, 800);
			return false;
		});
	});

});
</script>
</footer>
<!-- live chat 3 widget -->
<script type="text/javascript">

$(document).ready(function(){

})
</script>

<div id="jaklcp-chat-container"></div>
<!-- end live chat 3 widget -->
</body></html>
<script>
	(function(w, d, s, u) {
		w.id = 1; w.lang = ''; w.cName = ''; w.cEmail = ''; w.cMessage = ''; w.lcjUrl = u;
		var h = d.getElementsByTagName(s)[0], j = d.createElement(s);
		j.async = true; j.src = 'https://avhair.com/chat/js/jaklcpchat.js';
		h.parentNode.insertBefore(j, h);
	})(window, document, 'script', 'https://avhair.com/chat/');

$('#submit-wholesale').on('click',function(){
  $.ajax({
    url: 'https://api.avhair.com/api/v1/rest/wholesale',
    data: JSON.stringify({
names: $('#names').val(),
email: $('#email').val(),
telephone: $('#telephone').val(),
country: $('#country').val(),
messages: $('#messages').val(),

} ),
         type: "POST",
        dataType: "json",
           contentType: "application/json"
  }).done(function() {
   alert('Success');
});
})
</script>
