<?php

class Usuario extends Dao  {

	public $con;

	function __construct() {

		$this->setTableName('usuario');
		$this->con = new Connection();
		//$this->con->setInstanceName('Franqueadora');
		parent::__construct();
		
	}


	
}
?>