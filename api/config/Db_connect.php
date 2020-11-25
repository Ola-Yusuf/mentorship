<?php 
    class Db_connect {
        private $production = true;
        private $server_name = "localhost";
        private $db_username = "root";
        private $db_password = "";
        protected $db_name = "mentorship";
        protected $url = null;

        public $conn;

        // Db connection
        public function __construct(){
            if($production){
                // $this->url = parse_url(getenv("CLEARDB_DATABASE_URL"));
                // $this->server_name = $this->url["host"];
                // $this->db_username = $this->url["user"];
                // $this->db_password = $this->url["pass"];
                // $this->db_name = substr($this->url["path"], 1);

                $this->server_name = getenv("server");
                $this->db_username = getenv("username");
                $this->db_password = getenv("password");
                $this->db_name = getenv("name");
            }
            echo $this->url;
            echo $this->server_name ;
            echo $this->db_username ;
            echo $this->db_password ;
            echo $this->db_name ;

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


