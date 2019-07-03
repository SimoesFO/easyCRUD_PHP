<?php

class Connection {
	
	private $con;

	function __construct($con = null) {

		$this->con = $con;
		$this->getInstance();
	}

	public function getInstance() {
		
		try {
			if(!isset($this->con)) {

				$this->con = new PDO('mysql:host=localhost;dbname=projeto;charset=utf8', 'root', '');
			}

			return $this->con;
		}
		catch (PDOException $e) {
			return $e->getMessage();
		}
	}



}
?>