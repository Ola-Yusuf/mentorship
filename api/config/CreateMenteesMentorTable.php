<?php 
    class CreateMenteesMentorTable extends Db_connect {
       
      public function __construct(){
            parent::__construct();
            $this->selectDatabase();
             //create mentees_mentor table
            $query =  "CREATE TABLE IF NOT EXISTS `mentees_mentor` (
                              `id` int(11) NOT NULL AUTO_INCREMENT,
                              `mentor_id` int(11) NOT NULL,
                              `mentee_id` int(11) NOT NULL,
                              PRIMARY KEY (`id`),
                              FOREIGN KEY (mentor_id) REFERENCES mentor(id),
                              FOREIGN KEY (mentee_id) REFERENCES mentee(id)
                            )ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19";
            $this->conn->exec($query);
            echo "Mentees Mentor table created successfully<br>";
        }

        public function addTestData(){
          parent::__construct();
          $this->selectDatabase();
            //add data to mentee tables
            try {
          $query = "INSERT INTO `mentees_mentor` (`mentor_id`, `mentee_id`) VALUES 
                      (1, 2),
                      (1, 3),
                      (1, 4),
                      (2, 1),
                      (2, 2),
                      (3, 2),
                      (4, 2),
                      (3, 1),
                      (5, 2),
                      (5, 3)";
          $this->conn->exec($query);
          echo "Test data added to Mentees Mentor table successfully <br>";
        }catch(PDOException $e) {
          echo $query . "<br>" . $e->getMessage();
        }
      }
    }  
?>


