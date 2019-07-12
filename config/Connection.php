<?php
class Connection {
	
	private static $con = array();
	private static $arrayConfig;

	private function __construct() {
	}

	private static function getConfig() {

		$pathRoot = $_SERVER['DOCUMENT_ROOT'].substr($_SERVER['PHP_SELF'],0, strpos($_SERVER['PHP_SELF'],"/",1))."/config/";

		$jsonConfig = file_get_contents($pathRoot.'config.json');
		self::$arrayConfig = json_decode($jsonConfig);
	}


	public static function beginTransaction() {
		foreach (self::$con as $instanceName => $instance) {
			$instance->beginTransaction();
		}
	}


	public static function commit() {
		foreach (self::$con as $instanceName => $instance) {
			$instance->commit();
		}
	}


	public static function rollBack() {

		self::$con = null;
	}


	public static function getInstance($instanceName = null) {
		
		try {

			self::getConfig();

			if(empty(trim($instanceName))) {
				$instance = self::$arrayConfig->connections->default;
				$instanceName = $instance;
			}
			else {
				$instance = $instanceName;	
			}

			if(!isset(self::$con[$instanceName])) {

				$host = self::$arrayConfig->connections->$instance->host;
				$dbname = self::$arrayConfig->connections->$instance->dbname;
				$user = self::$arrayConfig->connections->$instance->user;
				$pws = self::$arrayConfig->connections->$instance->pws;

				self::$con[$instanceName] = new PDO("mysql:host=". $host .";dbname=". $dbname .";charset=utf8", $user, $pws);
			}

			return self::$con[$instanceName];
		}
		catch (Exception $e) {
			return $e->getMessage();
		}
	}
}
?>