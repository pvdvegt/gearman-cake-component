<?
class GearmanComponent extends Object {

  private $servers;
	private $gmc;
	
	
	/**
	 * Component startup
	 * 
	 * @access public
	 * @param object reference $controller The calling controller
	 */
	function startup(&$controller) {
		Configure::load('gearman');
		
		$this->servers = Configure::read('gearman.servers');
		$this->gmc = $this->__registerServers();
	} // end startup()
	
	
	/**
	 * Used to validate that an API call is legit. HMAC is used for private key crypto
	 *
	 * @access public
	 * @return boolean
	 */
	function validateApiCall($accessKey, $hash, $data) {
		$keys = Configure::read('gearman.valid_keys');
		$secret = '';
		foreach ($keys as $pair) {
			if ($pair['access'] == $accessKey) {
				$secret = $pair['secret'];
			}
		}
		
		if (empty($secret)) {
			return false;
		}
		
		$res = hash_hmac('sha256', $data, $secret);
		return $res == $hash;
	} // end validateApiCall()
	
	/**
	 * Add a (background) task to gearman server
	 * file.
	 * 
	 * @access public
	 * @return string $handle - a gearman job handle
	 */
	
	public function addTask($task,$job){
		
		return $this->gmc->addTaskBackground($task, serialize($job));
		
	} // end addTask()
	
	/**
	 * Used to register with a number of gearman servers stored in config 
	 * file.
	 * 
	 * @access private
	 * @return object $gmc - a gearman client object
	 */
	private function __registerServers() {
		
		$servers = explode(',', $this->servers);
		
		foreach ($servers as $i => $server) {
			$server = trim($server);
			$server = explode(':', $server);
			if ($server[0] == 'localhost') {
				$gmc->addServer();
			} else {
				$gmc->addServer($server[0], $server[1]);
			}
		}
		
		return $gmc;
	} // end __registerServers()
	
} // end class GearmanComponent

?>
