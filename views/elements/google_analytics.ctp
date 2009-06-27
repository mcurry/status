<?php
	$key = sprintf('status-google-analytics-%s', preg_replace("/[^a-zA-Z0-9]/", '', $options));
?>
<h1><?php echo ucfirst($options) ?></h1>
<div id="<?php echo $key ?>">
	<?php echo $html->image('/status/img/ajax-loader.gif') ?>
</div>


<script type="text/javascript">
	$(function(){
		$.get("/status/google_analytics/<?php echo $options ?>", function(data) {
			$("#<?php echo $key ?>").html(data);
		});
	});
</script>