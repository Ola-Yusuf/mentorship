<?php
require_once './config/Db_connect.php';
    class Mentee extends Db_connect{

        // Table
        private $db_table = "mentee";
        Private $db_relation_table = "mentees_mentor";

        // Columns
        public $id;
        public $mentee_name;
        public $mentee_email;
        public $mentee_password;
        public $created;

        //relationship column
        public $mentee_id;
        public $mentor_id;

        // const PASSWORD_DEFAULT = "MentorshipRecord";

        // Db connection
        public function __construct(){
          parent::__construct();
          $this->selectDatabase();
        }

        // CREATE a new mentee
        public function createMentee(){

            try {
                //Begin the transaction.
                $this->conn->beginTransaction();

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

                $stmt->execute();
                $this->mentee_id = $this->conn->lastInsertId(); //last insertion id

                //get mentors id
                $sqlQueryMentor = "SELECT id FROM mentor";
                $stmtMentor = $this->conn->prepare($sqlQueryMentor);
                $stmtMentor ->execute();
                $ids = $stmtMentor->fetchAll(PDO::FETCH_COLUMN);
                $this->mentor_id = array_rand($ids);
                while($this->mentor_id == 0){
                    $this->mentor_id = array_rand($ids); 
                }

                $sqlQueryRelationship = "INSERT INTO
                            ". $this->db_relation_table ."
                                SET
                                mentee_id = :mentee_id, 
                                mentor_id = :mentor_id";
            
                $stmtRelationship = $this->conn->prepare($sqlQueryRelationship);

                // bind data
                $stmtRelationship->bindParam(":mentee_id", $this->mentee_id);
                $stmtRelationship->bindParam(":mentor_id", $this->mentor_id);
                $stmtRelationship->execute();

                //Commit the transaction.
                $this->conn->commit();
                $this->closeDbConnection();
                $response['mentee_id'] = $this->mentee_id;
                $response['status'] = true;
                return $response;
            } catch (Exception $e) {
                //Rollback the transaction.
                $this->conn->rollBack();
                $response['status'] = false;
                $response['message'] = $e->getMessage();
                return $response;
            }
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

