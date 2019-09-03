<?php
include_once ("../inc/_autoload.php");

class AuthorListControl {

	public function showAuthors( $debug = false ) {
		
		try {

			$objAuthor = new AuthorsControl();
			$arrayAuthors = $objAuthor->selectAll( $debug );

			$html = "";
			foreach ( $arrayAuthors as $key => $author ) {
				
				$htmlPhones = $this->loadPhonesAuthor( $author, $debug );

				$linkEdit = "AuthorAddControl.php?id=". $author->getId();
				//$linkDelete = "AuthorDeleteControl.php?id=". $author->getId();
				
				$html .= "
					<tr>
						<td>". $author->getId() ."</td>
						<td>". $author->getName() ."</td>
						<td>". Help::prepareCpfCnpj( $author->getCpf() ) ."</td>
						<td>". Help::formatDateTo( $author->getBirthday() ) ."</td>
						<td>". $htmlPhones ."</td>
						<td>
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

	public function loadPhonesAuthor( $author, $debug = false ) {

		$htmlPhone = "";
		$arrayPhones = $author->loadPhones( $debug );
		if($arrayPhones) {
			
			$fn = function ($phone) { 
				return  Help::preparePhone( $phone->getNumber() ); 
			};

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