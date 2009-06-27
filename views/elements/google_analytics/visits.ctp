<h2>Last Updated: <?php echo $time->timeAgoInWords($updated) ?></h2>
<table>
	<tr>
		<th><?php __('When') ?></th>
		<th><?php __('Visits') ?></th>
	</tr>
	<?php foreach($data as $hour => $count) { ?>
		<tr>
			<td><?php
				$unit = 'am';
				if($hour >= 12) {
					$unit = 'pm';
				}
				
				if($hour > 12) {
					$hour -= 12;
				} else if($hour == 0) {
					$hour = 12;
				}
				
				echo ltrim($hour, '0') . ':00' . $unit;
			?></td>
			<td><?php echo $count ?></td>
		</tr>
	<?php } ?>
</table>