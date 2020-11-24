<?php
require_once './config/Db_connect.php';
    class Mentor extends Db_connect{

        // Table
        private $db_table = "mentor";

        // Columns
        public $id;
        public $mentee_id;
        public $mentor_name;
        public $mentor_email;
        public $mentor_password;
        public $created;

        const PASSWORD_DEFAULT = "MentorshipRecord";

        // Db connection
        public function __construct(){
          parent::__construct();
          $this->selectDatabase();
        }

        // CREATE a Mentor
        public function createMentor(){

            $sqlQuery = "INSERT INTO
                        ". $this->db_table ."
                    SET
                        mentor_name = :mentor_name, 
                        mentor_email = :mentor_email, 
                        mentor_password = :mentor_password, 
                        mentor_created = :mentor_created";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            // sanitize
            $this->mentor_name=htmlspecialchars(strip_tags($this->mentor_name));
            $this->mentor_email=htmlspecialchars(strip_tags($this->mentor_email));
            $this->mentor_password=htmlspecialchars(strip_tags($this->mentor_password));
            $this->mentor_created=htmlspecialchars(strip_tags($this->mentor_created));

            $hash = password_hash($this->mentor_password, PASSWORD_DEFAULT);
        
            // bind data
            $stmt->bindParam(":mentee_id", $this->mentee_id);
            $stmt->bindParam(":mentor_name", $this->mentor_name);
            $stmt->bindParam(":mentor_email", $this->mentor_email);
            $stmt->bindParam(":mentor_password", $hash);
            $stmt->bindParam(":mentor_created", $this->mentor_created);
        
            if($stmt->execute()){
              $this->closeDbConnection();
               return true;
            }
            $this->closeDbConnection();

            return false;
        }

        // GET a Mentor data
        public function getSingleMentor(){
            $sqlQuery = "SELECT
                        id, mentor_name, mentor_email, mentor_created
                      FROM
                        ". $this->db_table ."
                    WHERE 
                       id = ?
                    LIMIT 0,1";

            $stmt = $this->conn->prepare($sqlQuery);

            $stmt->bindParam(1, $this->id);

            $stmt->execute();

            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $this->mentor_name = $dataRow['mentor_name'];
            $this->mentor_email = $dataRow['mentor_email'];
            // $this->mentor_password = $dataRow['mentor_password'];
            $this->mentor_created = $dataRow['mentor_created'];
        } 
        
        // GET Mentors of a mentee
        public function getMentorsOfMentee(){
            $sqlQuery = "SELECT
                        mentee_id, mentor_id, mentor_name
                      FROM
                        ". $this->db_table ."
                    LEFT JOIN mentees_mentor 
                    ON mentees_mentor.mentor_id = mentor.id 
                    WHERE mentee_id = ? ";

            $stmt = $this->conn->prepare($sqlQuery);

            $stmt->bindParam(1, $this->mentee_id);
            
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } 

    }
?>

