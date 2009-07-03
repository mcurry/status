<?php
class StatusController extends StatusAppController {
	var $name = 'Status';
	var $uses = array();
	var $helpers = array('Javascript', 'Time');
	var $components = array('RequestHandler');

	function index() {
		$panels = array();
		foreach(Configure::read('Status.panels') as $panel => $options) {

			if (is_numeric($panel)) {
				$panel = $options;
				$options = array();
			}

			if (empty($options) || !Set::numeric(array_keys($options))) {
				$options = array($options);
			}


			if (strpos($panel, '.') !== false) {
				list($plugin, $panel) = explode('.', $panel);
			} else {
				$plugin = 'Status';
			}

			foreach($options as $option) {
				$panels[] = array('plugin' => $plugin,
													'element' => $panel,
													'options' => $option);
			}
		}

		$this->set('panels', $panels);
	}

	function system() {
		$free = disk_free_space("/");
		$total = disk_total_space("/");
		$perc = round(($free / $total * 100), 2);
		$disk = array('free' => $this->__diskHumanize($free),
									'total' => $this->__diskHumanize($total),
									'perc' => $perc);

		$uptime = exec('uptime');

		return compact('disk', 'uptime');
	}

	function shell() {
		$this->loadModel('Status.StatusConsole');
		$this->paginate = array('order' => array('StatusConsole.created' => 'DESC'),
														'limit' => 10);
		return $this->paginate('StatusConsole');
	}

	function logs() {
		$logfile = $this->params['log'];
		if (strpos($logfile, '.') === false) {
			$logfile .= '.log';
		}

		$filename = LOGS . $logfile;
		if (!file_exists($filename)) {
			return;
		}

		return $this->_parseFile($filename);
	}

	function google_analytics($type) {
		$this->loadModel('Status.GoogleAnalytics');

		$data = $this->GoogleAnalytics->load($type);
		$this->set(compact('type', 'data'));
	}

	function _parseFile($filename) {
		$file =& new File($filename);
		$contents = $file->read();
		$timePattern = '/(\d{4}-\d{2}\-\d{2}\s\d{1,2}\:\d{1,2}\:\d{1,2})/';
		$chunks = preg_split($timePattern, $contents, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);

		$chunks = array_values(array_slice($chunks, -20));

		$return = array();
		$time = null;
		foreach($chunks as $i => $chunk) {
			if ($i % 2 == 0) {
				$time = $chunk;
			} else {
				$return[] = array('time' => $time,
													'entry' => $chunk);
			}
		}

		return array_reverse($return);
	}

	function __diskHumanize($size) {
		$filesizename = array(" Bytes", " KB", " MB", " GB", " TB", " PB", " EB", " ZB", " YB");
		return $size ? round($size/pow(1024, ($i = floor(log($size, 1024)))), 2) . $filesizename[$i] : '0 Bytes';
	}
}