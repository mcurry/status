<?php
	$tests = $this->requestAction(array('plugin' => 'status', 'controller' => 'panels', 'action' => 'tests'));
?>

<div>
	<h1><?php __('Unit Tests') ?></h1>
	<?php
		if(empty($tests['cases'])) {
			__('No test cases found.');	
		} else {
			echo '<h2>'; __('Test Cases'); echo '</h2>';
			echo '<ul>';
			foreach($tests['cases'] as $case) {
				echo '<li>' . $this->Html->link($case, array('controller' => 'status', 'action' => 'tests_run', '?' => array('case' => $case)), array('class' => 'status-tests-case')) . '</li>';
			}
			echo '</ul>';
		}
	?>
	
	<div id="status-tests-results"></div>
	<div id="status-tests-running"><?php echo $this->Html->image('/status/img/ajax-loader.gif') ?></div>
	
	<script type="text/javascript">
		$(function(){
			$("#status-tests-running").hide();
			
			$(".status-tests-case").click(function() {
				$("#status-tests-running").show();
				$.get($(this).attr("href"), function(result) {
					$("#status-tests-results").append(result);
					$("#status-tests-running").hide();
				});
				
				return false;
			});
			
			$(".status-tests-results").live("click", function() {
				var id = "#overlay-" + $(this).attr("id");
				$(id).dialog("open");
			});
		});
	</script>
</div>