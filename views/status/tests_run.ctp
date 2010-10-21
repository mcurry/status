<h2>Test <?php echo $case ?></h2>
<?php
	$key = 'status-tests-results-' . time();
?>

<p class="status-detail status-tests-results" id="<?php echo $key ?>"><?php echo $summary ?></p>
<?php if($results) { ?>
	<div id="overlay-<?php echo $key ?>"><?php echo implode('<br />', $results) ?></div>
<?php } ?>

<script type="text/javascript">
	$(function(){
		$("#overlay-<?php echo $key ?>").dialog({autoOpen: false, modal: true, width: "600px"});
	});
</script>