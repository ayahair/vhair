 <table class="table table-hover">
<thead>
<tr>
<th><?php echo $col_batch_id; ?></th>
<th><?php echo $col_batch_range; ?></th>
<th><?php echo $col_batch_status; ?></th>
<th><?php echo $col_batch_tstatus; ?></th>
<th><?php echo $col_batch_date; ?></th>
</tr>
</thead>
<tbody>
<?php if($all_batches) { ?>
<?php foreach ($all_batches as $all_batch) { ?>
<tr>
	<td><?php echo $all_batch['batch_id']; ?></td>
	<td><?php echo $all_batch['min_range'].' <i class="fa fa-long-arrow-right"></i> '.$all_batch['max_range']; ?></td>
	<td><?php if ($all_batch['status'] == 0){ ?>
	<a class="btn btn-primary" onclick="generatebatchmap('<?php echo $all_batch['id']; ?>')"><?php echo $btn_generate; ?></a>
   <?php  } else { ?>
		<span style="color:green;"><?php echo $text_batch_generated. ' ('.$all_batch['count'].') '; ?>
		<a onclick="resetproductbatch('<?php echo $all_batch['id']; ?>','status')"> <i class="fa fa-trash"></i> </a>
		</span>
   <?php }  ?></td>
   <td><?php if ($all_batch['astatus'] == 0){ ?>
	<a class="btn btn-primary" onclick="generateaddmap('<?php echo $all_batch['id']; ?>')"><?php echo $btn_generate; ?></a>
   <?php  } else { ?>
		<span style="color:green;"><?php echo $text_batch_generated; ?>
		<a onclick="resetproductbatch('<?php echo $all_batch['id']; ?>','astatus')"> <i class="fa fa-trash"></i> </a>
		</span>
   <?php }  ?></td>
	<td><?php echo $all_batch['date_added']; ?></td>
</tr>
<?php } ?>
<?php } else { ?>
<tr><td colspan="5"><?php echo $text_no_records; ?></td></tr>
<?php } ?>
</tbody>
</table>
<a class="btn btn-warning" onclick="batchestimate()"><?php echo $btn_batch; ?></a> 
<a class="btn btn-danger" onclick="clearbatch()"><?php echo $btn_clear_batch; ?></a>
<a class="btn btn-success" onclick="autogenerate('autogeneratemain')"><i class="fa fa-rocket"></i> RUN ALL : PRODUCT MAIN</a>
<a class="btn btn-success" onclick="autogenerate('autogenerateadditional')"><i class="fa fa-rocket"></i> RUN ALL : PRODUCT ADDITIONAL</a>
<a class="btn btn-success" onclick="autogenerate('autogenerateall')"><i class="fa fa-rocket"></i> RUN ALL</a>

<br /><br /><hr />
<h3>IMAGE FOLDER</h3>

<?php  //path to directory to scan
$directory = $target;
 
//get all files in specified directory
$files = glob($directory . "*");
 
//print each file name
foreach($files as $file)
{
 //check to see if the file is a folder/directory
 if(is_dir($file))
 {
  echo $file.'<br>';
 }
}

?>