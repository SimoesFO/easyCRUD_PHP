<?php

class PostsUsuarios extends Dao  {

	//public $con;

	function __construct() {

		$this->setTableName('posts_usuarios');
		//$this->con = new Connection();
		//$this->con->setInstanceName('Franqueadora');
		parent::__construct();
	}


	
}
?>