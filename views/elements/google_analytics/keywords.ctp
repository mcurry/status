<h2>Last Updated: <?php echo $time->timeAgoInWords($updated) ?></h2>
<table>
	<tr>
		<th><?php __('Keyword') ?></th>
		<th><?php __('Visits') ?></th>
	</tr>
	<?php foreach($data as $keyword) { ?>
		<tr>
			<td><?php
				$display = $keyword['keyword'];
				if(strlen($display) > 25) {
					$display = substr($display, 0, 25) . '...';
					echo '<abbr title="' . $keyword['keyword'] . '">' . $display . '</abbr>';
				} else {
					echo $display;
				}
			?></td>
			<td><?php echo $keyword['visits'] ?></td>
		</tr>
	<?php } ?>
</table>