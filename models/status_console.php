<?php
/*
 * App Status Planel CakePHP Plugin
 * Copyright (c) 2009 Matt Curry
 * www.PseudoCoder.com
 * http://github.com/mcurry/status
 *
 * @author      Matt Curry <matt@pseudocoder.com>
 * @license     MIT
 *
 */
 
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