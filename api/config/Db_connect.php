<?php 
    class Db_connect {
        private $production = true;
        protected $db_url = null;
        private $server_name =null;
        private $db_username =null; 
        private $db_password =null; 
        protected $db_name =null; 

        public $conn;

        // Db connection
        public function __construct(){
            $this->server_name = getenv("server");
            $this->db_username = getenv("username");
            $this->db_password = getenv("password");
            $this->db_name = getenv("name");

            echo $this->server_name;
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


