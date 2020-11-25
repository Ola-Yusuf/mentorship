<?php 
    class Db_connect {
        private $production = true;
        private $server_name = "localhost";
        private $db_username = "root";
        private $db_password = "";
        protected $db_name = "mentorship";

        public $conn;

        // Db connection
        public function __construct(){
            if($production){
                $this->server_name = getenv('server_name');
                $this->db_username = getenv('db_username');
                $this->db_password = getenv('db_password');
                $this->db_name = getenv('db_name');
            }

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


