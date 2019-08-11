<?php
include_once ("../inc/_autoload.php");

class AuthorAjax extends _autoload {

    private $objCF =  null; 

    public function registerUser($debug = false) {
        try {
            $this->objCF = new CommonFunctions();

            $objAuthor = new AuthorsControl();
            $objAuthor->setName( $_REQUEST['inputName'] );
            $objAuthor->setBirthday( $_REQUEST['inputBirthday'] );
            $objAuthor->setCpf( $this->objCF->prepareCpfCnpj($_REQUEST['inputCPF'], $clear = true) );

            Connection::beginTransaction();
            $idAuthor = $objAuthor->insert($debug);
            $this->insertPhones($idAuthor, $debug);
            Connection::commit();

            echo "success";
        }
        catch (Exception $e) {
            
            Connection::rollBack();
            echo $e->getMessage();
        }
    }


    public function insertPhones($idAuthor, $debug = false) {

        try {

            $arrayPhones = explode(";", mb_substr($_REQUEST['hidePhones'], 0, -1));
            $arrayOperadora = explode(";", mb_substr($_REQUEST['hideOperadora'], 0, -1));

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

$objAjax = new AuthorAjax();
switch ($_REQUEST['method']) {
    case 'registerUser':
        $objAjax->registerUser($_REQUEST['debug']);
        break;
    
    default:
        # code...
        break;
}

?>