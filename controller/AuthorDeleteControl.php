<?php
include_once ("../inc/_autoload.php");

class AuthorDeleteControl {

	public function deleteAuthors( $request = null, $debug = false ) {
		
		try {
			echo "teste";
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

//include_once('../view/author_list.php');
?>