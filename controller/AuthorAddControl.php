<?php
include_once ("../inc/_autoload.php");

class AuthorAddControl {

	public function addAuthor($request = null, $debug = false) {
		
		try {
			$objAuthor = new AuthorsControl();
			$objAuthor->setId( $request['idAuthor'] );
			$objAuthor->setName( $request['inputName'] );
			$objAuthor->setBirthday( Help::formatDateTo( $request['inputBirthday'], 'Y-m-d' ) );
			$objAuthor->setCpf( Help::prepareCpfCnpj( $request['inputCPF'], $clear = true ) );
			
			$arrayAuthorPhones = $this->addPhones( $request, $debug );
			$objAuthor->setPhones( $arrayAuthorPhones );

			Connection::beginTransaction();
				$idAuthor = $objAuthor->save($debug);
			Connection::commit();

			header("Location: AuthorListControl.php");
			die();
		}
		catch(Exception $e) {
			Connection::rollBack();
			echo $e->getMessage();
		}
	}

	private function addPhones($request, $debug = false) {

	    try {

			$arrayAuthorPhones = array();
			$arrayPhones = $request['field-phone'];
			$arrayOperator = $request['field-operator'];
	        foreach ($arrayPhones as $key => $phone) {

	            // Remover especial characters.
	            $phone = Help::preparePhone($phone, $clear = true, $ddi = false);

				$objAuthorPhone = new AuthorPhonesControl();
	            $objAuthorPhone->setNumber($phone);
	            $objAuthorPhone->setOperator($arrayOperator[$key]);
				$arrayAuthorPhones[] = $objAuthorPhone;
			}
			
			return $arrayAuthorPhones;
	    }
	    catch (ExceptiosetPhonesn $e) {
	        throw new Exception ($e->getMessage());
	    }
	}

	public function loadDataAuthors( $request, $debug = false ) {

		try {

			$objAuthor = new AuthorsControl();
			$objAuthor->setId( $request['id'] );
			$objAuthor->selectId( $debug = false );
			$arrayPhones = $objAuthor->loadPhones( $debug );
			
			$htmlPhone = "";
			if( $arrayPhones ) {

				foreach ($arrayPhones as $key => $phone) {
					$htmlPhone .= $this->templatePhone( $phone->getNumber(), $phone->getOperator() );
				}
			}

			$objAuthor->setHtmlPhone($htmlPhone);
			
			return $objAuthor;
		}
		catch ( Exception $e ) {
	        throw new Exception ( $e->getMessage() );
	    }
	}

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
		
		return preg_replace( "/\r|\n|\t/", "", $html );
	}
}

$id = null;
$name = null;
$birthday = null;
$cpf = null;
$htmlPhones = null;

$obj = new AuthorAddControl();
$templatePhone = $obj->templatePhone();

if( !empty( $_REQUEST ) && empty( $_REQUEST['id'] ) ) {

	$objAuthor = $obj->addAuthor($_REQUEST, $debug = false);
}
else if( !empty( $_REQUEST['id'] ) ) {

	$objAuthor = $obj->loadDataAuthors($_REQUEST, $debug = false);

	$id = $_REQUEST['id'];
	$name = $objAuthor->getName();
	$birthday = Help::formatDateTo( $objAuthor->getBirthday() );
	$cpf = $objAuthor->getCpf();
	$htmlPhones = $objAuthor->getHtmlPhone();
}

include_once('../view/author_add.php');
?>