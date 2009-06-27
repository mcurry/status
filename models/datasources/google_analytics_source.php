<?php
class GoogleAnalyticsSource extends DataSource {

	var $description = 'Google Analytics Data Source';
	var $source = 'CakePHP-GoogleAnalytics-0.1';

	var $connected = false;
	var $token = null;

	var $urls = array('authenticate' => 'https://www.google.com/accounts/ClientLogin',
										'data' => 'https://www.google.com/analytics/feeds/data');

	var $Http = null;
	var $Xml = null;

	function __construct($config) {
		parent::__construct($config);

		App::import('HttpSocket');
		$this->Http = new HttpSocket();

		App::import('Xml');
		$this->Xml = new Xml();

		Cache::config('google_analytics', array(
											'engine' => 'File',
											'duration'=> '+5 minutes',
									));

		if ($token = Cache::read('GoogleAnalytics.token')) {
			$this->token = $token;
		}
	}

	function read(&$model, $queryData = array()) {
		$queryData = $this->__parseData($queryData);
		return $this->__request($queryData);
	}

	function close() {
		if (Configure::read() > 1) {
			//$this->showLog();
		}

		$this->disconnect();
	}

	function disconnect() {
		$this->connected = false;
		return !$this->connected;
	}

	function __request($queryData=array()) {
		$key = 'GoogleAnalytics.' . md5(serialize($queryData));
		if ($data = Cache::read($key, 'google_analytics')) {
			return $data;
		}

		if (!$this->connected && !$this->__connect()) {
			return false;
		}

		$request = array('header' => array('Authorization' => 'GoogleLogin auth=' . $this->token));

		$queryData = am(array('ids' => 'ga:' . $this->config['account_id']), $queryData);
		$response = $this->Http->get($this->urls['data'], $queryData, $request);

		if ($this->Http->response['status']['code'] != 200) {
			var_dump($response);
			return $response;
		}

		$this->Xml->load($response);
		$data = $this->Xml->toArray();

		Cache::write($key, $data, 'google_analytics');

		return $data;
	}

	function __parseData($queryData) {
		$data = array();

		if (!empty($queryData['order'][0])) {
			$order = $queryData['order'][0];
			array_walk($order, array($this, '__googleizeParams'));
			$data['sort'] = implode(',', $order);
		}

		foreach($queryData['conditions'] as $condition => $values) {
			if (!is_array($values)) {
				$values = array($values);
			}

			if (in_array($condition, array('dimensions', 'metrics', 'filters'))) {
				array_walk($values, array($this, '__googleizeParams'));
			}

			$data[$condition] = implode(',', $values);
		}

		if (!empty($queryData['limit'])) {
			$data['max-results'] = $queryData['limit'];
		}

		if (empty($data['start-date'])) {
			$data['start-date'] = date('Y-m-d', strtotime('-0 day'));
		}

		if (empty($data['end-date'])) {
			$data['end-date'] = date('Y-m-d', strtotime('-0 day'));
		}

		if (empty($data['max-results'])) {
			$data['max-results'] = 10;
		}

		if (empty($data['start-index'])) {
			$data['start-index'] = 1;
		}

		return $data;
	}

	function __connect() {
		if (!$this->token) {
			return $this->__authenticate();
		}

		$this->connected = true;
		return true;
	}

	function __authenticate() {
		$data = array('accountType' => 'GOOGLE',
									'service' => 'analytics',
									'source' => $this->source,
									'Email' => $this->config['email'],
									'Passwd' => $this->config['password']
								 );
		$response = $this->Http->post($this->urls['authenticate'], $data);

		if ($this->Http->response['status']['code'] != 200) {
			return false;
		}

		$response = explode("\n", trim($response));

		if (empty($response[2])) {
			return false;
		}

		$this->token = str_replace('Auth=', '', $response[2]);
		Cache::write('GoogleAnalytics.token', $this->token);
		$this->connected = true;
		return true;
	}

	function __googleizeParams(&$param) {
		$neg = false;
		if ($param[0] === '-') {
			$param = substr($param, 1);
			$neg = true;
		}

		$param = 'ga:' . $param;

		if ($neg) {
			$param = '-' . $param;
		}
	}
}

?>