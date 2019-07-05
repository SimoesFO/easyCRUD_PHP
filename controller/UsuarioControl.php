<?php

class UsuarioControl extends Usuario {
	
	private $obj;

	function __construct() {
		try {
			$this->obj = new Usuario();
			//$this->obj->setNome("Felipe Simões7");
			//$this->obj->setIdade(27);
			//$this->obj->setExemploTeste("TESTE7");
			//$this->obj->setId(20);

			//$this->obj->insert(true);
			//$this->obj->getFieldsTable();
			//$this->obj->getAtrributeClass();
			$array = $this->obj->selectAll();
			
			
			foreach ($array as $key => $value) {
				echo "<br>Nome: ". $value->getNome() ."<br>";
			}
			
			
			//$result = $this->obj->selectId(true);
			///if($result)
			//	echo $this->obj->getExemploTeste();

			//echo $this->obj->insert();

			//$this->obj->update(true);
			// /$result =  $this->obj->delete(true);
			//var_dump($result);

		}
		catch (Exception $e) {
			echo $e->getMessage();
		}
		//echo "Finaliza";
	}
}
?>