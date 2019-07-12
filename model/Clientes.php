<?php
class Clientes extends Dao {
	
	function __construct() {

		$this->setTableName('clientes');
		$this->setInstance('Franqueadora');
		parent::__construct();
		
	}
}
?>