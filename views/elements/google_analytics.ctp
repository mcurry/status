<?php
	$key = sprintf('status-google-analytics-%s', preg_replace("/[^a-zA-Z0-9]/", '', $options));
?>
<?php echo $form->create('GoogleAnalytics', array('id' => $key . '-form')); ?>
<h1>
	<?php echo ucfirst($options) ?>
	(last
	<?php
		echo $form->input($key . '-span', array('type' => 'select', 'options' => array('1' => 'day', '7' => 'week', '30' => 'month', '365' => 'year'),
																		'div' => false, 'label' => false, 'id' => $key . '-span'));
	?>)
</h1>
<?php echo $form->end(); ?>

<div id="<?php echo $key ?>">
	<?php echo $this->Html->image('/status/img/ajax-loader.gif') ?>
</div>


<script type="text/javascript">
	$(function(){
		$.get("/status/panels/google_analytics/<?php echo $options ?>/" + $("#<?php echo $key ?>-span").val(), function(data) {
			$("#<?php echo $key ?>").html(data);
		});
		
		$("#<?php echo $key ?>-span").change(function() {
			$("#<?php echo $key ?>").html("<img src=\"/status/img/ajax-loader.gif\" \>");
			$.get("/status/panels/google_analytics/<?php echo $options ?>/" + $(this).val(), function(data) {
				$("#<?php echo $key ?>").html(data);
			});
		});
	});
</script>