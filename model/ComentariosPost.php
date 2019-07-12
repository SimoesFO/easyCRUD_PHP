<?php

class ComentariosPost extends Dao {
	
	function __construct() {

		$this->setTableName('comentarios_post');
		parent::__construct();
		
	}
}

?>