<?php   

    class DBResultWithCondition 
    {

        public function __construct($condition)
        {
            $this->condition = $condition;

            return $this->all($condition);
        }

        public function all($args)
        {
            $this->db->query(
                "SELECT * FROM $this->table $args"
            );
            
            return $this->db->resultSet();
        }
    }