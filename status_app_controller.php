<?php
class StatusAppController extends AppController {
	function beforeFilter() {
		parent::beforeFilter();
		
		if(!Configure::read('Status.allow')) {
			return $this->redirect($this->referer());
		}
	}
}
?>