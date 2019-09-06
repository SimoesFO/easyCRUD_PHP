<?php

class AuthorsControl extends Authors {
	
	function __construct() {
		parent::__construct();		
	}

	/************************************************************
	 * Description: Insert or Update the Author.
	 ************************************************************/
	public function save( $debug = false ) {

		try {
			if( !empty( trim( $this->getId() ) ) ) {
				// Update
				$this->update( $debug );
				$this->deletePhones( $debug );
				$this->insertPhones( $debug );
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


	/************************************************************
	 * Description: Delete author from database.
	 ************************************************************/
	public function delete( $debug = false ) {

		try {
			$this->deletePhones( $debug ); // Delete all phones from an author.
			parent::delete( $debug ); // Delete author.
		}
		catch ( Exception $e ) {
			throw new Exception ( $e->getMessage() );
		}
	}
}
?>