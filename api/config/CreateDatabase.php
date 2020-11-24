<?php 
    class CreateDatabase extends Db_connect {
       
      public function __construct(){
            parent::__construct();

            //drop database if exist
            try {
              $database_name = "`".str_replace("`","``", $this->db_name)."`";
              $query = "DROP DATABASE IF EXISTS $database_name";
              $this->conn->exec($query);
              echo "Database dropped successfully<br>";
            
              //create database
              
              $database_name = "`".str_replace("`","``", $this->db_name)."`";
              $query = "CREATE DATABASE IF NOT EXISTS $database_name";
              $this->conn->exec($query);
              $this->conn->query("use $database_name");
              $this->closeDbConnection();
              echo "Database created successfully<br>";
          }catch(PDOException $e) {
            echo $query . "<br>" . $e->getMessage();
          }
        }
    }  
?>


