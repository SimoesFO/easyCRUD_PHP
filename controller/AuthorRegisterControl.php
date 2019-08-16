<?php
include_once ("../inc/_autoload.php");
//var_dump($_POST);
//var_dump($_REQUEST);

class AuthorRegisterControl {

	public $name = null;
	public $birthday = null;
	public $cpf = null;
	public $listPhones = null;
	public $listOperator = null;
	public $objCF = null;

	public function __construct() {
		
		$this->objCF = new CommonFunctions();		
	}

	public function addAuthor($request = null, $debug = false) {
		
		try {

			$this->name = $request['inputName'];
			$this->birthday = $request['inputBirthday'];
			$this->cpf = $request['inputCPF'];
			$this->listPhones = $request['hidePhones'];
			$this->listOperator = $request['hideOperator'];
			
			$objAuthor = new AuthorsControl();
			$objAuthor->setName($this->name);
			$objAuthor->setBirthday($this->birthday);
			$objAuthor->setCpf($this->cpf);

			Connection::beginTransaction();
				$idAuthor = $objAuthor->insert($debug);
				$this->insertPhones($idAuthor, $debug);
			Connection::commit();
		}
		catch(Exception $e) {
			Connection::rollBack();
			echo $e->getMessage();
		}
	}

	private function insertPhones($idAuthor, $debug = false) {

	    try {

	        $arrayPhones = explode(";", mb_substr($this->listPhones, 0, -1));
	        $arrayOperadora = explode(";", mb_substr($this->listOperator, 0, -1));

	        foreach ($arrayPhones as $key => $phone) {

	            // Remover especial characters.
	            $phone = $this->objCF->preparePhone($phone, $clear = true, $ddi = false);

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
}

$name = null;
$birthday = null;
$cpf = null;
$listPhones = null;
$listOperator = null;

if(count($_REQUEST)) {	
	$obj = new AuthorRegisterControl();
	$obj->addAuthor($_REQUEST, $debug = false);

	$name = $obj->name;
	$birthday = $obj->birthday;
	$cpf = $obj->cpf;
	$listPhones = $obj->listPhones;
	$listOperator = $obj->listOperator;
}

include_once('../view/author_add.php');
?>