<h2>Last Updated: <?php echo $time->timeAgoInWords($updated) ?></h2>
<table>
	<tr>
		<th><?php __('Referrer') ?></th>
		<th><?php __('Visits') ?></th>
	</tr>
	<?php foreach($data as $referrer) { ?>
		<tr>
			<td><?php
				if($referrer['link']) {
					echo $this->Html->link($referrer['url'], 'http://' . $referrer['url'], array('title' => $referrer['url'], 'target' => '_blank'));
				} else {
					echo $referrer['url'];
				}
			?></td>
			<td><?php echo $referrer['visits'] ?></td>
		</tr>
	<?php } ?>
</table>