<?php
include_once ("../inc/_autoload.php");

class AuthorListControl {

	/************************************************************
	 * Description: Search all existing authors in the database and
	 * genarate the table rows where they will be shown.
	 ************************************************************/
	public function showAuthors( $debug = false ) {
		
		try {

			// Loading Authors.
			$objAuthor = new AuthorsControl();
			$arrayAuthors = $objAuthor->selectAll( $debug );

			$html = "";
			foreach ( $arrayAuthors as $key => $author ) {
				
				// Loading all the phone number.
				$htmlPhones = $this->loadPhonesAuthor( $author, $debug );

				// Link to update register.
				$linkEdit = "AuthorAddControl.php?id=". $author->getId();
				
				// Store all rows with information from authors.
				$html .= "
					<tr>
						<td>". $author->getId() ."</td>
						<td>". $author->getName() ."</td>
						<td>". Help::prepareCpfCnpj( $author->getCpf() ) ."</td>
						<td>". Help::formatDateTo( $author->getBirthday() ) ."</td>
						<td>". $htmlPhones ."</td>
						<td class='td-center'>
							<a href='$linkEdit' class='img-icons'><img src='../resources/img/icons/pencil.svg' /></a>
							<a href='javascript:void(0)' class='img-icons delete-author' data-id='". $author->getId() ."'><img src='../resources/img/icons/trashcan.svg' /></a>
						</td>
					</tr>";
			}

			return $html;
		}
		catch(Exception $e) {
			echo $e->getMessage();
		}
	}


	/************************************************************
	 * Description: Loading all phones from an author.
	 ************************************************************/
	public function loadPhonesAuthor( $author, $debug = false ) {

		$htmlPhone = "";
		$arrayPhones = $author->loadPhones( $debug );
		
		if($arrayPhones) {
			
			// Formats all the phones numbers from an author.
			$fn = function ($phone) { 
				return  Help::preparePhone( $phone->getNumber() ); 
			};

			// Transform the phones into a string separated by line break.
			$htmlPhone = implode( '<br>', array_map( $fn, $arrayPhones ) );
		}

		return $htmlPhone;
	}
}

$htmlTable = "";	
$obj = new AuthorListControl();
$htmlTable = $obj->showAuthors($debug = false);

include_once('../view/author_list.php');
?>