<?php

	class DatabaseHelper
	{
		public function __construct($databaseInstance) {

			$this->db = $databaseInstance;
		}

		public function insert($tableName , $fieldsAndValues)
		{
			$fields = array_keys($fieldsAndValues);

			$values = array_values($fieldsAndValues);

			$cleansedValues = [] ;
			$retunData = [];

			foreach($values as $key => $val) {

				$cleansedValues[] = str_escape($val , FILTER_SANITIZE_STRING);

			}

			foreach($fields as $key => $field) {

				$retunData[$field] = $cleansedValues[$key]; 
			}


			$sql = "INSERT INTO $tableName(".implode(",", $fields).")
				VALUES('".implode("','", $cleansedValues)."')";
			
			$this->db->query($sql);

			try{
				return 
					$this->db->insert();
					
			}catch(Exception $e) {
				die($e->getMessage());
				Debugger::log($e->getMessage());
				return false;
			}
		}

		public function update($tableName , $fieldsAndValues , $where = null)
		{
			$fields = array_keys($fieldsAndValues);

			$values = array_values($fieldsAndValues);

			$cleansedValues = [] ;

			$retunData = [];

			foreach($values as $key => $val) {

				$cleansedValues[] = str_escape($val , FILTER_SANITIZE_STRING);

			}

			foreach($fields as $key => $field) {

				$retunData[$field] = $cleansedValues[$key]; 
			}

			$sql = " UPDATE $tableName set ";

			$count = 0;
			
			foreach($fields as $key => $field) {

				if($count < $key) {
					$sql .=',';
					$count++;
				}

				$sql .= " {$field} = '{$cleansedValues[$key]}' ";
			}

			if($where != null) {
				$sql .= " WHERE $where";
			}

			$this->db->query($sql);

			try{

				$this->db->execute();

				return true;

			}catch(Exception $e) {


				die($e->getMessage());

				Debugger::log($e->getMessage());

				return false;
			}
		}

		public function delete($tableName , $where)
		{
			$sql = "DELETE FROM $tableName where $where";

			$this->db->query($sql);

			try{

				$this->db->execute();
				return true;
			}catch(Exception $e) {

				die($e->getMessage());
				return false;
			}
		}

		private final function select($tableName , $fields = '*' , $condition = null, $orderby= null , $limit = null , $offset = null)
		{
			if(is_array($fields))
			{
				$sql = "SELECT  ".implode(',',$fields)." from $tableName";
			}else{
				$sql = "SELECT $fields from $tableName";
			}

			if(! is_null($condition)) {

				$sql .= " WHERE $condition ";
			}

			if(!is_null($orderby)) {
				$sql .= " ORDER BY $orderby";
			}

			if(!is_null($limit) && is_null($offset)) {
				$sql .= " LIMIT $limit";
			}

			if(!is_null($offset) && is_null($limit))
			{
				$sql .= " offset $offset";
			}

			if(!is_null($offset) && !is_null($limit))
			{
				$sql .= " LIMIT $offset , $limit";
			}

			return $sql;
		}

		public function resultSet($tableName , $fields = '*' , $condition = null, $orderby= null , $limit = null , $offset = null)
		{
			$sql = $this->select($tableName , $fields , $condition , $orderby , $limit , $offset);

			try{
				$this->db->query($sql);

				if(isset($this->objectName)) {
					return $this->db->resultSet($this->objectName);
				}
				
				return $this->db->resultSet();

			}catch(Exception $e) {
				die($e->getMessage());
				Debugger::log($e->getMessage());
				return false;
			}
		}


		public function single($tableName , $fields = '*' , $condition = null, $orderby = null)
		{
			$sql = $this->select($tableName , $fields , $condition, $orderby);

			try{
				$this->db->query($sql);

				if(isset($this->objectName)) {
					return $this->db->single($this->objectName);
				}
				return $this->db->single();

			}catch(Exception $e) {
				die($e->getMessage());
				Debugger::log($e->getMessage());
				return false;
			}	
		}


		public function loadToObject($objectName)
		{
			$this->objectName = $objectName;
		}
	}