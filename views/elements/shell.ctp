<?php
	$data = $this->requestAction(array('controller' => 'status', 'action' => 'shell'));
?>

<h1><?php __('Shells') ?></h1>
<table>
	<tr>
		<th><?php __('When') ?></th>
		<th><?php __('Shell') ?></th>
		<th><?php __('Runtime') ?></th>
	</tr>
<?php
	foreach($data as $row) {
		$class = ife($row['StatusConsole']['success'], 'success', 'error');
?>
	<tr class="<?php echo $class?> status-detail" id="status-console-detail-<?php echo $row['StatusConsole']['id'] ?>">
		<td><?php echo $time->timeAgoInWords($row['StatusConsole']['created']) ?></td>
		<td>
			<span><?php echo $row['StatusConsole']['shell'] ?></span>
			<div title="<?php echo $row['StatusConsole']['shell'] ?>" class="overlay-status-console-detail" id="overlay-status-console-detail-<?php echo $row['StatusConsole']['id'] ?>">
				<table>
					<tr><td><?php __('Shell') ?></td><td><?php echo $row['StatusConsole']['shell'] ?></td></tr>
					<tr><td><?php __('Args') ?></td><td><?php echo implode('<br />', unserialize($row['StatusConsole']['args'])) ?></td></tr>	
					<tr><td><?php __('Params') ?></td><td><?php
						foreach(unserialize($row['StatusConsole']['params']) as $key => $val) {
							echo '<p><strong>' . $key . '</strong> ' . $val . '</p>';
						}
					?></td></tr>
					<tr><td><?php __('Output') ?></td><td><?php echo nl2br($row['StatusConsole']['output']) ?></td></tr>
					<tr><td><?php __('Started') ?></td><td><?php echo $row['StatusConsole']['created'] ?></td></tr>
					<tr><td><?php __('Runtime') ?></td><td><?php echo $row['StatusConsole']['runtime'] ?></td></tr>
				</table>
			</div>
		</td>
		<td><?php echo $row['StatusConsole']['runtime'] ?></td>
	</tr>
<?php } ?>
</table>

<script type="text/javascript">
	$(function() {
		$(".overlay-status-console-detail").dialog({autoOpen: false, modal: true, width: "600px"});
		$(".status-detail").click(function() {
			var id = "#overlay-" + $(this).attr("id");
			$(id).dialog("open");
		});
	});
</script>