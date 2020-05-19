<link rel="stylesheet" type="text/css" href="view/stylesheet/stylesheet.css" />
<div class="container-fluid">
<div class="table-responsive">
<table class="table table-bordered table-hover">
<thead>
	<tr>
    	<td class="text-left"><?php echo $column_referrer; ?></td>
		<td class="text-left"><?php echo $column_useragent; ?></td>
        <td class="text-right"><?php echo $column_datetime; ?></td>
    </tr>
</thead>
<tbody>
    <?php if ($referrers) {
    foreach ($referrers as $referrer){
    	$referrer_url = (!empty($referrer['referrer']))? urldecode($referrer['referrer']) : ' - ';
    	echo '<tr><td class="text-left">'.$referrer_url.'</td>';
		echo '<td class="text-left">'.$referrer['user_agent'].'</td>';
        echo '<td class="text-right">'.$referrer['datetime'].'</td></tr>';
    }
    }else { ?>
    		<tr>
              <td class="text-center" colspan="3"><?php echo $text_no_results; ?></td>
            </tr> 
    <?php } ?>
</tbody>    

</table>
</div>
</div>
</div>