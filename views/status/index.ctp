<?php
	foreach($panels as $panel) {
		//echo '<div id=' . $plugin['name'] . 'Block></div>';
		$options = array('plugin' => Inflector::underscore($panel['plugin']),
										 'options' => $panel['options']);

		echo '<div id="' . $panel['plugin'] . Inflector::classify($panel['element']) . 'Block" class="block">'
			. $this->element($panel['element'], $options)
			. '</div>';
	}
?>