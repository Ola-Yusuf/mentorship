<?php
require_once './config/Db_connect.php';
    class Mentee extends Db_connect{

        // Table
        private $db_table = "mentee";

        // Columns
        public $id;
        public $mentee_name;
        public $mentee_email;
        public $mentee_password;
        public $created;

        const PASSWORD_DEFAULT = "MentorshipRecord";

        // Db connection
        public function __construct(){
          parent::__construct();
          $this->selectDatabase();
        }

        // CREATE a new mentee
        public function createMentee(){

            $sqlQuery = "INSERT INTO
                        ". $this->db_table ."
                    SET
                        mentee_name = :mentee_name, 
                        mentee_email = :mentee_email, 
                        mentee_password = :mentee_password, 
                        mentee_created = :mentee_created";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            // sanitize
            $this->mentee_name=htmlspecialchars(strip_tags($this->mentee_name));
            $this->mentee_email=htmlspecialchars(strip_tags($this->mentee_email));
            $this->mentee_password=htmlspecialchars(strip_tags($this->mentee_password));
            $this->mentee_created=htmlspecialchars(strip_tags($this->mentee_created));

            $hash = password_hash($this->mentee_password, PASSWORD_DEFAULT);
        
            // bind data
            $stmt->bindParam(":mentee_name", $this->mentee_name);
            $stmt->bindParam(":mentee_email", $this->mentee_email);
            $stmt->bindParam(":mentee_password", $hash);
            $stmt->bindParam(":mentee_created", $this->mentee_created);
        
            if($stmt->execute()){
              $this->closeDbConnection();
               return true;
            }
            $this->closeDbConnection();

            return false;
        }

        // GET a mentee data
        public function getSingleMentee(){
            $sqlQuery = "SELECT
                        id, mentee_name, mentee_email, mentee_created
                      FROM
                        ". $this->db_table ."
                    WHERE 
                       id = ?
                    LIMIT 0,1";

            $stmt = $this->conn->prepare($sqlQuery);

            $stmt->bindParam(1, $this->id);

            $stmt->execute();

            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $this->mentee_name = $dataRow['mentee_name'];
            $this->mentee_email = $dataRow['mentee_email'];
            // $this->mentee_password = $dataRow['mentee_password'];
            $this->mentee_created = $dataRow['mentee_created'];
        }  
        
    }
?>

