<?php 
    class CreateMentorTable extends Db_connect {
       
      public function __construct(){
            parent::__construct();
            $this->selectDatabase();
             //create mentor table
            $query =  "CREATE TABLE IF NOT EXISTS `mentor` (
                        `id` int(11) NOT NULL AUTO_INCREMENT,
                        `mentor_name` varchar(255) NOT NULL,
                        `mentor_email` varchar(255) NOT NULL,
                        `mentor_phone` varchar(20) NOT NULL,
                        `mentor_created` timestamp NOT NULL,
                        PRIMARY KEY (`id`),
                        UNIQUE KEY email (mentor_email,mentor_phone)
                      )ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19";
            $this->conn->exec($query);
            echo "Mentor table created successfully<br>";
        }

        public function addTestData(){
          parent::__construct();
          $this->selectDatabase();
           //add data to mentor tables
          $query = "INSERT INTO `mentor` (`id`,`mentor_name`, `mentor_email`, `mentor_phone`, `mentor_created`) VALUES 
                    (1,'John Doe', 'johndoe@gmail.com', +2341236759874, '2020-11-24 02:12:30'),
                    (2, 'Smith Fatty', 'smitfatty@yahoo.com', +2345987412367, '2020-11-24 02:12:30'),
                    (3, 'Look Back', 'lookback@gmail.com', +2348741259367, '2020-11-24 02:12:30'),
                    (4, 'Green leaf', 'greenleaf@yahoo.com', 2343675987412, '2020-11-24 02:12:30'),
                    (5, 'Paul Zinc', 'paulzinc@gmail.com', 2348741592367, '2020-11-24 02:12:30')";
          $this->conn->exec($query);
          echo "Test data added to Mentor table successfully <br>";
      }
    }  
?>


