<div id="status-dashboard">
	<?php
		foreach($panels as $panel) {
			$options = array('options' => $panel['options']);
			if(!empty($panel['plugin'])) {
				$options['plugin'] = Inflector::underscore($panel['plugin']);
			}
			
			echo '<div id="' . $panel['plugin'] . Inflector::classify($panel['element']) . 'Block" class="block">'
				. $this->element($panel['element'], $options)
				. '</div>';
		}
	?>
</div>

<script type="text/javascript">
	$(function(){
		$("#status-dashboard").arrange();
		
		$("#status-dashboard").ajaxComplete(function(event, request, settings){
			 $("#status-dashboard").arrange();
		 });

	});
</script>