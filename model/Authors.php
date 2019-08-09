<?php

class Authors extends Dao  {

	protected $arrayAuthorPhones = null;

	function __construct() {

		$this->setTableName('authors');
		parent::__construct();
	}

	public function addPhone(AuthorPhones $phone) {
		$arrayAuthorPhones[] = $phone;
	}
}
?>