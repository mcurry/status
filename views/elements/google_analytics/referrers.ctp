<h2>Last Updated: <?php echo $time->timeAgoInWords($updated) ?></h2>
<table>
	<tr>
		<th><?php __('Referrer') ?></th>
		<th><?php __('Visits') ?></th>
	</tr>
	<?php foreach($data as $referrer) { ?>
		<tr>
			<td><?php
				$display = $referrer['url'];
				if(strlen($display) > 25) {
					$display = substr($display, 0, 25) . '...';
				}
				
				if($referrer['link']) {
					echo $html->link($display, 'http://' . $referrer['url'], array('title' => $referrer['url'], 'target' => '_blank'));
				} else {
					echo $display;
				}
			?></td>
			<td><?php echo $referrer['visits'] ?></td>
		</tr>
	<?php } ?>
</table>