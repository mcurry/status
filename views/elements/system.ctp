<?php
	$data = $this->requestAction(array('plugin' => 'status', 'controller' => 'panels', 'action' => 'system'));
?>

<h1><?php __('System Info') ?></h1>
<?php if(!empty($data['uptime'])) { ?>
  <div>
	  <h2>Uptime</h2>
	  <p><?php echo $data['uptime'] ?></p>
	</div>
<?php } ?>

<div>
	<h2>Disk Space</h2>
	<p>
	<?php 
	  if($data['disk'] === false) {
	    __('Unable to read disk free space.  Probably an open_basedir restriction');
	  } else {
	    echo String::insert(':free free of :total (:perc%)',  $data['disk']);
	  }
	?>
	</p>
</div>