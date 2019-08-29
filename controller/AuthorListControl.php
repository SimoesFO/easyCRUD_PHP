<?php
include_once ("../inc/_autoload.php");

class AuthorListControl {

	public function showAuthors($debug = false) {
		
		try {

			$objAuthor = new AuthorsControl();
			$arrayAuthors = $objAuthor->selectAll($debug);

			$html = "";
			foreach ($arrayAuthors as $key => $author) {
				
				$html .= "
					<tr>
						<td>". $author->getId() ."</td>
						<td>". $author->getName() ."</td>
						<td>". Help::prepareCpfCnpj($author->getCpf()) ."</td>
						<td>". Help::formatDateTo($author->getBirthday()) ."</td>
						<td>(43) 99661-7698 <br/> (43) 8567-4356</td>
						<td></td>
					</tr>";
			}

			return $html;
		}
		catch(Exception $e) {
			echo $e->getMessage();
		}
	}
}

$htmlTable = "";	
$obj = new AuthorListControl();
$htmlTable = $obj->showAuthors($debug = false);

include_once('../view/author_list.php');
?>