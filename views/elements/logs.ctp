<?php
	$data = $this->requestAction(array('plugin' => 'status', 'controller' => 'panels', 'action' => 'logs', 'log' => $options));

	$key = sprintf('status-logs-%s-detail', preg_replace("/[^a-zA-Z0-9]/", '', $options));
?>

<h1><?php echo $options . ' ' . __(' Log', true) ?></h1>
<table>
	<tr>
		<th><?php __('When') ?></th>
		<th><?php __('Entry') ?></th>
	</tr>
	<?php if(!empty($data)) { ?>
		<?php foreach($data as $i => $row) { ?>
			<tr class="status-detail" id="<?php echo $key ?>-<?php echo $i ?>">
				<td><?php echo $time->timeAgoInWords($row['time']) ?></td>
				<td><?php
					if(strlen($row['entry']) > 50) {
						echo h(substr($row['entry'], 0, 50)) . '...';
					} else {
						echo h($row['entry']);
					}
				?>
				<div title="<?php echo $options . ' ' . $row['time'] ?>" class="overlay-<?php echo $key ?>" id="overlay-<?php echo $key ?>-<?php echo $i ?>">
					<?php echo nl2br(h($row['entry'])); ?>
				</div>	
				</td>
			</tr>
		<?php } ?>
	<?php } ?>
</table>

<script type="text/javascript">
	$(function() {
		$(".overlay-<?php echo $key ?>").dialog({autoOpen: false, modal: true, width: "600px"});
		$(".status-detail").click(function() {
			var id = "#overlay-" + $(this).attr("id");
			$(id).dialog("open");
		});
	});
</script>