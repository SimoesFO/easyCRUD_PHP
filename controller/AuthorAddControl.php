<?php
include_once ("../inc/_autoload.php");

class AuthorAddControl {

	/************************************************************
	 * Description: Save a new author in database.
	 ************************************************************/
	public function addAuthor($request = null, $debug = false) {
		
		try {
			// Create object author.
			$objAuthor = new AuthorsControl();
			$objAuthor->setId( $request['idAuthor'] );
			$objAuthor->setName( $request['inputName'] );
			$objAuthor->setBirthday( Help::formatDateTo( $request['inputBirthday'], 'Y-m-d' ) );
			$objAuthor->setCpf( Help::prepareCpfCnpj( $request['inputCPF'], $clear = true ) );
			
			// Add phones in object author.
			$arrayAuthorPhones = $this->addPhones( $request, $debug );
			$objAuthor->setPhones( $arrayAuthorPhones );

			// Begin Transaction Controller.
			Connection::beginTransaction();
				// Save Author and Phones from an author.
				$idAuthor = $objAuthor->save($debug);
			Connection::commit();

			// Redirect to Main Page.
			header("Location: AuthorListControl.php");
			die();
		}
		catch(Exception $e) {
			// If something went wrong, undoes database transaction.
			Connection::rollBack();
			echo $e->getMessage();
		}
	}


	/************************************************************
	 * Description: Create an array from Author Phones, with phones
	 * send by user.
	 ************************************************************/
	private function addPhones($request, $debug = false) {

	    try {

			$arrayAuthorPhones = array(); // Store all phones from an author.
			$arrayPhones = $request['field-phone'];
			$arrayOperator = $request['field-operator'];
			
			// Iterate through all phone sent by the user.
	        foreach ($arrayPhones as $key => $phone) {

	            // Remover especial characters.
	            $phone = Help::preparePhone($phone, $clear = true, $ddi = false);

				// Create one array with author phones.
				$objAuthorPhone = new AuthorPhonesControl();
	            $objAuthorPhone->setNumber($phone);
	            $objAuthorPhone->setOperator($arrayOperator[$key]);
				$arrayAuthorPhones[] = $objAuthorPhone;
			}
			
			// Return all phones from an author.
			return $arrayAuthorPhones;
	    }
	    catch (ExceptiosetPhonesn $e) {
	        throw new Exception ($e->getMessage());
	    }
	}

	/************************************************************
	 * Description: Loads all information from an author.
	 ************************************************************/
	public function loadDataAuthors( $request, $debug = false ) {

		try {
			// Load Author.
			$objAuthor = new AuthorsControl();
			$objAuthor->setId( $request['id'] );
			$objAuthor->selectId( $debug = false );
			// Load Phones from an author.
			$arrayPhones = $objAuthor->loadPhones( $debug );
			
			// Generates rows the tables phones.
			$htmlPhone = "";
			if( $arrayPhones ) {

				// Load row by row, to each phone.
				foreach ($arrayPhones as $key => $phone) {
					$htmlPhone .= $this->templatePhone( $phone->getNumber(), $phone->getOperator() );
				}
			}

			// Save html phones in object author.
			$objAuthor->setHtmlPhone($htmlPhone);
			
			return $objAuthor;
		}
		catch ( Exception $e ) {
	        throw new Exception ( $e->getMessage() );
	    }
	}

	/************************************************************
	 * Description: Returns the template responsible form showing
	 * the phone and the operator.
	 ************************************************************/
	public function templatePhone( $phone = ":phone", $operator = ":operator" ) {

		$html = "
		<tr>
			<td class='col-6'>
				<input type='text' class='form-control' name='field-phone[]' data-mask='(00) 00000-0000' placeholder='(00) 00000-0000' readonly value='$phone' >
			</td>
			<td class='col-3'>
				<select class='form-control' name='field-operator[]' readonly>
					<option value='$operator' selected>$operator</option>
				</select>
			</td>
			<td class='col-1' align='center' style='vertical-align: middle;'>
				<a href='javascript:void(0)' class='delete-phone'><img src='../resources/img/icons/trashcan.svg' width='15px' id='icon-delete-phone' title='Delete Phone'></a>
			</td>
		</tr>";
		
		// Remove break-lines and tabs.
		return preg_replace( "/\r|\n|\t/", "", $html );
	}
}

$id = null;
$name = null;
$birthday = null;
$cpf = null;
$htmlPhones = null;

$obj = new AuthorAddControl();

// Load template phone view.
$templatePhone = $obj->templatePhone();

if( !empty( $_REQUEST ) && empty( $_REQUEST['id'] ) ) {
	// Add new Author.

	$objAuthor = $obj->addAuthor($_REQUEST, $debug = false);
}
else if( !empty( $_REQUEST['id'] ) ) {
	// Update Information from an Author.

	// Loading all information.
	$objAuthor = $obj->loadDataAuthors($_REQUEST, $debug = false);

	// Set new Data to view.
	$id = $_REQUEST['id'];
	$name = $objAuthor->getName();
	$birthday = Help::formatDateTo( $objAuthor->getBirthday() );
	$cpf = $objAuthor->getCpf();
	$htmlPhones = $objAuthor->getHtmlPhone();
}

include_once('../view/author_add.php');
?>