<?php

class AuthorsControl extends Authors {
	
	function __construct() {
		parent::__construct();		
	}

	public function save( $debug = false ) {

		if( !empty( $this->getId() ) ) {
			// Update
			echo "update";
		}
		else {
			// Insert
			$id = $this->insert( $debug);
			$this->insertPhones( $debug );
			return $id;
		}

	}
}
?>