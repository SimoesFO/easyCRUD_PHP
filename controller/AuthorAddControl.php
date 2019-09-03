<?php
include_once ("../inc/_autoload.php");

class AuthorAddControl {

	public function addAuthor($request = null, $debug = false) {
		
		try {
			$objAuthor = new AuthorsControl();
			$objAuthor->setName( $request['inputName'] );
			$objAuthor->setBirthday( Help::formatDateTo( $request['inputBirthday'], 'Y-m-d' ) );
			$objAuthor->setCpf( Help::prepareCpfCnpj( $request['inputCPF'], $clear = true ) );
			$objAuthor->setListPhones( $request['hidePhones'] );
			$objAuthor->setListOperator( $request['hideOperator'] );

			//$this->addPhones($objAuthor, $debug);
			Connection::beginTransaction();
				$idAuthor = $objAuthor->save($debug);
			Connection::commit();

			return $objAuthor;
		}
		catch(Exception $e) {
			Connection::rollBack();
			echo $e->getMessage();
		}
	}

	private function addPhones($objAuthor, $debug = false) {

	    try {
	        $arrayPhones = explode(";", mb_substr($this->listPhones, 0, -1));
	        $arrayOperadora = explode(";", mb_substr($this->listOperator, 0, -1));

	        foreach ($arrayPhones as $key => $phone) {

	            // Remover especial characters.
	            $phone = Help::preparePhone($phone, $clear = true, $ddi = false);

				$objAuthorPhone = new AuthorPhonesControl();
	            $objAuthorPhone->setNumber($phone);
	            $objAuthorPhone->setOperator($arrayOperadora[$key]);
				$objAuthor->addPhone($objAuthorPhone);
	        }
	    }
	    catch (Exception $e) {
	        throw new Exception ($e->getMessage());
	    }
	}

	public function loadDataAuthors( $request, $debug = false ) {

		try {

			$objAuthor = new AuthorsControl();
			$objAuthor->setId( $request['id'] );
			$objAuthor->selectId( $debug = false );
			$arrayPhones = $objAuthor->loadPhones( $debug );
			//$op
			foreach ($arrayPhones as $key => $phone) {
				
			}
		}
		catch (Exception $e) {
	        throw new Exception ($e->getMessage());
	    }
	}
}

$name = null;
$birthday = null;
$cpf = null;
$listPhones = null;
$listOperator = null;

if( !isset( $_REQUEST['id'] ) && !empty( $_REQUEST ) ) {
	

	var_dump($_REQUEST); die();
	$obj = new AuthorAddControl();
	$objAuthor = $obj->addAuthor($_REQUEST, $debug = false);
	
	$name = $objAuthor->getName();
	$birthday = $objAuthor->getBirthday();
	$cpf = $objAuthor->getCpf();
	$listPhones = $objAuthor->getListPhones();
	$listOperator = $objAuthor->getListOperator();
	
}
else if( isset( $_REQUEST['id'] ) ) {
	$obj = new AuthorAddControl();
	$obj->loadDataAuthors($_REQUEST, $debug = false);
}

include_once('../view/author_add.php');
?>