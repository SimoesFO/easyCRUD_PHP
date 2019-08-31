<?php

class Authors extends Dao  {

	protected $arrayAuthorPhones = null;

	function __construct() {
		
		$this->setTableName('authors');
		parent::__construct();
	}

	public function addPhone(AuthorPhones $phone) {
		$this->arrayAuthorPhones[] = $phone;
	}

	public function getPhones() {
		return $this->arrayAuthorPhones;
	}

	public function insertPhones( $debug = false ) {

		try {
			
			foreach ( $this->arrayAuthorPhones as $phone ) {
				$phone->setAuthorsId( $this->getId() );
				$phone->insert( $debug );
			}

			return true;
		}
		catch ( Exception $e ) {
			throw new Exception ( $e->getMessage() );
		}
	}


	public function loadPhones( $debug = false ) {

		try {

			// SQL
			$query = "SELECT * FROM author_phones WHERE authors_id = :idAuthor";
			
			// PARAMS
			$arrayParams = array(':idAuthor' => $this->getId());

			// EXECUTE
			$stmt = $this->executeQuery($query, $arrayParams, $debug);

			// CHECK IF RETURNED RESULT
			if($stmt) {

				// IF NUMBER OF REGISTER BIGGER THAN ZERO, CREATE ARRAY OF OBJECTS.
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

					$obj = new AuthorPhones();
					$obj->setRow($row);
					$this->addPhone($obj);
				}

				return $this->getPhones();
			}
			else {

				return false;
			}
		}
		catch (Exception $e) {
			throw new Exception ($e->getMessage());
		}
	}
}
?>