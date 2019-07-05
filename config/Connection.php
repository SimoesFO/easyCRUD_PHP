<?php
class Connection {
	
	private $con;
	private $instanceName;

	function __construct($con = null) {

		$this->con = $con;
		$this->getInstance();
	}

	public function setInstanceName($instanceName) {

		$this->con = null;
		$this->instanceName = $instanceName;
	}

	public function getInstanceName() {

		return $this->instanceName;
	}

	public function getInstance() {
		
		try {
			if(!isset($this->con)) {
				
				$pathRoot = $_SERVER['DOCUMENT_ROOT'].substr($_SERVER['PHP_SELF'],0, strpos($_SERVER['PHP_SELF'],"/",1))."/config/";

				$jsonConfig = file_get_contents($pathRoot.'config.json');
				$arrayConfig = json_decode($jsonConfig);

				if(empty(trim($this->instanceName))) {
					$instance = $arrayConfig->connections->default;
				}
				else {
					$instance = $this->instanceName;	
				}
				
				$host = $arrayConfig->connections->$instance->host;
				$dbname = $arrayConfig->connections->$instance->dbname;
				$user = $arrayConfig->connections->$instance->user;
				$pws = $arrayConfig->connections->$instance->pws;

				$this->con = new PDO("mysql:host=". $host .";dbname=". $dbname .";charset=utf8", $user, $pws);
			}

			return $this->con;
		}
		catch (PDOException $e) {
			return $e->getMessage();
		}
	}
}
?>