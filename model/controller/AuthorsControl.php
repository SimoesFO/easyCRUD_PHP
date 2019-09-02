<?php

class AuthorsControl extends Authors {
	
	function __construct() {
		parent::__construct();		
	}

	public function save( $debug = false ) {

		try {
			if( !empty( $this->getId() ) ) {
				// Update
				echo "update";
			}
			else {
				// Insert
				$id = $this->insert( $debug );
				$this->insertPhones( $debug );
				return $id;
			}
		}
		catch ( Exception $e ) {
			throw new Exception ( $e->getMessage() );
		}
	}

	public function delete( $debug = false ) {

		try {
			$this->deletePhones( $debug );
			parent::delete( $debug );
		}
		catch ( Exception $e ) {
			throw new Exception ( $e->getMessage() );
		}
	}
}
?>