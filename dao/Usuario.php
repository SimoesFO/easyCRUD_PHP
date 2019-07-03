<?php

class Usuario extends Dao  {

	public $con;
	public $teste = 5;

	function __construct() {

		$this->setTableName('usuario');
		$this->con = new Connection();
		parent::__construct();
		
	}


	
}
?>