<?php 
    class Db_connect {
        
        private $server_name =null;
        private $db_username =null; 
        private $db_password =null; 
        protected $db_name =null; 

        public $conn;

        // Db connection
        public function __construct(){
            $this->server_name = getenv("db_server") != null ? getenv("db_server"):'localhost' ;
            $this->db_username = getenv("db_username") != null ? getenv("db_username"):'root' ;
            $this->db_password = getenv("db_password") != null ? getenv("db_password"):'' ;
            $this->db_name = getenv("db_name") != null ? getenv("db_name"):'mentorship' ;
    
            $this->conn = null;
            try {
                 $this->conn = new PDO("mysql:host=$this->server_name", $this->db_username, $this->db_password);
                 $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }catch(PDOException $e) {
                echo  "<br>" . $e->getMessage();
              }
        }

        public function selectDatabase(){
            $dbname = "`".str_replace("`","``",$this->db_name)."`";
             $this->conn->query("use $dbname");
            //  return $this->conn;
        }

        public function closeDbConnection(){
             return $this->conn = null;
        }

    }  
?>


