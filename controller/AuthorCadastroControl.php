<?php
include_once ("../inc/_autoload.php");
//var_dump($_POST);
//var_dump($_REQUEST);

$name = null;
$birthday = null;
$cpf = null;
$listPhones = null;
$listOperator = null;
$objCF =  null; 

try {

	if(count($_REQUEST)) {	
		$name = $_POST['inputName'];
		$birthday = $_POST['inputBirthday'];
		$cpf = $_POST['inputCPF'];
		$listPhones = $_POST['hidePhones'];
		$listOperator = $_POST['hideOperator'];
		$objCF = new CommonFunctions();

		$objAuthor = new AuthorsControl();
		$objAuthor->setName($name);
		$objAuthor->setBirthday($birthday);
		$objAuthor->setCpf($cpf);
		$idAuthor = $objAuthor->insert($debug = false);

		insertPhones($idAuthor, $debug);
	}
}
catch(Exception $e) {
	echo $e->getMessage();
	die;
}

function insertPhones($idAuthor, $debug = false) {

    try {

        $arrayPhones = explode(";", mb_substr($_POST['hidePhones'], 0, -1));
        $arrayOperadora = explode(";", mb_substr($_POST['hideOperator'], 0, -1));

        foreach ($arrayPhones as $key => $phone) {

            // Remover especial characters.
            $phone = $objCF->preparePhone($phone, $clear = true, $ddi = false);

            $objAuthorPhone = new AuthorPhonesControl();
            $objAuthorPhone->setNumber($phone);
            $objAuthorPhone->setOperator($arrayOperadora[$key]);
            $objAuthorPhone->setAuthorsId($idAuthor);
            $objAuthorPhone->insert($debug);
        }
    }
    catch (Exception $e) {
        throw new Exception ($e->getMessage());
    }           
}

include_once('../view/author_cadastro.php');
?>