<?php
class StatusConsole extends StatusAppModel {
	var $name = 'StatusConsole';
	var $order = 'started DESC';
	
	function afterFind($results) {
		foreach($results as $i => $result) {
			if(!empty($result['StatusConsole']['runtime'])) {
				$results[$i]['StatusConsole']['runtime'] = $this->__timeHumanize($result['StatusConsole']['runtime']);
			}
		}
		
		return $results;
	}
	
	function __timeHumanize($time) {
		if($time > 1000) {
			return round($time / 1000, 1) . 's';
		}
		
		return $time . 'ms';
	}
}
?>