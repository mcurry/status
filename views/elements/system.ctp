<?php
	$data = $this->requestAction(array('controller' => 'status', 'action' => 'system'));
?>

<h1><?php __('System Info') ?></h1>
<?php if(!empty($data['uptime'])) { ?>
	<h2>Uptime</h2>
<?php } ?>

<div>
	<h2>Disk Space</h2>
	<p>
	<?php echo String::insert(':free free of :total (:perc%)',  $data['disk']); ?>
	</p>
</div>