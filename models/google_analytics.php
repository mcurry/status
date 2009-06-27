<?php
class GoogleAnalytics extends StatusAppModel {
	var $useTable = false;
	var $useDbConfig = 'googleAnalytics';

	function __construct() {
		App::import(array('type' => 'File', 'name' => 'Status.STATUS_CONFIG', 'file' => 'config'.DS.'status.php'));
		App::import(array('type' => 'File', 'name' => 'Status.GoogleAnalyticsSource', 'file' => 'models'.DS.'datasources'.DS.'google_analytics_source.php'));
		$config =& new STATUS_CONFIG();
		ConnectionManager::create('googleAnalytics', $config->googleAnalytics);

		parent::__construct();
	}

	function load($type, $options=array()) {
		$method = "__load" . Inflector::camelize($type);

		if (method_exists($this, $method)) {
			return $this-> {$method}($options);
		}

		return false;
	}

	function __loadKeywords($options) {
		$defaults = array('conditions' => array('start-date' => date('Y-m-d', strtotime('-1 day')),
																						'end-date' => date('Y-m-d'),
																						'dimensions' => array('keyword'),
																						'metrics' => array('visits')
																					 ),
											'limit' => 25,
											'order' => array('-visits')
										 );

		$data = parent::find('all', am($defaults, $options));

		$keywords = array();
		foreach($data['Feed']['Entry'] as $entry) {
			if ($entry['Dimension']['value'] == '(not set)') {
				continue;
			}

			$keywords[] = array('keyword' => $entry['Dimension']['value'],
													'visits' => $entry['Metric']['value']);
		}

		return array('updated' => $data['Feed']['updated'],
								 'data' => $keywords);
	}

	function __loadReferrers($options) {
		$defaults = array('conditions' => array('start-date' => date('Y-m-d', strtotime('-1 day')),
																						'end-date' => date('Y-m-d'),
																						'dimensions' => array('source', 'referralPath'),
																						'metrics' => array('visits')
																					 ),
											'limit' => 24,
											'order' => array('-visits')
										 );

		$data = parent::find('all', am($defaults, $options));

		$referrers = array();
		foreach($data['Feed']['Entry'] as $entry) {
			$url = trim($entry['Dimension'][0]['value'], '()');
			$link = true;

			if ($entry['Dimension'][1]['value'] != '(not set)') {
				$url .= $entry['Dimension'][1]['value'];
			} else if ($url == 'direct') {
				$url .= ' (none)';
				$link = false;
			} else {
				$url .= ' (organic)';
				$link = false;
			}

			$referrers[] = array('url' => $url,
													 'link' => $link,
													 'visits' => $entry['Metric']['value']);
		}

		return array('updated' => $data['Feed']['updated'],
								 'data' => $referrers);
	}

	function __loadVisits($options) {
		$defaults = array('conditions' => array('start-date' => date('Y-m-d', strtotime('-1 day')),
																						'end-date' => date('Y-m-d'),
																						'dimensions' => array('day', 'hour'),
																						'metrics' => array('visits')
																					 ),
											'limit' => 48,
											'order' => array('-day', '-hour')
										 );

		$data = parent::find('all', am($defaults, $options));
		if (!is_array($data)) {
			return false;
		}

		$found = false;
		$visits = array();
		$count = 0;
		foreach($data['Feed']['Entry'] as $entry) {
			if (!$found && $entry['Metric']['value'] == 0) {
				continue;
			}

			$count ++;
			$found = true;
			$visits[$entry['Dimension'][1]['value']] = $entry['Metric']['value'];

			if ($count > 24) {
				break;
			}
		}

		return array('updated' => $data['Feed']['updated'],
								 'data' => $visits);
	}
}
?>