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
 
class LogTask extends Shell {
	var $uses = array('StatusConsole.StatusConsole');

	var $startTime = 0;
	var $status = false;
	var $ended = false;
	var $output = '';

	function start() {
		$this->startTime = microtime(true);
		
		$data = array('shell' => $this->Dispatch->shell,
									'args' => serialize($this->Dispatch->args),
									'params' => serialize($this->Dispatch->params),
									'success' => false);
		$this->StatusConsole->save($data);
	}

	function out($message) {
		$this->output .= $message . "\n";
	}

	function __destruct() {
		if (!$this->ended && $this->StatusConsole->id) {
			$this->end(false);
		}
	}

	function end($success=true) {
		$data = array('success' => $success,
									'output' => trim($this->output),
									'runtime' => round((microtime(true) - $this->startTime) * 1000));
		$this->StatusConsole->save($data);
		$this->ended = true;
	}
}
?>