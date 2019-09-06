<?php
class Connection {
	
	private static $con = array();
	private static $arrayConfig;
	private static $isTransaction = false;

	private function __construct() {
	}
	

	/************************************************************
	 * Description: Get all configuration from file config.json.
	 ************************************************************/
	private static function getConfig() {

		$pathRoot = $_SERVER['DOCUMENT_ROOT'].substr($_SERVER['PHP_SELF'],0, strpos($_SERVER['PHP_SELF'],"/",1))."/config/";

		$jsonConfig = file_get_contents($pathRoot.'config.json');
		self::$arrayConfig = json_decode($jsonConfig);
	}


	/************************************************************
	 * Description: Begin Transaction Control.
	 ************************************************************/
	public static function beginTransaction() {
		
		self::$isTransaction = true;
		foreach (self::$con as $instanceName => $instance) {
			$instance->beginTransaction();
		}
	}


	/************************************************************
	 * Description: Commit Transaction Control.
	 ************************************************************/
	public static function commit() {
		foreach (self::$con as $instanceName => $instance) {
			$instance->commit();
		}
	}


	/************************************************************
	 * Description: RollBack Transaction Control.
	 ************************************************************/
	public static function rollBack() {

		foreach (self::$con as $instanceName => $instance) {
			$instance->rollBack();
		}
	}


	/************************************************************
	 * Description: Get or Create a Instance Connection.
	 ************************************************************/
	public static function getInstance($instanceName = null) {
		
		try {
			self::getConfig();

			// Checks whether a name has been sent the instance name.
			if(empty(trim($instanceName))) {
				// If not, create default instance
				$instance = self::$arrayConfig->connections->default;
				$instanceName = $instance;
			}
			else {
				// Create instance with a name.
				$instance = $instanceName;	
			}

			// Check if doesn't exist a instance with this name.
			if(!isset(self::$con[$instanceName])) {

				$host = self::$arrayConfig->connections->$instance->host;
				$dbname = self::$arrayConfig->connections->$instance->dbname;
				$user = self::$arrayConfig->connections->$instance->user;
				$pws = self::$arrayConfig->connections->$instance->pws;

				// Create Instance Connection
				self::$con[$instanceName] = new PDO("mysql:host=". $host .";dbname=". $dbname .";charset=utf8", $user, $pws);

				if(self::$isTransaction) {
					self::$con[$instanceName]->beginTransaction();
				}
			}



			return self::$con[$instanceName];
		}
		catch (Exception $e) {
			return $e->getMessage();
		}
	}
}
?>