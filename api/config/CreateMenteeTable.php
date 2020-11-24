<?php 
    class CreateMenteeTable extends Db_connect {
       
      public function __construct(){
            parent::__construct();
            $this->selectDatabase();
            //create mentee table
            $query =  "CREATE TABLE IF NOT EXISTS `mentee` (
                              `id` int(11) NOT NULL AUTO_INCREMENT,
                              `mentee_name` varchar(255) NOT NULL,
                              `mentee_email` varchar(255) NOT NULL,
                              `mentee_phone` varchar(20) NOT NULL,
                              `mentee_created` timestamp NOT NULL,
                              PRIMARY KEY (`id`),
                              UNIQUE KEY email (mentee_email,mentee_phone)
                            )ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19";
            $this->conn->exec($query);
            echo "Mentee table created successfully<br>";
        }

      public function addTestData(){
        parent::__construct();
        $this->selectDatabase();
        //add data to mentee tables
        $query = "INSERT INTO `mentee` (`id`,`mentee_name`, `mentee_email`, `mentee_phone`, `mentee_created`) VALUES 
                  (1, 'Saka filler', 'sakafiller@gmail.com', +2349812367574, '2020-11-24 02:12:30'),
                  (2,'Mark Lucky', 'markluck@yahoo.com', +2346759874123, '2020-11-24 02:12:30'),
                  (3, 'Leed Rock', 'leedrock@gmail.com', +2343687412597, '2020-11-24 02:12:30'),
                  (4, 'Water Bird', 'waterbird@yahoo.com', 2347436759812, '2020-11-24 02:12:30'),
                  (5, 'Captain Joe', 'captainjoe@gmail.com', 2341587492367, '2020-11-24 02:12:30')";
        $this->conn->exec($query);
        echo "Test data added to Mentee table successfully <br>";
      }
    }  
?>


