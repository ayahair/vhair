<?php echo $header; ?>
	<div id="content">
		<?php echo $column_left; ?> 
		<?php echo $content_top; ?>
		<?php echo $content_bottom; ?>
		<?php echo $column_right; ?>
	</div>

			<?php if ($hb_snippets_kg_enable == '1'){echo html_entity_decode($hb_snippets_kg_data);} ?>
			<?php if ($hb_snippets_local_enable == 'y'){echo html_entity_decode($hb_snippets_local_snippet);} ?>
			
<?php echo $footer; ?>