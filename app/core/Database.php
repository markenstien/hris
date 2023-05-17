<?php

    class Database{


        protected $dbhost = DBHOST;
        protected $dbuser = DBUSER;
        protected $dbpass = DBPASS;
        protected $dbname = DBNAME;


        protected $dbh;//database handler
        protected $stmt; //holds the stamement;
        protected $errors = [];//holds the database errors;


        protected static $instance = null;

        public function __construct(){
            //create dsn
            $dsn = 'mysql:host='.$this->dbhost.';dbname='.$this->dbname;
            //set database options

            $options = [
                PDO::ATTR_PERSISTENT => true , 
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ];

            //create PDO INSTANCE
            try{
                $this->dbh = new PDO($dsn , $this->dbuser , $this->dbpass , $options);
            }catch(PDOException $e){
                $this->errors = $e->getMessage();

                die('Error connecting via database'.$this->errors);
            }
        }


        public static function getInstance()
        {
            if(self::$instance == null) {
                self::$instance = new Database();
            }

            return self::$instance;
        }

        //create query
        public function query($sql){
            $this->stmt = $this->dbh->prepare($sql);
        }
        //Bind Values
        public function bind($param , $value , $type = null){
            if(is_null($type)) {
                switch(true){
                    case is_int($value) :
                        $type = PDO::PARAM_INT;
                        break;
                    case is_bool($value) :
                        $type = PDO::PARAM_BOOL;
                        break;
                    case is_null($value) :
                        $type = PDO::PARAM_NULL;
                        break;
                    default:
                        $type = PDO::PARAM_INT;
                }
            }
        }
        //execute statement
        public function execute(){
            return $this->stmt->execute();
        }
        
        public function lastInsertId()
        {
            return $this->dbh->lastInsertId();
        }

        public function insert()
        {
            $this->stmt->execute();

            return $this->lastInsertId();
            
        }

        public function update()
        {
            $this->stmt->execute();
            return $this->stmt->rowCount();
        }

        public function pickColumn($columns = [] , $table , $params , $returnType = 'single')
        {
            $sql = "SELECT ".implode(',',$columns)." from $table $params";

            $this->stmt = $this->dbh->prepare($sql);

            $this->execute();

            if($returnType == 'single') {
                return $this->single();
            }else{
                return $this->resultSet();
            }
        }

        public function resultSet($customObject = null)
        {
         $this->execute();

          if(!is_null($customObject)) {
            return $this->stmt->fetchAll(PDO::FETCH_CLASS, $customObject);
          }
          return $this->stmt->fetchAll(PDO::FETCH_OBJ);
        }
        //get result as single
        public function single($myObject = null){
            $this->execute();

            if($myObject != null){
                return $this->stmt->fetchObject($myObject);
            }
            return $this->stmt->fetch(PDO::FETCH_OBJ);
        }

        public function total_rows()
        {
            return $this->stmt->rowCount();
        }
        
        public function multiple($table_name , $fields = array() , $value)
        {
            
        }

        public function errors()
        {
            return $this->errors;
        }
    }