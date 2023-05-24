<?php 	

	function db_get_user($userId)
	{
		$db = Database::getInstance();

		$tableUser  = DB_PREFIX.'users';
		$tablePersonal  = DB_PREFIX.'personal';

		$db->query(
			"SELECT user.* , personal.* , user.id as id 
				FROM $tableUser as user 

				LEFT JOIN $tablePersonal as personal
				ON user.id = personal.user_id

				WHERE user.id = {$userId} "
		);

		return $db->single();
	}


	function db_single($tableName , $fields = '*' , $condition = null, $orderby = null)
	{
		$db = Database::getInstance();


		if(is_array($condition))
			$condition = db_condition_equal($condition);

		$sql = db_query($tableName , $fields , $condition, $orderby);

		try{
			$db->query($sql);
			return $db->single();
		}catch(Exception $e)
		{
			return false;
		}	
	}


	function db_query($tableName , $fields = '*' , 
		$condition = null, $orderby= null , 
		$limit = null , $offset = null)
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


	function db_condition_equal($params , $defaultCondition = '=')
	{
		$WHERE = '';
		$counter = 0;

		$errors = [];


		if( !is_array($params) )
			return $params;
		/*
		*convert-where default concatinator is and
		*add concat on param values to use it
		*/
		$condition_operation_concatinator = 'AND';

		foreach($params as $key => $param_value) 
		{	
			if( $counter > 0)
				$WHERE .= " {$condition_operation_concatinator} "; //add space
			
			if($key == 'GROUP_CONDITION') {
				$WHERE .= '('.$this->conditionConvert($param_value) . ')';
				$counter++;
				continue;
			}
			/*should have a condition*/
			if(is_array($param_value) && isset($param_value['condition']) ) 
			{
				$condition_operation_concatinator = $param_value['concatinator'] ?? $condition_operation_concatinator;

				//check for what condition operation
				$condition = $param_value['condition'];
				$condition_values = $param_value['value'] ?? '';
				$isField = isset($param_value['is_field']) ? true : false;

				if(is_numeric($key) && isEqual($condition, $this->_dbConditionWrap)) {
					$WHERE .= "({$param_value['value']})";

					if(isset($param_value['concatinator'])) {
						$WHERE .= " {$param_value['concatinator']} ";
					}
					continue;
				}

				if(isEqual($condition , 'not null'))
				{
					$WHERE .= "{$key} IS NOT NULL ";
				}

				if( isEqual($condition , ['between' , 'not between']))
				{
					if( !is_array($condition_values) )
						return _error(["Invalid query" , $params]);
					if( count($condition_values) < 2 )
						return _error("Incorrect between condition");

					$condition = strtoupper($condition);

					list($valueA, $valueB) = $condition_values;
					if($isField) {
						$WHERE .= " {$key} {$condition} {$valueA} AND {$valueB}";
					}else{
						$WHERE .= " {$key} {$condition} '{$valueA}' AND '{$valueB}'";
					}
				}

				if( isEqual($condition , ['equal' , 'not equal' , 'in' , 'not in']) )
				{
					$conditionKeySign = '=';

					if( isEqual($condition , 'not equal') )
						$conditionKeySign = '!=';

					if( isEqual( $condition , 'in'))
						$conditionKeySign = ' IN ';

					if( isEqual( $condition , 'not in'))
						$conditionKeySign = ' NOT IN ';

					if( is_array($condition_values) ){
						if($isField) {
							$WHERE .= "{$key} $conditionKeySign (".implode(",",$condition_values).") ";
						}else{
							$WHERE .= "{$key} $conditionKeySign ('".implode("','",$condition_values)."') ";
						}
					}else{
						$WHERE .= "{$key} {$conditionKeySign} '{$condition_values}' ";
					}
				}

				/*
				*if using like
				*add '%' on value 
				*/
				if(isEqual($condition , ['>' , '>=' , '<' , '<=' , '=', 'like']) )
				{
					if($isField){
						$WHERE .= "{$key} {$condition} {$condition_values}";
					}else{
						$WHERE .= "{$key} {$condition} '{$condition_values}'";
					}
				}
				$counter++;

				continue;
			}

			if( isEqual($defaultCondition , 'like')) 
				$WHERE .= " $key {$defaultCondition} '%{$param_value}%'";

			if( isEqual($defaultCondition , '=')) 
			{
				$isNotCondition = substr( $param_value , 0 ,1); //get exlamation
				$isNotCondition = stripos($isNotCondition , '!');

				if( $isNotCondition === FALSE )
				{
					$WHERE .= " $key = '{$param_value}'";
				}else{
					
					$cleanRow = substr($param_value , 1);
					$WHERE .= " $key != '{$cleanRow}'";
				}
			}

			$counter++;
		}
		return $WHERE;
	}