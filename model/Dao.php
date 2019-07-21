<?php
class Dao extends _autoload {

	private $arrayFieldsTable;
	private $arrayPrimaryKeyTable;
	private $con;

	function __construct() {

		if(!$this->con) {
			$this->con = Connection::getInstance();
		}
		$this->arrayFieldsTable = array();
		$this->arrayFieldsTableNoPK = array();
		$this->arrayPrimaryKeyTable = array();
		$this->getFieldsTablePrepare();
	}


	public function setInstance($instanceName) {

		$this->con = Connection::getInstance($instanceName);
	}


	public function getInstance() {

		return $this->con;
	}


	private function getFieldsTable($debug = false) {

		try {
			$sql = "SHOW COLUMNS FROM ".$this->getTableName();
			$stmt = $this->con->prepare($sql);
			// EXECUTE
			$isNotError = $stmt->execute();

			// DEBUG
			$this->setDebug($stmt, $debug);

			// CHECK IF HAS ERROR
			if($isNotError) {

				$result = $stmt->fetchAll();
				return $result;
			}
			else {
				throw new Exception ("Error! Get Fields Table! ".get_parent_class(get_class($this)));
			}
		}
		catch (Exception $e) {
			throw new Exception ($e->getMessage());
		}
	}


	public function getFieldsTablePrepare($debug = false) {

		$arrayFields = $this->getFieldsTable($debug);

		foreach ($arrayFields as $field) {
			
			if($field['Key'] == 'PRI') {
				array_push($this->arrayPrimaryKeyTable, $field['Field']);
			}
			else {
				array_push($this->arrayFieldsTableNoPK, $field['Field']);
			}

			array_push($this->arrayFieldsTable, $field['Field']);
		}
	}


	public function prepareField($field) {

		$field = mb_strtolower($field);
		$arrayAux = explode("_", $field);
		$arrayAux = array_map(function($arg) { return ucfirst($arg);}, $arrayAux);
		$field = implode("", $arrayAux);
		
		return $field;
	}

	
	private function getWhereDefault() {

		// WHERE
		$where = "";
		foreach ($this->arrayPrimaryKeyTable as $pk) {
			
			$field = lcfirst($this->prepareField($pk));

			// Verifica se a PK está vazia.
			if(!isset($this->$field))
				throw new Exception ("Error! Primary Key empty!");

			$where .= $pk ." = ? AND ";
		}
		$where = substr(trim($where), 0, -4);

		return $where;
	}


	private function setDebug($stmt, $debug = false) {

		if($debug) {
			echo "<div style='color:red'><b>".$stmt->errorInfo()[2]."</b></div>";
			$result = $stmt->debugDumpParams();
		}
	}


	private function getArrayValues($pk = false, $onlyPK = false, $debug = false) {

		$arrayValues = array();

		if(!$onlyPK) {
			// VALUES	
			foreach ($this->arrayFieldsTableNoPK as $key => $fieldName) {
				
				$fieldNameAux = lcfirst($this->prepareField($fieldName));
				// Check if the field has defined (set).
				if(isset($this->$fieldNameAux)) {
					$function = 'get'.$this->prepareField($fieldName);
					$value = $this->$function();
					array_push($arrayValues, $value);
				}
			}
		}

		if($pk || $onlyPK) {
			// PK - PRIMARY KEY
			foreach ($this->arrayPrimaryKeyTable as $key => $pk) {

				$function = 'get'.$this->prepareField($pk);
				$value = $this->$function();
				array_push($arrayValues, $value);
			}
		}

		// DEBUG
		if($debug) {
			var_dump($arrayValues);
		}

		return $arrayValues;
	}


	public function selectAll($debug = false) {
		
		try {

			// SQL
			$sql = "SELECT * FROM ".$this->getTableName();
			$stmt = $this->con->prepare($sql);

			// EXECUTE
			$isNotError = $stmt->execute();

			// DEBUG
			$this->setDebug($stmt, $debug);

			// CHECK IF HAS ERROR
			if($isNotError) {

				// IF NOT ERROR, BUT NUMBER OF REGISTER EQUAL ZERO, RETURN FALSE.
				if(!$stmt->rowCount()){
					return false;
				}

				// IF NUMBER OF REGISTER BIGGER THAN ZERO, CREATE ARRAY OF OBJECTS.
				$classChild = static::class;
				$arrayObj = array();
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

					$obj = new $classChild();
					foreach ($row as $key => $field) {

						$function = 'set'.$this->prepareField($key);
						$obj->$function($field);
					}	
					array_push($arrayObj, $obj);		
				}

				return $arrayObj;
			}
			else {
				throw new Exception ("Error! ".get_parent_class(get_class($this))." - Could not return all data!");
			}
		}
		catch (Exception $e) {
			throw new Exception ($e->getMessage());
		}
	}

	public function selectId($debug = false) {
		
		try {
			// WHERE
			$where = $this->getWhereDefault();

			// SQL
			$sql = "SELECT * FROM ". $this->getTableName() ." WHERE ". $where;
			$stmt = $this->con->prepare($sql);

			// VALUES
			$arrayValues = $this->getArrayValues(false, true, false);

			// EXECUTE
			$isNotError = $stmt->execute($arrayValues);

			// DEBUG
			$this->setDebug($stmt, $debug);

			// CHECK IF HAS ERROR
			if($isNotError) {

				// IF NOT ERROR, BUT NUMBER OF REGISTER EQUAL ZERO, RETURN FALSE.
				if(!$stmt->rowCount()){
					return false;
				}

				// IF NUMBER OF REGISTER BIGGER THAN ZERO, DEFINE VALUES FOR OBJECT.
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

					foreach ($row as $key => $field) {

						$function = 'set'.$this->prepareField($key);
						$this->$function($field);
					}
				}

				return true;
			}
			else {
				throw new Exception ("Error! ".get_parent_class(get_class($this))." - Could not return data!");
			}
		}
		catch (Exception $e) {
			throw new Exception ($e->getMessage());
		}
	}


	public function insert($debug = false) {

		try {
			// FIELDS
			$fields = "";
			foreach ($this->arrayFieldsTableNoPK as $fieldName) {
				
				$fieldNameAux = lcfirst($this->prepareField($fieldName));
				// Check if the field has defined (set).
				if(isset($this->$fieldNameAux)) {
					
					$fields .= $fieldName . ", ";
				}
			}
			$fields = substr(trim($fields), 0, -1);

			// PARAMS
			$params = "";
			foreach ($this->arrayFieldsTableNoPK as $fieldName) {

				$fieldNameAux = lcfirst($this->prepareField($fieldName));
				// Check if the field has defined (set).
				if(isset($this->$fieldNameAux)) {
					$params .= "?, ";
				}
			}
			$params = substr(trim($params), 0, -1);

			// SQL
			$sql = "INSERT INTO ". $this->getTableName() ." (". $fields .") VALUES (". $params .")";
			$stmt = $this->con->prepare($sql);

			// VALUES
			$arrayValues = $this->getArrayValues(false, false, false);

			// EXECUTE
			$isNotError = $stmt->execute($arrayValues);

			// DEBUG
			$this->setDebug($stmt, $debug);

			// CHECK IF HAS ERROR
			if($isNotError) {
				return $this->con->lastInsertId();
			}
			else {
				throw new Exception ("Error! ".get_parent_class(get_class($this))." - Could not insert data!");
			}
		}
		catch (Exception $e) {
			throw new Exception ($e->getMessage());
		}
	}


	public function update($debug = false) {

		try {
			// WHERE
			$where = $this->getWhereDefault();

			// FIELDS
			$fields = "";
			foreach ($this->arrayFieldsTableNoPK as $fieldName) {
				
				$fieldNameAux = lcfirst($this->prepareField($fieldName));
				// Check if the field has defined (set).
				if(isset($this->$fieldNameAux)) {
					
					$fields .= $fieldName . " = ?, ";
				}
			}
			$fields = substr(trim($fields), 0, -1);

			// SQL
			$sql = "UPDATE ". $this->getTableName() ." SET ". $fields ." WHERE ". $where;
			$stmt = $this->con->prepare($sql);

			// VALUES
			$arrayValues = $this->getArrayValues(true, false, false);

			// EXECUTE
			$isNotError = $stmt->execute($arrayValues);

			// DEBUG
			$this->setDebug($stmt, $debug);

			// CHECK IF HAS ERROR
			if($isNotError) {
				return $stmt->rowCount();
			}
			else {
				throw new Exception ("Error! ".get_parent_class(get_class($this))." - Could not update data!");
			}
		}
		catch (Exception $e) {
			throw new Exception ($e->getMessage());
		}
	}


	public function delete($debug = false) {

		try {
			// WHERE
			$where = $this->getWhereDefault();
			
			// SQL
			$sql = "DELETE FROM ". $this->getTableName() ." WHERE ".$where;
			$stmt = $this->con->prepare($sql);

			// PK - PRIMARY KEY
			$arrayValues = $this->getArrayValues(false, true, false);

			// EXECUTE
			$isNotError = $stmt->execute($arrayValues);

			// DEBUG
			$this->setDebug($stmt, $debug);

			// CHECK IF HAS ERROR
			if($isNotError) {
				return $stmt->rowCount();
			}
			else {
				throw new Exception ("Error! ".get_parent_class(get_class($this))." - Could not delete data!");
			}	
		}
		catch (Exception $e) {
			throw new Exception ($e->getMessage());
		}
	}

	
}
?>