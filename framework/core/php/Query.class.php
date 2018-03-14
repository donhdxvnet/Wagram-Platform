<?php

	/**
	 * Query builder: Construit les requêtes Insert, Update
	 */
	class Query
	{
		private $table = NULL;
		private $fieldList = array();
		private $valueList = array();
		private $itemList = array();
		private $insert = NULL;
		private $update = NULL;
		private $delete = NULL;
		private $where = NULL;

		/**
		 * Constructeur par défault
		 * @param String $table Une table dans la base de données
		 * @return Query
		 */
		function __construct($table){
			$this->table = $table;
		}

		/**
		 * Ajoute un champ
		 * @param String $data 
		 * @return void
		 */
		private function addField($data){
			$this->fieldList[] = $data;
		}

		/**
		 * Ajoute une valeur
		 * @param String $data 
		 * @return void
		 */
		private function addValue($data){
			$this->valueList[] = $data;
		}

		/**
		 * Ajoute un élément dans une requête
		 * @param String $field 
		 * @param String $value 
		 * @param Boolean $filter 
		 * @return void
		 */
		public function addItem($field, $value, $filter, $type = "php"){
			if ($filter){
				$this->addField(trim($field));
				if ($type == "sql"){
					$this->addValue(trim($value));
					$this->itemList[] = trim($field)."=".trim($value);
				}else{
					$this->addValue("'".trim($value)."'");
					$this->itemList[] = trim($field)."='".trim($value)."'";
				}
			}
		}

		/**
		 * Ajoute la condition Where
		 * @param String $data 
		 * @return void
		 */
		public function addWhere($data){
			$this->where = $data;
		}

		/**
		 * Construit la requête Insert
		 * @return String
		 */
		public function getInsert(){
			$fieldString = implode(",", $this->fieldList);
			$valueString = implode(",", $this->valueList);
			$this->insert = "INSERT INTO ".$this->table."(".$fieldString.") VALUES(".$valueString.")";
			return $this->insert;
		}

		 /**
		 * Construit la requête Update
		 * @return String
		 */
		public function getUpdate(){
			$itemString = implode(",", $this->itemList);
			$this->update = "UPDATE ".$this->table." SET ".$itemString." WHERE ".$this->where;
			return $this->update;
		}
	}

?>