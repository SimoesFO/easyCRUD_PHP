<?php
include_once ("../inc/_autoload.php");

class AuthorDeleteControl {

	/************************************************************
	 * Description: Delete author from database, with id equals 
	 * $request['id']
	 ************************************************************/
	public function deleteAuthors( $request = null, $debug = false ) {
		
		try {
			$objAuthor = new AuthorsControl();
			$objAuthor->setId( $request['id'] );
			$objAuthor->delete( $debug );
			header("Location: AuthorListControl.php");
			die();
		}
		catch(Exception $e) {
			echo $e->getMessage();
		}
	}
}

if( isset( $_REQUEST['id'] ) ) {
	$obj = new AuthorDeleteControl();
	$obj->deleteAuthors( $_REQUEST, $debug = false );
}
?>