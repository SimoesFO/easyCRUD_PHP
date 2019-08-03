<?php

class PostsUsuarios extends Dao  {

	function __construct() {

		$this->setTableName('posts_usuarios');
		parent::__construct();
	}
}
?>