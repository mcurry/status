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
 
class StatusAppController extends AppController {
	function beforeRender() {
		parent::beforeRender();
		
		if(!Configure::read('Status.allow')) {
			return $this->redirect($this->referer());
		}
	}
}
?>