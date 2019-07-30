<?php

class Usuario extends Dao  {

	protected $arrayPostsUsuarios = null;

	function __construct() {

		$this->setTableName('usuario');
		parent::__construct();
	}

	public function loadPostsUsuarios($debug = false) {

		try {

			// SQL
			$sql = "SELECT * FROM posts_usuarios WHERE id_usuario = ?";
			$stmt = $this->con->prepare($sql);

			// EXECUTE
			$isNotError = $stmt->execute([$this->getId()]);

			// DEBUG
			$this->setDebug($stmt, $debug);

			// CHECK IF HAS ERROR
			if($isNotError) {

				// IF NOT ERROR, BUT NUMBER OF REGISTER EQUAL ZERO, RETURN FALSE.
				if(!$stmt->rowCount()){
					return false;
				}

				$this->arrayPostsUsuarios = array();

				// IF NUMBER OF REGISTER BIGGER THAN ZERO, CREATE ARRAY OF OBJECTS.
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

					$obj = new PostsUsuarios();
					foreach ($row as $key => $field) {

						$function = 'set'.$this->prepareField($key);
						$obj->$function($field);
					}	
					array_push($this->arrayPostsUsuarios, $obj);		
				}

				return true;
			}
			else {
				throw new Exception ("Error! ".get_parent_class(get_class($this))." - Could not return all data!");
			}
		}
		catch (Exception $e) {
			throw new Exception ($e->getMessage());
		}
	}

	
}
?>