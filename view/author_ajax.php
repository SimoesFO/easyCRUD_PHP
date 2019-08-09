<?php
include_once ("../inc/_autoload.php");

class AuthorAjax extends _autoload {

    public function registerUser($debug = false) {
        try {
            $objAuthor = new AuthorsControl();
            $objAuthor->setName( $_REQUEST['inputName'] );
            $objAuthor->setBirthday( $_REQUEST['inputBirthday'] );
            $objAuthor->setCpf( $_REQUEST['inputCPF'] );

            Connection::beginTransaction();
            $idAuthor = $objAuthor->insert();
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
            $arrayPhones = explode(";", mb_substr($_REQUEST['hidePhones'], -1));
            $arrayOperadora = explode(";", mb_substr($_REQUEST['hideOperadora'], -1));

            foreach ($arrayPhones as $key => $phone) {
                $objAuthorPhone = new AuthorPhonesControl();
                $objAuthorPhone->setNumber($phone);
                $objAuthorPhone->setOperator($arrayOperadora[$key]);
                $objAuthorPhone->setAuthorsId($idAuthor);
                $objAuthorPhone->insert();
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
        $objAjax->registerUser();
        break;
    
    default:
        # code...
        break;
}

?>