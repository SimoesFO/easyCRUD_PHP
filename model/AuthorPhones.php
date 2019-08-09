<?php

class AuthorPhones extends Dao  {

	function __construct() {

		$this->setTableName('author_phones');
		parent::__construct();
	}
}
?>